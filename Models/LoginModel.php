<?php 

/**
* 
*/
class LoginModel extends Mysql
{
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR 

	private $intIdUsuario;
	private $strUsuario;
	private $strPassword; 
	private $intIdPerfil;


	public function __construct()
	{
		# code...
		parent::__construct();

	}


	public function hash_pwd(string $usuario)
	{
		$this->strUsuario 	= $usuario;
		$queryUser = "SELECT SUBSTR(password,0,10) AS SALT FROM users WHERE dni = '{$this->strUsuario}'";
		$request = $this->select($queryUser);

		return $request;
	}



	public function loginUser(string $usuario, string $password)
	{
		
		$this->strUsuario 	= $usuario;
		$this->strPassword	= $password;
		$queryUser = "SELECT id FROM users WHERE dni = '{$this->strUsuario}'";
		$requestUser = $this->select($queryUser);

		if(empty($requestUser)){
			return 'user';
		}else{

			$query = "SELECT id, CONCAT(nombres,' ',apellidos) AS nombre, estado, id_perfil, request_password FROM users WHERE dni = '{$this->strUsuario}' AND password = '{$this->strPassword}'";
			$request = $this->select($query);

			return $request;
		}
		 
	}


	public function loginUserModulo(int $idPerfil)
	{
		
		$this->intIdPerfil 	= $idPerfil;
		$query = "	SELECT m.url
		                FROM perfiles p INNER JOIN perfil_modulos pm ON p.id = pm.id_perfil 
		     			INNER JOIN modulos m ON m.id = pm.id_modulo
		                WHERE p.id  = '{$this->intIdPerfil}'";

		$request = $this->select_all($query);
		return $request;
		
		 
	}

}

?>