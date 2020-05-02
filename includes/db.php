<?php
class Conn{

    private $conn;

    function __construct(){
        $creds = Array();
        $dbfile = fopen(__DIR__ ."/db.txt", "r") or die("Unable to open DB credentials file!");
        $file = fread($dbfile, filesize(__DIR__ ."/db.txt")); 
        $file = explode(PHP_EOL, $file);
        foreach($file as $i){
            $temp = explode('=', $i);
            $creds += Array($temp[0] => $temp[1]);
        }
        fclose($dbfile);
        #region DB Credentials
        $servername = $creds['servername'];
        $username = $creds['username'];
        $password = $creds['password'];
        $dbname = $creds['dbname'];
        #endregion

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