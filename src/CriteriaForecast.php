<?php

namespace ForecastVerifiability;

use Exception;

/**
 * CriteriaForecast Calculates Weather Forecast Success Criteria
 * 
 * 
 * In this class such criteria are implemented:
 * 
 * - General forecast accuracy
 *  This criterion is the ratio of the number of forecasts that came true 
 *  to their total number.
 * 
 *                             p=n11+n22/N*100%
 * 
 * - Forecast accuracy criterion
 *  It characterizes part of the forecasts that came true, with a known 
 *  repeatability of the presence or absence of a meteorological phenomenon
 * 
 *                            Q=1-(n12/n10+n21/n20)
 *  The value of Q varies from -1 (all predogonos erroneous) to +1 
 *  (forecasts at the ideal level). When Q = 0, the forecast quality 
 *  corresponds to the level of a random forecast.
 * 
 * - Forecast reliability criterion
 *  The criterion characterizes an increase in the general justification 
 *  of methodological forecasts in comparison with random forecasts with 
 *  the maximum possible value.
 * 
 *                           H=p-p_comp/100-p_comp
 * 
 * - Climate entropy
 *  This criterion characterizes the uncertainty of the event of 
 *  a meteorological phenomenon.
 * 
 *                    H(F)=-(n10/N*lg(n10/N)+n20/N*lg(n20/N))
 * 
 * - Conditional entropy
 *  This criterion is a measure of the uncertainty of the occurrence of 
 *  an event of a forecasted meteorological phenomenon or phase of the weather.
 * 
 *  H(P)=-[n01/N*(n11/n01*lg(n11/n01)+n21/n01*lg(n21/n01))+n02/N*(n12/n02*lg(n12/n02)+n22/n02*lg(n22/n02))]
 * 
 * - Amount of forecaste information
 *  The criterion is the difference between the values ​​of the 
 *  unconditional (climatic) entropy and conditional entropy.
 * 
 *                                 I=H(F)-H(P)
 * 
 * - Information relation
 *  The criterion indicates how much of the uncertainty of climate forecasts 
 *  is eliminated using this forecasting method.
 * 
 *                                V=1-H(P)/H(F)
 * 
 *
 * @author Dmytriyenko Vyacheslav <dmytriyenko.vyacheslav@gmail.com>
 */
final class CriteriaForecast implements CriteriaForecastInterface
{
    /**
     * @var type \ForecastVerifiability\ConjugacyMatrix
     */
    private $source_data;
    
    /**
     * @var type string name of the current criterion for the success of prognosis, 
     * for which the calculation will be made
     */
    private $name_criteria;
    
    /**
     * @var type array all criteria available for calculation
     */
    private $criteries = [
        'General forecast accuracy' => null,
        'Forecast accuracy criterion' => null,
        'Forecast reliability criterion' => null,
        'Climate entropy' => null,
        'Conditional entropy' => null,
        'Amount of forecaste information' => null,
        'Information relation' => null,
    ];
    
    /**
     * @var type all criteria that were calculated
     */
    private $calculated_criteria = [];

    /**
     * @var type float general forecast accuracy
     */
    private $p;
    
    /**
     * @var type float forecast accuracy criterion
     */
    private $Q;
    
    /**
     * @var type float forecast reliability criterion
     */
    private $H;
    
    /**
     * @var type float climate entropy
     */
    private $H_F;
    
    /**
     * @var type float conditional entropy
     */
    private $H_P;
    
    /**
     * @var type float amount of forecaste information
     */
    private $I;
    
    /**
     * @var type float information relation
     */
    private $V;
    
    /**
     * @var type string unit of forecast success criterion
     */
    private $unit;
    
    /**
     * @var type array all possible units for these criteria
     */
    private $units = [
        '%'
    ];

    /**
     * 
     * @param \ForecastVerifiability\ConjugacyMatrix $data
     */
    public function __construct(ConjugacyMatrix $data)
    {
        $this->source_data = $data;
    }
    
