<?php 

/**
* 
*/
class ReporteModel extends Oracle
{
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR
	private $strDataBase;
	private $intIdProceso;
	private $intIdSolucion;
	private $intIdOdpe;
	private $intIdMaterial;
	private $intIdEtapa;

	private $strDepartamento;
	private $strProvincia;
	private $strDistrito;

	private $strNroMesa;

	private $intIdValidacion;

	public function __construct()
	{
		# code...
		parent::__construct();

	}


	public function selectCboProceso()
	{
		
		$query = "SELECT P.ID_PROCESO, P.PROCESO, P.DESCRIPCION, TP.ELECCION--, P.DATA_BASE 
										FROM PROCESO P
										INNER JOIN TIPO_PROCESO TP ON P.ID_TIPO = TP.ID_TIPO
										WHERE P.ESTADO = 1 
										--AND SYSDATE BETWEEN P.FECHA_INICIO AND P.FECHA_CIERRE + 1 
										ORDER BY P.FECHA_INICIO DESC";

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


	public function reporteAvanceGeneral(int $idprocesos, int $idSolucion)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion	= $idSolucion;
		//$this->strDataBase		= $dataBase;

		$where = ($idSolucion != '') ? " AND MS.ID_SOLUCION = $this->intIdSolucion ":" " ;

		$query = "SELECT ST.ID_SOLUCIONTECNOLOGICA, ST.SOLUCIONTECNOLOGICA, MS.ID_ODPE, O.NOMBRE_ODPE, COUNT(DISTINCT MS.ID_SUFRAGIO) META, 
										REPLACE(ROUND((COUNT(CCC.ID_SUFRAGIO)/COUNT(MS.ID_SUFRAGIO)*100),2),',','.') CEDULA, 
										REPLACE(ROUND((COUNT(CCL.ID_SUFRAGIO)/COUNT(MS.ID_SUFRAGIO)*100),2),',','.') LISTA, 
										REPLACE(ROUND((COUNT(CCD.ID_SUFRAGIO)/COUNT(MS.ID_SUFRAGIO)*100),2),',','.') DOCUMENTO, 
										REPLACE(ROUND((COUNT(CCR.ID_SUFRAGIO)/COUNT(MS.ID_SUFRAGIO)*100),2),',','.') RELACION,
										REPLACE(ROUND((COUNT(CCN.ID_SUFRAGIO)/COUNT(MS.ID_SUFRAGIO)*100),2),',','.') CONTINGENCIA,
										REPLACE(ROUND((COUNT(CCE.ID_SUFRAGIO)/COUNT(MS.ID_SUFRAGIO)*100),2),',','.') EMPAREJAMIENTO, 
										REPLACE(ROUND((COUNT(CCP.ID_SUFRAGIO)/COUNT(MS.ID_SUFRAGIO)*100),2),',','.') DISPOSITIVOS
										FROM MESA_SUFRAGIO MS
                    					INNER JOIN ODPE O ON O.ID_ODPE = MS.ID_ODPE
                    					INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = MS.ID_SOLUCION
										LEFT JOIN CONTROL_CALIDAD CCC ON MS.ID_SUFRAGIO = CCC.ID_SUFRAGIO AND CCC.ID_PROCESO = $this->intIdProceso AND CCC.ID_MATERIAL = 1 AND CCC.ID_ETAPA = 3
										LEFT JOIN CONTROL_CALIDAD CCL ON MS.ID_SUFRAGIO = CCL.ID_SUFRAGIO AND CCL.ID_PROCESO = $this->intIdProceso AND CCL.ID_MATERIAL = 2 AND CCL.ID_ETAPA = 1
										LEFT JOIN CONTROL_CALIDAD CCD ON MS.ID_SUFRAGIO = CCD.ID_SUFRAGIO AND CCD.ID_PROCESO = $this->intIdProceso AND CCD.ID_MATERIAL = 4 
										LEFT JOIN CONTROL_CALIDAD CCR ON MS.ID_SUFRAGIO = CCR.ID_SUFRAGIO AND CCR.ID_PROCESO = $this->intIdProceso AND CCR.ID_MATERIAL = 3
										LEFT JOIN CONTROL_CALIDAD CCN ON MS.ID_SUFRAGIO = CCN.ID_SUFRAGIO AND CCN.ID_PROCESO = $this->intIdProceso AND CCN.ID_MATERIAL = 5 
										LEFT JOIN CONTROL_CALIDAD CCE ON MS.ID_SUFRAGIO = CCE.ID_SUFRAGIO AND CCE.ID_PROCESO = $this->intIdProceso AND CCE.ID_MATERIAL = 2 AND CCE.ID_ETAPA = 4 
										LEFT JOIN CONTROL_CALIDAD CCP ON MS.ID_SUFRAGIO = CCP.ID_SUFRAGIO AND CCP.ID_PROCESO = $this->intIdProceso AND CCP.ID_MATERIAL = 6
										WHERE MS.ID_PROCESO = $this->intIdProceso ".$where."
 							 			GROUP BY ST.ID_SOLUCIONTECNOLOGICA, ST.SOLUCIONTECNOLOGICA, MS.ID_ODPE, O.NOMBRE_ODPE, O.PRIORIDAD
										ORDER BY O.PRIORIDAD, O.NOMBRE_ODPE";

		$request = $this->select_all($query);
		return $request;
	}


	public function reporteAvanceGeneralGrafica(int $idprocesos, int $idSolucion)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion	= $idSolucion;

		$where = ($idSolucion != '') ? " AND MS.ID_SOLUCION = $this->intIdSolucion ":" " ;

