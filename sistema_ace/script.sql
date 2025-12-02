
CREATE DATABASE sistema_ace;

USE sistema_ace;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";




CREATE TABLE `agente_de_campo` (
  `id_agente` int(11) NOT NULL,
  `cod_agente` varchar(5) NOT NULL,
  `nome` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;




CREATE TABLE `area` (
  `cod_area` varchar(10) NOT NULL,
  `nome_area` varchar(255) NOT NULL,
  `cod_zona` varchar(2) NOT NULL,
  `qtd_quarteiroes` int(11) NOT NULL,
  `qtd_habitantes` int(11) DEFAULT NULL,
  `qtd_caes` int(11) DEFAULT NULL,
  `qtd_gatos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `area` (`cod_area`, `nome_area`, `cod_zona`, `qtd_quarteiroes`, `qtd_habitantes`, `qtd_caes`, `qtd_gatos`) VALUES
('01', 'A', '01', 2, 3, 0, 0),
('02', 'B', '02', 3, 0, 0, 0);



CREATE TABLE `boletim_diario` (
  `id_diario` int(11) NOT NULL,
  `id_imovel` int(11) NOT NULL,
  `id_visita` int(11) NOT NULL,
  `id_agente` int(11) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `hora` time DEFAULT NULL,
  `data` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



CREATE TABLE `deposito` (
  `id_deposito` int(11) NOT NULL,
  `id_visita` int(11) NOT NULL,
  `tipo` varchar(2) NOT NULL,
  `foco` tinyint(1) DEFAULT NULL,
  `tratado` tinyint(1) DEFAULT NULL,
  `qtd_larvicida` float DEFAULT NULL,
  `amostra` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-

INSERT INTO `deposito` (`id_deposito`, `id_visita`, `tipo`, `foco`, `tratado`, `qtd_larvicida`, `amostra`) VALUES
(1, 11, 'A1', 1, NULL, 1, NULL),
(2, 11, 'A1', 1, NULL, 2, NULL),
(3, 11, 'A1', 1, NULL, 4, NULL),
(4, 11, 'A1', 1, NULL, 0, NULL),
(5, 8, 'A1', 0, NULL, 0, NULL),
(6, 8, 'A1', 0, NULL, 2, NULL),
(7, 8, 'A1', 1, NULL, 2.5, NULL);



CREATE TABLE `imovel` (
  `id_imovel` int(11) NOT NULL,
  `id_quarteirao` int(11) NOT NULL,
  `nome_rua` varchar(100) NOT NULL,
  `numero_imovel` varchar(10) NOT NULL,
  `tipo_imovel` varchar(20) NOT NULL,
  `qtd_habitantes` int(11) DEFAULT NULL,
  `qtd_caes` int(11) DEFAULT NULL,
  `qtd_gatos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `imovel` (`id_imovel`, `id_quarteirao`, `nome_rua`, `numero_imovel`, `tipo_imovel`, `qtd_habitantes`, `qtd_caes`, `qtd_gatos`) VALUES
(1, 3, 'Projetada A', '100', 'Residencial', 2, 2, 0),
(2, 2, 'Projetada 2', '200', 'Comercial', 5, 2, 1),
(5, 1, 'Projetada 7', '55', 'Comercial', 1, 1, 1),
(6, 2, 'Etelvino', '555', 'Residencial', 2, 1, 2);




CREATE TABLE `registro_geografico` (
  `id_quarteirao` int(11) NOT NULL,
  `numero_quarteirao` int(11) NOT NULL,
  `cod_area` varchar(10) NOT NULL,
  `nome_area` varchar(255) NOT NULL,
  `cod_zona` varchar(2) NOT NULL,
  `qtd_imoveis` int(11) NOT NULL,
  `qtd_residencia` int(11) DEFAULT NULL,
  `qtd_terrenos_baldio` int(11) DEFAULT NULL,
  `qtd_ponto_estrategico` int(11) DEFAULT NULL,
  `qtd_outro` int(11) DEFAULT NULL,
  `qtd_comercio` int(11) DEFAULT NULL,
  `qtd_habitantes` int(11) DEFAULT NULL,
  `qtd_caes` int(11) DEFAULT NULL,
  `qtd_gatos` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `registro_geografico` (`id_quarteirao`, `numero_quarteirao`, `cod_area`, `nome_area`, `cod_zona`, `qtd_imoveis`, `qtd_residencia`, `qtd_terrenos_baldio`, `qtd_ponto_estrategico`, `qtd_outro`, `qtd_comercio`, `qtd_habitantes`, `qtd_caes`, `qtd_gatos`) VALUES
(1, 2, '01', 'A', '1', 6, 0, 2, 1, 3, 0, 0, 0, 0),
(2, 1, '01', 'A', '01', 2, 2, 0, 0, 0, 0, 3, 0, 0),
(3, 1, '02', 'B', '02', 2, 2, 0, 0, 0, 0, 3, 0, 0),
(4, 2, '02', 'B', '02', 6, 0, 2, 1, 3, 0, 0, 0, 0);



CREATE TABLE `visita` (
  `id_visita` int(11) NOT NULL,
  `id_imovel` int(11) NOT NULL,
  `tipo` varchar(8) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `data` date DEFAULT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;



INSERT INTO `visita` (`id_visita`, `id_imovel`, `tipo`, `hora`, `data`, `estado`) VALUES
(8, 2, 'Normal', '23:30:00', '2025-12-04', 0),
(9, 1, 'Normal', '05:40:00', '2025-11-02', 0),
(10, 1, 'Normal', '03:16:00', '2025-12-09', 0),
(11, 5, 'Normal', '04:16:00', '2025-12-04', 0),
(12, 1, 'Repasse', '03:16:00', '2025-12-24', 0),
(13, 5, 'Normal', '04:34:00', '2026-01-03', 0),
(14, 6, 'Normal', '00:47:00', '2025-12-10', 0);


ALTER TABLE `agente_de_campo`
  ADD PRIMARY KEY (`id_agente`);


ALTER TABLE `area`
  ADD PRIMARY KEY (`cod_area`);

ALTER TABLE `boletim_diario`
  ADD PRIMARY KEY (`id_diario`),
  ADD KEY `id_agente` (`id_agente`),
  ADD KEY `id_imovel` (`id_imovel`),
  ADD KEY `id_visita` (`id_visita`);


ALTER TABLE `deposito`
  ADD PRIMARY KEY (`id_deposito`),
  ADD KEY `id_visita` (`id_visita`);


ALTER TABLE `imovel`
  ADD PRIMARY KEY (`id_imovel`),
  ADD KEY `id_quarteirao` (`id_quarteirao`);

ALTER TABLE `registro_geografico`
  ADD PRIMARY KEY (`id_quarteirao`),
  ADD KEY `cod_area` (`cod_area`);


ALTER TABLE `visita`
  ADD PRIMARY KEY (`id_visita`),
  ADD KEY `id_imovel` (`id_imovel`);


ALTER TABLE `agente_de_campo`
  MODIFY `id_agente` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `boletim_diario`
  MODIFY `id_diario` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `deposito`
  MODIFY `id_deposito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;


ALTER TABLE `imovel`
  MODIFY `id_imovel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;


ALTER TABLE `registro_geografico`
  MODIFY `id_quarteirao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `visita`
  MODIFY `id_visita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;


ALTER TABLE `boletim_diario`
  ADD CONSTRAINT `boletim_diario_ibfk_1` FOREIGN KEY (`id_agente`) REFERENCES `agente_de_campo` (`id_agente`),
  ADD CONSTRAINT `boletim_diario_ibfk_2` FOREIGN KEY (`id_imovel`) REFERENCES `imovel` (`id_imovel`),
  ADD CONSTRAINT `boletim_diario_ibfk_3` FOREIGN KEY (`id_visita`) REFERENCES `visita` (`id_visita`);


ALTER TABLE `deposito`
  ADD CONSTRAINT `deposito_ibfk_1` FOREIGN KEY (`id_visita`) REFERENCES `visita` (`id_visita`);


ALTER TABLE `imovel`
  ADD CONSTRAINT `imovel_ibfk_1` FOREIGN KEY (`id_quarteirao`) REFERENCES `registro_geografico` (`id_quarteirao`);


ALTER TABLE `registro_geografico`
  ADD CONSTRAINT `registro_geografico_ibfk_1` FOREIGN KEY (`cod_area`) REFERENCES `area` (`cod_area`);


ALTER TABLE `visita`
  ADD CONSTRAINT `visita_ibfk_1` FOREIGN KEY (`id_imovel`) REFERENCES `imovel` (`id_imovel`);
COMMIT;

