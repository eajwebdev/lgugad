<?php

namespace App\Services;

use App\Models\Citizen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use InvalidArgumentException;

/** Imports only senior citizen data from a phpMyAdmin dump, never its accounts or DDL. */
class SeniorSqlImporter
{
    private const TABLES = ['citizens', 'citizen_i_s', 'citizen_i_i_s', 'citizen_i_i_i_s', 'citizen_bcks'];

    public function import(string $path, bool $replace = false): array
    {
        if (! is_file($path) || ! is_readable($path)) {
            throw new InvalidArgumentException('The SQL dump cannot be read.');
        }

        $sql = file_get_contents($path);
        if ($sql === false) {
            throw new InvalidArgumentException('The SQL dump cannot be read.');
        }

        $rows = $this->parseInserts($sql);
        if (empty($rows['citizens'])) {
            throw new InvalidArgumentException('The dump contains no senior citizen rows.');
        }
        foreach (self::TABLES as $table) {
            if (! Schema::hasTable($table)) {
                throw new InvalidArgumentException("The {$table} table is missing. Run migrations first.");
            }
        }

        $columns = [];
        foreach (self::TABLES as $table) {
            $columns[$table] = array_flip(Schema::getColumnListing($table));
        }

        return DB::transaction(function () use ($rows, $columns, $replace) {
            $existing = DB::table('citizens')->count();
            if ($existing && ! $replace) {
                throw new InvalidArgumentException('Senior records already exist. Use --replace to replace them.');
            }

            if ($replace) {
                foreach (array_reverse(self::TABLES) as $table) {
                    DB::table($table)->delete();
                }
            }

            $counts = array_fill_keys(self::TABLES, 0);
            $counts['orphan_details_skipped'] = 0;
            $validIds = [];
            foreach ($rows['citizens'] as $row) {
                $record = array_intersect_key($row, $columns['citizens']);
                if (! isset($record['id']) || ! ctype_digit((string) $record['id'])) {
                    throw new InvalidArgumentException('A senior citizen row has an invalid ID.');
                }
                $validIds[(int) $record['id']] = true;
                DB::table('citizens')->insert($record);
                $counts['citizens']++;
            }

            foreach (array_slice(self::TABLES, 1) as $table) {
                foreach ($rows[$table] ?? [] as $row) {
                    $cid = $row['cid'] ?? null;
                    if ($cid === null || ! ctype_digit((string) $cid) || ! isset($validIds[(int) $cid])) {
                        $counts['orphan_details_skipped']++;
                        continue;
                    }
                    $record = array_intersect_key($row, $columns[$table]);
                    $record['cid'] = (int) $cid;
                    DB::table($table)->insert($record);
                    $counts[$table]++;
                }
            }

            foreach (array_keys($validIds) as $id) {
                $citizen = Citizen::findOrFail($id);
                $citizen->personal()->firstOrCreate([]);
                $citizen->family()->firstOrCreate([]);
                $citizen->education()->firstOrCreate([]);
                $citizen->background()->firstOrCreate([]);
            }

            return $counts;
        });
    }

    private function parseInserts(string $sql): array
    {
        $result = [];
        preg_match_all('/INSERT INTO\s+`([^`]+)`\s*\(([^)]+)\)\s*VALUES\s*/i', $sql, $matches, PREG_OFFSET_CAPTURE);

        foreach ($matches[0] as $index => $match) {
            $table = $matches[1][$index][0];
            if (! in_array($table, self::TABLES, true)) {
                continue;
            }
            preg_match_all('/`([^`]+)`/', $matches[2][$index][0], $columnMatches);
            $columns = $columnMatches[1];
            $start = $match[1] + strlen($match[0]);
            $parsed = $this->parseValues($sql, $start);
            foreach ($parsed as $values) {
                if (count($values) !== count($columns)) {
                    throw new InvalidArgumentException("The {$table} dump has a column/value mismatch.");
                }
                $result[$table][] = array_combine($columns, $values);
            }
        }

        return $result;
    }

    /** Read SQL tuple values while respecting quoted commas, parentheses and escapes. */
    private function parseValues(string $sql, int $start): array
    {
        $rows = [];
        $row = [];
        $value = '';
        $quoted = false;
        $wasQuoted = false;
        $escaped = false;
        $inRow = false;
        $ended = false;
        $length = strlen($sql);

        for ($i = $start; $i < $length; $i++) {
            $char = $sql[$i];
            if ($quoted) {
                if ($escaped) {
                    $value .= match ($char) {
                        'n' => "\n", 'r' => "\r", 't' => "\t", '0' => "\0", 'Z' => "\x1a",
                        default => $char,
                    };
                    $escaped = false;
                } elseif ($char === '\\') {
                    $escaped = true;
                } elseif ($char === "'") {
                    if (($sql[$i + 1] ?? '') === "'") {
                        $value .= "'";
                        $i++;
                    } else {
                        $quoted = false;
                    }
                } else {
                    $value .= $char;
                }
                continue;
            }
            if ($char === ';') {
                $ended = true;
                break;
            }
            if ($char === '(' && ! $inRow) {
                $inRow = true;
                $row = [];
                $value = '';
                $wasQuoted = false;
            } elseif ($char === "'" && $inRow) {
                $quoted = true;
                $wasQuoted = true;
            } elseif ($char === ',' && $inRow) {
                $row[] = $this->scalar($value, $wasQuoted);
                $value = '';
                $wasQuoted = false;
            } elseif ($char === ')' && $inRow) {
                $row[] = $this->scalar($value, $wasQuoted);
                $rows[] = $row;
                $inRow = false;
            } elseif ($inRow && ! (ctype_space($char) && ($wasQuoted || $value === ''))) {
                $value .= $char;
            }
        }

        if (! $ended || $quoted || $inRow) {
            throw new InvalidArgumentException('The SQL dump contains an incomplete INSERT statement.');
        }

        return $rows;
    }

    private function scalar(string $value, bool $quoted): ?string
    {
        $value = $quoted ? $value : trim($value);
        return ! $quoted && strtoupper($value) === 'NULL' ? null : $value;
    }
}
