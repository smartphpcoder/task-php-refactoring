<?php

namespace Services\CalculateCommission;
use Exception;

/**
 * Definition: Class for commission calculations
 * Author: Badri Gogilashvili
 */

class CalculateCommission
{
    private string $bin = "";
    private string $currency = "";
    private int $amount = 0;
    private $config;

    const EU_COMMISSION = 0.01;
    const NON_EU_COMMISSION = 0.02;

    public function __construct(){
        $this->config = require_once('config.php');
    }

    /**
     * @param string $file_content
     * @return array
     * @throws Exception
     */
    public function get_commission_data(string $file_content): array
    {
        if(!$file_content) throw new Exception("No data provided!");

        $explode_file_content = explode(PHP_EOL, $file_content);

        $row_decode = [];
        foreach ($explode_file_content as $row){
            $row_decode[] = json_decode($row, true);
        }

        return $row_decode;
    }

    /**
     * @param $bin
     * @param $currency
     * @param $amount
     * @return void
     */
    public function set_commissions_data($bin, $currency, $amount): void
    {
        $this->bin = $bin;
        $this->currency = $currency;
        $this->amount = $amount;
    }

    /**
     * Calculate commissions
     * @return string
     * @throws Exception
     */
    public function calculate_commission(): string
    {
        // get bin results
        $bin = $this->get_bin_results();

        // check country
        $isEu = $this->isEu($bin->country->alpha2);

        // get rates
        $amountFixed = $this->get_rates();

        // return calculations
        return round($amountFixed * ($isEu ? self::EU_COMMISSION : self::NON_EU_COMMISSION), 2) . PHP_EOL;
    }

    /**
     * Check Country
     * @param $alpha2
     * @return bool
     */
    protected function isEu($alpha2): bool
    {
        $countries = [
            'AT', 'BE', 'BG', 'CY', 'CZ',
            'DE', 'DK', 'EE', 'ES', 'FI',
            'FR', 'GR', 'HR', 'HU', 'IE',
            'IT', 'LT', 'LU', 'LV', 'MT',
            'NL', 'PO', 'PT', 'RO', 'SE',
            'SI', 'SK'
        ];

        in_array($alpha2, $countries) ? $result = True : $result = False;

        return $result;
    }

    /**
     * Get Bin Results
     * @return mixed|void
     * @throws Exception
     */
    protected function get_bin_results()
    {
        $binResults = @file_get_contents($this->config['binlist_api_credentials']['api_url'] . $this->bin);

        if (!$binResults) throw new Exception("There are no results for the specified bin");

        return json_decode($binResults);
    }

    /**
     * Get Rates
     * @return float|int
     */
    protected function get_rates(): float|int
    {
        $amountFixed = 0;

        $rate = @json_decode(
            file_get_contents(
                $this->config['exchange_rates_api_credentials']['api_url'].
                 $this->config['exchange_rates_api_credentials']['api_key']
            ), true)['rates'][$this->currency];

        if ($this->currency == 'EUR' or $rate == 0) {
            $amountFixed = $this->amount;
        }

        if ($this->currency != 'EUR' or $rate > 0) {
            $amountFixed = $this->amount / $rate;
        }
        return $amountFixed;
    }
}


