<?php

class Prime {
    protected $year;
  
    public function __construct($year) {
        $this->year = $year;
    }

    public static function isPrime($n) {
        for($x = 2; $x < $n; $x++) {
            if($n % $x == 0) {
            return false;
            }
        }
        return $n;
    }
  
    public function getPrimes() {
        $startingYear = $this->year;
        $primeYears = [];

        // Loop to find the prime numbers from the selected year
        while (count($primeYears) < 30) {
            $current = Prime::isPrime($startingYear); 
        
            // Handle the case if there are less than 30 prime years
            if ($current == 1) {
            break;
            }
        
            if ($current != false) {
                array_push($primeYears, $current);
            }
            $startingYear--;
        }
        
        return $primeYears;
    }
}