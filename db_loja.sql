-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Jan-2022 às 18:35
-- Versão do servidor: 10.4.17-MariaDB
-- versão do PHP: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_loja`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.categorias`
--

CREATE TABLE `tb_admin.categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `icone` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_admin.categorias`
--

INSERT INTO `tb_admin.categorias` (`id`, `nome`, `icone`, `slug`, `order_id`) VALUES
(1, 'CABO USB', 'fas fa-mobile-alt', 'cabo-usb', 1),
(2, 'INFROMÁTICA', 'fas fa-laptop', 'informatica ', 2),
(3, 'GAMES', 'fas fa-gamepad', 'games', 3),
(4, 'CARREGADOR', 'fas fa-tv', 'carregador', 4),
(14, 'OFERTAS', 'fas fa-percent', 'ofertas', 14);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.configuracoes`
--

CREATE TABLE `tb_admin.configuracoes` (
  `id` int(11) NOT NULL,
  `tipo` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `conteudo` varchar(512) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_inicial` int(11) NOT NULL,
  `id_final` int(11) DEFAULT NULL,
  `valor` decimal(10,2) NOT NULL DEFAULT 0.00,
  `formato` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `dias` int(11) DEFAULT NULL,
  `ativo` int(1) NOT NULL DEFAULT 1,
  `modificado` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.contabilidade`
--

CREATE TABLE `tb_admin.contabilidade` (
  `id` int(11) NOT NULL,
  `imposto` int(11) NOT NULL,
  `funcionarios` decimal(10,2) NOT NULL,
  `fixos` decimal(10,2) NOT NULL,
  `publicidade` decimal(10,2) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_admin.contabilidade`
--

