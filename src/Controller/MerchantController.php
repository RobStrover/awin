<?php

namespace App\Controller;

use App\Model\TransactionTable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MerchantController extends Controller
{
    private $merchantId;
    private $transactions;

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
}