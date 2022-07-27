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
select * from odpe_soluciones;

INSERT INTO archelect.odpe_soluciones (id_odpe, id_solucion, created_at, updated_at)
SELECT O.id, snv.COD_ST, now(), now()
FROM (SELECT NOM_ODPE, COD_ST FROM sufragio_nacional_vertical GROUP BY NOM_ODPE, COD_ST ORDER BY NOM_ODPE) snv
INNER JOIN odpes o ON snv.NOM_ODPE = o.nombre_odpe;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE odpe_soluciones;
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

















