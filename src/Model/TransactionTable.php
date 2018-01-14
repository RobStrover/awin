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
        $csv->setEnclosure('"');
        return $csv;
    }

    private function splitTransactionCurrency($record)
    {
        $transactionValue = substr($record['value'], 1);

        $symbolRegex = "/^\D+/";
        $valueRegex = "([0-9]*\.[0-9]+|[0-9]+)";

        preg_match($symbolRegex, $record['value'], $currencySymbol);
        $currencySymbol = mb_convert_encoding($currencySymbol[0], "UTF-8", "auto");

        preg_match($valueRegex, $record['value'], $transactionValue);
        $transactionValue = $transactionValue[0];

        $currencyConverter = new CurrencyConversionController();
        $currencyCode = $currencyConverter->getCurrencyCode($currencySymbol);

        if ($currencyCode !== null) {
            $record['currency'] = $currencyCode;
            $record['value'] = $transactionValue;
        }

        return $record;
    }
}