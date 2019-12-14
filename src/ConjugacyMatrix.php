<?php

namespace ForecastVerifiability;

use Exception;

/**
 * Class for constructing the conjugacy matrix
 * 
 * ConjugacyMatrix determines the name of the meteorological parameter and, 
 * in the presence of data on the justified and failed meteorological forecasts,
 * forms the conjugacy matrix for an alternative forecast for the given 
 * meteorological forecast.
 * 
 * Important! this class does not calculate the estimate for a specific single 
 * forecast, but accepts ready-made data on the number of cases in which 
 * the forecast was successful or failed.
 *
 * @author Dmytriyenko Vyacheslav <dmytriyenko.vyacheslav@gmail.com>
 */
class ConjugacyMatrix implements ConjugacyMatrixInterface
{
    /**
     * @var type string name of the weather parameter
     */
    private $weather_name;
    
    /**
     * @var type int number of cases where a meteorological phenomenon
     * was forecasted and observed
     */
    private $N11;
    
    /**
     * @var type int number of cases when a meteorological phenomenon 
     * was not forecasted but was observed
     */
    private $N12;
    
    /**
     * @var type int number of cases when a meteorological phenomenon 
     * was forecasted but not observed
     */
    private $N21;
    
    /**
     * @var type int number of cases when the meteorological phenomenon
     * was not forecasted and not observed
     */
    private $N22;
    
    /**
     * @var type int number of cases when there is evidence 
     * of a meteorological phenomenon
     */
    private $N10;
    
    /**
     * @var type int number of cases where there is a lack 
     * of meteorological phenomena
     */
    private $N20;
    
    /**
     * @var type int number of cases when the evidence of 
     * the meteorological phenomenon is forecasted
     */
    private $N01;
    
    /**
     * @var type int number of cases where the absence 
     * of a meteorological phenomenon is predicted
     */
    private $N02;
    
    /**
     * @var type int total number of weather forecast events
     */
    private $N;
    
    /**
     *
     * @var type array container for storing the spherical conjugacy matrix
     */
    private $matrix = [
        'n11' => 0,
        'n12' => 0,
        'n21' => 0,
        'n22' => 0,
        'n10' => 0,
        'n20' => 0,
        'n01' => 0,
        'n02' => 0,
        'N'   => 0,
    ];


    /**
     * @param type string $name number of cases where a meteorological phenomenon
     */
    public function __construct($name)
    {
        $this->setWeather($name);
    }

    /** 
     * @param string $weather_name number of cases where a meteorological phenomenon
     * was forecasted and observed
     * @return void
     */
    public function setWeather(string $weather_name): void
    {
        $this->weather_name = $weather_name;
    }

    /**
     * 
     * @param int $number total number of weather forecast events
     * @return void
     */
    public function setN(int $number): void
    {
        $this->N = $number;
    }

    /**
     * 
     * @param int $number number of cases when the evidence of 
     * the meteorological phenomenon is forecasted
     * @return void
     */
    public function setN01(int $number): void
    {
        $this->N01 = $number;
    }

    /**
     * 
     * @param int $number number of cases where the absence 
     * of a meteorological phenomenon is predicted
     * @return void
     */
    public function setN02(int $number): void
    {
        $this->N02 = $number;
    }

    /**
     * 
     * @param int $number number of cases when there is evidence 
     * of a meteorological phenomenon
     * @return void
     */
    public function setN10(int $number): void
    {
        $this->N10 = $number;
    }

    /**
     * 
     * @param int $nubmer number of cases where a meteorological phenomenon
     * was forecasted and observed
     * @return void
     */
    public function setN11(int $nubmer): void
    {
        $this->N11 = $nubmer;
    }

    /**
     * 
     * @param int $number number of cases when a meteorological phenomenon 
     * was not forecasted but was observed
     * @return void
     */
    public function setN12(int $number): void
    {
        $this->N12 = $number;
    }

