/* Sacando convencional */
SELECT solucion_tecnologica,
       CANT_MESAS,
       TOTAL,
       RECIBIDOS,
       (TOTAL - RECIBIDOS)                                                           AS FALTANTES,
       IFNULL(ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4), 0)                   AS PORC_RECIBIDOS,
       IFNULL(ROUND((100 - ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4)), 4), 0) AS PORC_FALTANTES
FROM (
         SELECT solucion_tecnologica,
                COUNT(T.nro_mesa)            AS CANT_MESAS,
                SUM(T.total_docxmesa)        AS TOTAL,
                (SELECT COUNT(*) AS cantDocActas
                 FROM recepcion_documentos rdoc
                 WHERE rdoc.id_solucion = 1) AS RECIBIDOS
         FROM (
                  SELECT nro_mesa, solucion_tecnologica, SUM(cant_doc) AS total_docxmesa -- Aca tengo todos los totales
                  FROM (
                           SELECT m.nro_mesa, s3.solucion_tecnologica, COUNT(s3.solucion_tecnologica) AS cant_doc
                           FROM ubigeo_consultas uc -- id_proceso
                                    INNER JOIN ubigeos u ON uc.id_ubigeo = u.id -- id_odpe
                                    INNER JOIN locales l ON u.id= l.id_ubigeo
                                    INNER JOIN mesas m ON l.id = m.id_local -- esta mesa
                                    INNER JOIN consultas c ON m.id_consulta = c.id
                                    INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
                                    INNER JOIN soluciones s on m.id_solucion = s.id
                                    INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
                                    INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                                    INNER JOIN sobres sb on sd.id_sobre = sb.id
                                    INNER JOIN documentos d on sd.id_documento = d.id
                           WHERE sd.id_sobre IN (1, 2, 3) AND s3.id = 1 AND uc.id_proceso = 1 AND u.id_odpe = 1
                           GROUP BY m.nro_mesa, S3.id, s3.solucion_tecnologica
                           UNION ALL
                           SELECT m.nro_mesa, s3.solucion_tecnologica, COUNT(s3.solucion_tecnologica) AS cant_doc
                           FROM ubigeo_consultas uc -- id_proceso
                                    INNER JOIN ubigeos u ON uc.id_ubigeo= u.id -- id_odpe
                                    INNER JOIN locales l ON u.id= l.id_ubigeo
                                    INNER JOIN mesas m ON l.id = m.id_local -- esta mesa
                                    INNER JOIN soluciones s on m.id_solucion = s.id
                                    INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
                                    INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                                    INNER JOIN sobres sb on sd.id_sobre = sb.id
                                    INNER JOIN documentos d on sd.id_documento = d.id
                           WHERE sd.id_sobre NOT IN (1, 2, 3)  AND s3.id = 1 AND uc.id_proceso = 1 AND u.id_odpe = 1
                           GROUP BY m.nro_mesa, s3.solucion_tecnologica
                        ORDER BY nro_mesa
                       ) AS documento_mesas
                  GROUP BY nro_mesa, solucion_tecnologica) AS t
         GROUP BY solucion_tecnologica
) AS con
UNION ALL
SELECT solucion_tecnologica,
       CANT_MESAS,
       TOTAL,
       RECIBIDOS,
       (TOTAL - RECIBIDOS)                                                           AS FALTANTES,
       IFNULL(ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4), 0)                   AS PORC_RECIBIDOS,
       IFNULL(ROUND((100 - ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4)), 4), 0) AS PORC_FALTANTES
FROM (
         SELECT solucion_tecnologica,
                COUNT(T.nro_mesa)            AS CANT_MESAS,
                SUM(T.total_docxmesa)        AS TOTAL,
                (SELECT COUNT(*) AS cantDocActas
                 FROM recepcion_documentos rdoc
                 WHERE rdoc.id_solucion = 1) AS RECIBIDOS
         FROM (
                  SELECT nro_mesa, solucion_tecnologica, SUM(cant_doc) AS total_docxmesa -- Aca tengo todos los totales
                  FROM (
                           SELECT m.nro_mesa, s3.solucion_tecnologica, COUNT(s3.solucion_tecnologica) AS cant_doc
                           FROM ubigeo_consultas uc -- id_proceso
                                    INNER JOIN ubigeos u ON uc.id_ubigeo = u.id -- id_odpe
                                    INNER JOIN locales l ON u.id= l.id_ubigeo
                                    INNER JOIN mesas m ON l.id = m.id_local -- esta mesa
                                    INNER JOIN consultas c ON m.id_consulta = c.id
                                    INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
                                    INNER JOIN soluciones s on m.id_solucion = s.id
                                    INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
                                    INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                                    INNER JOIN sobres sb on sd.id_sobre = sb.id
                                    INNER JOIN documentos d on sd.id_documento = d.id
                           WHERE sd.id_sobre IN (1, 2, 3) AND s3.id = 2 AND uc.id_proceso = 1 AND u.id_odpe = 1
                           GROUP BY m.nro_mesa, S3.id, s3.solucion_tecnologica
                           UNION ALL
                           SELECT m.nro_mesa, s3.solucion_tecnologica, COUNT(s3.solucion_tecnologica) AS cant_doc
                           FROM ubigeo_consultas uc -- id_proceso
                                    INNER JOIN ubigeos u ON uc.id_ubigeo= u.id -- id_odpe
                                    INNER JOIN locales l ON u.id= l.id_ubigeo
                                    INNER JOIN mesas m ON l.id = m.id_local -- esta mesa
                                    INNER JOIN soluciones s on m.id_solucion = s.id
                                    INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
                                    INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                                    INNER JOIN sobres sb on sd.id_sobre = sb.id
                                    INNER JOIN documentos d on sd.id_documento = d.id
                           WHERE sd.id_sobre NOT IN (1, 2, 3)  AND s3.id = 2 AND uc.id_proceso = 1 AND u.id_odpe = 1
                           GROUP BY m.nro_mesa, s3.solucion_tecnologica
                        ORDER BY nro_mesa
                       ) AS documento_mesas
                  GROUP BY nro_mesa, solucion_tecnologica) AS t
         GROUP BY solucion_tecnologica
) AS con
UNION ALL
SELECT solucion_tecnologica,
       CANT_MESAS,
       TOTAL,
       RECIBIDOS,
       (TOTAL - RECIBIDOS)                                                           AS FALTANTES,
       IFNULL(ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4), 0)                   AS PORC_RECIBIDOS,
       IFNULL(ROUND((100 - ROUND(((RECIBIDOS / NULLIF(TOTAL, 0)) * 100), 4)), 4), 0) AS PORC_FALTANTES
