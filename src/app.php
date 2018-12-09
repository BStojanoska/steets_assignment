<?php
require './models/Prime.php';
require './models/Christmas.php';
require './models/DB.php';

$date = $_POST["year"];

if ($date != "") {
  $year = substr($date, 0, 4);
  $year = ltrim($year, '0');
  
  // ******************* Calculate Primes ****************
  $primeYears = new Prime($year);
  $primeYears = $primeYears->getPrimes();

  // ******************* Calculate Christmas Day ****************
  $christmas = new Christmas($year);
  $christmasDay = $christmas->getChristmas();

  // ******************* Connect to DB, write and display data ****************
  $dbEntries = $christmas->create();

  $result = [ 'primeYears' => $primeYears, 'christmas' => $christmasDay, 'year' => $year, 'dbEntries' => $dbEntries ];
} else {
  $result = '';
}

echo json_encode($result);