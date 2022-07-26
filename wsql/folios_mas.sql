select * from mesas;
-- 80940
/* Sacando las mesas por solucionTecnologia - codigoConsulta */
SELECT N_MESA_MADRE, COD_ST, COD_CONSULTA
FROM sufragio_nacional_vertical
GROUP BY N_MESA_MADRE, COD_ST, COD_CONSULTA
ORDER BY N_MESA_MADRE;

-- Convencional - CON
SELECT N_MESA_MADRE, COD_ST, COD_CONSULTA
FROM sufragio_nacional_vertical
WHERE COD_ST = 1
GROUP BY N_MESA_MADRE, COD_ST, COD_CONSULTA
ORDER BY N_MESA_MADRE;
-- 72096

-- Solución Tecnológica de Apoyo al Escrutinio - STAE
SELECT N_MESA_MADRE, COD_ST, COD_CONSULTA
FROM sufragio_nacional_vertical
WHERE COD_ST = 2
GROUP BY N_MESA_MADRE, COD_ST, COD_CONSULTA
ORDER BY N_MESA_MADRE;
-- 2963

-- Voto Electronico Presencial - VEP
SELECT N_MESA_MADRE, COD_ST, COD_CONSULTA
FROM sufragio_nacional_vertical
WHERE COD_ST = 3
GROUP BY N_MESA_MADRE, COD_ST, COD_CONSULTA
ORDER BY N_MESA_MADRE;
-- 5881

/* Sacando mesas por solucionTecnologia - codigoConsulta Convencional - CON */
SELECT N_MESA_MADRE, c.consulta, c.descripcion, s.codigo, s.descripcion, COUNT(codigo) AS cant_act
FROM (SELECT N_MESA_MADRE, COD_ST, COD_CONSULTA
      FROM sufragio_nacional_vertical
      WHERE COD_ST = 1
      GROUP BY N_MESA_MADRE, COD_ST, COD_CONSULTA
      ORDER BY N_MESA_MADRE) snv
         INNER JOIN consultas c ON snv.COD_CONSULTA = c.consulta
         INNER JOIN sufragios s on c.estado = s.estado
GROUP BY N_MESA_MADRE, c.consulta, c.descripcion, s.codigo, s.descripcion;

SELECT N_MESA_MADRE, c.consulta, c.descripcion, s.id, s.descripcion -- ,COUNT(codigo) AS cant_act
FROM (SELECT N_MESA_MADRE, COD_ST, COD_CONSULTA
      FROM sufragio_nacional_vertical
      WHERE COD_ST = 1 AND N_MESA_MADRE = '000001'
      GROUP BY N_MESA_MADRE, COD_ST, COD_CONSULTA
      ORDER BY N_MESA_MADRE) snv
         INNER JOIN consultas c ON snv.COD_CONSULTA = c.consulta
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
         INNER JOIN sufragios s ON cs.id_sufragio = s.id
         INNER JOIN mesas m  ON snv.N_MESA_MADRE = m.nro_mesa
         INNER JOIN sobres sb ON sm.id_sobre = sb.id
         INNER JOIN solucion_documentos sd on sb.id = sd.id_sobre
         INNER JOIN documentos d on sd.id_documento = d.id;
#     INNER JOIN solucion_documentos sd ON INNER JOIN documentos d on sd.id_documento = d.id GROUP BY id_solucion, id_sobre;
# GROUP BY N_MESA_MADRE, c.consulta, c.descripcion;


/* Query de Consultas y Sufragios */
SELECT c.consulta, c.descripcion, s.codigo, s.descripcion
FROM consulta_sufragios cs
         INNER JOIN consultas c ON cs.id_consulta = c.id
         INNER JOIN sufragios s ON cs.id_sufragio = s.id;

/* Cantidad de documentos por solucion */
SELECT id_solucion, id_sobre, count(id_sobre) cant_doc_sol
FROM solucion_documentos sd
         INNER JOIN documentos d on sd.id_documento = d.id
GROUP BY id_solucion, id_sobre;

select *
FROM solucion_documentos;

SELECT *
FROM sufragios;
SELECT *
FROM consultas c
         INNER JOIN sufragios s on c.estado = s.estado;
select *
FROM consulta_sufragios;
SELECT *
FROM sufragios;

SELECT * FROM soluciones;
SELECT * FROM documentos;
SELECT * FROM solucion_documentos;

