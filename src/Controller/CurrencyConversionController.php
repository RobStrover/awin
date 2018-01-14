<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CurrencyConversionController extends Controller
{

    private $currencies = array(
        "$" => 'USD',
        "€" => 'EUR',
        "£" => 'GBP'
    );

    public function getCurrencyCode($currencySymbol)
    {
        if (array_key_exists($currencySymbol, $this->currencies)) {
            return $this->currencies[$currencySymbol];
        }
        return null;
    }

    public function convertToGbp($currentCurrency, $value)
    {
        $curl = curl_init();

        $url = 'localhost:8000/currency-exchange-rates/get-exchange-rate/' . $currentCurrency;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $conversionRequirement = curl_exec($curl);

        return(round($value * $conversionRequirement, 2));

    }
}