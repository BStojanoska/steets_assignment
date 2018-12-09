<?php

class DB {
    static private $host = '127.0.0.1';
    static private $db   = 'steets';
    static private $user = 'root';
    static private $pass = '';
    static private $charset = 'utf8mb4';
    static private $connection = null;
    
    public static function getDsn() {
        $dsn = "mysql:host=" . DB::$host . ";dbname=".DB::$db.";charset=".DB::$charset;

        return $dsn;
    }

    public static function connect() {
        if(DB::$connection != null) {
            return DB::$connection;
        } else {   
            try {
                $pdo = new PDO(DB::getDsn(), DB::$user, DB::$pass);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage(), (int)$e->getCode());
            }

            DB::$connection = $pdo;
            return DB::$connection;
        }
    }

    public static function encription( $string, $action = 'e' ) {
        $secret_key = 'secret_key';
        $secret_iv = 'secret_iv';
     
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash( 'sha256', $secret_key );
        $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
     
        if( $action == 'e' ) {
            $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
        }
        else if( $action == 'd' ){
            $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
        }
     
        return $output;
    }
}