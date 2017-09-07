var BitGoJS = require('bitgo');

var useProduction = false;
var bitgo = new BitGoJS.BitGo({accessToken:'v2x7fe39ff7f30d0c11ae0db91b2250791e76406f0ba7641943c3db43a7e682af67'});

// bitgo.me({}, function callback(err, user) {
//   if (err) {
//     // handle error
//   }
//   console.log(user);
// });

// bitgo.session({}, function callback(err, session) {
//   if (err) {
//     // handle error
//   }
//   console.dir(session);
// });

// var wallets = bitgo.wallets();
// wallets.list({}, function callback(err, wallets) {
// // handle error, do something with wallets
// console.log(wallets.wallets);
// });

// var wallets = bitgo.wallets();
// var data = {
//   "type": "bitcoin",
//   "id": "2N5tprWy7NWoqQaeYp2YBHj5aboaax1Mvk6",
// };
// wallets.get(data, function callback(err, wallet) {
//   if (err) {
//     // handle error
//   }
//   // Use wallet object here
//   console.dir(wallet);
//   console.dir(wallet.balance());
// });


// var destinationAddress = '2NF4DxJrFEWr3TUiFPTcw5Hn3sbKbnPxTxu';
// var amountSatoshis = 0.001 * 1e8; // send 0.1 bitcoins
// var walletPassphrase = 'huydkzhi@300393';
// var walletId = '2N9XUSpu2Y4MRAoRELLUwtFhLJkmDfuDKfg'
// var otp = '0000000';
// bitgo.unlock({otp: otp}, function callback(err) {
//   if (err) {
//     console.log(err);
//   }
  
// });

// bitgo.wallets().get({id: walletId}, function(err, wallet) {
//   if (err) { console.log("Error getting wallet!"); console.dir(err); return process.exit(-1); }
//   console.log("Balance is: " + (wallet.balance() / 1e8).toFixed(4));

//   wallet.sendCoins({ address: destinationAddress, amount: amountSatoshis, walletPassphrase: walletPassphrase }, function(err, result) {
//     if (err) { console.log("Error sending coins!"); console.dir(err); return process.exit(-1); }

//     console.dir(result);
//   });
// });

var data = {
  "passphrase": 'huydkzhi@300393',
  "label": 'vi_test_21h',
  "backupXpubProvider": "keyternal"
}

bitgo.wallets().createWalletWithKeychains(data, function(err, result) {
  if (err) { console.dir(err); throw new Error("Could not create wallet!"); }
  console.dir(result.wallet.wallet);
  console.log("User keychain encrypted xPrv: " + result.userKeychain.encryptedXprv);
  console.log("Backup keychain xPub: " + result.backupKeychain.xPub);
});