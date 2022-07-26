SELECT COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI
    FROM sufragio_nacional_vertical
WHERE COD_UBI = '010102'
GROUP BY COD_UBI, DEPAR_UBI, PROV_UBI, DIST_UBI ORDER BY COD_UBI
SELECT COD_PROCESO,'ELECCIONES MUNICPALES 2022', NOW(), NOW(), 1, 'USER0001', 'USER0001', 1, NOW(), NOW() FROM sufragio_nacional_vertical LIMIT 1;
CONCAT(cod_dep, cod_pro, cod_dis)


select * from odpes;
select * from departamentos;
select * from provincias;
select * from departamentos;
select * from ubigeos;

/**/

-- INSERT INTO archelect.distritos (codigo, descripcion, created_at, updated_at);
SELECT SUBSTRING(COD_UBI, 3, 2) AS CODIGO, DIST_UBI, NOW(), NOW()
FROM (SELECT COD_UBI, DIST_UBI FROM sufragio_nacional_vertical GROUP BY COD_UBI, DIST_UBI ORDER BY DIST_UBI) AS DISTRITOS GROUP BY CODIGO, DIST_UBI;

SELECT NULL, COD_UBI, 'id_dep', 'id_pro', 'id_dis', 1, now(), now()
FROM (SELECT COD_UBI FROM sufragio_nacional_vertical
WHERE COD_UBI = '010101' AND DIST_UBI = 'CHACHAPOYAS'
GROUP BY COD_UBI ORDER BY COD_UBI) AS COD_UBI_SNV;
# SELECT COD_UBI FROM sufragio_nacional_vertical
# WHERE COD_UBI = cod_ubigeo
# GROUP BY COD_UBI ORDER BY COD_UBI

select * from ubigeos;

SELECT COD_UBI FROM sufragio_nacional_vertical
# WHERE COD_UBI = '010101'
GROUP BY COD_UBI

select * from ubigeos u inner join departamentos d on u.id_departamento = d.id inner join distritos d2 on u.id_distrito = d2.id inner join provincias p on u.id_provincia = p.id
inner join sufragio_nacional_vertical snv on u.codigo = snv.COD_UBI

# Poblando odpes
# INSERT INTO archelect.odpes (nombre_odpe, estado, created_at, updated_at)
SELECT NOM_ODPE, 1, NOW(), NOW() FROM (SELECT COD_UBI, NOM_ODPE FROM sufragio_nacional_vertical GROUP BY COD_UBI, NOM_ODPE ORDER BY COD_UBI) AS ODPES;

SELECT * FROM odpes;

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE odpes;
SET FOREIGN_KEY_CHECKS = 1;