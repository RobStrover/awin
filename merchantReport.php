<?php

require 'vendor/autoload.php';

use App\Controller\MerchantController as Merchant;

$merchantId = $argv[1];

$merchant = new Merchant();
$merchant->setMerchantId($merchantId);

$transactions = $merchant->getTransactions();

if (count($transactions) == 0) {
    echo 'No transactions found for merchant ' . $merchantId . "\r\n";
} else {
    echo count($transactions) . ' transactions for merchant ' . $merchantId . "\r\n";
    echo ' | Date       | Value  |' . "\r\n";
}

foreach($transactions as $transaction) {
    echo ' | ' . $transaction['date'] . ' | ' . $transaction['symbol'] . $transaction['value'] . " | \r\n";
}
