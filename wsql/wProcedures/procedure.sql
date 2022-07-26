DELIMITER $$
CREATE PROCEDURE sp_poblarUbigeo()
BEGIN
    /* Objetivo : Insertar los ubigeos depende los departamentos-provincias-distritos */
    /* Listando los departamentos */
#     SELECT ID, CODIGO, descripcion FROM departamentos;
    /* Listando las provincias */
#     SELECT ID, CODIGO, descripcion FROM provincias;
    /* Listando los distritos */
#     SELECT ID, CODIGO, descripcion FROM distritos;
    /*Listando los ubigeos y sus campos para comparar */
#     SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI FROM sufragio_nacional_vertical GROUP BY COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI ORDER BY COD_UBI;-- 1874
    DECLARE done INT DEFAULT FALSE;
    /* variables del sufragio_nacional_vertical */
    DECLARE cod_ubigeo VARCHAR(6);
    DECLARE des_ubi_dep VARCHAR(255);
    DECLARE des_ubi_pro VARCHAR(255);
    DECLARE des_ubi_dis VARCHAR(255);
    /* variables de la codigo  */
    DECLARE cod_dep VARCHAR(2);
    DECLARE cod_pro VARCHAR(2);
    DECLARE cod_dis VARCHAR(2);
    /* variables de la descripcion  */
    DECLARE des_dep VARCHAR(255);
    DECLARE des_pro VARCHAR(255);
    DECLARE des_dis VARCHAR(255);

    /* variables de la id's  */
    DECLARE id_dep INT;
    DECLARE id_pro INT;
    DECLARE id_dis INT;

    /* Declarando los cursores */
    DECLARE curUbigeoSNV CURSOR FOR SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI
                                    FROM sufragio_nacional_vertical
                                    GROUP BY COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI
                                    ORDER BY COD_UBI;

    DECLARE curDepartamentos CURSOR FOR SELECT ID, CODIGO, descripcion FROM departamentos;
    DECLARE curProvincias CURSOR FOR SELECT ID, CODIGO, descripcion FROM provincias;
    DECLARE curDistritos CURSOR FOR SELECT ID, CODIGO, descripcion FROM distritos;
    /* Para salir del loop */
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    OPEN curUbigeoSNV;
    OPEN curDepartamentos;
    OPEN curProvincias;
    OPEN curDistritos;

    asignar_ubigeos:
    LOOP
        FETCH curUbigeoSNV INTO cod_ubigeo, des_ubi_dep, des_ubi_pro, des_ubi_dis;
        FETCH curDepartamentos INTO id_dep, cod_dep, des_dep;
        FETCH curProvincias INTO id_pro, cod_pro,des_pro;
        FETCH curDistritos INTO id_dis, cod_dis, des_dis;

        IF done THEN
            LEAVE asignar_ubigeos;
        END IF;

        /*IF cod_ubigeo = CONCAT(cod_dep, cod_pro, cod_dis) THEN
#             Aqui se se inserta una odpe de prueba
            INSERT INTO ubigeos VALUES (NULL, cod_ubigeo, id_dep, id_pro, id_dis,1, now(), now());
        END IF;*/
        INSERT INTO ubigeos VALUES (NULL, cod_ubigeo, id_dep, id_pro, id_dis,1, now(), now());
    END LOOP;

    CLOSE curUbigeoSNV;
    CLOSE curDepartamentos;
    CLOSE curProvincias;
    CLOSE curDistritos;

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

SELECT * FROM ubigeos;