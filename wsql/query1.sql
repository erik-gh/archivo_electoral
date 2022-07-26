DELIMITER $$
CREATE PROCEDURE sp_poblarUbigeo()
BEGIN
    DECLARE done1dep, done2pro, done3dis INT DEFAULT FALSE;
    DECLARE var_dep INT;
    DECLARE var_pro INT;
    DECLARE var_dis INT;
    /* Declarando los cursor Ubigeo */
#     DECLARE curUbigeoSNV CURSOR FOR SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI
#     FROM sufragio_nacional_vertical GROUP BY COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI ORDER BY COD_UBI;
    # 010101, AMAZONAS, CHACHAPOYAS, CHACHAPOYAS
    DECLARE id_dep INT;
    DECLARE cod_dep VARCHAR(2);
    DECLARE des_dep VARCHAR(255);

    DECLARE curDepartamentos CURSOR FOR SELECT id, codigo, descripcion FROM departamentos;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done1dep = TRUE;
    SET var_dep = 0;
    SET var_pro = 0;
    SET var_dis = 0;

    OPEN curDepartamentos;
    loop1_departamentos:
    LOOP
        FETCH curDepartamentos INTO id_dep, cod_dep, des_dep;
        #   1, 01, AMAZONAS/
        IF done1dep THEN
            CLOSE curDepartamentos;
            LEAVE loop1_departamentos;
        END IF;
        SET var_dep = id_dep;
        /*Bloque de loop2*/
        BLOCK2PROVINCIA:
        BEGIN
            DECLARE cod_pro VARCHAR(2);
            DECLARE des_pro VARCHAR(255);
            DECLARE id_pro INT;
            DECLARE curProvincias CURSOR FOR SELECT id, codigo, descripcion FROM provincias;
            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done2pro = TRUE;

            OPEN curProvincias;
            loop2_provincias:
            LOOP
                FETCH curProvincias INTO id_pro, cod_pro,des_pro;
                #   1,01, ABANCAY
                IF done2pro THEN
                    CLOSE curProvincias;
                    LEAVE loop2_provincias;
                END IF;
                SET var_pro = id_pro;
                /*Bloque de loop3*/
                BLOCK3DISTRITO:
                BEGIN
                    DECLARE cod_dis VARCHAR(2);
                    DECLARE des_dis VARCHAR(255);
                    DECLARE cod_ubigeo VARCHAR(6); -- COD_UBI
                    DECLARE id_dis INT;
                    DECLARE str_cod_ubi varchar(6);-- ver si funciona
#                     DECLARE id_pro_dist INT;-- ver si funciona
                    DECLARE curDistritos CURSOR FOR SELECT id, codigo, descripcion FROM distritos;
                    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done3dis = TRUE;

                    OPEN curDistritos;
                    loop3_distritos:
                    LOOP
                        FETCH curDistritos INTO id_dis, cod_dis, des_dis;
                        # 1, 01, ABANCAY
                        IF done3dis THEN
                            CLOSE curDistritos;
                            LEAVE loop3_distritos;
                        END IF;
                        SET cod_ubigeo := CONCAT(cod_dep, cod_pro, cod_dis);
                        SET var_dis = id_dis;
#                         SET id_dep_dist := id_dep;
#                         SET id_pro_dist := id_pro;
                        #                         SET cod_ubigeo := CONCAT(cod_dep, cod_pro, cod_dis);
#                         SET cod_ubigeo := CONCAT(cod_dep, cod_pro, cod_dis);
                        /*Bloque de sentecia e insert*/
#                         SELECT COD_UBI, DIST_UBI FROM sufragio_nacional_vertical
#                          WHERE COD_UBI = '010101' AND DIST_UBI = 'CHACHAPOYAS';
#                         GROUP BY COD_UBI, DIST_UBI;
                        SET str_cod_ubi := (SELECT COD_UBI FROM sufragio_nacional_vertical WHERE COD_UBI = cod_ubigeo GROUP BY COD_UBI);
                        IF cod_ubigeo = str_cod_ubi
                        THEN
                            INSERT INTO archelect.ubigeos(id, codigo, id_departamento, id_provincia, id_distrito, id_odpe, created_at, updated_at)
                            VALUES (NULL, cod_ubigeo, var_dep, var_pro, var_dis, 1, '2022-07-18 10:37:59', '2022-07-18 10:37:59');
                        END IF;

