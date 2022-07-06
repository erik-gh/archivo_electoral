<?php 

/**
* 
*/
class ContratoModel extends Mysql
{
	private $intIdContrato;
	private $intControl;
	private $intPedido;
	private $intIdPersonal;
	private $strNroContrato;
	private $intRuc;
	private $strFechaInicio;
	private $strFechaFin;
	private $intProceso;
	private $intLocal;
	private $strJefe;
	private $intVerificacion;
	private $strNacimiento;
	private $intSexo;
	private $strDireccion;
	private $intUbigeo;
	private $intCelular;
	private $intTelefono;
	private $intUserSession;
	private $intEstado;

	private $intIdFormAcad;
	private $intIdTipo;
	private $intIdNive;
	private $strEspecialidad;
	private $strCentroEstudio;
	private $strFechaEstudio;

	private $intIdCursoEspec;
	private $intIdCursoTipo;
	private $strCursoDescrip;
	private $strCursoCentroEst;
	private $strCursofechaInicio;
	private $strCursoFechaFin;
	private $intCursoHoras;

	private $intIdExperiencia;
	private $intExperienciaTipo;
	private $intExperienciatipoEntidad;
	private $strExperienciaEntidad;
	private $strExperienciaArea;
	private $strExperienciaCargo;
	private $strExperienciaFechaInicio;
	private $strExperienciaFechaFin;
	private $strExperienciaTiempo;
	private $intExperienciaTiempoDias;

	private $strCodDepart;
	private $strCodProv;

	public function __construct()
	{
		# code...
		parent::__construct();
	}


	public function insertContrato(int $pedido, int $idPersonal, string $nroContrato, int $ruc, string $fechaInicio, string $fechaFin, int $proceso, int $local, string $jefe, int $verificacion, string $nacimiento, int $sexo, string $direccion, int $ubigeo, int $celular, int $telefono, int $userSession)
	{
		
		$this->intPedido		= $pedido;
		$this->intIdPersonal	= $idPersonal;
		$this->strNroContrato	= $nroContrato;
		$this->intRuc 			= $ruc;
		$this->strFechaInicio	= $fechaInicio;
		$this->strFechaFin		= $fechaFin;
		$this->intProceso		= $proceso;
		$this->intLocal			= $local;
		$this->strJefe			= $jefe;
		$this->intVerificacion	= $verificacion;
		$this->strNacimiento	= $nacimiento;
		$this->intSexo			= $sexo;	
		$this->strDireccion		= $direccion;
		$this->intUbigeo		= $ubigeo;
		$this->intCelular		= $celular;
		$this->intTelefono		= $telefono;
		$this->intUserSession	= $userSession;

		$queryContrato = "SELECT id_contrato FROM contrato WHERE estado_contrato != 0 AND (id_personal = $this->intIdPersonal OR nro_contrato ='{$this->strNroContrato}' ) ";

		$requestContrato = $this->select($queryContrato);

		if(empty($requestContrato)){
			
			$query = "INSERT INTO contrato(id_pedido, id_personal, nro_contrato, ruc, fecha_inicio, fecha_fin, id_proceso, id_local, nombre_jefe, verificacion, fecha_nacimiento, sexo, direccion, id_ubigeo, celular, telefono, user_create, estado_contrato) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)";
			$arrData = array($this->intPedido, $this->intIdPersonal, $this->strNroContrato, $this->intRuc, $this->strFechaInicio, $this->strFechaFin, $this->intProceso, $this->intLocal, $this->strJefe, $this->intVerificacion, $this->strNacimiento, $this->intSexo, $this->strDireccion, $this->intUbigeo, $this->intCelular, $this->intTelefono, $this->intUserSession);
			$requestInsert = $this->insert($query, $arrData);
			
			return $requestInsert;

		}else{

			return  'exist';
		}
	}


