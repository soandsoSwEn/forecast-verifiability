# Weather forecast verifiability - PHP library for evaluating the success of alternative weather forecasts

Forecast success is characterized by indicators called meteorological forecast success criteria. Success criteria are quantitative estimates of the compliance of actual and predictive weather characteristics.

Setup
-----

Add the library to your `composer.json` file in your project:

```javascript
{
  "require": {
      "soandso/forecast-verifiability": "0.*"
  }
}
```

Use [composer](http://getcomposer.org) to install the library:

```bash
$ php composer.phar install
```

Composer will install Forecast verifiability inside your vendor folder. Then you can add the following to your
.php files to use the library with Autoloading.

```php
require_once(__DIR__ . '/vendor/autoload.php');
```

You can also use composer on the command line to require and install Forecast verifiability:

```bash
$ php composer.phar require soandso/forecast-verifiability:0.*
```

## Minimum Requirements
 * PHP 7

## Description

At the beginning, it is necessary to form a conjugacy matrix. To do this, you need to create an object of the ConjugacyMatrix class by giving the parameter the name of the meteorological value for which the assessment, e.g. wind:

```php
$matrix = new ConjugacyMatrix('wind');
```
Next, fill in the values ​​of the elements of the conjugacy matrix

```php
$matrix->setN11(104);
$matrix->setN12(12);
$matrix->setN21(58);
$matrix->setN22(369);
$matrix->setN10($matrix->calcN10());
$matrix->setN20($matrix->calcN20());
$matrix->setN01($matrix->calcN01());
$matrix->setN02($matrix->calcN02());
$matrix->setN($matrix->calcN());
$matrix->setMatrix('n11', $matrix->getN11());
$matrix->setMatrix('n12', $matrix->getN12());
$matrix->setMatrix('n21', $matrix->getN21());
$matrix->setMatrix('n22', $matrix->getN22());
$matrix->setMatrix('n10', $matrix->getN10());
$matrix->setMatrix('n20', $matrix->getN20());
$matrix->setMatrix('n01', $matrix->getN01());
$matrix->setMatrix('n02', $matrix->getN02());
$matrix->setMatrix('N', $matrix->getN());
```

Taken designation of conjugacy matrix elements

|                                           | Forecasted manifestation of a phenomenon | Forecasted absence of a phenomenon | Total number of cases |
|-------------------------------------------|------------------------------------------|------------------------------------|-----------------------|
| Observability of a phenomenon is observed |                    n11                   |                  n12               |           n10         |
| There is a lack of a phenomena            |                    n21                   |                  n22               |           n20         |
| Total number of cases                     |                    n01                   |                  n02               |            N          |


After the conjugacy matrix is ​​constructed, individual criteria can be calculated.
To do this, first create an object of the CriteriaForecast class by giving it the conjugacy matrix object

```php
$criteria = new CriteriaForecast($matrix);
```

Calculation general forecast accuracy.
Sets the name of the criterion (necessary for generating output)ю

```php
$criteria->setNameCriteria('General forecast accuracy');
```

Valid list of criteria:
```bash
'General forecast accuracy'
'Forecast accuracy criterion'
'Forecast reliability criterion'
'Climate entropy'
'Conditional entropy'
'Amount of forecaste information'
'Information relation'
```

Sets criterion units

```php
$criteria->setUnit('%');
```

Value calculation

```php
$criteria->calclateP();
```

To generate a general conclusion (many different criteria can be calculated for one task), you need to add the result to a general container for output.

```php
$criteria->setValueCriteria($criteria->getNameCriteria(), $criteria->getP(), $criteria->getUnit());
```

Calculation forecast accuracy criterion.
```php
$criteria->setNameCriteria('Forecast accuracy criterion');
$criteria->calculateQ();
$criteria->setValueCriteria($criteria->getNameCriteria(), $criteria->getQ());
```

Calculation forecast reliability criterion.
```php
$criteria->setNameCriteria('Forecast reliability criterion');
$criteria->calculateH();
$criteria->setValueCriteria($criteria->getNameCriteria(), $criteria->getH());
```

Calculation climate entropy.
```php
$criteria->setNameCriteria('Climate entropy');
$criteria->calculateHf();
$criteria->setValueCriteria($criteria->getNameCriteria(), $criteria->getHf());
```

Calculation conditional entropy.
```php
$criteria->setNameCriteria('Conditional entropy');
$criteria->calculateHp();
$criteria->setValueCriteria($criteria->getNameCriteria(), $criteria->getHp());
```

Calculation amount of forecaste information.
```php
$criteria->setNameCriteria('Amount of forecaste information');
$criteria->calculateI();
$criteria->setValueCriteria($criteria->getNameCriteria(), $criteria->getI());
```

Calculation information relation.
```php
$criteria->setNameCriteria('Information relation');
$criteria->calculateV();
$criteria->setValueCriteria($criteria->getNameCriteria(), $criteria->getV());
```

Get all values ​​of criteria:
```php
$criteria->getValueCriteries();
```

Get the value of a criterion by naming it:
```php
$criteria->getValueCriteria('General forecast accuracy');
```

The output of the output function can be an array of the following form:

```bash
Array
(
    [General forecast accuracy] => Array
        (
            [value] => 87.108655616943
            [unit] => %
        )

    [Forecast accuracy criterion] => Array
        (
            [value] => 0.76072034240491
            [unit] => 
        )

    [Forecast reliability criterion] => Array
        (
            [value] => 0.66472611802064
            [unit] => 
        )

   ...........................

)
```

Standards
---------

Grouping conforms to the following standards:

 * PSR-2  - Basic coding standard (https://www.php-fig.org/psr/psr-2/)
 * PSR-4  - Autoloader (https://www.php-fig.org/psr/psr-4/)
 * PSR-12 - Extended coding style guide (https://www.php-fig.org/psr/psr-12/)

License
-------

Grouping is licensed under the GPLv2 License (https://www.gnu.org/licenses/old-licenses/gpl-2.0.html).
