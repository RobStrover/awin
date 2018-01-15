<?php

namespace App\Model;

use App\Controller\CurrencyConversionController;
use League\Csv\Reader;
use League\Csv\Statement;

class TransactionTable
{

    // function that returns array of transactions for given merchant ID
    public function getTransactionsForMerchant($merchantId)
    {
        // get our league csv connection to the csv file
        $reader = $this->getCsvConnection();

        // define an empty array of merchant transactions
        $merchantTransactions = array();

        // set the header offset to 0, meaning that the first row in the csv file is not included in the results
        $reader->setHeaderOffset(0);
        $records = (new Statement())->process($reader);

        // call the function to split the transaction currency symbol from the transaction value
        // and add the transaction the the merchant transactions if the merchant ID is correct
        foreach ($records as $record) {
            if ($record['merchant'] == $merchantId) {
                $record = $this->splitTransactionCurrency($record);
                $merchantTransactions[] = $record;
            }
        }
        // return the array of transactions
        return $merchantTransactions;
    }

    // function that creates a league csv reader connection
    private function getCsvConnection()
    {
        // create a reader connection to the csv file
        $csv = Reader::createFromPath('data.csv', 'r');

        // set our delimiter and enclosure characters
        $csv->setDelimiter(';');
        $csv->setEnclosure('"');
        return $csv;
    }


    // function that splits the currency symbol from the transaction value
    private function splitTransactionCurrency($record)
    {
        // symbol regex (select all characters until the first number) The code for the symbols is often
        // longer than a single character due to encoding
        $symbolRegex = "/^\D+/";

        // value regex (select the numbers in the string)
        $valueRegex = "([0-9]*\.[0-9]+|[0-9]+)";

        // get matches for the currency symbol convert the symbols to UTF-8
        preg_match($symbolRegex, $record['value'], $currencySymbol);
        $currencySymbol = mb_convert_encoding($currencySymbol[0], "UTF-8", "auto");

        // get the matches for the transaction value
        preg_match($valueRegex, $record['value'], $transactionValue);
        $transactionValue = $transactionValue[0];

        // get a currency conversion object and call the getCurrencyCode method
        $currencyConverter = new CurrencyConversionController();
        $currencyCode = $currencyConverter->getCurrencyCode($currencySymbol);

        // if we have a currency code then add it and the value to the record array
        if ($currencyCode !== null) {
            $record['currency'] = $currencyCode;
            $record['value'] = $transactionValue;
        }

        return $record;
    }
}