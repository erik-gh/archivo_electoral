SELECT * FROM consulta_sufragios;
SELECT * FROM odpes;

SELECT * FROM ubigeos;
SELECT * FROM locales;
SELECT COD_UBI, COD_LOC, NOM_LOC, DIR_LOC FROM sufragio_nacional_vertical GROUP BY COD_UBI, COD_LOC, NOM_LOC, DIR_LOC;

SELECT * FROM sufragio_nacional_vertical ORDER BY COD_UBI;
SELECT COD_UBI, COD_LOC, NOM_LOC, DIR_LOC FROM sufragio_nacional_vertical GROUP BY COD_UBI, COD_LOC, NOM_LOC, DIR_LOC ORDER BY COD_UBI

/* Poblando Locales */
# INSERT INTO archelect.locales (cod_local, nombre_local, direccion_local, estado, id_ubigeo, created_at, updated_at)
# SELECT snv.COD_LOC, snv.NOM_LOC, snv.DIR_LOC, 1, u.id, now(), now()
# FROM (SELECT COD_UBI, COD_LOC, NOM_LOC, DIR_LOC
# FROM sufragio_nacional_vertical GROUP BY COD_UBI, COD_LOC, NOM_LOC, DIR_LOC ORDER BY COD_LOC) AS snv
# INNER JOIN ubigeos u ON snv.COD_UBI = u.codigo;

/* Poblando Odpe_soluciones */
/*Se esta cambiando los COD_ST = 6 a 3 */
UPDATE sufragio_nacional_vertical SET COD_ST = 3 WHERE COD_ST = 6;
SELECT * FROM sufragio_nacional_vertical WHERE COD_ST = 3;
SELECT *
FROM ubigeos u INNER JOIN distritos d ON u.id_distrito = d.id
WHERE d.descripcion LIKE 'VILLA MARIA DEL TRIUNFO%';
SELECT *
FROM ubigeos u
    INNER JOIN departamentos d ON u.id_departamento = d.id
    INNER JOIN provincias p ON u.id_provincia = p.id
    INNER JOIN distritos dt ON u.id_distrito = dt.id
WHERE u.codigo = '140132';
/** Poblando los ubigeos_soluciones **/
INSERT INTO archelect.ubigeo_soluciones (id_ubigeo, id_solucion, created_at, updated_at)
SELECT u.id, snv.COD_ST, now(), now()
FROM (SELECT COD_UBI, COD_ST FROM sufragio_nacional_vertical GROUP BY COD_UBI, COD_ST ORDER BY COD_UBI) snv
INNER JOIN ubigeos u ON snv.COD_UBI = u.codigo;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE ubigeo_soluciones;
SET FOREIGN_KEY_CHECKS = 1;
/* lA CNATIDAD DE mESAS SON 80940 */
SELECT * FROM sufragio_nacional_vertical;

SELECT COD_LOC, COD_ST, N_MESA_MADRE
FROM sufragio_nacional_vertical GROUP BY COD_LOC, COD_ST, N_MESA_MADRE;
/* Poblando Las mesas*/
SET @row_number = 0;
INSERT INTO archelect.mesas (nro_mesa, codigo, nro_electores, orden, id_local, id_solucion, created_at, updated_at)
SELECT snv.N_MESA_MADRE, '01K', snv.TOTELECMMADRE, (@row_number:=@row_number + 1) AS row_num  ,l.id, COD_ST, now(), now()
FROM (SELECT COD_LOC, COD_ST, N_MESA_MADRE, TOTELECMMADRE
FROM sufragio_nacional_vertical GROUP BY COD_LOC, COD_ST, N_MESA_MADRE, TOTELECMMADRE ORDER BY N_MESA_MADRE) AS snv
INNER JOIN locales l ON snv.COD_LOC = l.cod_local;

SELECT * FROM mesas;
/* Otros Temas */
SELECT DISTINCT s.id, s.solucion_tecnologica
FROM ubigeos u -- id_odpe
INNER JOIN ubigeo_soluciones us on u.id = us.id_ubigeo
INNER JOIN soluciones s on us.id_solucion = s.id
WHERE u.id_odpe = 1
ORDER BY s.solucion_tecnologica;

SELECT DISTINCT d.id, d.descripcion
FROM ubigeo_soluciones us
     INNER JOIN ubigeos u ON us.id_ubigeo = u.id
     INNER JOIN departamentos d ON u.id_departamento = d.id
# WHERE u.id_odpe = $this->intIdOdpe;
WHERE u.id_odpe = 12;

select * from users;
select * from odpes WHERE id= 21; -- 21
select * from departamentos; -- 13
select * from provincias; -- 67
select * from users;

SELECT DISTINCT d.id, d.descripcion
FROM ubigeos u
INNER JOIN ubigeo_soluciones us on u.id = us.id_ubigeo
INNER JOIN distritos d on u.id_distrito = d.id
WHERE u.id_odpe = 21 AND u.id_departamento = 13 AND u.id_provincia = 67 AND us.id_solucion = 2;

/**/
SELECT * FROM recepcion_documentos;
SELECT * FROM recepcion_detalles;

TRUNCATE TABLE recepcion_detalles;
TRUNCATE TABLE recepcion_documentos;










