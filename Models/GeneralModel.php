<?php

/**
 *
 */
class GeneralModel extends Mysql
{
    //CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR
    private $intIdProceso;
    private $intControl;
    private $intTipoProeso;
    private $strCodProceso;
    private $strNomProceso;
    private $strFechaInicio;
    private $strFechaFin;

    private $intIdConsulta;
    private $strConsulta;
    private $strDescripcion;

    private $intIdEtapa;

    private $intIdSolucion;
    private $strSolucion;

    private $intIdMaterial;

    private $intIdIncidencia;
    private $strIncidencia;

    private $intUserSession;
    private $intEstado;

    private $intIdDispositivo;


    public function __construct()
    {
        # code...
        parent::__construct();
    }


    /* =====  PROCESO ===== */
    public function insertProceso(int $tipoProeso, string $codProceso, string $nomProceso, string $fechaInicio, string $fechaFin, int $userSession)
    {

        $this->intTipoProeso = $tipoProeso;
        $this->strCodProceso = $codProceso;
        $this->strNomProceso = $nomProceso;
        $this->strFechaInicio = $fechaInicio;
        $this->strFechaFin = $fechaFin;
        $this->intUserSession = $userSession;

        $queryProceso = "SELECT id FROM procesos WHERE estado != 0 AND (proceso = '{$this->strCodProceso}' OR  descripcion ='{$this->strNomProceso}') ";
        $requestProceso = $this->select($queryProceso);

        if (empty($requestProceso)) {

            $query = "INSERT INTO procesos(id_tipo, proceso, descripcion, fecha_inicio, fecha_cierre, user_create, date_create, estado) VALUES(?,?,?, TO_DATE(?,'YYYY-MM-DD'),TO_DATE(?,'YYYY-MM-DD'), ?, LOCALTIMESTAMP, 1)";
            $arrData = array($this->intTipoProeso, $this->strCodProceso, $this->strNomProceso, $this->strFechaInicio, $this->strFechaFin, $this->intUserSession);
            $secuence = 'SEQ_PROCESO_ID';
            $requestInsert = $this->insert($query, $arrData, $secuence);

            return $requestInsert;

        } else {

            return 'exist';
        }
    }


    public function selectProcesos()
    {
        $query = "SELECT * FROM procesos WHERE estado != 0 ORDER BY fecha_inicio";
        $requestData = $this->select_all($query);
        return $requestData;
    }


    public function selectProceso(int $idProceso)
    {
        $this->intIdProceso = $idProceso;
        $query = "SELECT ID_PROCESO, PROCESO, DESCRIPCION, TO_CHAR(FECHA_INICIO, 'YYYY-MM-DD') AS FECHA_INICIO, TO_CHAR(FECHA_CIERRE, 'YYYY-MM-DD') AS FECHA_CIERRE, ESTADO, ID_TIPO FROM procesos WHERE id_proceso = $this->intIdProceso";
        $request = $this->select($query);
        return $request;
    }

    public function updateProceso(int $idProceso, int $tipoProeso, string $codProceso, string $nomProceso, string $fechaInicio, string $fechaFin, int $userSession, int $estado)
    {

        $this->intIdProceso = $idProceso;
        $this->intTipoProeso = $tipoProeso;
        $this->strCodProceso = $codProceso;
        $this->strNomProceso = $nomProceso;
        $this->strFechaInicio = $fechaInicio;
        $this->strFechaFin = $fechaFin;
        $this->intUserSession = $userSession;
        $this->intEstado = $estado;


        $queryProceso = "SELECT * FROM procesos WHERE ((proceso = '{$this->strCodProceso}' AND id_proceso != $this->intIdProceso) OR (descripcion = '{$this->strNomProceso}' AND id_proceso != $this->intIdProceso)) AND estado != 0 ";
        $requestProceso = $this->select($queryProceso);

        if (empty($requestProceso)) {

            $query = "UPDATE procesos SET proceso = ?, descripcion = ?, fecha_inicio = TO_DATE(?,'YYYY-MM-DD'), fecha_cierre = TO_DATE(?,'YYYY-MM-DD'), user_update = ?, estado = ?, id_tipo = ?, date_update = LOCALTIMESTAMP WHERE id_proceso = $this->intIdProceso";
            $arrData = array($this->strCodProceso, $this->strNomProceso, $this->strFechaInicio, $this->strFechaFin, $this->intUserSession, $this->intEstado, $this->intTipoProeso);
            $request = $this->update($query, $arrData);

            return $request;

        } else {

            return 'exist';

        }
    }

