<?php 

/**
* 
*/
class PedidoModel extends Mysql
{
	private $intIdPedido;
	private $intPedido;
	private $intMemorandum;
	private $intInforme;
	private $strFechaPedido;
	private $strObservacion;
	private $intUserSession;

	private $intIdCargo;
	private $cantidad;
	//private $intEstado;

	public function __construct()
	{
		# code...
		parent::__construct();
	}


	public function insertPedido(int $pedido, int $memorandum, int $informe, string $fechaPedido, int $userSession)
	{
		
		$this->intPedido		= $pedido;
		$this->intMemorandum	= $memorandum;
		$this->intInforme		= $informe;
		$this->strFechaPedido	= $fechaPedido;
		$this->intUserSession 	= $userSession;

		$queryPedido 	= "SELECT id_pedido FROM pedido WHERE pedido = '$this->intPedido' AND estado_pedido != 0 ";
		$requestPedido	= $this->select($queryPedido);

		if(empty($requestPedido)){
			
			$query = "INSERT INTO pedido(pedido, memorandum, informe,fecha_pedido, user_create, estado_pedido) VALUES(?,?,?,?,?,1)";
			$arrData = array($this->intPedido, $this->intMemorandum, $this->intInforme, $this->strFechaPedido, $this->intUserSession);
			$requestInsert = $this->insert($query, $arrData);
			
			return $requestInsert;

		}else{

			return  'exist';
		}
	}


	public function selectPedidos()
	{

		$query = "SELECT id_pedido, pedido, memorandum, informe, fecha_pedido FROM pedido WHERE estado_pedido != 0 ";
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( pedido LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR memorandum LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR informe LIKE '%".$_POST["search"]["value"]."%'  ";
		    $query .= "OR fecha_pedido LIKE '%".$_POST["search"]["value"]."%' )";
		}

		if(isset($_POST["order"]))
		{
			$query .= ' ORDER BY '.(1+$_POST['order']['0']['column']).' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= ' ORDER BY id_pedido DESC';
		}

		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$query .= " LIMIT ".$_POST['start'].", ".$_POST['length'];
		}
		$request = $this->select_all($query);
	

