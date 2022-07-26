# Poblando distritos
# INSERT INTO archelect.distritos (codigo, descripcion, created_at, updated_at)
# SELECT SUBSTRING(COD_UBI, 5, 2) AS CODIGO, DIST_UBI, NOW(), NOW()
# FROM (SELECT COD_UBI, DIST_UBI FROM sufragio_nacional_vertical GROUP BY COD_UBI, DIST_UBI ORDER BY COD_UBI) AS DISTRITOS ;-- 1874

SELECT * FROM distritos order by descripcion;-- 1852

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE ubigeos;
SET FOREIGN_KEY_CHECKS = 1;

select * from ubigeos;


SELECT u.id, u.codigo, d.descripcion, p.descripcion, d2.descripcion, o.nombre_odpe
FROM ubigeos u
INNER JOIN departamentos d ON u.id_departamento = d.id
INNER JOIN provincias p on u.id_provincia = p.id
INNER JOIN distritos d2 on u.id_distrito = d2.id
INNER JOIN odpes O ON u.id_odpe = O.id;


SELECT * FROM ubigeos;
