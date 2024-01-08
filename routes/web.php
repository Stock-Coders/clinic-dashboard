<?php

use Illuminate\Support\Facades\{
    Route, Auth, Cache, Log, Gate
};
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardHomeController;
// use GuzzleHttp\Middleware;
// use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
// use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

// if any route is non-existing in the project, then 404 page will appear
Route::fallback(function(){
    return abort(404);
});

// this will redirect the standard url "http://localhost:8000/" to "http://localhost:8000/dashboard"
Route::get('/')->middleware('redirectToDashboard');

//-------------------------------> Telescope Routes
Route::get('/cache', function () {
    if(Cache::has('testCache')){ // Cache::has('key')
        return Cache::get('testCache'); // Cache::get('key');
    }
    Cache::add('testCache', 'myCache'); // Cache::add('key', 'value');
    return Cache::get('testCache'); // Cache::get('key');
});

Route::get('/dumps', function () {
    return dump('dumps!!!');
});

Route::get('/gates', function () {
    if (Gate::forUser(Auth::user())->allows('testGate')) {
        return 'you are allowed to take this action';
    }
    abort(403);
});

//-------------------------------> Start Dashboard Routes
Route::group([
    'middleware' => ['auth' , 'dashboard']
], function(){
    Route::prefix('dashboard')->group(function(){
        Route::get('/', [DashboardHomeController::class, 'index'])->name('dashboard');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
