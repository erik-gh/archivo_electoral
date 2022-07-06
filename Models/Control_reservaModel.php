<?php 

/**
* 
*/
class Control_reservaModel extends Oracle
{
	
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR
	private $intIdMaterial;
	private $intIdProceso;
	private $intIdFase;
	private $intIdEtapa;
	private $intIdSolucion;
	private $intIdOdpe;
	private $intIdEleccion;
	private $intIdAgrupacion;
	private $strDepartamento;
	private $strProvincia;
	private $strDistrito;
	private $strConsulta;
	private $intIdUsusario;

	private $conOracle;

	private $strNroUbigeo;
	private $strNroMesa;
	private $strNroElectores;
	private $intIdValor;
	private $intIdValidacion;
	private $intIdIncidencia;
	private $intCantidad;
	private $intIdSufragio;

	private $strCboUbigeo;

	public function __construct()
	{
		# code...
		parent::__construct();

		include("Libraries/Core/conexionOracle.php");//"app/class/QRCodeGenerator.class.php");
		//$this->conO = new conexionOracle($this->config->item('userOracle'), $this->config->item('pssOracle'), $this->config->item('hostOracle'));
		$this->conOracle = new conexionOracle(DB_USER, DB_PASSWORD, DB_HOST);
	}


	public function selectIdMesa(int $idprocesos, string $nroMesa)
	{

		$this->intIdProceso = $idprocesos;
		$this->strNroMesa 	= $nroMesa;

		$query = " 	SELECT MS.ID_SUFRAGIO
				    FROM MESA_SUFRAGIO MS
				    WHERE MS.ID_PROCESO=$this->intIdProceso
				    AND MS.NRO_MESA='{$this->strNroMesa}'";

		$request = $this->select($query);
		return $request;
	}


	public function selectCboSolucion(int $idprocesos)
	{
		
		$this->intIdProceso = $idprocesos;

		$query = "SELECT s.ID_SOLUCIONTECNOLOGICA, s.SOLUCIONTECNOLOGICA
										FROM MESA_SUFRAGIO m
										INNER JOIN SOLUCION_PROCESO sp ON m.ID_SOLUCION = sp.ID_SOLUCION
										INNER JOIN SOLUCIONTECNOLOGICA s ON m.ID_SOLUCION = s.ID_SOLUCIONTECNOLOGICA
										WHERE m.ID_PROCESO = $this->intIdProceso
										GROUP BY s.ID_SOLUCIONTECNOLOGICA, s.SOLUCIONTECNOLOGICA 
										ORDER BY s.SOLUCIONTECNOLOGICA";

		$request = $this->select_all($query);
		return $request;

	}


	public function selectCboOdpe(int $idprocesos, int $idSolucion)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion	= $idSolucion;

		$query = "SELECT o.id_odpe,o.nombre_odpe
										FROM mesa_sufragio m
										INNER JOIN odpe o ON m.id_odpe = o.id_odpe
										--INNER JOIN odpe_proceso op ON m.id_odpe = op.id_odpe
										where M.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion
										GROUP BY o.id_odpe, o.nombre_odpe 
										ORDER BY o.nombre_odpe";

