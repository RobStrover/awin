<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GbpCurrencyExchangeRatesController extends Controller
{
    // define supported currency codes with their conversion decimals
    private $exchangeRatesArray = array(
        "USD" => 0.73,
        "EUR" => 1.347,
    );

    // function that returns json encoded array of all exchange rates
    public function getCurrencyExchangeRates()
    {
        return $this->json($this->exchangeRatesArray);
    }

    // function that returns requested json encoded exchange rate decimal if it exists
    public function getCurrencyExchangeRate($currency)
    {
        if (array_key_exists($currency, $this->exchangeRatesArray)) {
            return $this->json($this->exchangeRatesArray[$currency]);
        }
        return $this->json(false);
    }
}