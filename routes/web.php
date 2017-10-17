<?php
Route::get('/', function () {
    return view('welcome');
});
Route::get('/term-condition.html', function () {
    return view('term');
});
Auth::routes();
Route::get('users/search',"Backend\User\UserController@search");
Route::group(/**
 *
 */
    ['middleware' => ['auth']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('admin/home', 'Backend\HomeController@index')->name('backend.home');
    Route::get('users/root', 'Backend\User\UserController@root')->name('users.root');
    Route::post('users/reset2fa', 'Backend\User\UserController@reset2fa')->name('users.reset2fa');
    Route::get('users/photo_approve', 'Backend\User\UserController@photo_approve')->name('users.photo_approve');
    Route::post('users/approve_ok/{id}', 'Backend\User\UserController@approve_ok')->name('approve.ok');
    Route::post('users/approve_cancel/{id}', 'Backend\User\UserController@approve_cancel')->name('approve.cancel');
    Route::resource('users', 'Backend\User\UserController');
    Route::resource('roles', 'Backend\User\RoleController');
    Route::resource('posts', 'Backend\User\PostController');

    Route::get('/report/member', 'Backend\ReportController@member')->name('report.member');
    Route::get('/report/member_pack', 'Backend\ReportController@member_pack')->name('report.member_pack');


    Route::get('members/genealogy', 'Backend\User\MemberController@genealogy');
    Route::get('members/binary', 'Backend\User\MemberController@binary');
    Route::get('members/referrals', 'Backend\User\MemberController@refferals');
    Route::get('members/referrals/{id}/detail', 'Backend\User\MemberController@refferalsDetail');
    Route::post('members/pushIntoTree', 'Backend\User\MemberController@pushIntoTree');
    Route::resource('members', 'Backend\User\MemberController');
    Route::get('authenticator', 'Auth\Auth2FAController@index');
    Route::post('authenticator', 'Auth\Auth2FAController@index');
    
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
    Route::post('wallets/clpwithdraw', 'Wallet\WithDrawController@clpWithDraw');
    Route::post('wallets/sellclp', 'Wallet\ClpWalletController@sellCLP');
    
    //Get total value
    Route::get('wallets/totalvalue','WalletController@getMaxTypeWallet');
    

    Route::get('wallets/buyclp', 'WalletController@buyclp');
    Route::post('wallets/buyclp', 'WalletController@buyclp');
        
    Route::get('wallets/buyclpbybtc', 'WalletController@buyclpbybtc');
    Route::post('wallets/buyclpbybtc', 'WalletController@buyclpbybtc');

    Route::get('wallets/sellclpbybtc', 'WalletController@sellclpbybtc');
    Route::post('wallets/sellclpbybtc', 'WalletController@sellclpbybtc');

    Route::get('wallets/buysellclp', 'WalletController@buysellclp');
    Route::get('wallets/transferholding', 'WalletController@transferFromHolding')->name('holding.transfer');

    Route::post('wallets/buyclpusd', 'Wallet\UsdWalletController@buyCLP')->name('usd.buyclp');

  

    Route::get('mybonus/faststart', 'MyBonusController@faststart');
    Route::get('mybonus/binary', 'MyBonusController@binary');
    Route::get('mybonus/loyalty', 'MyBonusController@loyalty');
    Route::resource('mybonus', 'MyBonusController');

    Route::get('packages/invest', 'Backend\PackageController@invest');
    Route::post('packages/invest', [ 'as' => 'packages.invest', 'uses' => 'Backend\PackageController@invest']);
    Route::post('packages/withdraw', [ 'as' => 'packages.withdraw', 'uses' => 'Backend\PackageController@withDraw']);
    Route::resource('packages', 'Backend\PackageController');

    //Profile router
    Route::any('profile/upload','User\ProfileController@upload');
    Route::get('profile','User\ProfileController@index');
    Route::post('profile/changepassword','User\ProfileController@changePassword');
    Route::get('profile/switchauthen','User\ProfileController@switchTwoFactorAuthen');

    Route::resource('profile', 'User\ProfileController');

    
    //News
    Route::get('news/manage','Backend\News\NewsController@newManagent')->name('news.manage');
    Route::get('news/add','Backend\News\NewsController@newAdd');
    Route::post('news/add','Backend\News\NewsController@newAdd');
    Route::get('news/edit/{id}','Backend\News\NewsController@newEdit');
    Route::put('news/edit/{id}','Backend\News\NewsController@newEdit');
    Route::get('news/delete/{id}','Backend\News\NewsController@newDelete');
    Route::get('news/detail/{id}','Backend\News\DisplayNewsController@displayDetailNews');
    //get ty gia
    Route::get('exchange',function(App\ExchangeRate $rate){
        return $rate->getExchRate();
    });
    

});
Route::get('getnotification','GetNotificationController@getNotification');
Route::post('getnotification','GetNotificationController@getNotification');

/***------- TEST -------***/
Route::get('ethereumtest', 'EthereumTestController@index');
Route::get('test-register', 'Auth\TestRegisterController@showRegistrationFormNoActive')->name('test.showRegister');
Route::post('registernoactiveaction', 'Auth\TestRegisterController@registerNoActive')->name('test.registerAction');

Route::get('test-binary', 'TestController@testBinary');
Route::get('test-interest',"TestController@testInterest");
Route::get('test-auto-binary',"TestController@testAutoAddBinary");



/***------- END TEST -------***/
Route::get('ref/{nameref}',"Auth\RegisterController@registerWithRef")->name('user.ref');
Route::get('active/{infoActive}',"Auth\ActiveController@activeAccount");
Route::get('reactive',"Auth\ActiveController@reactiveAccount");
Route::post('reactive',"Auth\ActiveController@reactiveAccount");
Route::get('notification/useractive',"NotificationController@userActive");
Route::get('notification/useractived',"NotificationController@userActived");
Route::get('notiactive',"NotificationController@userNotiActive");
Route::any('confirmWithdraw',"Wallet\WithDrawController@confirmWithdraw");

Route::get('test',"TestController@test");