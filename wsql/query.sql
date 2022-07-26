-- Obtener ubigeo, departamento y provincia y distrito
select DISTINCT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI from sufragio_nacional_vertical order by COD_UBI;
-- Obtener ubigeo, departamento y provincia y distrito
select DISTINCT COD_UBI, count(*)AS cantidad_ubigeo from sufragio_nacional_vertical  group by COD_UBI order by COD_UBI;

-- Revisar los datos de la tabla
-- SOBRE LAS ODPES
select NOM_ODPE from sufragio_nacional_vertical GROUP BY NOM_ODPE order by NOM_ODPE;
SELECT count(*) AS CANT_ODPES FROM (SELECT NOM_ODPE FROM sufragio_nacional_vertical GROUP BY NOM_ODPE) AS ODPES;
-- SOBRE LOS UBIGEOS
select COD_UBI from sufragio_nacional_vertical GROUP BY COD_UBI order by COD_UBI;
select count(*) AS CANT_UBIGEOS FROM (SELECT COD_UBI FROM sufragio_nacional_vertical GROUP BY COD_UBI) AS UBIGEOS;
-- SOBRE LOS DEPARTAMENTOS
SELECT DEPAR_UBI from sufragio_nacional_vertical GROUP BY DEPAR_UBI order by DEPAR_UBI;
SELECT COUNT(*) AS CANT_DEPARTAMENTOS FROM (SELECT DEPAR_UBI FROM sufragio_nacional_vertical GROUP BY DEPAR_UBI) AS DEPARTAMENTOS;
-- SOBRE LOS PROVINCIAS
SELECT PROV_UBI from sufragio_nacional_vertical GROUP BY PROV_UBI order by PROV_UBI;
SELECT COUNT(*) AS CANT_PROVINCIAS FROM (SELECT PROV_UBI FROM sufragio_nacional_vertical GROUP BY PROV_UBI) AS PROVINCIAS;
-- SOBRE LOS DISTRITOS
SELECT DIST_UBI from sufragio_nacional_vertical GROUP BY DIST_UBI order by DIST_UBI;
SELECT COUNT(*) AS CANT_DISTRITOS FROM (SELECT DIST_UBI FROM sufragio_nacional_vertical GROUP BY DIST_UBI) AS DISTRITOS;
-- SOBRE LOS LOCALES
SELECT COD_LOC, NOM_LOC, DIR_LOC FROM sufragio_nacional_vertical GROUP BY COD_LOC, NOM_LOC, DIR_LOC ORDER BY COD_LOC;
SELECT COUNT(*) AS CANT_LOCALES FROM (SELECT NOM_LOC FROM sufragio_nacional_vertical GROUP BY NOM_LOC) AS LOCALES;
-- SOBRE LAS MESAS
SELECT N_MESA_MADRE,TOTELECMMADRE FROM sufragio_nacional_vertical GROUP BY N_MESA_MADRE, TOTELECMMADRE ORDER BY N_MESA_MADRE;
-- SELECT N_MESA_MADRE FROM sufragio_nacional_vertical GROUP BY N_MESA_MADRE ORDER BY N_MESA_MADRE;
SELECT COUNT(*) AS CANT_MESAS FROM (SELECT N_MESA_MADRE FROM sufragio_nacional_vertical GROUP BY N_MESA_MADRE) AS MESAS;

-- SELECT COUNT(*) AS CANT_CONDICIONES FROM (SELECT CONDI FROM sufragio_nacional_vertical GROUP BY CONDI) AS CONDICIONES;
SELECT COUNT(*) AS CANT_CONDICIONES FROM (SELECT TOTELECMMADRE FROM sufragio_nacional_vertical GROUP BY TOTELECMMADRE) AS CONDICIONES;

-- SOBRE LAS CONSULTAS
SELECT COD_CONSULTA, COUNT(*) AS CANTIDAD FROM sufragio_nacional_vertical GROUP BY COD_CONSULTA;
-- SOBRE LAS SOLUCIONES TECNOLOGICAS
SELECT COD_ST, COUNT(*) AS CANTIDAD FROM sufragio_nacional_vertical GROUP BY COD_ST;-- AQUI DEBE DE SER  3 TIPOS 1=CON, 2=STAE, 3=VEP
--------------------------------------------------
select  COD_UBI from sufragio_nacional_vertical  group by COD_UBI order by COD_UBI;
-- Obtener ubigeo, departamento y provincia y distrito
select DISTINCT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI from sufragio_nacional_vertical order by COD_UBI;
-- Obtener ubigeo, departamento y provincia y distrito
select DISTINCT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI from sufragio_nacional_vertical order by COD_UBI;

