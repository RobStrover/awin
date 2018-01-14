<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GbpCurrencyExchangeRatesController extends Controller
{

    private $exchangeRatesArray = array(
        "USD" => 0.73,
        "EUR" => 1.347,
    );

    public function getCurrencyExchangeRates()
    {
        return $this->json($this->exchangeRatesArray);
    }

    public function getCurrencyExchangeRate($currency)
    {
        if (array_key_exists($currency, $this->exchangeRatesArray)) {
            return $this->json($this->exchangeRatesArray[$currency]);
        }
        return $this->json(false);
    }
}