    public function deleteProceso(int $idProceso)
    {
        $this->intIdProceso = $idProceso;

        $query = "UPDATE procesos SET estado = ? WHERE id_proceso = $this->intIdProceso ";
        $arrData = array(0);
        $request = $this->update($query, $arrData);

        return $request;
    }

    public function selectCboTipoProceso()
    {
        $query = "SELECT * FROM tipo_procesos WHERE estado = 1 ORDER BY tipo_proceso";
        $request = $this->select_all($query);
        return $request;
    }

    /* ===== CONSULTA ===== */
    public function insertConsulta(string $consukta, string $descripcion, int $userSession)
    {

        $this->strConsulta = $consukta;
        $this->strDescripcion = $descripcion;
        $this->intUserSession = $userSession;

        $queryConsulkta = "SELECT id_consulta FROM consultas WHERE estado != 0 AND consulta = '{$this->strConsulta}' ";
        $requestConsulta = $this->select($queryConsulkta);

        if (empty($requestConsulta)) {

            $query = "INSERT INTO consulta(consulta, descripcion, user_create, date_create, estado) VALUES(?,?,?, LOCALTIMESTAMP, 1)";
            $arrData = array($this->strConsulta, $this->strDescripcion, $this->intUserSession);
            $secuence = 'SEQ_CONSULTA_ID';
            $requestInsert = $this->insert($query, $arrData, $secuence);

            return $requestInsert;

        } else {

            return 'exist';
        }
    }


    public function selectConsultas()
    {

        $query = "SELECT * FROM consultas WHERE estado != 0 ORDER BY consulta";
        $requestData = $this->select_all($query);

        return $requestData;
    }


    public function selectConsulta(int $idConsulta)
    {
        $this->intIdConsulta = $idConsulta;
        $query = "SELECT * FROM consultas WHERE id = $this->intIdConsulta";
        $request = $this->select($query);
        return $request;
    }


    public function updateConsulta(int $idConsulta, string $consukta, string $descripcion, int $userSession, int $estado)
    {

        $this->intIdConsulta = $idConsulta;
        $this->strConsulta = $consukta;
        $this->strDescripcion = $descripcion;
        $this->intUserSession = $userSession;
        $this->intEstado = $estado;

        $queryConsulta = "SELECT * FROM consultas WHERE (consulta = '{$this->strConsulta}' AND id != $this->intIdConsulta)  AND estado != 0 ";
        $requestConsulta = $this->select($queryConsulta);

        if (empty($requestConsulta)) {

            $query = "UPDATE consultas SET consulta = ?, descripcion = ?, user_update = ?, estado = ?, date_update = LOCALTIMESTAMP WHERE id_consulta = $this->intIdConsulta";
            $arrData = array($this->strConsulta, $this->strDescripcion, $this->intUserSession, $this->intEstado);
            $request = $this->update($query, $arrData);

            return $request;

        } else {

            return 'exist';

        }
    }


    public function deleteConsulta(int $idConsulta)
    {
        $this->intIdConsulta = $idConsulta;

        $query = "UPDATE consultas SET estado = ? WHERE id_consulta = $this->intIdConsulta ";
        $arrData = array(0);
        $request = $this->update($query, $arrData);

        return $request;
    }


    /* ===== CONSULTA ===== */

    public function selectEtapas()
    {

        $query = "SELECT * FROM etapas WHERE estado != 0 ORDER BY orden";
        $requestData = $this->select_all($query);

        return $requestData;
    }


    public function selectEtapa(int $idEtapa)
    {
        $this->intIdEtapa = $idEtapa;
        $query = "SELECT * FROM etapas WHERE id_etapa = $this->intIdEtapa";
        $request = $this->select($query);
        return $request;
    }


    public function updateEtapa(int $idEtapa, string $descripcion, int $userSession, int $estado)
    {

        $this->intIdEtapa = $idEtapa;
        $this->strDescripcion = $descripcion;
        $this->intUserSession = $userSession;
        $this->intEstado = $estado;

        $queryEtapa = "SELECT * FROM etapas WHERE (descripcion = '{$this->strDescripcion}' AND id_etapa != $this->intIdEtapa)  AND estado != 0 ";
        $requestEtapa = $this->select($queryEtapa);

        if (empty($requestEtapa)) {

            $query = "UPDATE etapas SET descripcion = ?, user_update = ?, estado = ?, date_update = LOCALTIMESTAMP WHERE id_etapa = $this->intIdEtapa";
            $arrData = array($this->strDescripcion, $this->intUserSession, $this->intEstado);
            $request = $this->update($query, $arrData);

            return $request;
        } else {
            return 'exist';
        }
    }

