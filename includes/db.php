<?php
// This file can include functions to load data from the CSV files
function load_users($filename) {
    return array_map('str_getcsv', file($filename));
}

function load_games($filename) {
    return array_map('str_getcsv', file($filename));
}
?>
