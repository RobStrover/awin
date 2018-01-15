# CSV Currency Conversion with Mock Web Service
  ## Setup
  Clone the project and run composer install in the project folder  
    `$ git clone https://github.com/RobStrover/awin.git`  
    `$ cd awin`  
    `$ composer install`
  ## Usage
  Then make sure the currency web service works, run the Symphony Web Server.  
  `$ php bin/console server:run`
  
  You can test that the webservice is running with the following [link](http://localhost:8000/currency-exchange-rates/get-exchange-rates "List all exchange rates").
  This should show the two available currencies and their exchange rates vs GBP.
  
  To run the script, use the following command:  
  `$ php merchantReport.php {merchant_number}`  
  Example:  
  `$ php merchantReport.php 1`  
  which returns the following output:
  
  4 transactions for merchant 1  
    | Date       | Value  |  
    | 01/05/2010 | £50.00 |  
    | 02/05/2010 | £11.04 |  
    | 02/05/2010 | £1.35 |  
    | 03/05/2010 | £16.83 | 
## Automated Tests
A few PHPUnit tests have been included in this project. Run them with:  
`$ ./bin/phpunit`