<?php



class GetNotificationController

<<<<<<< HEAD
=======
use Coinbase\Wallet\Client;
use Coinbase\Wallet\Configuration;
use Coinbase\Wallet\Resource\Address;
use App\BitGoSDK;

class GetNotificationController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    public function getNotification(){

        // key chains = 33PK7u86q3v1cPqcKBhwmCHzs6RfFYfzJP
        // wallets_id = 33PK7u86q3v1cPqcKBhwmCHzs6RfFYfzJP
        // wallets_id = 3JYs1xqtq7fL5dFyy4E3LyeycM5QMwyLkG
        // address_wallet = 3P5t8x767hbNsc5nkFmHqSiMPVyQ9r4nTu
       $bitgo = new BitGoSDK('v2x15b687915c114fd8d4583bedcf0617e5b41cfe311d2e31db7aba849939a739ef');
       $wallet = $bitgo->createWallet();
       dd($wallet);
       // dd($bitgo->createAddress('33PK7u86q3v1cPqcKBhwmCHzs6RfFYfzJP','0x69920a31a0a1aca870e2d1bbf03913ad8065f6fb'));
    }

}
