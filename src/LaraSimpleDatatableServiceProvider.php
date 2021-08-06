<?php

namespace Cuongnd88\LaraSimpleDatatable;

use Illuminate\Support\ServiceProvider;

class LaraSimpleDatatableServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('simpleDatatable', function() {
            return new SimpleDatatable();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Set Paginator views
         */
        Paginator::defaultView(config('simple-datatable.paginator_view'));
        Paginator::defaultSimpleView(config('simple-datatable.simple_paginator_view'));

        /**
         * Define simple datatbale components
         */
        Blade::component('components.simple-datatable.simple-datatable', 'simpleDatatable');
        Blade::component('components.simple-datatable.simple-paginator', 'simplePaginator');

        $this->publishes([
            __DIR__.'/../resources' => resource_path(),
        ], 'simple-datatable-view');

        $this->publishes([
            __DIR__.'/../resources' => config_path(),
        ], 'simple-datatable-config');
    }
}