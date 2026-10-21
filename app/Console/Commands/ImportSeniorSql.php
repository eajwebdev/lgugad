<?php

namespace App\Console\Commands;

use App\Services\SeniorSqlImporter;
use Illuminate\Console\Command;
use Throwable;

class ImportSeniorSql extends Command
{
    protected $signature = 'senior:import-sql {file : Path to a phpMyAdmin senior SQL dump} {--replace : Replace existing senior records}';
    protected $description = 'Import senior citizen records from a SQL dump; ignore accounts and unrelated tables';

    public function handle(SeniorSqlImporter $importer): int
    {
        try {
            $counts = $importer->import($this->argument('file'), (bool) $this->option('replace'));
        } catch (Throwable $exception) {
            $this->error($exception->getMessage());
            return self::FAILURE;
        }

        $this->info('Senior citizen import complete.');
        foreach ($counts as $table => $count) {
            $this->line("{$table}: {$count}");
        }

        return self::SUCCESS;
    }
}
