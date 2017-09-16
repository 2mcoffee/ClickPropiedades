-- phpMyAdmin SQL Dump
-- version 4.7.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 16, 2017 at 03:43 PM
-- Server version: 10.1.24-MariaDB-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `revistac_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `avisos`
--

CREATE TABLE `avisos` (
  `id_aviso` bigint(20) NOT NULL,
  `id_inmobiliaria` bigint(20) NOT NULL,
  `id_caracteristica` bigint(20) DEFAULT NULL,
  `id_dato_basico` bigint(20) DEFAULT NULL,
  `codigoficha` varchar(30) DEFAULT NULL,
  `id_localidad` int(11) DEFAULT NULL,
  `id_domicilio` bigint(20) DEFAULT NULL,
  `descripcion` varchar(500) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_estadoAviso` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `caracteristicas`
--

CREATE TABLE `caracteristicas` (
  `id_caracteristica` bigint(20) NOT NULL,
  `can_ambientes` int(11) DEFAULT NULL,
  `can_dormitorios` int(11) DEFAULT NULL,
  `antiguedad` int(11) DEFAULT NULL,
  `disposicion` varchar(30) DEFAULT NULL,
  `profesional` char(2) DEFAULT NULL,
  `terraza` varchar(10) DEFAULT NULL,
  `luminosidad` varchar(10) DEFAULT NULL,
  `seguridad` varchar(10) DEFAULT NULL,
  `sup_total` int(11) DEFAULT NULL,
  `sup_cubierta` int(11) DEFAULT NULL,
  `banos` varchar(10) DEFAULT NULL,
  `toilette` varchar(10) DEFAULT NULL,
  `garage` varchar(10) DEFAULT NULL,
  `balcon` varchar(10) DEFAULT NULL,
  `patio` varchar(10) DEFAULT NULL,
  `jardin` varchar(10) DEFAULT NULL,
  `pileta` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `datos_basicos`
--

CREATE TABLE `datos_basicos` (
  `id_dato_basico` bigint(20) NOT NULL,
  `id_tipo_inmueble` int(11) DEFAULT NULL,
  `id_tipo_operacion` int(11) DEFAULT NULL,
  `id_tipo_moneda` int(11) DEFAULT NULL,
  `precio` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `destacados`
--

CREATE TABLE `destacados` (
  `id_destacado` int(11) NOT NULL,
  `id_aviso` bigint(20) NOT NULL,
  `orden` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `domicilios`
--

CREATE TABLE `domicilios` (
  `id_domicilio` bigint(20) NOT NULL,
  `calle` varchar(50) DEFAULT NULL,
  `altura` int(11) DEFAULT NULL,
  `piso` varchar(10) DEFAULT NULL,
  `depto` varchar(9) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `estado_aviso`
--

CREATE TABLE `estado_aviso` (
  `id_estadoAviso` int(11) NOT NULL DEFAULT '0',
  `descripcion` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `fotos`
--

CREATE TABLE `fotos` (
  `id_foto` bigint(20) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `orden` int(11) DEFAULT NULL,
  `id_aviso` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `inmobiliarias`
--

CREATE TABLE `inmobiliarias` (
  `id_inmobiliaria` bigint(20) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `cuit` varchar(13) DEFAULT NULL,
  `url_log` varchar(200) DEFAULT NULL,
  `habilitada` bit(1) DEFAULT NULL,
  `id_tipo_plan` int(11) DEFAULT NULL,
  `id_domicilio` bigint(20) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `id_usuario` bigint(20) DEFAULT NULL,
  `fecha_alta_plan` datetime DEFAULT NULL,
  `URL` varchar(50) DEFAULT NULL,
  `contacto` varchar(50) DEFAULT NULL,
  `id_localidad` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `localidades`
--

CREATE TABLE `localidades` (
  `id_localidad` int(11) NOT NULL DEFAULT '0',
  `descripcion` varchar(50) DEFAULT NULL,
  `id_provincia` int(11) DEFAULT NULL,
  `id_partido` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mails`
--

CREATE TABLE `mails` (
  `id_mail` bigint(20) NOT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `id_inmobiliaria` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `partidos`
--

CREATE TABLE `partidos` (
  `id_partido` int(11) NOT NULL DEFAULT '0',
  `descripcion` varchar(50) DEFAULT NULL,
  `id_provincia` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `provincias`
--

CREATE TABLE `provincias` (
  `id_provincia` int(11) NOT NULL DEFAULT '0',
  `descripcion` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `telefonos`
--

CREATE TABLE `telefonos` (
  `id_telefono` bigint(20) NOT NULL,
  `numero` varchar(20) DEFAULT NULL,
  `region` varchar(10) DEFAULT NULL,
  `movil` varchar(15) DEFAULT NULL,
  `id_inmobiliaria` bigint(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_inmuebles`
--

CREATE TABLE `tipo_inmuebles` (
  `id_tipo_inmueble` int(11) NOT NULL,
  `descripcion` varchar(30) DEFAULT NULL,
  `orden` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_monedas`
--

CREATE TABLE `tipo_monedas` (
  `id_tipo_moneda` int(11) NOT NULL,
  `descripcion` varchar(20) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_operaciones`
--

CREATE TABLE `tipo_operaciones` (
  `id_tipo_operacion` int(11) NOT NULL,
  `descripcion` varchar(30) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tipo_plan_inmobiliarias`
--

CREATE TABLE `tipo_plan_inmobiliarias` (
  `id_tipo_plan` int(11) NOT NULL,
  `descripcion` varchar(30) DEFAULT NULL,
  `cantidad_inmueble` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` bigint(20) NOT NULL,
  `usuario` varchar(50) DEFAULT NULL,
  `pwd` varchar(50) DEFAULT NULL,
  `id_rol` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `visitas_avisos`
--

CREATE TABLE `visitas_avisos` (
  `id_aviso` bigint(20) DEFAULT NULL,
  `fecha_visita` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avisos`
--
ALTER TABLE `avisos`
  ADD PRIMARY KEY (`id_aviso`),
  ADD KEY `id_inmobiliaria` (`id_inmobiliaria`),
  ADD KEY `id_caracteristica` (`id_caracteristica`),
  ADD KEY `id_dato_basico` (`id_dato_basico`),
  ADD KEY `id_localidad` (`id_localidad`),
  ADD KEY `id_domicilio` (`id_domicilio`),
  ADD KEY `id_estadoAviso` (`id_estadoAviso`);

--
-- Indexes for table `caracteristicas`
--
ALTER TABLE `caracteristicas`
  ADD PRIMARY KEY (`id_caracteristica`);

--
-- Indexes for table `datos_basicos`
--
ALTER TABLE `datos_basicos`
  ADD PRIMARY KEY (`id_dato_basico`),
  ADD KEY `id_tipo_inmueble` (`id_tipo_inmueble`),
  ADD KEY `id_tipo_operacion` (`id_tipo_operacion`),
  ADD KEY `id_tipo_moneda` (`id_tipo_moneda`);

--
-- Indexes for table `destacados`
--
ALTER TABLE `destacados`
  ADD PRIMARY KEY (`id_destacado`),
  ADD KEY `id_aviso` (`id_aviso`);

--
-- Indexes for table `domicilios`
--
ALTER TABLE `domicilios`
  ADD PRIMARY KEY (`id_domicilio`);

--
-- Indexes for table `estado_aviso`
--
ALTER TABLE `estado_aviso`
  ADD PRIMARY KEY (`id_estadoAviso`);

--
-- Indexes for table `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id_foto`),
  ADD KEY `id_aviso` (`id_aviso`);

--
-- Indexes for table `inmobiliarias`
--
ALTER TABLE `inmobiliarias`
  ADD PRIMARY KEY (`id_inmobiliaria`),
  ADD KEY `id_tipo_plan` (`id_tipo_plan`),
  ADD KEY `id_domicilio` (`id_domicilio`),
  ADD KEY `id_localidad` (`id_localidad`);

--
-- Indexes for table `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`id_localidad`),
  ADD KEY `id_partido` (`id_partido`);

--
-- Indexes for table `mails`
--
ALTER TABLE `mails`
  ADD PRIMARY KEY (`id_mail`),
  ADD KEY `id_inmobiliaria` (`id_inmobiliaria`);

--
-- Indexes for table `partidos`
--
ALTER TABLE `partidos`
  ADD PRIMARY KEY (`id_partido`),
  ADD KEY `id_provincia` (`id_provincia`);

--
-- Indexes for table `provincias`
--
ALTER TABLE `provincias`
  ADD PRIMARY KEY (`id_provincia`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`);

--
-- Indexes for table `telefonos`
--
ALTER TABLE `telefonos`
  ADD PRIMARY KEY (`id_telefono`),
  ADD KEY `id_inmobiliaria` (`id_inmobiliaria`);

--
-- Indexes for table `tipo_inmuebles`
--
ALTER TABLE `tipo_inmuebles`
  ADD PRIMARY KEY (`id_tipo_inmueble`);

--
-- Indexes for table `tipo_monedas`
--
ALTER TABLE `tipo_monedas`
  ADD PRIMARY KEY (`id_tipo_moneda`);

--
-- Indexes for table `tipo_operaciones`
--
ALTER TABLE `tipo_operaciones`
  ADD PRIMARY KEY (`id_tipo_operacion`);

--
-- Indexes for table `tipo_plan_inmobiliarias`
--
ALTER TABLE `tipo_plan_inmobiliarias`
  ADD PRIMARY KEY (`id_tipo_plan`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `id_rol` (`id_rol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avisos`
--
ALTER TABLE `avisos`
  MODIFY `id_aviso` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1503;
--
-- AUTO_INCREMENT for table `caracteristicas`
--
ALTER TABLE `caracteristicas`
  MODIFY `id_caracteristica` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1503;
--
-- AUTO_INCREMENT for table `datos_basicos`
--
ALTER TABLE `datos_basicos`
  MODIFY `id_dato_basico` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1503;
--
-- AUTO_INCREMENT for table `domicilios`
--
ALTER TABLE `domicilios`
  MODIFY `id_domicilio` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1950;
--
-- AUTO_INCREMENT for table `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id_foto` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4603;
--
-- AUTO_INCREMENT for table `inmobiliarias`
--
ALTER TABLE `inmobiliarias`
  MODIFY `id_inmobiliaria` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=448;
--
-- AUTO_INCREMENT for table `mails`
--
ALTER TABLE `mails`
  MODIFY `id_mail` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=448;
--
-- AUTO_INCREMENT for table `telefonos`
--
ALTER TABLE `telefonos`
  MODIFY `id_telefono` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=448;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=449;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