    /**
     * Sets name of a forecast success criterion
     * 
     * valid list of criteria:
     * 'General forecast accuracy'
     * 'Forecast accuracy criterion'
     * 'Forecast reliability criterion'
     * 'Climate entropy'
     * 'Conditional entropy'
     * 'Amount of forecaste information'
     * 'Information relation'
     * 
     * 
     * @param string $name name of the current criterion for the success 
     * of prognosis, for which the calculation will be made
     * @return void
     */
    public function setNameCriteria(string $name): void
    {
        $criteries = $this->criteries;
        if ($this->in_key_array($name, $criteries)) {
            $this->name_criteria = $name;
        } else {
            throw new Exception('Criterion with such a name does not exist');
        }
    }
    
    /**
     * 
     * @param type string $name unit name
     * @return void
     * @throws Exception
     */
    public function setUnit(string $name) : void
    {
        if (in_array($name, $this->units)) {
            $this->unit = $name;
        } else {
            throw new Exception('This unit is not available');
        }
    }

    /**
     * Sets the value of the success criterion for the meteorological forecast
     * and its unit of measurement by its name
     * 
     * @param string $name name of the criterion for assessing the success
     * of the forecast
     * @param float $value forecast success criterion value
     * @param string $unit unit of forecast success criterion
     * @return void
     */
    public function setValueCriteria(string $name, float $value, string $unit = null): void
    {
        $criteries = $this->criteries;
        if ($this->in_key_array($name, $criteries)) {
            $this->calculated_criteria[$name]['value'] = $value;
            $this->calculated_criteria[$name]['unit'] = $unit;
        } else {
            throw new Exception('Criterion with such a name does not exist');
        }
        $this->dataReset();
    }
    
    /**
     * 
     * @param float $data general forecast accuracy
     * @return void
     */
    public function setP(float $data) : void
    {
        $this->p = $data;
    }
    
    /**
     * 
     * @param float $data forecast accuracy criterion
     * @return void
     */
    public function setQ(float $data) : void
    {
        $this->Q = $data;
    }
    
    /**
     * 
     * @param float $data forecast reliability criterion
     * @return void
     */
    public function setH(float $data) : void
    {
        $this->H = $data;
    }
    
    /**
     * 
     * @param float $data climate entropy
     * @return void
     */
    public function setHf(float $data) : void
    {
        $this->H_F = $data;
    }
    
    /**
     * 
     * @param float $data conditional entropy
     * @return void
     */
    public function setHp(float $data) : void
    {
        $this->H_P = $data;
    }
    
    /**
     * 
     * @return float information relation
     */
    public function getV() : float
    {
        return $this->V;
    }

    /**
     * 
     * @param float $data amount of forecaste information
     * @return void
     */
    public function setI(float $data) : void
    {
        $this->I = $data;
    }
    
    /**
     * 
     * @param float $data information relation
     * @return void
     */
    public function setV(float $data) : void
    {
        $this->V = $data;
    }

    /**
     * @return string name of the current criterion for which the calculation 
     * is carried out
     */
    public function getNameCriteria(): string
    {
        return $this->name_criteria;
    }
    
    /**
     * 
     * @return string unit name
     */
    public function getUnit() : string
    {
        return $this->unit;
    }
    
    /**
     * Return value general forecast accuracy
     * @return float general forecast accuracy
     */
    public function getP() : float
    {
        return $this->p;
    }
    
    /**
     * Return value forecast accuracy criterion
     * @return float forecast accuracy criterion
     */
    public function getQ() : float
    {
        return $this->Q;
    }
    
    /**
     * 
     * @return float forecast reliability criterion
     */
    public function getH() : float
    {
        return $this->H;
    }
    
    /**
     * 
     * @return float climate entropy
     */
    public function getHf() : float
    {
        return $this->H_F;
    }
    
    /**
     * 
     * @return float conditional entropy
     */
    public function getHp() : float
    {
        return $this->H_P;
    }
    
    /**
     * 
     * @return float amount of forecaste information
     */
    public function getI() : float
    {
        return $this->I;
    }

    /**
     * Returns the value of the success criterion for prognosis by its name
     * @param string $name name of the criterion for assessing the success of the forecast
     * @return array value and unit of a forecast success criterion
     * @throws Exception
     */
    public function getValueCriteria(string $name): array
    {
        $criteries = $this->criteries;
        if (in_array($name, $criteries) && isset($criteries[$name])) {
            return $this->criteries[$name];
        } else {
            throw new Exception('Criterion with such a name does not exist');
        }
    }

