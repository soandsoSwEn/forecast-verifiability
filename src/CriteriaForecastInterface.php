<?php

namespace ForecastVerifiability;

/**
 * This interface must be implemented by a class that calculates forecast 
 * success criteria.
 * The interface describes the possibilities for calculating and forming 
 * various criteria for the success of forecasts.
 * 
 * Criteria are a measure of the relationship between actual weather
 * and its forecast.
 * 
 * @author Dmytriyenko Vyacheslav <dmytriyenko.vyacheslav@gmail.com>
 */
interface CriteriaForecastInterface
{
    /**
     * Sets the name of the current criterion for the success of prognosis, 
     * for which the calculation will be made
     * @param string $name name of a forecast success criterion
     * @return void
     */
    public function setNameCriteria(string $name) : void;
    
    /**
     * Sets the value of the success criterion for the meteorological forecast
     * and its unit of measurement by its name
     * 
     * @param float $name name of the criterion for assessing the success
     * of the forecast
     * @param float $value forecast success criterion value
     * @param string $unit unit of forecast success criterion
     * @return void
     */
    public function setValueCriteria(string $name, float $value, string $unit = null) : void;
    
    /**
     * Returns the name of the current criterion for which the calculation is carried out
     * 
     * @return string name of a forecast success criterion
     */
    public function getNameCriteria() : string;
    
    /**
     * Returns the value of the success criterion for prognosis by its name
     * 
     * @return array value and unit of a forecast success criterion
     */
    public function getValueCriteria(string $name) : array;
    
    /**
     * Returns all criteria that have been calculated
     * 
     * @return array all criteria that were calculated
     */
    public function getValueCriteries() : array;
}
