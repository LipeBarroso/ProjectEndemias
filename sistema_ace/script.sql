CREATE DATABASE sistema_ace DEFAULT CHARACTER SET utf8;
USE sistema_ace;

CREATE TABLE agente_de_campo (
    id_agente     INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    cod_agente    varchar(5) NOT NULL,
    nome          VARCHAR(255) NOT NULL
);

CREATE TABLE area (
    cod_area    VARCHAR(10) NOT NULL PRIMARY KEY,
    nome_area   VARCHAR(255) NOT NULL,
    cod_zona    VARCHAR(2) NOT NULL,
    qtd_quarteiroes int NOT NULL,
    qtd_habitantes INT,
    qtd_caes    INT,
    qtd_gatos   INT
);

CREATE TABLE registro_geografico (
    id_quarteirao   INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    numero_quarteirao    INT NOT NULL,
    cod_area    varchar(10) NOT NULL ,
    nome_area   VARCHAR(255) NOT NULL,
    cod_zona    VARCHAR(2) NOT NULL,
    qtd_imoveis INT NOT NULL,
    qtd_residencia int,
    qtd_terrenos_baldio int,
    qtd_ponto_estrategico int,
    qtd_outro int,
    qtd_comercio int,
    qtd_habitantes INT,
    qtd_caes    INT,
    qtd_gatos   INT,
    FOREIGN KEY (cod_area) REFERENCES area(cod_area)
);

CREATE TABLE imovel (
    id_imovel   INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_quarteirao INT NOT NULL,
    nome_rua    varchar(100) NOT NULL,
    numer_imovel   VARCHAR(10) NOT NULL,
    tipo_imovel    VARCHAR(20) NOT NULL,
    qtd_habitantes INT,
    qtd_caes    INT,
    qtd_gatos   INT,
    FOREIGN KEY (id_quarteirao) REFERENCES registro_geografico(id_quarteirao)
);

CREATE TABLE deposito (
    id_deposito   INT NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    id_visita   INT NOT NULL,
    tipo    varchar(2) NOT NULL,
    foco    BOOLEAN,
    tratado BOOLEAN,
    qtd_larvicida FLOAT,
    amostra VARCHAR(10)
);

CREATE TABLE visita (
    id_visita INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_imovel   INT NOT NULL,
    id_deposito   INT NOT NULL,
    tipo    varchar(2) NOT NULL,
    hora    time,
    data    DATE,
    FOREIGN KEY (id_imovel) REFERENCES imovel(id_imovel),
    FOREIGN KEY (id_deposito) REFERENCES deposito(id_deposito)
);

CREATE TABLE boletim_diario (
    id_diario INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    id_imovel INT NOT NULL,
    id_visita INT NOT NULL,
    id_agente INT NOT NULL,
    tipo    varchar(2) NOT NULL,
    hora    time,
    data    DATE,
    FOREIGN KEY (id_agente) REFERENCES agente_de_campo(id_agente),
    FOREIGN KEY (id_imovel) REFERENCES imovel(id_imovel),
    FOREIGN KEY (id_visita) REFERENCES visita(id_visita)
);


    alter TABLE deposito
    add FOREIGN KEY (id_visita) REFERENCES visita(id_visita);