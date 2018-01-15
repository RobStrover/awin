<?php

namespace App\Tests\Util;

use App\Controller\CurrencyConversionController;
use PHPUnit\Framework\TestCase;

class CurrencyConversionControllerTest extends TestCase
{
    public function testGetCurrencyCode()
    {
        $currencyCodeObject = new CurrencyConversionController();
        $currencyCode = $currencyCodeObject->getCurrencyCode('$');

        $this->assertEquals('USD', $currencyCode);
    }

    public function testConvertToGbp()
    {
        $currencyCodeObject = new CurrencyConversionController();
        $convertedCurrency = $currencyCodeObject->convertToGbp('USD', 5000);

        $this->assertEquals(
            3650, $convertedCurrency, 'Make sure that the currency web service is running and accessible');
    }
}