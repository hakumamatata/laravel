<?php

namespace App\Providers\View;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        # 使用 Class
        View::composer(
            'greeting', 'App\Http\View\Composers\ProfileComposer'
        );

        # 使用 Closure
        View::composer('admin.profile', function ($view) {
            $view->with('class', 'Math');
        });


        # 一次多筆
        View::composer(
            ['view1', 'view2'],
            'App\Http\View\Composers\MyViewComposer'
        );

        # 全部!
        View::composer('*', function ($view) {
            $view->with('systemName', 'My Laravel');
        });
    }
}