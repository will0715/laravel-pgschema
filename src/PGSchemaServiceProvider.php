<?php

namespace Poyi\PGSchema;

use Illuminate\Support\ServiceProvider;
use Poyi\PGSchema\Commands\PGMigrateCommand;
use Poyi\PGSchema\Commands\PGMigrateAllCommand;
use Poyi\PGSchema\Commands\PGRefreshCommand;
use Poyi\PGSchema\Commands\PGResetCommand;
use Poyi\PGSchema\Commands\PGRollbackCommand;
use Poyi\PGSchema\Commands\PGSeedCommand;

/**
 * Class PGSchemaServiceProvider
 *
 * @package Poyi\PGSchema
 */
class PGSchemaServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('pgschema', function () {
            return new PGSchema();
        });
        $this->app->singleton('pgschema.migrate', function ($app) {
            return new PGMigrateCommand($app['migrator']);
        });
        $this->app->singleton('pgschema.migrate_all', function ($app) {
            return new PGMigrateAllCommand($app['migrator']);
        });
        $this->app->singleton('pgschema.rollback', function ($app) {
            return new PGRollbackCommand($app['migrator']);
        });
        $this->app->singleton('pgschema.reset', function ($app) {
            return new PGResetCommand($app['migrator']);
        });
        $this->app->singleton('pgschema.refresh', function ($app) {
            return new PGRefreshCommand();
        });
        $this->app->singleton('pgschema.seed', function ($app) {
            return new PGSeedCommand($app['db']);
        });
        $this->commands([
            'pgschema.migrate',
            'pgschema.migrate_all',
            'pgschema.rollback',
            'pgschema.reset',
            'pgschema.refresh',
            'pgschema.seed',
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