		$query = "SELECT count(*) as row FROM pedido WHERE estado_pedido != 0 ";
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( pedido LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR memorandum LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR informe LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR fecha_pedido LIKE '%".$_POST["search"]["value"]."%' )";
		}
		$request2 = $this->select($query);

		
		$query = "SELECT count(*) as row FROM pedido WHERE estado_pedido != 0 ";
		$request3 = $this->select($query);

		$requestData=[$request,$request2,$request3];

		return $requestData;
	}


	public function selectPedido(int $idPedido)
	{
		$this->intIdPedido 	= $idPedido;
		$query = "	SELECT p.id_pedido, p.pedido, p.memorandum, p.informe, p.fecha_pedido, pc.id_cargo, pc.cantidad, c.cargo FROM pedido p
					INNER JOIN pedido_cargo pc ON p.id_pedido = pc.id_pedido
					INNER JOIN cargo c ON c.id_cargo = pc.id_cargo
					WHERE p.id_pedido = $this->intIdPedido AND p.estado_pedido = 1 AND pc.estado = 1";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectPedidoH(int $idPedido)
	{
		$this->intIdPedido 	= $idPedido;
		$query = "	SELECT p.id_pedido, p.pedido, p.memorandum, p.informe, pc.id_cargo, pc.cantidad, c.cargo, pc.observacion, DATE_FORMAT(pc.date_create, '%d/%m/%Y %h:%i:%s %p' ) as date_create FROM pedido p
					INNER JOIN pedido_cargo_history pc ON p.id_pedido = pc.id_pedido
					INNER JOIN cargo c ON c.id_cargo = pc.id_cargo
					WHERE p.id_pedido = $this->intIdPedido AND p.estado_pedido = 1 AND pc.estado = 1
					ORDER BY pc.date_create DESC";
		$request = $this->select_all($query);
		return $request;
	}


	public function updatePedido(int $idPedido, int $pedido, int $memorandum, int $informe, string $fechaPedido, string $observacion, int $userSession)
	{

		$this->intIdPedido 		= $idPedido;
		$this->intPedido 		= $pedido;
		$this->intMemorandum	= $memorandum;
		$this->intInforme		= $informe;
		$this->strFechaPedido	= $fechaPedido;
		$this->strObservacion	= $observacion;
		$this->intUserSession 	= $userSession;
		

		$queryPedido = "SELECT * FROM pedido WHERE pedido = '$this->intPedido' AND id_pedido != $this->intIdPedido AND estado_pedido != 0 ";
		$requestPedido = $this->select($queryPedido);

		if(empty($requestPedido)){
			
			$query = "UPDATE pedido SET pedido = ?, memorandum = ?, informe = ?, fecha_pedido = ?, user_update = ?, observacion = ? WHERE id_pedido = $this->intIdPedido";
			$arrData = array($this->intPedido, $this->intMemorandum, $this->intInforme, $this->strFechaPedido, $this->intUserSession, $this->strObservacion);
			$request = $this->update($query, $arrData);

			/*$queryUpdPersonal = "UPDATE personal SET estado = ? WHERE id_cargo = $this->intIdPedido";
			$arrDataUpd = array($this->intEstado);
			$requestUpd = $this->update($queryUpdPersonal, $arrDataUpd);*/

			return $request;

		}else{
			
			return  'exist';

		}
	}


	public function deletePedido(int $idPedido)
	{

		$this->intIdPedido 	=  $idPedido;
		$query 	= "UPDATE pedido SET estado_pedido = ? WHERE id_pedido = $this->intIdPedido ";
		$arrData= array(0);
		$request = $this->update($query, $arrData);
			
		return $request;
		
	}


	public function deleteDetPedido(int $idPedido)
	{

		$this->intIdPedido 	=  $idPedido;
		$query 	= "DELETE FROM pedido_cargo WHERE id_pedido = $this->intIdPedido ";
		$arrData= array(0);
		$request = $this->update($query, $arrData);
			
		return $request;
		
	}

	

	public function listCargos()
	{
		$query = "SELECT * FROM cargo WHERE estado = 1 ORDER BY cargo";
		$request = $this->select_all($query);
		return $request;
	}


	public function insertDetPedido(int $idPedido, int $idCargo, int $cantidad)
	{

		$this->intIdPedido		= $idPedido;
		$this->intIdCargo		= $idCargo;
		$this->intcantidad		= $cantidad;

		$query = "INSERT INTO pedido_cargo(id_pedido, id_cargo, cantidad, estado) VALUES(?,?,?,1)";
		$arrData = array($this->intIdPedido, $this->intIdCargo, $this->intcantidad);
		$requestInsert = $this->insert($query, $arrData);
			
		return $requestInsert;

	}


	public function insertDetPedidoH(int $idPedido, int $idCargo, int $cantidad, string $observacion, int $userSession)
	{

		$this->intIdPedido		= $idPedido;
		$this->intIdCargo		= $idCargo;
		$this->intcantidad		= $cantidad;
		$this->strObservacion	= $observacion;
		$this->intUserSession	= $userSession;

		$query = "INSERT INTO pedido_cargo_history(id_pedido, id_cargo, cantidad, observacion, user_create, estado) VALUES(?,?,?,?,?,1)";
		$arrData = array($this->intIdPedido, $this->intIdCargo, $this->intcantidad, $this->strObservacion, $this->intUserSession);
		$requestInsert = $this->insert($query, $arrData);
			
		return $requestInsert;

	}


	/* METODO PEDIDO - CONTRATO */
	public function selectCboPedido()
	{
		$query = "SELECT * FROM pedido WHERE estado_pedido != 0 ORDER BY pedido ASC";
		$request = $this->select_all($query);
		return $request;
	}

	/*public function selectReporteCargo()
	{
		$query = "SELECT * FROM cargo WHERE estado != 0 ORDER BY estado ASC, cargo ASC";
		$request = $this->select_all($query);
		return $request;
	}*/




}