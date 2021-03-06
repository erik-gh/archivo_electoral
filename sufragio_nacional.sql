create table sufragio_nacional_vertical
(
    COD_PROCESO   varchar(15)  null,
    COD_ODPE      int          null,
    COD_UBI       varchar(6)   null,
    DEPAR_UBI     varchar(255) null,
    PROV_UBI      varchar(255) null,
    DIST_UBI      varchar(255) null,
    COD_LOC       varchar(8)   null,
    NOM_LOC       varchar(255) null,
    DIR_LOC       varchar(255) null,
    NRO_MESA      varchar(255) null,
    N_MESA_MADRE  varchar(255) null,
    ELECTORES     varchar(255) null,
    CONDI         varchar(2)   null,
    ORDEN         varchar(255) null,
    TOTELECMMADRE int          null,
    COD_CONSULTA  varchar(10)  null,
    COD_ST        varchar(5)   null,
    ESPECIAL      varchar(5)   null,
    COD_LOC_NUEVO varchar(20)  null,
    NOM_ODPE      varchar(255) null,
    COD_PP        varchar(4)   null,
    COD_TIPO      varchar(3)   null,
    COD_AC        varchar(3)   null
);