/* Query de Documentos por Consulta - Soluciones - Mesas*/
SELECT nro_mesa, consulta, solucion_tecnologica,id_sobre, sobres, id_documento, documentos
FROM (
SELECT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
         INNER JOIN sufragios s2 on cs.id_sufragio = s2.id-- Aqui se amarra los sufragios
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
WHERE m.nro_mesa= '000001' AND sd.id_sobre IN (1,2,3) -- son 12 documentos
    UNION  ALL
SELECT DISTINCT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
#          INNER JOIN sufragios s2 on cs.id_sufragio = s2.id-- Aqui se amarra los sufragios
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE m.nro_mesa= '000001' AND sd.id_sobre NOT IN (1,2,3)
# GROUP BY id_documento,documentos, m.nro_mesa, c.consulta,s2.codigo, id_sobre,sobres, s3.solucion_tecnologica
) AS documento_mesas;
# GROUP BY nro_mesa, consulta, solucion_tecnologica,id_sobre, sobres, id_documento, documentos
# ORDER BY id_documento, documentos;

/* Cantidad de Documentos por mesa */
SELECT COUNT(*) AS cant_docxmesa
FROM (SELECT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres, s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
         INNER JOIN sufragios s2 on cs.id_sufragio = s2.id-- Aqui se amarra los sufragios
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
WHERE m.nro_mesa= '000001' AND sd.id_sobre IN (1,2,3) -- son 12 documentos
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
WHERE m.nro_mesa= '000001' AND sd.id_sobre NOT IN (1,2,3)
) AS documento_mesas;
# GROUP BY nro_mesa, consulta, solucion_tecnologica,id_sobre, sobres, id_documento, documentos;

/* Cantidad de Documentos en General */
SELECT COUNT(*) AS cant_doc_general -- 636315 documentos
FROM (SELECT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres,
             s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
         INNER JOIN sufragios s2 on cs.id_sufragio = s2.id-- Aqui se amarra los sufragios
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
WHERE sd.id_sobre IN (1,2,3) --
    UNION  ALL
SELECT DISTINCT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres,
                s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE sd.id_sobre NOT IN (1,2,3)
) AS documentos;
# GROUP BY nro_mesa, consulta, solucion_tecnologica,id_sobre, sobres, id_documento, documentos;
/******  Calculos de documentos por *******/

/* Query de Actas instalacion - sufragio - Escrutinio */

SELECT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres,
             s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
         INNER JOIN sufragios s2 on cs.id_sufragio = s2.id-- Aqui se amarra los sufragios
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
WHERE sd.id_sobre IN (1,2,3);-- Es por que son actas
-- cantidad de Actas instalacion - sufragio - Escrutinio
SELECT count(*)
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on cs.id_consulta = c.id
         INNER JOIN sufragios s2 on cs.id_sufragio = s2.id-- Aqui se amarra los sufragios
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on sd.id_solucion = s.id
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
WHERE sd.id_sobre IN (1,2,3); -- 465591
/* Query de Otros documentos */
SELECT DISTINCT m.nro_mesa, c.consulta, sb.id AS id_sobre, sb.descripcion AS sobres,
                s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE sd.id_sobre NOT IN (1,2,3); -- 242820
-- Cantidad de Otros documentos HCAMM - PC - LE
SELECT count(*)
FROM mesas m
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE sd.id_sobre NOT IN (1,2,3); -- Aqui se podria  agrgear un campo y que haga por tipo documento Acta o Otros
# GROUP BY d.id; -- 242820
SELECT * FROM sobres;

/* Query de documentos HCAMM */
SELECT m.nro_mesa, sb.id AS id_sobre, sb.descripcion AS sobres,
                s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE sd.id_sobre = 5; --
-- cantidad de HCAMM
SELECT COUNT(*)
FROM mesas m
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE sd.id_sobre = 5; --

/* Query de documentos Puesta Cero */
SELECT m.nro_mesa, sb.id AS id_sobre, sb.descripcion AS sobres,
                s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos
FROM mesas m
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE sd.id_sobre = 6; --

SELECT * FROM solucion_documentos;
-- cantidad puesta cero
SELECT COUNT(*)
FROM mesas m
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE sd.id_sobre = 6; --

/* Query de documentos Lista Electores */
SELECT m.nro_mesa, sb.id AS id_sobre, sb.descripcion AS sobres,
                s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos, m.nro_electores
FROM mesas m
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE sd.id_sobre = 4; --
/* Calculando los folios*/
SELECT m.nro_mesa, sb.id AS id_sobre, sb.descripcion AS sobres,
                s3.solucion_tecnologica, d.id AS id_documento, d.descripcion AS documentos, m.nro_electores,
       CASE
           WHEN
               MOD(nro_electores,40) = 0
           THEN nro_electores DIV 40
           WHEN MOD(nro_electores,40) <> 0
           THEN floor(nro_electores DIV 40) +1
       END AS folios
FROM mesas m
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE sd.id_sobre = 4; --

-- Cantidad Folios a scanear
SELECT SUM(CASE
           WHEN
               MOD(nro_electores,40) = 0
           THEN nro_electores DIV 40
           WHEN MOD(nro_electores,40) <> 0
           THEN FLOOR(nro_electores DIV 40) +1
       END) AS suma_folios
FROM mesas m
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres sb on sd.id_sobre = sb.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los sufragios
WHERE sd.id_sobre = 4; --

SELECT nro_mesa, nro_electores,
       CASE
           WHEN
               MOD(nro_electores,40) = 0
           THEN nro_electores DIV 40
           WHEN MOD(nro_electores,40) <> 0
           THEN floor(nro_electores DIV 40) +1
       END AS folios
FROM mesas
WHERE nro_mesa = '000001';





SELECT * FROM documentos;