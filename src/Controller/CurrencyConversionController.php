<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CurrencyConversionController extends Controller
{

    // have all supported currency codes in here
    private $currencies = array(
        "$" => 'USD',
        "€" => 'EUR',
        "£" => 'GBP'
    );

    // function that returns currency code if it is in the list of supported currency codes
    public function getCurrencyCode($currencySymbol)
    {
        if (array_key_exists($currencySymbol, $this->currencies)) {
            return $this->currencies[$currencySymbol];
        }
        return null;
    }

    // function that converts value to GBP with given currency code
    public function convertToGbp($currentCurrency, $value)
    {
        $curl = curl_init();

        // create a curl request to get the exchange rate for the given currency
        // this process is run for each transaction currently which would ensure up to the second
        // exchange rates but would be slower. An array of exchange rates could also be requested here at:
        // localhost:8000/currency-exchange-rates/get-exchange-rates
        $url = 'localhost:8000/currency-exchange-rates/get-exchange-rate/' . $currentCurrency;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $conversionRequirement = curl_exec($curl);

        // return the converted value rounded to the nearest 2 decimal places
        // the maths for this is (original_value x conversion_decimal)
        return(round($value * $conversionRequirement, 2));

    }
}