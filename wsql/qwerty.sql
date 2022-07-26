select * from odpe_soluciones;

select NOM_ODPE,COD_ST from sufragio_nacional_vertical
where COD_ST = 3
group by NOM_ODPE,COD_ST order by NOM_ODPE;


SELECT * FROM tipo_procesos;
SELECT * FROM procesos;
SELECT * FROM odpes;
# SELECT * FROM proceso_odpes;
# SELECT * FROM proceso_consultas;
SELECT * FROM sufragios;
SELECT * FROM consulta_sufragios;
SELECT * FROM ubigeos;
SELECT * FROM distritos;
SELECT * FROM provincias;
SELECT * FROM departamentos;
SELECT * FROM odpes;
SELECT * FROM soluciones;
SELECT * FROM odpe_soluciones;

select *
FROM ubigeo_consultas;
SELECT COD_UBI, COD_CONSULTA, COD_PROCESO
FROM sufragio_nacional_vertical
GROUP BY COD_UBI, COD_CONSULTA, COD_PROCESO;

/* Realizando la insercion de las tabla ubigeo_consulta */
INSERT INTO archelect.ubigeo_consultas (id_ubigeo, id_consulta, id_proceso, created_at, updated_at)
SELECT u.id, c.id, p.id, NOW(), NOW()
FROM (SELECT COD_UBI, COD_CONSULTA, COD_PROCESO
      FROM sufragio_nacional_vertical
      GROUP BY COD_UBI, COD_CONSULTA, COD_PROCESO) AS snv
         INNER JOIN ubigeos u ON snv.COD_UBI = u.codigo
         INNER JOIN consultas c ON snv.COD_CONSULTA = c.consulta
         INNER JOIN procesos p ON snv.COD_PROCESO = p.proceso


