<?php 

/**
* 
*/
class UsuarioModel extends Oracle
{
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR 
	private $intIdUsuario;	
	private $intControl;	
	private $strDNI;			
	private $strApellido;	
	private $strNombre;		
	private $intPerfil;		
	private $strUsuario;		
	private $strPassword;	
	private $intUserSession;	
	private $intEstado;		


	public function __construct()
	{
		# code...
		parent::__construct();
	}


	public function insertUsuario(string $dni, string $apellido, string $nombre, int $perfil, string $usuario, String $password, int $userSession)
	{
		
		$this->strDNI 			= $dni;
		$this->strApellido		= $apellido;
		$this->strNombre 		= $nombre;
		$this->intPerfil		= $perfil;
		$this->strUsuario	 	= $usuario;
		$this->strPassword 		= $password;
		$this->intUserSession	= $userSession;

		$queryUsuario = "SELECT id_usuario FROM usuario WHERE estado != 0 AND (dni_usuario = '{$this->strDNI}' OR  username ='{$this->strUsuario}') ";
		$requestUsuario = $this->select($queryUsuario);

		if(empty($requestUsuario)){
			
			$query = "INSERT INTO usuario(dni_usuario, apellidos, nombres, username, password, id_perfil, user_create, date_create, estado, request_password) VALUES(?,?,?,?,?,?,?, LOCALTIMESTAMP, 1, 0)";
			$arrData = array($this->strDNI, $this->strApellido, $this->strNombre, $this->strUsuario, $this->strPassword, $this->intPerfil, $this->intUserSession);
			$secuence = 'SEQ_USUARIO_ID';
			$requestInsert = $this->insert($query, $arrData, $secuence);
			
			return $requestInsert;

		}else{

			return  'exist';
		}
	}


	public function selectUsuarios()
	{
		/*$where = ($_SESSION['idPerfil'] != 1) ? ' AND u.id_perfil != 1 ' : '' ;
		$query = "SELECT * FROM (SELECT u.id_usuario, u.dni_usuario, u.apellido_paterno || ' ' || u.apellido_materno as apellidps, u.nombres, p.perfil, u.username, u.estado, row_number() over (order by p.id_perfil, u.apellido_paterno, u.apellido_materno, u.nombres) orden FROM perfil p INNER JOIN usuario u ON p.id_perfil = u.id_perfil WHERE p.estado != 0 AND u.estado != 0 ".$where;
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( u.dni_usuario LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR u.apellido_paterno LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR u.apellido_materno LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR u.nombres LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR p.perfil LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR u.username LIKE '%".$_POST["search"]["value"]."%' )";
		}

		if(isset($_POST["order"]))
		{
			$query .= ' ORDER BY '.(1+$_POST['order']['0']['column']).' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= ' ORDER BY p.id_perfil, u.apellido_paterno, u.apellido_materno, u.nombres ';
		}

		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$query .= " ) WHERE orden BETWEEN ".$_POST['start']." AND ".$_POST['length'];
		}
		
		$request = $this->select_all($query);
	

		$query = "SELECT count(*) as fila FROM perfil p INNER JOIN usuario u ON p.id_perfil = u.id_perfil WHERE p.estado != 0 AND u.estado != 0 ".$where;
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( u.dni_usuario LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR u.apellido_paterno LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR u.apellido_materno LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR u.nombres LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR p.perfil LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR u.username LIKE '%".$_POST["search"]["value"]."%' )";
		}
		$request2 = $this->select($query);

		
		$query = "SELECT count(*) as fila FROM perfil p INNER JOIN usuario u ON p.id_perfil = u.id_perfil WHERE p.estado != 0 AND u.estado != 0 ".$where;
		$request3 = $this->select($query);

		$requestData=[$request,$request2,$request3];

		return $requestData;*/


		$where = ($_SESSION['idPerfil'] != 1) ? ' AND u.id_perfil != 1 ' : '' ;
		$query = "SELECT u.id_usuario, u.dni_usuario, u.apellidos, u.nombres, p.perfil, u.username, u.estado FROM perfil p INNER JOIN usuario u ON p.id_perfil = u.id_perfil WHERE p.estado != 0 AND u.estado != 0 ".$where."
		ORDER BY p.id_perfil, u.apellidos, u.nombres";
		$requestData = $this->select_all($query);

		return $requestData;

	}


	public function selectusuario(int $idUsuario)
	{
		$this->intIdUsuario = $idUsuario;
		$query = "SELECT * FROM usuario WHERE id_usuario = $this->intIdUsuario";
		$request = $this->select($query);
		return $request;
	}



	public function updateUsuario(int $idUsuario, string $dni, string $apellido, string $nombre, int $perfil, string $usuario, int $userSession, int $estado)
	{

		$this->intIdUsuario 	= $idUsuario;
		$this->strDNI 			= $dni;
		$this->strApellido		= $apellido;
		$this->strNombre		= $nombre;
		$this->intPerfil		= $perfil;
		$this->strUsuario		= $usuario;
		$this->intUserSession 	= $userSession;
		$this->intEstado 		= $estado;

		$queryUsuario = "SELECT * FROM usuario WHERE ((dni_usuario = '{$this->strDNI}' AND id_usuario != $this->intIdUsuario) OR (username = '{$this->strUsuario}' AND id_usuario != $this->intIdUsuario)) AND estado != 0 ";
		$requestUsuario = $this->select($queryUsuario);

		if(empty($requestUsuario)){
			
			$query = "UPDATE usuario SET dni_usuario = ?, apellidos = ?, nombres = ?, username = ?, user_update = ?, estado = ?, id_perfil = ? WHERE id_usuario = $this->intIdUsuario";
			$arrData = array($this->strDNI, $this->strApellido, $this->strNombre, $this->strUsuario, $this->intUserSession, $this->intEstado , $this->intPerfil);
			$request = $this->update($query, $arrData);

			return $request;

		}else{
			
			return  'exist';

		}
	}


	public function updateUsuarioPass(int $idUsuario, string $password)
	{

		$this->intIdUsuario 	= $idUsuario;
		$this->strPassword 		= $password;

		$query = "UPDATE usuario SET password = ? WHERE id_usuario = $this->intIdUsuario";
		$arrData = array($this->strPassword);
		$request = $this->update($query, $arrData);

		return $request;
	}


	public function deleteUsuario(int $idUsuario)
	{
		$this->intIdUsuario 	=  $idUsuario;
		
		$query 	= "UPDATE usuario SET estado = ? WHERE id_usuario = $this->intIdUsuario ";
		$arrData= array(0);
		$request = $this->update($query, $arrData);
			
		return $request;
		
	}


	public function selectCboUsuarios(){
		$query = "SELECT * FROM usuario WHERE estado = 1 ORDER BY apellido, nombre";
		$request = $this->select_all($query);
		return $request;
	}


}


?>