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
                $record = $this->splitTransactionCurrency($record);

                if ($record['currency'] !== 'GBP') {
                    // currency conversion code here
                }

                $merchantTransactions = $record;
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

        if (array_key_exists($currencySymbol, $currencies)) {
            $record['currency'] = $currencies[$currencySymbol];
            $record['value'] = $transactionValue;
        }

        return $record;
    }
}