<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer('layouts.sidebar', function ($view) {
            $menus = Menu::orderBy('priority')->get(); 
            $view->with('menuTree', $menus);
        });

        DB::listen(function ($query) {
        if (str_contains($query->sql, 'general_logs')) {
            return;
        }

        if (!preg_match('/^(insert|update|delete)/i', $query->sql)) {
            return;
        }

        collect_log([
            'log_type' => 'db-query',
            'model_type' => null,
            'model_id' => null,
            'before' => null,
            'after' => json_encode([
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
            ]),
            'user_id' => Auth::id(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    });
    }
}
