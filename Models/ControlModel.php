<?php 

/**
* 
*/
class ControlModel extends Oracle
{
	
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR 
	public function __construct()
	{
		# code...
		parent::__construct();
	}


	public function selectCboProceso()
	{
		
		$query = "SELECT P.ID_PROCESO, P.PROCESO, P.DESCRIPCION, TP.ELECCION  
										FROM PROCESO P
										INNER JOIN TIPO_PROCESO TP ON P.ID_TIPO = TP.ID_TIPO
										WHERE P.ESTADO = 1 AND SYSDATE BETWEEN P.FECHA_INICIO AND P.FECHA_CIERRE + 1 ORDER BY P.FECHA_INICIO DESC";

		$request = $this->select_all($query);
		return $request;
	}


}


?>