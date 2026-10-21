<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

/**
 * Loads the Philippine address reference data (PSGC) from the SQL dumps in public/uploads/sqldata.
 *
 * Only the INSERT statements are executed (the dumps' CREATE/ALTER statements are skipped,
 * because the tables come from migrations), and each file may only insert into its own table.
 */
class ImportAddressData extends Command
{
    use ConfirmableTrait;

    protected $signature = 'address:import
                            {--path= : Folder with the .sql files (default: public/uploads/sqldata)}
                            {--only=* : Import only these tables, e.g. --only=barangays}
                            {--force : Run without confirmation, even in production or when records reference barangays}';

    protected $description = 'Replace regions, provinces, cities, barangays and Mabinay barangays with the SQL data files';

    /** file => table, in dependency order */
    private const FILES = [
        'regions.sql' => 'regions',
        'provinces.sql' => 'provinces',
        'cities.sql' => 'cities',
        'barangays.sql' => 'barangays',
        'mabinay_brgys.sql' => 'mabinay_brgys',
    ];

    /** Records that point at address rows by primary key, which a reload can renumber. */
    private const REFERENCES = [
        'barangays' => [['dafacs', 'add_brgy'], ['dafacs', 'city_mun_head'], ['citizen_i_s', 'add_brgy']],
        'mabinay_brgys' => [['pwds', 'brangay']],
    ];

    public static function defaultPath(): string
    {
        return public_path('uploads/sqldata');
    }

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return self::FAILURE;
        }

        $path = rtrim($this->option('path') ?: self::defaultPath(), '/\\');
        $only = $this->option('only');
        $files = array_filter(self::FILES, fn ($table) => ! $only || in_array($table, $only, true));

        if ($unknown = array_diff($only, self::FILES)) {
            $this->error('Unknown table(s): ' . implode(', ', $unknown) . '. Choose from: ' . implode(', ', self::FILES));

            return self::FAILURE;
        }

        foreach ($files as $file => $table) {
            if (! is_file("$path/$file")) {
                $this->error("Missing file: $path/$file");

                return self::FAILURE;
            }
        }

        if (! $this->option('force') && ! $this->referencesAreSafe(array_values($files))) {
            return self::FAILURE;
        }

        foreach ($files as $file => $table) {
            $started = microtime(true);

            try {
                $statements = $this->insertStatements(file_get_contents("$path/$file"), $table);
            } catch (RuntimeException $e) {
                $this->error("$file: {$e->getMessage()}");

                return self::FAILURE;
            }

            DB::transaction(function () use ($table, $statements) {
                DB::table($table)->delete();
                foreach ($statements as $sql) {
                    DB::unprepared($sql);
                }
            });

            $this->line(sprintf(
                '  <info>%-14s</info> %7s rows  (%.1fs)',
                $table,
                number_format(DB::table($table)->count()),
                microtime(true) - $started
            ));
        }

        $this->info('Address data imported.');

        return self::SUCCESS;
    }

    /**
     * Existing client records store barangays by id. Replacing those rows can point them at a
     * different barangay, so stop unless the user confirms.
     */
    private function referencesAreSafe(array $tables): bool
    {
        $blocking = [];
        foreach ($tables as $table) {
            foreach (self::REFERENCES[$table] ?? [] as [$refTable, $column]) {
                $count = Schema::hasTable($refTable) ? DB::table($refTable)->whereNotNull($column)->count() : 0;
                if ($count > 0) {
                    $blocking[] = "$refTable.$column ($count records) -> $table.id";
                }
            }
        }

        if (! $blocking) {
            return true;
        }

        $this->warn('These records reference address rows by id:');
        foreach ($blocking as $line) {
            $this->line("  - $line");
        }
        $this->warn('If the data files use different ids than the current rows, those records will show the wrong barangay.');

        return $this->confirm('Replace the address data anyway?', false);
    }

    /**
     * Returns the dump's INSERT statements for $table, validated against the table's columns.
     */
    private function insertStatements(string $sql, string $table): array
    {
        $columns = Schema::getColumnListing($table);
        $inserts = [];

        foreach ($this->splitStatements($sql) as $statement) {
            if (! preg_match('/^INSERT\s+INTO\s+`?(\w+)`?\s*\(([^)]*)\)\s*VALUES/i', $statement, $m)) {
                continue; // CREATE, ALTER, SET, COMMIT... are handled by migrations
            }

            if ($m[1] !== $table) {
                throw new RuntimeException("inserts into `{$m[1]}`, expected only `$table`.");
            }

            $fileColumns = array_map(fn ($c) => trim($c, " `\t\r\n"), explode(',', $m[2]));
            if ($missing = array_diff($fileColumns, $columns)) {
                throw new RuntimeException("column(s) " . implode(', ', $missing) . " don't exist in `$table`. Run php artisan migrate first.");
            }

            $inserts[] = $statement;
        }

        if (! $inserts) {
            throw new RuntimeException('no INSERT statements found.');
        }

        return $inserts;
    }

    /**
     * Splits SQL on semicolons outside quoted strings and comments.
     */
    private function splitStatements(string $sql): array
    {
        $statements = [];
        $current = '';
        $quote = null;
        $length = strlen($sql);

        for ($i = 0; $i < $length; $i++) {
            $char = $sql[$i];

            if ($quote !== null) {
                $current .= $char;
                if ($char === '\\' && $i + 1 < $length) {
                    $current .= $sql[++$i];
                } elseif ($char === $quote) {
                    if ($i + 1 < $length && $sql[$i + 1] === $quote) {
                        $current .= $sql[++$i];
                    } else {
                        $quote = null;
                    }
                }
                continue;
            }

            if ($char === '-' && substr($sql, $i, 2) === '--') {
                $end = strpos($sql, "\n", $i);
                $i = $end === false ? $length : $end;
                continue;
            }

            if ($char === '/' && substr($sql, $i, 2) === '/*') {
                $end = strpos($sql, '*/', $i + 2);
                $i = $end === false ? $length : $end + 1;
                continue;
            }

            if ($char === "'" || $char === '"' || $char === '`') {
                $quote = $char;
                $current .= $char;
                continue;
            }

            if ($char === ';') {
                if (trim($current) !== '') {
                    $statements[] = trim($current);
                }
                $current = '';
                continue;
            }

            $current .= $char;
        }

        if (trim($current) !== '') {
            $statements[] = trim($current);
        }

        return $statements;
    }
}