    /**
     * Returns all criteria that have been calculated
     * @return array all criteria for assessing the success 
     * of a forecast: name value and unit of measurement
     */
    public function getValueCriteries(): array
    {
        return $this->calculated_criteria;
    }
    
    /**
     * Checks if a key with the name exists in the associative array
     * @param type $needle The searched value
     * @param type $array source array in which the search is performed
     * @return boolean
     */
    public function in_key_array($needle, $array) : bool
    {
        foreach ($array as $key => $value) {
            if(strcmp($key, $needle) == 0) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Resets temporary data
     * @return void
     */
    public function dataReset() : void
    {
        $this->name_criteria = null;
        $this->p = null;
        $this->unit = null;
    }

    /**
     * Calculation value general forecast accuracy
     * @return void
     * @throws Exception
     */
    public function calclateP() : void
    {
        if (!isset($this->source_data)) {
            throw new Exception('Missing contingency matrix data');
        }
        $data = $this->source_data->getMatrix();
        //$this->setP((($data['n11']+$data['n22'])-($data['n12']+$data['21']))/$data['N']*100);
        $this->setP(($data['n11']+$data['n22'])/$data['N']*100);
    }
    
    /**
     * Calculation value forecast accuracy criterion
     * @return void
     * @throws Exception
     */
    public function calculateQ() : void
    {
        if (!isset($this->source_data)) {
            throw new Exception('Missing contingency matrix data');
        }
        $data = $this->source_data->getMatrix();
        $this->setQ(1-($data['n12']/$data['n10']+$data['n21']/$data['n20']));
    }
    
    /**
     * Calculation value forecast reliability criterion
     * @return void
     * @throws Exception
     */
    public function calculateH() : void
    {
        if (!isset($this->source_data)) {
            throw new Exception('Missing contingency matrix data');
        }
        $data = $this->source_data->getMatrix();
        $p_rand = ($data['n01']*$data['n10']+$data['n20']*$data['n02'])/pow($data['N'], 2)*100;
        $this->calclateP();
        $p = $this->getP();
        $this->setH(($p-$p_rand)/(100-$p_rand));
    }
    
    /**
     * Calculation value climate entropy
     * @return void
     * @throws Exception
     */
    public function calculateHf() : void
    {
        if (!isset($this->source_data)) {
            throw new Exception('Missing contingency matrix data');
        }
        $data = $this->source_data->getMatrix();
        $this->setHf(-($data['n10']/$data['N']*log10($data['n10']/$data['N'])+$data['n20']/$data['N']*log10($data['n20']/$data['N'])));
    }
    
    /**
     * Calculate value conditional entropy
     * @return void
     * @throws Exception
     */
    public function calculateHp() : void
    {
        if (!isset($this->source_data)) {
            throw new Exception('Missing contingency matrix data');
        }
        $data = $this->source_data->getMatrix();
        $this->setHp(-(($data['n01']/$data['N'])*($data['n11']/$data['n01']*log10($data['n11']/$data['n01'])+$data['n21']/$data['n01']*log10($data['n21']/$data['n01']))+$data['n02']/$data['N']*($data['n12']/$data['n02']*log10($data['n12']/$data['n02'])+$data['n22']/$data['n02']*log10($data['n22']/$data['n02']))));
    }
    
    /**
     * Calculate amount of forecaste information
     * @return void
     * @throws Exception
     */
    public function calculateI() : void
    {
        if (!isset($this->source_data)) {
            throw new Exception('Missing contingency matrix data');
        }
        $data = $this->source_data->getMatrix();
        $this->calculateHf();
        $Hf = $this->getHf();
        $this->calculateHp();
        $Hp = $this->getHp();
        $this->setI($Hf-$Hp);
    }
    
    /**
     * Calculation value information relation
     * @return void
     * @throws Exception
     */
    public function calculateV() : void
    {
        if (!isset($this->source_data)) {
            throw new Exception('Missing contingency matrix data');
        }
        $this->calculateHf();
        $Hf = $this->getHf();
        $this->calculateHp();
        $Hp = $this->getHp();
        $this->setV(1-($Hp/$Hf));
    }
}
