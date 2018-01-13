<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CurrencyExchangeRatesController extends Controller
{
    public function getCurrencyExchangeRates()
    {
        $exchangeRatesArray = array(
            "USD" => 0.73,
            "EUR" => 1.347,
        );

        return $this->json($exchangeRatesArray);
    }
}