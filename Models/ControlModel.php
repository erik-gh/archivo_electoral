<?php 

/**
* 
*/
class ControlModel extends Mysql
{
	
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR 
	public function __construct()
	{
		# code...
		parent::__construct();
	}

	public function selectCboProceso(){
		
		$query = "SELECT P.id, P.proceso, P.descripcion, TP.eleccion
                    FROM procesos P INNER JOIN tipo_procesos TP ON P.id_tipo_proceso = TP.id
                    WHERE P.estado = 1 AND SYSDATE() BETWEEN P.fecha_inicio AND P.fecha_cierre + 1 ORDER BY P.fecha_inicio DESC";
		$request = $this->select_all($query);
		return $request;
	}
}


?>