-- Poblacion de data en las tablas moduladas
-- INSERT INTO archelect.tipo_procesos (tipo_proceso, descripcion, estado, eleccion, created_at, updated_at) VALUES ('ELECCIONES MUNICIPALES', 'ELECCIONES MUNICIPALES', 1, 1, NOW(), NOW());
# INSERT INTO archelect.procesos (proceso, descripcion, fecha_inicio, fecha_cierre, estado, user_create, user_update,id_tipo_proceso, created_at, updated_at)
# SELECT COD_PROCESO,'ELECCIONES MUNICPALES 2022', NOW(), NOW(), 1, 'USER0001', 'USER0001', 1, NOW(), NOW() FROM sufragio_nacional_vertical LIMIT 1;

# Poblando odpes
# INSERT INTO archelect.odpes (nombre_odpe, estado, created_at, updated_at)
# SELECT NOM_ODPE, 1, NOW(), NOW() FROM sufragio_nacional_vertical GROUP BY NOM_ODPE ORDER BY NOM_ODPE;
# Poblando departamentos
# INSERT INTO archelect.departamentos (codigo, descripcion, created_at, updated_at)
# SELECT SUBSTRING(COD_UBI, 1, 2) AS CODIGO, DEPAR_UBI, NOW(), NOW()
                                     # FROM (SELECT COD_UBI, DEPAR_UBI FROM sufragio_nacional_verticales GROUP BY COD_UBI, DEPAR_UBI ORDER BY DEPAR_UBI) AS UBIGEO GROUP BY CODIGO, DEPAR_UBI;
# Poblando provincias
# INSERT INTO archelect.provincias (codigo, descripcion, created_at, updated_at)
# SELECT SUBSTRING(COD_UBI, 3, 2) AS CODIGO, PROV_UBI, NOW(), NOW()
                                     # FROM (SELECT COD_UBI, PROV_UBI FROM sufragio_nacional_verticales GROUP BY COD_UBI, PROV_UBI ORDER BY PROV_UBI) AS UBIGEO GROUP BY CODIGO, PROV_UBI;
# Poblando distritos
# INSERT INTO archelect.provincias (codigo, descripcion, created_at, updated_at)
# SELECT SUBSTRING(COD_UBI, 3, 2) AS CODIGO, DIST_UBI, NOW(), NOW()
                                     # FROM (SELECT COD_UBI, DIST_UBI FROM sufragio_nacional_verticales GROUP BY COD_UBI, DIST_UBI ORDER BY DIST_UBI) AS UBIGEO GROUP BY CODIGO, DIST_UBI;
# Poblando locales
# INSERT INTO archelect.locales (cod_local, nombre_local, direccion_local, estado, id_distrito, created_at, updated_at)

SELECT snv.COD_LOC, snv.NOM_LOC, snv.DIR_LOC, 1, 1, NOW(), NOW() FROM sufragio_nacional_vertical snv INNER JOIN distritos d ON  = d.codigo
GROUP BY DIST_UBI, COD_LOC, NOM_LOC, DIR_LOC ORDER BY COD_LOC;


SELECT SUBSTRING(COD_UBI, 3, 2) AS CODIGO, DIST_UBI, NOW(), NOW()
FROM (SELECT COD_UBI, DIST_UBI FROM sufragio_nacional_verticales GROUP BY COD_UBI, DIST_UBI ORDER BY DIST_UBI) AS UBIGEO GROUP BY CODIGO, DIST_UBI;

-- todavia
SELECT snv.DIST_UBI, snv.COD_LOC, snv.NOM_LOC, snv.DIR_LOC FROM sufragio_nacional_vertical snv INNER JOIN distritos d ON  = d.codigo
GROUP BY DIST_UBI, COD_LOC, NOM_LOC, DIR_LOC ORDER BY COD_LOC;

select * from sufragio_nacional_vertical;



SELECT DEPAR_UBI from sufragio_nacional_vertical GROUP BY DEPAR_UBI order by DEPAR_UBI;
SELECT NOM_ODPE, 1, NOW(), NOW() FROM sufragio_nacional_vertical GROUP BY NOM_ODPE ORDER BY NOM_ODPE;


SELECT NOM_ODPE FROM sufragio_nacional_vertical GROUP BY NOM_ODPE ORDER BY NOM_ODPE;









