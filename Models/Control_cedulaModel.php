<?php

/**
 */
class Control_cedulaModel extends Mysql
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
    private $intIdDepartamento;
    private $intIdProvincia;
    private $intIdDistrito;

    private $strDepartamento;
    private $strProvincia;
    private $strDistrito;

    private $strConsulta;
    private $intIdUsusario;
    private $intIdSobre;
    private $intIdConsulta;
    private $strCodMesa;
    private $intIdDocumento;

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
        parent::__construct();
    }

    /* INICIO DE MODELOS DE COMBO */
    public function selectCboOdpe(int $idprocesos)
    {
        $this->intIdProceso = $idprocesos;
        $query = "SELECT o.id, o.nombre_odpe FROM procesos p
                        INNER JOIN ubigeo_consultas uc on p.id = uc.id_proceso
                        INNER JOIN ubigeos u on uc.id_ubigeo = u.id
                        INNER JOIN odpes o on u.id_odpe = o.id
                    WHERE p.id = $this->intIdProceso
                    group by o.id, o.nombre_odpe
                    order by o.id, o.nombre_odpe;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectCboSolucion(int $idodpe)
    {
        $this->intIdOdpe = $idodpe;
        $query = "SELECT DISTINCT s.id, s.solucion_tecnologica
                    FROM ubigeos u -- id_odpe
                    INNER JOIN ubigeo_soluciones us on u.id = us.id_ubigeo
                    INNER JOIN soluciones s on us.id_solucion = s.id
                    WHERE u.id_odpe = $this->intIdOdpe
                    ORDER BY s.solucion_tecnologica;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectCboDepartamento(int $idprocesos, int $idSolucion, int $idOdpe)
    {
        $this->intIdProceso = $idprocesos;
        $this->intIdOdpe = $idOdpe;
        $this->intIdSolucion = $idSolucion;

        $query = "SELECT DISTINCT d.id, d.descripcion
                    FROM ubigeos u
                         INNER JOIN departamentos d ON u.id_departamento = d.id
                     WHERE u.id_odpe = $this->intIdOdpe;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectCboProvincia(int $idprocesos, int $idSolucion, int $idOdpe, string $Departamento, int $idEleccion)
    {
        $this->intIdProceso = $idprocesos;
        $this->intIdSolucion = $idSolucion;
        $this->intIdOdpe = $idOdpe;
        $this->strDepartamento = $Departamento;
        $this->intIdEleccion = $idEleccion;
        $query = "SELECT DISTINCT p.id, p.descripcion
                    FROM ubigeos u INNER JOIN provincias p on u.id_provincia = p.id
                    WHERE u.id_odpe = $this->intIdOdpe AND u.id_departamento=$this->strDepartamento;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectCboDistrito(int $idprocesos, int $idSolucion, int $idOdpe, string $Departamento, string $Provincia)
    {
        $this->intIdProceso = $idprocesos;
        $this->intIdSolucion = $idSolucion;
        $this->intIdOdpe = $idOdpe;
        $this->strDepartamento = $Departamento;
        $this->strProvincia = $Provincia;
        $query = "SELECT DISTINCT d.id, d.descripcion
                    FROM ubigeos u
                    INNER JOIN ubigeo_soluciones us on u.id = us.id_ubigeo
                    INNER JOIN distritos d on u.id_distrito = d.id
                    WHERE u.id_odpe = $this->intIdOdpe AND u.id_departamento = $this->strDepartamento 
                      AND u.id_provincia = $this->strProvincia AND us.id_solucion = $this->intIdSolucion;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectCboConsulta(int $idprocesos, int $idodpes, $iddepartamento, $idprovincia, $iddistrito)
    {
        $this->intIdProceso = $idprocesos;
        $this->intIdOdpe = $idodpes;
        $this->intIdDepartamento = $iddepartamento;
        $this->intIdProvincia = $idprovincia;
        $this->intIdDistrito = $iddistrito;
        $query = "";
        if ($this->intIdProvincia == null) {
            $query = "SELECT DISTINCT c.id, c.descripcion
                    FROM ubigeo_consultas uc
                             INNER JOIN consultas c ON c.id = uc.id_consulta
                             INNER JOIN ubigeos u ON uc.id_ubigeo = u.id
                    WHERE uc.id_proceso = $this->intIdProceso
                      AND u.id_odpe = $this->intIdOdpe
                      AND u.id_departamento = $this->intIdDepartamento
                    ORDER BY c.id;";
        } elseif ($this->intIdDistrito == null) {
            $query = "SELECT DISTINCT c.id, c.descripcion
                    FROM ubigeo_consultas uc
                             INNER JOIN consultas c ON c.id = uc.id_consulta
                             INNER JOIN ubigeos u ON uc.id_ubigeo = u.id
                    WHERE uc.id_proceso = $this->intIdProceso
                      AND u.id_odpe = $this->intIdOdpe
                      AND u.id_departamento = $this->intIdDepartamento
                      AND u.id_provincia = $this->intIdProvincia
                    ORDER BY c.id;";
        } else {
            $query = "SELECT c.id, c.descripcion
                    FROM ubigeo_consultas uc
                             INNER JOIN consultas c ON c.id = uc.id_consulta
                             INNER JOIN ubigeos u ON uc.id_ubigeo = u.id
                    WHERE uc.id_proceso = $this->intIdProceso
                      AND u.id_odpe = $this->intIdOdpe
                      AND u.id_departamento = $this->intIdDepartamento
                      AND u.id_provincia = $this->intIdProvincia
                      AND u.id_distrito = $this->intIdDistrito
                    ORDER BY c.id;";
        }
        $request = $this->select_all($query);
        return $request;
    }

    public function selectCboSobre(int $idSolucion)
    {
        $this->intIdSolucion = $idSolucion;
        $query = "SELECT id, sobre FROM sobres;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectCboSufragio(int $idConsulta)
    {
        $this->intIdConsulta = $idConsulta;
        $query = "SELECT * FROM sufragios s INNER JOIN consulta_sufragios cs on s.id = cs.id_sufragio 
                    WHERE cs.id_consulta = $this->intIdConsulta ORDER BY s.id;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectCboDocumento(int $idSolucion, int $idSobre)
    {
        $this->intIdSolucion = $idSolucion;
        $this->intIdSobre = $idSobre;
        $query = "SELECT d.id,d.documento FROM documentos d INNER JOIN solucion_documentos sd ON d.id = sd.id_documento 
                    WHERE sd.id_solucion = $this->intIdSolucion AND sd.id_sobre = $this->intIdSobre ORDER BY d.id;";
        $request = $this->select_all($query);
        return $request;
    }

    /* FIN DE MODELOS COMBOS */
    public function avanceDocumentos(int $idprocesos)
    {
        $this->intIdProceso = $idprocesos;
        $query = "CALL sp_avance_general($this->intIdProceso);";
        $request = $this->select_all($query);
        return $request;
    }

    public function avanceOdpe(int $idprocesos, int $idOdpe)
    {
        $this->intIdProceso = $idprocesos;
        $this->intIdOdpe = $idOdpe;
        $query = "CALL sp_avance_general_odpe($this->intIdProceso, $this->intIdOdpe);";
        $request = $this->select_all($query);
        return $request;
    }


    public function selectIdMesa(int $idprocesos, string $nroMesa)
    {

        $this->intIdProceso = $idprocesos;
        $this->strNroMesa = $nroMesa;

        $query = " 	SELECT MS.ID_SUFRAGIO
				    FROM MESA_SUFRAGIO MS
				    WHERE MS.ID_PROCESO=$this->intIdProceso
				    AND MS.NRO_MESA='{$this->strNroMesa}'";

        $request = $this->select($query);
        return $request;
    }

    public function selectinpBarra(int $idprocesos, int $idSolucion, int $idOdpe, int $idDepartamento, int $idProvincia, int $idDistrito, string $idConsulta, int $idSobre, int $idDocumento, int $idEleccion)
    {
        $this->intIdProceso = $idprocesos;
        $this->intIdSolucion = $idSolucion;
        $this->intIdOdpe = $idOdpe;
        $this->intIdDepartamento = $idDepartamento;
        $this->intIdProvincia = $idProvincia;
        $this->intIdDistrito = $idDistrito;
        $this->intIdConsulta = $idConsulta;
        $this->intIdSobre = $idSobre;
        $this->intIdDocumento = $idDocumento;
        $this->intIdEleccion = $idEleccion;

        $query = "SELECT cod_documento, cant_digito FROM documentos WHERE id= $this->intIdDocumento;";
        $request = $this->select($query);
        return $request;
    }

    public function insertRecepcionDocumentos(
        int $idproceso, int $idSolucion, int $idOdpe, int $idDepartamento, int $idProvincia, int $idDistrito,
        int $idConsulta, int $idSobre, int $idSufragio, int $idDocumento, string $codMesa)
    {
        $this->intIdProceso = $idproceso;
        $this->intIdSolucion = $idSolucion;
        $this->intIdOdpe = $idOdpe;
        $this->intIdDepartamento = $idDepartamento;
        $this->intIdProvincia = $idProvincia;
        $this->intIdDistrito = $idDistrito;
        $this->intIdConsulta = $idConsulta;
        $this->intIdSobre = $idSobre;
        $this->intIdSufragio = $idSufragio;
        $this->intIdDocumento = $idDocumento;
        $this->strNroMesa = $codMesa;

        $query = "CALL sp_insert_recepcion_documentos($this->intIdProceso, $this->intIdSolucion, $this->intIdOdpe,
        $this->intIdDepartamento, $this->intIdProvincia, $this->intIdDistrito, $this->intIdConsulta,
        $this->intIdSobre, $this->intIdSufragio, $this->intIdDocumento, '$this->strNroMesa');";
        $request = $this->select($query);
                /*
        // Revisar el la mesa
        $queryIdMesa = "SELECT id FROM mesas WHERE nro_mesa = SUBSTRING('{$this->strNroMesa}', 1, 6);";
        $requestIdMesa = (int)$this->select($queryIdMesa);
        if ($requestIdMesa != 0) {
            if ($this->intIdSobre = 3) {// si el sobre es plomo 3
                // Revisar el ubigeo
                $queryIdUbigeo = "SELECT id FROM ubigeos WHERE id_departamento=$this->intIdDepartamento 
                         AND id_provincia=$this->intIdProvincia AND id_distrito=$this->intIdDistrito;";
                $requestIdUbigeo = (int)$this->select($queryIdUbigeo);

                $query = "INSERT INTO recepcion_documentos (
                                        id_proceso, id_solucion, id_odpe, id_ubigeo, id_consulta, id_sobre,
                                        id_sufragio, id_documento, id_mesa, created_at, updated_at) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
                $arrData = array(
                    $this->intIdProceso, $this->intIdSolucion, $this->intIdOdpe, $requestIdUbigeo, $this->intIdConsulta,
                    $this->intIdSobre, $this->intIdSufragio, $this->intIdDocumento, $requestIdMesa);
                $requestInsert = $this->insert($query, $arrData);
            }
        }*/

        return $request;
    }


    public function validarUbigeoExiste(int $idprocesos, string $nroUbigeo, int $idValor)
    {

        $this->intIdProceso = $idprocesos;
        $this->strNroUbigeo = $nroUbigeo;
        $this->intIdValor = $idValor;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_UBIGEO_EXISTE( :P_ID_PROCESO, :P_UBIGEO, :P_VALOR, :P_ID_UBIGEO); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_UBIGEO', $this->strNroUbigeo);
        oci_bind_by_name($stid, ':P_VALOR', $this->intIdValor);
        oci_bind_by_name($stid, ':P_ID_UBIGEO', $P_ID_UBIGEO, 40);
        oci_execute($stid);

        if ($P_ID_UBIGEO == 0) {
            return 0;
        } else {
            return $P_ID_UBIGEO;
        }

    }

    public function validarUbigeoAgrupacion(int $idprocesos, string $idAgrupacion)
    {

        $this->intIdProceso = $idprocesos;
        $this->intIdAgrupacion = $idAgrupacion;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_UBIGEO_AGRUP( :P_ID_PROCESO, :P_UBIGEO, :P_COD_AGRUPACION); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_UBIGEO', $this->intIdAgrupacion);
        oci_bind_by_name($stid, ':P_COD_AGRUPACION', $P_COD_AGRUPACION, 40);
        oci_execute($stid);

        if ($P_COD_AGRUPACION == 0) {
            return 0;
        } else {
            return $P_COD_AGRUPACION;
        }

    }

    public function validarMesaExiste(int $idprocesos, string $nroMesa)
    {

        $this->intIdProceso = $idprocesos;
        $this->strNroMesa = $nroMesa;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_EXISTE( :P_ID_PROCESO, :P_NROMESA, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }

    }

    public function validarMesaSoltec(int $idprocesos, string $idSoltec, string $nroMesa)
    {
        $this->intIdProceso = $idprocesos;
        $this->strNroMesa = $nroMesa;
        $this->idSoltec = $idSoltec;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_SOLTEC( :P_ID_PROCESO, :P_NROMESA, :P_ID_SOLUCION, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_ID_SOLUCION', $this->idSoltec);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }
    }

    public function validarMesaOdpe(int $idprocesos, int $idOdpe, string $nroMesa)
    {

        $this->intIdProceso = $idprocesos;
        $this->strNroMesa = $nroMesa;
        $this->intIdOdpe = $idOdpe;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_ODPE( :P_ID_PROCESO, :P_NROMESA, :P_ID_ODPE, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }

    }

    public function validarMesaAgrupacion(int $idprocesos, int $idAgrupacion, string $nroMesa)
    {

        $this->intIdProceso = $idprocesos;
        $this->strNroMesa = $nroMesa;
        $this->intIdAgrupacion = $idAgrupacion;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_AGRUPACION( :P_ID_PROCESO, :P_NROMESA, :P_ID_AGRUPACION, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_ID_AGRUPACION', $this->intIdAgrupacion);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }

    }

    public function validarMesaDepart(int $idprocesos, string $Departamento, string $nroMesa)
    {

        $this->intIdProceso = $idprocesos;
        $this->strNroMesa = $nroMesa;
        $this->strDepartamento = $Departamento;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_DEPART( :P_ID_PROCESO, :P_NROMESA, :P_DEPART, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_DEPART', $this->strDepartamento);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }
    }

    public function validarMesaProv(int $idprocesos, string $Departamento, string $Provincia, string $nroMesa)
    {
        $this->intIdProceso = $idprocesos;
        $this->strNroMesa = $nroMesa;
        $this->strDepartamento = $Departamento;
        $this->strProvincia = $Provincia;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_PROV( :P_ID_PROCESO, :P_NROMESA, :P_DEPART, :P_PROV, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_DEPART', $this->strDepartamento);
        oci_bind_by_name($stid, ':P_PROV', $this->strProvincia);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }
    }

    public function validarMesaDist(int $idprocesos, string $Departamento, string $Provincia, string $Distrito, string $nroMesa)
    {
        $this->intIdProceso = $idprocesos;
        $this->strNroMesa = $nroMesa;
        $this->strDepartamento = $Departamento;
        $this->strProvincia = $Provincia;
        $this->strDistrito = $Distrito;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_DIST( :P_ID_PROCESO, :P_NROMESA, :P_DEPART, :P_PROV, :P_DIST, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_DEPART', $this->strDepartamento);
        oci_bind_by_name($stid, ':P_PROV', $this->strProvincia);
        oci_bind_by_name($stid, ':P_DIST', $this->strDistrito);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }
    }


    public function validarMesaElect(int $idprocesos, string $nroElectores, string $nroMesa)
    {
        $this->intIdProceso = $idprocesos;
        $this->strNroMesa = $nroMesa;
        $this->strNroElectores = $nroElectores;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_ELECT( :P_ID_PROCESO, :P_NROMESA, :P_ELECTORES, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_ELECTORES', $this->strNroElectores);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }
    }


    public function validarMesaUbigeo(int $idprocesos, string $nroUbigeo, string $nroMesa, int $idValor)
    {
        $this->intIdProceso = $idprocesos;
        $this->strNroMesa = $nroMesa;
        $this->strNroUbigeo = $nroUbigeo;
        $this->intIdValor = $idValor;

        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_UBIGEO( :P_ID_PROCESO, :P_NROMESA, :P_UBIGEO, :P_VALOR, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_UBIGEO', $this->strNroUbigeo);
        oci_bind_by_name($stid, ':P_VALOR', $this->intIdValor);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }
    }


    public function IncidenciaExiste(int $idMaterial, int $idprocesos, int $idEtapa, string $nroMesa, string $consulta)
    {
        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->strNroMesa = $nroMesa;
        $this->strConsulta = $consulta;

        $query = "	SELECT ci.ID_SUFRAGIO
					FROM control_incidencia ci 
					WHERE ci.id_proceso=$this->intIdProceso 
                    AND ci.id_material=$this->intIdMaterial 
                    AND ci.id_etapa=$this->intIdEtapa 
                    AND ci.paquete = '{$this->strConsulta}' 
                    AND ci.estado IN (1,2) AND ci.ID_SUFRAGIO = (
                                                                  	SELECT ms.ID_SUFRAGIO 
                                                                  	FROM MESA_SUFRAGIO ms 
                                                                  	WHERE ms.NRO_MESA = '{$this->strNroMesa}' AND ms.id_proceso=$this->intIdProceso)";
        $request = $this->select($query);
        return $request;

    }

    public function MesaPasoEtapa(int $idMaterial, int $idprocesos, int $idEtapa, string $nroMesa, int $idSoltec, string $consulta, int $validacion, string $nroUbigeo)
    {

        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->strNroMesa = $nroMesa;
        $this->intIdSolucion = $idSoltec;
        $this->strConsulta = $consulta;
        $this->intIdValidacion = $validacion;
        $this->strNroUbigeo = $nroUbigeo;

        $query = "	SELECT cc.ID_SUFRAGIO
					FROM control_calidad cc
					WHERE cc.id_proceso = $this->intIdProceso
                    AND cc.id_material = $this->intIdMaterial
                    AND cc.paquete = '{$this->strConsulta}' 
                    AND cc.validacion = $this->intIdValidacion
                    AND cc.ubigeo = '{$this->strNroUbigeo}'
                    AND cc.id_etapa= $this->intIdEtapa
                    AND cc.id_sufragio=(
                                        	SELECT ms.ID_SUFRAGIO 
                                        	FROM MESA_SUFRAGIO ms 
                                        	WHERE ms.NRO_MESA = '{$this->strNroMesa}' AND ms.id_proceso=$this->intIdProceso)";

        $request = $this->select($query);
        return $request;

    }


    public function MesaExisteControl(int $idMaterial, int $idprocesos, int $idEtapa, string $nroMesa, int $idSoltec, string $consulta, int $validacion, string $nroUbigeo)
    {

        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->strNroMesa = $nroMesa;
        $this->intIdSolucion = $idSoltec;
        $this->strConsulta = $consulta;
        $this->intIdValidacion = $validacion;
        $this->strNroUbigeo = $nroUbigeo;

        $query = "	SELECT cc.ID_SUFRAGIO 
                   	FROM CONTROL_CALIDAD cc
                    WHERE cc.ID_PROCESO = $this->intIdProceso
                    AND cc.ID_MATERIAL = $this->intIdMaterial
                    AND cc.ID_ETAPA =  $this->intIdEtapa
                    AND cc.ID_SOLUCION= $this->intIdSolucion 
                    AND cc.PAQUETE = '{$this->strConsulta}' 
                    AND cc.VALIDACION =$this->intIdValidacion 
                    AND cc.UBIGEO = '{$this->strNroUbigeo}'
                    AND cc.ID_SUFRAGIO = (
                                            SELECT ms.ID_SUFRAGIO 
                                            FROM MESA_SUFRAGIO ms 
                                            WHERE ms.NRO_MESA = '{$this->strNroMesa}' AND ms.id_proceso=$this->intIdProceso )";

        $request = $this->select($query);
        return $request;

    }

    public function insertCedula(int $idMaterial, int $idprocesos, int $idEtapa, int $idSoltec, int $idOdpe, string $nroMesa, string $consulta, int $validacion, int $idUsuario, string $nroUbigeo)
    {

        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->intIdSolucion = $idSoltec;
        $this->intIdOdpe = $idOdpe;
        $this->strNroMesa = $nroMesa;
        $this->strConsulta = $consulta;
        $this->intIdValidacion = $validacion;
        $this->intIdUsusario = $idUsuario;
        $this->strNroUbigeo = $nroUbigeo;


        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_INSERTAR( :P_ID_MATERIAL, :P_ID_PROCESO, :P_ID_ETAPA, :P_ID_SOLUCION, :P_ID_ODPE, :P_NROMESA, :P_CONSULTA, :P_ID_VALIDACION, :P_ID_USUARIO, :P_NROUBIGEO, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_MATERIAL', $this->intIdMaterial);
        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_ID_ETAPA', $this->intIdEtapa);
        oci_bind_by_name($stid, ':P_ID_SOLUCION', $this->intIdSolucion);
        oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_CONSULTA', $this->strConsulta);
        oci_bind_by_name($stid, ':P_ID_VALIDACION', $this->intIdValidacion);
        oci_bind_by_name($stid, ':P_ID_USUARIO', $this->intIdUsusario);
        oci_bind_by_name($stid, ':P_NROUBIGEO', $this->strNroUbigeo);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }

    }


    public function updateCedula(int $idMaterial, int $idprocesos, int $idEtapa, int $idSoltec, int $idOdpe, string $nroMesa, string $consulta, int $validacion, string $nroUbigeo)
    {

        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->intIdSolucion = $idSoltec;
        $this->intIdOdpe = $idOdpe;
        $this->strNroMesa = $nroMesa;
        $this->strConsulta = $consulta;
        $this->intIdValidacion = $validacion;
        $this->strNroUbigeo = $nroUbigeo;


        $stid = oci_parse($this->conOracle->conexion(), 'BEGIN PA_VALIDAR_MESA_UPDATE( :P_ID_MATERIAL, :P_ID_PROCESO, :P_ID_ETAPA, :P_ID_SOLUCION, :P_ID_ODPE, :P_NROMESA, :P_CONSULTA, :P_ID_VALIDACION, :P_NROUBIGEO, :P_ID_SUFRAGIO); END;');

        oci_bind_by_name($stid, ':P_ID_MATERIAL', $this->intIdMaterial);
        oci_bind_by_name($stid, ':P_ID_PROCESO', $this->intIdProceso);
        oci_bind_by_name($stid, ':P_ID_ETAPA', $this->intIdEtapa);
        oci_bind_by_name($stid, ':P_ID_SOLUCION', $this->intIdSolucion);
        oci_bind_by_name($stid, ':P_ID_ODPE', $this->intIdOdpe);
        oci_bind_by_name($stid, ':P_NROMESA', $this->strNroMesa);
        oci_bind_by_name($stid, ':P_CONSULTA', $this->strConsulta);
        oci_bind_by_name($stid, ':P_ID_VALIDACION', $this->intIdValidacion);
        oci_bind_by_name($stid, ':P_NROUBIGEO', $this->strNroUbigeo);
        oci_bind_by_name($stid, ':P_ID_SUFRAGIO', $P_ID_SUFRAGIO, 40);
        oci_execute($stid);

        if ($P_ID_SUFRAGIO == 0) {
            return 0;
        } else {
            return $P_ID_SUFRAGIO;
        }

    }


    public function ordenEmpaquetado(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, string $Departamento, string $Provincia, string $Distrito, string $consulta, int $validacion)
    {

        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->intIdFase = $idFase;
        $this->intIdSolucion = $idSoltec;
        $this->intIdOdpe = $idOdpe;
        $this->strDepartamento = $Departamento;
        $this->strProvincia = $Provincia;
        $this->strDistrito = $Distrito;
        $this->strConsulta = $consulta;
        $this->intIdValidacion = $validacion;

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
	                AND M.ID_SUFRAGIO NOT IN( SELECT CC.ID_SUFRAGIO 
	                                        FROM CONTROL_CALIDAD CC 
	                                        WHERE CC.ID_PROCESO=$this->intIdProceso	 
	                                        AND CC.ID_MATERIAL=$this->intIdMaterial 
	                                        AND CC.ID_ETAPA= $this->intIdEtapa
	                                        AND CC.ID_ODPE=$this->intIdOdpe 
	                                        AND CC.VALIDACION=$this->intIdValidacion
	                                        AND CC.PAQUETE='{$this->strConsulta}') 

	                ORDER BY  L.CODIGO_LOCAL, L.NOMBRE_LOCAL, M.NRO_MESA ASC)
					WHERE ROWNUM = 1";

        $request = $this->select($query);
        return $request;

    }


    public function ordenEmpaquetadoEI(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, string $Departamento, string $Provincia, string $Distrito, string $consulta, int $validacion)
    {

        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->intIdFase = $idFase;
        $this->intIdSolucion = $idSoltec;
        $this->intIdOdpe = $idOdpe;
        $this->strDepartamento = $Departamento;
        $this->strProvincia = $Provincia;
        $this->strDistrito = $Distrito;
        $this->strConsulta = $consulta;
        $this->intIdValidacion = $validacion;

        $query = "	SELECT * FROM (
					SELECT U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.CODIGO_LOCAL, L.NOMBRE_LOCAL, M.NRO_MESA, ST.SOLUCIONTECNOLOGICA, PC.TIPO_CEDULA, PC.DIG_UBIGEO, PC.PREF_UBIGEO, PC.SUF_UBIGEO, PC.DIG_ROTULO, PC.PREF_ROTULO, PC.SUF_ROTULO, AP.AGRUPACION, M.COD_TIPO  
					FROM MESA_SUFRAGIO M 
					LEFT JOIN UBIGEO U ON M.ID_UBIGEO = U.ID_UBIGEO
					LEFT JOIN LOCAL L ON M.ID_LOCAL = L.ID_LOCAL
					LEFT JOIN SOLUCIONTECNOLOGICA st ON M.ID_SOLUCION = st.ID_SOLUCIONTECNOLOGICA
					INNER JOIN AGRUPACION_POLITICA AP ON AP.ID_AGRUPACION = M.ID_AGRUPACION
					INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA = M.ID_CONSULTA AND CP.ID_PROCESO = $this->intIdProceso
					INNER JOIN CEDULA_PROCESO PC ON PC.ID_CONSULTA = CP.ID_CONSULTA AND PC.ID_PROCESO = $this->intIdProceso AND PC.ID_MATERIAL=$this->intIdMaterial  
					WHERE M.ID_PROCESO=$this->intIdProceso AND M.ID_FASE=$this->intIdFase AND M.ID_SOLUCION=$this->intIdSolucion AND M.ID_ODPE=$this->intIdOdpe AND SUBSTR(U.UBIGEO,1,2) ='{$this->strDepartamento}' AND SUBSTR(U.UBIGEO,3,2)='{$this->strProvincia}' 
					AND  
					(CASE 	WHEN 1=1 AND SUBSTR(U.UBIGEO,5,2) = '{$this->strDistrito}' THEN 1
							WHEN 2=1 AND SUBSTR(U.UBIGEO,5,2) = '{$this->strDistrito}' AND AP.ID_AGRUPACION = '' THEN 1
							ELSE 0 END) = 1
					AND  (M.ID_SUFRAGIO,PC.SUF_ROTULO) NOT IN(	SELECT ID_SUFRAGIO, PAQUETE 
																FROM CONTROL_CALIDAD CC 
																WHERE CC.ID_PROCESO=$this->intIdProceso 
																AND CC.ID_MATERIAL=$this->intIdMaterial 
																AND CC.ID_ETAPA=$this->intIdEtapa 
																AND CC.ID_ODPE=$this->intIdOdpe 
																AND CC.VALIDACION=$this->intIdValidacion) 
					ORDER BY L.CODIGO_LOCAL, L.NOMBRE_LOCAL, PC.ORDEN, PC.TIPO_CEDULA, M.COD_TIPO, AP.CODIGO_AGRUPACION, M.NRO_MESA ASC	
					)
					WHERE ROWNUM = 1 ";

        $request = $this->select($query);
        return $request;

    }

    public function avanceAgrupacion(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idOdpe, int $validacion)
    {
        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->intIdFase = $idFase;
        $this->intIdOdpe = $idOdpe;
        $this->intIdValidacion = $validacion;


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
        $this->intIdProceso = $idprocesos;
        $this->intIdFase = $idFase;
        $this->intIdSolucion = $idSoltec;
        $this->intIdOdpe = $idOdpe;
        $this->intIdAgrupacion = $idAgrupacion;

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
        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->intIdFase = $idFase;
        $this->intIdSolucion = $idSoltec;
        $this->intIdOdpe = $idOdpe;
        $this->intIdAgrupacion = $idAgrupacion;
        $this->intIdValidacion = $validacion;

        $query = "	SELECT C.CONSULTA, S.NRO_MESA, S.NRO_ELECTORES , AP.AGRUPACION
					FROM MESA_SUFRAGIO S 
					INNER JOIN CONTROL_CALIDAD CC ON S.ID_SUFRAGIO = CC.ID_SUFRAGIO AND S.ID_PROCESO =$this->intIdProceso
					INNER JOIN SOLUCION_PROCESO SP ON CC.ID_SOLUCION = SP.ID_SOLUCION  
					INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA= S.ID_CONSULTA  
					INNER JOIN CONSULTA C ON C.ID_CONSULTA= CP.ID_CONSULTA AND CP.ID_PROCESO =$this->intIdProceso
					INNER JOIN CEDULA_PROCESO PC on CC.PAQUETE = PC.SUF_ROTULO and PC.ID_PROCESO =$this->intIdProceso AND PC.ID_MATERIAL=$this->intIdMaterial
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
        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->intIdFase = $idFase;
        $this->intIdSolucion = $idSoltec;
        $this->intIdOdpe = $idOdpe;
        $this->intIdAgrupacion = $idAgrupacion;
        $this->intIdValidacion = $validacion;

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


    public function mesasEscaneadas(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, string $consulta, int $validacion, int $idValor, int $idEleccion)
    {
        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->intIdFase = $idFase;
        $this->intIdSolucion = $idSoltec;
        $this->intIdOdpe = $idOdpe;
        $this->strConsulta = $consulta;
        $this->intIdValidacion = $validacion;
        $this->intIdValor = $idValor;
        $this->intIdEleccion = $idEleccion;

        $select = ($this->intIdEleccion == 2) ? " , AP.AGRUPACION " : " ";
        $from = ($this->intIdEleccion == 2) ? " INNER JOIN AGRUPACION_POLITICA AP ON S.ID_AGRUPACION = AP.ID_AGRUPACION " : "";

        $query = "	SELECT ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION, C.CONSULTA, PC.TIPO_CEDULA, U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.NOMBRE_LOCAL, S.NRO_MESA, S.NRO_ELECTORES " . $select . "
				    FROM MESA_SUFRAGIO S 
				    INNER JOIN CONTROL_CALIDAD CC ON S.ID_SUFRAGIO = CC.ID_SUFRAGIO AND S.ID_PROCESO =$this->intIdProceso
				    INNER JOIN SOLUCION_PROCESO SP ON CC.ID_SOLUCION = SP.ID_SOLUCION  
				    INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = SP.ID_SOLUCION AND SP.ID_PROCESO = $this->intIdProceso 
				    INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA= S.ID_CONSULTA  
				    INNER JOIN CONSULTA C ON C.ID_CONSULTA= CP.ID_CONSULTA AND CP.ID_PROCESO =$this->intIdProceso
				    INNER JOIN CEDULA_PROCESO PC on CC.PAQUETE = PC.SUF_ROTULO and PC.ID_PROCESO =$this->intIdProceso AND PC.ID_MATERIAL=$this->intIdMaterial
                    " . $from . "
					LEFT JOIN UBIGEO U ON S.ID_UBIGEO = U.ID_UBIGEO
                    LEFT JOIN LOCAL L ON S.ID_LOCAL = L.ID_LOCAL
					WHERE 	CC.ID_PROCESO = $this->intIdProceso 
							AND CC.ID_MATERIAL = $this->intIdMaterial 
							AND CC.ID_ETAPA = $this->intIdEtapa 
							AND CC.ID_SOLUCION = $this->intIdSolucion
							AND CC.validacion = $this->intIdValidacion 
							AND (	CASE 	WHEN 1 = 1 AND CC.ID_ODPE = $this->intIdOdpe THEN 1  
                                 			WHEN 2 = 1 AND CC.ID_ODPE = $this->intIdOdpe AND CC.PAQUETE = '{$this->strConsulta}' THEN 1  
                                  	ELSE 0 END) = 1  
					--GROUP BY ST.SOLUCIONTECNOLOGICA,C.CONSULTA,PC.TIPO_CEDULA,U.DEPARTAMENTO_UBI,U.PROVINCIA_UBI,U.DISTRITO_UBI,S.NRO_MESA, S.NRO_ELECTORES,L.CODIGO_LOCAL, PC.TIPO_CEDULA 
                    ORDER BY U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.CODIGO_LOCAL, S.NRO_MESA, PC.TIPO_CEDULA";

        $request = $this->select_all($query);
        return $request;
    }


    public function mesasFaltantes(int $idMaterial, int $idprocesos, int $idEtapa, int $idFase, int $idSoltec, int $idOdpe, string $consulta, int $validacion, int $idValor, int $idEleccion)
    {
        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->intIdFase = $idFase;
        $this->intIdSolucion = $idSoltec;
        $this->intIdOdpe = $idOdpe;
        $this->strConsulta = $consulta;
        $this->intIdValidacion = $validacion;
        $this->intIdValor = $idValor;
        $this->intIdEleccion = $idEleccion;

        $select = ($this->intIdEleccion == 2) ? " , AP.AGRUPACION " : " ";
        $from = ($this->intIdEleccion == 2) ? " INNER JOIN AGRUPACION_POLITICA AP ON S.ID_AGRUPACION = AP.ID_AGRUPACION " : "";

        $query = "	SELECT ST.SOLUCIONTECNOLOGICA AS CODIGO_SOLUCION,C.CONSULTA,U.DEPARTAMENTO_UBI,U.PROVINCIA_UBI,U.DISTRITO_UBI, L.NOMBRE_LOCAL,S.NRO_MESA,S.NRO_ELECTORES " . $select . "  
				    FROM MESA_SUFRAGIO S  
				    INNER JOIN SOLUCION_PROCESO SP ON S.ID_SOLUCION = SP.ID_SOLUCION  
				    INNER JOIN SOLUCIONTECNOLOGICA ST ON ST.ID_SOLUCIONTECNOLOGICA = SP.ID_SOLUCION AND SP.ID_PROCESO=$this->intIdProceso
				    INNER JOIN CONSULTA_PROCESO CP ON CP.ID_CONSULTA= S.ID_CONSULTA  
				    INNER JOIN CONSULTA C ON C.ID_CONSULTA= CP.ID_CONSULTA AND CP.ID_PROCESO=$this->intIdProceso
                    LEFT JOIN UBIGEO U ON S.ID_UBIGEO = U.ID_UBIGEO
                    LEFT JOIN LOCAL L ON S.ID_LOCAL = L.ID_LOCAL
					" . $from . "
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
				                                                AND (	CASE 	WHEN 1 = 1 AND CC.ID_ODPE = $this->intIdOdpe THEN 1  
				                                                             	WHEN 2 = 1 AND CC.ID_ODPE = $this->intIdOdpe AND CC.PAQUETE = '{$this->strConsulta}' THEN 1  
				                                                        ELSE 0 END) = 1)  
				    ORDER BY U.DEPARTAMENTO_UBI, U.PROVINCIA_UBI, U.DISTRITO_UBI, L.CODIGO_LOCAL, S.NRO_MESA";

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


    public function insertIncidencia(int $idMaterial, int $idprocesos, int $idEtapa, int $idOdpe, int $idIncidencia, string $nroMesa, int $cantidad, string $consulta, string $nroUbigeo, int $idUsuario, int $idSufragio)
    {

        $this->intIdMaterial = $idMaterial;
        $this->intIdProceso = $idprocesos;
        $this->intIdEtapa = $idEtapa;
        $this->intIdOdpe = $idOdpe;
        $this->intIdIncidencia = $idIncidencia;
        $this->strNroMesa = $nroMesa;
        $this->intCantidad = $cantidad;
        $this->strConsulta = $consulta;
        $this->strNroUbigeo = $nroUbigeo;
        $this->intIdUsusario = $idUsuario;
        $this->intIdSufragio = $idSufragio;


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

?>
