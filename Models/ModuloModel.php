<?php 

/**
* 
*/
class ModuloModel extends Mysql
{
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR 

	private $intIdMdodulo;
	private $strModulo;
	private $strDescripcion;
	private $strURL;
	private $strIcono;
	private $intEstado;
	private $intIdPerfil;


	public function __construct()
	{
		# code...
		parent::__construct();
	}


	public function selectModulos()
	{

		/*$query = "SELECT id_modulo, modulo, descripcion, url, icono, estado FROM modulo WHERE estado != 0 ";
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( modulo LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR descripcion LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR url LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR icono LIKE '%".$_POST["search"]["value"]."%' )";
		}

		if(isset($_POST["order"]))
		{
			$query .= ' ORDER BY '.(1+$_POST['order']['0']['column']).' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= ' ORDER BY modulo ';
		}

		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$query .= " LIMIT ".$_POST['start'].", ".$_POST['length'];
		}
		$request = $this->select_all($query);
	

		$query = "SELECT COUNT(*) as row FROM modulo WHERE estado != 0 ";
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( modulo LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR descripcion LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR url LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR icono LIKE '%".$_POST["search"]["value"]."%' )";
		}
		$request2 = $this->select($query);

		
		$query = "SELECT COUNT(*) as row FROM modulo WHERE estado != 0";
		$request3 = $this->select($query);

		$requestData=[$request,$request2,$request3];

		return $requestData;*/

		$query = "SELECT id, modulo, descripcion, url, icono, estado FROM modulos WHERE estado != 0 ORDER BY modulo";
		$requestData = $this->select_all($query);

		return $requestData;
	}


	public function selectModulo(int $idMdodulo)
	{
		$this->intIdMdodulo = $idMdodulo;
		$query = "SELECT * FROM modulos WHERE id = $this->intIdMdodulo";
		$request = $this->select($query);
		return $request;
	}


	public function updateModulo(int $idModulo, string $modulo, string $descripcion, string $icono, int $estado)
	{

		$this->intIdMdodulo 	= $idModulo;
		$this->strModulo 		= $modulo;
		$this->strDescripcion	= $descripcion;
		$this->strIcono 		= $icono;
		$this->intEstado 		= $estado;

		$queryModulo = "SELECT * FROM modulo WHERE modulo = '{$this->strModulo}' AND id_modulo != $this->intIdMdodulo AND estado != 0 ";
		$requestModulo = $this->select($queryModulo);

		if(empty($requestModulo)){
			
			$query = "UPDATE modulo SET modulo = ?, descripcion = ?, icono = ?, estado = ? WHERE id_modulo = $this->intIdMdodulo";
			$arrData = array($this->strModulo, $this->strDescripcion, $this->strIcono, $this->intEstado);
			$request = $this->update($query, $arrData);
					
			return $request;

		}else{
			
			return  'exist';

		}
	}


	/* ASIGNAR */
	public function selectCboModulos(){
		if($_SESSION['idPerfil'] == 1){
			$query = "SELECT * FROM modulos m WHERE estado = 1 ORDER BY modulo";
			$request = $this->select_all($query);
		}else{
			$query = "SELECT * FROM modulos m INNER JOIN perfil_modulos pm ON m.id = pm.id_modulo 
	                    WHERE pm.id_perfil = ".$_SESSION['idPerfil']." AND estado = 1 ORDER BY modulo";
			$request = $this->select_all($query);
		}
		return $request;
	}


	public function insertAsignar(int $idperfil, int $idmodulo)
	{
		$this->intIdPerfil 		= $idperfil;
		$this->intIdMdodulo		= $idmodulo;

		$query = "INSERT INTO perfil_modulo(id_perfil, id_modulo) VALUES(?,?)";
		$arrData = array($this->intIdPerfil, $this->intIdMdodulo);
		$secuence = 'SEQ_PERFILMODULO_ID';
		$requestInsert = $this->insert($query, $arrData, $secuence);

		return $requestInsert;
	}


	public function deleteAsignar(int $idPerfil)
	{
		$this->intIdPerfil 	=  $idPerfil;
		
		$query 	= "DELETE FROM perfil_modulos WHERE id_perfil = $this->intIdPerfil ";
		$request = $this->delete($query);
		return $request;
	}


	public function selectModulosAsignar(){
//		$where = ($_SESSION['idPerfil'] != 1) ? ' WHERE p.id != 1 ' : '' ;
		$query = "SELECT p.id, group_concat(m.id ORDER BY m.id separator ', ') as id_modulo, p.perfil, p.descripcion, group_concat(m.modulo ORDER BY m.id separator ',') as modulos
                  FROM perfiles p INNER JOIN perfil_modulos pm ON p.id = pm.id_perfil INNER JOIN modulos m ON m.id = pm.id_modulo GROUP BY p.id, m.id ORDER BY p.id, m.id;";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectAsignar(int $idPerfil)
	{
		$this->intIdPerfil = $idPerfil;
		$query = "SELECT p.ID_PERFIL, p.PERFIL, LISTAGG(pm.ID_MODULO , ',') WITHIN GROUP (ORDER BY pm.ID_MODULO) MODULOS
										FROM PERFIL p 
										inner join PERFIL_MODULO pm on p.ID_PERFIL = pm.ID_PERFIL 
										WHERE pm.ID_PERFIL= $this->intIdPerfil GROUP BY p.ID_PERFIL, p.PERFIL";
		$request = $this->select($query);
		return $request;
	}

}

?>