<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Url;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


# 基本閉包回傳
Route::get('say', function () {
    return 'Hahaha world';
});

# 傳遞參數 + 正規表達過濾
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    //
    return '$postId' . $postId . '$commentId' . $commentId;
})->where(['post' => '[0-9]+']);

# prefix
Route::get('user/info', function () {
    return 'HERE?';
})->name('profile');
Route::prefix('admin')->group(function () {
    Route::get('user/info', function () {
        return 'ADMIN HERE?';
    });
});

# Report(自定義控制器)
// 路由可以動態調整 對應 控制器類
Route::get('tw/price/list', 'Report\PriceController@taiwan');
Route::get('jp/price/list', 'Report\PriceController@japan');
Route::get('price/list/test', 'Report\PriceController@test');
// test02($str)
Route::get('price/list/test02/{str}', 'Report\PriceController@test02');

# Resource Route 假使要自定義路由 需要在resource (但是建議保持類的專一性 如有需求可再拆解成多個小的控制器)
Route::get('photos/popular', 'PhotoController@method');
Route::resource('photos', 'PhotoController');


# \Illuminate\Http\Request Test
Route::get('request/{rid}', function (\Illuminate\Http\Request $request, $rid) {
    dump($request);

    $uri = $request->path();
    dump($uri);

    if ($request->is('request')) {
        dump('Y');
    } else {
        dump('N');
    }

    $url = $request->url();
    dump($url);
    $fullUrl = $request->fullUrl();
    dump($fullUrl);

    $method = $request->method();
    dump($method);
    if ($request->isMethod('post')) {
        dump('method post...');
    }
    if ($request->isMethod('get')) {
        dump('method get...');
    }

    dump($request->input());
    dump($request->pp ?? 'pp is not exist...');

    $rs1 = $request->only(['pp']);
    dump($rs1);
    $rs2 = $request->except(['pp']);
    dump($rs2);

    dd('test!!');
});


# Illuminate\Http\Response Test
Route::prefix('response')->group(function () {
    Route::get('simple', function () {
        return [1, 2, 3];
    });

    Route::get('hi', function () {
        return response('Hello World', 200)
            ->header('Content-Type', 'text/plain');
    })->name('sayHi');

    Route::get('hi2', function () {
        return response([2, 3, 4], 200)
            ->header('Content-Type', 'text/csv');
    });

    # group with redirect
    Route::get('thi', function () {
//        return redirect('response/hi', 301);
//        return redirect('response/hi');
        return redirect()->route('sayHi');
    });
});

# use Route::redirect
Route::redirect('here', 'there', 301);
Route::get('there', function () {
    return 'here is there!';
});


# back() 返回並帶有輸入值
Route::post('user/profile', function () {
    return back()->withInput();
});


# 文件下載
Route::get('download', function () {
//    return response()->download('test/sayhi.txt');
    return response()->download('test/sayhi.txt', 'test.txt');
//    return response()->download('test/sayhi2.txt')->deleteFileAfterSend();
});
Route::get('file', function () {
//    return response()->file('test/test0526.png');
    return response()->file('test/testFile0526.pdf');
});

# 自定義的Response
Route::get('responseMacro/{name}', function ($name) {
    return response()->book($name);
})->where(['name' => '[a-z]+']);

# View相關
Route::get('view', function () {
//    return view('greeting', ['name' => 'Michael']);

    if (View::exists('admin.profile')) {
        return view('admin.profile', ['name' => 'Mary']);
    } else {
        return view('greeting', ['name' => 'Michael']);
    }

    # first
//    return view()->first(['greeting', 'admin.profile'], ['name' => 'Ken']);
//    return View::first(['admin.profile', 'greeting'], ['name' => 'Ken']);

    # 也可以透過 with
//    return view('greeting')->with('name', 'Victoria');

    # 全局的可以再覆蓋
//    return view('greeting')->with('name', 'Victoria')->with('company', 'Yahoo');
});

# Url相關
Route::get('url', function () {
    echo url('viewOthers/777'), '<br>';

    echo url()->current(), '<br>';
//    echo Url::current(), '<br>';

    echo url()->full(), '<br>';
//    echo Url::full(), '<br>';

    echo url()->previous(), '<br>';
//    echo Url::previous(), '<br>';

    # controller route
    echo action('Report\PriceController@test'), '<br>';
    echo action([\App\Http\Controllers\Report\PriceController::class, 'taiwan']), '<br>';
    echo action([\App\Http\Controllers\Report\PriceController::class, 'test02'], ['str' => 'Hello World']), '<br>';

    exit;
});
// 簽名請求
Route::get('signedUrl', function () {
//    return URL::signedRoute('unsubscribe', ['name' => 'Dave']);

    // 可以設定有效期限
    return URL::temporarySignedRoute(
        'unsubscribe', now()->addSeconds(30), ['name' => 'Yarn']
    );
});
// 驗證授權
Route::get('/unsubscribe/{name}', function (Request $request, $name) {
    if (! $request->hasValidSignature()) {
        abort(401);
    }

    return 'Pass By ' . $name;
})->name('unsubscribe');
// 預設值
Route::get('/{locale}/url', function () {
    echo url()->current(), '<br>';

    echo 'Developer Test...', '<br>';

    exit;
})->middleware(\App\Http\Middleware\User\SetDefaultLocaleForUrls::class);









# 此應為註冊的最後一個路由 (可以自定義找不到路由時 要做的處理)
Route::fallback(function () {
    return '統一找不到路由';
});