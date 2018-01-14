<?php

require 'vendor/autoload.php';

use App\Controller\MerchantController as Merchant;

$merchantId = $argv[1];

$merchant = new Merchant();
$merchant->setMerchantId($merchantId);

var_dump($merchant->getTransactions());

//foreach($merchant->getTransactions() as $transaction) {
//
//}