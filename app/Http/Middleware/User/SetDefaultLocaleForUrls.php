<?php

namespace App\Http\Middleware\User;


use Closure;
use Illuminate\Support\Facades\URL;

class SetDefaultLocaleForUrls
{
    public function handle($request, Closure $next)
    {
        # 可以動態設定
//        URL::defaults(['locale' => $request->user()->locale]);
        URL::defaults(['locale' => 'tw']);

        return $next($request);
    }
}