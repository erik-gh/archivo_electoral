<?php 

/**
* 
*/
class ReportAsistenciaModel extends Mysql
{
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR 
	private $strDNI;
	private $strFechaInicio;	
	private $strFechaFin;
	private $strDias;

	public function __construct()
	{
		# code...
		parent::__construct();

	}


	public function selectDias($fechaInicio, $fechaFin)
	{
		$this->strFechaInicio = $fechaInicio;
		$this->strFechaFin = $fechaFin;

		$where = '';
		if($this->strFechaInicio == '' && $this->strFechaFin == ''){
			$where = ' WHERE 1';
		}else if($this->strFechaInicio != '' && $this->strFechaFin == ''){
			$where = " WHERE fecha = '{$this->strFechaInicio}'"; 
		}else{
			$where = " WHERE fecha BETWEEN '{$this->strFechaInicio}' AND '{$this->strFechaFin}'";
		}

		$query = "SELECT DISTINCT fecha FROM asistencia ".$where." ORDER BY fecha ASC";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectReporte($dni, $selectDia)
	{
		$this->strDNI 	= $dni;
		$this->strDias	= $selectDia;

		$where = ($dni != '') ? " WHERE personal.dni = '{$this->strDNI}' " : " WHERE 1 " ; 

		$query = " SELECT asistencia.id_personal, personal.dni, personal.nombre, cargo.cargo, gerencia.abreviatura, personal.estado ".$this->strDias." 
									FROM 
									asistencia 
									RIGHT JOIN personal ON asistencia.id_personal = personal.id_personal 
									INNER JOIN cargo ON cargo.id_cargo = personal.id_cargo
									INNER JOIN gerencia ON personal.id_gerencia = gerencia.id_gerencia
									".$where." AND personal.id_gerencia = 1 AND personal.estado in (1,2)  
									GROUP BY
										personal.id_personal
									ORDER BY
										gerencia.id_gerencia ASC, personal.nombre ASC ";
		$request = $this->select_all($query);
		return $request;

	}


}

?>