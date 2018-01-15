<?php

namespace App\Controller;

use App\Model\TransactionTable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MerchantController extends Controller
{

    // define our private variables
    private $merchantId;
    private $transactions = [];
    private $convertedTransactions = [];

    // function to set the private merchant ID
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    // function that gets all transactions for a merchant ID and calls manages conversion to GBP
    private function refreshTransactions()
    {
        // define an empty transactions and converted transactions array
        $this->transactions = [];
        $this->convertedTransactions = [];

        // use PHP League CSV to load a read connection to the CSV file
        $transactionConnection = new TransactionTable();
        // use the csv connection to fetch an array of transaction for our merchant ID
        // This also splits the currency symbol from the transaction and adds the
        // conversion value from the webservice
        $this->transactions = $transactionConnection->getTransactionsForMerchant($this->merchantId);

        // create a currency conversion object
        $currencyConverter = new CurrencyConversionController();

        foreach ($this->transactions as $transaction) {

            // Skip any transaction that we do not have a currency code for
            if(!array_key_exists('currency', $transaction)) {
                continue;
            }

            // if the transaction currency is already GBP then we do not need to convert.
            if ($transaction['currency'] !== 'GBP') {
                // if we are converting then we call the conversion function.
                $transaction['value'] = $currencyConverter->convertToGbp($transaction['currency'], $transaction['value']);
            }
            $transaction['currency'] = 'GBP';
            $transaction['symbol'] = '£';
            $this->convertedTransactions[] = $transaction;
        }
    }

    // function that calls transaction transaction refresh method
    // and returns converted transactions
    public function getTransactions()
    {
        $this->refreshTransactions();
        return $this->convertedTransactions;
    }
}