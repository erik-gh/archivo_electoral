DELIMITER $$
CREATE PROCEDURE sp_insert_recepcion_documentos(IN idproceso int, IN idSolucion int, IN idOdpe int,
                                                IN idDepartamento int, IN idProvincia int, IN idDistrito int,
                                                IN idConsulta int, IN idSobre int, IN idSufragio int,
                                                IN idDocumento int, IN codMesa VARCHAR(10))
BEGIN
    DECLARE idMesa INT default null;
    DECLARE idUbigeo INT default null;
    DECLARE corMesa VARCHAR(3);
    DECLARE nroMesa VARCHAR(3);
    DECLARE ingCorMesa VARCHAR(6);
    DECLARE ingNroMesa VARCHAR(6);
    DECLARE idRecDoc INT default null;
    SET ingNroMesa = SUBSTRING(codMesa, 1, 6);
    SET ingCorMesa = SUBSTRING(codMesa, 7, 3);
    #   Evaluando que la mesa exista, si no hay nada no asignada nada se queda con el null
    SELECT id, codigo, nro_mesa INTO idMesa, corMesa, nroMesa FROM mesas WHERE nro_mesa = ingNroMesa;
    #     SELECT id, codigo FROM mesas WHERE nro_mesa = SUBSTRING(codMesa, 1, 6);
#     SELECT idMesa, idUbigeo, corMesa;
    IF (idMesa is not null) THEN
        SELECT id INTO idRecDoc FROM recepcion_documentos WHERE id_mesa = idMesa;
        IF (idRecDoc is not null) THEN
            SELECT 'YA SE RECEPCIONO EL DOCUMENTO' AS MENSAJE;
        ELSE -- Evaluando el ubigeo
            SELECT id INTO idUbigeo
            FROM ubigeos
            WHERE id_departamento = idDepartamento
              AND id_provincia = idProvincia
              AND id_distrito = idDistrito;
            IF (SELECT id FROM sobres WHERE id = idSobre) = 3 THEN -- Evaluando el sobre
                SET idMesa = (SELECT id FROM mesas WHERE codigo = codMesa AND nro_mesa = nroMesa);
                IF (idMesa) THEN
                    SELECT 'INSERTANDO ACTA SOBRE PLOMO' AS MENSAJE, idMesa,corMesa;
                -- Aqui se inserta el sobre plomo
                ELSE
                    SELECT 'EL SOBRE DEL ACTA NO ES PLOMO' AS MENSAJE;
                END IF;
            ELSE
            SELECT 'INSERTANDO CON OTRO SOBRE ' AS MENSAJE;
            END IF;
        END IF;
    ELSE
    SELECT 'MESA NO EXISTE' AS MENSAJE;

END IF;
END$$
DELIMITER ;
/* Ejecutando el procedimiento */
CALL sp_insert_recepcion_documentos(1, 2, 21,
                                    13, 67, 1264, 1,
                                    3, 1, 3, '00000101k');
SELECT * FROM mesas WHERE codigo = '02k';
/* Eliminado el procedimiento */
DROP PROCEDURE IF EXISTS sp_insert_recepcion_documentos;


/* Truncar una tabla */
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE ubigeos;
SET FOREIGN_KEY_CHECKS = 1;
SELECT *
FROM mesas WHERE id = 131071;
SELECT *
FROM sobres;