INSERT INTO `tb_admin.contabilidade` (`id`, `imposto`, `funcionarios`, `fixos`, `publicidade`, `data`) VALUES
(1, 6, '0.00', '50.00', '0.00', '2021-08-01'),
(2, 6, '0.00', '50.00', '0.00', '2021-08-02'),
(3, 6, '0.00', '50.00', '0.00', '2021-08-03'),
(4, 6, '0.00', '50.00', '0.00', '2021-08-04'),
(5, 6, '0.00', '50.00', '0.00', '2021-08-05'),
(6, 6, '0.00', '50.00', '0.00', '2021-08-06'),
(7, 6, '0.00', '50.00', '0.00', '2021-08-07'),
(8, 6, '0.00', '50.00', '0.00', '2021-08-08'),
(9, 6, '0.00', '50.00', '0.00', '2021-08-09'),
(10, 6, '0.00', '50.00', '0.00', '2021-08-10'),
(11, 6, '0.00', '50.00', '0.00', '2021-08-11'),
(12, 6, '0.00', '50.00', '0.00', '2021-08-12'),
(13, 6, '0.00', '50.00', '0.00', '2021-08-13'),
(14, 6, '0.00', '50.00', '0.00', '2021-08-14'),
(15, 6, '0.00', '50.00', '10.00', '2021-08-15'),
(16, 6, '0.00', '50.00', '0.00', '2021-08-16'),
(17, 6, '0.00', '50.00', '0.00', '2021-08-17'),
(18, 6, '0.00', '50.00', '0.00', '2021-08-18'),
(19, 6, '0.00', '50.00', '0.00', '2021-08-19'),
(20, 6, '0.00', '50.00', '0.00', '2021-08-20'),
(21, 6, '0.00', '50.00', '0.00', '2021-08-21'),
(22, 6, '0.00', '50.00', '0.00', '2021-08-22'),
(23, 6, '0.00', '50.00', '0.00', '2021-08-23'),
(24, 6, '0.00', '50.00', '0.00', '2021-08-24'),
(25, 6, '0.00', '50.00', '0.00', '2021-08-25'),
(26, 6, '0.00', '50.00', '0.00', '2021-08-26'),
(27, 6, '0.00', '50.00', '0.00', '2021-08-27'),
(28, 6, '0.00', '50.00', '0.00', '2021-08-28'),
(29, 6, '0.00', '50.00', '15.00', '2021-08-29'),
(30, 6, '0.00', '50.00', '0.00', '2021-08-30'),
(31, 6, '0.00', '50.00', '0.00', '2021-08-31'),
(32, 12, '0.00', '510.00', '0.00', '2021-07-01'),
(33, 12, '0.00', '510.00', '0.00', '2021-07-02'),
(34, 12, '0.00', '510.00', '0.00', '2021-07-03'),
(35, 12, '0.00', '510.00', '0.00', '2021-07-04'),
(36, 12, '0.00', '510.00', '0.00', '2021-07-05'),
(37, 12, '0.00', '510.00', '0.00', '2021-07-06'),
(38, 12, '0.00', '510.00', '0.00', '2021-07-07'),
(39, 12, '0.00', '510.00', '0.00', '2021-07-08'),
(40, 12, '0.00', '510.00', '0.00', '2021-07-09'),
(41, 12, '0.00', '510.00', '0.00', '2021-07-10'),
(42, 12, '0.00', '510.00', '0.00', '2021-07-11'),
(43, 12, '0.00', '510.00', '0.00', '2021-07-12'),
(44, 12, '0.00', '510.00', '0.00', '2021-07-13'),
(45, 12, '0.00', '510.00', '0.00', '2021-07-14'),
(46, 12, '0.00', '510.00', '0.00', '2021-07-15'),
(47, 12, '0.00', '510.00', '0.00', '2021-07-16'),
(48, 12, '0.00', '510.00', '0.00', '2021-07-17'),
(49, 12, '0.00', '510.00', '0.00', '2021-07-18'),
(50, 12, '0.00', '510.00', '0.00', '2021-07-19'),
(51, 12, '0.00', '510.00', '0.00', '2021-07-20'),
(52, 12, '0.00', '510.00', '0.00', '2021-07-21'),
(53, 12, '0.00', '510.00', '0.00', '2021-07-22'),
(54, 12, '0.00', '510.00', '0.00', '2021-07-23'),
(55, 12, '0.00', '510.00', '0.00', '2021-07-24'),
(56, 12, '0.00', '510.00', '0.00', '2021-07-25'),
(57, 12, '0.00', '510.00', '0.00', '2021-07-26'),
(58, 12, '0.00', '510.00', '0.00', '2021-07-27'),
(59, 12, '0.00', '510.00', '0.00', '2021-07-28'),
(60, 12, '0.00', '510.00', '0.00', '2021-07-29'),
(61, 12, '0.00', '510.00', '0.00', '2021-07-30'),
(62, 12, '0.00', '510.00', '0.00', '2021-07-31'),
(63, 6, '0.00', '20.00', '0.00', '2021-12-01'),
(64, 6, '0.00', '20.00', '0.00', '2021-12-02'),
(65, 6, '0.00', '20.00', '0.00', '2021-12-03'),
(66, 6, '0.00', '20.00', '0.00', '2021-12-04'),
(67, 6, '0.00', '20.00', '0.00', '2021-12-05'),
(68, 6, '0.00', '20.00', '0.00', '2021-12-06'),
(69, 6, '0.00', '20.00', '0.00', '2021-12-07'),
(70, 6, '0.00', '20.00', '0.00', '2021-12-08'),
(71, 6, '0.00', '20.00', '0.00', '2021-12-09'),
(72, 6, '0.00', '20.00', '0.00', '2021-12-10'),
(73, 6, '0.00', '20.00', '0.00', '2021-12-11'),
(74, 6, '0.00', '20.00', '0.00', '2021-12-12'),
(75, 6, '0.00', '20.00', '0.00', '2021-12-13'),
(76, 6, '0.00', '20.00', '0.00', '2021-12-14'),
(77, 6, '0.00', '20.00', '0.00', '2021-12-15'),
(78, 6, '0.00', '20.00', '0.00', '2021-12-16'),
(79, 6, '0.00', '20.00', '0.00', '2021-12-17'),
(80, 6, '0.00', '20.00', '0.00', '2021-12-18'),
(81, 6, '0.00', '20.00', '0.00', '2021-12-19'),
(82, 6, '0.00', '20.00', '0.00', '2021-12-20'),
(83, 6, '0.00', '20.00', '0.00', '2021-12-21'),
(84, 6, '0.00', '20.00', '0.00', '2021-12-22'),
(85, 6, '0.00', '20.00', '0.00', '2021-12-23'),
(86, 6, '0.00', '20.00', '0.00', '2021-12-24'),
(87, 6, '0.00', '20.00', '0.00', '2021-12-25'),
(88, 6, '0.00', '20.00', '0.00', '2021-12-26'),
(89, 6, '0.00', '20.00', '0.00', '2021-12-27'),
(90, 6, '0.00', '20.00', '0.00', '2021-12-28'),
(91, 6, '0.00', '20.00', '0.00', '2021-12-29'),
(92, 6, '0.00', '20.00', '0.00', '2021-12-30'),
(93, 6, '0.00', '20.00', '2.00', '2021-12-31');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.controle_logs`
--

CREATE TABLE `tb_admin.controle_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `onde` varchar(255) NOT NULL,
  `acao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.cupom`