#                         LEAVE loop3_distritos;
                        #SELECT * FROM sufragio_nacional_vertical WHERE COD_UBI = cod_ubigeo
#                         INSERT INTO archelect.ubigeos(id, codigo, id_departamento, id_provincia, id_distrito, id_odpe,created_at, updated_at)
#                         VALUES (NULL, '010101', 1, 1, 1, 1, '2022-07-18 10:37:59', '2022-07-18 10:37:59');
#                         INSERT INTO archelect.ubigeos (codigo, id_departamento, id_provincia, id_distrito, id_odpe, created_at, updated_at)
#                         SELECT cod_ubigeo, id_dep, id_pro, id_dis, 1, now(), now() FROM sufragio_nacional_vertical WHERE COD_UBI = cod_ubigeo GROUP BY COD_UBI;
#                         INSERT INTO archelect.ubigeos VALUES (NULL, '010101', 1, 1, 1,1, '2022-07-18 10:37:59', '2022-07-18 10:37:59');
#                         SELECT NULL, COD_UBI, id_dep, id_pro, id_dis, 1, now(), now()
#                         FROM (SELECT COD_UBI FROM sufragio_nacional_vertical WHERE COD_UBI = cod_ubigeo
#                         GROUP BY COD_UBI ORDER BY COD_UBI) AS COD_UBI_SNV;
#                         SELECT NULL, COD_UBI, id_dep, id_pro, id_dis, 1, now(), now()
#                         FROM (SELECT COD_UBI FROM sufragio_nacional_vertical WHERE COD_UBI = cod_ubigeo
#                         GROUP BY COD_UBI ORDER BY COD_UBI) AS COD_UBI_SNV;
                    END LOOP;
#                     CLOSE curDistritos;
                END BLOCK3DISTRITO;
            END LOOP;
        END BLOCK2PROVINCIA;
    END LOOP;
    /* Mostrando los ubigeos insertados */
#     SELECT * FROM ubigeos;
    SELECT var_dep, var_pro, var_dis;
END$$
DELIMITER ;

/* Truncar una tabla */
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE ubigeos;
SET FOREIGN_KEY_CHECKS = 1;

/* Ejecutando el procedimiento */
CALL sp_poblarUbigeo();
/* Eliminado el procedimiento */
DROP PROCEDURE IF EXISTS sp_poblarUbigeo;

select * from ubigeos;

SELECT *
FROM ubigeos
         inner join distritos d on ubigeos.id_distrito = d.id;

select *
from sufragio_nacional_vertical
where COD_UBI = '010101';

SELECT * FROM (select COD_UBI, DIST_UBI from sufragio_nacional_vertical GROUP BY COD_UBI, DIST_UBI) AS snv INNER JOIN ubigeos u ON snv.COD_UBI = u.codigo
# INNER JOIN distritos d ON u.id_distrito = d.id
WHERE snv.DIST_UBI = d.descripcion;



UPDATE ubigeos u inner join distritos d2 on u.id_distrito = d2.id
#inner join provincias p on u.id_provincia = p.id inner join departamentos d on u.id_departamento = d.id
inner join sufragio_nacional_vertical snv on u.codigo = snv.COD_UBI
SET id_departamento = d.id,
    id_provincia = p.id,
    WHERE ;


select * from ubigeos u inner join departamentos d on u.id_departamento = d.id inner join distritos d2 on u.id_distrito = d2.id inner join provincias p on u.id_provincia = p.id
inner join sufragio_nacional_vertical snv on u.codigo = snv.COD_UBI;

/*SACANDO LOS DATOS DEL UBIGEOS*/
SELECT u.id, u.codigo FROM ubigeos u INNER JOIN distritos d ON u.id_distrito = d.id;

/*SACANDO LOS DATOS DEL UBIGEOS*/
SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI FROM sufragio_nacional_vertical snv group by COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI;