SELECT * FROM soluciones;
/** Sacando las  mesas con consultas y documentos **/
SELECT N_MESA_MADRE, c.consulta, c.descripcion, s.id, s.descripcion -- ,COUNT(codigo) AS cant_act
FROM (SELECT N_MESA_MADRE, COD_ST, COD_CONSULTA
      FROM sufragio_nacional_vertical
      WHERE COD_ST = 1 AND N_MESA_MADRE = '000001'
      GROUP BY N_MESA_MADRE, COD_ST, COD_CONSULTA
      ORDER BY N_MESA_MADRE) snv
         INNER JOIN consultas c ON snv.COD_CONSULTA = c.consulta
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
         INNER JOIN sufragios s ON cs.id_sufragio = s.id
         INNER JOIN mesas m  ON snv.N_MESA_MADRE = m.nro_mesa
         INNER JOIN solucion_documentos sd on sb.id = sd.id_sobre
         INNER JOIN documentos d on sd.id_documento = d.id;


/* Solo mesas convencional - consulta - sobres Actas */
SELECT m.nro_mesa, c.consulta, c.descripcion, s.solucion_tecnologica, s2.descripcion,
s3.descripcion, sd.id_sobre, s4.descripcion
FROM mesas m INNER JOIN consultas c ON m.id_consulta=c.id
            INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
            INNER JOIN sufragios s2 on cs.id_sufragio = s2.id
            INNER JOIN soluciones s on m.id_solucion = s.id
            INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
            INNER JOIN soluciones s3 on sd.id_solucion=s3.id
            INNER JOIN sobres s4 on sd.id_sobre = s4.id
WHERE m.nro_mesa= '000001' AND sd.id_solucion = 1 AND sd.id_sobre IN (1,2,3);

/** solo mesas convencional consulta - sobres Actas - documentos**/
SELECT m.nro_mesa, c.consulta, c.descripcion, s.solucion_tecnologica, s2.descripcion,
s3.descripcion, sd.id_sobre, s4.descripcion, d.id,d.documento,d.descripcion
FROM mesas m INNER JOIN consultas c ON m.id_consulta=c.id
            INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta -- Aqui se amarra los sufragios
            INNER JOIN sufragios s2 on cs.id_sufragio = s2.id
            INNER JOIN soluciones s on m.id_solucion = s.id
            INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
            INNER JOIN soluciones s3 on sd.id_solucion=s3.id
            INNER JOIN sobres s4 on sd.id_sobre = s4.id
            INNER JOIN documentos d on sd.id_documento = d.id
WHERE m.nro_mesa= '004141' AND sd.id_sobre IN (1,2,3);

/** Solo mesas por consulta - sobres Actas - documentos **/
SELECT m.nro_mesa, c.consulta, c.descripcion, s2.descripcion,
s3.descripcion, sd.id_sobre, s4.descripcion, d.id,d.documento,d.descripcion
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
         INNER JOIN sufragios s2 on cs.id_sufragio = s2.id-- Aqui se amarra los sufragios
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres s4 on sd.id_sobre = s4.id
         INNER JOIN documentos d on sd.id_documento = d.id -- Aqui se amarra los documentos
WHERE m.nro_mesa= '004141' AND sd.id_sobre IN (1,2,3)
ORDER BY s2.descripcion;

/** solo mesas por consulta - sobres Otros-Documentos - documentos **/
SELECT m.nro_mesa, c.consulta, c.descripcion,
s3.descripcion, sd.id_sobre, s4.descripcion, d.id,d.documento,d.descripcion
FROM mesas m
         INNER JOIN consultas c ON m.id_consulta=c.id
         INNER JOIN soluciones s on m.id_solucion = s.id
         INNER JOIN solucion_documentos sd on s.id = sd.id_solucion
         INNER JOIN soluciones s3 on sd.id_solucion=s3.id
         INNER JOIN sobres s4 on sd.id_sobre = s4.id
         INNER JOIN documentos d on sd.id_documento = d.id
WHERE m.nro_mesa= '004141' AND sd.id_sobre NOT IN (1,2,3);

-- Encontrar un convencional - Mesa
SELECT * FROM mesas WHERE id_solucion = 1;
SELECT * FROM mesas WHERE nro_mesa = '000002'; -- 284 -

SELECT nro_mesa, nro_electores,
       CASE
           WHEN
               MOD(nro_electores,40) = 0
           THEN nro_electores DIV 40
           WHEN MOD(nro_electores,40) <> 0
           THEN floor(nro_electores DIV 40) +1
       END AS folios
FROM mesas
WHERE nro_mesa = '000002';

