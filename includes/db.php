<?php
class Conn{

    private $conn;

    function __construct(){
        #DB creds from env variables  configured from Heroku
        $servername = getenv('db_server');
        $username = getenv('db_user');
        $password = getenv('db_pass');
        $dbname = getenv('db_name');

        $this->conn = new mysqli($servername, $username, $password, $dbname);
        if ($this->conn->connect_error)
            die("Connection failed: " . $this->conn->connect_error);
    }
    function getConn(){
        return $this->conn;
    }
    function closeConn(){
        $this->conn->close();
    }
}

?>