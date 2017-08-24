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

Route::get('mybonus/faststart', 'MyBonusController@faststart');
Route::get('mybonus/binary', 'MyBonusController@binary');
Route::get('mybonus/loyalty', 'MyBonusController@loyalty');
Route::resource('mybonus', 'MyBonusController');

Route::get('packages/invest', 'PackageController@invest');
Route::post('packages/invest', [ 'as' => 'packages.invest', 'uses' => 'PackageController@invest']);
Route::resource('packages', 'PackageController');

Route::get('members/genealogy', 'MemberController@genealogy');
Route::get('members/binary', 'MemberController@binary');
Route::get('members/refferals', 'MemberController@refferals');
Route::get('members/pushIntoTree', 'MemberController@pushIntoTree');
Route::resource('members', 'MemberController');


Route::get('wallets/usd', 'WalletController@usd');
Route::get('wallets/btc', 'WalletController@btc');
Route::get('wallets/clp', 'WalletController@clp');
Route::get('wallets/reinvest', 'WalletController@reinvest');
Route::get('wallets/deposit', 'WalletController@deposit');
Route::get('wallets/btcwithdraw', 'WalletController@btcwithdraw');
Route::resource('wallets', 'WalletController');
Route::get('authenticator', 'Auth2FAController@index');
Route::post('authenticator', 'Auth2FAController@index');
Route::get('authenticator/check2fa', 'Auth2FAController@check2fa');
Route::post('authenticator/check2fa', 'Auth2FAController@check2fa');


//Route::get('members/genealogy', 'MemberController@genealogy');
//
//Route::get('members/genealogy', 'MemberController@genealogy');