-- Création de la base de données ZapKartenn

CREATE DATABASE IF NOT EXISTS zapkartenn
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE zapkartenn;


CREATE TABLE IF NOT EXISTS COMMUNE (
    code_insee   VARCHAR(10)  PRIMARY KEY,
    nom          VARCHAR(150) NOT NULL,
    code_postal  VARCHAR(10),
    population   INTEGER,
    dep_nom      VARCHAR(100)
) ENGINE=InnoDB;


-- Table AMENAGEUR
CREATE TABLE IF NOT EXISTS AMENAGEUR (
    siren    VARCHAR(20)  PRIMARY KEY,
    nom      VARCHAR(150) NOT NULL,
    contact  VARCHAR(255)
) ENGINE=InnoDB;

-- Table OPERATEUR
CREATE TABLE IF NOT EXISTS OPERATEUR (
    id_operateur  INT          AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(150) NOT NULL,
    contact       VARCHAR(255),
    telephone     VARCHAR(30)
) ENGINE=InnoDB;

-- Table STATION
CREATE TABLE IF NOT EXISTS STATION (
    id_station           VARCHAR(100) PRIMARY KEY,
    id_local             VARCHAR(100),
    nom_station          VARCHAR(255),
    nom_enseigne         VARCHAR(255),
    implantation         VARCHAR(100),
    adresse              TEXT,
    horaires             TEXT,
    raccordement         VARCHAR(100),
    date_mise_en_service VARCHAR(20),
    longitude            DECIMAL(11, 7),
    latitude             DECIMAL(11, 7),

    code_insee           VARCHAR(10),
    siren                VARCHAR(20),

    CONSTRAINT fk_station_commune
        FOREIGN KEY (code_insee) REFERENCES COMMUNE(code_insee)
        ON DELETE SET NULL ON UPDATE CASCADE,

    CONSTRAINT fk_station_amenageur
        FOREIGN KEY (siren) REFERENCES AMENAGEUR(siren)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Table POINT_DE_CHARGE
CREATE TABLE IF NOT EXISTS POINT_DE_CHARGE (
    id_pdc             INT          AUTO_INCREMENT PRIMARY KEY,
    puissance_nominale INT,
    prise_ef           INT          DEFAULT 0,
    prise_t2           INT          DEFAULT 0,
    prise_type_ccs     BOOLEAN      DEFAULT FALSE,
    chademo            BOOLEAN      DEFAULT FALSE,
    gratuit            VARCHAR(10),
    paiement           TEXT,
    tarification       TEXT,

    id_station         VARCHAR(100),

    CONSTRAINT fk_pdc_station
        FOREIGN KEY (id_station) REFERENCES STATION(id_station)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Table de liaison OPERE
CREATE TABLE IF NOT EXISTS OPERE (
    id_pdc        INT NOT NULL,
    id_operateur  INT NOT NULL,

    PRIMARY KEY (id_pdc, id_operateur),

    CONSTRAINT fk_opere_pdc
        FOREIGN KEY (id_pdc) REFERENCES POINT_DE_CHARGE(id_pdc)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT fk_opere_operateur
        FOREIGN KEY (id_operateur) REFERENCES OPERATEUR(id_operateur)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;