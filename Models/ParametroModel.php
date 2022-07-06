<?php 

/**
* 
*/
class ParametroModel extends Oracle
{
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR 
	private $intIdAccion;
	private $intIdProceso;
	private $intIdSolucion;
	
	private $intIdConsulta;
	private $intPaquete;
	private $intCartel;

	private $strTipo;
	private $intDigUbigeo;
	private $strPrefUbigeo;
	private $strSufUbigeo;
	private $intDigRotulo;
	private $strPrefRotulo;
	private $strSufRotulo;
	private $intOrden;

	private $intIdMaterial;
	private $intDigito;
	private $strCodigo;
	private $intTipo;

	private $strPrefijo;

	private $strCodReserva;


	public function __construct()
	{
		# code...
		parent::__construct();
	}


	/* =====  STEP 1 ===== */
	public function selectCboProceso(int $accion)
	{
		
		$this->intIdAccion = $accion;
		$query = "SELECT * 
										FROM PROCESO
										WHERE ESTADO = 1 AND 
										(CASE WHEN 1=$this->intIdAccion AND ID_PROCESO NOT IN (  SELECT DISTINCT PR.ID_PROCESO 
										                                          FROM PROCESO PR 
										                                          INNER JOIN ETAPA_PROCESO EP ON PR.ID_PROCESO = EP.ID_PROCESO
										                                          INNER JOIN SOLUCION_PROCESO SP ON PR.ID_PROCESO = SP.ID_PROCESO ) THEN 1
										      WHEN 2=$this->intIdAccion AND ID_PROCESO  IN (  SELECT DISTINCT PR.ID_PROCESO 
										                                          FROM PROCESO PR 
										                                          INNER JOIN ETAPA_PROCESO EP ON PR.ID_PROCESO = EP.ID_PROCESO
										                                          INNER JOIN SOLUCION_PROCESO SP ON PR.ID_PROCESO = SP.ID_PROCESO ) THEN 1  
										      ELSE 0 END

										) = 1 
										ORDER BY FECHA_INICIO DESC";
		$request = $this->select_all($query);
		return $request;
	}

	
	public function getSelectSolucion()
	{
		$query = "	SELECT id_soluciontecnologica, soluciontecnologica 
					FROM  soluciontecnologica 
					WHERE estado = 1 ORDER BY soluciontecnologica";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboEtapa()
	{
		$query = "	SELECT ID_ETAPA, ETAPA 
					FROM  ETAPA 
					WHERE ESTADO = 1 ORDER BY ORDEN";
		$request = $this->select_all($query);
		return $request;
	}

	public function selectCargaSolucion(int $idProceso)
	{
		
		$this->intIdProceso = $idProceso;
		$query = "SELECT SP.ID_PROCESO, LISTAGG(SP.ID_SOLUCION , ',') WITHIN GROUP (ORDER BY SP.ID_SOLUCION) SOLUCIONES
										FROM PROCESO P 
										INNER JOIN SOLUCION_PROCESO SP on P.ID_PROCESO = SP.ID_PROCESO 
										INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = SP.ID_SOLUCION
                   						WHERE SP.ID_PROCESO=$this->intIdProceso
										GROUP BY SP.ID_PROCESO";
		$request = $this->select($query);
		return $request;
	}


	public function selectCargaEtapa(int $idProceso)
	{
		
		$this->intIdProceso = $idProceso;
		$query = "SELECT EP.ID_PROCESO, LISTAGG(EP.ID_ETAPA , ',') WITHIN GROUP (ORDER BY EP.ID_ETAPA) ETAPAS
										FROM PROCESO P 
										INNER JOIN ETAPA_PROCESO EP on P.ID_PROCESO = EP.ID_PROCESO 
										INNER JOIN ETAPA ET ON ET.ID_ETAPA = EP.ID_ETAPA
                    					WHERE EP.ID_PROCESO=$this->intIdProceso
										GROUP BY EP.ID_PROCESO";
		$request = $this->select($query);
		return $request;
	}


	public function insertSolucionProceso(int $idProceso, int $idSolucion)
	{
		$this->intIdProceso 	= $idProceso;
		$this->intIdSolucion	= $idSolucion;

		$query = "INSERT INTO SOLUCION_PROCESO (ID_PROCESO, ID_SOLUCION) VALUES(?,?)";
		$arrData = array($this->intIdProceso, $this->intIdSolucion);
		$secuence = 'SEQ_SOLUCIONPROCESO_ID';
		$requestInsert = $this->insert($query, $arrData, $secuence);

		return $requestInsert;
	}


	public function insertEtapaProceso(int $idProceso, int $idEtapa)
	{
		$this->intIdProceso 	= $idProceso;
		$this->intIdEtapa		= $idEtapa;

		$query = "INSERT INTO ETAPA_PROCESO (ID_PROCESO, ID_ETAPA) VALUES(?,?)";
		$arrData = array($this->intIdProceso, $this->intIdEtapa);
		$secuence = 'SEQ_ETAPAPROCESO_ID';
		$requestInsert = $this->insert($query, $arrData, $secuence);

		return $requestInsert;
	}


	public function deleteSolucionProceso(int $idProceso)
	{
		$this->intIdProceso =  $idProceso;
		
		$query 	= "DELETE FROM SOLUCION_PROCESO WHERE ID_PROCESO = $this->intIdProceso ";
		$request = $this->delete($query);
		return $request;
	}


	public function deleteEtapaProceso(int $idProceso)
	{
		$this->intIdProceso =  $idProceso;
		
		$query 	= "DELETE FROM ETAPA_PROCESO WHERE ID_PROCESO = $this->intIdProceso ";
		$request = $this->delete($query);
		return $request;
	}




	/* =====  STEP 2 ===== */
	public function getSelectConsultas()
	{
		$query = "	SELECT ID_CONSULTA, CONSULTA 
					FROM  CONSULTA 
					WHERE ESTADO = 1 ORDER BY DATE_CREATE DESC";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCargaConsulta(int $idProceso)
	{
		
		$this->intIdProceso = $idProceso;
		$query = "	SELECT *
					FROM consulta_proceso 
					WHERE ID_PROCESO = $this->intIdProceso";
		$request = $this->select_all($query);
		return $request;
	}

	
	public function insertConsultaProceso(int $idProceso, int $idConsulta, int $paquete, int $cartel)
	{
		$this->intIdProceso 	= $idProceso;
		$this->intIdConsulta	= $idConsulta;
		$this->intPaquete		= $paquete;
		$this->intCartel		= $cartel;

		$query = "INSERT INTO CONSULTA_PROCESO (ID_PROCESO, ID_CONSULTA, CANTIDAD_PAQUETES, CANTIDAD_CARTELES) VALUES (?,?,?,?)";
		$arrData = array($this->intIdProceso, $this->intIdConsulta, $this->intPaquete, $this->intCartel);
		$secuence = 'SEQ_CONSULTAPROCESO_ID';
		$requestInsert = $this->insert($query, $arrData, $secuence);

		return $requestInsert;
	}


	public function deleteConsultaProceso(int $idProceso)
	{
		$this->intIdProceso =  $idProceso;
		
		$query 	= "DELETE FROM CONSULTA_PROCESO WHERE ID_PROCESO = $this->intIdProceso ";
		$request = $this->delete($query);
		return $request;
	}




	/* =====  STEP 3 ===== */
	public function getSelectCedulaProceso(int $idProceso)
	{
		$this->intIdProceso = $idProceso;
		$query = "	SELECT * 
					FROM CONSULTA c 
					INNER JOIN CONSULTA_PROCESO cp ON c.ID_CONSULTA = cp.ID_CONSULTA 
					WHERE ID_PROCESO = $this->intIdProceso ";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCargaCedula(int $idProceso)
	{
		
		$this->intIdProceso = $idProceso;
		$query = "	SELECT * 
					FROM CEDULA_PROCESO 
					WHERE ID_PROCESO =$this->intIdProceso AND ID_MATERIAL = 1";
		$request = $this->select_all($query);
		return $request;
	}


	public function insertCedulaProceso(int $idProceso, int $idConsulta, string $tipo, int $digUbigeo, string $prefUbigeo, string $sufUbigeo, int $digRotulo, string $prefRotulo, string $sufRotulo, int $orden)
	{
		$this->intIdProceso 	= $idProceso;
		$this->intIdConsulta	= $idConsulta;
		$this->strTipo			= $tipo;
		$this->intDigUbigeo		= $digUbigeo;
		$this->strPrefUbigeo	= $prefUbigeo;
		$this->strSufUbigeo		= $sufUbigeo;
		$this->intDigRotulo		= $digRotulo;
		$this->strPrefRotulo	= $prefRotulo;
		$this->strSufRotulo		= $sufRotulo;
		$this->intOrden			= $orden;

		$query = "INSERT INTO CEDULA_PROCESO (ID_PROCESO, ID_CONSULTA, TIPO_CEDULA, DIG_UBIGEO, PREF_UBIGEO, SUF_UBIGEO, DIG_ROTULO, PREF_ROTULO, SUF_ROTULO, ORDEN, ID_MATERIAL) VALUES (?,?,?,?,?,?,?,?,?,?,1)";
		$arrData = array($this->intIdProceso, $this->intIdConsulta, $this->strTipo, $this->intDigUbigeo,  $this->strPrefUbigeo, $this->strSufUbigeo,  $this->intDigRotulo, $this->strPrefRotulo,  $this->strSufRotulo, $this->intOrden);
		$secuence = 'SEQ_CEDULAPROCESO_ID';
		$requestInsert = $this->insert($query, $arrData, $secuence);

		return $requestInsert;
	}


	public function deleteCedulaProceso(int $idProceso)
	{
		$this->intIdProceso =  $idProceso;
		
		$query 	= "DELETE FROM CEDULA_PROCESO WHERE ID_PROCESO = $this->intIdProceso AND ID_MATERIAL = 1 ";
		$request = $this->delete($query);
		return $request;
	}


	


	/* =====  STEP 4 ===== */
	public function getSelectActaProceso()
	{
		
		$query = "	SELECT * FROM MATERIAL WHERE ID_MATERIAL IN (2,3,4,5) ";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCargaActa(int $idProceso)
	{
		
		$this->intIdProceso = $idProceso;
		$query = "	SELECT * 
					FROM ACTA_PROCESO 
					WHERE ID_PROCESO =$this->intIdProceso";
		$request = $this->select_all($query);
		return $request;
	}


	public function insertActaProceso(int $idProceso, int $idMaterial, int $digito, string $codigo)
	{
		$this->intIdProceso 	= $idProceso;
		$this->intIdMaterial	= $idMaterial;
		$this->intDigito		= $digito;
		$this->strCodigo		= $codigo;

		$query = "INSERT INTO ACTA_PROCESO (ID_PROCESO, ID_MATERIAL, DIGITO, CODIGO) VALUES (?,?,?,?)";
		$arrData = array($this->intIdProceso, $this->intIdMaterial, $this->intDigito, $this->strCodigo);
		$secuence = 'SEQ_ACTAPROCESO_ID';
		$requestInsert = $this->insert($query, $arrData, $secuence);

		return $requestInsert;
	}


	public function deleteActaProceso(int $idProceso)
	{
		$this->intIdProceso =  $idProceso;
		
		$query 	= "DELETE FROM ACTA_PROCESO WHERE ID_PROCESO = $this->intIdProceso ";
		$request = $this->delete($query);
		return $request;
	}




	/* =====  STEP 5 ===== */
	public function getSelectDispositivoProceso()
	{
		
		$query = "	SELECT M.ID_MATERIAL, DT.ID_TIPO, DT.DESCRIPCION 
					FROM MATERIAL M 
					INNER JOIN DISPOSITIVO_TIPO DT ON M.ID_MATERIAL = DT.ID_MATERIAL 
					WHERE M.ID_MATERIAL = 6 AND dt.ESTADO = 1";

		$request = $this->select_all($query);
		return $request;
	}


	public function selectCargaDispositivo(int $idProceso)
	{
		
		$this->intIdProceso = $idProceso;
		$query = "	SELECT * 
					FROM DISPOSITIVO_PROCESO 
					WHERE ID_PROCESO = $this->intIdProceso";
		$request = $this->select_all($query);
		return $request;
	}


	public function insertDispositivoProceso(int $idProceso, int $idMaterial, int $digito, string $prefijo, string $codigo, int $tipo)
	{
		$this->intIdProceso 	= $idProceso;
		$this->intIdMaterial	= $idMaterial;
		$this->intDigito		= $digito;
		$this->strPrefijo		= $prefijo;
		$this->strCodigo		= $codigo;
		$this->strTipo			= $tipo;

		$query = "INSERT INTO DISPOSITIVO_PROCESO (ID_PROCESO, ID_MATERIAL, DIGITO, PREFIJO, CODIGO, TIPO)  VALUES (?,?,?,?,?,?)";
		$arrData = array($this->intIdProceso, $this->intIdMaterial, $this->intDigito, $this->strPrefijo, $this->strCodigo, $this->strTipo);
		$secuence = 'SEQ_DISPOSITIVOPROCESO_ID';
		$requestInsert = $this->insert($query, $arrData, $secuence);

		return $requestInsert;
	}


	public function deleteDispositivoProceso(int $idProceso)
	{
		$this->intIdProceso =  $idProceso;
		
		$query 	= "DELETE FROM DISPOSITIVO_PROCESO WHERE ID_PROCESO = $this->intIdProceso ";
		$request = $this->delete($query);
		return $request;
	}




	/* =====  STEP 6 ===== */
	public function getSelectReservaProceso(int $idProceso)
	{
		$this->intIdProceso = $idProceso;
		$query = "	SELECT * 
					FROM CONSULTA c 
					INNER JOIN CONSULTA_PROCESO cp ON c.ID_CONSULTA = cp.ID_CONSULTA 
					WHERE ID_PROCESO = $this->intIdProceso ";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCargaReserva(int $idProceso)
	{
		
		$this->intIdProceso = $idProceso;
		$query = "	SELECT * 
					FROM CEDULA_PROCESO 
					WHERE ID_PROCESO =$this->intIdProceso AND ID_MATERIAL = 9";
		$request = $this->select_all($query);
		return $request;
	}


	public function insertReservaProceso(int $idProceso, int $idConsulta, string $tipo, int $digUbigeo, string $prefUbigeo, string $sufUbigeo, int $digRotulo, string $prefRotulo, string $sufRotulo, string $codReserva, int $orden)
	{
		$this->intIdProceso 	= $idProceso;
		$this->intIdConsulta	= $idConsulta;
		$this->strTipo			= $tipo;
		$this->intDigUbigeo		= $digUbigeo;
		$this->strPrefUbigeo	= $prefUbigeo;
		$this->strSufUbigeo		= $sufUbigeo;
		$this->intDigRotulo		= $digRotulo;
		$this->strPrefRotulo	= $prefRotulo;
		$this->strSufRotulo		= $sufRotulo;
		$this->strCodReserva	= $codReserva;
		$this->intOrden			= $orden;

		$query = "INSERT INTO CEDULA_PROCESO (ID_PROCESO, ID_CONSULTA, TIPO_CEDULA, DIG_UBIGEO, PREF_UBIGEO, SUF_UBIGEO, DIG_ROTULO, PREF_ROTULO, SUF_ROTULO, ORDEN, COD_CONSULTA, ID_MATERIAL) VALUES (?,?,?,?,?,?,?,?,?,?,?,9)";
		$arrData = array($this->intIdProceso, $this->intIdConsulta, $this->strTipo, $this->intDigUbigeo,  $this->strPrefUbigeo, $this->strSufUbigeo,  $this->intDigRotulo, $this->strPrefRotulo,  $this->strSufRotulo, $this->intOrden, $this->strCodReserva);
		$secuence = 'SEQ_CEDULAPROCESO_ID';
		$requestInsert = $this->insert($query, $arrData, $secuence);

		return $requestInsert;
	}

	
	public function deleteReservaProceso(int $idProceso)
	{
		$this->intIdProceso =  $idProceso;
		
		$query 	= "DELETE FROM CEDULA_PROCESO WHERE ID_PROCESO = $this->intIdProceso AND ID_MATERIAL= 9 ";
		$request = $this->delete($query);
		return $request;
	
	}



}


?>