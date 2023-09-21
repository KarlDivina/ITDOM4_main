<?php
//include connection file
include_once("inc/config.php");

$params = $columns = $totalRecords = $data = array();

$params = $_REQUEST;

$columns = array(
    0 => 'customer_id',
    1 => 'customer_name',
    2 => 'payment_date',
    3 => 'paid_amount',
    4 => 'payment_method'
);
?>