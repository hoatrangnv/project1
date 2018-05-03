# CLP BOS Change Log
## CR0032
This change will enhance CR0031 
A. User A can transfer unlimited amount of USD to user B;
B. User B can re-transfer the received USD amount to any other user;
C. There is not time limit it can take place

and bug fixed


## CR0031
This change will modify the transfer of USD between users with the following specifications
A. When user A transfers USD to B, A must B's upline or downline. A and B cannot be sideline;
B. A can transfer any amount to B (as long as it does not exceed max package price);
C. B can receive many USD transfer from the same or different senders;
D. The USD B receive can only be used for activate / upgrade package;
E. To buy package, there is no exchange rate involve, USD100 can buy USD100 package

Request
1. Transfer is only allowed between uplines and downlines and **NOT** sideline
2. Use can accumulate 2 or more transfers to buy a bigger package.

Database Change
   A. New table usd_coin_usds;
   B. Modify tabel user_orders needs a new column amountUSD with type double;
   To extend the database, user can run 
   ~php artisan migrate~;
   
