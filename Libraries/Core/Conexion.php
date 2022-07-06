<?php 

/**
* 
*/
class Conexion
{
	
	public function __construct(){
		/*$connectionString = 'mysql:host='.DB_HOST.';dbname='.DB_NAME.';'.DB_CHARSET;

		try {
			
			$this->conect = new PDO($connectionString, DB_USER, DB_PASSWORD);
			$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);;
			// echo 'conexion exitosa';

		} catch (Exception $e) {
			
			$this->conect = 'Error de Conexión';
			echo 'ERROR: '.$e->getMessage();
		}*/

		$connectionString = 'oci:dbname='.DB_HOST.';'.DB_CHARSET;

		try {
			$this->conect = new PDO($connectionString, DB_USER, DB_PASSWORD);
			$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);;
			// echo 'conexion exitosa';

		} catch (Exception $e) {
			
			$this->conect = 'Error de Conexión';
			echo 'ERROR DE CONEXION: '.$e->getMessage();
		}


	}

	public function conect(){
		return $this->conect;
	}

}

?>