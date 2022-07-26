DELIMITER $$
CREATE PROCEDURE sp_avance_general( IN intIdProceso int)
BEGIN
SELECT 'MESAS'                                                                       AS TIPO,
       TOTAL,
       RECIBIDOS,
       (TOTAL - RECIBIDOS)                                                           AS FALTANTES,
       IFNULL(ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4), 0)                   AS PORC_RECIBIDOS,
       IFNULL(ROUND((100 - ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4)), 4), 0) AS PORC_FALTANTES
FROM (
         SELECT COUNT(*) AS TOTAL, (SELECT COUNT(*) AS cantDoc FROM recepcion_documentos) AS RECIBIDOS
         FROM (
                  SELECT m.nro_mesa,
                         c.consulta,
                         sb.descripcion AS sobres,
                         s3.solucion_tecnologica,
                         d.descripcion  AS documentos
                  FROM mesas m
                           INNER JOIN consultas c ON m.id_consulta = c.id
                           INNER JOIN ubigeo_consultas uc ON m.id_consulta = uc.id -- id_proceso
                           INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
                           INNER JOIN sufragios s2 on cs.id_sufragio = s2.id
                           INNER JOIN soluciones s on m.id_solucion = s.id
                           INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
                           INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                           INNER JOIN sobres sb on sd.id_sobre = sb.id
                           INNER JOIN documentos d on sd.id_documento = d.id
                  WHERE sd.id_sobre IN (1, 2, 3) AND uc.id_proceso = intIdProceso
                  UNION ALL
                  SELECT DISTINCT m.nro_mesa,
                                  c.consulta,
                                  sb.descripcion AS sobres,
                                  s3.solucion_tecnologica,
                                  d.descripcion  AS documentos
                  FROM mesas m
                           INNER JOIN consultas c ON m.id_consulta = c.id
                           INNER JOIN ubigeo_consultas uc ON m.id_consulta = uc.id -- id_proceso
                           INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
                           INNER JOIN soluciones s on m.id_solucion = s.id
                           INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
                           INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                           INNER JOIN sobres sb on sd.id_sobre = sb.id
                           INNER JOIN documentos d on sd.id_documento = d.id
                  WHERE sd.id_sobre NOT IN (1, 2, 3) AND uc.id_proceso = intIdProceso
              ) AS DC
     ) AS MESAS
UNION ALL
SELECT 'ACTAS'                                                                       AS TIPO,
       TOTAL,
       RECIBIDOS,
       (TOTAL - RECIBIDOS)                                                           AS FALTANTES,
       IFNULL(ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4), 0)                   AS PORC_RECIBIDOS,
       IFNULL(ROUND((100 - ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4)), 4), 0) AS PORC_FALTANTES
FROM (
         SELECT COUNT(*)                                                             AS TOTAL,
                (SELECT COUNT(*) AS cantDocActas
                FROM recepcion_documentos rdoc
                WHERE rdoc.id_sobre IN (1, 2, 3) AND rdoc.id_proceso = intIdProceso) AS RECIBIDOS
         FROM mesas m
                  INNER JOIN consultas c ON m.id_consulta = c.id
                  INNER JOIN ubigeo_consultas uc ON m.id_consulta = uc.id -- id_proceso
                  INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
                  INNER JOIN sufragios s2 on cs.id_sufragio = s2.id-- Aqui se amarra los sufragios
                  INNER JOIN soluciones s on m.id_solucion = s.id
                  INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
                  INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                  INNER JOIN sobres sb on sd.id_sobre = sb.id
                  INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
         WHERE sd.id_sobre IN (1, 2, 3) AND uc.id_proceso = intIdProceso
     ) AS ACTAS
UNION ALL
SELECT 'HCAMM'                                                                       AS TIPO,
       TOTAL,
       RECIBIDOS,
       (TOTAL - RECIBIDOS)                                                           AS FALTANTES,
       IFNULL(ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4), 0)                   AS PORC_RECIBIDOS,
       IFNULL(ROUND((100 - ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4)), 4), 0) AS PORC_FALTANTES
