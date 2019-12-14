<?php

namespace ForecastVerifiability;

/**
 * ConjugacyMatrixInterface is an interface that must be implemented
 * in the conjugacy matrix formation class
 * 
 * The conjugacy matrix is ​​a form of presentation of the implementations of 
 * the forecast of the meteorological parameter by gradations
 * 
 * 
 * In the case of alternative forecasts of such gradations, there are two
 * All cases of forecasting metrological values ​​are divided into four groups:
 * 
 * n11 - the number of cases where a meteorological phenomenon was forecasted 
 * and observed;
 * 
 * n12 - the number of cases when a meteorological phenomenon was not forecasted
 * but was observed;
 * 
 * n21 - the number of cases when a meteorological phenomenon was forecasted 
 * but not observed;
 * 
 * n22 - the number of cases when the meteorological phenomenon was not 
 * forecasted and not observed.
 * 
 * 
 * This conjugacy matrix is ​​the basis for calculating all the success criteria 
 * for metrological forecasts.
 * Conjugacy matrices are constructed for both methodological and standard 
 * forecasts - climatological, inertial and random.
 * 
 * @author Dmytriyenko Vyacheslav <dmytriyenko.vyacheslav@gmail.com>
 */
interface ConjugacyMatrixInterface
{
    /**
     * Sets the name of the weather parameter
     * @param string $weather_name name of the weather parameter, 
     * e.g. precipitation, wind, ice
     * @return void
     */
    public function setWeather(string $weather_name) : void;
    
    /**
     * 
     * @param int $nubmer number of cases where a meteorological phenomenon
     * was forecasted and observed
     * @return void
     */
    public function setN11(int $nubmer) : void;
    
    /**
     * 
     * @param int $number number of cases when a meteorological phenomenon 
     * was not forecasted but was observed
     * @return void
     */
    public function setN12(int $number) : void;
    
    /**
     * 
     * @param int $number number of cases when a meteorological phenomenon 
     * was forecasted but not observed
     * @return void
     */
    public function setN21(int $number) : void;
    
    /**
     * 
     * @param int $number number of cases when the meteorological phenomenon
     * was not forecasted and not observed
     * @return void
     */
    public function setN22(int $number) : void;
    
    /**
     * 
     * @param int $number number of cases when there is evidence 
     * of a meteorological phenomenon
     * @return void
     */
    public function setN10(int $number): void;
    
    /**
     * 
     * @param int $number number of cases where there is a lack 
     * of meteorological phenomena
     * @return void
     */
    public function setN20(int $number) : void;
    
    /**
     * 
     * @param int $number number of cases when the evidence of 
     * the meteorological phenomenon is forecasted
     * @return void
     */
    public function setN01(int $number) : void;
    
    /**
     * 
     * @param int $number number of cases where the absence 
     * of a meteorological phenomenon is predicted
     * @return void
     */
    public function setN02(int $number) : void;
    
    /**
     * 
     * @param int $number total number of weather forecast events
     * @return void
     */
    public function setN(int $number) : void;
    
    /**
     * 
     * @return string name of the weather parameter
     */
    public function getWeather() : string;
    
    /**
     * 
     * @return int number of cases where a meteorological phenomenon
     * was forecasted and observed
     */
    public function getN11() : int;
    
    /**
     * 
     * @return int number of cases when a meteorological phenomenon 
     * was not forecasted but was observed
     */
    public function getN12() : int;
    
    /**
     * 
     * @return int number of cases when a meteorological phenomenon 
     * was forecasted but not observed
     */
    public function getN21() : int;
    
    /**
     * 
     * @return int number of cases when the meteorological phenomenon
     * was not forecasted and not observed
     */
    public function getN22() : int;
    
    /**
     * 
     * @return int number of cases when there is evidence 
     * of a meteorological phenomenon
     */
    public function getN10() : int;
    
    /**
     * 
     * @return int number of cases where there is a lack 
     * of meteorological phenomena
     */
    public function getN20() : int;
    
    /**
     * 
     * @return int number of cases when the evidence of 
     * the meteorological phenomenon is forecasted
     */
    public function getN01() : int;
    
    /**
     * 
     * @return int number of cases where the absence 
     * of a meteorological phenomenon is predicted
     */
    public function getN02() : int;
    
    /**
     * 
     * @return int total number of weather forecast events
     */
    public function getN() : int;
}
