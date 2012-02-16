--
-- Banco de Dados: `locadora`
--
CREATE DATABASE `locadora_renan` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `locadora_renan`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `dtnasc` date NOT NULL,
  `cpf` char(11) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `bairro` varchar(40) NOT NULL,
  `telefone` char(13) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
