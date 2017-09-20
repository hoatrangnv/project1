<?php
Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('users/search',"User\UserController@search");
Route::group( ['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::resource('users', 'User\UserController');
    Route::resource('roles', 'User\RoleController');
    Route::resource('posts', 'User\PostController');
    Route::get('members/genealogy', 'User\MemberController@genealogy');
    Route::get('members/binary', 'User\MemberController@binary');
    Route::get('members/refferals', 'User\MemberController@refferals');
    Route::get('members/pushIntoTree', 'User\MemberController@pushIntoTree');
    Route::resource('members', 'User\MemberController');
    Route::get('authenticator', 'Auth\Auth2FAController@index');
    Route::post('authenticator', 'Auth\Auth2FAController@index');

    Route::get('wallets/usd', 'Wallet\UsdWalletController@usdWallet');
    Route::post('wallets/usd', 'Wallet\UsdWalletController@usdWallet');
    Route::get('wallets/switchusdclp', 'Wallet\UsdWalletController@switchUSDCLP');
    Route::get('wallets/getrateusdbtc', 'Wallet\UsdWalletController@getDataWallet');
    
    Route::get('wallets/btc', 'Wallet\BtcWalletController@btcWallet')->name('wallet.btc');
    Route::get('wallets/getbtccoin',"Wallet\BtcWalletController@getBtcCoin");
    
    Route::get('wallets/clp', 'WalletController@clp')->name('wallet.clp');
    Route::get('wallets/reinvest', 'WalletController@reinvest');
    Route::get('wallets/deposit', 'Wallet\BtcWalletController@deposit');

    Route::get('wallets/btcwithdraw', 'Wallet\WithDrawController@btcWithDraw');
    Route::post('wallets/btcwithdraw', 'Wallet\WithDrawController@btcWithDraw');

    Route::get('wallets/buyclp', 'WalletController@buyclp');
    Route::post('wallets/buyclp', 'WalletController@buyclp');
        
    Route::get('wallets/buyclpbybtc', 'WalletController@buyclpbybtc');
    Route::post('wallets/buyclpbybtc', 'WalletController@buyclpbybtc');

    Route::get('wallets/sellclpbybtc', 'WalletController@sellclpbybtc');
    Route::post('wallets/sellclpbybtc', 'WalletController@sellclpbybtc');

    Route::get('wallets/buysellclp', 'WalletController@buysellclp');

  

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
    Route::resource('profile', 'ProfileController');


});
Route::get('getnotification','GetNotificationController@getNotification');
Route::post('getnotification','GetNotificationController@getNotification');

/***------- TEST -------***/
Route::get('ethereumtest', 'EthereumTestController@index');
Route::get('test-register', 'Auth\TestRegisterController@showRegistrationFormNoActive')->name('test.showRegister');
Route::post('registernoactiveaction', 'Auth\TestRegisterController@registerNoActive')->name('test.registerAction');

Route::get('test-set-clp', 'TestController@showCLP')->name('test.showCLP');
Route::post('setclp', 'TestController@setCLP')->name('test.setCLP');

/***------- END TEST -------***/

Route::get('active/{infoActive}',"Auth\ActiveController@activeAccount");
Route::get('reactive',"Auth\ActiveController@reactiveAccount");
Route::post('reactive',"Auth\ActiveController@reactiveAccount");
Route::get('notification/useractive',"NotificationController@userActive");
Route::get('notification/useractived',"NotificationController@userActived");
Route::get('notiactive',"NotificationController@userNotiActive");
Route::get('test',"TestController@test");
