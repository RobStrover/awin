<?php

namespace App\Controller;

use App\Model\TransactionTable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MerchantController extends Controller
{
    private $merchantId;
    private $transactions;
    private $convertedTransactions;

    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    private function refreshTransactions()
    {
        $transactionConnection = new TransactionTable();
        $this->transactions = $transactionConnection->getTransactionsForMerchant($this->merchantId);
    }

    public function getTransactions()
    {
        $this->refreshTransactions();
        return $this->transactions;
    }

    public function getConvertedTransactions()
    {
        $this->refreshTransactions();
        return $this->convertedTransactions;
    }
}