<?php

require 'vendor/autoload.php';

use App\Controller\MerchantController as Merchant;

$merchantId = $argv[1];

$merchant = new Merchant();
$merchant->setMerchantId($merchantId);

foreach($merchant->getTransactions() as $transaction) {
//    var_dump($transaction);
}