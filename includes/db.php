<?php
class Conn{

    private $conn;

    function __construct(){
        #DB creds from env variables  configured from Heroku
        $servername = getenv('servername');
        $username = getenv('username');
        $password = getenv('password');
        $dbname = getenv('dbname');

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