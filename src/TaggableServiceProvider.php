<?php

namespace Pharaonic\Laravel\Taggable;

use Illuminate\Support\ServiceProvider;

class TaggableServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Config Merge
        $this->mergeConfigFrom(__DIR__ . '/config/taggable.php', 'laravel-taggable');

        // Migration Loading
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishes
        $this->publishes([
            __DIR__ . '/config/taggable.php'                                                            => config_path('Pharaonic/taggable.php'),

            __DIR__ . '/database/migrations/2021_02_01_000013_create_tags_table.php'                    => database_path('migrations/2021_02_01_000013_create_tags_table.php'),
            __DIR__ . '/database/migrations/2021_02_01_000014_create_tag_translations_table.php'        => database_path('migrations/2021_02_01_000014_create_tag_translations_table.php'),
            __DIR__ . '/database/migrations/2021_02_01_000015_create_taggables_table.php'               => database_path('migrations/2021_02_01_000015_create_taggables_table.php'),
        ], ['pharaonic', 'laravel-taggable']);
    }
}