		$query = "SELECT 
							REPLACE(NVL(ROUND((COUNT(CCC.ID_SUFRAGIO)/NULLIF(COUNT(MS.ID_SUFRAGIO),0)*100),4),0),',','.') CEDULA,
							REPLACE(NVL(ROUND((COUNT(CCL.ID_SUFRAGIO)/NULLIF(COUNT(MS.ID_SUFRAGIO),0)*100),4),0),',','.') LISTA,
							REPLACE(NVL(ROUND((COUNT(CCD.ID_SUFRAGIO)/NULLIF(COUNT(MS.ID_SUFRAGIO),0)*100),4),0),',','.') DOCUMENTO,
							REPLACE(NVL(ROUND((COUNT(CCR.ID_SUFRAGIO)/NULLIF(COUNT(MS.ID_SUFRAGIO),0)*100),4),0),',','.') RELACION,
							REPLACE(NVL(ROUND((COUNT(CCN.ID_SUFRAGIO)/NULLIF(COUNT(MS.ID_SUFRAGIO),0)*100),4),0),',','.') CONTINGENCIA,
							REPLACE(NVL(ROUND((COUNT(CCE.ID_SUFRAGIO)/NULLIF(COUNT(MS.ID_SUFRAGIO),0)*100),4),0),',','.') EMPAREJAMIENTO, 
							REPLACE(NVL(ROUND((COUNT(CCP.ID_SUFRAGIO)/NULLIF(COUNT(MS.ID_SUFRAGIO),0)*100),4),0),',','.') DISPOSITIVOS
							FROM MESA_SUFRAGIO MS
							LEFT JOIN CONTROL_CALIDAD CCC ON MS.ID_SUFRAGIO = CCC.ID_SUFRAGIO AND CCC.ID_PROCESO = $this->intIdProceso AND CCC.ID_MATERIAL = 1 AND CCC.ID_ETAPA = 3
							LEFT JOIN CONTROL_CALIDAD CCL ON MS.ID_SUFRAGIO = CCL.ID_SUFRAGIO AND CCL.ID_PROCESO = $this->intIdProceso AND CCL.ID_MATERIAL = 4
							LEFT JOIN CONTROL_CALIDAD CCD ON MS.ID_SUFRAGIO = CCD.ID_SUFRAGIO AND CCD.ID_PROCESO = $this->intIdProceso AND CCD.ID_MATERIAL = 4
							LEFT JOIN CONTROL_CALIDAD CCR ON MS.ID_SUFRAGIO = CCR.ID_SUFRAGIO AND CCR.ID_PROCESO = $this->intIdProceso AND CCR.ID_MATERIAL = 3
							LEFT JOIN CONTROL_CALIDAD CCN ON MS.ID_SUFRAGIO = CCN.ID_SUFRAGIO AND CCN.ID_PROCESO = $this->intIdProceso AND CCN.ID_MATERIAL = 5
							LEFT JOIN CONTROL_CALIDAD CCE ON MS.ID_SUFRAGIO = CCE.ID_SUFRAGIO AND CCE.ID_PROCESO = $this->intIdProceso AND CCE.ID_MATERIAL = 2 AND CCE.ID_ETAPA = 4
							LEFT JOIN CONTROL_CALIDAD CCP ON MS.ID_SUFRAGIO = CCP.ID_SUFRAGIO AND CCP.ID_PROCESO = $this->intIdProceso AND CCP.ID_MATERIAL = 6 
							WHERE MS.ID_PROCESO = $this->intIdProceso ".$where;