    /* ===== SOLUCION ===== */
    public function insertSolucion(string $solucion, string $descripcion, int $userSession)
    {

        $this->strSolucion = $solucion;
        $this->strDescripcion = $descripcion;
        $this->intUserSession = $userSession;

        $querySolucion = "SELECT id FROM soluciones WHERE estado != 0 AND soluciontecnologica = '{$this->strSolucion}' ";
        $requestSolucion = $this->select($querySolucion);

        if (empty($requestSolucion)) {

            $query = "INSERT INTO soluciones(solucion_tecnologica, descripcion, user_create, created_at, estado) VALUES(?,?,?, LOCALTIMESTAMP(), 1)";
            $arrData = array($this->strSolucion, $this->strDescripcion, $this->intUserSession);
            $secuence = 'SEQ_SOLUCIONTECNOLOGICA_ID';
            $requestInsert = $this->insert($query, $arrData, $secuence);

            return $requestInsert;

        } else {

            return 'exist';
        }
    }

    public function selecSoluciones()
    {
        $query = "SELECT * FROM soluciones WHERE estado != 0 ORDER BY solucion_tecnologica";
        $requestData = $this->select_all($query);
        return $requestData;
    }


    public function selectSolucion(int $idSolucion)
    {
        $this->intIdSolucion = $idSolucion;
        $query = "SELECT * FROM soluciones WHERE id = $this->intIdSolucion";
        $request = $this->select($query);
        return $request;
    }


    public function updateSolucion(int $idSolucion, string $solucion, string $descripcion, int $userSession, int $estado)
    {
        $this->intIdSolucion = $idSolucion;
        $this->strSolucion = $solucion;
        $this->strDescripcion = $descripcion;
        $this->intUserSession = $userSession;
        $this->intEstado = $estado;

        $querySolucion = "SELECT * FROM soluciones WHERE (solucion_tecnologica = '{$this->strSolucion}' AND id != $this->intIdSolucion)  AND estado != 0";
        $requestSolucion = $this->select($querySolucion);

        if (empty($requestSolucion)) {

            $query = "UPDATE soluciones SET solucion_tecnologica = ?, descripcion = ?, user_update = ?, estado = ?, updated_at = LOCALTIMESTAMP() WHERE id = $this->intIdSolucion";
            $arrData = array($this->strSolucion, $this->strDescripcion, $this->intUserSession, $this->intEstado);
            $request = $this->update($query, $arrData);
            return $request;
        } else {
            return 'exist';
        }
    }

    public function deleteSolucion(int $idSolucion)
    {
        $this->intIdSolucion = $idSolucion;

        $query = "UPDATE soluciones SET estado = ? WHERE id = $this->intIdSolucion ";
        $arrData = array(0);
        $request = $this->update($query, $arrData);

        return $request;
    }

    /* ===== Sobre ===== */

    public function selecMateriales()
    {
        $query = "SELECT * FROM sobres WHERE estado != 0 ORDER BY id;";
        $requestData = $this->select_all($query);
        return $requestData;
    }


    public function selectMaterial(int $idMaterial)
    {
        $this->intIdMaterial = $idMaterial;
        $query = "SELECT * FROM material WHERE id_material = $this->intIdMaterial";
        $request = $this->select($query);
        return $request;
    }

    public function updateMaterial(int $idMaterial, string $descripcion, int $userSession, int $estado)
    {
        $this->intIdMaterial = $idMaterial;
        $this->strDescripcion = $descripcion;
        $this->intUserSession = $userSession;
        $this->intEstado = $estado;


        $queryMaterial = "SELECT * FROM material WHERE (descripcion = '{$this->strDescripcion}' AND id_material != $this->intIdMaterial)  AND estado != 0 ";
        $requestMaterial = $this->select($queryMaterial);

        if (empty($requestMaterial)) {

            $query = "UPDATE material SET descripcion = ?, user_update = ?, estado = ?, date_update = LOCALTIMESTAMP WHERE id_material = $this->intIdMaterial";
            $arrData = array($this->strDescripcion, $this->intUserSession, $this->intEstado);
            $request = $this->update($query, $arrData);

            return $request;

        } else {
            return 'exist';
        }
    }

