<?php

class conexionOracle{
	
	private $user;
	private $pwd;
	private $bd;
	private $conn;
	
	function __construct($userData, $pwdData, $bdData) {
        
		$this->user=$userData;
		$this->pwd=$pwdData;
		$this->bd=$bdData;
		
    }
	
	public function conexion(){
		
		$this->conn=oci_connect($this->user, $this->pwd, $this->bd, 'AL32UTF8');
		if(!$this->conn){ 
			$e = oci_error();   
			trigger_error(htmlentities($e['message']), E_USER_ERROR);
		}else{
			//echo 'ok';
			@session_start();
			
			return $this->conn;
		}
	}
	
	
}


