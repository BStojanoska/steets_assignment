<?php

class Christmas {
    protected $year;
    
    public function __construct($year) {
        $this->year = $year;
    }

    public function getDay() {
        $timestamp = strtotime($this->year.'-12-25');
        $day = date('D', $timestamp);
        $day = date('l', $timestamp);

        return [ 'day' => $day, 'timestamp' => $timestamp ];
    }

    public function getChristmas() {
        $getDay = $this->getDay();

        // If Christmas hasn't passed, return sentence with present tense, if passed with past tense
        if ($getDay['timestamp'] < strtotime('today')) {
            $christmas = ' was on ' . $getDay['day'];
        } else {
            $christmas = ' is on ' . $getDay['day'];
        }

        return $christmas;
    }


    public static function is_written($year, $PDO) {
        $stmt = $PDO->prepare("SELECT * FROM dates WHERE `year`=? LIMIT 1");
        $stmt->execute([DB::encription($year)]);
        $yearExists = $stmt->fetchColumn();
        
        if (!empty($yearExists)) {
            return true;
        }
        return false;
    }

    public function create() {
        $PDO = DB::connect();
        $dbYears = [];

        if (!(Christmas::is_written($this->year, $PDO))) {
            $getDay = $this->getDay();

            $sql = "INSERT INTO dates (`year`, `day`) VALUES (?, ?)";
            $PDO->prepare($sql)->execute([DB::encription($this->year), DB::encription($getDay['day'])]);       
                
        }

        $stmt = $PDO->query("SELECT * FROM dates");
        foreach ($stmt as $row) {
            array_push($dbYears, ['year' => DB::encription($row['year'], 'd'), 'day' => DB::encription($row['day'], 'd')]);
        }
        return $dbYears;
    }
}