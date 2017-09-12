<?php
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('users/search',"UserController@search");
Route::group( ['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('posts', 'PostController');
    Route::get('members/genealogy', 'MemberController@genealogy');
    Route::get('members/binary', 'MemberController@binary');
    Route::get('members/refferals', 'MemberController@refferals');
    Route::get('members/pushIntoTree', 'MemberController@pushIntoTree');
    Route::resource('members', 'MemberController');
    Route::get('authenticator', 'Auth2FAController@index');
    Route::post('authenticator', 'Auth2FAController@index');

    Route::get('wallets/usd', 'WalletController@usd');
    Route::get('wallets/btc', 'WalletController@btc');
    Route::get('wallets/clp', 'WalletController@clp');
    Route::get('wallets/reinvest', 'WalletController@reinvest');
    Route::get('wallets/deposit', 'WalletController@deposit');

    Route::get('wallets/btcwithdraw', 'WalletController@btcwithdraw');
    Route::post('wallets/btcwithdraw', 'WalletController@btcwithdraw');

    Route::get('wallets/buyclp', 'WalletController@buyclp');
    Route::post('wallets/buyclp', 'WalletController@buyclp');

    Route::get('wallets/buyclpbybtc', 'WalletController@buyclpbybtc');
    Route::post('wallets/buyclpbybtc', 'WalletController@buyclpbybtc');

    Route::get('wallets/sellclpbybtc', 'WalletController@sellclpbybtc');
    Route::post('wallets/sellclpbybtc', 'WalletController@sellclpbybtc');

    Route::get('wallets/buysellclp', 'WalletController@buysellclp');

    Route::get('wallets/getbtccoin',"WalletController@getBtcCoin");

    Route::get('mybonus/faststart', 'MyBonusController@faststart');
    Route::get('mybonus/binary', 'MyBonusController@binary');
    Route::get('mybonus/loyalty', 'MyBonusController@loyalty');
    Route::resource('mybonus', 'MyBonusController');

    Route::get('packages/invest', 'PackageController@invest');
    Route::post('packages/invest', [ 'as' => 'packages.invest', 'uses' => 'PackageController@invest']);
    Route::resource('packages', 'PackageController');

    //Profile router
    Route::get('profile','ProfileController@index');
    Route::post('profile/changepassword','ProfileController@changePassword');
    Route::get('profile/switchauthen','ProfileController@switchTwoFactorAuthen');


});
Route::get('getnotification','GetNotificationController@getNotification');
Route::post('getnotification','GetNotificationController@getNotification');
/***------- TEST -------***/
Route::get('ethereumtest', 'EthereumTestController@index');

Route::get('active/{infoActive}',"Auth\ActiveController@activeAccount");
Route::get('notification/useractive',"NotificationController@userActive");
Route::get('notification/useractived',"NotificationController@userActived");
