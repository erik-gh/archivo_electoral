DELIMITER $$
CREATE PROCEDURE sp_avance_general_odpe( IN intIdProceso int, IN intIdOdpe int)
BEGIN
SELECT solucion_tecnologica,COUNT(T.nro_mesa) CANT_MESAS, SUM(T.total_docxmesa) AS TOTALDOC

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
                  GROUP BY m.nro_mesa, s3.solucion_tecnologica
              ) AS documento_mesas
         GROUP BY solucion_tecnologica, nro_mesa
     ) AS T
GROUP BY solucion_tecnologica;
END$$
DELIMITER ;
/* Truncar una tabla */

/*
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE ubigeos;
SET FOREIGN_KEY_CHECKS=1;
*/
/* Ejecutando el procedimiento */
CALL sp_avance_general_odpe( 1,1);

/* Eliminado el procedimiento */
DROP PROCEDURE IF EXISTS sp_avance_general_odpe;

SELECT * FROM ubigeos;