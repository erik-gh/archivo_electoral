DELIMITER $$
CREATE PROCEDURE sp_poblarUbigeo()
BEGIN
    DECLARE doneubi, done1dep, done2pro, done3dis  INT DEFAULT FALSE;
    DECLARE var_ubigeo INT;
    DECLARE var_dep INT;
    DECLARE var_pro INT;
    DECLARE var_dis INT;
    /* variables del sufragio_nacional_vertical */
    DECLARE cod_ubigeo VARCHAR(6); -- COD_UBI
    DECLARE des_ubi_dep VARCHAR(255); -- DEPAR_UBI
    DECLARE des_ubi_pro VARCHAR(255);-- PROV_UBI
    DECLARE des_ubi_dis VARCHAR(255);-- DIST_UBI
    /* Declarando los cursor Ubigeo */
    DECLARE curUbigeoSNV CURSOR FOR SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI FROM sufragio_nacional_vertical GROUP BY COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI ORDER BY COD_UBI;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET doneubi = TRUE;
    SET var_ubigeo = 0;
    SET var_dep = 0;
    SET var_pro = 0;
    SET var_dis = 0;
    OPEN curUbigeoSNV;
    loop1_ubigeos: LOOP
        FETCH curUbigeoSNV INTO cod_ubigeo, des_ubi_dep, des_ubi_pro, des_ubi_dis;
        # 010101, AMAZONAS, CHACHAPOYAS, CHACHAPOYAS
        IF doneubi THEN
            CLOSE curUbigeoSNV;
            LEAVE loop1_ubigeos;
        END IF;
        /*Bloque de loop1*/
        BLOCK1DEPARTAMENTO: BEGIN
            DECLARE id_dep INT;
            DECLARE cod_dep VARCHAR(2);
            DECLARE des_dep VARCHAR(255);
            DECLARE curDepartamentos CURSOR FOR SELECT id, codigo, descripcion FROM departamentos;
            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done1dep = TRUE;

            OPEN curDepartamentos;
            loop1_departamentos: LOOP
                FETCH curDepartamentos INTO id_dep, cod_dep, des_dep;
                #   1, 01, AMAZONAS/
                IF done1dep THEN
                    CLOSE curDepartamentos;
                    LEAVE loop1_departamentos;
                END IF;
                /*Bloque de loop2*/
                BLOCK2PROVINCIA: BEGIN
                    DECLARE cod_pro VARCHAR(2);
                    DECLARE des_pro VARCHAR(255);
                    DECLARE id_pro INT;
                    DECLARE curProvincias CURSOR FOR SELECT id, codigo, descripcion FROM provincias;
                    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done2pro = TRUE;

                    OPEN curProvincias;
                    loop2_provincias: LOOP
                        FETCH curProvincias INTO id_pro, cod_pro,des_pro;
                        #   1,01, ABANCAY
                        IF done2pro THEN
                            CLOSE curProvincias;
                            LEAVE loop2_provincias;
                        END IF;
                        /*Bloque de loop3*/
                        BLOCK3DISTRITO: BEGIN
                            DECLARE cod_dis VARCHAR(2);
                            DECLARE des_dis VARCHAR(255);
                            DECLARE id_dis INT;
                            DECLARE curDistritos CURSOR FOR SELECT id, codigo, descripcion FROM distritos;
                            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done3dis = TRUE;

                            OPEN curDistritos;
                            loop3_distritos: LOOP
                                FETCH curDistritos INTO id_dis, cod_dis, des_dis;
                                # 1, 01, ABANCAY
#                                 IF done3dis THEN
#                                     CLOSE curDistritos;
#                                     LEAVE loop3_distritos;
#                                 END IF;
                                /*Bloque de sentecia e insert*/
#                                 IF cod_ubigeo = CONCAT(cod_dep, cod_pro, cod_dis) AND des_ubi_dep = des_dep AND des_ubi_pro = des_pro AND des_ubi_dis = des_dis THEN
                                IF cod_ubigeo = CONCAT(cod_dep, cod_pro, cod_dis) AND des_ubi_dis = des_dis THEN
                                # 010101 and
                                # Aqui se se inserta una odpe de prueba
#                                 INSERT INTO ubigeos VALUES (NULL, cod_ubigeo, id_dep, id_pro, id_dis,1, now(), now());
                                    SET var_dis := var_dis + 1;
                                END IF;
                            END LOOP;
                        END BLOCK3DISTRITO;
                    END LOOP;
                END BLOCK2PROVINCIA;
            END LOOP;
        END BLOCK1DEPARTAMENTO;
    END LOOP;
    /* Mostrando los ubigeos insertados */
#     SELECT var_dis;
    SELECT * FROM ubigeos;
END$$
DELIMITER ;
/* Truncar una tabla */
SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE ubigeos;
SET FOREIGN_KEY_CHECKS=1;

/* Ejecutando el procedimiento */
CALL sp_poblarUbigeo();

/* Eliminado el procedimiento */
DROP PROCEDURE IF EXISTS sp_poblarUbigeo;

SELECT * FROM ubigeos inner join distritos d on ubigeos.id_distrito = d.id;

select * from sufragio_nacional_vertical where COD_UBI ='010101';