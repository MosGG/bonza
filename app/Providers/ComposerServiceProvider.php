<?php 

namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;
use DB;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {

        // 使用闭包来指定视图组件
        View::composer('layouts.pageLayout', function($view)
        {
            $category = DB::table('category')->where('father', '!=', '0')->get();
            $view->with('category', $category);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}