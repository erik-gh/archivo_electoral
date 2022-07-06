<?php 

/**
* 
*/
class Control_actaModel extends Oracle
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



	public function selectCboMaterial(int $idprocesos)
	{
		
		$this->intIdProceso = $idprocesos;

		$query = "	SELECT DISTINCT M.ID_MATERIAL,M.MATERIAL
										FROM MATERIAL M
										INNER JOIN MATERIAL_PROCESO MP ON M.ID_MATERIAL = MP.ID_MATERIAL
										where MP.ID_PROCESO = $this->intIdProceso AND M.ID_MATERIAL IN (2,3,4,5)
										ORDER BY M.ID_MATERIAL";

		$request = $this->select_all($query);
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


	public function selectinpBarra(int $idMaterial, int $idprocesos)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		
		$query = " SELECT ap.digito, ap.codigo
										FROM material m
										INNER JOIN acta_proceso ap ON m.id_material = ap.id_material
										WHERE  m.id_material=$this->intIdMaterial AND ap.id_proceso = $this->intIdProceso
										ORDER BY m.id_material";

		$request = $this->select($query);
		return $request;
		
	}
	

	public function selectinpBarraEmparejamiento(int $idprocesos)
	{
		
		$this->intIdProceso			= $idprocesos;
		
		$query = " SELECT ap.id_material, m.material, ap.digito, ap.codigo
										FROM material m
										INNER JOIN acta_proceso ap ON m.id_material = ap.id_material
										WHERE ap.id_proceso=$this->intIdProceso AND ap.id_material IN (2,4)
										ORDER BY m.id_material ";

		$request = $this->select_all($query);
		return $request;
		
	}


	public function validarMesaExiste(int $idprocesos, string $nroMesa)
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

	}


	public function validarMesaSoltec(int $idprocesos, string $idSoltec, string $nroMesa)
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

	}


	public function validarMesaOdpe(int $idprocesos, int $idOdpe, string $nroMesa)
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

	}


	public function validarMesaAgrupacion(int $idprocesos, int $idAgrupacion, string $nroMesa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;
		$this->intIdAgrupacion	= $idAgrupacion;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_AGRUPACION( :P_ID_PROCESO, :P_NROMESA, :P_ID_AGRUPACION, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_ID_AGRUPACION', $this->intIdAgrupacion);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}


	public function validarMesaDepart(int $idprocesos, string $Departamento, string $nroMesa)
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

	}


	public function validarMesaProv(int $idprocesos, string $Departamento, string $Provincia, string $nroMesa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;
		$this->strDepartamento	= $Departamento;
		$this->strProvincia		= $Provincia;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_PROV( :P_ID_PROCESO, :P_NROMESA, :P_DEPART, :P_PROV, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_DEPART', $this->strDepartamento);
		oci_bind_by_name($stid, ':P_PROV', $this->strProvincia);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}


	public function validarMesaDist(int $idprocesos, string $Departamento, string $Provincia, string $Distrito, string $nroMesa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->strNroMesa		= $nroMesa;
		$this->strDepartamento	= $Departamento;
		$this->strProvincia		= $Provincia;
		$this->strDistrito		= $Distrito;

		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_DIST( :P_ID_PROCESO, :P_NROMESA, :P_DEPART, :P_PROV, :P_DIST, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_DEPART', $this->strDepartamento);
		oci_bind_by_name($stid, ':P_PROV', $this->strProvincia);
		oci_bind_by_name($stid, ':P_DIST', $this->strDistrito);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}


	public function IncidenciaExiste(int $idMaterial, int $idprocesos, int $idEtapa, string $nroMesa)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->strNroMesa	 		= $nroMesa;

		$query = "	SELECT ci.ID_SUFRAGIO
					FROM control_incidencia ci 
					WHERE ci.id_proceso=$this->intIdProceso 
                    AND ci.id_material=$this->intIdMaterial 
                    AND ci.id_etapa=$this->intIdEtapa 
                    AND ci.estado IN (1,2) AND ci.ID_SUFRAGIO = (
                                                                  	SELECT ms.ID_SUFRAGIO 
                                                                  	FROM MESA_SUFRAGIO ms 
                                                                  	WHERE ms.NRO_MESA = '{$this->strNroMesa}' AND ms.id_proceso=$this->intIdProceso )";

		$request = $this->select($query);
		return $request;

	}


	public function MesaPasoEtapa( int $idMaterial, int $idprocesos, int $idEtapa, string $nroMesa,  int $idSoltec, int $validacion, string $nroUbigeo)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->strNroMesa	 		= $nroMesa;
		$this->intIdSolucion 		= $idSoltec;
		$this->intIdValidacion		= $validacion;
		$this->strNroUbigeo			= $nroUbigeo;

		$query = "	SELECT cc.ID_SUFRAGIO
					FROM control_calidad cc
					WHERE cc.id_proceso = $this->intIdProceso
                    AND cc.id_material = $this->intIdMaterial
                    AND cc.validacion = $this->intIdValidacion
                    AND cc.ubigeo = '{$this->strNroUbigeo}'
                    AND cc.id_etapa= $this->intIdEtapa
                    AND cc.id_sufragio=(
                                        	SELECT ms.ID_SUFRAGIO 
                                        	FROM MESA_SUFRAGIO ms 
                                        	WHERE ms.NRO_MESA = '{$this->strNroMesa}' AND ms.id_proceso=$this->intIdProceso )";

		$request = $this->select($query);
		return $request;

	}


	public function MesaExisteControl( int $idMaterial, int $idprocesos, int $idEtapa, string $nroMesa,  int $idSoltec, int $validacion, string $nroUbigeo)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->strNroMesa	 		= $nroMesa;
		$this->intIdSolucion 		= $idSoltec;
		$this->intIdValidacion		= $validacion;
		$this->strNroUbigeo			= $nroUbigeo;

		$query = "	SELECT cc.ID_SUFRAGIO 
                   	FROM CONTROL_CALIDAD cc
                    WHERE cc.ID_PROCESO = $this->intIdProceso
                    AND cc.ID_MATERIAL = $this->intIdMaterial
                    AND cc.ID_ETAPA =  $this->intIdEtapa
                    AND cc.ID_SOLUCION= $this->intIdSolucion 
                    AND cc.VALIDACION =$this->intIdValidacion
                    AND cc.UBIGEO = '{$this->strNroUbigeo}'
                    AND cc.ID_SUFRAGIO = (
                                            SELECT ms.ID_SUFRAGIO 
                                            FROM MESA_SUFRAGIO ms 
                                            WHERE ms.NRO_MESA = '{$this->strNroMesa}' AND ms.id_proceso=$this->intIdProceso )";

		$request = $this->select($query);
		return $request;

	}


	public function insertActa(int $idMaterial, int $idprocesos, int $idEtapa, int $idSoltec, int $idOdpe, string $nroMesa, int $validacion, int $idUsuario, string $nroUbigeo)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdSolucion 		= $idSoltec;
		$this->intIdOdpe	 		= $idOdpe;
		$this->strNroMesa	 		= $nroMesa;
		$this->intIdValidacion		= $validacion;
		$this->intIdUsusario		= $idUsuario;
		$this->strNroUbigeo			= $nroUbigeo;

		
		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_ACTA_INSERTAR( :P_ID_MATERIAL, :P_ID_PROCESO, :P_ID_ETAPA, :P_ID_SOLUCION, :P_ID_ODPE, :P_NROMESA, :P_ID_VALIDACION, :P_ID_USUARIO, :P_NROUBIGEO, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_MATERIAL', $this->intIdMaterial);
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_ID_ETAPA', $this->intIdEtapa);
		oci_bind_by_name($stid, ':P_ID_SOLUCION', $this->intIdSolucion);
		oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_ID_VALIDACION', $this->intIdValidacion);
		oci_bind_by_name($stid, ':P_ID_USUARIO', $this->intIdUsusario);
		oci_bind_by_name($stid, ':P_NROUBIGEO', $this->strNroUbigeo);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
		oci_execute($stid);
		
		if($P_ID_SUFRAGIO == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO;
		}

	}
	


	public function ordenEmparejamiento(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, string $Departamento, string $Provincia, string $Distrito,  int $validacion)

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
		$this->intIdValidacion		= $validacion;

		$query = "	SELECT * FROM (
		                SELECT U.DEPARTAMENTO_UBI,U.PROVINCIA_UBI, U.DISTRITO_UBI, 
		                  L.CODIGO_LOCAL, L.NOMBRE_LOCAL, M.NRO_MESA, ST.SOLUCIONTECNOLOGICA
		                FROM MESA_SUFRAGIO M
		                LEFT JOIN UBIGEO U ON M.ID_UBIGEO = U.ID_UBIGEO
		                LEFT JOIN LOCAL L ON M.ID_LOCAL = L.ID_LOCAL
		                LEFT JOIN SOLUCIONTECNOLOGICA st ON M.ID_SOLUCION = st.ID_SOLUCIONTECNOLOGICA 
		                WHERE M.ID_PROCESO=$this->intIdProceso	 
		                AND M.ID_FASE=$this->intIdFase
		                AND M.ID_SOLUCION=$this->intIdSolucion
		                AND M.ID_ODPE=$this->intIdOdpe
		                AND SUBSTR(U.UBIGEO,1,2) ='{$this->strDepartamento}' 
		                AND SUBSTR(U.UBIGEO,3,2)='{$this->strProvincia}' 
		                AND SUBSTR(U.UBIGEO,5,2) = '{$this->strDistrito}'      
		                AND M.ID_SUFRAGIO NOT IN( 	SELECT CC.ID_SUFRAGIO 
			                                        FROM CONTROL_CALIDAD CC 
			                                        WHERE CC.ID_PROCESO=$this->intIdProceso	 
			                                        AND CC.ID_MATERIAL=$this->intIdMaterial 
			                                        AND CC.ID_ETAPA= $this->intIdEtapa
			                                        AND CC.ID_ODPE=$this->intIdOdpe 
			                                        AND CC.VALIDACION=$this->intIdValidacion) 

		                ORDER BY  L.CODIGO_LOCAL, L.NOMBRE_LOCAL, M.NRO_MESA ASC)
					WHERE ROWNUM = 1";

		$request = $this->select($query);
		return $request;

	}


	public function ordenEmparejamientoEI(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, string $Departamento, string $Provincia, string $Distrito,  int $validacion)

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
		$this->intIdValidacion		= $validacion;

		$query = "	SELECT * FROM (
		                SELECT U.DEPARTAMENTO_UBI,U.PROVINCIA_UBI, U.DISTRITO_UBI, 
		                  L.CODIGO_LOCAL, L.NOMBRE_LOCAL, M.NRO_MESA, ST.SOLUCIONTECNOLOGICA, C.CONSULTA, AP.AGRUPACION, M.COD_TIPO 
		                FROM MESA_SUFRAGIO M
		                LEFT JOIN UBIGEO U ON M.ID_UBIGEO = U.ID_UBIGEO
		                LEFT JOIN LOCAL L ON M.ID_LOCAL = L.ID_LOCAL
		                LEFT JOIN SOLUCIONTECNOLOGICA st ON M.ID_SOLUCION = st.ID_SOLUCIONTECNOLOGICA
						INNER JOIN AGRUPACION_POLITICA AP ON AP.ID_AGRUPACION = M.ID_AGRUPACION
						INNER JOIN CONSULTA C ON C.ID_CONSULTA = M.ID_CONSULTA AND M.ID_PROCESO = $this->intIdProceso
						INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA = M.ID_CONSULTA AND CP.ID_PROCESO = $this->intIdProceso
		                WHERE M.ID_PROCESO=$this->intIdProceso	 
		                AND M.ID_FASE=$this->intIdFase
		                AND M.ID_SOLUCION=$this->intIdSolucion
		                AND M.ID_ODPE=$this->intIdOdpe
		                AND SUBSTR(U.UBIGEO,1,2) ='{$this->strDepartamento}' 
		                AND SUBSTR(U.UBIGEO,3,2)='{$this->strProvincia}' 
		                AND SUBSTR(U.UBIGEO,5,2) = '{$this->strDistrito}'      
		                AND M.ID_SUFRAGIO NOT IN( 	SELECT CC.ID_SUFRAGIO 
			                                        FROM CONTROL_CALIDAD CC 
			                                        WHERE CC.ID_PROCESO=$this->intIdProceso	 
			                                        AND CC.ID_MATERIAL=$this->intIdMaterial 
			                                        AND CC.ID_ETAPA= $this->intIdEtapa
			                                        AND CC.ID_ODPE=$this->intIdOdpe 
			                                        AND CC.VALIDACION=$this->intIdValidacion) 

		                ORDER BY  L.CODIGO_LOCAL, L.NOMBRE_LOCAL, C.CONSULTA, M.COD_TIPO, AP.CODIGO_AGRUPACION, M.NRO_MESA ASC)
					WHERE ROWNUM = 1";

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

		$where = ($idMaterial == 5) ? " AND m.id_solucion=2": "" ;

		$query = "	SELECT 	COUNT(M.ID_SUFRAGIO) AS TOTAL,count(CC.ID_SUFRAGIO) AS RECIBIDOS, (
							COUNT(M.ID_SUFRAGIO)-count(CC.ID_SUFRAGIO)) AS FALTANTES,
							NVL(ROUND((COUNT(CC.ID_SUFRAGIO)*100/NULLIF(COUNT(M.ID_SUFRAGIO),0)),4),0) as PORC_RECIBIDOS,
							NVL(ROUND((100-(COUNT(CC.ID_SUFRAGIO)*100/NULLIF(COUNT(M.ID_SUFRAGIO),0))),4),0) as PORC_FALTANTES
							FROM MESA_SUFRAGIO M
							LEFT JOIN CONTROL_CALIDAD CC ON M.ID_SUFRAGIO = CC.ID_SUFRAGIO AND CC.ID_MATERIAL=$this->intIdMaterial AND CC.ID_ETAPA=$this->intIdEtapa AND CC.ID_PROCESO=$this->intIdProceso AND CC.VALIDACION=$this->intIdValidacion
							WHERE M.ID_PROCESO=$this->intIdProceso AND M.ID_FASE=$this->intIdFase ".$where;

		$request = $this->select_all($query);
		return $request;

	}


	public function avanceOdpe(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idOdpe, int $idSolucion,  int $validacion)
	{
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdOdpe			= $idOdpe;
		$this->intIdSolucion		= $idSolucion;
		$this->intIdValidacion		= $validacion;

		$where = ($idMaterial == 5) ? " AND m.id_solucion=".$this->intIdSolucion : "" ;
		
		$query = "	SELECT ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION, 
						COUNT(m.id_solucion) AS TOTAL, 
						COUNT(cc.id_solucion) AS RECIBIDOS,
						(COUNT(m.id_solucion)-COUNT(cc.id_solucion)) AS FALTANTES, 
						ROUND((COUNT(cc.id_solucion)*100/COUNT(m.id_solucion)),2) AS PORC_RECIBIDOS, 
						ROUND((100-(COUNT(cc.id_solucion)*100/COUNT(m.id_solucion))),2) as PORC_FALTANTES, O.nombre_odpe
						FROM mesa_sufragio m
						INNER JOIN ODPE O ON m.ID_ODPE = O.ID_ODPE
						INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = M.ID_SOLUCION
						LEFT JOIN control_calidad cc ON m.ID_SUFRAGIO = cc.ID_SUFRAGIO AND cc.id_material=$this->intIdMaterial AND cc.id_etapa=$this->intIdEtapa AND CC.ID_PROCESO=$this->intIdProceso AND CC.VALIDACION=$this->intIdValidacion
						WHERE m.id_proceso=$this->intIdProceso AND m.id_odpe=$this->intIdOdpe $where
						GROUP BY ST.SOLUCIONTECNOLOGICA, O.nombre_odpe

						UNION ALL
						
						SELECT 'TOTAL', 
						COUNT(m.id_solucion) AS TOTAL, 
						COUNT(cc.id_solucion) AS RECIBIDOS, 
						(COUNT(m.id_solucion)-COUNT(cc.id_solucion)) AS FALTANTES, 
						ROUND((COUNT(cc.id_solucion)*100/COUNT(m.id_solucion)),2) AS PORC_RECIBIDOS, 
						ROUND((100-(COUNT(cc.id_solucion)*100/COUNT(m.id_solucion))),2) as PORC_FALTANTES, O.nombre_odpe
						FROM mesa_sufragio m
						INNER JOIN ODPE O ON m.ID_ODPE = O.ID_ODPE
						INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = M.ID_SOLUCION
						LEFT JOIN control_calidad cc ON m.ID_SUFRAGIO = cc.ID_SUFRAGIO AND cc.id_material=$this->intIdMaterial AND cc.id_etapa=$this->intIdEtapa AND CC.ID_PROCESO=$this->intIdProceso AND CC.VALIDACION=$this->intIdValidacion
						WHERE m.id_proceso=$this->intIdProceso AND m.id_odpe=$this->intIdOdpe $where
						GROUP BY O.nombre_odpe";

		$request = $this->select_all($query); 
		return $request;
	}


	public function avanceAgrupacion(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idOdpe,  int $validacion)
	{
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdOdpe			= $idOdpe;
		$this->intIdValidacion		= $validacion;


		$query = "	SELECT S.ID_AGRUPACION, AP.AGRUPACION AS AGRUPACION_POLITCA, CAST(COUNT(DISTINCT S.ID_SUFRAGIO)AS VARCHAR2(20)) AS TOTAL, 
						(COUNT(DISTINCT S.ID_SUFRAGIO)*CP.CANTIDAD_PAQUETES) AS TOTAL_PAQUETE, 
						CAST(COUNT(CC.ID_ETAPA) AS VARCHAR2(20)) AS PAQUETES_RECIBIDOS, 
						CAST(((COUNT(DISTINCT S.ID_SUFRAGIO)*CP.CANTIDAD_PAQUETES) - COUNT(CC.ID_SUFRAGIO)) AS VARCHAR2(20)) AS PAQUETES_FALTANTES, 
						LTRIM(TO_CHAR(ROUND(((COUNT(CC.ID_SUFRAGIO)/(COUNT(DISTINCT S.ID_SUFRAGIO)*CP.CANTIDAD_PAQUETES))*100),2),'99G990D99MI')) AS PORCENTAJE_RECIBIDOS, 
						LTRIM(TO_CHAR(ROUND((100-ROUND(((COUNT(CC.ID_SUFRAGIO)/(COUNT(DISTINCT S.ID_SUFRAGIO)*CP.CANTIDAD_PAQUETES))*100),2)),2),'99G990D99MI')) AS PORCENTAJE_FALTANTES 
					FROM MESA_SUFRAGIO S 
									INNER JOIN ODPE O ON S.ID_ODPE = O.ID_ODPE
									INNER JOIN AGRUPACION_POLITICA AP ON AP.ID_AGRUPACION = S.ID_AGRUPACION AND S.ID_PROCESO=$this->intIdProceso 
									INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA= S.ID_CONSULTA 
									INNER JOIN CONSULTA C ON C.ID_CONSULTA= CP.ID_CONSULTA AND CP.ID_PROCESO=$this->intIdProceso 
					LEFT JOIN CONTROL_CALIDAD CC ON CC.ID_SUFRAGIO = S.ID_SUFRAGIO AND CC.ID_PROCESO=$this->intIdProceso AND CC.ID_MATERIAL = $this->intIdMaterial AND CC.ID_ETAPA = $this->intIdEtapa AND CC.VALIDACION = $this->intIdValidacion
					WHERE S.ID_ODPE=$this->intIdOdpe
					AND S.ID_PROCESO=$this->intIdProceso AND S.ID_FASE = $this->intIdFase
					GROUP BY AP.AGRUPACION,CP.CANTIDAD_PAQUETES,AP.CODIGO_AGRUPACION,S.ID_AGRUPACION
					ORDER BY AP.CODIGO_AGRUPACION";

		$request = $this->select_all($query);
		return $request;
	}


	public function mesasAgrupacion(int $idprocesos, int $idFase, int $idOdpe, int $idSoltec, int $idAgrupacion)
	{
		$this->intIdProceso			= $idprocesos;
		$this->intIdFase 			= $idFase;
		$this->intIdSolucion		= $idSoltec;
		$this->intIdOdpe			= $idOdpe;
		$this->intIdAgrupacion		= $idAgrupacion;

		$query = "	SELECT C.CONSULTA, S.NRO_MESA, S.NRO_ELECTORES, AP.AGRUPACION
					FROM MESA_SUFRAGIO S 
					INNER JOIN SOLUCION_PROCESO SP ON S.ID_SOLUCION = SP.ID_SOLUCION  
					INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA= S.ID_CONSULTA  
					INNER JOIN CONSULTA C ON C.ID_CONSULTA= CP.ID_CONSULTA AND CP.ID_PROCESO =$this->intIdProceso
					INNER JOIN AGRUPACION_POLITICA AP ON S.ID_AGRUPACION = AP.ID_AGRUPACION
					WHERE S.ID_PROCESO = $this->intIdProceso 
						AND S.ID_SOLUCION = $this->intIdSolucion
						AND S.ID_ODPE = $this->intIdOdpe
						AND S.ID_AGRUPACION = $this->intIdAgrupacion
						AND S.ID_FASE = $this->intIdFase 
					ORDER BY C.CONSULTA, S.NRO_MESA";

		$request = $this->select_all($query);
		return $request;
	}


	public function mesasEscAgrupacion(int $idprocesos, int $idFase, int $idOdpe, int $idSoltec, int $idAgrupacion, int $idMaterial, int $idEtapa, int $validacion)
	{	
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdSolucion		= $idSoltec;
		$this->intIdOdpe			= $idOdpe;
		$this->intIdAgrupacion		= $idAgrupacion;
		$this->intIdValidacion		= $validacion;

		$query = "	SELECT C.CONSULTA, S.NRO_MESA, S.NRO_ELECTORES , AP.AGRUPACION
					FROM MESA_SUFRAGIO S 
					INNER JOIN CONTROL_CALIDAD CC ON S.ID_SUFRAGIO = CC.ID_SUFRAGIO AND S.ID_PROCESO =$this->intIdProceso
					INNER JOIN SOLUCION_PROCESO SP ON CC.ID_SOLUCION = SP.ID_SOLUCION  
					INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA= S.ID_CONSULTA  
					INNER JOIN CONSULTA C ON C.ID_CONSULTA= CP.ID_CONSULTA AND CP.ID_PROCESO =$this->intIdProceso
					INNER JOIN AGRUPACION_POLITICA AP ON S.ID_AGRUPACION = AP.ID_AGRUPACION
					WHERE CC.ID_PROCESO = $this->intIdProceso 
						AND CC.ID_MATERIAL = $this->intIdMaterial
						AND CC.ID_ETAPA = $this->intIdEtapa
						AND CC.ID_SOLUCION = $this->intIdSolucion
						AND CC.VALIDACION = $this->intIdValidacion
						AND CC.ID_ODPE = $this->intIdOdpe
						AND S.ID_FASE = $this->intIdFase
						AND S.ID_AGRUPACION = $this->intIdAgrupacion
					ORDER BY C.CONSULTA, S.NRO_MESA";

		$request = $this->select_all($query);
		return $request;
	}


	public function mesasFaltAgrupacion(int $idprocesos, int $idFase, int $idOdpe, int $idSoltec, int $idAgrupacion, int $idMaterial, int $idEtapa, int $validacion)
	{	
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdSolucion		= $idSoltec;
		$this->intIdOdpe			= $idOdpe;
		$this->intIdAgrupacion		= $idAgrupacion;
		$this->intIdValidacion		= $validacion;

		$query = "	SELECT C.CONSULTA, S.NRO_MESA, S.NRO_ELECTORES, AP.AGRUPACION  
					FROM MESA_SUFRAGIO S  
					INNER JOIN SOLUCION_PROCESO SP ON S.ID_SOLUCION = SP.ID_SOLUCION  
					INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA= S.ID_CONSULTA  
					INNER JOIN CONSULTA C ON C.ID_CONSULTA= CP.ID_CONSULTA AND CP.ID_PROCESO=$this->intIdProceso
					INNER JOIN AGRUPACION_POLITICA AP ON S.ID_AGRUPACION = AP.ID_AGRUPACION
					WHERE 	S.ID_PROCESO = $this->intIdProceso  
							AND S.ID_ODPE = $this->intIdOdpe 
							AND S.ID_SOLUCION = $this->intIdSolucion
							AND S.ID_FASE = $this->intIdFase
							AND S.ID_AGRUPACION = $this->intIdAgrupacion
							AND S.ID_SUFRAGIO NOT IN (  SELECT CC.ID_SUFRAGIO  
														FROM CONTROL_CALIDAD CC 
														WHERE 	CC.ID_ETAPA = $this->intIdEtapa 
																AND CC.ID_MATERIAL = $this->intIdMaterial
																AND CC.ID_PROCESO = $this->intIdProceso 
																AND CC.ID_SOLUCION = $this->intIdSolucion
																AND CC.VALIDACION = $this->intIdValidacion
																AND CC.ID_ODPE = $this->intIdOdpe  )
					ORDER BY C.CONSULTA, S.NRO_MESA";

		$request = $this->select_all($query);
		return $request;
	}

	
	public function mesasEscaneadas(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, int $validacion)
	{
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdSolucion		= $idSoltec;
		$this->intIdOdpe			= $idOdpe;
		$this->intIdValidacion		= $validacion;

		$query = "	SELECT ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION, U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, S.NRO_MESA, S.NRO_ELECTORES  
					FROM MESA_SUFRAGIO S 
					INNER JOIN CONTROL_CALIDAD CC ON S.ID_SUFRAGIO = CC.ID_SUFRAGIO AND S.ID_PROCESO = $this->intIdProceso
					INNER JOIN SOLUCION_PROCESO SP ON CC.ID_SOLUCION = SP.ID_SOLUCION  
					INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = SP.ID_SOLUCION AND SP.ID_PROCESO = $this->intIdProceso 
					INNER JOIN ACTA_PROCESO AC ON CC.ID_MATERIAL = AC.ID_MATERIAL AND AC.ID_PROCESO = $this->intIdProceso
					LEFT JOIN UBIGEO U ON S.ID_UBIGEO = U.ID_UBIGEO
					LEFT JOIN LOCAL L ON S.ID_LOCAL = L.ID_LOCAL
					WHERE CC.ID_PROCESO = $this->intIdProceso  
					AND CC.ID_MATERIAL = $this->intIdMaterial
					AND CC.ID_ETAPA = $this->intIdEtapa
					AND CC.ID_SOLUCION = $this->intIdSolucion
					AND S.ID_ODPE = $this->intIdOdpe 
					AND CC.VALIDACION = $this->intIdValidacion  
					--GROUP BY ST.SOLUCIONTECNOLOGICA,U.DEPARTAMENTO_UBI,U.PROVINCIA_UBI,U.DISTRITO_UBI,S.NRO_MESA, S.NRO_ELECTORES,L.CODIGO_LOCAL
					ORDER BY U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.CODIGO_LOCAL, S.NRO_MESA";

		$request = $this->select_all($query);
		return $request;
	}


	public function mesasFaltantes(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, int $validacion)
	{
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdSolucion		= $idSoltec;
		$this->intIdOdpe			= $idOdpe;
		$this->intIdValidacion		= $validacion;

		$query = "	SELECT ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION, u.DEPARTAMENTO_UBI,u.PROVINCIA_UBI, u.DISTRITO_UBI, S.NRO_MESA,S.NRO_ELECTORES  
					FROM MESA_SUFRAGIO S  
					INNER JOIN SOLUCION_PROCESO SP ON S.ID_SOLUCION = SP.ID_SOLUCION  
					INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = SP.ID_SOLUCION AND SP.ID_PROCESO=$this->intIdProceso
					LEFT JOIN UBIGEO U ON S.ID_UBIGEO = U.ID_UBIGEO
					LEFT JOIN LOCAL L ON S.ID_LOCAL = L.ID_LOCAL
					WHERE S.ID_PROCESO = $this->intIdProceso  
					AND S.ID_ODPE = $this->intIdOdpe 
					AND S.ID_SOLUCION = $this->intIdSolucion
					AND S.ID_SUFRAGIO NOT IN (  SELECT CC.ID_SUFRAGIO  
									                FROM CONTROL_CALIDAD CC 
									                WHERE CC.ID_ETAPA = $this->intIdEtapa 
									                AND CC.ID_MATERIAL = $this->intIdMaterial 
									                AND CC.ID_PROCESO = $this->intIdProceso  
									                AND CC.ID_SOLUCION = $this->intIdSolucion
									                AND CC.VALIDACION = $this->intIdValidacion
									                AND CC.ID_ODPE = $this->intIdOdpe )  
					ORDER BY U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.CODIGO_LOCAL, S.NRO_MESA ";

		$request = $this->select_all($query);
		return $request;
	}


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





	public function insertIncidencia(int $idMaterial, int $idprocesos, int $idEtapa,  int $idOdpe, int $idIncidencia , string $nroMesa, int $cantidad, string $consulta, string $nroUbigeo, int $idUsuario, int $idSufragio)
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
		$this->intIdSufragio		= $idSufragio;

		
		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_INCIDENCIA_INSERTAR( :P_ID_MATERIAL, :P_ID_PROCESO, :P_ID_ETAPA, :P_ID_ODPE, :P_ID_INCIDENCIA, :P_NROMESA, :P_CANTIDAD, :P_CONSULTA, :P_NROUBIGEO, :P_ID_USUARIO, :P_ID_SUFRAGIO, :P_ID_SUFRAGIO_CI); END;');
		
		oci_bind_by_name($stid, ':P_ID_MATERIAL', $this->intIdMaterial);
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_ID_ETAPA', $this->intIdEtapa);
		oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
		oci_bind_by_name($stid, ':P_ID_INCIDENCIA', $this->intIdIncidencia);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_CANTIDAD', $this->intCantidad);
		oci_bind_by_name($stid, ':P_CONSULTA', $this->strConsulta);
		oci_bind_by_name($stid, ':P_NROUBIGEO', $this->strNroUbigeo);
		oci_bind_by_name($stid, ':P_ID_USUARIO', $this->intIdUsusario);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $this->intIdSufragio);
		oci_bind_by_name($stid, ':P_ID_SUFRAGIO_CI', $P_ID_SUFRAGIO_CI, 40);
		oci_execute($stid);
		
		/*if($P_ID_SUFRAGIO_CI == 0){
			return 0;
		}else{
			return $P_ID_SUFRAGIO_CI;
		}*/
		return $P_ID_SUFRAGIO_CI;
	}
}


?>