    /* ===== INCIDENCIAS ===== */
    public function insertIncidencia(string $incidencia, string $descripcion, int $userSession)
    {

        $this->strIncidencia = $incidencia;
        $this->strDescripcion = $descripcion;
        $this->intUserSession = $userSession;

        $queryIncidencia = "SELECT id_incidencia FROM incidencia WHERE estado != 0 AND incidencia = '{$this->strIncidencia}' ";
        $requestIncidencia = $this->select($queryIncidencia);

        if (empty($requestIncidencia)) {

            $query = "INSERT INTO incidencia(incidencia, descripcion, user_create, date_create, estado) VALUES(?,?,?, LOCALTIMESTAMP, 1)";
            $arrData = array($this->strIncidencia, $this->strDescripcion, $this->intUserSession);
            $secuence = 'SEQ_INCIDENCIA_ID';
            $requestInsert = $this->insert($query, $arrData, $secuence);

            return $requestInsert;

        } else {

            return 'exist';
        }
    }

    public function selectDocumentos()
    {
        $query = "SELECT * FROM documentos WHERE estado = 1 ORDER BY id;";
        $requestData = $this->select_all($query);
        return $requestData;
    }

    public function selectSufragios()
    {
        $query = "SELECT * FROM sufragios WHERE estado = 1 ORDER BY id;";
        $requestData = $this->select_all($query);
        return $requestData;
    }


    public function selectIncidencia(int $idIncidencia)
    {
        $this->intIdIncidencia = $idIncidencia;
        $query = "SELECT * FROM incidencia WHERE id_incidencia = $this->intIdIncidencia";
        $request = $this->select($query);
        return $request;
    }

    public function updateIncidencia(int $idIncidencia, string $incidencia, string $descripcion, int $userSession, int $estado)
    {

        $this->intIdIncidencia = $idIncidencia;
        $this->strIncidencia = $incidencia;
        $this->strDescripcion = $descripcion;
        $this->intUserSession = $userSession;
        $this->intEstado = $estado;


        $queryIncidencia = "SELECT * FROM incidencia WHERE (incidencia = '{$this->strIncidencia}' AND id_incidencia != $this->intIdIncidencia)  AND estado != 0 ";
        $requestIncidencia = $this->select($queryIncidencia);

        if (empty($requestIncidencia)) {

            $query = "UPDATE incidencia SET incidencia = ?, descripcion = ?, user_update = ?, estado = ?, date_update = LOCALTIMESTAMP WHERE id_incidencia = $this->intIdIncidencia";
            $arrData = array($this->strIncidencia, $this->strDescripcion, $this->intUserSession, $this->intEstado);
            $request = $this->update($query, $arrData);

            return $request;

        } else {

            return 'exist';

        }
    }

    public function deleteIncidencia(int $idIncidencia)
    {
        $this->intIdIncidencia = $idIncidencia;

        $query = "UPDATE incidencia SET estado = ? WHERE id_incidencia = $this->intIdIncidencia ";
        $arrData = array(0);
        $request = $this->update($query, $arrData);

        return $request;
    }

