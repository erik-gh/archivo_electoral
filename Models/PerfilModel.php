<?php 

/**
* 
*/
class PerfilModel extends Oracle
{
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR 

	private $intIdPerfil;
	private $strPerfil;
	private $strDescripcion;
	private $intUserSession;
	private $intEstado;


	public function __construct()
	{
		# code...
		parent::__construct();
	}


	public function insertPerfil(string $perfil, string $descripcion, int $userSession)
	{
		
		$this->strPerfil 		= $perfil;
		$this->strDescripcion	= $descripcion;
		$this->intUserSession 	= $userSession;

		$queryPerfil = "SELECT id_perfil FROM perfil WHERE perfil = '{$this->strPerfil}' AND estado != 0 ";
		$requestPerfil = $this->select($queryPerfil);

		if(empty($requestPerfil)){
			
			$query = "INSERT INTO perfil(perfil, descripcion, user_create, date_create, estado) VALUES(?,?,?,localtimestamp,1)";
			$arrData = array($this->strPerfil, $this->strDescripcion, $this->intUserSession);
			$secuence = 'SEQ_PERFIL_ID';
			$requestInsert = $this->insert($query, $arrData, $secuence);
			
			return $requestInsert;

		}else{

			return  'exist';
		}
	}


	public function selectPerfiles()
	{
		$where = ($_SESSION['idPerfil'] != 1) ? ' AND id_perfil != 1 ' : '' ;
		$query = "SELECT * FROM (SELECT id_perfil, perfil, descripcion, estado, row_number() over (order by perfil) orden FROM perfil WHERE estado != 0 ".$where;
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( perfil LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR descripcion LIKE '%".$_POST["search"]["value"]."%' )";
		}

		if(isset($_POST["order"]))
		{
			$query .= ' ORDER BY '.(1+$_POST['order']['0']['column']).' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= ' ORDER BY perfil ';
		}

		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$query .= " ) WHERE orden BETWEEN ".$_POST['start']." AND ".$_POST['length'];
		}
		$request = $this->select_all($query);
		


		$query = "SELECT COUNT(*) as fila FROM perfil WHERE estado != 0 ".$where;
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( perfil LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR descripcion LIKE '%".$_POST["search"]["value"]."%' )";
		}
		$request2 = $this->select($query);

		
		$query = "SELECT COUNT(*) as fila FROM perfil WHERE estado != 0".$where;
		$request3 = $this->select($query);

		$requestData=[$request,$request2,$request3];

		return $requestData;
	}


	public function selectPerfil(int $idPerfil)
	{
		$this->intIdPerfil 	= $idPerfil;
		$query = "SELECT * FROM perfil WHERE id_perfil = $this->intIdPerfil";
		$request = $this->select($query);
		return $request;
	}


	public function updatePerfil(int $idPerfil, string $perfil, string $descripcion, int $userSession, int $estado)
	{

		$this->intIdPerfil 		= $idPerfil;
		$this->strPerfil 		= $perfil;
		$this->strDescripcion	= $descripcion;
		$this->intUserSession 	= $userSession;
		$this->intEstado 		= $estado;

		$queryPerfil = "SELECT * FROM perfil WHERE perfil = '{$this->strPerfil}' AND id_perfil != $this->intIdPerfil AND estado != 0 ";
		$requestPerfil = $this->select($queryPerfil);

		if(empty($requestPerfil)){
			
			$query = "UPDATE perfil SET perfil = ?, descripcion = ?, user_update = ?, estado = ? WHERE id_perfil = $this->intIdPerfil";
			$arrData = array($this->strPerfil, $this->strDescripcion, $this->intUserSession, $this->intEstado);
			$request = $this->update($query, $arrData);

			$queryUpdUser = "UPDATE usuario SET estado = ? WHERE id_perfil = $this->intIdPerfil";
			$arrDataUpd = array($this->intEstado);
			$requestUpd = $this->update($queryUpdUser, $arrDataUpd);
			
			return $request;

		}else{
			
			return  'exist';

		}
	}


	public function deletePerfil(int $idPerfil)
	{
		$this->intIdPerfil 	=  $idPerfil;
		
		$queryUser 	= "SELECT id_usuario FROM usuario WHERE id_perfil = $this->intIdPerfil AND estado != 0 ";
		$requestUser = $this->select($queryUser);

		if(empty($requestUser)){
			$query 	= "UPDATE perfil SET estado = ? WHERE id_perfil = $this->intIdPerfil ";
			$arrData= array(0);
			$request = $this->update($query, $arrData);
			
			return $request;
		}else{

			return  'exist';
		}
	}


	public function selectCboPerfiles(){
		$where = ($_SESSION['idPerfil'] != 1) ? ' AND id_perfil != 1 ' : '' ;
		$query = "SELECT * FROM perfil WHERE estado = 1 ".$where." ORDER BY perfil";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboPerfilesModulo(){
		$where = ($_SESSION['idPerfil'] != 1) ? ' AND id_perfil != 1 ' : '' ;
		$query = "SELECT * FROM perfil WHERE estado = 1 ".$where." AND id_perfil NOT IN (SELECT DISTINCT id_perfil FROM perfil_modulo) ORDER BY perfil";
		$request = $this->select_all($query);
		return $request;
	}


}


?>