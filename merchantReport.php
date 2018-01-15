<?php

require 'vendor/autoload.php';

use App\Controller\MerchantController as Merchant;

// A merchant ID can only be an integer
if (!array_key_exists(1, $argv) || !is_numeric($argv[1])) {
    die('please include an integer merchant ID');
}

// Get the merchant argument (the first and only argument)
$merchantId = $argv[1];

// Set the new merchant ID in a new
$merchant = new Merchant();
$merchant->setMerchantId($merchantId);

// Get the transactions from our merchant object
$transactions = $merchant->getTransactions();

// If there are no transaction for the given merchant ID, say there isn't
if (count($transactions) == 0) {
    echo 'No transactions found for merchant ' . $merchantId . "\r\n";
} else {
    echo count($transactions) . ' transactions for merchant ' . $merchantId . "\r\n";
    echo ' | Date       | Value  |' . "\r\n";
}

// echo the transaction details.
foreach($transactions as $transaction) {
    echo ' | ' . $transaction['date'] . ' | ' . $transaction['symbol'] . $transaction['value'] . " | \r\n";
}
