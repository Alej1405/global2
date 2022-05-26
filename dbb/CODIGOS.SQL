CREATE TABLE despachos (
    mrn VARCHAR(45) NOT NULL,
    producto VARCHAR(45) NOT NULL,
    peso DECIMAL(6,2) NOT NULL,
    qtCarga INT(11) NOT NULL,
    mCubicos DECIMAL(6,2) NOT NULL,
    fecha DATE NOT NULL,
    PRIMARY KEY (mrn)
);

tabla de ingresos, tabla que se va a realcionar con los despachos realizados se rastrea por medio del mrn de la carga
es decir que el mrn sera la clave foranea la tabla

CREATE TABLE ingresos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    fecha DATE NOT NULL,
    proveedor VARCHAR(45) NOT NULL,
    producto VARCHAR(45) NOT NULL,
    marca VARCHAR(45) NOT NULL,
    loteCol VARCHAR(45) NOT NULL,
    fechaVencimiento DATE NOT NULL,
    cantidadC DECIMAL(6,2) NOT NULL,
    cantidadU DECIMAL(6,2) NOT NULL,
    largo DECIMAL(6,2) NOT NULL,
    ancho DECIMAL(6,2) NOT NULL,
    alto DECIMAL(6,2) NOT NULL,
    volumen DECIMAL(6,2) NOT NULL,
    peso DECIMAL(6,2) NOT NULL,
    observaciones VARCHAR(45) NOT NULL,
    mrnDespachos VARCHAR(45) NOT NULL,
    PRIMARY KEY (id),
    KEY mrnDespachos (mrnDespachos),
    CONSTRAINT mrn_FK
    FOREIGN KEY (mrnDespachos)
    REFERENCES despachos (mrn)
    );

    prueba de datos con la realcion de la tabla

    INSERT INTO despachos (mrn, producto, peso, qtCarga, mCubicos, fecha) VALUES
        ("CEC2021001581WT", "AZUVISTIN", 12.5, 500, 12.5, "2021/12/12");

    INSERT INTO despachos (mrn, producto, peso, qtCarga, mCubicos, fecha) VALUES
        ("CEC2021SDFSDFS1", "AZUVISTIN", 12.5, 500, 12.5, "2021/09/12"),
        ("CEC202125145241", "PREDSTANOL", 25.5, 500, 120.5, "2021/11/12"),
        ("CEC20212554SDAS", "ECOMAX", 30.5, 550, 15.5, "2021/12/25"),
        ("CEC2021252245SD", "AZUVISTIN", 12.5, 500, 15.5, "2021/12/12");

    ingreso de datos para ingresos

    INSERT INTO ingresos (id, fecha, proveedor, producto, marca, loteCol, fechaVencimiento, cantidadC, cantidadU, largo, ancho, alto, volumen, peso, observaciones, mrnDespachos) VALUES
        ('1', '2021/01/12', 'NUTRIPHARMA', 'CARAMELOS DUROS', 'AZUVISTIN', '102215SD', '2022/12/22', 252, 1522, 125, 12.3, 123, 1150.5, 125, 'SIN NOVEDAD', 'CEC2021SDFSDFS1');
    INSERT INTO ingresos (id, fecha, proveedor, producto, marca, loteCol, fechaVencimiento, cantidadC, cantidadU, largo, ancho, alto, volumen, peso, observaciones, mrnDespachos) VALUES
        ('2', '2021/01/12', 'NUTRIPHARMA', 'CARAMELOS DUROS', 'AZUVISTIN', '102215SD', '2022/12/22', 252, 152, 125, 12.3, 123, 1150.5, 125, 'SIN NOVEDAD', 'CEC2021SDFSDFS1'),
        ('3','2021/01/12', 'NUTRIPHARMA', 'CARAMELOS DUROS', 'AZUVISTIN', '102215SD', '2022/12/22', 25, 12, 125, 12.3, 123, 1150.5, 125, 'SIN NOVEDAD', 'CEC2021SDFSDFS1'),
        ('4', '2021/01/12', 'NUTRIPHARMA', 'CARAMELOS DUROS', 'AZUVISTIN', '102215SD', '2022/12/22', 2, 15, 125, 12.3, 123, 1150.5, 125, 'SIN NOVEDAD', 'CEC20212554SDAS');

SELECT * FROM cliente
    left JOIN usuario ON usuario.id = cliente.idUsuario;