		$request = $this->select_all($query);
		return $request;
		
	}


	public function selectCboDepartamento(int $idprocesos, int $idSolucion, int $idOdpe, int $idEleccion)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion	= $idSolucion;
		$this->intIdOdpe 		= $idOdpe;
		$this->intIdEleccion 	= $idEleccion;

		$query = "SELECT DISTINCT
					                    CASE 	WHEN 1=$this->intIdEleccion THEN SUBSTR(u.ubigeo,1,2)
					                          	WHEN 2=$this->intIdEleccion THEN TO_CHAR(a.ID_AGRUPACION)
					                    END codigo,	
					                    CASE 	WHEN 1=$this->intIdEleccion THEN u.DEPARTAMENTO_UBI
					                         	WHEN 2=$this->intIdEleccion THEN a.AGRUPACION
					                    END descripcion,
					                    CASE 	WHEN 1=$this->intIdEleccion THEN 'UN DEPARTAMENTO'
					                          	WHEN 2=$this->intIdEleccion THEN 'UNA AGRUP. POLITICA' 	
					                    END selector
					                    FROM mesa_sufragio m
										INNER JOIN ubigeo u ON m.ID_UBIGEO = u.ID_UBIGEO
										LEFT JOIN AGRUPACION_POLITICA a ON m.ID_AGRUPACION = a.ID_AGRUPACION
										WHERE m.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion AND m.id_odpe = $this->intIdOdpe
										ORDER BY DESCRIPCION";

		$request = $this->select_all($query);
		return $request;
		
	}


	public function selectCboAgrupacion(int $idprocesos, int $idSolucion, int $idOdpe, int $idAgrupacion, int $idEleccion)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion	= $idSolucion;
		$this->intIdOdpe 		= $idOdpe;
		$this->intIdAgrupacion 	= $idAgrupacion;
		$this->intIdEleccion 	= $idEleccion;

		$query = "SELECT DISTINCT SUBSTR(u.ubigeo,1,2) codigo, u.departamento_ubi
										FROM mesa_sufragio m
										INNER JOIN ubigeo u ON m.ID_UBIGEO = u.ID_UBIGEO
										where m.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion AND m.id_odpe = $this->intIdOdpe AND m.id_agrupacion = $this->intIdAgrupacion
										ORDER BY u.departamento_ubi";

		$request = $this->select_all($query);
		return $request;
		
	}


	public function selectCboProvincia(int $idprocesos, int $idSolucion, int $idOdpe, int $idAgrupacion, string $Departamento, int $idEleccion)
	{
		
		$this->intIdProceso			= $idprocesos;
		$this->intIdSolucion		= $idSolucion;
		$this->intIdOdpe 			= $idOdpe;
		$this->intIdAgrupacion 		= $idAgrupacion;
		$this->strDepartamento		= $Departamento;
		$this->intIdEleccion 		= $idEleccion;

		$query = "SELECT DISTINCT SUBSTR(u.ubigeo,3,2) codigo, u.provincia_ubi
										FROM mesa_sufragio m
										INNER JOIN ubigeo u ON m.ID_UBIGEO = u.ID_UBIGEO
										WHERE m.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion AND m.id_odpe = $this->intIdOdpe 
                    					AND 
										(CASE 	WHEN 1=$this->intIdEleccion AND SUBSTR(u.ubigeo,1,2) =$this->strDepartamento THEN 1
                            					WHEN 2=$this->intIdEleccion AND SUBSTR(u.ubigeo,1,2) =$this->strDepartamento AND m.id_agrupacion =$this->intIdAgrupacion THEN 1
                            					ELSE 0 END) = 1
										ORDER BY u.provincia_ubi";

		$request = $this->select_all($query);
		return $request;
		
	}


	public function selectCboDistrito(int $idprocesos, int $idSolucion, int $idOdpe, int $idAgrupacion, string $Departamento, string $Provincia, int $idEleccion)
	{
		
		$this->intIdProceso			= $idprocesos;
		$this->intIdSolucion		= $idSolucion;
		$this->intIdOdpe 			= $idOdpe;
		$this->intIdAgrupacion 		= $idAgrupacion;
		$this->strDepartamento		= $Departamento;
		$this->strProvincia			= $Provincia;
		$this->intIdEleccion 		= $idEleccion;

		$query = "SELECT DISTINCT SUBSTR(u.ubigeo,5,2) codigo, u.distrito_ubi
                    					FROM mesa_sufragio m
										INNER JOIN UBIGEO u ON m.ID_UBIGEO = u.ID_UBIGEO
										WHERE m.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion AND m.id_odpe = $this->intIdOdpe AND  SUBSTR(u.ubigeo,1,2) = $this->strDepartamento 
					                    AND  
					                    (CASE 	WHEN 1=$this->intIdEleccion AND SUBSTR(u.ubigeo,3,2) = $this->strProvincia THEN 1
					                            WHEN 2=$this->intIdEleccion AND SUBSTR(u.ubigeo,3,2) = $this->strProvincia AND m.id_agrupacion = $this->intIdAgrupacion THEN 1
					                            ELSE 0 END) = 1
										ORDER BY u.distrito_ubi";

		$request = $this->select_all($query);
		return $request;
		
	}


	public function selectCboCedula(int $idMaterial, int $idprocesos, int $idSolucion, int $idOdpe, int $idAgrupacion, string $Departamento, string $Provincia, string $Distrito, int $idEleccion)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdSolucion		= $idSolucion;
		$this->intIdOdpe 			= $idOdpe;
		$this->intIdAgrupacion 		= $idAgrupacion;
		$this->strDepartamento		= $Departamento;
		$this->strProvincia			= $Provincia;
		$this->strDistrito			= $Distrito;
		$this->intIdEleccion 		= $idEleccion;

		$query = "SELECT DISTINCT cp.suf_ubigeo, cp.tipo_cedula
										FROM mesa_sufragio m
										INNER JOIN UBIGEO u ON m.ID_UBIGEO = u.ID_UBIGEO
										INNER JOIN cedula_proceso cp ON m.id_consulta = cp.id_consulta AND  cp.id_material = $this->intIdMaterial AND cp.ID_PROCESO = $this->intIdProceso
										WHERE m.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion AND m.id_odpe = $this->intIdOdpe AND  SUBSTR(u.ubigeo,1,2) = $this->strDepartamento AND  SUBSTR(u.ubigeo,3,2) = $this->strProvincia
										AND  
                    					(CASE 	WHEN 1=$this->intIdEleccion AND SUBSTR(u.ubigeo,5,2) = $this->strDistrito THEN 1
					                            WHEN 2=$this->intIdEleccion AND SUBSTR(u.ubigeo,5,2) = $this->strDistrito AND m.id_agrupacion = $this->intIdAgrupacion THEN 1
					                            ELSE 0 END) = 1
										order by cp.tipo_cedula ASC";

		$request = $this->select_all($query);
		return $request;
		
	}


	public function selectinpBarra(int $idMaterial, int $idprocesos, int $idSolucion, int $idOdpe, int $idAgrupacion, string $Departamento, string $Provincia, string $Distrito, string $consulta, int $idEleccion)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdSolucion		= $idSolucion;
		$this->intIdOdpe 			= $idOdpe;
		$this->intIdAgrupacion 		= $idAgrupacion;
		$this->strDepartamento		= $Departamento;
		$this->strProvincia			= $Provincia;
		$this->strDistrito			= $Distrito;
		$this->strConsulta			= $consulta;
		$this->intIdEleccion 		= $idEleccion;

		$query = "SELECT DISTINCT cp.suf_ubigeo, cp.tipo_cedula, cp.id_barra, cp.dig_ubigeo, cp.pref_ubigeo, cp.dig_rotulo, cp.pref_rotulo, cp.suf_rotulo, cp.id_consulta, cp.cod_consulta
										FROM mesa_sufragio m
										INNER JOIN UBIGEO u ON m.ID_UBIGEO = u.ID_UBIGEO
										INNER JOIN cedula_proceso cp ON m.id_consulta = cp.id_consulta AND  cp.id_material = $this->intIdMaterial AND cp.id_proceso = $this->intIdProceso
										WHERE m.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion AND m.id_odpe = $this->intIdOdpe AND  SUBSTR(u.ubigeo,1,2) = $this->strDepartamento AND  SUBSTR(u.ubigeo,3,2) = $this->strProvincia AND SUBSTR(u.ubigeo,5,2) = $this->strDistrito 
					                    AND  
					                    (CASE 	WHEN 1=$this->intIdEleccion AND cp.suf_ubigeo = '{$this->strConsulta}' THEN 1
					                            WHEN 2=$this->intIdEleccion AND cp.suf_ubigeo = '{$this->strConsulta}' AND m.id_agrupacion = $this->intIdAgrupacion THEN 1
					                            ELSE 0 END) = 1
										ORDER BY cp.id_barra DESC";

		$request = $this->select($query);
		return $request;
		
	}
	

	/*public function validarMesaCbo(int $idprocesos, int $idSolucion, int $idOdpe, string $Departamento, string $Provincia, string $Distrito,  string $nroMesa, string $nroElectores, string $nroUbigeo, int $idValor)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion	= $idSolucion;
		$this->intIdOdpe		= $idOdpe;
		$this->strNroElectores	= $nroElectores;
		$this->strDepartamento	= $Departamento;
		$this->strProvincia		= $Provincia;
		$this->strDistrito		= $Distrito;
		$this->strNroMesa		= $nroMesa;
		$this->strNroUbigeo		= $nroUbigeo;
		$this->intIdValor		= $idValor;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_CBOMESA( :P_ID_PROCESO, :P_NROMESA, :P_ID_SOLUCION, :P_ID_ODPE, :P_ELECTORES, :P_DEPART, :P_PROV, :P_DIST, :P_UBIGEO, :P_VALOR, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);	
		oci_bind_by_name($stid, ':P_ID_SOLUCION', $this->intIdSolucion);
		oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
		oci_bind_by_name($stid, ':P_ELECTORES', $this->strNroElectores);
		oci_bind_by_name($stid, ':P_DEPART', $this->strDepartamento);
		oci_bind_by_name($stid, ':P_PROV', $this->strProvincia);
		oci_bind_by_name($stid, ':P_DIST', $this->strDistrito);
		oci_bind_by_name($stid, ':P_UBIGEO', $this->strNroUbigeo);
		oci_bind_by_name($stid, ':P_VALOR', $this->intIdValor);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}*/

	public function validarUbigeoExiste(int $idprocesos, string $nroUbigeo, int $idValor)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroUbigeo		= $nroUbigeo;
		$this->intIdValor		= $idValor;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_UBIGEO_EXISTE( :P_ID_PROCESO, :P_UBIGEO, :P_VALOR, :P_ID_UBIGEO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_UBIGEO', $this->strNroUbigeo);
		oci_bind_by_name($stid, ':P_VALOR', $this->intIdValor);
		oci_bind_by_name($stid, ':P_ID_UBIGEO', $P_ID_UBIGEO, 40);
		oci_execute($stid);
		
		if($P_ID_UBIGEO == 0){
			return 0;
		}else{
			return $P_ID_UBIGEO;
		}

	}


	/*public function validarMesaExiste(int $idprocesos, string $nroMesa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_EXISTE( :P_ID_PROCESO, :P_NROMESA, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}*/


	/*public function validarMesaSoltec(int $idprocesos, string $idSoltec, string $nroMesa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;
		$this->idSoltec 		= $idSoltec;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_SOLTEC( :P_ID_PROCESO, :P_NROMESA, :P_ID_SOLUCION, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_ID_SOLUCION', $this->idSoltec);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}*/


	/*public function validarMesaOdpe(int $idprocesos, int $idOdpe, string $nroMesa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;
		$this->intIdOdpe		= $idOdpe;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_ODPE( :P_ID_PROCESO, :P_NROMESA, :P_ID_ODPE, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}*/


	/*public function validarMesaDepart(int $idprocesos, string $Departamento, string $nroMesa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;
		$this->strDepartamento	= $Departamento;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_DEPART( :P_ID_PROCESO, :P_NROMESA, :P_DEPART, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_DEPART', $this->strDepartamento);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}*/


	/*public function validarMesaProv(int $idprocesos, string $Provincia, string $nroMesa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;
		$this->strProvincia		= $Provincia;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_PROV( :P_ID_PROCESO, :P_NROMESA, :P_PROV, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_PROV', $this->strProvincia);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}*/


	/*public function validarMesaDist(int $idprocesos, string $Distrito, string $nroMesa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;
		$this->strDistrito		= $Distrito;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_DIST( :P_ID_PROCESO, :P_NROMESA, :P_DIST, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_DIST', $this->strDistrito);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}*/


	/*public function validarMesaElect(int $idprocesos, string $nroElectores, string $nroMesa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;
		$this->strNroElectores	= $nroElectores;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_ELECT( :P_ID_PROCESO, :P_NROMESA, :P_ELECTORES, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_ELECTORES', $this->strNroElectores);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}*/


	/*public function validarMesaUbigeo(int $idprocesos, string $nroUbigeo, string $nroMesa, int $idValor)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;
		$this->strNroUbigeo		= $nroUbigeo;
		$this->intIdValor		= $idValor;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_UBIGEO( :P_ID_PROCESO, :P_NROMESA, :P_UBIGEO, :P_VALOR, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_UBIGEO', $this->strNroUbigeo);
		oci_bind_by_name($stid, ':P_VALOR', $this->intIdValor);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}
*/

	public function IncidenciaExiste(int $idMaterial, int $idprocesos, int $idEtapa, string $nroMesa, string $consulta, string $cboUbigeo)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->strNroMesa	 		= $nroMesa;
		$this->strConsulta			= $consulta;
		$this->strCboUbigeo			= $cboUbigeo;

		$query = "	SELECT ROTULO
					FROM control_incidencia
					WHERE id_proceso= $this->intIdProceso 
					AND id_material= $this->intIdMaterial
					AND id_etapa= $this->intIdEtapa
					AND rotulo= '{$this->strNroMesa}' 
					AND paquete = '{$this->strConsulta}' 
					AND ubigeo = '{$this->strCboUbigeo}'
					AND estado IN (1,2)";

		$request = $this->select($query);
		return $request;

	}


	public function MesaPasoEtapa( int $idMaterial, int $idprocesos, int $idEtapa, string $nroMesa,  int $idSoltec, string $consulta,  int $validacion, string $cboUbigeo)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->strNroMesa	 		= $nroMesa;
		$this->intIdSolucion 		= $idSoltec;
		$this->strConsulta			= $consulta;
		$this->intIdValidacion		= $validacion;
		$this->strCboUbigeo			= $cboUbigeo;

		$query = "	SELECT rotulo
					FROM control_calidad
					WHERE id_proceso= $this->intIdProceso 
                    AND rotulo='{$this->strNroMesa}' 
                    AND id_material= $this->intIdMaterial
                    AND id_etapa= $this->intIdEtapa
                    AND paquete='{$this->strConsulta}' 
                    AND validacion= $this->intIdValidacion
                    AND ubigeo = '{$this->strCboUbigeo}' ";

		$request = $this->select($query);
		return $request;

	}


	public function MesaExisteControl( int $idMaterial, int $idprocesos, int $idEtapa, string $nroMesa,  int $idSoltec, string $consulta,  int $validacion, string $cboUbigeo)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->strNroMesa	 		= $nroMesa;
		$this->intIdSolucion 		= $idSoltec;
		$this->strConsulta			= $consulta;
		$this->intIdValidacion		= $validacion;
		$this->strCboUbigeo			= $cboUbigeo;

		$query = "	SELECT rotulo 
                    FROM CONTROL_CALIDAD
                    WHERE ID_PROCESO = $this->intIdProceso
                    AND ID_MATERIAL = $this->intIdMaterial 
                    AND ID_ETAPA = $this->intIdEtapa 
                    AND ID_SOLUCION= $this->intIdSolucion 
                    AND ROTULO = '{$this->strNroMesa}' 
                    AND paquete = '{$this->strConsulta}' 
                    AND validacion= $this->intIdValidacion
                    AND ubigeo = '{$this->strCboUbigeo}'";

		$request = $this->select($query);
		return $request;

	}


	public function insertCedula(int $idMaterial, int $idprocesos, int $idEtapa, int $idSoltec, int $idOdpe, string $nroMesa, string $consulta, int $validacion, int $idUsuario, string $nroUbigeo)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdSolucion 		= $idSoltec;
		$this->intIdOdpe	 		= $idOdpe;
		$this->strNroMesa	 		= $nroMesa;
		$this->strConsulta			= $consulta;
		$this->intIdValidacion		= $validacion;
		$this->intIdUsusario		= $idUsuario;
		$this->strNroUbigeo			= $nroUbigeo;

		
		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_RESERVA_INSERTAR( :P_ID_MATERIAL, :P_ID_PROCESO, :P_ID_ETAPA, :P_ID_SOLUCION, :P_ID_ODPE, :P_NRORESERVA, :P_CONSULTA, :P_ID_VALIDACION, :P_ID_USUARIO, :P_NROUBIGEO, :P_ID_RESERVA); END;');
		
		oci_bind_by_name($stid, ':P_ID_MATERIAL', $this->intIdMaterial);
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_ID_ETAPA', $this->intIdEtapa);
		oci_bind_by_name($stid, ':P_ID_SOLUCION', $this->intIdSolucion);
		oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
		oci_bind_by_name($stid, ':P_NRORESERVA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_CONSULTA', $this->strConsulta);
		oci_bind_by_name($stid, ':P_ID_VALIDACION', $this->intIdValidacion);
		oci_bind_by_name($stid, ':P_ID_USUARIO', $this->intIdUsusario);
		oci_bind_by_name($stid, ':P_NROUBIGEO', $this->strNroUbigeo);
		oci_bind_by_name($stid, ':P_ID_RESERVA', $P_ID_RESERVA, 40);
		oci_execute($stid);
		
		if($P_ID_RESERVA == 0){
			return 0;
		}else{
			return $P_ID_RESERVA;
		}

	}
	

	public function updateCedula(int $idMaterial, int $idprocesos, int $idEtapa, int $idSoltec, int $idOdpe, string $nroMesa, string $consulta, int $validacion, string $nroUbigeo)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdSolucion 		= $idSoltec;
		$this->intIdOdpe	 		= $idOdpe;
		$this->strNroMesa	 		= $nroMesa;
		$this->strConsulta			= $consulta;
		$this->intIdValidacion		= $validacion;
		$this->strNroUbigeo			= $nroUbigeo;

		
		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_RESERVA_UPDATE( :P_ID_MATERIAL, :P_ID_PROCESO, :P_ID_ETAPA, :P_ID_SOLUCION, :P_ID_ODPE, :P_NRORESERVA, :P_CONSULTA, :P_ID_VALIDACION, :P_NROUBIGEO, :P_ID_RESERVA); END;');
		
		oci_bind_by_name($stid, ':P_ID_MATERIAL', $this->intIdMaterial);
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_ID_ETAPA', $this->intIdEtapa);
		oci_bind_by_name($stid, ':P_ID_SOLUCION', $this->intIdSolucion);
		oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
		oci_bind_by_name($stid, ':P_NRORESERVA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_CONSULTA', $this->strConsulta);
		oci_bind_by_name($stid, ':P_ID_VALIDACION', $this->intIdValidacion);
		oci_bind_by_name($stid, ':P_NROUBIGEO', $this->strNroUbigeo);
		oci_bind_by_name($stid, ':P_ID_RESERVA', $P_ID_RESERVA, 40);
		oci_execute($stid);
		
		if($P_ID_RESERVA == 0){
			return 0;
		}else{
			return $P_ID_RESERVA;
		}

	}



	public function ordenEmpaquetado(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, string $Departamento, string $Provincia, string $Distrito, string $consulta, int $validacion, string $nroUbigeo)

	{

		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdSolucion 		= $idSoltec;
		$this->intIdOdpe	 		= $idOdpe;
		$this->strDepartamento		= $Departamento;
		$this->strProvincia			= $Provincia;
		$this->strDistrito			= $Distrito;
		$this->strConsulta			= $consulta;
		$this->intIdValidacion		= $validacion;
		$this->strNroUbigeo			= $nroUbigeo;

		/*$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_MESA_ORDENAMIENTO( :P_ID_MATERIAL, :P_ID_PROCESO, :P_ID_ETAPA, :P_ID_FASE, :P_ID_SOLUCION, :P_ID_ODPE, :P_DEPART, :P_PROV, :P_DIST, :P_NROMESA, :P_CONSULTA, :P_ID_VALIDACION, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_MATERIAL', $this->intIdMaterial);
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_ID_ETAPA', $this->intIdEtapa);
		oci_bind_by_name($stid, ':P_ID_FASE', $this->idFase);
		oci_bind_by_name($stid, ':P_ID_SOLUCION', $this->intIdSolucion);
		oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
		oci_bind_by_name($stid, ':P_DEPART', $this->strDepartamento);
		oci_bind_by_name($stid, ':P_PROV', $this->strProvincia);
		oci_bind_by_name($stid, ':P_DIST', $this->strDistrito);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_CONSULTA', $this->strConsulta);
		oci_bind_by_name($stid, ':P_ID_VALIDACION', $this->intIdValidacion);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}*/

		$query = "	SELECT * 
					FROM ( SELECT * FROM
								(SELECT LPAD(rotulo+1,4,0) ROTULO
								FROM control_calidad cc 
								WHERE cc.id_proceso=$this->intIdProceso
								AND cc.id_material=$this->intIdMaterial 
								AND cc.id_etapa=$this->intIdEtapa
								AND cc.paquete='{$this->strConsulta}' 
								AND cc.validacion=$this->intIdValidacion 
								AND cc.ubigeo = '{$this->strNroUbigeo}'
								ORDER BY ROTULO DESC) T1,
								
								(SELECT o.nombre_odpe, u.departamento_ubi, u.provincia_ubi, u.distrito_ubi, ST.SOLUCIONTECNOLOGICA codigo_solucion
								FROM mesa_sufragio m
								LEFT JOIN UBIGEO U ON M.ID_UBIGEO = U.ID_UBIGEO
								LEFT JOIN ODPE O ON M.ID_ODPE = O.ID_ODPE
                        		LEFT JOIN SOLUCIONTECNOLOGICA st ON M.ID_SOLUCION = st.ID_SOLUCIONTECNOLOGICA 
								WHERE m.id_proceso=$this->intIdProceso 
								AND m.id_fase=$this->intIdFase 
								AND m.id_solucion=$this->intIdSolucion
								AND m.id_odpe=$this->intIdOdpe
								AND substr(u.ubigeo,1,2) ='{$this->strDepartamento}' 
								AND substr(u.ubigeo,3,2)='{$this->strProvincia}' 
								AND SUBSTR(u.ubigeo,5,2) = '{$this->strDistrito}' 
								ORDER BY  o.nombre_odpe, u.departamento_ubi, u.provincia_ubi, u.distrito_ubi, ST.SOLUCIONTECNOLOGICA ASC) T2
					)WHERE ROWNUM = 1";

		$request = $this->select($query);
		return $request;

	}



	public function avanceFase(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $validacion)
	{

		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdValidacion		= $validacion;

		$query = "	SELECT 'PAQUETES' AS TIPO , COUNT(1) AS TOTAL_RESERVA
					FROM CONTROL_CALIDAD
					WHERE ID_PROCESO = $this->intIdProceso AND ID_MATERIAL= $this->intIdMaterial AND ID_ETAPA = $this->intIdEtapa AND VALIDACION = $this->intIdValidacion";

		$request = $this->select_all($query);
		return $request;

	}


	public function avanceOdpe(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idOdpe,  int $validacion)
	{
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdOdpe			= $idOdpe;
		$this->intIdValidacion		= $validacion;


		$query = "	SELECT ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION, COUNT( CC.ID_ODPE) AS CANTIDAD
					FROM CONTROL_CALIDAD CC
					INNER JOIN ODPE O ON O.ID_ODPE = CC.ID_ODPE
					LEFT JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = CC.ID_SOLUCION
					INNER JOIN SOLUCION_PROCESO SP ON CC.ID_SOLUCION = SP.ID_SOLUCION AND SP.ID_PROCESO=$this->intIdProceso 
					WHERE CC.ID_PROCESO = $this->intIdProceso AND CC.ID_ODPE=$this->intIdOdpe AND CC.ID_ETAPA=$this->intIdEtapa AND CC.ID_MATERIAL=$this->intIdMaterial AND CC.VALIDACION = $this->intIdValidacion
					GROUP BY O.NOMBRE_ODPE,ST.SOLUCIONTECNOLOGICA";

		$request = $this->select_all($query);
		return $request;
	}


	public function mesasEscaneadas(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, string $consulta,  int $validacion, int $idValor)
	{
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdSolucion		= $idSoltec;
		$this->intIdOdpe			= $idOdpe;
		$this->strConsulta			= $consulta;
		$this->intIdValidacion		= $validacion;
		$this->intIdValor			= $idValor;


		$query = "	SELECT U.UBIGEO, ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION, PC.TIPO_CEDULA, U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI,PC.PREF_ROTULO || PC.SUF_ROTULO || CC.ROTULO AS NRO_MESA, PC.SUF_ROTULO AS NRO_ELECTORES
					FROM CONTROL_CALIDAD CC
					LEFT JOIN UBIGEO U ON U.UBIGEO = CC.UBIGEO
					INNER JOIN SOLUCION_PROCESO SP ON CC.ID_SOLUCION = SP.ID_SOLUCION  
					INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = SP.ID_SOLUCION AND SP.ID_PROCESO = $this->intIdProceso
					INNER JOIN CEDULA_PROCESO PC on CC.PAQUETE = PC.SUF_UBIGEO and PC.ID_PROCESO =$this->intIdProceso AND PC.ID_MATERIAL=$this->intIdMaterial
					WHERE CC.ID_PROCESO = $this->intIdProceso 
					AND CC.ID_MATERIAL = $this->intIdMaterial
					AND CC.ID_SOLUCION = $this->intIdSolucion
					AND CC.ID_ETAPA = $this->intIdEtapa 
					AND CC.VALIDACION = $this->intIdValidacion 
					AND (CASE 	WHEN 1 = $this->intIdValor AND CC.ID_ODPE = $this->intIdOdpe THEN 1  
					            WHEN 2 = $this->intIdValor AND CC.ID_ODPE = $this->intIdOdpe AND CC.PAQUETE = '{$this->strConsulta}' THEN 1  
					            ELSE 0 END) = 1
					--GROUP BY U.UBIGEO,ST.SOLUCIONTECNOLOGICA, U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI,CC.ROTULO, PC.TIPO_CEDULA,PC.SUF_ROTULO,PC.PREF_ROTULO
					ORDER BY U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, CC.ROTULO, PC.TIPO_CEDULA";

		$request = $this->select_all($query);
		return $request;
	}


	/*public function mesasFaltantes(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, string $consulta,  int $validacion, int $idValor)
	{
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdSolucion		= $idSoltec;
		$this->intIdOdpe			= $idOdpe;
		$this->strConsulta			= $consulta;
		$this->intIdValidacion		= $validacion;
		$this->intIdValor			= $idValor;


		$query = "	SELECT ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION,C.CONSULTA,U.DEPARTAMENTO_UBI,U.PROVINCIA_UBI,U.DISTRITO_UBI,S.NRO_MESA,S.NRO_ELECTORES  
				    FROM MESA_SUFRAGIO S  
				    INNER JOIN SOLUCION_PROCESO SP ON S.ID_SOLUCION = SP.ID_SOLUCION  
				    INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = SP.ID_SOLUCION AND SP.ID_PROCESO=$this->intIdProceso
				    INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA= S.ID_CONSULTA  
				    INNER JOIN CONSULTA C ON C.ID_CONSULTA= CP.ID_CONSULTA AND CP.ID_PROCESO=$this->intIdProceso
                    LEFT JOIN UBIGEO U ON S.ID_UBIGEO = U.ID_UBIGEO
                    LEFT JOIN LOCAL L ON S.ID_LOCAL = L.ID_LOCAL
				    WHERE 	S.ID_PROCESO = $this->intIdProceso  
				            AND S.ID_ODPE = $this->intIdOdpe 
				            AND S.ID_SOLUCION = $this->intIdSolucion 
				            AND S.ID_SUFRAGIO NOT IN (  SELECT CC.ID_SUFRAGIO  
				                                        FROM CONTROL_CALIDAD CC 
				                                        WHERE 	CC.ID_ETAPA = $this->intIdEtapa 
				                                                AND CC.ID_MATERIAL = $this->intIdMaterial
				                                                AND CC.ID_PROCESO = $this->intIdProceso 
				                                                AND CC.ID_SOLUCION = $this->intIdSolucion
				                                                AND CC.VALIDACION = $this->intIdValidacion
				                                                AND (	CASE 	WHEN 1 = $this->intIdValor AND CC.ID_ODPE = $this->intIdOdpe THEN 1  
				                                                             	WHEN 2 = $this->intIdValor AND CC.ID_ODPE = $this->intIdOdpe AND CC.PAQUETE = 'G' THEN 1  
				                                                        ELSE 0 END) = 1)  
				    ORDER BY U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.CODIGO_LOCAL, S.NRO_MESA";

		$request = $this->select_all($query);
		return $request;
	}*/


	public function selectCboIncidencia(int $idEtapa)
	{
		
		$this->intIdEtapa = $idEtapa;

		$query = "	SELECT i.id_incidencia, i.incidencia
                                        FROM incidencia i
                                       	INNER JOIN incidencia_etapa ie On i.id_incidencia=ie.id_incidencia
                                        WHERE ie.id_etapa=$this->intIdEtapa
                                        ORDER BY id_incidencia";

		$request = $this->select_all($query);
		return $request;

	}





	public function insertIncidencia(int $idMaterial, int $idprocesos, int $idEtapa,  int $idOdpe, int $idIncidencia ,string $nroMesa, int $cantidad, string $consulta, string $nroUbigeo, int $idUsuario)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdOdpe	 		= $idOdpe;
		$this->intIdIncidencia		= $idIncidencia;
		$this->strNroMesa	 		= $nroMesa;
		$this->intCantidad			= $cantidad;
		$this->strConsulta			= $consulta;
		$this->strNroUbigeo			= $nroUbigeo;
		$this->intIdUsusario		= $idUsuario;

		
		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_INCIDEN_INSERT_RES( :P_ID_MATERIAL, :P_ID_PROCESO, :P_ID_ETAPA, :P_ID_ODPE, :P_ID_INCIDENCIA, :P_NRORESERVA, :P_CANTIDAD, :P_CONSULTA, :P_NROUBIGEO, :P_ID_USUARIO, :P_ID_RESERVA_CI); END;');
		
		oci_bind_by_name($stid, ':P_ID_MATERIAL', $this->intIdMaterial);
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_ID_ETAPA', $this->intIdEtapa);
		oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
		oci_bind_by_name($stid, ':P_ID_INCIDENCIA', $this->intIdIncidencia);
		oci_bind_by_name($stid, ':P_NRORESERVA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_CANTIDAD', $this->intCantidad);
		oci_bind_by_name($stid, ':P_CONSULTA', $this->strConsulta);
		oci_bind_by_name($stid, ':P_NROUBIGEO', $this->strNroUbigeo);
		oci_bind_by_name($stid, ':P_ID_USUARIO', $this->intIdUsusario);
		oci_bind_by_name($stid, ':P_ID_RESERVA_CI', $P_ID_RESERVA_CI, 40);
		oci_execute($stid);
		
		/*if($P_ID_RESERVA_CI == 0){
			return 0;
		}else{
			return $P_ID_RESERVA_CI;
		}*/
		return $P_ID_RESERVA_CI;
	}
}


?>
