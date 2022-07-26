select *
from mesas;
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
      WHERE COD_ST = 1
        AND N_MESA_MADRE = '000001'
      GROUP BY N_MESA_MADRE, COD_ST, COD_CONSULTA
      ORDER BY N_MESA_MADRE) snv
         INNER JOIN consultas c ON snv.COD_CONSULTA = c.consulta
         INNER JOIN consulta_sufragios cs on c.id = cs.id_consulta
         INNER JOIN sufragios s ON cs.id_sufragio = s.id
         INNER JOIN mesas m ON snv.N_MESA_MADRE = m.nro_mesa
         INNER JOIN sobre_mesas sm on m.id = sm.id_mesa
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
/* Realizacion de query para poder ver las consultas */
SELECT DISTINCT c.id, c.descripcion
FROM ubigeo_consultas uc
         INNER JOIN consultas c ON c.id = uc.id_consulta
         INNER JOIN ubigeos u ON uc.id_ubigeo = u.id
WHERE uc.id_proceso = 1
  AND u.id_odpe = 1
  AND u.id_departamento = 3
ORDER BY c.id;

SELECT o.id, o.nombre_odpe
FROM procesos p
         INNER JOIN ubigeo_consultas uc on p.id = uc.id_proceso
         INNER JOIN ubigeos u on uc.id_ubigeo = u.id
         INNER JOIN odpes o on u.id_odpe = o.id
WHERE p.id = 1
group by o.id, o.nombre_odpe
order by o.id, o.nombre_odpe;

SELECT s.id, s.solucion_tecnologica
FROM odpe_soluciones os
         INNER JOIN soluciones s on os.id_solucion = s.id
WHERE os.id_odpe = 10
ORDER BY solucion_tecnologica;



