-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 11, 2013 at 04:38 PM
-- Server version: 5.6.13
-- PHP Version: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `store_locator`
--

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state`) VALUES
(1, 'Guadalajara', 1),
(2, 'Zapopan', 1),
(3, 'Tlaquepaque', 1),
(4, 'Aguascalientes', 2),
(5, 'Mazatlán', 3),
(6, 'León', 4),
(7, 'Chihuahua', 5),
(8, 'Culiacán', 3),
(9, 'Monterrey', 7),
(10, 'San Luis Potosí', 8),
(11, 'Torreón', 9);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` varchar(255) NOT NULL,
  `lng` varchar(255) NOT NULL,
  `store` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `lat`, `lng`, `store`) VALUES
(1, '-103.3499184', '20.6765735', 1),
(2, '-103.401428', '20.649939', 2),
(3, '-103.35135', '20.674447', 3),
(4, '-103.3539652', '20.6647874', 4),
(5, '-103.347659', '20.675421', 5),
(6, '-103.3472874', '20.67813611', 6),
(7, '-103.3684884', '20.6734905', 7),
(8, '-103.4040991', '20.64855152', 8),
(9, '-103.3783276', '20.71264586', 9),
(10, '-103.3997181', '20.67944679', 10),
(11, '-103.4137998', '20.69137534', 11),
(12, '-103.4056467', '20.67452558', 12),
(13, '-103.3049815', '20.64674113', 13),
(14, '-103.3907316', '20.59664154', 14),
(15, '-102.2936165', '21.89020003', 15),
(16, '-106.4383672', '23.23888689', 16),
(17, '-101.6509596', '21.11860168', 17),
(18, '-101.6949254', '21.15777218', 18),
(19, '-106.1152971', '28.6224644', 19),
(20, '-107.3957476', '24.81660583', 20),
(21, '-103.4115899', '20.71040695', 21),
(22, '-103.4552263', '20.73448244', 22),
(23, '-100.3510581', '25.67966286', 23),
(24, '-100.9815512', '22.15127218', 24),
(25, '-103.4332396', '25.56021591', 25);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`) VALUES
(1, 'Jalisco'),
(2, 'Aguascalientes'),
(3, 'Sinaloa'),
(4, 'Guanajuato'),
(5, 'Chihuahua'),
(6, 'Sinaloa'),
(7, 'Nuevo León'),
(8, 'San Luis Potosí'),
(9, 'Coahuila');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE IF NOT EXISTS `stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `city` int(11) NOT NULL,
  `telephone` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `schedule` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `name`, `address`, `city`, `telephone`, `email`, `schedule`, `notes`) VALUES