    /**
     * 
     * @param int $number number of cases where there is a lack 
     * of meteorological phenomena
     * @return void
     */
    public function setN20(int $number): void
    {
        $this->N20 = $number;
    }

    /**
     * 
     * @param int $number number of cases when a meteorological phenomenon 
     * was forecasted but not observed
     * @return void
     */
    public function setN21(int $number): void
    {
        $this->N21 = $number;
    }

    /**
     * 
     * @param int $number number of cases when the meteorological phenomenon
     * was not forecasted and not observed
     * @return void
     */
    public function setN22(int $number): void
    {
        $this->N22 = $number;
    }
    
    /**
     * Sets the value for an individual parameter of the conjugacy matrix
     * @param string $parametr one of the component parameters of the conjugacy 
     * matrix
     * @param int $value conjugacy matrix parameter value
     * @return void
     * @throws Exception
     */
    public function setMatrix(string $parametr, int $value) : void
    {
        $matrix = $this->getMatrix();
        if (in_array($parametr, $matrix) && isset($matrix[$parametr])) {
            $this->matrix[$parametr] = $value;
        } else {
            throw new Exception('Invalid matrix parameter');
        }
    }

    /**
     * 
     * @return string name of the weather parameter
     */
    public function getWeather(): string
    {
        return $this->weather_name;
    }

    /**
     * 
     * @return int total number of weather forecast events
     */
    public function getN(): int
    {
        return $this->N;
    }

    /**
     * 
     * @return int number of cases when the evidence of 
     * the meteorological phenomenon is forecasted
     */
    public function getN01(): int
    {
        return $this->N01;
    }

    /**
     * 
     * @return int number of cases where the absence 
     * of a meteorological phenomenon is predicted
     */
    public function getN02(): int
    {
        return $this->N02;
    }

    /**
     * 
     * @return int number of cases when there is evidence 
     * of a meteorological phenomenon
     */
    public function getN10(): int
    {
        return $this->N10;
    }

    /**
     * 
     * @return int number of cases where a meteorological phenomenon
     * was forecasted and observed
     */
    public function getN11(): int
    {
        return $this->N11;
    }

    /**
     * 
     * @return int number of cases when a meteorological phenomenon 
     * was not forecasted but was observed
     */
    public function getN12(): int
    {
        return $this->N12;
    }

    /**
     * 
     * @return int number of cases where there is a lack 
     * of meteorological phenomena
     */
    public function getN20(): int
    {
        return $this->N20;
    }

    /**
     * 
     * @return int number of cases when a meteorological phenomenon 
     * was forecasted but not observed
     */
    public function getN21(): int
    {
        return $this->N21;
    }

    /**
     * 
     * @return int number of cases when the meteorological phenomenon
     * was not forecasted and not observed
     */
    public function getN22(): int
    {
        return $this->N22;
    }
    
    /**
     * 
     * @return array formed conjugacy matrix
     */
    public function getMatrix() : array
    {
        return $this->matrix;
    }
    
    /**
     * 
     * @return int number of cases when there is evidence 
     * of a meteorological phenomenon
     */
    public function calcN10() : int
    {
        return $this->getN11() + $this->getN12();
    }
    
    /**
     * 
     * @return int number of cases where there is a lack 
     * of meteorological phenomena
     */
    public function calcN20() : int
    {
        return $this->getN21() + $this->getN22();
    }
    
    /**
     * 
     * @return int number of cases when the evidence of 
     * the meteorological phenomenon is forecasted
     */
    public function calcN01() : int
    {
        return $this->getN11() + $this->getN21();
    }
    
    /**
     * 
     * @return int number of cases where the absence 
     * of a meteorological phenomenon is predicted
     */
    public function calcN02() : int
    {
        return $this->getN12() + $this->getN22();
    }
    
    /**
     * 
     * @return int total number of weather forecast events
     */
    public function calcN() : int
    {
        return $this->getN01() + $this->getN02();
    }
}
