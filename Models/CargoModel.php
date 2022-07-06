<?php 

/**
* 
*/
class CargoModel extends Mysql
{
	private $intIdCargo;
	private $strCargo;
	private $intRemuneracion;
	private $intUserSession;
	private $intEstado;

	public function __construct()
	{
		# code...
		parent::__construct();
	}


	public function insertCargo(string $cargo, int $remuneracion, int $userSession)
	{
		
		$this->strCargo 		= $cargo;
		$this->intRemuneracion	= $remuneracion;
		$this->intUserSession 	= $userSession;

		$queryCargo = "SELECT id_cargo FROM cargo WHERE cargo = '{$this->strCargo}' AND estado != 0 ";
		$requestCargo = $this->select($queryCargo);

		if(empty($requestCargo)){
			
			$query = "INSERT INTO cargo(cargo, remuneracion, user_create, cantidad, estado) VALUES(?,?,?,0,1)";
			$arrData = array($this->strCargo, $this->intRemuneracion, $this->intUserSession);
			$requestInsert = $this->insert($query, $arrData);
			
			return $requestInsert;

		}else{

			return  'exist';
		}
	}


	public function selectCargos()
	{

		$query = "SELECT id_cargo, cargo, remuneracion, estado FROM cargo WHERE estado != 0 ";
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( cargo LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR remuneracion LIKE '%".$_POST["search"]["value"]."%' )";
		}

		if(isset($_POST["order"]))
		{
			$query .= ' ORDER BY '.(1+$_POST['order']['0']['column']).' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= ' ORDER BY cargo ';
		}

		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$query .= " LIMIT ".$_POST['start'].", ".$_POST['length'];
		}
		$request = $this->select_all($query);
	

		$query = "SELECT count(*) as row FROM cargo WHERE estado != 0 ";
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( cargo LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR remuneracion LIKE '%".$_POST["search"]["value"]."%' )";
		}
		$request2 = $this->select($query);

		
		$query = "SELECT count(*) as row FROM cargo WHERE estado != 0";
		$request3 = $this->select($query);

		$requestData=[$request,$request2,$request3];

		return $requestData;
	}


	public function selectCargo(int $idCargo)
	{
		$this->intIdCargo 	= $idCargo;
		$query = "SELECT * FROM cargo WHERE id_cargo = $this->intIdCargo";
		$request = $this->select($query);
		return $request;
	}


	public function updateCargo(int $idCargo, string $cargo, int $remuneracion, int $userSession, int $estado)
	{

		$this->intIdCargo 		= $idCargo;
		$this->strCargo 		= $cargo;
		$this->intRemuneracion	= $remuneracion;
		$this->intUserSession 	= $userSession;
		$this->intEstado 		= $estado;

		$queryCargo = "SELECT * FROM cargo WHERE cargo = '{$this->strCargo}' AND id_cargo != $this->intIdCargo AND estado != 0 ";
		$requestCargo = $this->select($queryCargo);

		if(empty($requestCargo)){
			
			$query = "UPDATE cargo SET cargo = ?, remuneracion = ?, user_update = ?, estado = ? WHERE id_cargo = $this->intIdCargo";
			$arrData = array($this->strCargo, $this->intRemuneracion, $this->intUserSession, $this->intEstado);
			$request = $this->update($query, $arrData);

			$queryUpdPersonal = "UPDATE personal SET estado = ? WHERE id_cargo = $this->intIdCargo";
			$arrDataUpd = array($this->intEstado);
			$requestUpd = $this->update($queryUpdPersonal, $arrDataUpd);

			return $request;

		}else{
			
			return  'exist';

		}
	}


	public function deleteCargo(int $idCargo)
	{
		$this->intIdCargo 	=  $idCargo;
		
		$queryPersonal 	= "SELECT id_personal FROM personal WHERE id_cargo = $this->intIdCargo AND estado != 0 ";
		$requestPersonal = $this->select($queryPersonal);

		if(empty($requestPersonal)){
			$query 	= "UPDATE cargo SET estado = ? WHERE id_cargo = $this->intIdCargo ";
			$arrData= array(0);
			$request = $this->update($query, $arrData);
			
			return $request;
		}else{

			return  'exist';
		}
	}


	public function selectCboCargos()
	{
		$query = "SELECT * FROM cargo WHERE estado = 1 ORDER BY cargo";
		$request = $this->select_all($query);
		return $request;
	}



	public function selectReporteCargo()
	{
		$query = "SELECT * FROM cargo WHERE estado != 0 ORDER BY estado ASC, cargo ASC";
		$request = $this->select_all($query);
		return $request;
	}



}