(1, 'Sucursal Morelos', 'Morelos # 530.', 1, '(33) 3613-2614, 3613-5100, 3658-2884 ', 'librosbooks@gonvill.com.mx', 'Lunes a Sábado 10:00 a.m. a 8:30 p.m.', 'Domingo Cerrado'),
(2, 'Sucursal Plaza del Sol 1', 'Local 4 Zona F.', 2, '(33) 3122-8697, 3122-0899,  3647-4737', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 10:00 a.m. a 8:30 p.m.', 'Domingos 11:00 a.m. a 8:00 p.m.'),
(3, 'Sucursal López Cotilla', 'López Cotilla # 501.', 1, '(33) 3613-0123,  3658-0041 ', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 10:00 a.m. a 8:30 p.m. ', 'Domingo Cerrado'),
(4, 'Centro de Distribución Nacional', '8 de Julio # 825 Col. Moderna.', 1, '(33) 3837-2300</br><b>Fax:</b>(33)3837-2309', 'librosbooks@gonvill.com.mx', 'Lunes a Viernes 8:00 a.m. a 7:00 p.m. S&aacute;bado 8:00 a.m. a 2:30 p.m.', 'Domingo Cerrado'),
(5, 'Sucursal Juárez', 'Av. Juárez # 305.', 1, '(33) 3614-2856,  3614-9785', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 9:00 a.m. a 8:30 p.m. ', 'Domingos 10:00 a.m. a 7:00 p.m.'),
(6, 'Sucursal Independencia ', 'Independencia # 352.', 1, '(33) 3613-2553,  3658-1063', '', 'Lunes a S&aacute;bado 10:00 a.m. a 8:30 p.m. ', 'Domingos 10:00 a.m. a 6:00 p.m.'),
(7, 'Sucursal Chapultepec ', 'Av. Chapultepec Sur # 150.', 1, '(33) 3616-3060,  3616-3068,  3616-3069 ', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 10:00 a.m. a 8:30 p.m. ', 'Domingos 10:00 a.m. a 3:00 p.m.'),
(8, 'Sucursal Plaza del Sol 2', 'Local 7 Zona G.', 2, '(33) 3647-4486,  3647-5090', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 10:00 a.m. a 8:30 p.m.', 'Domingos 11:00 a.m. a 8:00 p.m.'),
(9, 'Sucursal Plaza Patria', 'Locales 13 y 19 Zona B.', 2, '(33) 3642-8157,  3642-8107', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 10:00 a.m. a 8:30 p.m. ', 'Domingos 11:00 a.m. a 8:00 p.m.'),
(10, 'Sucursal Plaza México ', 'Local 24 Zona A.', 1, '(33) 3813-0296,  3813-3428', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 11:00 a.m. a 8:00 p.m. ', 'Domingos 11:00 a.m. a 8:00 p.m.'),
(11, 'Sucursal Plaza Universidad', 'Locales 5 al 9 Zona B.', 2, '(33) 3610-0887,  3610-0888', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 10:00 a.m. a 8:30 p.m. ', 'Domingo Cerrado'),
(12, 'Sucursal La Gran Plaza', 'Local 20 Zona C.', 1, '(33) 3647-7719,  3647-7727', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 10:00 a.m. a 8:30 p.m. ', 'Domingos 11:00 a.m. a 8:00 p.m.'),
(13, 'Sucursal Plaza Revolución', 'Locales 12, 13 y 21 Zona A.', 3, '(33) 3635-7221,  3639-5985', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 9:00 a.m. a 8:30 p.m. ', 'Domingos 11:00 a.m. a 8:00 p.m.'),
(14, 'Sucursal Centro Sur', 'Local 17 Zona B.', 3, '(33) 3693-6100,  3693-6144', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 11:00 a.m. a 8:30 p.m. ', 'Domingos 10:00 a.m. a 8:00 p.m.'),
(15, 'Centro Comercial Altaria', 'Planta Baja Locales 1032 y 1033. Blvd. A Zacatecas Nte. # 851.', 4, '(449) 912-1523 Â </br><b>Fax:</b> 912-1521', 'ags@gonvill.com.mx', 'Lunes a Jueves 11:00 a.m. a 8:30 p.m. Viernes y S&aacute;bado 11:00 a.m. a 9:00 p.m. ', 'Domingos 11:00 a.m. a 8:00 p.m.'),
(16, 'Centro Comercial Gran Plaza', 'Av.Rreforma s/n, Col. Alameda C.P. 83123. Local 1, Isla S.', 5, '(669) 9900-386, 9837-732', 'mzt@gonvill.com.mx', 'Lunes a S&aacute;bado 10:00 a.m. a 9:00 p.m. ', 'Domingos 11:00 a.m. a 8:00 p.m.'),
(17, 'Sucursal Francisco Villa', 'Blvd. Francisco Villa # 802 Nte. Col. Bugambilias C.P. 37270.', 6, '(477) 771-4708, 771-4709 711-5363.</br><b> Fax:</b> 771-4710', 'leon@gonvill.com.mx', 'Lunes a Viernes 9:00 a.m. a 7:00 p.m. S&aacute;bado 9:00 a.m. a 3:00 p.m. ', 'Domingo Cerrado'),
(18, 'Sucursal Plaza Mayor', 'Av. Las Torres # 2002 Local 1030 y 32. Col. Valle del Campestre C.P. 37150.', 6, '(477) 718-2187.</br><b>Fax:</b> 773-5283', 'leon@gonvill.com.mx', 'Lunes a Jueves 10:00 a.m. a 8:30 p.m.  Viernes y S&aacute;bado 10:00 a.m. a 9:00 p.m. ', 'Domingos 11:00 a.m. a 8:30 p.m.'),
(19, 'Fashion Mall Chihuahua', 'Planta Alta Locales 219-220 Periférico de la Juventud # 3501.', 7, '(614) 430-0256</br><b>Fax:</b> 430-0195', 'chih@gonvill.com.mx', 'Lunes a Domingo 11:00 a.m. a 8:30 p.m. ', ''),
(20, 'Gonvill Culiacán', 'Av. Álvaro Obregón 1686 norte.', 8, '(667) 712-3109, Â 712-3128 </br><b>Fax:</b> 712-29-97', 'cln@gonvill.com.mx', 'Lunes a S&aacute;bado 9:00 a.m. a 8:00 p.m. ', 'Domingo Cerrado'),
(21, 'Sucursal Plaza Andares', 'Local UP66-114.', 2, '(33) 3611-3434, 3611-1889', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 11:00 a.m. a 9:00 p.m. ', 'Domingos 11:00 a.m. a 9:00 p.m.'),
(22, 'Sucursal ITESM Campus GDL', 'Av. General Ramon Corona 2514.', 2, '(33) 1561-0411', 'librosbooks@gonvill.com.mx', 'Lunes a S&aacute;bado 8:00 a.m. a 7:00 p.m. ', 'Domingo Cerrado'),
(23, 'HEB Plaza Real', 'Planta Baja, Local B-10. Av.Gonalitos #315.', 9, '(81) 8333-7034, 8123-1018</br> <b>Fax:</b> 8333-6972', 'mty@gonvill.com.mx', 'Lunes a S&aacute;bado 11:00 a.m. a 8:30 p.m. ', 'Domingos 11:00 a.m. a 7:00 p.m.'),
(24, 'Gonvill San Luis', 'Av. Venustiano Carranza # 500.', 10, '(444) 812-6913, 812-6935 </br> <b>Fax:</b> 812-7399', 'slp@gonvill.com.mx', 'Lunes a S&aacute;bado 10:00 a.m. a 8:30 p.m. ', 'Domingo Cerrado.'),
(25, 'Centro Com. Pza. Cuatro Caminos', 'Blvd. Independencia Ote. # 1300, Col. Navarro C.P. 27010. Planta Baja, Local 124.', 11, '(871) 722-6077</br><b>Fax:</b> 718-3336', 'torreon@gonvill.com.mx', 'Lunes a Domingo 11:00 a.m. a 9:00 p.m. ', NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
