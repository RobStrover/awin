<?php

namespace App\Controller;

use App\Model\TransactionTable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MerchantController extends Controller
{
    private $merchantId;
    private $transactions = [];
    private $convertedTransactions = [];

    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    private function refreshTransactions()
    {
        $transactionConnection = new TransactionTable();
        $this->transactions = $transactionConnection->getTransactionsForMerchant($this->merchantId);

        $currencyConverter = new CurrencyConversionController();

        foreach ($this->transactions as $transaction) {
            if(!array_key_exists('currency', $transaction)) {
                continue;
            }
            if ($transaction['currency'] !== 'GBP') {
                $transaction['value'] = $currencyConverter->convertToGbp($transaction['currency'], $transaction['value']);
                $transaction['currency'] = 'GBP';
                $transaction['symbol'] = '£';
            }
            $this->convertedTransactions[] = $transaction;
        }
    }

    public function getTransactions()
    {
        $this->refreshTransactions();
            return array(
                "original_transactions" => $this->transactions,
                "gbp_transactions" => $this->convertedTransactions
            );
        }
}