FROM (
         SELECT solucion_tecnologica,
                COUNT(T.nro_mesa)            AS CANT_MESAS,
                SUM(T.total_docxmesa)        AS TOTAL,
                (SELECT COUNT(*) AS cantDocActas
                 FROM recepcion_documentos rdoc
                 WHERE rdoc.id_solucion = 1) AS RECIBIDOS
         FROM (
                  SELECT nro_mesa, solucion_tecnologica, SUM(cant_doc) AS total_docxmesa -- Aca tengo todos los totales
                  FROM (
                           SELECT m.nro_mesa, s3.solucion_tecnologica, COUNT(s3.solucion_tecnologica) AS cant_doc
                           FROM ubigeo_consultas uc -- id_proceso
                                    INNER JOIN ubigeos u ON uc.id_ubigeo = u.id -- id_odpe
                                    INNER JOIN locales l ON u.id= l.id_ubigeo
                                    INNER JOIN mesas m ON l.id = m.id_local -- esta mesa
                                    INNER JOIN consultas c ON m.id_consulta = c.id
                                    INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
                                    INNER JOIN soluciones s on m.id_solucion = s.id
                                    INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
                                    INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                                    INNER JOIN sobres sb on sd.id_sobre = sb.id
                                    INNER JOIN documentos d on sd.id_documento = d.id
                           WHERE sd.id_sobre IN (1, 2, 3) AND s3.id = 3 AND uc.id_proceso = 1 AND u.id_odpe = 1
                           GROUP BY m.nro_mesa, S3.id, s3.solucion_tecnologica
                           UNION ALL
                           SELECT m.nro_mesa, s3.solucion_tecnologica, COUNT(s3.solucion_tecnologica) AS cant_doc
                           FROM ubigeo_consultas uc -- id_proceso
                                    INNER JOIN ubigeos u ON uc.id_ubigeo= u.id -- id_odpe
                                    INNER JOIN locales l ON u.id= l.id_ubigeo
                                    INNER JOIN mesas m ON l.id = m.id_local -- esta mesa
                                    INNER JOIN soluciones s on m.id_solucion = s.id
                                    INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
                                    INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                                    INNER JOIN sobres sb on sd.id_sobre = sb.id
                                    INNER JOIN documentos d on sd.id_documento = d.id
                           WHERE sd.id_sobre NOT IN (1, 2, 3)  AND s3.id = 3 AND uc.id_proceso = 1 AND u.id_odpe = 1
                           GROUP BY m.nro_mesa, s3.solucion_tecnologica
                        ORDER BY nro_mesa
                       ) AS documento_mesas
                  GROUP BY nro_mesa, solucion_tecnologica) AS t
         GROUP BY solucion_tecnologica
) AS con;


SELECT count(*) FROM sufragio_nacional_vertical WHERE COD_ST = 1; -- 72096
SELECT count(*) FROM sufragio_nacional_vertical WHERE COD_ST = 2; -- 2963
SELECT count(*) FROM sufragio_nacional_vertical WHERE COD_ST = 3; -- 5881

/* Otro Query del STAE*/
SELECT solucion_tecnologica, COUNT(T.nro_mesa) AS CANT_MESAS, SUM(T.total_docxmesa) AS TOTALDOC
FROM (
         SELECT nro_mesa, solucion_tecnologica, SUM(cant_doc) AS total_docxmesa
         FROM (
                  SELECT m.nro_mesa, s3.solucion_tecnologica, COUNT(s3.solucion_tecnologica) AS cant_doc
                  FROM mesas m
                           INNER JOIN consultas c ON m.id_consulta = c.id
                           INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
                           INNER JOIN soluciones s on m.id_solucion = s.id
                           INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
                           INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                           INNER JOIN sobres sb on sd.id_sobre = sb.id
                           INNER JOIN documentos d on sd.id_documento = d.id
                  WHERE sd.id_sobre IN (1, 2, 3)
                    AND s3.id = 2
                  GROUP BY m.nro_mesa, S3.id, s3.solucion_tecnologica
                  UNION ALL
                  SELECT m.nro_mesa, s3.solucion_tecnologica, COUNT(s3.solucion_tecnologica) AS cant_doc
                  FROM mesas m
                           INNER JOIN soluciones s on m.id_solucion = s.id
                           INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
                           INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                           INNER JOIN sobres sb on sd.id_sobre = sb.id
                           INNER JOIN documentos d on sd.id_documento = d.id
                  WHERE sd.id_sobre NOT IN (1, 2, 3)
                    AND s3.id = 2
                  GROUP BY m.nro_mesa, s3.solucion_tecnologica
              ) AS documento_mesas
         GROUP BY nro_mesa, solucion_tecnologica) AS T
GROUP BY solucion_tecnologica;
/* Sacando vep */