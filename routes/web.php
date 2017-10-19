<?php
Route::get('/', function () {
    return view('welcome');
});

Route::get('/term-condition.html', function () {
    return view('adminlte::layouts.term_register');
});

Route::get('/package-term-condition.html', function () {
    return view('adminlte::layouts.term_buy_pack');
});

Auth::routes();
Route::get('authenticator', 'Auth\LoginController@auth2fa');
Route::post('authenticator', 'Auth\LoginController@auth2fa');
Route::get('users/search',"User\UserController@search");
Route::group( ['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('users/root', 'User\UserController@root')->name('users.root');
    Route::get('users/photo_approve', 'User\UserController@photo_approve')->name('users.photo_approve');
    Route::post('users/approve_ok/{id}', 'User\UserController@approve_ok')->name('approve.ok');
    Route::post('users/approve_cancel/{id}', 'User\UserController@approve_cancel')->name('approve.cancel');
    Route::resource('users', 'User\UserController');
    Route::resource('roles', 'User\RoleController');
    Route::resource('posts', 'User\PostController');
    


    Route::get('members/genealogy', 'User\MemberController@genealogy');
    Route::get('members/binary', 'User\MemberController@binary');
    Route::get('members/referrals', 'User\MemberController@refferals');
    Route::get('members/referrals/{id}/detail', 'User\MemberController@refferalsDetail');
    Route::post('members/pushIntoTree', 'User\MemberController@pushIntoTree');
    Route::resource('members', 'User\MemberController');

    
    //USD WALLET
    Route::get('wallets/usd', 'Wallet\UsdWalletController@usdWallet')->name('wallet.usd');
    Route::post('wallets/usd', 'Wallet\UsdWalletController@usdWallet');
    //Route::get('wallets/switchusdclp', 'Wallet\UsdWalletController@switchUSDCLP');
    Route::get('wallets/getrateusdbtc', 'Wallet\UsdWalletController@getDataWallet');
    Route::post('wallets/btcwithdraw', 'Wallet\WithDrawController@btcWithDraw');

    //Re-invest WALLET
    Route::get('wallets/reinvest', 'Wallet\UsdWalletController@reinvestWallet')->name('wallet.reinvest');
    Route::post('wallets/reinvest', 'Wallet\UsdWalletController@reinvestWallet');

    //BTC WALLET
    Route::get('wallets/btc', 'Wallet\BtcWalletController@showBTCWallet')->name('wallet.btc');
    Route::get('wallets/getbtccoin',"Wallet\BtcWalletController@getBtcCoin");
    Route::post('wallets/btcbuyclp',"Wallet\BtcWalletController@buyCLP");

    Route::get('wallets/btctranfer',"Wallet\BtcWalletController@btctranfer");

    Route::get('wallets/clptranfer',"Wallet\ClpWalletController@clptranfer");

    //Route::get('wallets/deposit', 'Wallet\BtcWalletController@deposit');
    //Route::get('wallets/switchbtcclp', 'Wallet\BtcWalletController@switchBTCCLP');
    
    //CLP WALLET
    Route::get('wallets/clp', 'Wallet\ClpWalletController@clpWallet')->name('wallet.clp');
    Route::post('wallets/clp', 'Wallet\ClpWalletController@clpWallet')->name('wallet.clp');
    Route::get('wallets/clp/getaddressclpwallet', 'Wallet\ClpWalletController@getClpWallet');
    Route::post('wallets/clpwithdraw', 'Wallet\WithDrawController@clpWithDraw');
    Route::post('wallets/sellclp', 'Wallet\ClpWalletController@sellCLP');
    
    //Get total value
    Route::get('wallets/totalvalue','WalletController@getMaxTypeWallet');
        
    Route::get('wallets/buyclpbybtc', 'WalletController@buyclpbybtc');
    Route::post('wallets/buyclpbybtc', 'WalletController@buyclpbybtc');

    Route::get('wallets/sellclpbybtc', 'WalletController@sellclpbybtc');
    Route::post('wallets/sellclpbybtc', 'WalletController@sellclpbybtc');

    Route::get('wallets/transferholding', 'WalletController@transferFromHolding')->name('holding.transfer');

    Route::post('wallets/buyclpusd', 'Wallet\UsdWalletController@buyCLP')->name('usd.buyclp');

  

    Route::get('mybonus/faststart', 'MyBonusController@faststart');
    Route::get('mybonus/binary', 'MyBonusController@binary');
    Route::get('mybonus/loyalty', 'MyBonusController@loyalty');
    Route::resource('mybonus', 'MyBonusController');

    Route::get('packages/invest', 'PackageController@invest');
    Route::post('packages/invest', [ 'as' => 'packages.invest', 'uses' => 'PackageController@invest']);
    Route::post('packages/withdraw', [ 'as' => 'packages.withdraw', 'uses' => 'PackageController@withDraw']);
    Route::resource('packages', 'PackageController');

    //Profile router
    Route::any('profile/upload','User\ProfileController@upload');
    Route::get('profile','User\ProfileController@index');
    Route::post('profile/changepassword','User\ProfileController@changePassword');
    Route::get('profile/switchauthen','User\ProfileController@switchTwoFactorAuthen');

    Route::resource('profile', 'User\ProfileController');

    
    //News
    Route::get('news/manage','News\NewsController@newManagent')->name('news.manage');
    Route::get('news/add','News\NewsController@newAdd');
    Route::post('news/add','News\NewsController@newAdd');
    Route::get('news/edit/{id}','News\NewsController@newEdit');
    Route::put('news/edit/{id}','News\NewsController@newEdit');
    Route::get('news/delete/{id}','News\NewsController@newDelete');
    Route::get('news/detail/{id}','News\DisplayNewsController@displayDetailNews');
    //get ty gia
    Route::get('exchange',function(App\ExchangeRate $rate){
        return $rate->getExchRate();
    });
    

});
Route::get('getnotification','GetNotificationController@getNotification');
Route::post('getnotification','GetNotificationController@getNotification');

/***------- TEST -------***/
//Route::get('ethereumtest', 'EthereumTestController@index');
//Route::get('test-register', 'Auth\TestRegisterController@showRegistrationFormNoActive')->name('test.showRegister');
//Route::post('registernoactiveaction', 'Auth\TestRegisterController@registerNoActive')->name('test.registerAction');

//Route::get('test-binary', 'TestController@testBinary');
//Route::get('test-interest',"TestController@testInterest");
//Route::get('test-auto-binary',"TestController@testAutoAddBinary");
//Route::get('test',"TestController@test");


/***------- END TEST -------***/
Route::get('ref/{nameref}',"Auth\RegisterController@registerWithRef")->name('user.ref');
Route::get('active/{infoActive}',"Auth\ActiveController@activeAccount");
//Route::get('reactive',"Auth\ActiveController@reactiveAccount");
//Route::post('reactive',"Auth\ActiveController@reactiveAccount");
Route::get('notification/useractive',"NotificationController@userActive");
Route::get('notification/useractived',"NotificationController@userActived");
Route::get('notiactive',"NotificationController@userNotiActive");
Route::any('confirmWithdraw',"Wallet\WithDrawController@confirmWithdraw");

