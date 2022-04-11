<?php

use Services\CalculateCommission\CalculateCommission;

require 'vendor/autoload.php';

// initialize the commission class
$commission = new CalculateCommission();

// get input data
try {
    $data = (array) $commission->get_commission_data(file_get_contents($argv[1]));

    // results
    $results = [];

    // loop through the data and send to commission class for the calculation
    foreach ($data as $row){
        $commission->set_commissions_data($row["bin"], $row["currency"], $row["amount"]);
        $results[] = $commission->calculate_commission();
    }

    echo implode("", $results);

} catch (Exception $e) {

    echo $e->getMessage();

}