	public function selectContratos()
	{

		$query = "	SELECT cn.id_contrato, pd.pedido, p.nombre, c.cargo, cn.nro_contrato, cn.fecha_inicio, cn.fecha_fin, cn.estado_contrato
					FROM contrato cn
					INNER JOIN pedido pd ON pd.id_pedido = cn.id_pedido AND pd.estado_pedido != 0
					INNER JOIN personal p ON cn.id_personal = p.id_personal AND p.estado != 0
					INNER JOIN cargo c ON c.id_cargo = p.id_cargo AND c.estado != 0
					WHERE estado_contrato != 0 ";

		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( pd.pedido LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR p.nombre LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR c.cargo LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR cn.nro_contrato LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR cn.fecha_inicio LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR cn.fecha_fin LIKE '%".$_POST["search"]["value"]."%' )";
		}

		if(isset($_POST["order"]))
		{
			$query .= ' ORDER BY '.(1+$_POST['order']['0']['column']).' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= ' ORDER BY p.nombre, c.cargo ';
		}

		if ( isset( $_POST['start'] ) && $_POST['length'] != '-1' )
		{
			$query .= " LIMIT ".$_POST['start'].", ".$_POST['length'];
		}
		$request = $this->select_all($query);
	

		$query = "	SELECT count(*) as row 
					FROM contrato cn
					INNER JOIN pedido pd ON pd.id_pedido = cn.id_pedido AND pd.estado_pedido != 0
					INNER JOIN personal p ON cn.id_personal = p.id_personal AND p.estado != 0
					INNER JOIN cargo c ON c.id_cargo = p.id_cargo AND c.estado != 0
					WHERE estado_contrato != 0 ";
		if(isset($_POST["search"]["value"]))
		{
		 	$query .= "AND ( pd.pedido LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR p.nombre LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR c.cargo LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR cn.nro_contrato LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR cn.fecha_inicio LIKE '%".$_POST["search"]["value"]."%' ";
		    $query .= "OR cn.fecha_fin LIKE '%".$_POST["search"]["value"]."%' )";
		}
		$request2 = $this->select($query);

		
		$query = "	SELECT count(*) as row 
					FROM contrato cn
					INNER JOIN pedido pd ON pd.id_pedido = cn.id_pedido AND pd.estado_pedido != 0
					INNER JOIN personal p ON cn.id_personal = p.id_personal AND p.estado != 0
					INNER JOIN cargo c ON c.id_cargo = p.id_cargo AND c.estado != 0";
		$request3 = $this->select($query);

		$requestData=[$request,$request2,$request3];

