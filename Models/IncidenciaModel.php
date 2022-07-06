<?php 

/**
* 
*/
class IncidenciaModel extends Oracle
{

	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR
	private $intIdMaterial;
	private $intIdProceso;
	private $intIdEtapa;
	private $intIdIncidencia;

	private $strObservacion;
	private $intEstado;
	private $intIdUsuario;



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


	public function selectCboMaterial(int $idprocesos)
	{
		
		$this->intIdProceso		= $idprocesos;

		$query = "	SELECT DISTINCT m.id_material,m.material
										FROM material m
										INNER JOIN material_proceso mp ON m.id_material = mp.id_material
										where mp.id_proceso = $this->intIdProceso AND m.id_material IN (1,2,3,4,5,6,9)
										order by m.id_material";

		$request = $this->select_all($query);
		return $request;
		
	}


	public function selectCboEtapa(int $idprocesos, int $idMaterial)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdMaterial	= $idMaterial;

		$query = "	SELECT DISTINCT e.id_etapa, e.etapa 
										FROM etapa e 
										INNER JOIN control_incidencia ci ON e.id_etapa = ci.id_etapa
										WHERE ci.id_proceso=$this->intIdProceso AND ci.id_material=$this->intIdMaterial
										GROUP BY e.id_etapa, e.etapa 
										ORDER BY e.id_etapa";

		$request = $this->select_all($query);
		return $request;
		
	}


	public function selectIncidencias(int $idprocesos, int $idMaterial, int $idEtapa)
	{
		
		$this->intIdProceso		= $idprocesos;
		$this->intIdMaterial	= $idMaterial;
		$this->intIdEtapa		= $idEtapa;

		$query = "	SELECT ci.id_incidenciaControl, st.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION, om.nombre_odpe, m.nro_mesa, i.incidencia, 
					o.nombre_odpe AS odpe_incidencia, (u.nombres || ' ' || u.apellidos ) AS usuario, 
					ci.estado, (ci.fecha_incidencia || ' ' || ci.hora_incidencia) AS fecha_incidencia
									FROM incidencia i
					                INNER JOIN control_incidencia ci ON i.id_incidencia = ci.id_incidencia
					                LEFT JOIN mesa_sufragio m ON ci.id_sufragio = m.id_sufragio AND M.id_proceso=$this->intIdProceso
					                INNER JOIN odpe om On om.id_odpe = m.id_odpe
					                inner join SOLUCIONTECNOLOGICA st on st.ID_SOLUCIONTECNOLOGICA = m.ID_SOLUCION
					                INNER JOIN odpe o ON ci.id_odpeIncidencia = o.id_odpe
					                INNER JOIN usuario u ON ci.id_usuario = u.id_usuario
					                WHERE ci.id_proceso=$this->intIdProceso AND ci.id_material=$this->intIdMaterial AND ci.id_etapa=$this->intIdEtapa AND ci.estado!= 0 
					                ORDER BY ci.fecha_incidencia, ci.hora_incidencia";

		$request = $this->select_all($query);
		return $request;
		
	}


	public function selectIncidencia(int $idIncidencia)
	{
		$this->intIdIncidencia 	= $idIncidencia;

		$query = "	SELECT ci.id_incidenciaControl, st.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION, o.nombre_odpe, m.NRO_MESA, i.incidencia, 
					o.nombre_odpe AS odpe_incidencia, (u.nombres || ' ' || u.apellidos) AS usuario, 
					ci.estado, ci.observacion, (ci.fecha_incidencia || ' ' || ci.hora_incidencia) AS fecha_incidencia, ci.cantidad
									FROM incidencia i
									INNER JOIN control_incidencia ci ON i.id_incidencia = ci.id_incidencia
									LEFT JOIN mesa_sufragio m ON ci.ID_SUFRAGIO = m.ID_SUFRAGIO
                    				INNER JOIN odpe o ON ci.id_odpeIncidencia = o.id_odpe
                    				INNER JOIN SOLUCIONTECNOLOGICA st on st.ID_SOLUCIONTECNOLOGICA = m.ID_SOLUCION
									INNER JOIN usuario u ON ci.id_usuario = u.id_usuario
									WHERE ci.id_incidenciaControl=$this->intIdIncidencia";

		$request = $this->select($query);
		return $request;
	}


	public function deleteIncidencia(int $idIncidencia)
	{

		$this->intIdIncidencia 	=  $idIncidencia;
		
		$query 	= "UPDATE control_incidencia SET estado = ? WHERE id_incidenciaControl = $this->intIdIncidencia ";
		$arrData= array(0);
		$request = $this->update($query, $arrData);
			
		return $request;

	}


	public function updateIncidencia(int $idIncidencia, string $observacion , int $estado, int $idUsuario)
	{

		$this->intIdIncidencia	= $idIncidencia;
		$this->strObservacion	= $observacion;
		$this->intEstado		= $estado;
		$this->intIdUsuario		= $idUsuario;

		$query = "UPDATE control_incidencia SET ESTADO = ?, OBSERVACION = ?, ID_USUARIOSOL = ?  WHERE ID_INCIDENCIACONTROL = $this->intIdIncidencia";
		$arrData = array($this->intEstado, $this->strObservacion, $this->intIdUsuario);
		$request = $this->update($query, $arrData);

		return $request;
	
	}



}


?>