    /* ====== ASIGNAR ===== */
    public function selectCboEtapa()
    {
        $query = "	SELECT ID_ETAPA, ETAPA 
					FROM  etapas 
					WHERE ID_ETAPA NOT IN (SELECT DISTINCT ID_ETAPA FROM INCIDENCIA_ETAPA) AND ESTADO = 1 ORDER BY ORDEN";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectCboIncidencias()
    {

        $query = "	SELECT * FROM incidencia WHERE estado = 1 ORDER BY incidencia";
        $request = $this->select_all($query);

        return $request;
    }

    public function selectDocumentosAsignados()
    {
        $query = "SELECT  sb.id AS id_sob, sb.descripcion AS sobres, GROUP_CONCAT(d.id ORDER BY d.id SEPARATOR ', ') id_doc, GROUP_CONCAT(d.descripcion ORDER BY d.descripcion SEPARATOR ', ') AS documentos
                    FROM solucion_documentos sd INNER JOIN soluciones s ON sd.id_solucion = s.id INNER JOIN sobres sb ON sd.id_sobre = sb.id INNER JOIN documentos d ON d.id = sd.id_documento
                    GROUP BY sb.id, sb.descripcion ORDER BY sb.id, sb.descripcion;";
        $request = $this->select_all($query);
        return $request;
    }

    public function selectSufragiosAsignados()
    {
        $query = "SELECT c.id, c.descripcion, GROUP_CONCAT(s.id ORDER BY s.id SEPARATOR ', ') id_suf, GROUP_CONCAT(s.descripcion ORDER BY s.id SEPARATOR ', ') AS sufragios
                    FROM consulta_sufragios cs INNER JOIN consultas c ON c.id = cs.id_consulta INNER JOIN sufragios s ON cs.id_sufragio = s.id
                    GROUP BY c.id, c.descripcion ORDER BY c.id, c.descripcion;";
        $request = $this->select_all($query);
        return $request;
    }

    public function insertAsignar(int $idEtapa, int $idIncidencia)
    {
        $this->intIdEtapa = $idEtapa;
        $this->intIdIncidencia = $idIncidencia;

        $query = "INSERT INTO incidencia_etapa(id_etapa, id_incidencia) VALUES(?,?)";
        $arrData = array($this->intIdEtapa, $this->intIdIncidencia);
        $secuence = 'SEQ_INCIDENCIAETAPA_ID';
        $requestInsert = $this->insert($query, $arrData, $secuence);

        return $requestInsert;
    }

    public function selectAsignar(int $idEtapa)
    {
        $this->intIdEtapa = $idEtapa;
        $query = "SELECT e.ID_ETAPA, e.ETAPA, LISTAGG(ie.ID_INCIDENCIA , ',') WITHIN GROUP (ORDER BY ie.ID_INCIDENCIA) INCIDENCIA
										FROM etapas e inner join INCIDENCIA_ETAPA ie on e.ID_ETAPA = ie.ID_ETAPA 
										WHERE ie.ID_ETAPA=$this->intIdEtapa
										GROUP BY e.ID_ETAPA, e.ETAPA";
        $request = $this->select($query);
        return $request;
    }

    public function deleteAsignar(int $idEtapa)
    {
        $this->intIdEtapa = $idEtapa;

        $query = "DELETE FROM incidencia_etapa WHERE id_etapa = $this->intIdEtapa ";
        $request = $this->delete($query);
        return $request;
    }

    /* ===== DISPOSITIVOS USB ===== */
    public function insertDispositivo(string $descripcion, int $userSession)
    {

        $this->strDescripcion = $descripcion;
        $this->intUserSession = $userSession;

        $queryDispositivo = "SELECT id_tipo FROM dispositivo_tipo WHERE estado != 0 AND descripcion = '{$this->strDescripcion}' ";
        $requestDispositivo = $this->select($queryDispositivo);

        if (empty($requestDispositivo)) {

            $query = "INSERT INTO dispositivo_tipo(descripcion, user_create, date_create, estado, id_material) VALUES(?,?, LOCALTIMESTAMP, 1,6)";
            $arrData = array($this->strDescripcion, $this->intUserSession);
            $secuence = 'SEQ_DISPOSITIVOTIPO_ID';
            $requestInsert = $this->insert($query, $arrData, $secuence);

            return $requestInsert;

        } else {

            return 'exist';
        }
    }

    public function selecSobres()
    {
        $query = "SELECT * FROM sobres WHERE estado = 1 ORDER BY id;";
        $requestData = $this->select_all($query);
        return $requestData;
    }

    public function selectDispositivo(int $idDispositivo)
    {
        $this->intIdDispositivo = $idDispositivo;
        $query = "SELECT * FROM dispositivo_tipo WHERE id_tipo = $this->intIdDispositivo";
        $request = $this->select($query);
        return $request;
    }

    public function updateDispositivo(int $idSolucion, string $descripcion, int $userSession, int $estado)
    {
        $this->intIdDispositivo = $idSolucion;
        $this->strDescripcion = $descripcion;
        $this->intUserSession = $userSession;
        $this->intEstado = $estado;


        $queryDispositivo = "SELECT * FROM dispositivo_tipo WHERE (descripcion = '{$this->strDescripcion}' AND id_tipo != $this->intIdDispositivo)  AND estado != 0 ";
        $requestDispositivo = $this->select($queryDispositivo);

        if (empty($requestDispositivo)) {

            $query = "UPDATE dispositivo_tipo SET descripcion = ?, user_update = ?, estado = ?, date_update = LOCALTIMESTAMP WHERE id_tipo = $this->intIdDispositivo";
            $arrData = array($this->strDescripcion, $this->intUserSession, $this->intEstado);
            $request = $this->update($query, $arrData);

            return $request;

        } else {

            return 'exist';

        }
    }


    public function deleteDispositivo(int $idDispositivo)
    {
        $this->intIdDispositivo = $idDispositivo;
        $query = "UPDATE dispositivo_tipo SET estado = ? WHERE id_tipo = $this->intIdDispositivo ";
        $arrData = array(0);
        $request = $this->update($query, $arrData);

        return $request;
    }

}

?>