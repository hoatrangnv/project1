<?php

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

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
});
Auth::routes();
//Route::get('/home', 'HomeController@index');
//
//Route::get('/', 'PostController@index')->name('home');
Route::resource('users', 'UserController');
Route::resource('roles', 'RoleController');
Route::resource('permissions', 'PermissionController');
Route::resource('posts', 'PostController');
Route::resource('packages', 'PackageController');
Route::get('members/genealogy', 'MemberController@genealogy');
Route::get('members/binary', 'MemberController@binary');
Route::get('members/refferals', 'MemberController@refferals');
Route::resource('members', 'MemberController');

Route::get('wallets/usd', 'WalletController@usd');
Route::get('wallets/btc', 'WalletController@btc');
Route::get('wallets/clp', 'WalletController@clp');
Route::get('wallets/reinvest', 'WalletController@reinvest');
Route::resource('wallets', 'WalletController');

//Route::get('members/genealogy', 'MemberController@genealogy');
//
//Route::get('members/genealogy', 'MemberController@genealogy');