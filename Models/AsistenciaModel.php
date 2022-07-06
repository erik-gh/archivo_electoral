<?php 

/**
* 
*/
class AsistenciaModel extends Mysql
{

	private $intIdPersonal;
	private $intControl;	
	private $intCargo;
	private $strFecha;
	private $intUserSession;
	private $strDNI;
	private $intIdAsistencia;

	public function __construct()
	{
		# code...
		parent::__construct();
	}


	public function selectPersona(string $dni)
	{
		$this->strDNI = $dni;
		$query = "SELECT * FROM personal WHERE dni =  $this->strDNI AND estado = 1 ";
		$request = $this->select($query);

		if(empty($request)){
			return 'nexiste';
		}else{
			return $request;
		}
	}


	public function insertAsistencia(int $idPersonal, int $idCargo, string $fecha, int $userSession)
	{
		
		$this->intIdPersonal 	= $idPersonal;
		$this->intCargo 		= $idCargo;
		$this->strFecha			= $fecha;
		$this->intUserSession 	= $userSession;

		$queryAsistencia = "SELECT id_asistencia FROM asistencia WHERE id_personal = $this->intIdPersonal AND id_cargo = $this->intCargo AND fecha = '{$this->strFecha}' AND estado =1 ";
		$requestAsistencia = $this->select($queryAsistencia);

		if(empty($requestAsistencia)){
			
			$query = 'INSERT INTO asistencia (id_personal, id_cargo, id_usuarioIng, fecha, hora_ingreso, sede, estado) VALUES(?,?,?,DATE_FORMAT(NOW( ), "%Y-%m-%d" ),DATE_FORMAT(NOW( ),"%H:%i:%S" ), 1, 1)';
			$arrData = array($this->intIdPersonal, $this->intCargo, $this->intUserSession);
			$requestInsert = $this->insert($query, $arrData);
			
			return $requestInsert;

		}else{

			return  'exist';
		}
	}


	public function selectAsistencia(string $dni, int $control)
	{

		$this->strDNI 		= $dni;
		$this->intControl 	= $control;

		$select = ($this->intControl == 1) ?  'DATE_FORMAT(a.fecha, "%d/%m/%Y") AS fecha, TIME_FORMAT(a.hora_ingreso, "%h:%i:%s %p") AS hora_ingreso, "ingreso" as ingreso' : 'DATE_FORMAT(a.fecha_salida, "%d/%m/%Y") AS fecha_salida, TIME_FORMAT(a.hora_salida, "%h:%i:%s %p") AS hora_salida, "salida" as salida ';

		$query = 'SELECT p.dni, p.nombre, c.cargo, '.$select.' , g.abreviatura,  a.id_asistencia, p.imagen 
									FROM asistencia a
                                    INNER JOIN personal p ON a.id_personal = p.id_personal 
									INNER JOIN cargo c ON p.id_cargo = c.id_cargo
									INNER JOIN gerencia g ON p.id_gerencia = g.id_gerencia
									WHERE p.dni= '.$this->strDNI.' AND (a.fecha != "" OR a.fecha is not NULL) AND (a.fecha_salida = "" OR a.fecha_salida is NULL) AND p.estado = 1
									ORDER BY a.fecha DESC ';
		$request = $this->select($query);

		return $request;
	}


	public function updateAsistencia(int $idAsistencia, string $fecha, int $userSession)
	{

		$this->intIdAsistencia 	= $idAsistencia;
		$this->strFecha			= $fecha;
		$this->intUserSession 	= $userSession;

		$query = 'UPDATE asistencia SET hora_salida=DATE_FORMAT(NOW( ), "%H:%i:%S" ), id_usuarioSal=?, fecha_salida=?, estado = 2 WHERE id_asistencia=?';
		$arrData = array($this->intUserSession, $this->strFecha, $this->intIdAsistencia);
		$request = $this->update($query, $arrData);

		return $request;
	}


	public function selectAsistenciaSalida(string $dni, int $control)
	{

		$this->strDNI 		= $dni;
		$this->intControl 	= $control;

		$select = ($this->intControl == 1) ?  'DATE_FORMAT(a.fecha, "%d/%m/%Y") AS fecha, TIME_FORMAT(a.hora_ingreso, "%h:%i:%s %p") AS hora_ingreso, "ingreso" as ingreso' : 'DATE_FORMAT(a.fecha_salida, "%d/%m/%Y") AS fecha_salida, TIME_FORMAT(a.hora_salida, "%h:%i:%s %p") AS hora_salida, "salida" as salida ';

		$query = 'SELECT p.dni, p.nombre, c.cargo, '.$select.' , g.abreviatura,  a.id_asistencia, p.imagen 
									FROM asistencia a
                                    INNER JOIN personal p ON a.id_personal = p.id_personal 
									INNER JOIN cargo c ON p.id_cargo = c.id_cargo
									INNER JOIN gerencia g ON p.id_gerencia = g.id_gerencia
									WHERE p.dni= '.$this->strDNI.' AND (a.fecha != "" OR a.fecha is not NULL) AND p.estado = 1
									ORDER BY a.fecha DESC ';
		$request = $this->select($query);

		return $request;
	}


	public function selectCantidad()
	{

		$query = "	SELECT g.abreviatura, COUNT(1) AS cantidad
					FROM asistencia a
					INNER JOIN personal p ON a.id_personal = p.id_personal
					INNER JOIN gerencia g ON p.id_gerencia = g.id_gerencia
					WHERE a.fecha_salida is NULL AND a.fecha = CURDATE() AND a.estado = 1
					GROUP BY p.id_gerencia
					UNION
					SELECT 'TOTAL', COUNT(1) 
					FROM asistencia a
					INNER JOIN personal p ON a.id_personal = p.id_personal
					WHERE a.fecha_salida is NULL AND a.fecha = CURDATE() AND a.estado = 1 ";
		
		$request = $this->select_all($query);
		return $request;
	}

}

?>