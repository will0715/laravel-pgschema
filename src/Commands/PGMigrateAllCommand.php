<?php

namespace Poyi\PGSchema\Commands;

use Illuminate\Console\Command;
use DB;
use Artisan;

class PGMigrateAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pgschema:migrate_all {--database= : The database connection to use.}
                {--force : Force the operation to run when in production.}
                {--path= : The path of migrations files to be executed.}
                {--pretend : Dump the SQL queries that would be run.}
                {--seed : Indicates if the seed task should be re-run.}
                {--step : Force the migrations to be run so they can be rolled back individually.}';


    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $database = $this->option('database');
        $force = $this->option('force');
        $path = $this->option('path');
        $pretend = $this->option('pretend');
        $seed = $this->option('seed');
        $step = $this->option('step');
        $schemas = $this->laravel['pgschema']->listSchemas($database);
        foreach ($schemas as $schema) {
            $schemaName = $schema->nspname;
            if ($schemaName != 'public') {
                try{
                    echo 'start migrate schema : '. $schemaName . PHP_EOL;
                    $options = [
                        "--schema" => $schemaName,
                        "--database" => $database,
                        "--force" => $force,
                        "--path" => $path,
                        "--pretend" => $pretend,
                        "--seed" => $seed,
                        "--step" => $step,
                    ];
                    $migrate = Artisan::call('pgschema:migrate', $options);
                    echo 'migrate succeed' . PHP_EOL;
                } catch (\Exception $e) {
                    echo 'migrate failed schema : ' . $schemaName. '. Error : ' . $e . PHP_EOL;
                }
            }

        }
    }

}