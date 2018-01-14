<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MerchantController extends Controller
{
    private $merchantId;
    private $transactions;
    private $convertedTransactions;

    public function setMerchant($merchantId)
    {
        $this->merchantId = $merchantId;

    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function getConvertedTransactions()
    {
        return $this->convertedTransactions;
    }
}