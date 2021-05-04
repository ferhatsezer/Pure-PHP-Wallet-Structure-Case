<?php

include "__autoload__.php";

$user = Model\User::find(1);


$bankWallet = new BankWallet($user);
$bonusWallet = new BonusWallet($user);



$bankWalletService = new WalletService($bankWallet);
$bonusWalletService = new WalletService($bonusWallet);

$bankWalletService->withdraw(3850.42, "Dell Inspiron 3501 Fb1005f82c I3 1005g1");
$bonusWalletService->deposit(38.5, "Dell Inspiron 3501 Fb1005f82c I3 1005g1 Bonus");