		return $requestData;
	}


	public function selectContrato(int $idContrato)
	{
		$this->intIdContrato 	= $idContrato;
		$query = "SELECT cn.id_pedido, pd.memorandum, pd.informe, p.id_personal, p.dni, p.nombre, c.cargo, cn.nro_contrato, c.remuneracion, cn.ruc, cn.fecha_inicio, cn.fecha_fin, cn.id_local, cn.nombre_jefe, cn.verificacion, cn.fecha_nacimiento, cn.sexo, cn.direccion, SUBSTR(u.cod_ubi,1,2) as departamento, SUBSTR(u.cod_ubi,3,2) as provincia, u.id_ubigeo, cn.celular, cn.telefono, cn.id_proceso, pc.codigo_proceso
					FROM contrato cn
					INNER JOIN pedido pd ON pd.id_pedido = cn.id_pedido AND pd.estado_pedido != 0
					INNER JOIN personal p ON cn.id_personal = p.id_personal AND p.estado != 0
					INNER JOIN cargo c ON c.id_cargo = p.id_cargo AND c.estado != 0
					INNER JOIN ubigeo u ON u.id_ubigeo = cn.id_ubigeo
					LEFT JOIN proceso pc ON pc.id_proceso = cn.id_proceso
					WHERE estado_contrato != 0 AND id_contrato = $this->intIdContrato";
		$request = $this->select($query);
		return $request;
	}


	public function updateContrato(int $idContrato, int $pedido, int $idPersonal, string $nroContrato, int $ruc, string $fechaInicio, string $fechaFin, int $proceso, int $local, string $jefe, int $verificacion, string $nacimiento, int $sexo, string $direccion, int $ubigeo, int $celular, int $telefono, int $userSession)
	{

		$this->intIdContrato 	= $idContrato;
		$this->intPedido		= $pedido;
		$this->intIdPersonal	= $idPersonal;
		$this->strNroContrato	= $nroContrato;
		$this->intRuc 			= $ruc;
		$this->strFechaInicio	= $fechaInicio;
		$this->strFechaFin		= $fechaFin;
		$this->intProceso		= $proceso;
		$this->intLocal			= $local;
		$this->strJefe			= $jefe;
		$this->intVerificacion	= $verificacion;
		$this->strNacimiento	= $nacimiento;
		$this->intSexo			= $sexo;	
		$this->strDireccion		= $direccion;
		$this->intUbigeo		= $ubigeo;
		$this->intCelular		= $celular;
		$this->intTelefono		= $telefono;
		$this->intUserSession	= $userSession;

		$queryContrato = "SELECT * FROM contrato WHERE ((id_personal = $this->intIdPersonal AND id_contrato != $this->intIdContrato) OR (id_proceso = $this->intProceso AND id_contrato != $this->intIdContrato)) AND estado_contrato != 0 ";
		$requestContrato = $this->select($queryContrato);

		if(empty($requestContrato)){
			
			$query = "	UPDATE contrato 
						SET id_pedido = ?, 
							id_personal = ?,
							nro_contrato = ?,
							ruc = ?,
							fecha_inicio = ?,
							fecha_fin = ?,
							id_proceso = ?,
							id_local = ?,
							nombre_jefe = ?,
							verificacion = ?,
							fecha_nacimiento = ?,
							sexo = ?,
							direccion = ?,
							id_ubigeo = ?,
							celular = ?,
							telefono = ?,
							user_update = ? 
						WHERE id_contrato = $this->intIdContrato";
			$arrData = array($this->intPedido, $this->intIdPersonal, $this->strNroContrato, $this->intRuc, $this->strFechaInicio, $this->strFechaFin, $this->intProceso, $this->intLocal, $this->strJefe, $this->intVerificacion, $this->strNacimiento, $this->intSexo, $this->strDireccion, $this->intUbigeo, $this->intCelular, $this->intTelefono, $this->intUserSession);
			$request = $this->update($query, $arrData);

			return $request;

		}else{
			
			return  'exist';

		}
	}


	public function deleteContrato(int $idContrato)
	{
		$this->intIdContrato 	=  $idContrato;
		
		$query 	= "UPDATE contrato SET estado_contrato = ? WHERE id_contrato = $this->intIdContrato ";
		$arrData= array(0);
		$request = $this->update($query, $arrData);
			
		return $request;
		
	}


	public function selectContratoReport(int $idContrato)
	{
		$this->intIdContrato 	= $idContrato;
		$query = "SELECT pd.pedido, pd.memorandum, pd.informe, DATE_FORMAT(pd.fecha_pedido, '%d/%m/%Y') fecha_pedido, p.dni, p.nombre, c.cargo, cn.nro_contrato, c.remuneracion, cn.ruc, DATE_FORMAT(cn.fecha_inicio, '%d/%m/%Y') fecha_inicio, DATE_FORMAT(cn.fecha_fin, '%d/%m/%Y') fecha_fin, l.nombre_local, cn.nombre_jefe, CASE WHEN cn.verificacion = 1 THEN 'OK' ELSE 'NO' END AS verificacion, DATE_FORMAT(cn.fecha_nacimiento, '%d/%m/%Y') fecha_nacimiento, CASE WHEN cn.sexo = 1 THEN 'MASCULINO' ELSE 'FEMENINO' END AS sexo, cn.direccion, u.depart_ubi, u.prov_ubi, u.dist_ubi, cn.celular, CASE WHEN cn.telefono = 0 THEN '-' ELSE cn.telefono END AS telefono, pr.codigo_proceso, CASE WHEN p.imagen = '' THEN 'user.png' ELSE p.imagen END AS imagen, us.apellido as apellido_usuario, us.nombre as nombre_usuario, DATE_FORMAT(cn.date_create, '%d/%m/%Y %h:%i:%s %p') date_create
					FROM contrato cn
					INNER JOIN pedido pd ON pd.id_pedido = cn.id_pedido AND pd.estado_pedido != 0
					INNER JOIN personal p ON cn.id_personal = p.id_personal AND p.estado != 0
					INNER JOIN cargo c ON c.id_cargo = p.id_cargo AND c.estado != 0
					INNER JOIN ubigeo u ON u.id_ubigeo = cn.id_ubigeo
					LEFT JOIN local l ON l.id_local = cn.id_local AND l.estado_local != 0
					LEFT JOIN usuario us ON us.id_usuario = cn.user_create AND  us.estado != 0
					LEFT JOIN proceso pr ON pr.id_proceso = cn.id_proceso AND pr.estado_proceso != 0
					WHERE estado_contrato != 0 AND id_contrato = $this->intIdContrato";
		$request = $this->select($query);
		return $request;
	}


	/* ===== FORMACION ACADEMICA =====*/

	public function insertFormAcad(int $idContrato, int $idTipo, int $idNivel, string $especialidad, string $centroEstudio, string $fechaEstudio, int $userSession)
	{
		
		$this->intIdContrato	= $idContrato;
		$this->intIdTipo		= $idTipo;
		$this->intIdNivel		= $idNivel;
		$this->strEspecialidad	= $especialidad;
		$this->strCentroEstudio	= $centroEstudio;
		$this->strFechaEstudio	= $fechaEstudio;
		$this->intUserSession	= $userSession;


		/*$queryContrato = "SELECT id_contrato FROM contrato WHERE estado_contrato != 0 AND (id_personal = $this->intIdPersonal OR nro_contrato ='{$this->strNroContrato}' ) ";

		$requestContrato = $this->select($queryContrato);

		if(empty($requestContrato)){*/
			
		$query = "INSERT INTO formacion(id_contrato, id_estudio, id_nivel, especialidad, centro_estudio, fecha_obtencion, user_create, estado_formacion) VALUES(?,?,?,?,?,?,?,1)";
		$arrData = array($this->intIdContrato, $this->intIdTipo, $this->intIdNivel, $this->strEspecialidad, $this->strCentroEstudio, $this->strFechaEstudio, $this->intUserSession);
		$requestInsert = $this->insert($query, $arrData);
			
		return $requestInsert;

		/*}else{

			return  'exist';
		}*/
	}


	public function selectFormAcad(int $idContrato)
	{

		$this->intIdContrato = $idContrato;

		$query 	= "	SELECT f.id_formacion, f.id_contrato, eg.grado_estudio, en.nivel_estudio, f.especialidad, f.centro_estudio, DATE_FORMAT(fecha_obtencion, '%d/%m/%Y') as fecha_obtencion, f.estado_formacion
					FROM formacion f 
					INNER JOIN estudio_grado eg ON f.id_estudio = eg.id_grado AND eg.estado_grado != 0 
					LEFT JOIN estudio_nivel en ON f.id_nivel = en.id_nivel AND en.estado_nivel != 0
					WHERE estado_formacion != 0 AND id_contrato = $this->intIdContrato ";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectFormAcadId(int $idFormAcad)
	{
		$this->intIdFormAcad 	= $idFormAcad;
		$query = "SELECT * FROM formacion WHERE estado_formacion != 0 AND id_formacion = $this->intIdFormAcad";
		$request = $this->select($query);
		return $request;
	}


	public function updateFormAcad(int $idFormAcad, int $idContrato, int $idTipo, int $idNivel, string $especialidad, string $centroEstudio, string $fechaEstudio, int $userSession)
	{

		$this->intIdFormAcad 	= $idFormAcad;
		$this->intIdContrato	= $idContrato;
		$this->intIdTipo		= $idTipo;
		$this->intIdNivel		= $idNivel;
		$this->strEspecialidad	= $especialidad;
		$this->strCentroEstudio	= $centroEstudio;
		$this->strFechaEstudio	= $fechaEstudio;
		$this->intUserSession	= $userSession;

		/*$queryContrato = "SELECT * FROM formacion WHERE id_contrato != $this->intIdContrato AND estado_contrato != 0 ";
		$requestContrato = $this->select($queryContrato);

		if(empty($requestContrato)){*/
			
			$query = "	UPDATE formacion 
						SET id_estudio = ?, 
							id_nivel = ?,
							especialidad = ?,
							centro_estudio = ?,
							fecha_obtencion = ?,
							user_update = ? 
						WHERE id_formacion = $this->intIdFormAcad";
			$arrData = array($this->intIdTipo, $this->intIdNivel, $this->strEspecialidad, $this->strCentroEstudio, $this->strFechaEstudio, $this->intUserSession);
			$request = $this->update($query, $arrData);

			return $request;

		/*}else{
			
			return  'exist';

		}*/
	}


	public function deleteFormAcad(int $idFormAcad)
	{
		$this->intIdFormAcad 	=  $idFormAcad;
		
		$query 	= "UPDATE formacion SET estado_formacion = ? WHERE id_formacion = $this->intIdFormAcad ";
		$arrData= array(0);
		$request = $this->update($query, $arrData);
			
		return $request;
	}



	/* ===== CURSOS Y/O ESPECIALIZACION =====*/	

	public function insertCursoEspec(int $idContrato, int $idCursoTipo, string $cursoDescrip, string $cursoCentroEstudio, string $cursoFechaInicio, string $cursoFechaFin, int $cursoHoras, int $userSession)
	{
		
		$this->intIdContrato		= $idContrato;
		$this->intIdCursoTipo		= $idCursoTipo;
		$this->strCursoDescrip		= $cursoDescrip;
		$this->strCursoCentroEst	= $cursoCentroEstudio;
		$this->strCursofechaInicio	= $cursoFechaInicio;
		$this->strCursoFechaFin		= $cursoFechaFin;
		$this->intCursoHoras		= $cursoHoras;
		$this->intUserSession		= $userSession;


		/*$queryContrato = "SELECT id_contrato FROM contrato WHERE estado_contrato != 0 AND (id_personal = $this->intIdPersonal OR nro_contrato ='{$this->strNroContrato}' ) ";

		$requestContrato = $this->select($queryContrato);

		if(empty($requestContrato)){*/
			
		$query = "INSERT INTO curso(id_contrato, id_especializacion, descripcion, centro_estudioCurso, fecha_inicioCurso, fecha_finCurso, horas_lectivas, user_create, estado_curso) VALUES(?,?,?,?,?,?,?,?,1)";
		$arrData = array($this->intIdContrato, $this->intIdCursoTipo, $this->strCursoDescrip, $this->strCursoCentroEst, $this->strCursofechaInicio, $this->strCursoFechaFin, $this->intCursoHoras, $this->intUserSession);
		$requestInsert = $this->insert($query, $arrData);
			
		return $requestInsert;

		/*}else{

			return  'exist';
		}*/
	}


	public function selectCursoEspec(int $idContrato)
	{

		$this->intIdContrato = $idContrato;

		$query 	= "SELECT id_curso, id_contrato, id_especializacion, descripcion, centro_estudioCurso, DATE_FORMAT(fecha_inicioCurso, '%d/%m/%Y') fecha_inicioCurso, DATE_FORMAT(fecha_finCurso, '%d/%m/%Y') fecha_finCurso, horas_lectivas, estado_curso, CASE WHEN id_especializacion = 1 THEN 'PROGRAMA DE ESPECIALIZACION' ELSE 'CURSO' END AS especializacion FROM curso WHERE estado_curso != 0 AND id_contrato = $this->intIdContrato ";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCursoEspecId(int $idCursoEspec)
	{
		$this->intIdCursoEspec 	= $idCursoEspec;
		$query = "SELECT * FROM curso WHERE estado_curso != 0 AND id_curso = $this->intIdCursoEspec";
		$request = $this->select($query);
		return $request;
	}


	public function updateCursoEspec(int $idCursoEspec, int $idContrato, int $idCursoTipo, string $cursoDescrip, string $cursoCentroEstudio, string $cursoFechaInicio, string $cursoFechaFin, int $cursoHoras, int $userSession)
	{

		$this->intIdCursoEspec 		= $idCursoEspec;
		$this->intIdContrato		= $idContrato;
		$this->intIdCursoTipo		= $idCursoTipo;
		$this->strCursoDescrip		= $cursoDescrip;
		$this->strCursoCentroEst	= $cursoCentroEstudio;
		$this->strCursofechaInicio	= $cursoFechaInicio;
		$this->strCursoFechaFin		= $cursoFechaFin;
		$this->intCursoHoras		= $cursoHoras;
		$this->intUserSession		= $userSession;

		/*$queryContrato = "SELECT * FROM formacion WHERE id_contrato != $this->intIdContrato AND estado_contrato != 0 ";
		$requestContrato = $this->select($queryContrato);

		if(empty($requestContrato)){*/
			
			$query = "	UPDATE curso 
						SET id_especializacion = ?, 
							descripcion = ?,
							centro_estudioCurso = ?,
							fecha_inicioCurso = ?,
							fecha_finCurso = ?,
							horas_lectivas = ?,
							user_update = ? 
						WHERE id_curso = $this->intIdCursoEspec";
			$arrData = array($this->intIdCursoTipo, $this->strCursoDescrip, $this->strCursoCentroEst, $this->strCursofechaInicio, $this->strCursoFechaFin, $this->intCursoHoras, $this->intUserSession);
			$request = $this->update($query, $arrData);

			return $request;

		/*}else{
			
			return  'exist';

		}*/
	}


	public function deleteCursoEspec(int $idCursoEspec)
	{
		$this->intIdCursoEspec 	=  $idCursoEspec;
		
		$query 	= "UPDATE curso SET estado_curso = ? WHERE id_curso = $this->intIdCursoEspec ";
		$arrData= array(0);
		$request = $this->update($query, $arrData);
			
		return $request;
	}



	/* ===== EXPERIENCIA LABORAL =====*/

	public function insertExperiencia(int $idContrato, int $experienciaTipo, int $experienciaTipoEntidad, string $experienciaEntidad, string $experienciaArea, string $experienciaCargo, string $experienciaFechaInicio, string $experienciaFechaFin, string $experienciaTiempo, int $experienciaTiempoDias, int $userSession)
	{
		
		$this->intIdContrato				= $idContrato;
		$this->intExperienciaTipo			= $experienciaTipo;
		$this->intExperienciatipoEntidad	= $experienciaTipoEntidad;
		$this->strExperienciaEntidad		= $experienciaEntidad;
		$this->strExperienciaArea			= $experienciaArea;
		$this->strExperienciaCargo			= $experienciaCargo;
		$this->strExperienciaFechaInicio	= $experienciaFechaInicio;
		$this->strExperienciaFechaFin		= $experienciaFechaFin;
		$this->strExperienciaTiempo			= $experienciaTiempo;
		$this->intExperienciaTiempoDias		= $experienciaTiempoDias;
		$this->intUserSession				= $userSession;


		$queryExperiencia = "SELECT id_experiencia FROM experiencia WHERE estado_experiencia != 0 AND id_tipo = $this->intExperienciaTipo AND (id_tipo BETWEEN '{$this->strExperienciaFechaInicio}' AND '{$this->strExperienciaFechaFin}' ) AND (cargo_entidad BETWEEN '{$this->strExperienciaFechaInicio}' AND '{$this->strExperienciaFechaFin}' ) ";

		$requestExperiencia = $this->select($queryExperiencia);

		if(empty($requestExperiencia)){
			
			$query = "INSERT INTO experiencia(id_contrato, id_tipo, id_tipoEntidad, entidad, area_entidad, cargo_entidad, fecha_inicioExp, fecha_finExp, tiempo, tiempo_dias, user_create, estado_experiencia) VALUES(?,?,?,?,?,?,?,?,?,?,?,1)";
			$arrData = array($this->intIdContrato, $this->intExperienciaTipo, $this->intExperienciatipoEntidad, $this->strExperienciaEntidad, $this->strExperienciaArea, $this->strExperienciaCargo, $this->strExperienciaFechaInicio, $this->strExperienciaFechaFin, $this->strExperienciaTiempo, $this->intExperienciaTiempoDias, $this->intUserSession);
			$requestInsert = $this->insert($query, $arrData);
			
			return $requestInsert;

		}else{

			return  'exist';
		}
	}


	public function selectExperiencia(int $idContrato)
	{

		$this->intIdContrato = $idContrato;

		$query 	= "SELECT id_experiencia, id_contrato, id_tipo, id_tipoEntidad, entidad, area_entidad, cargo_entidad, DATE_FORMAT(fecha_inicioExp, '%d/%m/%Y') fecha_inicioExp, DATE_FORMAT(fecha_finExp, '%d/%m/%Y') fecha_finExp, tiempo, tiempo_dias, estado_experiencia, CASE WHEN id_tipo = 1 THEN 'GENERAL' ELSE 'ESPECIFICA' END AS tipo_experiencia , CASE WHEN id_tipoEntidad = 1 THEN 'PUBLICO' ELSE 'PRIVADO' END AS tipo_entidad  FROM experiencia WHERE estado_experiencia != 0 AND id_contrato = $this->intIdContrato ORDER BY fecha_inicioExp DESC";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectExperienciaId(int $idExperiencia)
	{
		$this->intIdExperiencia 	= $idExperiencia;
		$query = "SELECT * FROM experiencia WHERE estado_experiencia != 0 AND id_experiencia = $this->intIdExperiencia";
		$request = $this->select($query);
		return $request;
	}


	public function updateExperiencia(int $idExperiencia, int $idContrato, int $experienciaTipo, int $experienciaTipoEntidad, string $experienciaEntidad, string $experienciaArea, string $experienciaCargo, string $experienciaFechaInicio, string $experienciaFechaFin, string $experienciaTiempo, int $experienciaTiempoDias, int $userSession)
	{

		$this->intIdExperiencia 			= $idExperiencia;
		$this->intExperienciaTipo			= $experienciaTipo;
		$this->intExperienciatipoEntidad	= $experienciaTipoEntidad;
		$this->strExperienciaEntidad		= $experienciaEntidad;
		$this->strExperienciaArea			= $experienciaArea;
		$this->strExperienciaCargo			= $experienciaCargo;
		$this->strExperienciaFechaInicio	= $experienciaFechaInicio;
		$this->strExperienciaFechaFin		= $experienciaFechaFin;
		$this->strExperienciaTiempo			= $experienciaTiempo;
		$this->intExperienciaTiempoDias		= $experienciaTiempoDias;
		$this->intUserSession				= $userSession;

		/*$queryContrato = "SELECT * FROM formacion WHERE id_contrato != $this->intIdContrato AND estado_contrato != 0 ";
		$requestContrato = $this->select($queryContrato);

		if(empty($requestContrato)){*/
			
			$query = "	UPDATE experiencia 
						SET id_tipo = ?, 
							id_tipoEntidad = ?,
							entidad = ?,
							area_entidad = ?,
							cargo_entidad = ?,
							fecha_inicioExp = ?,
							fecha_finExp = ?,
							tiempo = ?,
							tiempo_dias = ?,
							user_update = ? 
						WHERE id_experiencia = $this->intIdExperiencia";
			$arrData = array($this->intExperienciaTipo, $this->intExperienciatipoEntidad, $this->strExperienciaEntidad, $this->strExperienciaArea, $this->strExperienciaCargo, $this->strExperienciaFechaInicio, $this->strExperienciaFechaFin, $this->strExperienciaTiempo, $this->intExperienciaTiempoDias, $this->intUserSession);
			$request = $this->update($query, $arrData);

			return $request;

		/*}else{
			
			return  'exist';

		}*/
	}


	public function deleteExperiencia(int $idExperiencia)
	{
		$this->intIdExperiencia 	=  $idExperiencia;
		
		$query 	= "UPDATE experiencia SET estado_experiencia = ? WHERE id_experiencia = $this->intIdExperiencia ";
		$arrData= array(0);
		$request = $this->update($query, $arrData);
			
		return $request;
	}


	public function countExperiencia(int $idContrato)
	{
	
		$this->intIdContrato 	= 	$idContrato;
		$query = "	SELECT id_tipo, SUM(tiempo_dias) AS total_experiencia
					FROM experiencia 
					WHERE estado_experiencia != 0 AND id_contrato = $this->intIdContrato
					GROUP BY id_tipo
					ORDER BY id_tipo ASC";
		$request = $this->select_all($query);
		return $request;
	}

	

	/* ===== METODO PROCESO - CONTRATO ======*/
	
	public function selectCboProceso()
	{
		$query = "SELECT * FROM proceso WHERE estado_proceso != 0 ORDER BY nombre_proceso ASC";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboLocal()
	{
		$query = "SELECT * FROM local WHERE estado_local != 0 ORDER BY nombre_local ASC";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboDepartamento()
	{
		$query = "SELECT DISTINCT SUBSTR(cod_ubi,1,2) codigo, depart_ubi FROM ubigeo ORDER BY depart_ubi";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboProvincia(string $codDepart)
	{
		$this->strCodDepart = $codDepart;

		$query = "SELECT DISTINCT SUBSTR(cod_ubi,3,2) codigo, prov_ubi FROM ubigeo where SUBSTR(cod_ubi,1,2) = $this->strCodDepart ORDER BY prov_ubi";
		$request = $this->select_all($query);
		return $request;

	}


	public function selectCboDistrito(string $codDepart, string $CodProv)
	{
		$this->strCodDepart = $codDepart;
		$this->strCodProv 	= $CodProv;

		$query = "SELECT DISTINCT id_ubigeo, dist_ubi FROM ubigeo where SUBSTR(cod_ubi,1,2) = $this->strCodDepart AND SUBSTR(cod_ubi,3,2) = $this->strCodProv ORDER BY dist_ubi";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboGrado()
	{
		$query = "SELECT id_grado, grado_estudio FROM estudio_grado WHERE estado_grado != 0 ORDER BY grado_estudio";
		$request = $this->select_all($query);
		return $request;
	}


	public function selectCboNivel(int $idNivel)
	{
		$this->intIdNive = $idNivel;

		$query = "	SELECT en.id_nivel, en.nivel_estudio
					FROM estudio_nivel en
					INNER JOIN estudio_grado_nivel egn ON en.id_nivel = egn.id_nivel
					WHERE egn.id_grado = $this->intIdNive
					ORDER BY en.id_nivel";
		$request = $this->select_all($query);
		return $request;
	}
	

}