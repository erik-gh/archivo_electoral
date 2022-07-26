/* Inserccion de consultas */
# INSERT INTO archelect.odpe_consultas (id_odpe, id_consulta, id_proceso, created_at, updated_at)
SELECT o.id, c.id, p.id, now(), now()
FROM (SELECT NOM_ODPE, COD_CONSULTA, COD_PROCESO
      FROM sufragio_nacional_vertical
      GROUP BY NOM_ODPE, COD_CONSULTA, COD_PROCESO
      ORDER BY NOM_ODPE) as snv
         INNER JOIN procesos p ON snv.COD_PROCESO = p.proceso
         INNER JOIN consultas c on snv.COD_CONSULTA = c.consulta
         INNER JOIN odpes o ON snv.NOM_ODPE = o.nombre_odpe


select * FROM sufragio_nacional_vertical
WHERE NOM_ODPE= 'ABANCAY' AND DEPAR_UBI= 'APURIMAC' AND PROV_UBI = 'ABANCAY';

SELECT COD_CONSULTA, count(COD_CONSULTA) FROM sufragio_nacional_vertical group by COD_CONSULTA;
/*
P
PD
RP
RPD
*/
SELECT o.nombre_odpe, count(o.nombre_odpe) AS conteo FROM odpe_soluciones os INNER JOIN odpes o on os.id_odpe = o.id
WHERE os.id_solucion= 1 GROUP BY o.nombre_odpe ORDER BY nombre_odpe;

select NOM_ODPE from sufragio_nacional_vertical where COD_ST =1 group by NOM_ODPE;

-- -----------------
SELECT DISTINCT p.id, p.descripcion
FROM ubigeos u INNER JOIN provincias p on u.id_departamento = p.id
                    WHERE u.id_odpe = 6 AND u.id_departamento;

SELECT DISTINCT d.id, d.descripcion
FROM ubigeos u INNER JOIN distritos d on u.id_departamento = d.id
WHERE u.id_odpe = 1 AND u.id_provincia;



