<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()){
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //View::share('channels', Channel::all());
        
        //View::composer('*', function($view){
        //    $view->with('channels', Channel::all());
        //});
        
        //dd('query'); // X
        //var_dump('query');
        
        View::composer('*', function($view){
            $channels = \Cache::rememberForever('channels', function(){
                return Channel::all();
            });
            
            $view->with('channels', $channels);
        });
    }
}