FROM (
         SELECT COUNT(*)                                                                       AS TOTAL,
                (SELECT COUNT(*) AS cantDocActas FROM recepcion_documentos rdoc WHERE id_sobre = 5 AND rdoc.id_proceso = intIdProceso) AS RECIBIDOS
         FROM mesas m
                  INNER JOIN ubigeo_consultas uc ON m.id_consulta = uc.id -- id_proceso
                  INNER JOIN soluciones s on m.id_solucion = s.id
                  INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
                  INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                  INNER JOIN sobres sb on sd.id_sobre = sb.id
                  INNER JOIN documentos d on sd.id_documento = d.id
         WHERE sd.id_sobre = 5 AND uc.id_proceso = intIdProceso
     ) AS HCAMM
UNION ALL
SELECT 'PUESTA CERO'                                                                 AS TIPO,
       TOTAL,
       RECIBIDOS,
       (TOTAL - RECIBIDOS)                                                           AS FALTANTES,
       IFNULL(ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4), 0)                   AS PORC_RECIBIDOS,
       IFNULL(ROUND((100 - ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4)), 4), 0) AS PORC_FALTANTES
FROM (SELECT COUNT(*)                                                                       AS TOTAL,
             (SELECT COUNT(*) AS cantDocActas FROM recepcion_documentos rdoc WHERE id_sobre = 6 AND rdoc.id_proceso = intIdProceso) AS RECIBIDOS
      FROM mesas m
               INNER JOIN ubigeo_consultas uc ON m.id_consulta = uc.id -- id_proceso
               INNER JOIN soluciones s on m.id_solucion = s.id
               INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
               INNER JOIN soluciones s3 on sd.id_solucion = s3.id
               INNER JOIN sobres sb on sd.id_sobre = sb.id
               INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
      WHERE sd.id_sobre = 6 AND uc.id_proceso = intIdProceso
     ) AS PUESTA_CERO
UNION ALL
SELECT 'LISTA ELECTORES'                                                             AS TIPO,
       TOTAL,
       RECIBIDOS,
       (TOTAL - RECIBIDOS)                                                           AS FALTANTES,
       IFNULL(ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4), 0)                   AS PORC_RECIBIDOS,
       IFNULL(ROUND((100 - ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4)), 4), 0) AS PORC_FALTANTES
FROM (SELECT SUM(CASE
                     WHEN
                         MOD(nro_electores, 40) = 0
                         THEN nro_electores DIV 40
                     WHEN MOD(nro_electores, 40) <> 0
                         THEN FLOOR(nro_electores DIV 40) + 1
      END)                          AS TOTAL,
             (SELECT COUNT(*)
              FROM recepcion_documentos rdoc
                       INNER JOIN recepcion_detalles rd on rdoc.id = rd.id_recdoc
              WHERE rdoc.id_sobre = 4 AND rdoc.id_proceso = intIdProceso) AS RECIBIDOS
      FROM mesas m
               INNER JOIN ubigeo_consultas uc ON m.id_consulta = uc.id -- id_proceso
               INNER JOIN soluciones s on m.id_solucion = s.id
               INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
               INNER JOIN soluciones s3 on sd.id_solucion = s3.id
               INNER JOIN sobres sb on sd.id_sobre = sb.id
               INNER JOIN documentos d on sd.id_documento = d.id
      WHERE sd.id_sobre = 4 AND uc.id_proceso = intIdProceso ) AS FOLIOS;

END$$
DELIMITER ;
/* Truncar una tabla */
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE ubigeos;
SET FOREIGN_KEY_CHECKS=1;

/* Ejecutando el procedimiento */
CALL sp_avance_general(1);

/* Eliminado el procedimiento */
DROP PROCEDURE IF EXISTS sp_poblarUbigeo;

SELECT * FROM ubigeos;