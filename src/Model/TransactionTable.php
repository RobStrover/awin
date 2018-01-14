<?php

namespace App\Model;

use League\Csv\Reader;
use League\Csv\Statement;

class TransactionTable
{

    public function getTransactionsForMerchant($merchantId)
    {
        $reader = $this->getCsvConnection();
        $merchantTransactions = array();

        $reader->setHeaderOffset(0);
        $records = (new Statement())->process($reader);

        foreach ($records as $record) {
            if ($record['merchant'] == $merchantId) {
                $merchantTransactions[] = $this->splitTransactionCurrency($record);
            }
        }
        return $merchantTransactions;
    }

    private function getCsvConnection()
    {
        $csv = Reader::createFromPath('data.csv', 'r');
        $csv->setDelimiter(';');
        return $csv;
    }

    private function splitTransactionCurrency($record)
    {
        $currencies = array(
            "$" => 'USD',
            "€" => 'EUR',
            "£" => 'GBP'
        );

        $currencySymbol = substr($record['value'], 0, 1);
        $transactionValue = substr($record['value'], 1);

        if (in_array($currencySymbol, $currencies)) {
            $record['currency'] = $currencies[$currencySymbol];
            $record['value'] = $transactionValue;
        }

        var_dump($record);
    }
}