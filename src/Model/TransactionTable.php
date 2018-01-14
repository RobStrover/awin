<?php

namespace App\Model;

use League\Csv\Reader;
use League\Csv\Statement;

class TransactionTable
{
    private function getCsvConnection()
    {
        $csv = Reader::createFromPath('data.csv', 'r');
        $csv->setDelimiter(';');
        return $csv;
    }

    public function getTransactionsForMerchant($merchantId)
    {
        $reader = $this->getCsvConnection();
        $merchantTransactions = array();

        $reader->setHeaderOffset(0);
        $records = (new Statement())->process($reader);

        foreach ($records as $record) {
            if ($record['merchant'] == $merchantId) {
                $merchantTransactions[] = $record;
            }
        }
        return $merchantTransactions;
    }
}