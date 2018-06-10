<?php

class AvitoDB
{
    private $_host;
    private $_db;
    private $_name;
    private $_pass;
    private $_charset;
    const OPT = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    private $_pdo;
    public function __construct($host, $db, $name, $pass, $charset){
        $this->_host = $host;
        $this->_db = $db;
        $this->_name = $name;
        $this->_pass = $pass;
        $this->_charset = $charset;
        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;charset=%s",
            $this->_host,
            $this->_db,
            $this->_chatset
        );
        $this->_pdo = new PDO(
            $dsn,
            $this->_user,
            $this->_pass,
            OPT
        );
    }
    
    public function get_ads(){

    }
    public function set_ads(){

    }


}   



