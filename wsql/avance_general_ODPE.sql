/* ******* QUERYS DE AVANCE POR ODPE  Y SOLUCION TECNOLOGICA ******** */

/** QUERY DE CONVENCIONAL */
SELECT nro_mesa, consulta, solucion_tecnologica,id_sobre, sobres, id_documento, documentos
FROM (
SELECT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
WHERE s.id = 1 AND sd.id_sobre IN (1,2,3) --
    UNION  ALL
SELECT DISTINCT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE s.id = 1 AND sd.id_sobre NOT IN (1,2,3)
# GROUP BY id_documento,documentos, m.nro_mesa, c.consulta,s2.codigo, id_sobre,sobres, s3.solucion_tecnologica
) AS documento_mesas;
-- cantidad de la solucion Convencional
SELECT COUNT(*)
FROM (
SELECT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
WHERE s.id = 1 AND sd.id_sobre IN (1,2,3) --
    UNION  ALL
SELECT DISTINCT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE s.id = 1 AND sd.id_sobre NOT IN (1,2,3)
) AS documento_mesas;

/** QUERY DE STAE */
-- Cantidad de solucion STAE
SELECT COUNT(*)
FROM (
SELECT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
WHERE s.id = 2 AND sd.id_sobre IN (1,2,3) --
    UNION  ALL
SELECT DISTINCT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE s.id = 2 AND sd.id_sobre NOT IN (1,2,3)
) AS documento_mesas;

/** QUERY DE VEP */

SELECT COUNT(*)
FROM (
SELECT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
WHERE s.id = 3 AND sd.id_sobre IN (1,2,3) --
    UNION  ALL
SELECT DISTINCT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE s.id = 3 AND sd.id_sobre NOT IN (1,2,3)
) AS documento_mesas;