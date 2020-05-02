<?php

include_once('db.php');
class Auth extends Conn{
    private $auth;
    private $user;
    private $pass;
    private $result;

    function __construct($user, $pass){
        parent::__construct();
        $user_auth = $this->getConn()->prepare("SELECT username, password FROM users WHERE username=?");

        $this->user = str_replace(' ', '', $user);
        $this->pass = $pass; 

        $user_auth->bind_param("s", $this->user);
        $user_auth->execute();

        $result = $user_auth->get_result()->fetch_assoc();
        $this->closeConn();
        
        if(isset($result)){
            $hash = $result['password'];#DB Password
            if(password_verify($this->pass, $hash)){
                $this->auth = 1; 
            }
            else{
                $this->auth = 0; 
            }
        }
        else{
            $this->auth = 0; 
        }
    }
    function getAuth(){
        return $this->auth;
    }
    function getUser(){
        return $this->user;
    }
    function getPass(){
        return $this->pass;
    }
}
?>