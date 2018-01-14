<?php

namespace App\Model;

use App\Controller\CurrencyConversionController;
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
                $merchantTransactions[] = $record;
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
        $currencySymbol = substr($record['value'], 0, 1);
        $transactionValue = substr($record['value'], 1);

        $currencyConverter = new CurrencyConversionController();
        $currencyCode = $currencyConverter->getCurrencyCode($currencySymbol);

        if ($currencyCode !== null) {
            $record['currency'] = $currencyCode;
            $record['value'] = $transactionValue;
        }

        return $record;
    }
}