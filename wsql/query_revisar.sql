SELECT id, solucion_tecnologica, CANT_MESAS, TOTALDOC,  (SELECT count(*) FROM recepcion_documentos rd WHERE ) AS cantSolucin
FROM (
         SELECT id, solucion_tecnologica, COUNT(T.nro_mesa) AS CANT_MESAS, SUM(T.total_docxmesa) AS TOTALDOC
         FROM (
                  SELECT nro_mesa, id, solucion_tecnologica, SUM(cant_doc) AS total_docxmesa
                  FROM (
                           SELECT m.nro_mesa, s3.id, s3.solucion_tecnologica, COUNT(s3.solucion_tecnologica) AS cant_doc
                           FROM mesas m
                                    INNER JOIN consultas c ON m.id_consulta = c.id
                                    INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
                                    INNER JOIN soluciones s on m.id_solucion = s.id
                                    INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
                                    INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                                    INNER JOIN sobres sb on sd.id_sobre = sb.id
                                    INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
                           WHERE sd.id_sobre IN (1, 2, 3)
                           GROUP BY m.nro_mesa, S3.id, s3.solucion_tecnologica
                           UNION ALL
                           SELECT m.nro_mesa, s3.id, s3.solucion_tecnologica, COUNT(s3.solucion_tecnologica) AS cant_doc
                           FROM mesas m
                                    INNER JOIN soluciones s on m.id_solucion = s.id
                                    INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
                                    INNER JOIN soluciones s3 on sd.id_solucion = s3.id
                                    INNER JOIN sobres sb on sd.id_sobre = sb.id
                                    INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
                           WHERE sd.id_sobre NOT IN (1, 2, 3)
                           GROUP BY m.nro_mesa, s3.id, s3.solucion_tecnologica
                       ) AS dm
                  GROUP BY id, solucion_tecnologica, nro_mesa
              ) AS T
         GROUP BY id,solucion_tecnologica
     ) AS ut;



SELECT *
FROM recepcion_documentos;
