<?php 

/**
* 
*/
class DashboardModel extends Mysql
{
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR 

	private $intIdUsuario;	
	private $strPassword;	
	private $strnewPassword;

	private $intIdProceso;


	public function __construct()
	{
		# code...
		parent::__construct();

	}
	


	public function updateUsuarioPass(int $idUsuario, string $password)
	{

		$this->intIdUsuario 	= $idUsuario;
		$this->strPassword 		= $password;

		$query = "UPDATE usuario SET password = ?, REQUEST_PASSWORD = 1 WHERE id_usuario = $this->intIdUsuario";
		$arrData = array($this->strPassword);
		$request = $this->update($query, $arrData);

		return $request;
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



	public function selectResumenProceso(int $idprocesos){

		$this->intIdProceso 	= $idprocesos;

	 	$query = "SELECT COUNT(DISTINCT ID_SOLUCION) SOLUCION, COUNT(DISTINCT ID_ODPE) ODPE, COUNT(DISTINCT ID_UBIGEO) DISTRITOS,
										TO_CHAR(COUNT(DISTINCT ID_LOCAL),'FM999,999,999') LOCAL,
										TO_CHAR(COUNT(ID_SUFRAGIO),'FM999,999,999') MESAS, 
										NVL(TO_CHAR(SUM(NRO_ELECTORES),'FM999,999,999'),0) ELECTORES
										FROM MESA_SUFRAGIO
										WHERE ID_PROCESO = $this->intIdProceso ";

		$request = $this->select($query);
		return $request;

	 }


	public function selectResumenOdpe(int $idprocesos){

		$this->intIdProceso 	= $idprocesos;

	 	$query = "SELECT O.NOMBRE_ODPE, COUNT(DISTINCT M.ID_UBIGEO) DISTRITOS, COUNT(DISTINCT M.ID_LOCAL)LOCAL, 
	 									COUNT(M.NRO_MESA) MESAS, TO_CHAR(SUM(M.NRO_ELECTORES),'FM999,999,999') ELECTORES
										FROM  MESA_SUFRAGIO M
                      					INNER JOIN ODPE O ON M.ID_ODPE = O.ID_ODPE
										WHERE M.ID_PROCESO= $this->intIdProceso
										GROUP BY O.NOMBRE_ODPE
										ORDER BY O.NOMBRE_ODPE ";

		$request = $this->select_all($query);
		return $request;

	 }


	 public function selectResumenSoltec(int $idprocesos){

		$this->intIdProceso 	= $idprocesos;

	 	$query = "SELECT S.SOLUCIONTECNOLOGICA, COUNT(M.ID_SUFRAGIO) TOTAL, REPLACE(NVL(ROUND((COUNT(M.ID_SUFRAGIO)/(SELECT COUNT(ID_SUFRAGIO) FROM MESA_SUFRAGIO WHERE ID_PROCESO = $this->intIdProceso ))*100,2),0),',','.') AS PORCENTAJE
											FROM MESA_SUFRAGIO M
											INNER JOIN SOLUCIONTECNOLOGICA S ON M.ID_SOLUCION = S.ID_SOLUCIONTECNOLOGICA
											INNER JOIN SOLUCION_PROCESO SP ON SP.ID_SOLUCION = S.ID_SOLUCIONTECNOLOGICA AND SP.ID_PROCESO = $this->intIdProceso
											WHERE M.ID_PROCESO = $this->intIdProceso
											GROUP BY S.SOLUCIONTECNOLOGICA ";

		$request = $this->select_all($query);
		return $request;

	 }










	



	


}


?>