		$request = $this->select($query);
		return $request;
	}


	public function reporteAvanceGeneralDetalle(int $idprocesos, int $idSolucion, int $idOdpe)
	{
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion	= $idSolucion;
		$this->intIdoDPE		= $idOdpe;

		$where = ($idSolucion != '') ? " AND MS.ID_SOLUCION = $this->intIdSolucion ":" " ;

		$query = " SELECT MS.ID_SOLUCION, O.NOMBRE_ODPE, U.DEPARTAMENTO_UBI,U.PROVINCIA_UBI, U.DISTRITO_UBI, COUNT(DISTINCT MS.ID_SUFRAGIO) AS META, 
                      COUNT(DISTINCT CCCR.ID_SUFRAGIO) AS CEDULA_RECEP, ROUND( COUNT(DISTINCT CCCR.ID_SUFRAGIO)/COUNT(DISTINCT(MS.ID_SUFRAGIO))* 100,2) AS PORC_CED_RECEP,
                      COUNT(DISTINCT CCCC.ID_SUFRAGIO) AS CEDULA_CONTROL, ROUND( COUNT(DISTINCT CCCC.ID_SUFRAGIO)/COUNT(DISTINCT(MS.ID_SUFRAGIO))* 100,2) AS PORC_CED_CONTROL,
                      COUNT(DISTINCT CCCE.ID_SUFRAGIO) AS CEDULA_EMPAQ, ROUND( COUNT(DISTINCT CCCE.ID_SUFRAGIO)/COUNT(DISTINCT(MS.ID_SUFRAGIO))* 100,2) AS PORC_CED_EMPAQ,
                      COUNT(DISTINCT CCLR.ID_SUFRAGIO) AS LISTA_RECEP, ROUND( COUNT(DISTINCT CCLR.ID_SUFRAGIO)/COUNT(DISTINCT(MS.ID_SUFRAGIO))* 100,2) AS PORC_LISTA_RECEP,
                      COUNT(DISTINCT CCLE.ID_SUFRAGIO) AS LISTA_EMP, ROUND( COUNT(DISTINCT CCLE.ID_SUFRAGIO)/COUNT(DISTINCT(MS.ID_SUFRAGIO))* 100,2) AS PORC_LISTA_EMP,
                      COUNT(DISTINCT CCER.ID_SUFRAGIO) AS RELACION, ROUND( COUNT(DISTINCT CCER.ID_SUFRAGIO)/COUNT(DISTINCT(MS.ID_SUFRAGIO))* 100,2) AS PORC_RELACION,
                      COUNT(DISTINCT CCDE.ID_SUFRAGIO) AS DOCUMENTO, ROUND( COUNT(DISTINCT CCDE.ID_SUFRAGIO)/COUNT(DISTINCT(MS.ID_SUFRAGIO))* 100,2) AS PORC_DOCUMENTO,
                      COUNT(DISTINCT CCDC.ID_SUFRAGIO) AS CONTINGENCIA, ROUND( COUNT(DISTINCT CCDC.ID_SUFRAGIO)/COUNT(DISTINCT(MS.ID_SUFRAGIO))* 100,2) AS PORC_CONTINGENCIA,
                      COUNT(DISTINCT CCDU.ID_SUFRAGIO) AS DISPOSITIVOS1, ROUND( COUNT(DISTINCT CCDU.ID_SUFRAGIO)/COUNT(DISTINCT(MS.ID_SUFRAGIO))* 100,2) AS PORC_DISPOSITIVOS1
                      --COUNT(DISTINCT CCDB.ID_SUFRAGIO) AS DISPOSITIVOS2, ROUND( COUNT(DISTINCT CCDB.ID_SUFRAGIO)/COUNT(DISTINCT(MS.ID_SUFRAGIO))* 100,2) AS PORC_DISPOSITIVOS2
                      FROM MESA_SUFRAGIO MS
                      INNER JOIN ODPE O ON O.ID_ODPE = MS.ID_ODPE
                      LEFT JOIN UBIGEO U ON U.ID_UBIGEO = MS.ID_UBIGEO
                      INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA = MS.ID_CONSULTA AND CP.ID_PROCESO = $this->intIdProceso
                      INNER JOIN CONSULTA C ON C.ID_CONSULTA = CP.ID_CONSULTA
                      INNER JOIN CEDULA_PROCESO PC ON PC.ID_CONSULTA = C.ID_CONSULTA AND PC.ID_PROCESO = $this->intIdProceso AND PC.ID_MATERIAL = 1
                      LEFT JOIN DISPOSITIVO_PROCESO DP ON DP.ID_PROCESO = MS.ID_PROCESO AND DP.ID_MATERIAL = 6 AND MS.ID_SOLUCION = 2
                      LEFT JOIN CONTROL_CALIDAD CCCR ON CCCR.ID_SUFRAGIO = MS.ID_SUFRAGIO AND  CCCR.ID_MATERIAL = 1 AND CCCR.ID_ETAPA = 1 AND CCCR.VALIDACION = 1 AND CCCR.ID_ODPE = $this->intIdoDPE AND PC.SUF_ROTULO = CCCR.PAQUETE 
                      LEFT JOIN CONTROL_CALIDAD CCCC ON CCCC.ID_SUFRAGIO = MS.ID_SUFRAGIO AND  CCCC.ID_MATERIAL = 1 AND CCCC.ID_ETAPA = 2 AND CCCC.VALIDACION = 2 AND CCCC.ID_ODPE = $this->intIdoDPE AND PC.SUF_ROTULO = CCCC.PAQUETE 
                      LEFT JOIN CONTROL_CALIDAD CCCE ON CCCE.ID_SUFRAGIO = MS.ID_SUFRAGIO AND  CCCE.ID_MATERIAL = 1 AND CCCE.ID_ETAPA = 3 AND CCCE.VALIDACION = 1 AND CCCE.ID_ODPE = $this->intIdoDPE AND PC.SUF_ROTULO = CCCE.PAQUETE 
                      LEFT JOIN CONTROL_CALIDAD CCLR ON CCLR.ID_SUFRAGIO = MS.ID_SUFRAGIO AND  CCLR.ID_MATERIAL = 2 AND CCLR.ID_ETAPA = 1 AND CCLR.VALIDACION = 1 AND CCLR.ID_ODPE = $this->intIdoDPE 
                      LEFT JOIN CONTROL_CALIDAD CCLE ON CCLE.ID_SUFRAGIO = MS.ID_SUFRAGIO AND  CCLE.ID_MATERIAL = 2 AND CCLE.ID_ETAPA = 4 AND CCLE.VALIDACION = 1 AND CCLE.ID_ODPE = $this->intIdoDPE 
                      LEFT JOIN CONTROL_CALIDAD CCER ON CCER.ID_SUFRAGIO = MS.ID_SUFRAGIO AND  CCER.ID_MATERIAL = 3 AND CCER.ID_ETAPA = 1 AND CCER.VALIDACION = 1 AND CCER.ID_ODPE = $this->intIdoDPE 
                      LEFT JOIN CONTROL_CALIDAD CCDE ON CCDE.ID_SUFRAGIO = MS.ID_SUFRAGIO AND  CCDE.ID_MATERIAL = 4 AND CCDE.ID_ETAPA = 1 AND CCDE.VALIDACION = 1 AND CCDE.ID_ODPE = $this->intIdoDPE
                      LEFT JOIN CONTROL_CALIDAD CCDC ON CCDC.ID_SUFRAGIO = MS.ID_SUFRAGIO AND  CCDC.ID_MATERIAL = 5 AND CCDC.ID_ETAPA = 1 AND CCDC.VALIDACION = 1 AND CCDC.ID_ODPE = $this->intIdoDPE
                      LEFT JOIN CONTROL_CALIDAD CCDU ON CCDU.ID_SUFRAGIO = MS.ID_SUFRAGIO AND  CCDU.ID_MATERIAL = 6 AND CCDU.ID_ETAPA = 1 AND CCDU.VALIDACION = 1 AND CCDU.ID_ODPE = $this->intIdoDPE AND DP.CODIGO = CCDU.PAQUETE AND DP.TIPO = 1
                      --LEFT JOIN CONTROL_CALIDAD CCDB ON CCDB.ID_SUFRAGIO = MS.ID_SUFRAGIO AND  CCDB.ID_MATERIAL = 6 AND CCDB.ID_ETAPA = 1 AND CCDB.VALIDACION = 1 AND CCDB.ID_ODPE = $this->intIdoDPE AND DP.CODIGO = CCDB.PAQUETE AND DP.TIPO = 2
                      WHERE MS.ID_PROCESO = $this->intIdProceso AND MS.ID_ODPE = $this->intIdoDPE ".$where."
                      GROUP BY MS.ID_SOLUCION, O.NOMBRE_ODPE,U.DEPARTAMENTO_UBI,U.PROVINCIA_UBI,U.DISTRITO_UBI
                      ORDER BY U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI";

		$request = $this->select_all($query);
		return $request;
	}


	/*===== STEP 2 =====*/
	public function selectCboMaterial(int $idprocesos)
	{
		
		$this->intIdProceso		= $idprocesos;

		$query = "	SELECT DISTINCT m.id_material,m.material
										FROM material m
										INNER JOIN material_proceso mp ON m.id_material = mp.id_material
										where mp.id_proceso = $this->intIdProceso AND m.id_material IN (1,2,3,4,5,6)
										order by m.id_material";

		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboEtapa(int $idprocesos, int $idMaterial)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdMaterial	= $idMaterial;

		$query = "	SELECT DISTINCT e.id_etapa,e.etapa
										FROM etapa e
										INNER JOIN material_proceso mp ON e.id_etapa = mp.id_etapa
										where mp.id_proceso = $this->intIdProceso AND mp.id_material = $this->intIdMaterial 
										order by e.id_etapa";

		$request = $this->select_all($query);
		return $request;
	}


	public function reporteAvanceOdpe(int $idprocesos, int $idMaterial, int $idEtapa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdMaterial	= $idMaterial;
		$this->intIdEtapa		= $idEtapa;

		$where = ($idMaterial == 5 || $idMaterial == 6) ? " AND m.id_solucion= 2 ":" " ;

		$query = "	SELECT st.SOLUCIONTECNOLOGICA, o.nombre_odpe, count( DISTINCT m.id_sufragio) AS total, 
					count(DISTINCT c.id_sufragio) AS recibido, 
					(COUNT(DISTINCT m.id_sufragio)-COUNT(DISTINCT c.id_sufragio)) AS faltante, 
					ROUND((COUNT(DISTINCT c.id_sufragio)*100/COUNT(DISTINCT m.id_sufragio)),2) AS porc_recibido, 
					ROUND((100-(COUNT(DISTINCT c.id_sufragio)*100/COUNT(DISTINCT m.id_sufragio))),2) AS porc_faltante
										FROM mesa_sufragio m
					                    INNER JOIN odpe o ON o.id_odpe = m.id_odpe
					                    inner join SOLUCIONTECNOLOGICA st on st.ID_SOLUCIONTECNOLOGICA = m.id_solucion
										LEFT JOIN control_calidad c ON m.id_sufragio = c.id_sufragio ANd c.id_material = $this->intIdMaterial and c.id_etapa = $this->intIdEtapa and c.ID_PROCESO = $this->intIdProceso
										WHERE m.id_proceso = $this->intIdProceso ".$where."
										GROUP BY  o.nombre_odpe, st.SOLUCIONTECNOLOGICA
					                  	ORDER BY  o.nombre_odpe, st.SOLUCIONTECNOLOGICA";

		$request = $this->select_all($query);
		return $request;
	}


	public function reporteAvanceOdpeMaterial(int $idprocesos, int $idMaterial)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdMaterial	= $idMaterial;

		$select = ($idMaterial == 1) ? '	, COUNT(DISTINCT CCC.ID_SUFRAGIO) AS RECIBIDO_CONTROL, 
										(COUNT(DISTINCT M.ID_SUFRAGIO)-COUNT(DISTINCT CCC.ID_SUFRAGIO)) AS FALTANTE_CONTROL, 
										ROUND((COUNT(DISTINCT CCC.ID_SUFRAGIO)*100/COUNT(DISTINCT M.ID_SUFRAGIO)),2) AS PORC_RECIBIDO_CONTROL, 
										ROUND((100-(COUNT(DISTINCT CCC.ID_SUFRAGIO)*100/COUNT(DISTINCT M.ID_SUFRAGIO))),2) AS PORC_FALTANTE_CONTROL,
										COUNT(DISTINCT CCE.ID_SUFRAGIO) AS RECIBIDO_EMPAQUE, 
										(COUNT(DISTINCT M.ID_SUFRAGIO)-COUNT(DISTINCT CCE.ID_SUFRAGIO)) AS FALTANTE_EMPAQUE, 
										ROUND((COUNT(DISTINCT CCE.ID_SUFRAGIO)*100/COUNT(DISTINCT M.ID_SUFRAGIO)),2) AS PORC_RECIBIDO_EMPAQUE, 
										ROUND((100-(COUNT(DISTINCT CCE.ID_SUFRAGIO)*100/COUNT(DISTINCT M.ID_SUFRAGIO))),2) AS PORC_FALTANTE_EMPAQUE' : 

		($idMaterial == 2 ? '	, COUNT(DISTINCT CCEMP.ID_SUFRAGIO) AS RECIBIDO_EMPAREJ, 
								(COUNT(DISTINCT M.ID_SUFRAGIO)-COUNT(DISTINCT CCEMP.ID_SUFRAGIO)) AS FALTANTE_EMPAREJ, 
								ROUND((COUNT(DISTINCT CCEMP.ID_SUFRAGIO)*100/COUNT(DISTINCT M.ID_SUFRAGIO)),2) AS PORC_RECIBIDO_EMPAREJ, 
								ROUND((100-(COUNT(DISTINCT CCEMP.ID_SUFRAGIO)*100/COUNT(DISTINCT M.ID_SUFRAGIO))),2) AS PORC_FALTANTE_EMPAREJ' : '') ;

		$where 	= ($idMaterial == 5 || $idMaterial == 6) ? " AND m.id_solucion= 2 ":" " ;

		$query = "	SELECT ST.SOLUCIONTECNOLOGICA, O.NOMBRE_ODPE, COUNT( DISTINCT M.ID_SUFRAGIO) AS TOTAL, 
					COUNT(DISTINCT CCR.ID_SUFRAGIO) AS RECIBIDO_RECEP, 
					(COUNT(DISTINCT M.ID_SUFRAGIO)-COUNT(DISTINCT CCR.ID_SUFRAGIO)) AS FALTANTE_RECEP, 
					ROUND((COUNT(DISTINCT CCR.ID_SUFRAGIO)*100/COUNT(DISTINCT M.ID_SUFRAGIO)),2) AS PORC_RECIBIDO_RECEP, 
					ROUND((100-(COUNT(DISTINCT CCR.ID_SUFRAGIO)*100/COUNT(DISTINCT M.ID_SUFRAGIO))),2) AS PORC_FALTANTE_RECEP
					".$select."
					FROM MESA_SUFRAGIO M
					INNER JOIN ODPE O ON O.ID_ODPE = M.ID_ODPE
					INNER JOIN SOLUCIONTECNOLOGICA ST on ST.ID_SOLUCIONTECNOLOGICA = M.ID_SOLUCION
					LEFT JOIN CONTROL_CALIDAD CCR ON M.ID_SUFRAGIO = CCR.ID_SUFRAGIO ANd CCR.id_material = $this->intIdMaterial AND CCR.id_etapa = 1 AND CCR.ID_PROCESO = $this->intIdProceso
					LEFT JOIN CONTROL_CALIDAD CCC ON M.ID_SUFRAGIO = CCC.ID_SUFRAGIO ANd CCC.id_material = $this->intIdMaterial AND CCC.id_etapa = 2 AND CCC.ID_PROCESO = $this->intIdProceso
					LEFT JOIN CONTROL_CALIDAD CCE ON M.ID_SUFRAGIO = CCE.ID_SUFRAGIO ANd CCE.id_material = $this->intIdMaterial AND CCE.id_etapa = 3 AND CCE.ID_PROCESO = $this->intIdProceso
					LEFT JOIN CONTROL_CALIDAD CCEMP ON M.ID_SUFRAGIO = CCEMP.ID_SUFRAGIO ANd CCEMP.id_material = $this->intIdMaterial AND CCEMP.id_etapa = 4 AND CCEMP.ID_PROCESO = $this->intIdProceso
					WHERE M.ID_PROCESO =  $this->intIdProceso ".$where."  
					GROUP BY  O.NOMBRE_ODPE, ST.SOLUCIONTECNOLOGICA
					ORDER BY  O.NOMBRE_ODPE, ST.SOLUCIONTECNOLOGICA";

		$request = $this->select_all($query);
		return $request;
	}


	/*===== STEP 3 =====*/
	public function selectCboOdpe(int $idprocesos, int $idMaterial, int $idEtapa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdMaterial	= $idMaterial;
		$this->intIdEtapa		= $idEtapa;

		$query = "	SELECT DISTINCT CC.ID_ODPE, o.NOMBRE_ODPE 
										FROM CONTROL_CALIDAD CC
										INNER JOIN ODPE O ON CC.ID_ODPE = O.ID_ODPE 
										WHERE CC.ID_PROCESO = $this->intIdProceso AND CC.ID_MATERIAL = $this->intIdMaterial AND CC.ID_ETAPA = $this->intIdEtapa
										ORDER BY O.NOMBRE_ODPE";

		$request = $this->select_all($query);
		return $request;
	}


	public function reporteUsuarioMesa(int $idprocesos, int $idMaterial, int $idEtapa, int $idOdpe)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdMaterial	= $idMaterial;
		$this->intIdEtapa		= $idEtapa;
		$this->intIdOdpe		= $idOdpe;

		$select = ($idMaterial == 6) ? " ' (' || CC.PAQUETE || ') ' ": " ' ' "; 

		$query = "	SELECT ST.SOLUCIONTECNOLOGICA CODIGO_SOLUCION, UB.DEPARTAMENTO_UBI, UB.PROVINCIA_UBI, UB.DISTRITO_UBI, (M.NRO_MESA || ".$select.") NRO_MESA, (U.APELLIDOS || ' ' || U.NOMBRES) USUARIO, (CC.FECHA_CONTROL || ' ' || CC.HORA_CONTROL) FECHA_HORA
										FROM MESA_SUFRAGIO M
										INNER JOIN CONTROL_CALIDAD CC ON CC.ID_SUFRAGIO = M.ID_SUFRAGIO AND CC.ID_PROCESO = $this->intIdProceso
                    INNER JOIN SOLUCIONTECNOLOGICA ST ON M.ID_SOLUCION = ST.ID_SOLUCIONTECNOLOGICA
                    LEFT JOIN UBIGEO UB ON M.ID_UBIGEO = UB.ID_UBIGEO
										INNER JOIN USUARIO U ON U.ID_USUARIO = CC.ID_USUARIO
										WHERE CC.ID_PROCESO = $this->intIdProceso AND CC.ID_MATERIAL = $this->intIdMaterial AND CC.ID_ETAPA = $this->intIdEtapa AND CC.ID_ODPE = $this->intIdOdpe
										ORDER BY ST.SOLUCIONTECNOLOGICA, UB.DEPARTAMENTO_UBI, UB.PROVINCIA_UBI, UB.DISTRITO_UBI, M.NRO_MESA, CC.FECHA_CONTROL, CC.HORA_CONTROL";

		$request = $this->select_all($query);
		return $request;
	}



	/*===== STEP 4 =====*/
	public function reporteRendimiento(int $idprocesos, int $idMaterial, int $idEtapa, int $idValidacion)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdMaterial	= $idMaterial;
		$this->intIdEtapa		= $idEtapa;
		$this->intIdValidacion	= $idValidacion;
		

		$query = "	SELECT T2.FECHA_CONTROL,T1.META,T2.CANTIDAD_AVANCE,REPLACE(NVL(ROUND(T2.CANTIDAD_AVANCE*100/NULLIF(T1.META,0),2),0),',','.') PORC_AVANCE
					FROM  ( SELECT COUNT(ID_SUFRAGIO) META FROM MESA_SUFRAGIO) T1,
					      ( SELECT TO_CHAR(FECHA_CONTROL) FECHA_CONTROL, COUNT(FECHA_CONTROL) CANTIDAD_AVANCE
					        FROM CONTROL_CALIDAD
					        WHERE ID_MATERIAL = $this->intIdMaterial AND ID_ETAPA=$this->intIdEtapa AND ID_PROCESO=$this->intIdProceso AND VALIDACION=$this->intIdValidacion
					        GROUP BY TO_CHAR(FECHA_CONTROL)
					        ORDER BY TO_CHAR(FECHA_CONTROL)) T2
					        
					/*UNION ALL

					SELECT 'TOTAL',T1.META, T2.CANTIDAD_AVANCE, REPLACE(NVL(ROUND(T2.CANTIDAD_AVANCE*100/NULLIF(T1.META,0),4),0),',','.') PORC_AVANCE
					FROM  ( SELECT COUNT(ID_SUFRAGIO) META FROM MESA_SUFRAGIO) T1,
					      ( SELECT COUNT(ID_SUFRAGIO) CANTIDAD_AVANCE
					        FROM CONTROL_CALIDAD
					        WHERE ID_MATERIAL = $this->intIdMaterial AND ID_ETAPA=$this->intIdEtapa AND ID_PROCESO=$this->intIdProceso AND VALIDACION=$this->intIdValidacion) T2*/";

		$request = $this->select_all($query);
		return $request;
	}



	/*===== STEP 5 =====*/
	public function reporteOdpeGrafica(int $idprocesos, int $idMaterial, int $idEtapa, int $idOdpe)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdMaterial	= $idMaterial;
		$this->intIdEtapa		= $idEtapa;
		$this->intIdOdpe		= $idOdpe;

		$query = "	SELECT st.SOLUCIONTECNOLOGICA codigo_solucion,
										COUNT(DISTINCT m.ID_SUFRAGIO) AS total, 
										COUNT(DISTINCT cc.ID_SUFRAGIO) AS recibidos, 
										(COUNT(DISTINCT m.ID_SUFRAGIO)-COUNT(DISTINCT cc.ID_SUFRAGIO)) AS faltantes, 
										REPLACE(ROUND((COUNT(DISTINCT cc.ID_SUFRAGIO)*100/COUNT(DISTINCT m.ID_SUFRAGIO)),2),',','.') AS porc_recibidos, 
										REPLACE(ROUND((100-(COUNT(DISTINCT cc.ID_SUFRAGIO)*100/COUNT(DISTINCT m.ID_SUFRAGIO))),2),',','.') as porc_faltantes, 
										o.nombre_odpe
										FROM mesa_sufragio m
										INNER JOIN odpe o ON o.ID_ODPE = m.ID_ODPE
					                    INNER JOIN SOLUCIONTECNOLOGICA st on st.ID_SOLUCIONTECNOLOGICA = m.ID_SOLUCION
					                    LEFT JOIN control_calidad cc ON m.ID_SUFRAGIO = cc.ID_SUFRAGIO AND cc.id_material=$this->intIdMaterial AND cc.id_etapa=$this->intIdEtapa and cc.ID_PROCESO = $this->intIdProceso
										WHERE m.id_proceso=$this->intIdProceso AND m.id_odpe=$this->intIdOdpe 
										GROUP BY st.SOLUCIONTECNOLOGICA, o.nombre_odpe
										ORDER BY st.SOLUCIONTECNOLOGICA";

		$request = $this->select_all($query);
		return $request;
	}



	/*===== STEP 6 =====*/
	public function selectCboSoltec(int $idprocesos)
	{
		
		$this->intIdProceso		= $idprocesos;

		$query = "	SELECT s.ID_SOLUCIONTECNOLOGICA, s.SOLUCIONTECNOLOGICA
										FROM MESA_SUFRAGIO m
										INNER JOIN SOLUCION_PROCESO sp ON m.ID_SOLUCION = sp.ID_SOLUCION
										INNER JOIN SOLUCIONTECNOLOGICA s ON m.ID_SOLUCION = s.ID_SOLUCIONTECNOLOGICA
										where sp.ID_PROCESO = $this->intIdProceso
										GROUP BY s.ID_SOLUCIONTECNOLOGICA, s.SOLUCIONTECNOLOGICA 
										ORDER BY s.SOLUCIONTECNOLOGICA";

		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboOdpeEst(int $idprocesos, int $idSolucion)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion 	= $idSolucion;

		$query = "SELECT o.id_odpe,o.nombre_odpe
										FROM mesa_sufragio m
										INNER JOIN odpe o ON m.id_odpe = o.id_odpe
										where m.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion
										GROUP BY o.id_odpe, o.nombre_odpe 
										ORDER BY o.nombre_odpe";

		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboDepartamento(int $idprocesos, int $idSolucion, int $idOdpe)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion 	= $idSolucion;
		$this->intIdOdpe 		= $idOdpe;

		$query = "SELECT DISTINCT SUBSTR(u.ubigeo,1,2) codigo, u.departamento_ubi
										FROM mesa_sufragio m
										INNER JOIN odpe o ON m.id_odpe = o.id_odpe
                    					LEFT JOIN ubigeo u on u.id_ubigeo = m.id_ubigeo
										where m.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion AND o.id_odpe = $this->intIdOdpe
										ORDER BY u.departamento_ubi";

		$request = $this->select_all($query);
		return $request;
	}
	
	
	public function selectCboProvincia(int $idprocesos, int $idSolucion, int $idOdpe, string $departamento)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion 	= $idSolucion;
		$this->intIdOdpe 		= $idOdpe;
		$this->strDepartamento 	= $departamento;

		$query = "SELECT DISTINCT SUBSTR(u.ubigeo,3,2) codigo, u.provincia_ubi
										FROM mesa_sufragio m
										INNER JOIN odpe o ON m.id_odpe = o.id_odpe
                    					LEFT JOIN ubigeo u on u.id_ubigeo = m.id_ubigeo
										where m.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion AND o.id_odpe = $this->intIdOdpe AND  SUBSTR(u.ubigeo,1,2) = '{$this->strDepartamento}'
										ORDER BY u.provincia_ubi";

		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboDistrito(int $idprocesos, int $idSolucion, int $idOdpe, string $departamento, string $provincia)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion 	= $idSolucion;
		$this->intIdOdpe 		= $idOdpe;
		$this->strDepartamento 	= $departamento;
		$this->strProvincia		= $provincia;

		$query = "SELECT DISTINCT SUBSTR(u.ubigeo,5,2) codigo, u.distrito_ubi
										FROM mesa_sufragio m
										INNER JOIN odpe o ON m.id_odpe = o.id_odpe
                    					LEFT JOIN ubigeo u on u.id_ubigeo = m.id_ubigeo
										where m.id_proceso = $this->intIdProceso AND m.id_solucion = $this->intIdSolucion AND o.id_odpe = $this->intIdOdpe AND  SUBSTR(u.ubigeo,1,2) = '{$this->strDepartamento}' AND  SUBSTR(u.ubigeo,3,2) = '{$this->strProvincia}'
										ORDER BY u.distrito_ubi";

		$request = $this->select_all($query);
		return $request;
	}



	public function reporteEstadistico(int $idprocesos, int $idSolucion, int $idOdpe, string $departamento, string $provincia, string $distrito, int $eleccion)
	{ 
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdSolucion 	= $idSolucion;
		$this->intIdOdpe 		= $idOdpe;
		$this->strDepartamento 	= $departamento;
		$this->strProvincia		= $provincia;
		$this->strDistrito		= $distrito;
		$this->intIdEleccion	= $eleccion;

		if($idSolucion != '' && $idOdpe == '' && $departamento == '' && $provincia == '' && $distrito == ''){
			$where = " AND M.ID_SOLUCION = $this->intIdSolucion ";
		}else if($idSolucion != '' && $idOdpe != '' && $departamento == ''  && $provincia == '' && $distrito == ''){
			$where = " AND M.ID_SOLUCION = $this->intIdSolucion AND M.ID_ODPE = $this->intIdOdpe ";
		}else if($idSolucion != '' && $idOdpe != '' && $departamento != ''  && $provincia == '' && $distrito == ''){
			$where = " AND M.ID_SOLUCION = $this->intIdSolucion AND M.ID_ODPE = $this->intIdOdpe AND SUBSTR(U.UBIGEO,1,2) = '{$this->strDepartamento}' ";
		}else if($idSolucion != '' && $idOdpe != '' && $departamento != ''  && $provincia != '' && $distrito == ''){
			$where = " AND M.ID_SOLUCION = $this->intIdSolucion AND M.ID_ODPE = $this->intIdOdpe AND SUBSTR(U.UBIGEO,1,2) = '{$this->strDepartamento}' AND SUBSTR(U.UBIGEO,3,2) = '{$this->strProvincia}' ";
		}else if($idSolucion != '' && $idOdpe != '' && $departamento != ''  && $provincia != '' && $distrito != ''){
			$where = " AND M.ID_SOLUCION = $this->intIdSolucion AND M.ID_ODPE = $this->intIdOdpe AND SUBSTR(U.UBIGEO,1,2) = '{$this->strDepartamento}' AND SUBSTR(U.UBIGEO,3,2) = '{$this->strProvincia}' AND SUBSTR(U.UBIGEO,5,2) = '{$this->strDistrito}' ";
		}else{
			$where = " ";
		}

		$select = ($this->intIdEleccion == 2) ? " C.DESCRIPCION, M.COD_TIPO, AP.AGRUPACION, ": "";
		$from 	= ($this->intIdEleccion == 2) ? " INNER JOIN AGRUPACION_POLITICA AP ON M.ID_AGRUPACION = AP.ID_AGRUPACION
												  INNER JOIN CONSULTA C ON C.ID_CONSULTA = M.ID_CONSULTA   " : "" ;
		$group 	= ($this->intIdEleccion == 2) ? " , C.DESCRIPCION, M.COD_TIPO, AP.CODIGO_AGRUPACION, AP.AGRUPACION ": "";
		$order	= ($this->intIdEleccion == 2) ? " , C.DESCRIPCION, M.COD_TIPO, AP.CODIGO_AGRUPACION ": "";
		
		$query = " SELECT O.NOMBRE_ODPE, U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.NOMBRE_LOCAL, L.DIRECCION_LOCAL, ".$select."
						L.CODIGO_LOCAL,
						count(M.NRO_MESA) AS TOTAL_MESAS, sum(M.NRO_ELECTORES) AS TOTAL_ELECTORES ,
						LISTAGG(M.NRO_MESA || '(' || M.NRO_ELECTORES || ')', ' ') WITHIN GROUP (ORDER BY M.NRO_MESA) DETALLE
						FROM MESA_SUFRAGIO M
						INNER JOIN ODPE O ON O.ID_ODPE = M.ID_ODPE
						LEFT JOIN UBIGEO U ON U.ID_UBIGEO = M.ID_UBIGEO
						LEFT JOIN LOCAL L ON L.ID_LOCAL = M.ID_LOCAL
						".$from."
						WHERE ID_PROCESO = $this->intIdProceso ".$where." 
						GROUP BY O.NOMBRE_ODPE, U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.NOMBRE_LOCAL, L.DIRECCION_LOCAL, L.CODIGO_LOCAL ".$group."
						ORDER BY O.NOMBRE_ODPE, U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.CODIGO_LOCAL ".$order;

		$request = $this->select_all($query);
		return $request;
	}


	/*===== STEP 7 =====*/
	public function reporteConsultaMesa(int $idprocesos, string $nroMesa)
	{ 
		
		$this->intIdProceso	= $idprocesos;
		$this->strNroMesa 	= $nroMesa;

		$query = "  SELECT PC.TIPO_CEDULA, MS.NRO_MESA, MS.ID_SOLUCION, ST.SOLUCIONTECNOLOGICA, O.NOMBRE_ODPE, U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.NOMBRE_LOCAL, MS.NRO_ELECTORES,
					(CASE WHEN CCR.ID_SUFRAGIO IS null THEN 'null' ELSE 'check' END ) AS RECEPCION,
					(CASE WHEN CCC.ID_SUFRAGIO IS null THEN 'null' ELSE 'check' END ) AS CONTROL,
					(CASE WHEN CCE.ID_SUFRAGIO IS null THEN 'null' ELSE 'check' END ) AS EMPAQUETADO,
					(CASE WHEN CCLR.ID_SUFRAGIO IS null THEN 'null' ELSE 'check' END ) AS LISTA_RECEP,
					(CASE WHEN CCLE.ID_SUFRAGIO IS null THEN 'null' ELSE 'check' END ) AS LISTA_EMP,
					(CASE WHEN CCRE.ID_SUFRAGIO IS null THEN 'null' ELSE 'check' END ) AS RELACION,
					(CASE WHEN CCDE.ID_SUFRAGIO IS null THEN 'null' ELSE 'check' END ) AS DOCUMENTOS,
					(CASE WHEN CCDC.ID_SUFRAGIO IS null THEN 'null' ELSE 'check' END ) AS CONTINGENCIA,
					(CASE WHEN CDDU.ID_SUFRAGIO IS null THEN 'null' ELSE 'check' END ) AS dispositivos
					FROM MESA_SUFRAGIO MS
					--INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA = MS.ID_CONSULTA AND CP.ID_PROCESO = $this->intIdProceso
					INNER JOIN CONSULTA C ON C.ID_CONSULTA = MS.ID_CONSULTA
					INNER JOIN CEDULA_PROCESO PC ON PC.ID_CONSULTA = C.ID_CONSULTA AND PC.ID_PROCESO = $this->intIdProceso AND PC.ID_MATERIAL = 1
					LEFT JOIN DISPOSITIVO_PROCESO DP ON DP.ID_PROCESO = MS.ID_PROCESO AND DP.ID_MATERIAL = 6 AND MS.ID_SOLUCION = 2
					INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = MS.ID_SOLUCION 
					INNER JOIN ODPE O ON O.ID_ODPE = MS.ID_ODPE
					LEFT JOIN UBIGEO U ON U.ID_UBIGEO = MS.ID_UBIGEO
					LEFT JOIN LOCAL L ON L.ID_LOCAL = MS.ID_LOCAL
					LEFT JOIN CONTROL_CALIDAD CCR ON CCR.ID_SUFRAGIO = MS.ID_SUFRAGIO and CCR.ID_PROCESO = $this->intIdProceso AND CCR.ID_MATERIAL = 1 AND CCR.ID_ETAPA = 1 AND CCR.VALIDACION = 1 AND PC.SUF_ROTULO = CCR.PAQUETE
					LEFT JOIN CONTROL_CALIDAD CCC ON CCC.ID_SUFRAGIO = MS.ID_SUFRAGIO and CCC.ID_PROCESO = $this->intIdProceso AND CCC.ID_MATERIAL = 1 AND CCC.ID_ETAPA = 2 AND CCC.VALIDACION = 2 AND PC.SUF_ROTULO = CCC.PAQUETE
					LEFT JOIN CONTROL_CALIDAD CCE ON CCE.ID_SUFRAGIO = MS.ID_SUFRAGIO and CCE.ID_PROCESO = $this->intIdProceso AND CCE.ID_MATERIAL = 1 AND CCE.ID_ETAPA = 3 AND CCE.VALIDACION = 1 AND PC.SUF_ROTULO = CCE.PAQUETE
					LEFT JOIN CONTROL_CALIDAD CCLR ON CCLR.ID_SUFRAGIO = MS.ID_SUFRAGIO and CCLR.ID_PROCESO = $this->intIdProceso AND CCLR.ID_MATERIAL = 2 AND CCLR.ID_ETAPA = 1 AND CCLR.VALIDACION = 1
					LEFT JOIN CONTROL_CALIDAD CCLE ON CCLE.ID_SUFRAGIO = MS.ID_SUFRAGIO and CCLE.ID_PROCESO = $this->intIdProceso AND CCLE.ID_MATERIAL = 2 AND CCLE.ID_ETAPA = 4 AND CCLE.VALIDACION = 1
					LEFT JOIN CONTROL_CALIDAD CCRE ON CCRE.ID_SUFRAGIO = MS.ID_SUFRAGIO and CCRE.ID_PROCESO = $this->intIdProceso AND CCRE.ID_MATERIAL = 3 AND CCRE.ID_ETAPA = 1 AND CCRE.VALIDACION = 1
					LEFT JOIN CONTROL_CALIDAD CCDE ON CCDE.ID_SUFRAGIO = MS.ID_SUFRAGIO and CCDE.ID_PROCESO = $this->intIdProceso AND CCDE.ID_MATERIAL = 4 AND CCDE.ID_ETAPA = 1 AND CCDE.VALIDACION = 1
					LEFT JOIN CONTROL_CALIDAD CCDC ON CCDC.ID_SUFRAGIO = MS.ID_SUFRAGIO and CCDC.ID_PROCESO = $this->intIdProceso AND CCDC.ID_MATERIAL = 5 AND CCDC.ID_ETAPA = 1 AND CCDC.VALIDACION = 1
					LEFT JOIN CONTROL_CALIDAD CDDU ON CDDU.ID_SUFRAGIO = MS.ID_SUFRAGIO and CDDU.ID_PROCESO = $this->intIdProceso AND CDDU.ID_MATERIAL = 6 AND CDDU.ID_ETAPA = 1 AND CDDU.VALIDACION = 1 AND DP.CODIGO = CDDU.PAQUETE
					WHERE ms.ID_PROCESO = $this->intIdProceso AND MS.NRO_MESA= '{$this->strNroMesa}' 
					ORDER BY PC.TIPO_CEDULA";

		$request = $this->select_all($query);
		return $request;
	}



	/*===== STEP 8 - OTROS MATERIALES =====*/
	public function selectCboMaterialOtros(int $idprocesos)
	{
		
		$this->intIdProceso		= $idprocesos;

		$query = "	SELECT DISTINCT m.id_material,m.material
										FROM material m
										INNER JOIN material_proceso mp ON m.id_material = mp.id_material
										where mp.id_proceso = $this->intIdProceso AND m.id_material IN (9)
										order by m.id_material";

		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboEtapaOtros(int $idprocesos, int $idMaterial)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdMaterial	= $idMaterial;

		$query = "	SELECT DISTINCT e.id_etapa,e.etapa
										FROM etapa e
										INNER JOIN material_proceso mp ON e.id_etapa = mp.id_etapa
										where mp.id_proceso = $this->intIdProceso AND mp.id_material = $this->intIdMaterial 
										order by e.id_etapa";

		$request = $this->select_all($query);
		return $request;
	}



	public function reporteAvanceGeneralOtros(int $idprocesos)
	{
		
		$this->intIdProceso		= $idprocesos;

		$query = "SELECT O.NOMBRE_ODPE, R.CANTIDAD CANTIDAD_TOTAL, COUNT(CC.ROTULO) CANTIDAD_RECIBIDA, (R.CANTIDAD - COUNT(CC.ROTULO)) RESTO
		          FROM ODPE O
		          LEFT JOIN RESERVA_SUFRAGIO R ON O.ID_ODPE = R.ID_ODPE
		          LEFT JOIN CONTROL_CALIDAD CC ON R.ID_ODPE = CC.ID_ODPE AND CC.ID_PROCESO = $this->intIdProceso AND CC.ID_MATERIAL = 9 AND CC.ID_ETAPA = 3
		          GROUP BY O.NOMBRE_ODPE, R.CANTIDAD, O.PRIORIDAD
		          ORDER BY O.PRIORIDAD";

		$request = $this->select_all($query);
		return $request;
	}


	
}

?>