SELECT ud.id, ud.codigo, dp.id, pr.id,  FROM (SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI FROM sufragio_nacional_vertical snv group by COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI) AS snv
INNER JOIN (SELECT u.id, u.codigo FROM ubigeos u INNER JOIN distritos d ON u.id_distrito = d.id) ud ON COD_UBI = ud.codigo INNER JOIN departamentos dp ON snv.DEPAR_UBI = dp.descripcion
INNER JOIN provincias pr ON snv.PROV_UBI= pr.descripcion;

SELECT snv.COD_UBI, dp.id, pr.id,d.id  FROM (SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI FROM sufragio_nacional_vertical snv group by COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI order by COD_UBI) AS snv
INNER JOIN departamentos dp ON SUBSTRING(snv.COD_UBI, 1,2) = dp.codigo INNER JOIN provincias pr ON SUBSTRING(snv.COD_UBI, 3,2)= pr.codigo INNER JOIN distritos d ON SUBSTRING(snv.COD_UBI, 5,2) = d.codigo
WHERE snv.DIST_UBI = d.descripcion;

SELECT snv.COD_UBI, dp.id,dp.descripcion, pr.id,pr.descripcion FROM (SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI FROM sufragio_nacional_vertical snv group by COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI order by COD_UBI) AS snv
INNER JOIN departamentos dp ON DEPAR_UBI = dp.descripcion INNER JOIN provincias pr ON PROV_UBI= pr.descripcion ORDER BY COD_UBI;

SELECT COD_UBI, DIST_UBI FROM sufragio_nacional_vertical GROUP BY COD_UBI, DIST_UBI ORDER BY COD_UBI;
# INNER JOIN distritos d ON SUBSTRING(snv.COD_UBI, 5,2) = d.codigo
# WHERE snv.DIST_UBI = d.descripcion;
SELECT UDP.COD_UBI, UDP.id
FROM (SELECT snv.COD_UBI, dp.id, pr.id FROM (SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI FROM sufragio_nacional_vertical snv group by COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI order by COD_UBI) AS snv
INNER JOIN departamentos dp ON DEPAR_UBI = dp.descripcion INNER JOIN provincias pr ON PROV_UBI= pr.descripcion ORDER BY COD_UBI) AS UDP
union all
SELECT D.COD_UBI, D.DIST_UBI FROM (SELECT COD_UBI, DIST_UBI FROM sufragio_nacional_vertical GROUP BY COD_UBI, DIST_UBI ORDER BY COD_UBI) AS D;


/* Insertando Los datos de departamenteo y sufragio */
INSERT INTO archelect.ubigeos (codigo, id_departamento, id_provincia, id_distrito, id_odpe, created_at, updated_at)
SELECT snv.COD_UBI, dp.id, pr.id, 1,1,NOW(), NOW()  FROM (SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI FROM sufragio_nacional_vertical snv group by COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI order by COD_UBI) AS snv
INNER JOIN departamentos dp ON DEPAR_UBI = dp.descripcion INNER JOIN provincias pr ON PROV_UBI= pr.descripcion ORDER BY COD_UBI;

select * from ubigeos;
select * from distritos;
select * from odpes;


SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI FROM sufragio_nacional_vertical snv group by COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI order by COD_UBI;

/* */

SELECT COD_UBI, DEPAR_UBI,PROV_UBI,DIST_UBI, NOM_ODPE
FROM sufragio_nacional_vertical GROUP BY COD_UBI, DEPAR_UBI,PROV_UBI, DIST_UBI, NOM_ODPE
ORDER BY COD_UBI;

SELECT id, nombre_odpe FROM odpes;

SELECT COD_UBI, DEPAR_UBI,PROV_UBI, DIS NOM_ODPE, o.id, o.nombre_odpe FROM (SELECT COD_UBI, DEPAR_UBI,PROV_UBI, NOM_ODPE FROM sufragio_nacional_vertical GROUP BY COD_UBI, DEPAR_UBI,PROV_UBI, NOM_ODPE) snv
    INNER JOIN odpes o ON snv.NOM_ODPE = o.nombre_odpe;
