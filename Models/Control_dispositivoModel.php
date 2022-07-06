<?php 

/**
* 
*/
class Control_dispositivoModel extends Oracle
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

	private $strCodigo;

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
										WHERE m.ID_PROCESO = $this->intIdProceso AND m.ID_SOLUCION = 2
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


	public function selectinpBarra(int $idprocesos)
	{
		
		// $this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		
		$query = " SELECT dp.digito, dp.codigo
										FROM material m
										INNER JOIN dispositivo_proceso dp ON m.id_material = dp.id_material
										WHERE  m.id_material IN (6,11) AND dp.id_proceso = $this->intIdProceso
										ORDER BY m.id_material";

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


	public function validarMesaProv(int $idprocesos, string $Provincia, string $nroMesa)
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

	}


	public function validarMesaDist(int $idprocesos, string $Distrito, string $nroMesa)
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


	public function MesaExisteControl( int $idMaterial, int $idprocesos, int $idEtapa, string $nroMesa, int $idSoltec, string $codigo, int $validacion, string $nroUbigeo)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->strNroMesa	 		= $nroMesa;
		$this->intIdSolucion 		= $idSoltec;
		$this->strCodigo	 		= $codigo;
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
                    AND cc.paquete ='{$this->strCodigo}'
                    AND cc.ID_SUFRAGIO = (
                                            SELECT ms.ID_SUFRAGIO 
                                            FROM MESA_SUFRAGIO ms 
                                            WHERE ms.NRO_MESA = '{$this->strNroMesa}' AND ms.id_proceso=$this->intIdProceso )";

		$request = $this->select($query);
		return $request;

	}


	public function insertDispositivo(int $idMaterial, int $idprocesos, int $idEtapa, int $idSoltec, int $idOdpe, string $nroMesa, string $codigo, int $validacion, int $idUsuario, string $nroUbigeo)
	{
		
		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdSolucion 		= $idSoltec;
		$this->intIdOdpe	 		= $idOdpe;
		$this->strNroMesa	 		= $nroMesa;
		$this->strCodigo	 		= $codigo;
		$this->intIdValidacion		= $validacion;
		$this->intIdUsusario		= $idUsuario;
		$this->strNroUbigeo			= $nroUbigeo;

		
		$stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_DISPO_INSERTAR( :P_ID_MATERIAL, :P_ID_PROCESO, :P_ID_ETAPA, :P_ID_SOLUCION, :P_ID_ODPE, :P_NROMESA, :P_CODIGO, :P_ID_VALIDACION, :P_ID_USUARIO, :P_NROUBIGEO, :P_ID_SUFRAGIO); END;');
		
		oci_bind_by_name($stid, ':P_ID_MATERIAL', $this->intIdMaterial);
		oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
		oci_bind_by_name($stid, ':P_ID_ETAPA', $this->intIdEtapa);
		oci_bind_by_name($stid, ':P_ID_SOLUCION', $this->intIdSolucion);
		oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
		oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
		oci_bind_by_name($stid, ':P_CODIGO', $this->strCodigo);
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
	

	
	public function avanceFase(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $validacion)
	{

		$this->intIdMaterial		= $idMaterial;
		$this->intIdProceso			= $idprocesos;
		$this->intIdEtapa 			= $idEtapa;
		$this->intIdFase 			= $idFase;
		$this->intIdValidacion		= $validacion;

		$query = "	SELECT T1.TOTAL, T2. RECIBIDOS, 
					(T1.TOTAL - T2. RECIBIDOS) AS FALTANTES, 
					NVL(ROUND(((T2.RECIBIDOS/NULLIF(T1.TOTAL,0))*100),4),0) AS PORC_RECIBIDOS, 
					NVL(ROUND((100-ROUND(((T2.RECIBIDOS/NULLIF(T1.TOTAL,0))*100),4)),4),0) AS PORC_FALTANTES
		                    FROM (	SELECT COUNT(1) AS TOTAL 
									FROM MESA_SUFRAGIO
									WHERE ID_PROCESO=$this->intIdProceso AND ID_FASE = $this->intIdFase AND ID_SOLUCION = 2) T1, 
		                    (SELECT COUNT(1) AS RECIBIDOS 
								FROM (	SELECT ID_SUFRAGIO, COUNT (ID_SUFRAGIO) AS CANTIDAD_ESCANEADOS , CANTIDAD_USB 
										FROM(	SELECT 1 AS CANTIDAD_USB, CC.ID_SUFRAGIO 
		                                        FROM  MESA_SUFRAGIO S
												LEFT JOIN  CONTROL_CALIDAD CC ON CC.ID_SUFRAGIO = S.ID_SUFRAGIO AND CC.ID_PROCESO= $this->intIdProceso 
		                                        WHERE CC.ID_MATERIAL = $this->intIdMaterial AND CC.ID_ETAPA = $this->intIdEtapa AND CC.VALIDACION = $this->intIdValidacion) 
										GROUP BY ID_SUFRAGIO,CANTIDAD_USB) 
							WHERE CANTIDAD_ESCANEADOS = CANTIDAD_USB) T2";

		
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
	
		$query = "	SELECT ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION , COUNT(DISTINCT m.ID_SUFRAGIO) AS TOTAL, 
	                  COUNT(cc.ID_SUFRAGIO) AS RECIBIDOS, 
	                  (COUNT(DISTINCT m.ID_SUFRAGIO)-COUNT(cc.ID_SUFRAGIO)) AS FALTANTES, 
	                  ROUND(((COUNT(cc.ID_SUFRAGIO)/(COUNT(DISTINCT m.ID_SUFRAGIO)))*100),2) AS PORC_RECIBIDOS, 
	                  ROUND((100-ROUND( ((COUNT(cc.ID_SUFRAGIO)/(COUNT(DISTINCT m.ID_SUFRAGIO))) *100),2)),2) as PORC_FALTANTES, o.nombre_odpe
	                FROM mesa_sufragio m
	                INNER JOIN ODPE O ON m.ID_ODPE = O.ID_ODPE
	                INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = m.ID_SOLUCION 
					LEFT JOIN control_calidad cc ON m.ID_SUFRAGIO = cc.ID_SUFRAGIO AND CC.ID_PROCESO = $this->intIdProceso AND cc.id_material=$this->intIdMaterial AND cc.id_etapa=$this->intIdEtapa AND CC.VALIDACION = $this->intIdValidacion
					WHERE m.id_proceso=$this->intIdProceso AND m.id_odpe=$this->intIdOdpe AND m.id_solucion=2
					GROUP BY ST.SOLUCIONTECNOLOGICA, o.nombre_odpe ";

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

		$query = "	SELECT ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION, U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, S.NRO_MESA, S.NRO_ELECTORES, CC.PAQUETE
					FROM MESA_SUFRAGIO S 
					INNER JOIN CONTROL_CALIDAD CC ON S.ID_SUFRAGIO = CC.ID_SUFRAGIO AND S.ID_PROCESO = $this->intIdProceso
					INNER JOIN SOLUCION_PROCESO SP ON CC.ID_SOLUCION = SP.ID_SOLUCION  
					INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = SP.ID_SOLUCION AND SP.ID_PROCESO = $this->intIdProceso 
					INNER JOIN DISPOSITIVO_PROCESO DP ON CC.ID_MATERIAL = DP.ID_MATERIAL AND DP.ID_PROCESO = $this->intIdProceso
					LEFT JOIN UBIGEO U ON S.ID_UBIGEO = U.ID_UBIGEO
					LEFT JOIN LOCAL L ON S.ID_LOCAL = L.ID_LOCAL
					WHERE CC.ID_PROCESO = $this->intIdProceso  
					AND CC.ID_MATERIAL = $this->intIdMaterial
					AND CC.ID_ETAPA = $this->intIdEtapa
					AND CC.ID_SOLUCION = $this->intIdSolucion
					AND S.ID_ODPE = $this->intIdOdpe 
					AND CC.VALIDACION = $this->intIdValidacion  
					GROUP BY ST.SOLUCIONTECNOLOGICA,U.DEPARTAMENTO_UBI,U.PROVINCIA_UBI,U.DISTRITO_UBI,S.NRO_MESA, S.NRO_ELECTORES,L.CODIGO_LOCAL, CC.PAQUETE
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

		$query = "	SELECT ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION, u.DEPARTAMENTO_UBI,u.PROVINCIA_UBI, u.DISTRITO_UBI, S.NRO_MESA,S.NRO_ELECTORES, '-' AS PAQUETE  
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