--

CREATE TABLE `tb_admin.cupom` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.entrega`
--

CREATE TABLE `tb_admin.entrega` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.estoque`
--

CREATE TABLE `tb_admin.estoque` (
  `id` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `id_subcategoria` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `codigo` varchar(100) NOT NULL,
  `video` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `quantidade` int(11) NOT NULL,
  `vendido` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `preco_venda` decimal(10,2) NOT NULL,
  `altura` varchar(200) NOT NULL,
  `largura` varchar(200) NOT NULL,
  `comprimento` varchar(200) NOT NULL,
  `peso` varchar(200) NOT NULL,
  `custo` decimal(10,2) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_admin.estoque`
--

INSERT INTO `tb_admin.estoque` (`id`, `id_categoria`, `id_subcategoria`, `nome`, `codigo`, `video`, `descricao`, `quantidade`, `vendido`, `preco`, `preco_venda`, `altura`, `largura`, `comprimento`, `peso`, `custo`, `data_cadastro`, `slug`) VALUES
(6, 1, 0, 'Cabo USB Tipo - C Inova Original', 'RA12', '', '<p>Cabo De Dados Tipo - C Inova Original</p><p>-&gt; Leia com Aten&ccedil;&atilde;o&nbsp;</p><p>Cores dispon&iacute;vel&nbsp;<br />3 Vermelhas<br />7 Pretos<br />CABO REFOR&Ccedil;ADO!</p><p><br />ESPECIFICA&Ccedil;&Otilde;ES:</p><p>- Anti Interfer&ecirc;ncia;<br />- Compat&iacute;vel com todas as vers&otilde;es USB;<br />- Carregamento r&aacute;pido e seguro;<br />- Est&aacute;vel, resistente, vida &uacute;til prolongada;<br />- Total compatibilidade com v&aacute;rios dispositivos;<br />- Leve e port&aacute;til.</p><p>- Comprimento: 1 metro<br />- Marca: Inova<br />- Cores sortidas (Enviaremos cores sortidas) !!!<br />- Cabo 100% NOVO e embalado.</p><p>- Pronto para utiliza&ccedil;&atilde;o!<br />- Garantia contra defeito de fabrica&ccedil;&atilde;o!<br />- Imagens meramente ilustrativas!</p>', 15, 1, '18.00', '15.00', '6', '11', '16', '0.88', '6.50', '2021-09-25 00:00:00', 'cabo-usb-tipo-c-inova-original');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.estoque_imagens`
--

CREATE TABLE `tb_admin.estoque_imagens` (
  `id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_admin.estoque_imagens`
--

INSERT INTO `tb_admin.estoque_imagens` (`id`, `produto_id`, `imagem`) VALUES
(17, 6, 'cabo_inova.png'),
(20, 6, 'cabo_inova2.png'),
(21, 6, 'cabo_inova3.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.financeiro`
--

CREATE TABLE `tb_admin.financeiro` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.pedidos_envios`
--

CREATE TABLE `tb_admin.pedidos_envios` (
  `pedido_id` int(11) NOT NULL,
  `impresso` datetime DEFAULT NULL,
  `entregue` int(1) NOT NULL DEFAULT 0,
  `informacao` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dataInformacao` datetime NOT NULL,
  `contato` int(1) NOT NULL DEFAULT 0,
  `atualizacao` datetime DEFAULT NULL,
  `data_contato` datetime DEFAULT NULL,
  `observacao` varchar(1024) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.produto_variante`
--

CREATE TABLE `tb_admin.produto_variante` (
  `id` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `referenca` varchar(200) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.subcategoria`
--

CREATE TABLE `tb_admin.subcategoria` (
  `id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.usuario`
--

CREATE TABLE `tb_admin.usuario` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_admin.usuario`
--

INSERT INTO `tb_admin.usuario` (`id`, `user`, `senha`, `img`, `nome`, `cargo`) VALUES
(1, 'rubens', '$2y$10$5SyEFOy2lfme7V9BE1/0buIS31Tq6NpadtUzOCT0Gv13p43HYMXJi', '614f4552cc573.jpg', 'Rubens Nogueira', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente.depoimentos_loja`
--

CREATE TABLE `tb_cliente.depoimentos_loja` (
  `id` int(11) NOT NULL,
  `id_loja` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `depoimento` text NOT NULL,
  `data` datetime NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente.depoimentos_produto`
--

CREATE TABLE `tb_cliente.depoimentos_produto` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `depoimento` text NOT NULL,
  `data` datetime NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente.endereco`
--

CREATE TABLE `tb_cliente.endereco` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `rua` varchar(100) NOT NULL,
  `complemento` varchar(200) NOT NULL,
  `numero` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_cliente.endereco`
--

INSERT INTO `tb_cliente.endereco` (`id`, `id_cliente`, `cep`, `estado`, `cidade`, `bairro`, `rua`, `complemento`, `numero`) VALUES
(1, 4, '04340-130', 'SP', 'São Paulo', 'Jardim Bom Clima', 'Rua José Vilas Boas', '', 227);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente.informacoes`
--

CREATE TABLE `tb_cliente.informacoes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(20) NOT NULL,
  `senha` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_cliente.informacoes`
--

INSERT INTO `tb_cliente.informacoes` (`id`, `nome`, `sobrenome`, `email`, `cpf`, `senha`) VALUES
(1, 'Rubens', 'Nogueira', 'rubens@gg.com', '065.672.195-21', '$2y$10$5SyEFOy2lfme7V9BE1/0buIS31Tq6NpadtUzOCT0Gv13p43HYMXJi'),
(2, 'Rubens', 'Nogueira', 'rubens.jesus1997@gmail.com', '16585151020', '$2y$10$.Fmyzgu/CuQoGZodxJ2ktuhC.zYtt2fg80VeFq95U8x8CxTMAVNlG'),
(3, 'Rubens', 'Nogueira', 'rubens12@gmail.com', '130.353.150-00', '$2y$10$Enh3tXKfmrBSs6xRDTuYc.2Twk7NdDYbwBgj56lwNfl3eOlWIE.Tm'),
(4, 'Caique', 'Silva', 'caique@gmail.com', '160.382.710-23', '$2y$10$.rUgBLntEn7pAhKM0vwxXOvXAg/kXnhn8aNLk1ldFxx7vs6qlDys6'),
(5, 'Bruna', 'Santos', 'bruna@gmail.com', '', '$2y$10$febFYbLgOKyVjYMTVGUwNOMtYe7MuQrOUCoOZ5Q8JX1MWzr/Vt9M.'),
(6, 'Joana', 'Jesus', 'joana@gmail.com', '', '$2y$10$XQRzE1xM0JFXemFAGtVxTutnCLFGTZIPJG32N5qnbUjaEeZJk8CPK'),
(7, 'Francisco', 'Sova', 'francisco@gmail.com', '', '$2y$10$FAhccrm1.saVsqmCAYpMQ.jnlm/FemC9.rt3KmRpDjmwtZwGGPm.O'),
(8, 'Carlos', 'Santos', 'carlos@gmail.com', '', '$2y$10$H1bNpVgdTWriP.mdiFGlLeJ2c7GCJMNrR5h7JYtDliwBH90Egdy66');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente.pedidos`
--

CREATE TABLE `tb_cliente.pedidos` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_endereco` int(11) NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `external_ref` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `status_interno` varchar(100) NOT NULL,
  `criado` datetime NOT NULL,
  `modificado` datetime NOT NULL,
  `tipo_frete` varchar(20) NOT NULL,
  `valor_frete` decimal(10,2) NOT NULL,
  `rastreio` varchar(200) NOT NULL,
  `forma_pagamento` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_cliente.pedidos`
--

INSERT INTO `tb_cliente.pedidos` (`id`, `id_cliente`, `id_endereco`, `valor_total`, `external_ref`, `status`, `status_interno`, `criado`, `modificado`, `tipo_frete`, `valor_frete`, `rastreio`, `forma_pagamento`) VALUES
(2, 2, 0, '40.99', '', 0, '', '2021-07-11 13:23:01', '2021-07-11 13:23:01', 'PAC', '21.00', 'GLI1254', 'mercadopago'),
(3, 1, 0, '162.43', '', 0, '', '2021-07-14 18:17:09', '2021-07-14 18:17:09', 'SEDEX', '22.50', 'TEST123', 'mercadopago'),
(4, 2, 0, '120.95', '', 0, '', '2021-07-15 21:34:20', '2021-07-15 21:34:20', 'PAC', '21.00', '', 'mercadopago'),
(5, 2, 0, '180.92', '', 0, '', '2021-07-15 21:34:36', '2021-07-15 21:34:36', 'PAC', '21.00', '', 'mercadopago'),
(6, 2, 0, '40.99', '1972384598387', 0, '', '2021-08-15 16:09:09', '2021-08-15 16:09:09', 'SEDEX', '21.00', '', 'mercadopago'),
(7, 2, 0, '40.99', '3581405875670', 0, '', '2021-08-29 10:47:26', '2021-08-29 10:47:26', 'SEDEX', '21.00', '', 'mercadopago'),
(8, 2, 0, '60.98', '8321191991331', 0, '', '2021-08-29 10:49:15', '2021-08-29 10:49:15', 'SEDEX', '21.00', 'GLI1236', 'mercadopago'),
(9, 2, 0, '40.99', '50315249234', 0, '', '2021-08-29 10:50:01', '2021-08-29 10:50:01', 'SEDEX', '21.00', '', 'mercadopago'),
(10, 4, 1, '37.50', '8080085583699', 0, '', '2021-12-31 13:17:24', '2021-12-31 13:17:24', 'SEDEX', '22.50', '', 'mercadopago');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente.produto_pedido`
--

CREATE TABLE `tb_cliente.produto_pedido` (
  `id` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_produto` int(11) NOT NULL,
  `qtd` int(11) NOT NULL,
  `separado` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `tb_cliente.produto_pedido`
--

INSERT INTO `tb_cliente.produto_pedido` (`id`, `id_pedido`, `id_produto`, `qtd`, `separado`) VALUES
(1, 1, 6, 1, 0),
(2, 2, 6, 1, 0),
(3, 3, 6, 7, 0),
(4, 4, 6, 5, 0),
(5, 5, 6, 8, 0),
(6, 6, 6, 1, 0),
(7, 7, 6, 1, 0),
(8, 8, 6, 2, 0),
(9, 9, 6, 1, 0),
(10, 10, 6, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente.recover_solicitado`
--

CREATE TABLE `tb_cliente.recover_solicitado` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `rash` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `tb_admin.categorias`
--
ALTER TABLE `tb_admin.categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.configuracoes`
--
ALTER TABLE `tb_admin.configuracoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.contabilidade`
--
ALTER TABLE `tb_admin.contabilidade`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.controle_logs`
--
ALTER TABLE `tb_admin.controle_logs`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.cupom`
--
ALTER TABLE `tb_admin.cupom`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.entrega`
--
ALTER TABLE `tb_admin.entrega`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.estoque`
--
ALTER TABLE `tb_admin.estoque`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.estoque_imagens`
--
ALTER TABLE `tb_admin.estoque_imagens`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.financeiro`
--
ALTER TABLE `tb_admin.financeiro`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.produto_variante`
--
ALTER TABLE `tb_admin.produto_variante`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.subcategoria`
--
ALTER TABLE `tb_admin.subcategoria`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_admin.usuario`
--
ALTER TABLE `tb_admin.usuario`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_cliente.depoimentos_loja`
--
ALTER TABLE `tb_cliente.depoimentos_loja`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_cliente.depoimentos_produto`
--
ALTER TABLE `tb_cliente.depoimentos_produto`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_cliente.endereco`
--
ALTER TABLE `tb_cliente.endereco`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_cliente.informacoes`
--
ALTER TABLE `tb_cliente.informacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_cliente.pedidos`
--
ALTER TABLE `tb_cliente.pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `tb_cliente.produto_pedido`
--
ALTER TABLE `tb_cliente.produto_pedido`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `tb_admin.categorias`
--
ALTER TABLE `tb_admin.categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `tb_admin.configuracoes`
--
ALTER TABLE `tb_admin.configuracoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_admin.contabilidade`
--
ALTER TABLE `tb_admin.contabilidade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT de tabela `tb_admin.controle_logs`
--
ALTER TABLE `tb_admin.controle_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_admin.cupom`
--
ALTER TABLE `tb_admin.cupom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_admin.entrega`
--
ALTER TABLE `tb_admin.entrega`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_admin.estoque`
--
ALTER TABLE `tb_admin.estoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `tb_admin.estoque_imagens`
--
ALTER TABLE `tb_admin.estoque_imagens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de tabela `tb_admin.financeiro`
--
ALTER TABLE `tb_admin.financeiro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_admin.produto_variante`
--
ALTER TABLE `tb_admin.produto_variante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_admin.subcategoria`
--
ALTER TABLE `tb_admin.subcategoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tb_admin.usuario`
--
ALTER TABLE `tb_admin.usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_cliente.depoimentos_loja`
--
ALTER TABLE `tb_cliente.depoimentos_loja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_cliente.depoimentos_produto`
--
ALTER TABLE `tb_cliente.depoimentos_produto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `tb_cliente.endereco`
--
ALTER TABLE `tb_cliente.endereco`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tb_cliente.informacoes`
--
ALTER TABLE `tb_cliente.informacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `tb_cliente.pedidos`
--
ALTER TABLE `tb_cliente.pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `tb_cliente.produto_pedido`
--
ALTER TABLE `tb_cliente.produto_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
