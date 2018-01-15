<?php

namespace App\Tests\Util;

use App\Model\TransactionTable;
use PHPUnit\Framework\TestCase;

class TransactionTableTest extends TestCase
{
    public function testGetTransactionsForMerchant()
    {
        $transactionTableObject = new TransactionTable();
        $transactions = $transactionTableObject->getTransactionsForMerchant(1);

        $this->assertInternalType('array', $transactions);
    }
}