-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 30, 2015 at 11:23 AM
-- Server version: 5.5.40-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `primescan`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sender_signature` varchar(255) DEFAULT NULL,
  `sender_namespace` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

CREATE TABLE IF NOT EXISTS `attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `attachment_url_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_attachment_url_id` (`attachment_url_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `branch`
--

CREATE TABLE IF NOT EXISTS `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `points` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `address` text,
  `created_at` date DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `points`, `owner_name`, `mobile_number`, `address`, `created_at`, `email_id`) VALUES
(1, 'Default', '500000', 'Xavoc Technocrats', '+91 8875191258', '18/436 Gayatri Marg, Kanji Ka Hata, Dhabai Ji Ka Wada, udaipur', '2011-12-12', 'info@xavoc.com');

-- --------------------------------------------------------

--
-- Table structure for table `developerZone_editor_tools`
--

CREATE TABLE IF NOT EXISTS `developerZone_editor_tools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `template` varchar(255) DEFAULT NULL,
  `is_output_multibranch` tinyint(1) DEFAULT NULL,
  `special_php_handler` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `order` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `instance_ports` text,
  `is_for_editor` tinyint(1) DEFAULT NULL,
  `js_widget` varchar(255) DEFAULT NULL,
  `can_add_ports` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `developerZone_editor_tools`
--

INSERT INTO `developerZone_editor_tools` (`id`, `category`, `name`, `template`, `is_output_multibranch`, `special_php_handler`, `icon`, `order`, `type`, `instance_ports`, `is_for_editor`, `js_widget`, `can_add_ports`) VALUES
(1, 'General', 'Code Block', '// _name_  \\n \\t _code_  \\n\\t  // _name_', NULL, NULL, 'fa fa-users fa-2x', NULL, 'Process', '[]', 1, 'CodeBlock', 1),
(3, 'General', 'ConnectorPort', NULL, NULL, NULL, 'port fa fa-play ', NULL, 'in-out', NULL, 0, 'Port', 0),
(5, 'General', 'A>B ?', 'if( _port_A_ > _port_B) {\\n \\t _branch_true_code_ \\n\\t} else  { \\n\\t  _branch_false_code \\n\\t}', NULL, 'If', 'fa fa-cog fa-2x', NULL, 'PHPFunc', '[{"type":"DATA-IN","name":"A","mandatory":"YES","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"B","mandatory":"YES","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"true","creates_block":"TRUE_BLOCK","caption":""},{"type":"DATA-OUT","name":"false","creates_block":"FALSE_BLOCK","caption":""}]', 0, 'Node', 0),
(6, 'General', 'Variable', '$_name_ = _name_', NULL, 'Variable', NULL, NULL, 'PHPFunc', '[{"type":"DATA-OUT","name":"value","creates_block":"NO","caption":""}]', NULL, 'Node', 0),
(7, 'General', 'ForEach', 'foreach ( \\n\\t $_port_items_name_ as $_port_key_name_ => $_port_value_name_) { _branch_value_code_ }', NULL, 'Foreach', NULL, NULL, 'PHPFunc', '[{"type":"DATA-IN","name":"A","mandatory":"YES","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"B","mandatory":"YES","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"key","creates_block":"FOREACH_BLOCK","caption":""},{"type":"DATA-OUT","name":"values","creates_block":"FOREACH_BLOCK","caption":""}]', NULL, 'Node', 0),
(8, 'General', 'Method Call', NULL, NULL, 'method_call', 'fa fa-calendar fa-2x', NULL, 'PHPFunc', '[]', NULL, 'MethodCall', 0);

-- --------------------------------------------------------

--
-- Table structure for table `developerZone_entities`
--

CREATE TABLE IF NOT EXISTS `developerZone_entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `parent_class` varchar(255) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `is_class` tinyint(4) DEFAULT NULL,
  `instance_ports` text,
  `is_framework_class` tinyint(4) DEFAULT NULL,
  `js_widget` varchar(255) DEFAULT NULL,
  `css_class` varchar(255) DEFAULT NULL,
  `code_structure` text,
  PRIMARY KEY (`id`),
  KEY `fk_component_id` (`component_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `developerZone_entities`
--

INSERT INTO `developerZone_entities` (`id`, `component_id`, `name`, `type`, `table_name`, `parent_class`, `owner_id`, `is_class`, `instance_ports`, `is_framework_class`, `js_widget`, `css_class`, `code_structure`) VALUES
(1, NULL, 'AbstractObject', 'Object', NULL, NULL, NULL, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', NULL, '{"name":"init","class":"View","attributes":[],"Method":[{"name":"destroy","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"recursive","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"}},"Nodes":[],"Connections":[],"left":62,"top":51,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"removeElement","uuid":"4","type":"Method","Ports":{"1":{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":312,"top":20,"width":214,"height":157,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"getElement","uuid":"8","type":"Method","Ports":{"1":{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":599,"top":21,"width":255,"height":137,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"hasElement","uuid":"12","type":"Method","Ports":{"1":{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":20,"top":195,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"rename","uuid":"16","type":"Method","Ports":{"1":{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":276,"top":195,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setModel","uuid":"20","type":"Method","Ports":{"1":{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":540,"top":199,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"memorize","uuid":"28","type":"Method","Ports":{"1":{"type":"In","name":"key","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"3":{"type":"Out","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":27,"top":336,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"recall","uuid":"47","type":"Method","Ports":{"1":{"type":"In","name":"key","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"default","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":296,"top":333,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"1"}'),
(2, NULL, 'Test', 'View', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, '{"name":"init","class":"View","attributes":[],"Method":[{"name":"init","uuid":"1","type":"Method","Ports":[],"Nodes":[{"name":"1.1","uuid":"3","type":"PHPFunc","js_widget":"Node","Ports":[{"uuid":"4","type":"in-out","name":"Flow","left":0,"top":0,"creates_block":false},{"type":"DATA-OUT","name":"value","creates_block":"NO","caption":"","uuid":"5"}],"Nodes":[],"Connections":[],"top":29,"left":35,"width":100,"height":50,"tool_id":6,"ports_obj":[]},{"name":"2.2","uuid":"6","type":"PHPFunc","js_widget":"Node","Ports":[{"uuid":"7","type":"in-out","name":"Flow","left":0,"top":0,"creates_block":false},{"type":"DATA-OUT","name":"value","creates_block":"NO","caption":"","uuid":"8"}],"Nodes":[],"Connections":[],"top":147,"left":41,"width":100,"height":50,"tool_id":6,"ports_obj":[]},{"name":"ABCD","uuid":"9","type":"PHPFunc","js_widget":"Node","Ports":[{"uuid":"10","type":"in-out","name":"Flow","left":0,"top":0,"creates_block":false},{"type":"DATA-IN","name":"A","mandatory":"YES","caption":"","is_singlaton":"YES","uuid":"11"},{"type":"DATA-IN","name":"B","mandatory":"YES","caption":"","is_singlaton":"YES","uuid":"12"},{"type":"DATA-OUT","name":"true","creates_block":"TRUE_BLOCK","caption":"","uuid":"13"},{"type":"DATA-OUT","name":"false","creates_block":"FALSE_BLOCK","caption":"","uuid":"14"}],"Nodes":[],"Connections":[],"top":29,"left":230,"width":119,"height":94,"tool_id":5,"ports_obj":[]},{"name":"Variable","uuid":"15","type":"PHPFunc","js_widget":"Node","Ports":[{"uuid":"16","type":"in-out","name":"Flow","left":0,"top":0,"creates_block":false},{"type":"DATA-OUT","name":"value","creates_block":"NO","caption":"","uuid":"17"}],"Nodes":[],"Connections":[],"top":20,"left":414,"width":100,"height":50,"tool_id":6,"ports_obj":[]},{"name":"Variable","uuid":"18","type":"PHPFunc","js_widget":"Node","Ports":[{"uuid":"19","type":"in-out","name":"Flow","left":0,"top":0,"creates_block":false},{"type":"DATA-OUT","name":"value","creates_block":"NO","caption":"","uuid":"20"}],"Nodes":[],"Connections":[],"top":119,"left":420,"width":79,"height":39,"tool_id":6,"ports_obj":[]},{"name":"Variable","uuid":"21","type":"PHPFunc","js_widget":"Node","Ports":[{"uuid":"22","type":"in-out","name":"Flow","left":0,"top":0,"creates_block":false},{"type":"DATA-OUT","name":"value","creates_block":"NO","caption":"","uuid":"23"}],"Nodes":[],"Connections":[],"top":61,"left":588.00001525879,"width":100,"height":50,"tool_id":6,"ports_obj":[]},{"name":"AbstractObject","uuid":"29","type":"Object","js_widget":"Node","Ports":[{"uuid":"30","type":"in-out","name":"Flow","left":0,"top":0,"creates_block":false},{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES","uuid":"31"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES","uuid":"32"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES","uuid":"33"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES","uuid":"34"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":"","uuid":"35"}],"Nodes":[],"Connections":[],"top":195,"left":586,"width":135,"height":61,"entity_id":1,"is_framework_class":0,"css_class":"","ports_obj":[]},{"name":"Process","uuid":"44","type":"Process","Ports":[{"uuid":"45","type":"in-out","name":"Flow","left":0,"top":0,"width":0,"height":0,"creates_block":false},{"uuid":"46","type":"in-out","name":"sadsad","mandatory":false,"is_singlaton":false,"left":0,"top":0,"creates_block":false,"default_value":""}],"Nodes":[{"name":"Variable","uuid":"47","type":"PHPFunc","js_widget":"Node","Ports":[{"uuid":"48","type":"in-out","name":"Flow","left":0,"top":0,"creates_block":false},{"type":"DATA-OUT","name":"value","creates_block":"NO","caption":"","uuid":"49"}],"Nodes":[],"Connections":[],"top":33,"left":40,"width":100,"height":50,"tool_id":6,"ports_obj":[]}],"Connections":[],"left":57,"top":263,"width":265,"height":158,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setModel","uuid":"36","type":"PHPFunc","js_widget":"MethodCall","Ports":[{"type":"DATA-IN","name":"obj\\/this","mandatory":"NO","caption":"","is_singlaton":"NO","uuid":"37"},{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"","uuid":"50"},{"type":"Out","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"","uuid":"51"}],"Nodes":[],"Connections":[],"top":322,"left":450,"width":267,"height":96,"tool_id":8,"ports_obj":[],"method_list":{"setModel":[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"","uuid":"50"},{"type":"Out","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"","uuid":"51"}],"memorize":[{"type":"In","name":"key","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"","uuid":"52"},{"type":"In","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"","uuid":"53"},{"type":"Out","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"","uuid":"54"}],"recall":[{"type":"In","name":"key","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"default","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}],"getElement":[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}],"hasElement":[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}],"rename":[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}],"destroy":[{"type":"In","name":"recursive","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"}],"removeElement":[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]}},{"name":"Variable","uuid":"40","type":"PHPFunc","js_widget":"Node","Ports":[{"uuid":"41","type":"in-out","name":"Flow","left":0,"top":0,"creates_block":false},{"type":"DATA-OUT","name":"value","creates_block":"NO","caption":"","uuid":"42"}],"Nodes":[],"Connections":[],"top":424,"left":757,"width":100,"height":50,"tool_id":6,"ports_obj":[]}],"Connections":[{"sourceId":"xxep_5","sourceParentId":"3","targetId":"xxep_11","taggetParentId":"9"},{"sourceId":"xxep_8","sourceParentId":"6","targetId":"xxep_12","taggetParentId":"9"},{"sourceId":"xxep_14","sourceParentId":"9","targetId":"xxep_16","taggetParentId":"15"},{"sourceId":"xxep_13","sourceParentId":"9","targetId":"xxep_19","taggetParentId":"18"},{"sourceId":"xxep_17","sourceParentId":"15","targetId":"xxep_22","taggetParentId":"21"},{"sourceId":"xxep_20","sourceParentId":"18","targetId":"xxep_22","taggetParentId":"21"},{"sourceId":"xxep_35","sourceParentId":"29","targetId":"xxep_41","taggetParentId":"40"},{"sourceId":"xxep_23","sourceParentId":"21","targetId":"xxep_30","taggetParentId":"29"},{"sourceId":"xxep_49","sourceParentId":"47","targetId":"xxep_46","taggetParentId":"44"},{"sourceId":"xxep_35","sourceParentId":"29","targetId":"xxep_37","taggetParentId":"36"}],"left":23,"top":65.5,"width":987,"height":559,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"2"}'),
(3, NULL, 'AbstractView', 'Object', NULL, NULL, 1, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"setModel","uuid":"1","type":"Method","Ports":[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"actual_fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}],"Nodes":[],"Connections":[],"left":31.16667175293,"top":20,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"getHTML","uuid":"9","type":"Method","Ports":{"1":{"type":"In","name":"destroy","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"},"2":{"type":"In","name":"execute_js","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"},"3":{"type":"Out","name":"html","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":330.58334350586,"top":20,"width":213,"height":127,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"js","uuid":"14","type":"Method","Ports":{"1":{"type":"In","name":"when","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"In","name":"code","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"instance","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"Out","name":"jQuery_Chain","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":613.69998168945,"top":20,"width":244,"height":138,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"3"}'),
(4, NULL, 'AbstractModel', 'Object', NULL, NULL, 1, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', NULL),
(5, NULL, 'AbstractController', 'Object', NULL, NULL, 1, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', NULL),
(6, NULL, 'Page', 'Object', NULL, NULL, 3, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', NULL),
(7, NULL, 'View', 'Object', NULL, NULL, 3, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"setElement","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"element","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":36,"top":50,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setAttr","uuid":"5","type":"Method","Ports":{"1":{"type":"In","name":"attribute","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":310,"top":43,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setClass","uuid":"10","type":"Method","Ports":{"1":{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":588,"top":32,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addClass","uuid":"14","type":"Method","Ports":{"1":{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":34,"top":189,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setStyle","uuid":"15","type":"Method","Ports":{"1":{"type":"In","name":"property","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"style","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":304,"top":180,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addStyle","uuid":"20","type":"Method","Ports":{"1":{"type":"In","name":"property","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"style","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":567,"top":178,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"set","uuid":"25","type":"Method","Ports":{"1":{"type":"In","name":"text","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":43,"top":327,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setText","uuid":"29","type":"Method","Ports":{"1":{"type":"In","name":"text","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":307,"top":321,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setHTML","uuid":"33","type":"Method","Ports":{"1":{"type":"In","name":"html","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":592,"top":328,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"7"}'),
(8, NULL, 'Model', 'Object', NULL, NULL, 4, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"addField","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":22.933334350586,"top":20,"width":121,"height":65,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addExpression","uuid":"6","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"expression","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"3":{"type":"In","name":"field_class","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"4":{"type":"Out","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":236.39999389648,"top":20.116668701172,"width":104,"height":80,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"set","uuid":"12","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"3":{"type":"Out","name":"mix","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":382.05001831055,"top":20,"width":42,"height":65,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"get","uuid":"17","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"data","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":358.46667480469,"top":116.58332824707,"width":80,"height":64,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"getGroupField","uuid":"21","type":"Method","Ports":{"1":{"type":"In","name":"group","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"all"},"2":{"type":"Out","name":"array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":632.8166809082,"top":113.81666564941,"width":89,"height":81,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setActualFields","uuid":"25","type":"Method","Ports":{"1":{"type":"In","name":"group","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"2":{"type":"Out","name":"array the actual fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":579.69998168945,"top":20,"width":96,"height":76,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"getActualFields","uuid":"29","type":"Method","Ports":{"1":{"type":"Out","name":"array the actual fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":496.35000610352,"top":114.93333435059,"width":72,"height":72,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"getTitleField","uuid":"32","type":"Method","Ports":{"1":{"type":"Out","name":"string the title field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":712.69998168945,"top":20,"width":77,"height":79,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setDirty","uuid":"35","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":359.58334350586,"top":212.58332824707,"width":54,"height":75,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"isDirty","uuid":"39","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"bool","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":195.58334350586,"top":117.58332824707,"width":94,"height":66,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setSource","uuid":"44","type":"Method","Ports":{"1":{"type":"In","name":"controller","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"table","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":205.05000305176,"top":197.05000305176,"width":88,"height":80,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"load","uuid":"50","type":"Method","Ports":{"1":{"type":"In","name":"id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":285.39999389648,"top":291.40000915527,"width":80,"height":86,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"tryLoad","uuid":"51","type":"Method","Ports":{"1":{"type":"In","name":"id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":844.35000610352,"top":20,"width":62,"height":79,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"loadAny","uuid":"55","type":"Method","Ports":{"1":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":141.58334350586,"top":312.58331298828,"width":88,"height":66,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"tryLoadAny","uuid":"58","type":"Method","Ports":{"1":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":462.58334350586,"top":20.116668701172,"width":91,"height":83,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"loadBy","uuid":"61","type":"Method","Ports":{"1":{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"cond","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"3":{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"4":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":21.116668701172,"top":208.69999694824,"width":94,"height":69,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"tryLoadBy","uuid":"67","type":"Method","Ports":{"1":{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"cond","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"3":{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"4":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":23.116668701172,"top":312.58331298828,"width":87,"height":62,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"loaded","uuid":"73","type":"Method","Ports":{"1":{"type":"Out","name":"boolean","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":597.58334350586,"top":211.58331298828,"width":94,"height":75,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"unload","uuid":"76","type":"Method","Ports":{"1":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":775.9333190918,"top":131.93334960938,"width":87,"height":63,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"reset","uuid":"79","type":"Method","Ports":{"1":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":567.58334350586,"top":293.58331298828,"width":66,"height":71,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"save","uuid":"82","type":"Method","Ports":{"1":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":721.8166809082,"top":223.81665039062,"width":87,"height":60,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"saveAndUnload","uuid":"85","type":"Method","Ports":{"1":{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},"2":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":856.58334350586,"top":226.58331298828,"width":91,"height":60,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"delete","uuid":"89","type":"Method","Ports":{"1":{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":478.23330688477,"top":200.69999694824,"width":74,"height":64,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"deleteAll","uuid":"93","type":"Method","Ports":{"1":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":31.466674804688,"top":132.58332824707,"width":98,"height":65,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"reload","uuid":"96","type":"Method","Ports":{"1":{"type":"Out","name":"current record id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":434.46667480469,"top":301.58332824707,"width":55,"height":78,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addCondition","uuid":"97","type":"Method","Ports":{"1":{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"operator","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"3":{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"4":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":677.9333190918,"top":292.93334960938,"width":92,"height":70,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setLimit","uuid":"103","type":"Method","Ports":{"1":{"type":"In","name":"count","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"offset","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":809.11666870117,"top":293.81665039062,"width":115,"height":74,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setOrder","uuid":"108","type":"Method","Ports":{"1":{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"desc","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":20,"top":380.4666595459,"width":114,"height":71,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"count","uuid":"113","type":"Method","Ports":{"1":{"type":"In","name":"alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"integer","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":204.81666564941,"top":372.81665039062,"width":85,"height":66,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"getRows","uuid":"117","type":"Method","Ports":{"1":{"type":"In","name":"fields","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":375.46667480469,"top":382.46667480469,"width":95,"height":68,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"hasField","uuid":"121","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":528.8166809082,"top":374.81665039062,"width":106,"height":62,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"getField","uuid":"125","type":"Method","Ports":{"1":{"type":"In","name":"f","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":669.16665649414,"top":405.28332519531,"width":121,"height":85,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"hasOne","uuid":"129","type":"Method","Ports":{"1":{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"3":{"type":"In","name":"field_class","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"4":{"type":"Out","name":"expr","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":838,"top":397.28332519531,"width":124,"height":78,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"hasMany","uuid":"135","type":"Method","Ports":{"1":{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"their_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"3":{"type":"In","name":"our_field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},"4":{"type":"In","name":"reference_name","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"5":{"type":"Out","name":"null","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":27.700012207031,"top":463.70001220703,"width":120,"height":82,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"ref","uuid":"142","type":"Method","Ports":{"1":{"type":"In","name":"ref1","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"type","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":223.70001220703,"top":465.70001220703,"width":141,"height":82,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"debug","uuid":"146","type":"Method","Ports":{"1":{"type":"In","name":"debug","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"},"2":{"type":"Out","name":"debug","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":421.35000610352,"top":486.34997558594,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"8"}'),
(9, NULL, 'Lister', 'Object', NULL, NULL, 7, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"setSource","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"source","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":45,"top":52,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"9"}'),
(10, NULL, 'Form_Basic', 'Object', NULL, NULL, 7, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"addField","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"type","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"options","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"caption","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"In","name":"attr","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"5":{"type":"Out","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":264,"top":20,"width":200,"height":101,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"set","uuid":"6","type":"Method","Ports":{"1":{"type":"In","name":"field_or_array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":506,"top":22,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"getAllFields","uuid":"11","type":"Method","Ports":{"1":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":79,"top":297,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addSubmit","uuid":"14","type":"Method","Ports":{"1":{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Save"},"2":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"submit","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":652,"top":133,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addButton","uuid":"19","type":"Method","Ports":{"1":{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Button"},"2":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"button","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":344,"top":295,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"update","uuid":"24","type":"Method","Ports":{"1":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":637,"top":368,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"save","uuid":"27","type":"Method","Ports":{"1":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":284,"top":441,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"submitted","uuid":"30","type":"Method","Ports":{"1":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":20,"top":175,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"isSubmitted","uuid":"33","type":"Method","Ports":{"1":{"type":"Out","name":"result","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":29,"top":452,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"onSubmit","uuid":"36","type":"Method","Ports":{"1":{"type":"In","name":"callback","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":548,"top":495,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"hasField","uuid":"39","type":"Method","Ports":{"1":{"type":"In","name":"","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":20,"top":21,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"isClicked","uuid":"43","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":628,"top":250,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addClass","uuid":"47","type":"Method","Ports":{"1":{"type":"Out","name":"$_POST","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":255,"top":150,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"10"}'),
(11, NULL, 'Menu_Advanced', 'Object', NULL, NULL, 7, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"addTitle","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"title","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Menu_Advanced_Title"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":32,"top":47,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addItem","uuid":"6","type":"Method","Ports":{"1":{"type":"In","name":"title","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"action","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Menu_Advanced_Item"},"4":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":295,"top":29,"width":224,"height":144,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addMenu","uuid":"12","type":"Method","Ports":{"1":{"type":"In","name":"title","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"options","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array()"},"4":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":582,"top":46,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addMenuItem","uuid":"18","type":"Method","Ports":{"1":{"type":"In","name":"page","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":61,"top":213,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"11"}');
INSERT INTO `developerZone_entities` (`id`, `component_id`, `name`, `type`, `table_name`, `parent_class`, `owner_id`, `is_class`, `instance_ports`, `is_framework_class`, `js_widget`, `css_class`, `code_structure`) VALUES
(12, NULL, 'View_Columns', 'Object', NULL, NULL, 7, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"addColumn","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"width","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"auto"},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":52,"top":46,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"12"}'),
(13, NULL, 'SQL_Model', 'Object', NULL, NULL, 8, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"addField","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"actual_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":20,"top":20,"width":159,"height":66,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"_dsql","uuid":"6","type":"Method","Ports":{"1":{"type":"Out","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":312.35000610352,"top":20,"width":151,"height":70,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"dsql","uuid":"9","type":"Method","Ports":{"1":{"type":"Out","name":"_dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":599.46670532227,"top":20,"width":166,"height":76,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"selectQuery","uuid":"12","type":"Method","Ports":{"1":{"type":"In","name":"fields","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"_selectQuery","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":20,"top":95.16667175293,"width":116,"height":84,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"fieldQuery","uuid":"21","type":"Method","Ports":{"1":{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":200.93333435059,"top":88.933334350586,"width":120,"height":92,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"titleQuery","uuid":"25","type":"Method","Ports":{"1":{"type":"Out","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":795.11666870117,"top":20,"width":162,"height":82,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addExpression","uuid":"28","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"expression","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"expression","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":54.466674804688,"top":193.93334960938,"width":128,"height":71,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"join","uuid":"33","type":"Method","Ports":{"1":{"type":"In","name":"foreign_table","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"master_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"join_kind","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"In","name":"$_foreign_alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"5":{"type":"In","name":"relation","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"6":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":577.75003051758,"top":116.63333129883,"width":160,"height":79,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"leftJoin","uuid":"47","type":"Method","Ports":{"1":{"type":"In","name":"foreign_table","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"master_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"join_kind","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"In","name":"_foreign_alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"5":{"type":"In","name":"relation","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"6":{"type":"Out","name":"join","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":406.16665649414,"top":100.16667175293,"width":145,"height":88,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"hasOne","uuid":"55","type":"Method","Ports":{"1":{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"display_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"In","name":"as_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"5":{"type":"Out","name":"Field_Reference","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":44.050003051758,"top":262.04998779297,"width":140,"height":81,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"hasMany","uuid":"62","type":"Method","Ports":{"1":{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"their_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"In","name":"as_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"5":{"type":"Out","name":"SQL_Many","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":464.05001831055,"top":208.04998779297,"width":138,"height":98,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"ref","uuid":"69","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"load","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":801.58334350586,"top":127.58331298828,"width":152,"height":69,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"refSQL","uuid":"74","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":264.46667480469,"top":195.46667480469,"width":129,"height":88,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"getRef","uuid":"83","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"load","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"ref (name, load )","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":462.70001220703,"top":347.70001220703,"width":153,"height":73,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addCondition","uuid":"88","type":"Method","Ports":{"1":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"3":{"type":"In","name":"cond","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},"4":{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},"5":{"type":"In","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"}},"Nodes":[],"Connections":[],"left":683.05001831055,"top":224.04998779297,"width":135,"height":78,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"sum","uuid":"95","type":"Method","Ports":{"1":{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":137.46667480469,"top":349.46667480469,"width":171,"height":88,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"_load","uuid":"99","type":"Method","Ports":{"1":{"type":"In","name":"id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"ignore_missing","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"false"},"3":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":720.9333190918,"top":347.93334960938,"width":124,"height":67,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"loadData","uuid":"104","type":"Method","Ports":{"1":{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":42.466674804688,"top":437.46667480469,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"saveAndUnload","uuid":"108","type":"Method","Ports":{"1":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":365.35000610352,"top":447.34997558594,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"update","uuid":"111","type":"Method","Ports":{"1":{"type":"In","name":"data","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array"},"2":{"type":"Out","name":"save","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":693.58334350586,"top":458.58331298828,"width":123,"height":67,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"tryDelete","uuid":"115","type":"Method","Ports":{"1":{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":638.23330688477,"top":544.23333740234,"width":109,"height":59,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setActualFields","uuid":"119","type":"Method","Ports":{"1":{"type":"In","name":"array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"3":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":271.46667480469,"top":557.46667480469,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"13"}'),
(14, NULL, 'View_Box', 'Object', NULL, NULL, 7, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"addIcon","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":55,"top":70,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addButton","uuid":"5","type":"Method","Ports":{"1":{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Continue"},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":305,"top":35,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"14"}'),
(15, NULL, 'View_Badge', 'Object', NULL, NULL, 7, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"setCount","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"count","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":22,"top":33,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setCountSwatch","uuid":"5","type":"Method","Ports":{"1":{"type":"In","name":"swatch","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":311,"top":49,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setBadgeSwatch","uuid":"9","type":"Method","Ports":{"1":{"type":"In","name":"swatch","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":20,"top":187,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"15"}'),
(16, NULL, 'DB', 'Object', NULL, NULL, 5, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"connect","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"dsn","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":52,"top":32,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"dsql","uuid":"5","type":"Method","Ports":{"1":{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":324,"top":47,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"query","uuid":"9","type":"Method","Ports":{"1":{"type":"In","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"params","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array()"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":654,"top":35,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"16"}'),
(17, NULL, 'Model_Table', 'Object', NULL, NULL, 13, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `developerZone_entity_attributes`
--

CREATE TABLE IF NOT EXISTS `developerZone_entity_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `developerZone_entities_id` int(11) DEFAULT NULL,
  `attribute_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_developerZone_entities_id` (`developerZone_entities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `developerZone_entity_methods`
--

CREATE TABLE IF NOT EXISTS `developerZone_entity_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `developerZone_entities_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `method_type` varchar(255) DEFAULT NULL,
  `properties` varchar(255) DEFAULT NULL,
  `default_ports` text,
  PRIMARY KEY (`id`),
  KEY `fk_developerZone_entities_id` (`developerZone_entities_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=847 ;

--
-- Dumping data for table `developerZone_entity_methods`
--

INSERT INTO `developerZone_entity_methods` (`id`, `developerZone_entities_id`, `name`, `method_type`, `properties`, `default_ports`) VALUES
(206, 1, 'destroy', 'public', NULL, '[{"type":"In","name":"recursive","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"}]'),
(207, 1, 'removeElement', 'public', NULL, '[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(208, 1, 'getElement', 'public', NULL, '[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(209, 1, 'hasElement', 'public', NULL, '[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(210, 1, 'rename', 'public', NULL, '[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(211, 1, 'setModel', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(212, 1, 'memorize', 'public', NULL, '[{"type":"In","name":"key","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(213, 1, 'recall', 'public', NULL, '[{"type":"In","name":"key","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"default","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(217, 3, 'setModel', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"actual_fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(218, 3, 'getHTML', 'public', NULL, '[{"type":"In","name":"destroy","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"},{"type":"In","name":"execute_js","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"},{"type":"Out","name":"html","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(219, 3, 'js', 'public', NULL, '[{"type":"In","name":"when","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"code","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"instance","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"jQuery_Chain","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(297, 7, 'setElement', 'public', NULL, '[{"type":"In","name":"element","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(298, 7, 'setAttr', 'public', NULL, '[{"type":"In","name":"attribute","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(299, 7, 'setClass', 'public', NULL, '[{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(300, 7, 'addClass', 'public', NULL, '[{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(301, 7, 'setStyle', 'public', NULL, '[{"type":"In","name":"property","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"style","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(302, 7, 'addStyle', 'public', NULL, '[{"type":"In","name":"property","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"style","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(303, 7, 'set', 'public', NULL, '[{"type":"In","name":"text","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(304, 7, 'setText', 'public', NULL, '[{"type":"In","name":"text","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(305, 7, 'setHTML', 'public', NULL, '[{"type":"In","name":"html","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(377, 9, 'setSource', 'public', NULL, '[{"type":"In","name":"source","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(463, 11, 'addTitle', 'public', NULL, '[{"type":"In","name":"title","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Menu_Advanced_Title"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(464, 11, 'addItem', 'public', NULL, '[{"type":"In","name":"title","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"action","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Menu_Advanced_Item"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(465, 11, 'addMenu', 'public', NULL, '[{"type":"In","name":"title","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"options","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array()"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(466, 11, 'addMenuItem', 'public', NULL, '[{"type":"In","name":"page","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(503, 8, 'addField', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(504, 8, 'addExpression', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"expression","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"field_class","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(505, 8, 'set', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"mix","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(506, 8, 'get', 'public', NULL, '[{"type":"In","name":"name","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"data","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(507, 8, 'getGroupField', 'public', NULL, '[{"type":"In","name":"group","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"all"},{"type":"Out","name":"array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(508, 8, 'setActualFields', 'public', NULL, '[{"type":"In","name":"group","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"array the actual fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(509, 8, 'getActualFields', 'public', NULL, '[{"type":"Out","name":"array the actual fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(510, 8, 'getTitleField', 'public', NULL, '[{"type":"Out","name":"string the title field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(511, 8, 'setDirty', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(512, 8, 'isDirty', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"bool","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(513, 8, 'setSource', 'public', NULL, '[{"type":"In","name":"controller","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"table","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(514, 8, 'load', 'public', NULL, '[{"type":"In","name":"id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(515, 8, 'tryLoad', 'public', NULL, '[{"type":"In","name":"id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(516, 8, 'loadAny', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(517, 8, 'tryLoadAny', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(518, 8, 'loadBy', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"cond","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(519, 8, 'tryLoadBy', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"cond","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(520, 8, 'loaded', 'public', NULL, '[{"type":"Out","name":"boolean","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(521, 8, 'unload', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(522, 8, 'reset', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(523, 8, 'save', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(524, 8, 'saveAndUnload', 'public', NULL, '[{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(525, 8, 'delete', 'public', NULL, '[{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(526, 8, 'deleteAll', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(527, 8, 'reload', 'public', NULL, '[{"type":"Out","name":"current record id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(528, 8, 'addCondition', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"operator","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(529, 8, 'setLimit', 'public', NULL, '[{"type":"In","name":"count","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"offset","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(530, 8, 'setOrder', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"desc","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(531, 8, 'count', 'public', NULL, '[{"type":"In","name":"alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"integer","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(532, 8, 'getRows', 'public', NULL, '[{"type":"In","name":"fields","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(533, 8, 'hasField', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(534, 8, 'getField', 'public', NULL, '[{"type":"In","name":"f","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(535, 8, 'hasOne', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"In","name":"field_class","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"expr","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(536, 8, 'hasMany', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"their_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"In","name":"our_field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"In","name":"reference_name","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"null","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(537, 8, 'ref', 'public', NULL, '[{"type":"In","name":"ref1","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"type","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(538, 8, 'debug', 'public', NULL, '[{"type":"In","name":"debug","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"},{"type":"Out","name":"debug","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(544, 12, 'addColumn', 'public', NULL, '[{"type":"In","name":"width","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"auto"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(568, 15, 'setCount', 'public', NULL, '[{"type":"In","name":"count","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(569, 15, 'setCountSwatch', 'public', NULL, '[{"type":"In","name":"swatch","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(570, 15, 'setBadgeSwatch', 'public', NULL, '[{"type":"In","name":"swatch","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(577, 16, 'connect', 'public', NULL, '[{"type":"In","name":"dsn","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(578, 16, 'dsql', 'public', NULL, '[{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(579, 16, 'query', 'public', NULL, '[{"type":"In","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"params","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array()"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(690, 14, 'addIcon', 'public', NULL, '[{"type":"In","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(691, 14, 'addButton', 'public', NULL, '[{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Continue"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(714, 13, 'addField', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"actual_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(715, 13, '_dsql', 'public', NULL, '[{"type":"Out","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(716, 13, 'dsql', 'public', NULL, '[{"type":"Out","name":"_dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(717, 13, 'selectQuery', 'public', NULL, '[{"type":"In","name":"fields","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"_selectQuery","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(718, 13, 'fieldQuery', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(719, 13, 'titleQuery', 'public', NULL, '[{"type":"Out","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(720, 13, 'addExpression', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"expression","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"expression","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(721, 13, 'join', 'public', NULL, '[{"type":"In","name":"foreign_table","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"master_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"join_kind","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"$_foreign_alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"relation","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(722, 13, 'leftJoin', 'public', NULL, '[{"type":"In","name":"foreign_table","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"master_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"join_kind","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"_foreign_alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"relation","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"join","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(723, 13, 'hasOne', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"display_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"as_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"Field_Reference","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(724, 13, 'hasMany', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"their_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"as_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"SQL_Many","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(725, 13, 'ref', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"load","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(726, 13, 'refSQL', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(727, 13, 'getRef', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"load","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"ref (name, load )","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(728, 13, 'addCondition', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"cond","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},{"type":"In","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"}]'),
(729, 13, 'sum', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(730, 13, '_load', 'public', NULL, '[{"type":"In","name":"id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"ignore_missing","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"false"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(731, 13, 'loadData', 'public', NULL, '[{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(732, 13, 'saveAndUnload', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(733, 13, 'update', 'public', NULL, '[{"type":"In","name":"data","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array"},{"type":"Out","name":"save","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(734, 13, 'tryDelete', 'public', NULL, '[{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(735, 13, 'setActualFields', 'public', NULL, '[{"type":"In","name":"array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(831, 10, 'addField', 'public', NULL, '[{"type":"In","name":"type","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"options","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"caption","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"attr","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(832, 10, 'set', 'public', NULL, '[{"type":"In","name":"field_or_array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(833, 10, 'getAllFields', 'public', NULL, '[{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(834, 10, 'addSubmit', 'public', NULL, '[{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Save"},{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"submit","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(835, 10, 'addButton', 'public', NULL, '[{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Button"},{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"button","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(836, 10, 'update', 'public', NULL, '[{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(837, 10, 'save', 'public', NULL, '[{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(838, 10, 'submitted', 'public', NULL, '[{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(839, 10, 'isSubmitted', 'public', NULL, '[{"type":"Out","name":"result","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(840, 10, 'onSubmit', 'public', NULL, '[{"type":"In","name":"callback","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(841, 10, 'hasField', 'public', NULL, '[{"type":"In","name":"","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(842, 10, 'isClicked', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(843, 10, 'addClass', 'public', NULL, '[{"type":"Out","name":"$_POST","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]'),
(846, 2, 'init', 'public', NULL, '[]');

-- --------------------------------------------------------

--
-- Table structure for table `developerZone_events`
--

CREATE TABLE IF NOT EXISTS `developerZone_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `developerZone_entities_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `fire_spot` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_developerZone_entities_id` (`developerZone_entities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `developerZone_method_nodes`
--

CREATE TABLE IF NOT EXISTS `developerZone_method_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `developerZone_entity_methods_id` int(11) DEFAULT NULL,
  `developerZone_entities_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `inputs` varchar(255) DEFAULT NULL,
  `outputs` varchar(255) DEFAULT NULL,
  `reference_obj` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `is_processed` tinyint(1) DEFAULT NULL,
  `parent_node_id` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `total_ins` varchar(255) DEFAULT NULL,
  `input_resolved_for_branch` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_developerZone_entity_methods_id` (`developerZone_entity_methods_id`),
  KEY `fk_developerZone_entities_id` (`developerZone_entities_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `developerZone_method_nodes`
--

INSERT INTO `developerZone_method_nodes` (`id`, `developerZone_entity_methods_id`, `developerZone_entities_id`, `name`, `inputs`, `outputs`, `reference_obj`, `action`, `is_processed`, `parent_node_id`, `branch`, `total_ins`, `input_resolved_for_branch`) VALUES
(1, 2, NULL, 'Draft Quotations', NULL, NULL, NULL, 'Block', 1, NULL, NULL, NULL, NULL),
(2, 2, 2, 'Model Quotation', NULL, NULL, NULL, 'Add', 1, NULL, NULL, NULL, NULL),
(3, 2, NULL, 'status', 'status', NULL, NULL, 'Variable', 1, NULL, NULL, NULL, NULL),
(4, 2, NULL, 'draft', 'draft', NULL, NULL, 'Variable', 1, NULL, NULL, NULL, NULL),
(5, 2, NULL, 'addCondition', NULL, NULL, '2', 'methodCall', 0, NULL, NULL, NULL, NULL),
(6, 2, 5, 'CRUD', NULL, NULL, NULL, 'Add', NULL, NULL, NULL, NULL, NULL),
(7, 2, NULL, 'setModel', NULL, NULL, '6', 'methodCall', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `developerZone_method_nodes_connections`
--

CREATE TABLE IF NOT EXISTS `developerZone_method_nodes_connections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `from_port_id` int(11) DEFAULT NULL,
  `to_port_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_from_port_id` (`from_port_id`),
  KEY `fk_to_port_id` (`to_port_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `developerZone_method_nodes_connections`
--

INSERT INTO `developerZone_method_nodes_connections` (`id`, `name`, `from_port_id`, `to_port_id`) VALUES
(1, 'addCond->field', 3, 5),
(2, 'addCond->value', 4, 5),
(3, 'addCond_obj', 2, 8),
(4, 'block_out_set', 12, 1),
(5, 'model->setModel', 1, 11),
(6, 'setModel->obj', 9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `developerZone_method_node_ports`
--

CREATE TABLE IF NOT EXISTS `developerZone_method_node_ports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_node_id` (`node_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `developerZone_method_node_ports`
--

INSERT INTO `developerZone_method_node_ports` (`id`, `node_id`, `name`, `type`) VALUES
(1, 1, 'draft_quotaions_from_block', 'OUT'),
(2, 2, 'quotation_model', 'OUT'),
(3, 3, 'field_status', 'OUT'),
(4, 4, 'value_draft', 'OUT'),
(5, 5, 'addCondition_field', 'IN'),
(6, 5, 'addCondition_condition_value', 'IN'),
(7, 5, 'addCondition_value', 'IN'),
(8, 5, 'addCondition_on', 'IN'),
(9, 6, 'crud_object', 'OUT'),
(10, 7, 'setModel_obj', 'IN'),
(11, 7, 'setModel_model', 'IN'),
(12, 5, 'addCondition_out_flow', 'OUT');

-- --------------------------------------------------------

--
-- Table structure for table `epan`
--

CREATE TABLE IF NOT EXISTS `epan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `staff_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fund_alloted` varchar(255) DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `address` text,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `keywords` text,
  `description` text,
  `website` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT NULL,
  `last_email_sent` datetime DEFAULT NULL,
  `allowed_aliases` int(11) DEFAULT NULL,
  `parked_domain` varchar(255) DEFAULT NULL,
  `email_host` varchar(255) DEFAULT NULL,
  `email_port` varchar(255) DEFAULT NULL,
  `email_username` varchar(255) DEFAULT NULL,
  `email_password` varchar(255) DEFAULT NULL,
  `email_reply_to` varchar(255) DEFAULT NULL,
  `email_reply_to_name` varchar(255) DEFAULT NULL,
  `user_activation` varchar(255) DEFAULT NULL,
  `email_threshold` int(11) DEFAULT NULL,
  `user_registration_email_subject` varchar(255) DEFAULT NULL,
  `user_registration_email_message_body` text,
  `email_transport` varchar(255) DEFAULT NULL,
  `encryption` varchar(255) DEFAULT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `sender_email` varchar(255) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `return_path` varchar(255) DEFAULT NULL,
  `smtp_auto_reconnect` int(11) DEFAULT NULL,
  `emails_in_BCC` int(11) DEFAULT NULL,
  `last_emailed_at` datetime DEFAULT NULL,
  `email_sent_in_this_minute` int(11) DEFAULT NULL,
  `is_frontend_registration_allowed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_staff1` (`staff_id`),
  KEY `fk_epan_epan_categories1` (`category_id`),
  FULLTEXT KEY `tags_description_full_text` (`keywords`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan`
--

INSERT INTO `epan` (`id`, `name`, `staff_id`, `branch_id`, `password`, `fund_alloted`, `created_at`, `category_id`, `company_name`, `contact_person_name`, `mobile_no`, `address`, `city`, `state`, `country`, `email_id`, `keywords`, `description`, `website`, `is_active`, `is_approved`, `last_email_sent`, `allowed_aliases`, `parked_domain`, `email_host`, `email_port`, `email_username`, `email_password`, `email_reply_to`, `email_reply_to_name`, `user_activation`, `email_threshold`, `user_registration_email_subject`, `user_registration_email_message_body`, `email_transport`, `encryption`, `from_email`, `from_name`, `sender_email`, `sender_name`, `return_path`, `smtp_auto_reconnect`, `emails_in_BCC`, `last_emailed_at`, `email_sent_in_this_minute`, `is_frontend_registration_allowed`) VALUES
(1, 'web', 1, 1, NULL, '5000000', '2014-01-26', 1, 'Xavoc Technocrats Pvt. Ltd.', 'Xavoc Admin', '+91 8875191258', '18/436, Gayatri marg, Kanji Ka hata, Udaipur, Rajasthan , India', 'Udaipur', 'Rajasthan', 'India', '', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'http://www.xavoc.com', 1, 1, NULL, 1, NULL, 'ssl://xepan.org', '465', 'support@xepan.org', '123', 'support@xepan.org', 'admin', 'self_activated', 200, '', '', 'SmtpTransport', 'ssl', 'info@xepan.org', 'admin', NULL, NULL, NULL, 100, NULL, NULL, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `epan_aliases`
--

CREATE TABLE IF NOT EXISTS `epan_aliases` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `epan_categories`
--

CREATE TABLE IF NOT EXISTS `epan_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `parent_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cat_id` (`id`),
  KEY `cat_parent` (`parent_category_id`),
  KEY `func_getPathWay` (`id`,`parent_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan_categories`
--

INSERT INTO `epan_categories` (`id`, `name`, `description`, `parent_category_id`) VALUES
(1, 'Default', 'Default', 0);

-- --------------------------------------------------------

--
-- Table structure for table `epan_components_marketplace`
--

CREATE TABLE IF NOT EXISTS `epan_components_marketplace` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `allowed_children` varchar(255) DEFAULT NULL,
  `specific_to` varchar(255) DEFAULT NULL,
  `namespace` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) DEFAULT NULL,
  `description` text,
  `default_enabled` tinyint(1) DEFAULT NULL,
  `has_toolbar_tools` tinyint(1) DEFAULT NULL,
  `has_owner_modules` tinyint(1) DEFAULT NULL,
  `has_plugins` tinyint(1) DEFAULT NULL,
  `has_live_edit_app_page` tinyint(1) DEFAULT NULL,
  `git_path` varchar(255) DEFAULT NULL,
  `initialize_and_clone_from_git` tinyint(1) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=86 ;

--
-- Dumping data for table `epan_components_marketplace`
--

INSERT INTO `epan_components_marketplace` (`id`, `name`, `allowed_children`, `specific_to`, `namespace`, `type`, `is_system`, `description`, `default_enabled`, `has_toolbar_tools`, `has_owner_modules`, `has_plugins`, `has_live_edit_app_page`, `git_path`, `initialize_and_clone_from_git`, `category`) VALUES
(51, 'Basic Web Elements And Plugins', '0', '0', 'baseElements', 'element', 1, '0', 1, 1, 0, NULL, 0, '0', 0, NULL),
(67, 'Developer Zone', '0', '0', 'developerZone', 'application', 0, '0', 1, 0, 0, NULL, 0, '0', 0, NULL),
(69, 'Enquiry And Subscriptions', '0', '0', 'xEnquiryNSubscription', 'application', 0, '0', 1, 1, 0, NULL, 0, '0', 0, NULL),
(70, 'xAtrificial Intelligence', '0', '0', 'xAi', 'application', 0, '0', 1, 1, 1, NULL, 0, 'https://github.com/xepan/xAi.git', 1, NULL),
(71, 'Extended Element', '0', '0', 'ExtendedElement', 'module', 0, '0', 1, 1, 0, NULL, 0, '0', 0, NULL),
(72, 'Slide Shows', '0', '0', 'slideShows', 'application', 0, '0', 1, 1, 0, NULL, 0, '0', 1, NULL),
(73, 'Extended Images', '0', '0', 'extendedImages', 'module', 0, '0', 1, 1, 0, NULL, 0, '0', 0, NULL),
(74, 'Image Galley', '0', '0', 'xImageGallery', 'application', 0, '0', 1, 1, 0, NULL, 0, 'https://github.com/xepan/xImageGallery', 1, NULL),
(75, 'xMarketingCampaign', '0', '0', 'xMarketingCampaign', 'application', 0, '0', 1, 0, 0, NULL, 0, 'https://github.com/xepan/xMarketingCampaign', 0, NULL),
(76, 'Menus', '0', '0', 'xMenus', 'application', 0, '0', 1, 1, 0, NULL, 0, '0', 0, NULL),
(77, 'xShop', '0', '0', 'xShop', 'application', 0, '0', 1, 1, 0, NULL, 0, 'https://github.com/xepan/xShop', 1, NULL),
(78, 'Human Resource Management', '0', '0', 'xHR', 'application', 0, '0', 1, 0, 0, NULL, 1, 'https://github.com/xepan/xHR.git', 1, NULL),
(79, 'xFlow Visual Language', NULL, NULL, 'xFlow', 'application', 0, NULL, 1, 0, 0, 1, 1, 'https://github.com/xepan/xFlow.git', 1, NULL),
(80, 'Production Management', '0', '0', 'xProduction', 'application', 0, '0', 1, 0, 0, NULL, 0, 'https://github.com/xepan/xProduction.git', 1, NULL),
(81, 'Customer Relation Management', NULL, NULL, 'xCRM', 'application', 0, NULL, 1, 0, 0, 1, 0, 'https://github.com/xepan/xCRM.git', 1, NULL),
(82, 'Accounts Mangement Application', NULL, NULL, 'xAccount', 'application', 0, NULL, 1, 0, 0, 1, 0, 'https://github.com/xepan/xAccount.git', 1, NULL),
(83, 'Stock Mangement Application', NULL, NULL, 'xStore', 'application', 0, NULL, 1, 0, 0, 1, 0, 'https://github.com/xepan/xStore.git', 1, NULL),
(84, 'Purchase Management Application', NULL, NULL, 'xPurchase', 'application', 0, NULL, 1, 0, 0, 1, 0, 'https://github.com/xepan/xPurchase.git', 1, NULL),
(85, 'Dispatch Management Application', NULL, NULL, 'xDispatch', 'application', 0, NULL, 1, 0, 0, 1, 0, 'https://github.com/xepan/xDispatch.git', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `epan_components_plugins`
--

CREATE TABLE IF NOT EXISTS `epan_components_plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `params` varchar(255) DEFAULT NULL,
  `is_system` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_component_id` (`component_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=81 ;

--
-- Dumping data for table `epan_components_plugins`
--

INSERT INTO `epan_components_plugins` (`id`, `component_id`, `name`, `event`, `params`, `is_system`) VALUES
(61, 51, 'RemoveContentEditable', 'content-fetched', '$page', 1),
(62, 51, 'RunServerSideComponent', 'content-fetched', '$page', 1),
(65, 70, 'BeforeSaveIBlockExtract', 'epan-page-before-save', '$page', 0),
(66, 70, 'ImplementIntelligence', 'beforeTemplateInit', '$page', 0),
(68, 75, 'Newsletter Delete', 'xenq_n_subs_newletter_before_delete', '$newsletter', 0),
(79, 77, 'userRegistration', 'new_user_registered', '$user_model', 0),
(80, 77, 'Register Event', 'register-event', '$events_array', 0);

-- --------------------------------------------------------

--
-- Table structure for table `epan_components_tools`
--

CREATE TABLE IF NOT EXISTS `epan_components_tools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_serverside` tinyint(1) DEFAULT NULL,
  `is_sortable` tinyint(1) DEFAULT NULL,
  `is_resizable` tinyint(1) DEFAULT NULL,
  `display_name` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_component_id` (`component_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=411 ;

--
-- Dumping data for table `epan_components_tools`
--

INSERT INTO `epan_components_tools` (`id`, `component_id`, `name`, `is_serverside`, `is_sortable`, `is_resizable`, `display_name`, `order`) VALUES
(277, 51, 'Row', 0, 1, 0, '', 0),
(278, 51, 'Container', 0, 1, 0, '', 0),
(279, 51, 'Image', 0, 0, 0, '', 0),
(280, 51, 'Title', 0, 0, 0, '', 0),
(281, 51, 'Text', 0, 0, 0, '', 0),
(282, 51, 'Html Block', 0, 0, 0, '', 0),
(283, 51, 'User Panel', 1, 0, 0, '', 0),
(284, 51, 'Column', 0, 1, 0, '', 0),
(285, 51, 'Template Content Region', 0, 1, 0, '', 0),
(288, 71, 'Marquee', 0, 1, 0, '', 1),
(289, 71, 'PopupTooltip', 0, 0, 0, 'Popup Window', 2),
(292, 73, 'xSVG', 0, 0, 0, '', 0),
(293, 73, 'Image With Description 1', 0, 0, 0, '', 0),
(309, 72, 'ThumbnailSlider', 1, 0, 0, '', 0),
(310, 72, 'AwesomeSlider', 1, 0, 0, '', 0),
(311, 72, 'BootStrap Carousel', 0, 0, 0, '', 0),
(312, 72, 'WaterWheelCarousel', 1, 0, 0, '', 0),
(313, 72, 'TransformGallery', 1, 0, 0, '3D transforms', 0),
(315, 70, 'IntelligentBlock', 0, 1, 0, 'IBlock', 0),
(336, 69, 'CustomeForm', 1, 0, 0, '', 2),
(337, 69, 'SubscriptionModule', 1, 0, 0, '', 3),
(338, 69, 'EnquiryForm', 0, 0, 0, '', 1),
(339, 69, 'unSubscribe', 1, 0, 0, 'Un Subscriber', 4),
(341, 74, 'GoogleImageGallery', 1, 0, 0, '', 0),
(343, 76, 'Bootstrap Menus', 0, 0, 0, '', 0),
(401, 77, 'Add Block', 1, 0, 0, '', 8),
(402, 77, 'Member Account', 1, 0, 0, '', 7),
(403, 77, 'Checkout', 1, 0, 0, '', 6),
(404, 77, 'Search', 1, 0, 0, '', 5),
(405, 77, 'xCart', 1, 0, 0, '', 4),
(406, 77, 'Category', 1, 0, 0, '', 1),
(407, 77, 'Item', 1, 0, 0, '', 2),
(408, 77, 'ItemDetail', 1, 0, 0, '', 3),
(409, 77, 'Designer', 1, 0, 0, 'Designer', 9),
(410, 77, 'ItemImages', 1, 0, 0, 'Item Images', 0);

-- --------------------------------------------------------

--
-- Table structure for table `epan_installed_components`
--

CREATE TABLE IF NOT EXISTS `epan_installed_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `component_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT NULL,
  `params` varchar(255) DEFAULT NULL,
  `installed_on` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `epan_installed_components`
--

INSERT INTO `epan_installed_components` (`id`, `epan_id`, `component_id`, `enabled`, `params`, `installed_on`) VALUES
(23, 1, 67, 1, NULL, '2014-09-28'),
(25, 1, 69, 1, NULL, '2014-10-06'),
(26, 1, 70, 1, NULL, '2014-10-17'),
(27, 1, 71, 1, NULL, '2014-10-24'),
(28, 1, 72, 1, NULL, '2014-10-24'),
(29, 1, 73, 1, NULL, '2014-10-24'),
(30, 1, 74, 1, NULL, '2014-10-24'),
(31, 1, 75, 1, NULL, '2014-10-24'),
(32, 1, 76, 1, NULL, '2014-10-24'),
(33, 1, 77, 1, NULL, '2014-10-24'),
(34, 1, 78, 1, NULL, '2015-02-01'),
(35, 1, 80, 1, NULL, '2015-02-14'),
(36, 1, 81, 1, NULL, '2015-02-16'),
(37, 1, 82, 1, NULL, '2015-02-16'),
(38, 1, 83, 1, NULL, '2015-02-16'),
(39, 1, 84, 1, NULL, '2015-02-16'),
(40, 1, 85, 1, NULL, '2015-03-04');

-- --------------------------------------------------------

--
-- Table structure for table `epan_page`
--

CREATE TABLE IF NOT EXISTS `epan_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_page_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `menu_caption` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `is_template` tinyint(1) DEFAULT NULL,
  `title` text,
  `description` text,
  `keywords` text,
  `content` text,
  `body_attributes` text,
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `access_level` varchar(255) DEFAULT NULL,
  `template_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_page_epan1` (`epan_id`),
  KEY `fk_template_id` (`template_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `epan_page`
--

INSERT INTO `epan_page` (`id`, `parent_page_id`, `name`, `menu_caption`, `epan_id`, `is_template`, `title`, `description`, `keywords`, `content`, `body_attributes`, `created_on`, `updated_on`, `access_level`, `template_id`) VALUES
(1, NULL, 'home', 'Home', 1, 0, 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '<div id="cb5ed5ab-e4e2-44db-a412-9b19efe2ecb3" component_namespace="baseElements" component_type="Container" class="epan-container  epan-sortable-component epan-component  ui-sortable" style="background-image: none; background-color: rgb(204, 204, 204);"> 	 <div id="77d11478-1ac5-49ce-cfab-f12812a29381" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="margin: auto;"> 	 <div id="afc8f126-bbdc-4e3f-955b-d4cc124ac454" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-3" span="3" style=" "> 	 \n<div id="faf66c24-b2e4-42bb-fa88-866d92d9deb4" component_namespace="xEnquiryNSubscription" component_type="SubscriptionModule" data-responsible-namespace="xEnquiryNSubscription" data-responsible-view="View_Tools_SubscriptionModule" data-is-serverside-component="true" class="epan-component" style="" data-options="enquiry subscription"></div>\n</div>\n<div id="fa66d440-683c-4653-ab39-f5500d5adec6" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable" span="4" style=" "> 	 <div id="cf9f4410-e43b-45f5-f6bf-29b12c85d454" component_namespace="ExtendedElement" component_type="PopupTooltip" class="epan-component" style=" "> 	 			<div class="xpopup modal fade" id="myModal11cf9f4410-e43b-45f5-f6bf-29b12c85d454" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"> 			  <div class="modal-dialog"> 			    <div class="modal-content"> 			      <div class="modal-header"> 			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button> 			        <h4 class="modal-title" id="myModalLabel" contenteditable="true">Modal title</h4> 			      </div> 			      <div class="modal-body"> 			        		<div class="epan-container  epan-sortable-component epan-component  ui-sortable"> 							<div id="edb7046a-14ef-472e-c7f8-083d32f4231e" component_namespace="slideShows" component_type="BootStrapCarousel" class="slide epan-component" style="position:relative; "> 	<div class="carousel-inner"> 	<div class="item active"><img src="epans/web/images.jpeg" style="width:100%; max-width:100%; height:auto; "></div>\n<div class="item"><img src="epans/web/home-slide2.jpg" style="width:100%; max-width:100%; height:auto; "></div>\n</div> 	 <!-- Controls --> 	  <a class="left carousel-control" href="#edb7046a-14ef-472e-c7f8-083d32f4231e" data-slide="prev"> 	    <span class="glyphicon glyphicon-chevron-left"></span> 	  </a> 	  <a class="right carousel-control" href="#edb7046a-14ef-472e-c7f8-083d32f4231e" data-slide="next"> 	    <span class="glyphicon glyphicon-chevron-right"></span> 	  </a> 	 </div>\n</div> 			      </div> 			      <div class="modal-footer"> 			        <button type="button" class="btn btn-default xpopup-btn" data-dismiss="modal" style="display: none;">Close</button> 			        <button type="button" class="btn btn-primary xpopup-btn" style="display: none;">Save changes</button> 			      </div> 			    </div> 			  </div> 			</div> 				<!-- Button trigger modal --> 			<div class="btn btn-primary xpopup_trigger" data-toggle="modal" data-target="#myModal11cf9f4410-e43b-45f5-f6bf-29b12c85d454" contenteditable="true">online Store</div> 			<!-- Modal --> 		 </div>\n</div>\n<div id="0f5abaaf-8094-46ec-8677-a4f545ac56b0" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-4" span="4" style=" "> 	 \n<div id="0a60a78d-4f25-4cbc-e94c-d13e0d9f92ee" component_namespace="baseElements" component_type="UserPanel" data-responsible-namespace="baseElements" data-responsible-view="View_Tools_UserPanel" data-is-serverside-component="true" class="epan-component" style=""></div><div id="7ac63c02-3527-41d6-d28b-7f1e0290ee95" component_namespace="baseElements" component_type="Text" class="editor epan-component editor-attached" style="font-size: 16px;" data-extra-classes="" contenteditable="true"><p style="text-align: right;"><span style="line-height: 1.428571429;">Call :- 9784954128</span></p></div>\n</div>\n</div>\n<div id="54b7d970-e41e-490e-8ef2-163a57f15a04" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="margin: auto; font-size: 16px;"> 	 <div id="fee390a5-fb88-4421-db93-f53aaa95efb3" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-2" span="2" style=" "> 	 <div id="0ddd7220-946c-4153-b4cb-7ade93b8ff2c" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="epans/web/Xavoc%20Technocrats%20Logo%20Small.png" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n<div id="489762c6-4bd5-4139-980a-8057504bde65" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-3" span="3" style=" "> 	 </div>\n<div id="323c3bbe-e9fd-47a9-9572-a62589b2691c" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-7" span="7" style=" "> 	 <nav id="34d11508-7934-4b37-8f17-71ff93906938" component_namespace="xMenus" component_type="BootstrapMenus" class="navbar navbar-default epan-component  navbar-inverse" style="margin: auto 12px 12px;" role="navigation" data-extra-classes="navbar-inverse"><!-- Brand and toggle get grouped for better mobile display --><div class="navbar-header"> 			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> 				<span class="sr-only">Toggle navigation</span> 				<span class="icon-bar"></span> 				<span class="icon-bar"></span> 				<span class="icon-bar"></span> 			</button> 			<div class="epan-component epan-sortable-component editor navbar-brand ui-sortable editor-attached" component_type="Container" component_namespace="baseElements" contenteditable="true"><br></div> 		</div> 	 		<!-- Collect the nav links, forms, and other content for toggling --> 		<div class="collapse navbar-collapse navbar-ex1-collapse"> 			<ul id="xMenu-boostrap-ul" class="nav navbar-nav ui-sortable"><li class=""><a href="index.php?subpage=home">Home</a></li></ul>\n<div style="" class="epan-sortable-component epan-component navbar-form navbar-left ui-sortable" component_type="Container" component_namespace="baseElements"> 				 			\n<div id="a8b52ab1-3012-4332-fb60-12a4bbb34fb0" component_namespace="xShop" component_type="Category" data-responsible-namespace="xShop" data-responsible-view="View_Tools_Category" data-is-serverside-component="true" class="epan-component" style="" xshop_application_id="1" show-category-column="3" xshop_category_url_page="item"></div>\n</div> 			 		</div>\n<!-- /.navbar-collapse --> 		 </nav>\n</div>\n</div>\n<div id="6f772cba-9ec2-4d70-f471-529ac2dbf3c1" component_namespace="slideShows" component_type="AwesomeSlider" data-responsible-namespace="slideShows" data-responsible-view="View_Tools_AwesomeSlider" data-is-serverside-component="true" class="epan-component" style="" awesomeslider-theme="theme-bar"></div>\n<div id="a1b8b0cd-f1a2-4dfe-f0bb-6d265992884f" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="margin: auto;"> 	 <marquee id="19b16f4f-23d3-4443-e5c6-5dea84e535e8" component_namespace="ExtendedElement" component_type="Marquee" class="epan-container   epan-sortable-component epan-component  ui-sortable" style="width: auto;" direction="left" behavior="slide" scrollamount="5"><div id="64faf106-5972-4f60-9f72-92d47f00486f" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="width: auto; height: auto; max-width: 100%;"> 	 <div id="bf703bb5-627f-4350-e157-fa3600ff164b" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-2" span="2" style=" "> 	 <div id="6567f9e4-bf44-41ba-dc08-99a2ecdaa25e" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="templates/images/logo.png" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n<div id="bf703bb5-627f-4350-e157-fa3600ff164b" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-2" span="2" style=" "> 	 <div id="6567f9e4-bf44-41ba-dc08-99a2ecdaa25e" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="templates/images/logo.png" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n<div id="bf703bb5-627f-4350-e157-fa3600ff164b" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-2" span="2" style=" "> 	 <div id="6567f9e4-bf44-41ba-dc08-99a2ecdaa25e" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="templates/images/logo.png" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n<div id="bf703bb5-627f-4350-e157-fa3600ff164b" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-2" span="2" style=" "> 	 <div id="6567f9e4-bf44-41ba-dc08-99a2ecdaa25e" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="templates/images/logo.png" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n<div id="bf703bb5-627f-4350-e157-fa3600ff164b" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-2" span="2" style=" "> 	 <div id="6567f9e4-bf44-41ba-dc08-99a2ecdaa25e" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="templates/images/logo.png" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n<div id="bf703bb5-627f-4350-e157-fa3600ff164b" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-2" span="2" style=" "> 	 <div id="6567f9e4-bf44-41ba-dc08-99a2ecdaa25e" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="templates/images/logo.png" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n</div>\n</marquee>\n</div>\n<div id="e7edc68a-faa8-42a0-b785-006c79fe6668" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable text-center" style="margin: auto auto 1%;" data-extra-classes="text-center"> 	 <div id="30158b37-e69a-4558-bcd2-765969e6cf40" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-3" span="3" style=" "> 	 <div id="175d08b1-3c13-4180-f769-0f745e1c491f" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="epans/web/seo-puzzle-piece-300x200.jpg" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n<div id="043dfe67-b646-4555-902f-34310ae2c139" component_namespace="baseElements" component_type="Text" class="editor epan-component editor-attached" style=" " contenteditable="true"><font face="Glyphicons Halflings"><span style="line-height: 12.8000001907349px;"><b>Web&nbsp;Contains&nbsp;SEO</b></span></font></div>\n</div>\n<div id="30158b37-e69a-4558-bcd2-765969e6cf40" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-3" span="3" style=" "> 	 <div id="175d08b1-3c13-4180-f769-0f745e1c491f" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="epans/web/Google-Image-Optimization1.jpg" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n<div id="043dfe67-b646-4555-902f-34310ae2c139" component_namespace="baseElements" component_type="Text" class="editor epan-component editor-attached" style=" " contenteditable="true"><b> 	Code Optimization</b></div>\n</div>\n<div id="30158b37-e69a-4558-bcd2-765969e6cf40" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-3" span="3" style=" "> 	 \n\n<div id="534372e5-e07f-4f67-9673-f588b8d421b9" component_namespace="extendedImages" component_type="ImageWithDescription1" class="epan-component" style=" "> <link rel="stylesheet" type="text/css" href="epan-components/extendedImages/templates/css/extendedImages-ImageWithDescription1.css">\n<div class="imagepluscontainer" style="z-index:2"> 		<div class="epan-component" component_type="Image"><img src="epans/web/wpid-Web_Design_70-300x200.jpg" style="width:100%; max-width:100%"></div> 		<div class="desc editor editor-attached" style="width:100%; max-width:100%; left-padding:auto; right-padding:auto" contenteditable="true">Website Design</div> 	</div> </div>\n</div>\n<div id="30158b37-e69a-4558-bcd2-765969e6cf40" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-3" span="3" style=" "> 	 \n\n<div id="1a4a6d30-708e-4c42-945a-c24df6c2a25c" component_namespace="slideShows" component_type="BootStrapCarousel" class="slide epan-component" style="position:relative; "> 	<div class="carousel-inner"> 	<div class="item active"><img src="epans/web/home-slide2.jpg" style="width:100%; max-width:100%; height:auto; "></div>\n<div class="item"><img src="epans/web/images.jpeg" style="width:100%; max-width:100%; height:auto; "></div>\n</div> 	 <!-- Controls --> 	  <a class="left carousel-control" href="#1a4a6d30-708e-4c42-945a-c24df6c2a25c" data-slide="prev"> 	    <span class="glyphicon glyphicon-chevron-left"></span> 	  </a> 	  <a class="right carousel-control" href="#1a4a6d30-708e-4c42-945a-c24df6c2a25c" data-slide="next"> 	    <span class="glyphicon glyphicon-chevron-right"></span> 	  </a> 	 </div>\n</div>\n</div>\n<div id="8b844368-1bf4-4e94-db11-e5eb7d37395f" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable navbar-inverse" style="margin: auto; padding-bottom: 1%;" data-extra-classes="navbar-inverse"> 	 <div id="f7e5a558-9dc2-4435-c42c-6be588ff0a27" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-4" span="4" style=" "> 	 <div id="cbb9eb77-e664-4e95-c932-970a5d6df074" component_namespace="baseElements" component_type="Text" class="editor epan-component editor-attached" style=" " contenteditable="true">\n<h2 style="font-family: ''Helvetica Neue'', Helvetica, sans-serif; color: white; margin-top: 0.9rem; background-color: rgb(34, 34, 34);"><b>Xavoc Technocrats Pvt.Ltd</b></h2>\n<div style="color: rgb(255, 255, 255); font-family: ''Allerta Stencil''; font-size: 12px; line-height: 17.142858505249px; background-color: rgb(34, 34, 34);" align="justify">Reg. Office: 18/436, Gaytri Marg,&nbsp;<br>Kanji ka hata, Dhabai Ji ka wada,<br>Udaipur (Rajasthan) -313001 (INDIA)<br>\n</div>\n<div style="color: rgb(255, 255, 255); font-family: ''Allerta Stencil''; font-size: 12px; line-height: 17.142858505249px; background-color: rgb(34, 34, 34);" align="left">\n<b>Email:</b>&nbsp;info@xavoc.com , &nbsp; &nbsp;management@xavoc.com<br><b>Call:</b>&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +91-9782300801<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +91-8875191258</div>\n</div>\n</div>\n<div id="a8a926ca-2b96-48df-cd3b-73e82a9d4598" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable" span="4" style=" "> 	 <div id="8ef641e4-e8ef-4074-cf9c-2ade8c40790b" component_namespace="baseElements" component_type="HtmlBlock" class="epan-component" style=" "> <iframe scrolling="no" src="https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Xavoc+Technocrats+Pvt.+Ltd.,+University+Road+Udaipur,+Rajasthan&amp;aq=t&amp;sll=24.587202,73.710801&amp;sspn=0.185131,0.338173&amp;ie=UTF8&amp;hq=&amp;hnear=&amp;ll=24.588776,73.714278&amp;spn=0.006295,0.006295&amp;t=m&amp;iwloc=A&amp;output=embed" marginwidth="0" marginheight="0" frameborder="0" height="200" width="100%"></iframe> </div>\n</div>\n<div id="52ee454c-c6cd-49f7-d82c-b0489a4224f3" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-4" span="4" style=" "> 	 <div id="b9013951-5d1c-4fd2-b43f-748f6a555e10" component_namespace="baseElements" component_type="Title" class="epan-component" style="color: rgb(255, 255, 255);"><h2 class="editor editor-attached" contenteditable="true">This is Title</h2></div>\n\n<div id="849ac8e3-6e91-4559-e5c3-718c8b78939d" component_namespace="xEnquiryNSubscription" component_type="CustomeForm" data-responsible-namespace="xEnquiryNSubscription" data-responsible-view="View_Tools_CustomeForm" data-is-serverside-component="true" class="epan-component" style="color: rgb(0, 0, 0); padding: 2%; background-color: rgb(232, 232, 232);" data-options="1"></div>\n</div>\n</div>\n</div>\n<div id="61c7816d-e140-42b2-914d-39f079409957" component_namespace="xImageGallery" component_type="GoogleImageGallery" data-responsible-namespace="xImageGallery" data-responsible-view="View_Tools_GoogleImageGallery" data-is-serverside-component="true" class="epan-component" style=""></div>', 'cursor: default; overflow: auto; background-image: url("http://localhost/primescan/epans/web/untitled%20folder%201/body-bg.gif");', NULL, '2015-03-25 06:32:37', '0', 4),
(3, NULL, 'item', '', 1, 0, 'web', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '<div id="cb5ed5ab-e4e2-44db-a412-9b19efe2ecb3" component_namespace="baseElements" component_type="Container" class="epan-container  epan-sortable-component epan-component  ui-sortable" style="background-image: none; background-color: rgb(204, 204, 204);"> 	 <div id="77d11478-1ac5-49ce-cfab-f12812a29381" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="margin: auto;"> 	 <div id="afc8f126-bbdc-4e3f-955b-d4cc124ac454" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-3" span="3" style=" "> 	 \n<div id="faf66c24-b2e4-42bb-fa88-866d92d9deb4" component_namespace="xEnquiryNSubscription" component_type="SubscriptionModule" data-responsible-namespace="xEnquiryNSubscription" data-responsible-view="View_Tools_SubscriptionModule" data-is-serverside-component="true" class="epan-component" style="" data-options="enquiry subscription"></div>\n</div>\n<div id="fa66d440-683c-4653-ab39-f5500d5adec6" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable" span="4" style=" "> 	 <div id="cf9f4410-e43b-45f5-f6bf-29b12c85d454" component_namespace="ExtendedElement" component_type="PopupTooltip" class="epan-component" style=" "> 	 			<div class="xpopup modal fade" id="myModal11cf9f4410-e43b-45f5-f6bf-29b12c85d454" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"> 			  <div class="modal-dialog"> 			    <div class="modal-content"> 			      <div class="modal-header"> 			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button> 			        <h4 class="modal-title" id="myModalLabel" contenteditable="true">Modal title</h4> 			      </div> 			      <div class="modal-body"> 			        		<div class="epan-container  epan-sortable-component epan-component  ui-sortable"> 							<div id="edb7046a-14ef-472e-c7f8-083d32f4231e" component_namespace="slideShows" component_type="BootStrapCarousel" class="slide epan-component" style="position:relative; "> 	<div class="carousel-inner"> 	<div class="item active"><img src="epans/web/images.jpeg" style="width:100%; max-width:100%; height:auto; "></div>\n<div class="item"><img src="epans/web/home-slide2.jpg" style="width:100%; max-width:100%; height:auto; "></div>\n</div> 	 <!-- Controls --> 	  <a class="left carousel-control" href="#edb7046a-14ef-472e-c7f8-083d32f4231e" data-slide="prev"> 	    <span class="glyphicon glyphicon-chevron-left"></span> 	  </a> 	  <a class="right carousel-control" href="#edb7046a-14ef-472e-c7f8-083d32f4231e" data-slide="next"> 	    <span class="glyphicon glyphicon-chevron-right"></span> 	  </a> 	 </div>\n</div> 			      </div> 			      <div class="modal-footer"> 			        <button type="button" class="btn btn-default xpopup-btn" data-dismiss="modal" style="display: none;">Close</button> 			        <button type="button" class="btn btn-primary xpopup-btn" style="display: none;">Save changes</button> 			      </div> 			    </div> 			  </div> 			</div> 				<!-- Button trigger modal --> 			<div class="btn btn-primary xpopup_trigger" data-toggle="modal" data-target="#myModal11cf9f4410-e43b-45f5-f6bf-29b12c85d454" contenteditable="true">online Store</div> 			<!-- Modal --> 		 </div>\n</div>\n<div id="0f5abaaf-8094-46ec-8677-a4f545ac56b0" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-4" span="4" style=" "> 	 <div id="7ac63c02-3527-41d6-d28b-7f1e0290ee95" component_namespace="baseElements" component_type="Text" class="editor epan-component editor-attached" style="font-size: 16px;" data-extra-classes="" contenteditable="true"><p style="text-align: right;"><span style="line-height: 1.428571429;">Call :- 9784954128</span></p></div>\n</div>\n</div>\n<div id="54b7d970-e41e-490e-8ef2-163a57f15a04" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="margin: auto; font-size: 16px;"> 	 <div id="fee390a5-fb88-4421-db93-f53aaa95efb3" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-2" span="2" style=" "> 	 <div id="0ddd7220-946c-4153-b4cb-7ade93b8ff2c" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="epans/web/Xavoc%20Technocrats%20Logo%20Small.png" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n<div id="489762c6-4bd5-4139-980a-8057504bde65" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-3" span="3" style=" "> 	 </div>\n<div id="323c3bbe-e9fd-47a9-9572-a62589b2691c" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-7" span="7" style=" "> 	 <nav id="34d11508-7934-4b37-8f17-71ff93906938" component_namespace="xMenus" component_type="BootstrapMenus" class="navbar navbar-default epan-component  navbar-inverse" style="margin: auto 12px 12px;" role="navigation" data-extra-classes="navbar-inverse"><!-- Brand and toggle get grouped for better mobile display --><div class="navbar-header"> 			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> 				<span class="sr-only">Toggle navigation</span> 				<span class="icon-bar"></span> 				<span class="icon-bar"></span> 				<span class="icon-bar"></span> 			</button> 			<div class="epan-component epan-sortable-component editor navbar-brand ui-sortable editor-attached" component_type="Container" component_namespace="baseElements" contenteditable="true"><br></div> 		</div> 	 		<!-- Collect the nav links, forms, and other content for toggling --> 		<div class="collapse navbar-collapse navbar-ex1-collapse"> 			<ul id="xMenu-boostrap-ul" class="nav navbar-nav ui-sortable"><li class="ui-sortable-handle"><a href="index.php?subpage=home">Home</a></li></ul>\n<div style="" class="epan-sortable-component epan-component navbar-form navbar-left ui-sortable" component_type="Container" component_namespace="baseElements"> 				 			</div> 			 		</div>\n<!-- /.navbar-collapse --> 		 </nav>\n</div>\n</div>\n<div id="6f772cba-9ec2-4d70-f471-529ac2dbf3c1" component_namespace="slideShows" component_type="AwesomeSlider" data-responsible-namespace="slideShows" data-responsible-view="View_Tools_AwesomeSlider" data-is-serverside-component="true" class="epan-component" style="" awesomeslider-theme="theme-bar"></div>\n<div id="310276f8-6313-4a27-ebe6-790c1a967565" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="margin-right: auto; margin-left: auto;"> 	 \n<div id="ec243d4e-a52c-4427-cfb0-a7dd42101464" component_namespace="xShop" component_type="Item" data-responsible-namespace="xShop" data-responsible-view="View_Tools_Item" data-is-serverside-component="true" class="epan-component" style="" xshop_itemlayout="xShop-itemgrid" xshop_itemtype="all" xshop-grid-column="4" xshop_item_application_id="1" xshop_item_hover="1" xshop-detail-page="itemd" xshop_item_paginator="10" show-image="1" show-name="1" show-price="1" show-short-description="1" show-add-to-cart="1" show-details-in-frame="1" show-specifications="1" show-personalized="1" show-reviews="1" show-enquiry-form="1" show-qty-selection="1" show-custom-fields="1"></div>\n</div>\n\n\n<div id="8b844368-1bf4-4e94-db11-e5eb7d37395f" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable navbar-inverse" style="margin: auto; padding-bottom: 1%;" data-extra-classes="navbar-inverse"> 	 <div id="f7e5a558-9dc2-4435-c42c-6be588ff0a27" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-4" span="4" style=" "> 	 <div id="cbb9eb77-e664-4e95-c932-970a5d6df074" component_namespace="baseElements" component_type="Text" class="editor epan-component editor-attached" style=" " contenteditable="true">\n<h2 style="font-family: ''Helvetica Neue'', Helvetica, sans-serif; color: white; margin-top: 0.9rem; background-color: rgb(34, 34, 34);"><b>Xavoc Technocrats Pvt.Ltd</b></h2>\n<div style="color: rgb(255, 255, 255); font-family: ''Allerta Stencil''; font-size: 12px; line-height: 17.142858505249px; background-color: rgb(34, 34, 34);" align="justify">Reg. Office: 18/436, Gaytri Marg,&nbsp;<br>Kanji ka hata, Dhabai Ji ka wada,<br>Udaipur (Rajasthan) -313001 (INDIA)<br>\n</div>\n<div style="color: rgb(255, 255, 255); font-family: ''Allerta Stencil''; font-size: 12px; line-height: 17.142858505249px; background-color: rgb(34, 34, 34);" align="left">\n<b>Email:</b>&nbsp;info@xavoc.com , &nbsp; &nbsp;management@xavoc.com<br><b>Call:</b>&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +91-9782300801<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +91-8875191258</div>\n</div>\n</div>\n<div id="a8a926ca-2b96-48df-cd3b-73e82a9d4598" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable" span="4" style=" "> 	 <div id="8ef641e4-e8ef-4074-cf9c-2ade8c40790b" component_namespace="baseElements" component_type="HtmlBlock" class="epan-component" style=" "> <iframe scrolling="no" src="https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Xavoc+Technocrats+Pvt.+Ltd.,+University+Road+Udaipur,+Rajasthan&amp;aq=t&amp;sll=24.587202,73.710801&amp;sspn=0.185131,0.338173&amp;ie=UTF8&amp;hq=&amp;hnear=&amp;ll=24.588776,73.714278&amp;spn=0.006295,0.006295&amp;t=m&amp;iwloc=A&amp;output=embed" marginwidth="0" marginheight="0" frameborder="0" height="200" width="100%"></iframe> </div>\n</div>\n<div id="52ee454c-c6cd-49f7-d82c-b0489a4224f3" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-4" span="4" style=" "> 	 <div id="b9013951-5d1c-4fd2-b43f-748f6a555e10" component_namespace="baseElements" component_type="Title" class="epan-component" style="color: rgb(255, 255, 255);"><h2 class="editor editor-attached" contenteditable="true">This is Title</h2></div>\n\n<div id="849ac8e3-6e91-4559-e5c3-718c8b78939d" component_namespace="xEnquiryNSubscription" component_type="CustomeForm" data-responsible-namespace="xEnquiryNSubscription" data-responsible-view="View_Tools_CustomeForm" data-is-serverside-component="true" class="epan-component" style="color: rgb(0, 0, 0); padding: 2%; background-color: rgb(232, 232, 232);" data-options="1"></div>\n</div>\n</div>\n</div>', 'cursor: default; overflow: auto; background-image: url(http://localhost/primescan/epans/web/untitled%20folder%201/body-bg.gif);', '2015-03-24 06:34:13', '2015-03-24 07:54:09', '0', 1),
(4, NULL, 'itemd', '', 1, 0, 'web', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '<div id="cb5ed5ab-e4e2-44db-a412-9b19efe2ecb3" component_namespace="baseElements" component_type="Container" class="epan-container  epan-sortable-component epan-component  ui-sortable" style="background-image: none; background-color: rgb(204, 204, 204);"> 	 <div id="77d11478-1ac5-49ce-cfab-f12812a29381" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="margin: auto;"> 	 <div id="afc8f126-bbdc-4e3f-955b-d4cc124ac454" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-3" span="3" style=" "> 	 \n<div id="faf66c24-b2e4-42bb-fa88-866d92d9deb4" component_namespace="xEnquiryNSubscription" component_type="SubscriptionModule" data-responsible-namespace="xEnquiryNSubscription" data-responsible-view="View_Tools_SubscriptionModule" data-is-serverside-component="true" class="epan-component" style="" data-options="enquiry subscription"></div>\n</div>\n<div id="fa66d440-683c-4653-ab39-f5500d5adec6" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable" span="4" style=" "> 	 <div id="cf9f4410-e43b-45f5-f6bf-29b12c85d454" component_namespace="ExtendedElement" component_type="PopupTooltip" class="epan-component" style=" "> 	 			<div class="xpopup modal fade" id="myModal11cf9f4410-e43b-45f5-f6bf-29b12c85d454" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"> 			  <div class="modal-dialog"> 			    <div class="modal-content"> 			      <div class="modal-header"> 			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button> 			        <h4 class="modal-title" id="myModalLabel" contenteditable="true">Modal title</h4> 			      </div> 			      <div class="modal-body"> 			        		<div class="epan-container  epan-sortable-component epan-component  ui-sortable"> 							<div id="edb7046a-14ef-472e-c7f8-083d32f4231e" component_namespace="slideShows" component_type="BootStrapCarousel" class="slide epan-component" style="position:relative; "> 	<div class="carousel-inner"> 	<div class="item active"><img src="epans/web/images.jpeg" style="width:100%; max-width:100%; height:auto; "></div>\n<div class="item"><img src="epans/web/home-slide2.jpg" style="width:100%; max-width:100%; height:auto; "></div>\n</div> 	 <!-- Controls --> 	  <a class="left carousel-control" href="#edb7046a-14ef-472e-c7f8-083d32f4231e" data-slide="prev"> 	    <span class="glyphicon glyphicon-chevron-left"></span> 	  </a> 	  <a class="right carousel-control" href="#edb7046a-14ef-472e-c7f8-083d32f4231e" data-slide="next"> 	    <span class="glyphicon glyphicon-chevron-right"></span> 	  </a> 	 </div>\n</div> 			      </div> 			      <div class="modal-footer"> 			        <button type="button" class="btn btn-default xpopup-btn" data-dismiss="modal" style="display: none;">Close</button> 			        <button type="button" class="btn btn-primary xpopup-btn" style="display: none;">Save changes</button> 			      </div> 			    </div> 			  </div> 			</div> 				<!-- Button trigger modal --> 			<div class="btn btn-primary xpopup_trigger" data-toggle="modal" data-target="#myModal11cf9f4410-e43b-45f5-f6bf-29b12c85d454" contenteditable="true">online Store</div> 			<!-- Modal --> 		 </div>\n</div>\n<div id="0f5abaaf-8094-46ec-8677-a4f545ac56b0" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-4" span="4" style=" "> 	 <div id="7ac63c02-3527-41d6-d28b-7f1e0290ee95" component_namespace="baseElements" component_type="Text" class="editor epan-component editor-attached" style="font-size: 16px;" data-extra-classes="" contenteditable="true"><p style="text-align: right;"><span style="line-height: 1.428571429;">Call :- 9784954128</span></p></div>\n</div>\n</div>\n<div id="54b7d970-e41e-490e-8ef2-163a57f15a04" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="margin: auto; font-size: 16px;"> 	 <div id="fee390a5-fb88-4421-db93-f53aaa95efb3" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-2" span="2" style=" "> 	 <div id="0ddd7220-946c-4153-b4cb-7ade93b8ff2c" component_namespace="baseElements" component_type="Image" class="epan-component" style=" "> 	<img src="epans/web/Xavoc%20Technocrats%20Logo%20Small.png" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n<div id="489762c6-4bd5-4139-980a-8057504bde65" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-3" span="3" style=" "> 	 </div>\n<div id="323c3bbe-e9fd-47a9-9572-a62589b2691c" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-7" span="7" style=" "> 	 <nav id="34d11508-7934-4b37-8f17-71ff93906938" component_namespace="xMenus" component_type="BootstrapMenus" class="navbar navbar-default epan-component  navbar-inverse" style="margin: auto 12px 12px;" role="navigation" data-extra-classes="navbar-inverse"><!-- Brand and toggle get grouped for better mobile display --><div class="navbar-header"> 			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> 				<span class="sr-only">Toggle navigation</span> 				<span class="icon-bar"></span> 				<span class="icon-bar"></span> 				<span class="icon-bar"></span> 			</button> 			<div class="epan-component epan-sortable-component editor navbar-brand ui-sortable editor-attached" component_type="Container" component_namespace="baseElements" contenteditable="true"><br></div> 		</div> 	 		<!-- Collect the nav links, forms, and other content for toggling --> 		<div class="collapse navbar-collapse navbar-ex1-collapse"> 			<ul id="xMenu-boostrap-ul" class="nav navbar-nav ui-sortable">\n<li class=""><a href="index.php?subpage=home">Home</a></li>\n<li class=""><a href="index.php?subpage=test">Test</a></li>\n</ul>\n<div style="" class="epan-sortable-component epan-component navbar-form navbar-left ui-sortable" component_type="Container" component_namespace="baseElements"> 				 			</div> 			 		</div>\n<!-- /.navbar-collapse --> 		 </nav>\n</div>\n</div>\n<div id="6f772cba-9ec2-4d70-f471-529ac2dbf3c1" component_namespace="slideShows" component_type="AwesomeSlider" data-responsible-namespace="slideShows" data-responsible-view="View_Tools_AwesomeSlider" data-is-serverside-component="true" class="epan-component" style="" awesomeslider-theme="theme-bar"></div>\n<div id="310276f8-6313-4a27-ebe6-790c1a967565" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="margin-right: auto; margin-left: auto;"> 	 \n\n<div id="a2489d30-883e-4b01-ad8f-d0d504851cd6" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style=" "> 	 <div id="b6923cb8-0b3d-4816-9fb5-2933ef5e0473" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable" span="4" style=" "> 	 <div id="19027be9-315a-4608-c8ad-e61f3e63ff23" component_namespace="xShop" component_type="ItemImages" data-responsible-namespace="xShop" data-responsible-view="View_Tools_ItemImages" data-is-serverside-component="true" class="epan-component" style=""></div></div>\n<div id="7bebdb33-9903-41f2-d938-a7aeeb405408" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-8" span="8" style=" "> 	 <div id="6830d334-4211-4034-d724-618319fbece6" component_namespace="xShop" component_type="ItemDetail" data-responsible-namespace="xShop" data-responsible-view="View_Tools_ItemDetail" data-is-serverside-component="true" class="epan-component" style="" show-heading="1" show-image="1" show-item-date="1" show-item-code="1" show-item-name="1" show-item-review="1" show-cart-section="1" show-item-price="1" show-item-short-description="1" show-item-affiliate="1" item-affiliate-label="Affiliate" show-item-detail-in-tabs="1" item-detail-label="Item Details" show-item-specification="1" item-specification-label="Specification" show-item-enquiry-form="1" item-enquiry-form-label="Enquiryy" show-item-comment="1" show-item-tags="1" item-tag-label="Taggs" show-item-attachment="1"></div>\n</div>\n</div>\n</div>\n\n\n<div id="8b844368-1bf4-4e94-db11-e5eb7d37395f" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable navbar-inverse" style="margin: auto; padding-bottom: 1%;" data-extra-classes="navbar-inverse"> 	 <div id="f7e5a558-9dc2-4435-c42c-6be588ff0a27" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-4" span="4" style=" "> 	 <div id="cbb9eb77-e664-4e95-c932-970a5d6df074" component_namespace="baseElements" component_type="Text" class="editor epan-component editor-attached" style=" " contenteditable="true">\n<h2 style="font-family: ''Helvetica Neue'', Helvetica, sans-serif; color: white; margin-top: 0.9rem; background-color: rgb(34, 34, 34);"><b>Xavoc Technocrats Pvt.Ltd</b></h2>\n<div style="color: rgb(255, 255, 255); font-family: ''Allerta Stencil''; font-size: 12px; line-height: 17.142858505249px; background-color: rgb(34, 34, 34);" align="justify">Reg. Office: 18/436, Gaytri Marg,&nbsp;<br>Kanji ka hata, Dhabai Ji ka wada,<br>Udaipur (Rajasthan) -313001 (INDIA)<br>\n</div>\n<div style="color: rgb(255, 255, 255); font-family: ''Allerta Stencil''; font-size: 12px; line-height: 17.142858505249px; background-color: rgb(34, 34, 34);" align="left">\n<b>Email:</b>&nbsp;info@xavoc.com , &nbsp; &nbsp;management@xavoc.com<br><b>Call:</b>&nbsp;<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +91-9782300801<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; +91-8875191258</div>\n</div>\n</div>\n<div id="a8a926ca-2b96-48df-cd3b-73e82a9d4598" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable" span="4" style=" "> 	 <div id="8ef641e4-e8ef-4074-cf9c-2ade8c40790b" component_namespace="baseElements" component_type="HtmlBlock" class="epan-component" style=" "> <iframe scrolling="no" src="https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Xavoc+Technocrats+Pvt.+Ltd.,+University+Road+Udaipur,+Rajasthan&amp;aq=t&amp;sll=24.587202,73.710801&amp;sspn=0.185131,0.338173&amp;ie=UTF8&amp;hq=&amp;hnear=&amp;ll=24.588776,73.714278&amp;spn=0.006295,0.006295&amp;t=m&amp;iwloc=A&amp;output=embed" marginwidth="0" marginheight="0" frameborder="0" height="200" width="100%"></iframe> </div>\n</div>\n<div id="52ee454c-c6cd-49f7-d82c-b0489a4224f3" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-4" span="4" style=" "> 	 <div id="b9013951-5d1c-4fd2-b43f-748f6a555e10" component_namespace="baseElements" component_type="Title" class="epan-component" style="color: rgb(255, 255, 255);"><h2 class="editor editor-attached" contenteditable="true">This is Title</h2></div>\n\n<div id="849ac8e3-6e91-4559-e5c3-718c8b78939d" component_namespace="xEnquiryNSubscription" component_type="CustomeForm" data-responsible-namespace="xEnquiryNSubscription" data-responsible-view="View_Tools_CustomeForm" data-is-serverside-component="true" class="epan-component" style="color: rgb(0, 0, 0); padding: 2%; background-color: rgb(232, 232, 232);" data-options="1"></div>\n</div>\n</div>\n</div>', 'cursor: default; overflow: auto; background-image: url(http://localhost/primescan/epans/web/untitled%20folder%201/body-bg.gif);', '2015-03-24 06:36:21', '2015-03-24 06:49:07', '0', 1),
(5, NULL, 'cart', '', 1, 0, 'web', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '<div id="c793d6a5-50e1-4040-c290-5b4ddf539880" component_namespace="xShop" component_type="xCart" data-responsible-namespace="xShop" data-responsible-view="View_Tools_xCart" data-is-serverside-component="true" class="epan-component" style="" show-item-count="1" show-price-count="1" show-cart-items="1" show-cart-items-sno="1" show-cart-items-image="1" show-cart-items-name="1" show-cart-items-qty-rate="1" show-cart-items-delivery-info="1" show-cart-items-subtotal="1" show-cart-items-remove-btn="1" show-cart-total-estimate-bar="1" show-empty="1" show-checkout="0" show-cartdetail="1" show-proceed="1" cart-detail-page="cartt" cart-proceed-page="checkout" item-designer-page="design" show-cart-noauth-subpage="0"></div>', 'cursor: default; overflow: auto;', '2015-03-24 06:52:16', '2015-03-24 07:26:27', '0', 1),
(6, NULL, 'catt', '', 1, 0, 'web', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', NULL, NULL, '2015-03-24 06:54:25', '2015-03-24 06:54:26', '0', 1),
(7, NULL, 'design', '', 1, 0, 'web', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '<div id="7eda10f3-cc5e-4b37-b378-55e8469f19f3" component_namespace="baseElements" component_type="Title" class="epan-component" style="font-family: Annie Use Your Telescope;"> 	<h3 class="editor" contenteditable="true">This is Title</h3> </div><div id="072ecb42-1de3-4a74-8a1f-91683e2e021c" component_namespace="baseElements" component_type="Text" class="editor epan-component" style="color: rgb(255, 102, 0); font-family: Allan;" contenteditable="true"> 	Default Text </div><link href="http://fonts.googleapis.com/css?family=Aclonica" rel="stylesheet" type="text/css"><link href="http://fonts.googleapis.com/css?family=Allan" rel="stylesheet" type="text/css"><link href="http://fonts.googleapis.com/css?family=Annie+Use+Your+Telescope" rel="stylesheet" type="text/css"><link href="http://fonts.googleapis.com/css?family=Anonymous+Pro" rel="stylesheet" type="text/css"><link href="http://fonts.googleapis.com/css?family=Allerta+Stencil" rel="stylesheet" type="text/css"><link href="http://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet" type="text/css"><link href="http://fonts.googleapis.com/css?family=Anton" rel="stylesheet" type="text/css"><link href="http://fonts.googleapis.com/css?family=Architects+Daughter" rel="stylesheet" type="text/css">', 'cursor: default; overflow: auto;', '2015-03-24 06:54:32', '2015-03-24 12:09:32', '0', 1),
(8, NULL, 'checkout', '', 1, 0, 'web', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '<div id="6848434d-d71c-409c-d739-e67bbe7c4ce4" component_namespace="xShop" component_type="Checkout" data-responsible-namespace="xShop" data-responsible-view="View_Tools_Checkout" data-is-serverside-component="true" class="epan-component component-outline" style="" xshop_checkout_noauth_subpage_url="off" xshop_checkout_noauth_view="on"></div>\n<div id="27413132-0bff-4f32-850f-92ec43a07d03" component_namespace="xShop" component_type="Checkout" data-responsible-namespace="xShop" data-responsible-view="View_Tools_Checkout" data-is-serverside-component="true" class="epan-component  component-outline" style="" xshop_checkout_noauth_subpage_url="off" xshop_checkout_noauth_view="on"></div>', 'cursor: default;', '2015-03-24 06:54:39', '2015-03-24 07:41:46', '0', 1),
(9, NULL, 'cartt', NULL, 1, 0, 'web', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '<div id="c7401844-1d8e-47e1-a03b-db2b0fcc21b8" component_namespace="xShop" component_type="xCart" data-responsible-namespace="xShop" data-responsible-view="View_Tools_xCart" data-is-serverside-component="true" class="epan-component" style="" show-item-count="1" show-price-count="1" show-cart-items="1" show-cart-items-sno="1" show-cart-items-image="1" show-cart-items-name="1" show-cart-items-qty-rate="1" show-cart-items-delivery-info="1" show-cart-items-subtotal="1" show-cart-items-remove-btn="1" show-cart-total-estimate-bar="1" show-empty="1" show-checkout="1" show-cartdetail="1" show-proceed="1" cart-proceed-page="checkout" cart-detail-page="cart" item-designer-page="design"></div>', 'cursor: default;', '2015-03-24 06:55:18', '2015-03-24 07:21:39', 'public', 1);

-- --------------------------------------------------------

--
-- Table structure for table `epan_page_snapshots`
--

CREATE TABLE IF NOT EXISTS `epan_page_snapshots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_page_id` int(11) DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `updated_on` datetime DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `keywords` text,
  `description` text,
  `body_attributes` text,
  `content` text,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `epan_templates`
--

CREATE TABLE IF NOT EXISTS `epan_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `body_attributes` text,
  `content` text,
  `is_current` tinyint(1) DEFAULT NULL,
  `css` text,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan_templates`
--

INSERT INTO `epan_templates` (`id`, `epan_id`, `name`, `body_attributes`, `content`, `is_current`, `css`) VALUES
(1, 1, 'default', 'cursor: default;', '<div id="6b9c7e51-526c-41f1-c404-66b136b60a83" component_namespace="baseElements" component_type="TemplateContentRegion" class="epan-sortable-component epan-component  ui-sortable" style="display: block; opacity: 1; margin-bottom: 5px; height: auto;" contenteditable="false">~~Content~~</div>', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `filestore_file`
--

CREATE TABLE IF NOT EXISTS `filestore_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filestore_type_id` int(11) NOT NULL DEFAULT '0',
  `filestore_volume_id` int(11) NOT NULL DEFAULT '0',
  `filename` varchar(255) NOT NULL DEFAULT '',
  `original_filename` varchar(255) DEFAULT NULL,
  `filesize` int(11) NOT NULL DEFAULT '0',
  `filenum` int(11) NOT NULL DEFAULT '0',
  `deleted` varchar(2) DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `filestore_file`
--

INSERT INTO `filestore_file` (`id`, `filestore_type_id`, `filestore_volume_id`, `filename`, `original_filename`, `filesize`, `filenum`, `deleted`) VALUES
(1, 2, 1, '0/20150324065139_1_thumb-xci.jpeg', 'thumb_xci.jpeg', 3770, 0, '0'),
(2, 2, 1, '0/20150324065139__xci.jpeg', 'xci.jpeg', 11514, 0, '0'),
(3, 2, 1, '0/20150324065139__xci.jpeg', 'xci.jpeg', 11514, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `filestore_image`
--

CREATE TABLE IF NOT EXISTS `filestore_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `original_file_id` int(11) NOT NULL DEFAULT '0',
  `thumb_file_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `filestore_image`
--

INSERT INTO `filestore_image` (`id`, `name`, `original_file_id`, `thumb_file_id`) VALUES
(1, NULL, 2, 1),
(2, NULL, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `filestore_type`
--

CREATE TABLE IF NOT EXISTS `filestore_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `mime_type` varchar(64) NOT NULL DEFAULT '',
  `extension` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `filestore_type`
--

INSERT INTO `filestore_type` (`id`, `name`, `mime_type`, `extension`) VALUES
(1, 'png', 'image/png', 'png'),
(2, 'jpeg', 'image/jpeg', 'jpeg'),
(3, 'gif', 'image/gif', 'gif'),
(4, 'jpg', 'image/jpg', 'jpg');

-- --------------------------------------------------------

--
-- Table structure for table `filestore_volume`
--

CREATE TABLE IF NOT EXISTS `filestore_volume` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `dirname` varchar(255) NOT NULL DEFAULT '',
  `total_space` bigint(20) NOT NULL DEFAULT '0',
  `used_space` bigint(20) NOT NULL DEFAULT '0',
  `stored_files_cnt` int(11) NOT NULL DEFAULT '0',
  `enabled` enum('Y','N') DEFAULT 'Y',
  `last_filenum` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `filestore_volume`
--

INSERT INTO `filestore_volume` (`id`, `name`, `dirname`, `total_space`, `used_space`, `stored_files_cnt`, `enabled`, `last_filenum`) VALUES
(1, 'upload', 'upload', 1000000000, 0, 192, 'Y', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `last_seen_updates`
--

CREATE TABLE IF NOT EXISTS `last_seen_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `seen_till` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_employee_id` (`employee_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=83 ;

--
-- Dumping data for table `last_seen_updates`
--

INSERT INTO `last_seen_updates` (`id`, `employee_id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `seen_till`) VALUES
(1, 2, NULL, 'xStore\\DispatchRequest', 'xDispatch\\DispatchRequest_Draft', '2015-03-23 11:03:11'),
(2, NULL, NULL, 'Application', 'xShop\\Shop', '2015-03-22 12:10:01'),
(3, 2, NULL, 'Application', 'xShop\\Shop', '2015-03-23 09:48:22'),
(4, 2, NULL, 'xShop\\Order', 'xShop\\Order_Draft', '2015-03-23 10:38:57'),
(5, 2, NULL, 'xShop\\TermsAndCondition', 'xShop\\TermsAndCondition', '2015-03-23 06:03:04'),
(6, 2, NULL, 'xShop\\OrderDetails', 'xShop\\OrderDetails', '2015-03-23 10:34:39'),
(7, 2, NULL, 'xShop\\Order', 'xShop\\Order_Submitted', '2015-03-23 10:34:14'),
(8, 2, NULL, 'xShop\\Order', 'xShop\\Order_Approved', '2015-03-23 09:47:54'),
(9, 2, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Approved', '2015-03-23 09:48:38'),
(10, 2, NULL, 'xCRM\\Activity', 'xCRM\\Activity', '2015-03-23 06:32:06'),
(11, 2, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Received', '2015-03-23 06:36:02'),
(12, 2, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Processing', '2015-03-23 10:22:21'),
(13, 2, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Assigned', '2015-03-23 06:32:00'),
(14, 2, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Processed', '2015-03-23 10:40:38'),
(15, 2, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Forwarded', '2015-03-23 10:40:51'),
(16, 2, NULL, 'xShop\\Order', 'xShop\\Order_Processed', '2015-03-23 10:39:06'),
(17, 2, NULL, 'xShop\\Order', 'xShop\\Order_Processing', '2015-03-23 10:39:02'),
(18, 2, NULL, 'xShop\\SalesOrderAttachment', 'xShop\\SalesOrderAttachment', '2015-03-23 06:30:50'),
(19, 2, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Completed', '2015-03-23 10:40:40'),
(20, 2, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Cancelled', '2015-03-23 06:40:28'),
(21, 2, NULL, 'xShop\\Quotation', 'xShop\\Quotation_Submitted', '2015-03-23 10:38:59'),
(22, 2, NULL, 'xShop\\Quotation', 'xShop\\Quotation_Draft', '2015-03-23 10:40:24'),
(23, 2, NULL, 'xStore\\MaterialRequestSent', 'xStore\\MaterialRequestSent_Draft', '2015-03-23 11:03:14'),
(24, 2, NULL, 'xMarketingCampaign\\Lead', 'xMarketingCampaign\\Lead', '2015-03-23 06:47:49'),
(25, 2, NULL, 'xShop\\Opportunity', 'xShop\\Opportunity', '2015-03-23 06:48:37'),
(26, 2, NULL, 'QuotationItem', 'xShop\\QuotationItem', '2015-03-23 08:03:37'),
(27, 2, NULL, 'xShop\\Quotation', 'xShop\\Quotation_Redesign', '2015-03-23 06:55:21'),
(28, 2, NULL, 'xShop\\Order', 'xShop\\Order_Completed', '2015-03-23 07:32:43'),
(29, 2, NULL, 'xShop\\Order', 'xShop\\Order_Redesign', '2015-03-23 07:33:57'),
(30, 2, NULL, 'xDispatch\\DeliveyNote', 'xDispatch\\DeliveryNote_Draft', '2015-03-23 07:56:13'),
(31, 2, NULL, 'xDispatch\\DeliveyNote', 'xDispatch\\DeliveryNote_Processing', '2015-03-23 07:55:21'),
(32, 2, NULL, 'xDispatch\\DeliveyNote', 'xDispatch\\DeliveryNote_Assigned', '2015-03-23 07:55:25'),
(33, 2, NULL, 'xDispatch\\DeliveyNote', 'xDispatch\\DeliveryNote_Processed', '2015-03-23 07:55:27'),
(34, NULL, NULL, 'xStore\\DispatchRequest', 'xDispatch\\DispatchRequest_Draft', '2015-03-23 08:41:25'),
(35, NULL, NULL, 'xStore\\MaterialRequestSent', 'xStore\\MaterialRequestSent_Draft', '2015-03-23 08:41:32'),
(36, NULL, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Draft', '2015-03-23 08:42:01'),
(37, NULL, NULL, 'xShop\\Order', 'xShop\\Order_Draft', '2015-03-24 10:14:22'),
(38, 2, NULL, 'xStore\\DispatchRequest', 'xDispatch\\DispatchRequest_Submitted', '2015-03-23 09:37:57'),
(39, 2, NULL, 'Category', 'xShop\\Category', '2015-03-23 09:48:26'),
(40, 2, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Draft', '2015-03-23 10:11:42'),
(41, 2, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Submitted', '2015-03-23 09:48:36'),
(42, 2, NULL, 'xShop\\Order', 'xShop\\Order_Shipping', '2015-03-23 09:54:30'),
(43, 2, NULL, 'xStore\\DispatchRequest', 'xDispatch\\DispatchRequest_Processed', '2015-03-23 10:22:47'),
(44, 2, NULL, 'Priority', 'xShop\\Priority', '2015-03-23 10:00:29'),
(45, NULL, NULL, 'xMarketingCampaign\\Lead', 'xMarketingCampaign\\Lead', '2015-03-23 10:18:53'),
(46, 3, NULL, 'xMarketingCampaign\\Lead', 'xMarketingCampaign\\Lead', '2015-03-23 10:24:02'),
(47, 3, NULL, 'xCRM\\Activity', 'xCRM\\Activity', '2015-03-23 13:19:29'),
(48, 3, NULL, 'xStore\\MaterialRequestSent', 'xStore\\MaterialRequestSent_Draft', '2015-03-23 13:18:15'),
(49, 2, NULL, 'xStore\\DispatchRequest', 'xDispatch\\DispatchRequest_Assigned', '2015-03-23 10:22:46'),
(50, 3, NULL, 'xShop\\Order', 'xShop\\Order_Draft', '2015-03-23 13:18:40'),
(51, 3, NULL, 'xShop\\Order', 'xShop\\Order_Submitted', '2015-03-23 12:58:48'),
(52, 3, NULL, 'xShop\\MemberDetails', 'xShop\\Customer', '2015-03-23 12:10:17'),
(53, 3, NULL, 'xShop\\TermsAndCondition', 'xShop\\TermsAndCondition', '2015-03-23 12:09:55'),
(54, 3, NULL, 'xPurchase\\PurchaseOrder', 'xPurchase\\PurchaseOrder_Draft', '2015-03-23 12:17:54'),
(55, 3, NULL, 'xPurchase\\PurchaseOrder', 'xPurchase\\PurchaseOrder_Redesign', '2015-03-23 12:14:17'),
(56, 3, NULL, 'xProduction\\Task', 'xProduction\\Task_Assigned', '2015-03-23 12:16:05'),
(57, 3, NULL, 'xProduction\\Task', 'xProduction\\Task_Processing', '2015-03-23 12:16:04'),
(58, 3, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Draft', '2015-03-23 12:59:21'),
(59, 3, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Submitted', '2015-03-23 12:59:22'),
(60, 3, NULL, 'xShop\\Order', 'xShop\\Order_Approved', '2015-03-23 13:18:41'),
(61, 3, NULL, 'xShop\\Order', 'xShop\\Order_Processing', '2015-03-23 12:49:09'),
(62, 3, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Approved', '2015-03-23 13:00:34'),
(63, 3, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Received', '2015-03-23 12:59:14'),
(64, 3, NULL, 'xProduction\\JobCard', 'xProduction\\Jobcard_Assigned', '2015-03-23 12:48:42'),
(65, 3, NULL, 'xShop\\OrderDetails', 'xShop\\OrderDetails', '2015-03-23 13:12:58'),
(66, 3, NULL, 'xShop\\Order', 'xShop\\Order_Redesign', '2015-03-23 12:58:30'),
(67, 3, NULL, 'xStore\\MaterialRequestReceived', 'xStore\\MaterialRequestReceived_Approved', '2015-03-23 13:18:18'),
(68, 3, NULL, 'xStore\\MaterialRequestReceived', 'xStore\\MaterialRequestReceived_Received', '2015-03-23 13:06:55'),
(69, 3, NULL, 'xStore\\MaterialRequestSent', 'xStore\\MaterialRequestSent_Approved', '2015-03-23 13:17:08'),
(70, 3, NULL, 'xStore\\MaterialRequestReceived', 'xStore\\MaterialRequestReceived_Processing', '2015-03-23 13:03:25'),
(71, 3, NULL, 'xStore\\MaterialRequestReceived', 'xStore\\MaterialRequestReceived_Assigned', '2015-03-23 13:03:14'),
(72, 3, NULL, 'xStore\\MaterialRequestReceived', 'xStore\\MaterialRequestReceived_Processed', '2015-03-23 13:07:00'),
(73, 3, NULL, 'xStore\\MaterialRequestSent', 'xStore\\MaterialRequestSent_Processed', '2015-03-23 13:08:51'),
(74, 3, NULL, 'xStore\\MaterialRequestSent', 'xStore\\MaterialRequestSent_Completed', '2015-03-23 13:19:29'),
(75, 3, NULL, 'xStore\\MaterialRequestReceived', 'xStore\\MaterialRequestReceived_Completed', '2015-03-23 13:16:34'),
(76, 3, NULL, 'xStore\\MaterialRequestSent', 'xStore\\MaterialRequestSent_Processing', '2015-03-23 13:08:50'),
(77, 3, NULL, 'xStore\\MaterialRequestSent', 'xStore\\MaterialRequestSent_Cancelled', '2015-03-23 13:19:25'),
(78, 3, NULL, 'xStore\\MaterialRequestSent', 'xStore\\MaterialRequestSent_Received', '2015-03-23 13:17:09'),
(79, NULL, NULL, 'Category', 'xShop\\Category', '2015-03-24 09:00:23'),
(80, NULL, NULL, 'xShop\\Order', 'xShop\\Order_Submitted', '2015-03-24 10:14:17'),
(81, NULL, NULL, 'xShop\\Opportunity', 'xShop\\Opportunity', '2015-03-25 09:25:45'),
(82, 3, NULL, 'xShop\\Opportunity', 'xShop\\Opportunity', '2015-03-24 10:28:43');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `message` text,
  `created_at` datetime DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `sender_signature` varchar(255) DEFAULT NULL,
  `watch` tinyint(1) DEFAULT NULL,
  `sender_namespace` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `epan_id`, `name`, `message`, `created_at`, `is_read`, `sender_signature`, `watch`, `sender_namespace`) VALUES
(1, 1, 'Custom Form Entry', '<b>first name</b> : vijay<br/><b>last name</b> : mali<br/><b>Mobile No: </b> : 9784954128<br/><b>Email </b> : vijay.mali552@gmail.com<br/><b>Gander</b> : Male<br/>', '2015-03-24 09:40:52', 1, 'Custom Enquiry Form', 1, 'xEnquiryNSubscription'),
(2, 1, 'Custom Form Entry', '<b>first name</b> : Gowrav<br/><b>last name</b> : vishwarkarma<br/><b>Mobile No: </b> : 75675675<br/><b>Email </b> : info@xavoc.com<br/><b>Gander</b> : Male<br/>', '2015-03-24 09:52:59', 1, 'Custom Enquiry Form', 0, 'xEnquiryNSubscription'),
(3, 1, 'Custom Form Entry', '<b>first name</b> : vijay<br/><b>last name</b> : mali<br/><b>Mobile No: </b> : 7665036690<br/><b>Email </b> : vijay.mali552@gmail.com<br/><b>Gander</b> : Male<br/>', '2015-03-25 06:03:43', 1, 'Custom Enquiry Form', 0, 'xEnquiryNSubscription'),
(4, 1, 'Custom Form Entry', '<b>first name</b> : rakesh<br/><b>last name</b> : sinha<br/><b>Mobile No: </b> : 874984654654<br/><b>Email </b> : rksinha.btech@gmail.com<br/><b>Gander</b> : Male<br/>', '2015-03-25 06:11:49', 1, 'Custom Enquiry Form', 0, 'xEnquiryNSubscription');

-- --------------------------------------------------------

--
-- Table structure for table `slideshows_awesomeimages`
--

CREATE TABLE IF NOT EXISTS `slideshows_awesomeimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `order_no` int(11) DEFAULT NULL,
  `effects` varchar(255) DEFAULT NULL,
  `is_publish` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_id` (`gallery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `slideshows_awesomeimages`
--

INSERT INTO `slideshows_awesomeimages` (`id`, `gallery_id`, `image`, `tag`, `order_no`, `effects`, `is_publish`) VALUES
(1, 1, 'epans/web/images.jpeg', '', 1, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `slideshows_awesomeslider`
--

CREATE TABLE IF NOT EXISTS `slideshows_awesomeslider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `pause_time` varchar(255) DEFAULT NULL,
  `on_hover` tinyint(1) DEFAULT NULL,
  `control_nav` tinyint(1) DEFAULT NULL,
  `image_paginator` varchar(255) DEFAULT NULL,
  `folder_path` varchar(255) DEFAULT NULL,
  `is_publish` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `slideshows_awesomeslider`
--

INSERT INTO `slideshows_awesomeslider` (`id`, `epan_id`, `name`, `pause_time`, `on_hover`, `control_nav`, `image_paginator`, `folder_path`, `is_publish`) VALUES
(1, 1, 'demo', '3000', 1, 1, NULL, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `slideShows_thumbnailslidergallery`
--

CREATE TABLE IF NOT EXISTS `slideShows_thumbnailslidergallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `scroll_intervarl` varchar(255) DEFAULT NULL,
  `scroll_duration` varchar(255) DEFAULT NULL,
  `on_hover` tinyint(1) DEFAULT NULL,
  `autoAdvance` tinyint(1) DEFAULT NULL,
  `scroll_by_each_thumb` tinyint(1) DEFAULT NULL,
  `is_publish` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `slideShows_thumbnailslidergallery`
--

INSERT INTO `slideShows_thumbnailslidergallery` (`id`, `epan_id`, `name`, `direction`, `scroll_intervarl`, `scroll_duration`, `on_hover`, `autoAdvance`, `scroll_by_each_thumb`, `is_publish`) VALUES
(1, 1, 'thumb', 'horizontal', '2400', '1200', 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `slideShows_thumbnailsliderimages`
--

CREATE TABLE IF NOT EXISTS `slideShows_thumbnailsliderimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `tooltip` text,
  `order_no` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_id` (`gallery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `slideShows_thumbnailsliderimages`
--

INSERT INTO `slideShows_thumbnailsliderimages` (`id`, `gallery_id`, `image`, `tooltip`, `order_no`, `description`) VALUES
(1, 1, 'epans/web/bigstock-E-commerce-Shopping-cart-with-56191391-300x200.jpg', '', 1, ''),
(2, 1, 'epans/web/Google-Image-Optimization1.jpg', '', 2, ''),
(3, 1, 'epans/web/wpid-Web_Design_70-300x200.jpg', '', 3, ''),
(4, 1, 'epans/web/seo-puzzle-piece-300x200.jpg', 'web poretal\r\n', 4, '');

-- --------------------------------------------------------

--
-- Table structure for table `slideShows_transformgallery`
--

CREATE TABLE IF NOT EXISTS `slideShows_transformgallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `autoplay` tinyint(1) DEFAULT NULL,
  `interval` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `slideShows_transformgallery`
--

INSERT INTO `slideShows_transformgallery` (`id`, `epan_id`, `name`, `autoplay`, `interval`) VALUES
(1, 1, 'transform', 1, '2000');

-- --------------------------------------------------------

--
-- Table structure for table `slideShows_transformgalleryimages`
--

CREATE TABLE IF NOT EXISTS `slideShows_transformgalleryimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_id` (`gallery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `slideShows_transformgalleryimages`
--

INSERT INTO `slideShows_transformgalleryimages` (`id`, `gallery_id`, `image`, `name`) VALUES
(1, 1, 'epans/web/single_property_websites_templates.jpg', ''),
(2, 1, 'epans/web/webportal.jpg', ''),
(3, 1, 'epans/web/univeral-ts-thumb-600x358.png', ''),
(4, 1, 'epans/web/SimpleCart-eCommerce-WordPress-Theme.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `slideShows_waterwheelgallery`
--

CREATE TABLE IF NOT EXISTS `slideShows_waterwheelgallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `show_item` varchar(255) DEFAULT NULL,
  `is_publish` tinyint(1) DEFAULT NULL,
  `separation` varchar(255) DEFAULT NULL,
  `size_multiplier` varchar(255) DEFAULT NULL,
  `opacity` varchar(255) DEFAULT NULL,
  `animation` varchar(255) DEFAULT NULL,
  `autoPlay` varchar(255) DEFAULT NULL,
  `orientation` varchar(255) DEFAULT NULL,
  `keyboard_Nav` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `slideShows_waterwheelgallery`
--

INSERT INTO `slideShows_waterwheelgallery` (`id`, `epan_id`, `name`, `show_item`, `is_publish`, `separation`, `size_multiplier`, `opacity`, `animation`, `autoPlay`, `orientation`, `keyboard_Nav`) VALUES
(1, 1, 'demo', '3', 1, '175', '0.7', '0.8', NULL, '3000', 'horizontal', 0);

-- --------------------------------------------------------

--
-- Table structure for table `slideShows_waterwheelimages`
--

CREATE TABLE IF NOT EXISTS `slideShows_waterwheelimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `is_publish` tinyint(1) DEFAULT NULL,
  `start_item` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_id` (`gallery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `slideShows_waterwheelimages`
--

INSERT INTO `slideShows_waterwheelimages` (`id`, `gallery_id`, `image`, `description`, `is_publish`, `start_item`) VALUES
(5, 1, 'epans/web/single_property_websites_templates.jpg', '', 1, 0),
(6, 1, 'epans/web/univeral-ts-thumb-600x358.png', '', 1, 0),
(7, 1, 'epans/web/SimpleCart-eCommerce-WordPress-Theme.png', '', 1, 0),
(8, 1, 'epans/web/online_shopping_ecommerce_website_design.jpg', '', 1, 0),
(9, 1, 'epans/web/webportal.jpg', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `access_level` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_staff_branche1` (`branch_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `userappaccess`
--

CREATE TABLE IF NOT EXISTS `userappaccess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `installed_app_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_allowed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_installed_app_id` (`installed_app_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=77 ;

--
-- Dumping data for table `userappaccess`
--

INSERT INTO `userappaccess` (`id`, `epan_id`, `user_id`, `installed_app_id`, `created_at`, `is_allowed`) VALUES
(6, 1, 1, 23, '2014-12-18 10:15:35', 1),
(7, 1, 1, 25, '2014-12-18 10:15:35', 1),
(8, 1, 1, 26, '2014-12-18 10:15:35', 1),
(9, 1, 1, 27, '2014-12-18 10:15:35', 1),
(10, 1, 1, 28, '2014-12-18 10:15:35', 1),
(11, 1, 1, 29, '2014-12-18 10:15:35', 1),
(12, 1, 1, 30, '2014-12-18 10:15:35', 1),
(13, 1, 1, 31, '2014-12-18 10:15:35', 1),
(14, 1, 1, 32, '2014-12-18 10:15:35', 1),
(15, 1, 1, 33, '2014-12-18 10:15:35', 1),
(16, 1, 1, 34, '2014-12-18 10:15:35', 1),
(18, 1, 1, 35, '2015-02-14 04:53:25', 1),
(30, 1, 1, 36, '2015-02-16 09:50:18', 1),
(31, 1, 1, 37, '2015-02-16 10:45:44', 1),
(32, 1, 1, 38, '2015-02-16 10:46:25', 1),
(33, 1, 1, 39, '2015-02-16 10:46:35', 1),
(36, 1, 1, 40, '2015-02-16 10:46:35', 1),
(37, 1, 3, 33, '2015-03-20 06:36:38', 1),
(38, 1, 2, 33, '2015-03-20 11:22:30', 1),
(39, 1, 2, 38, '2015-03-20 11:22:30', 1),
(40, 1, 3, 38, '2015-03-20 11:22:51', 1),
(41, 1, 8, 33, '2015-03-20 11:23:24', 1),
(42, 1, 8, 38, '2015-03-20 11:23:25', 1),
(43, 1, 9, 33, '2015-03-20 11:23:46', 1),
(44, 1, 9, 38, '2015-03-20 11:23:46', 1),
(45, 1, 10, 33, '2015-03-20 11:24:03', 1),
(46, 1, 10, 38, '2015-03-20 11:24:03', 1),
(47, 1, 5, 33, '2015-03-20 11:24:46', 1),
(48, 1, 5, 38, '2015-03-20 11:24:46', 1),
(49, 1, 14, 33, '2015-03-20 12:01:13', 1),
(50, 1, 14, 38, '2015-03-20 12:01:13', 1),
(51, 1, 24, 33, '2015-03-20 12:19:17', 1),
(52, 1, 24, 38, '2015-03-20 12:19:17', 1),
(53, 1, 3, 35, '2015-03-21 09:07:10', 1),
(54, 1, 2, 35, '2015-03-21 10:10:51', 1),
(55, 1, 4, 31, '2015-03-21 10:30:49', 1),
(56, 1, 4, 23, '2015-03-21 10:32:47', 1),
(57, 1, 4, 25, '2015-03-21 10:32:47', 1),
(58, 1, 4, 26, '2015-03-21 10:32:47', 1),
(59, 1, 4, 27, '2015-03-21 10:32:47', 1),
(60, 1, 4, 28, '2015-03-21 10:32:47', 1),
(61, 1, 4, 29, '2015-03-21 10:32:47', 1),
(62, 1, 4, 30, '2015-03-21 10:32:47', 1),
(63, 1, 4, 32, '2015-03-21 10:32:47', 1),
(64, 1, 4, 33, '2015-03-21 10:32:47', 1),
(65, 1, 4, 34, '2015-03-21 10:32:47', 1),
(66, 1, 4, 35, '2015-03-21 10:32:47', 1),
(67, 1, 4, 36, '2015-03-21 10:32:47', 1),
(68, 1, 4, 37, '2015-03-21 10:32:47', 1),
(69, 1, 4, 38, '2015-03-21 10:32:47', 1),
(70, 1, 4, 39, '2015-03-21 10:32:47', 1),
(71, 1, 4, 40, '2015-03-21 10:32:47', 1),
(72, 1, 3, 37, '2015-03-21 10:49:03', 1),
(73, 1, 3, 39, '2015-03-21 10:49:03', 1),
(74, 1, 3, 40, '2015-03-21 10:49:03', 1),
(75, 1, 3, 31, '2015-03-23 06:46:48', 1),
(76, 1, 3, 34, '2015-03-25 12:53:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `last_login_date` date DEFAULT NULL,
  `user_management` tinyint(1) DEFAULT NULL,
  `general_settings` tinyint(1) DEFAULT NULL,
  `application_management` tinyint(1) DEFAULT NULL,
  `website_designing` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `epan_id`, `name`, `username`, `password`, `created_at`, `type`, `email`, `is_active`, `activation_code`, `last_login_date`, `user_management`, `general_settings`, `application_management`, `website_designing`) VALUES
(1, 1, 'admin', 'admin', 'admin', '2015-03-20', '100', 'support@xavoc.com', 1, NULL, NULL, 1, 1, 1, 1),
(2, 1, 'Ayushi', 'ayushi', '123', '2015-03-20', '80', 'ayushijain559@gmail.com', 1, NULL, NULL, 1, 0, 0, 0),
(3, 1, 'Rakesh', 'rakesh', '123', '2015-03-20', '80', 'rksinha.btech@gmail.com', 1, NULL, NULL, 1, 0, 0, 0),
(4, 1, 'Vijay', 'vijay', '123', '2015-03-20', '80', 'vijay@gmail.com', 1, NULL, NULL, 1, 0, 0, 0),
(5, 1, 'Designing Employee', 'DesigningEmployee', '123', '2015-03-20', '80', 'info@xavoc.com', 1, NULL, NULL, 0, 0, 0, 0),
(6, 1, 'Designing HOD', 'DesigningHOD', '123', '2015-03-20', '80', 'info@xavoc1.com', 1, NULL, NULL, 0, 0, 0, 0),
(7, 1, 'LFP HOD', 'LFPHOD', '123', '2015-03-20', '80', 'info@xavoc2.com', 1, NULL, NULL, 0, 0, 0, 0),
(8, 1, 'LFP Employee', 'LFPEmployee', '123', '2015-03-20', '80', 'info@LFPEmployee.com', 1, NULL, NULL, 0, 0, 0, 0),
(9, 1, 'SP Employee', 'SPEmployee', '123', '2015-03-20', '80', 'info@SPEmployee.com', 1, NULL, NULL, 0, 0, 0, 0),
(10, 1, 'SP HOD', 'SPHOD', '123', '2015-03-20', '80', 'info@SPHOD.com', 1, NULL, NULL, 0, 0, 0, 0),
(11, 1, 'Offset HOD', 'OffsetHOD', '123', '2015-03-20', '80', 'info@OffsetHOD.com', 1, NULL, NULL, 0, 0, 0, 0),
(12, 1, 'Offset Employee', 'OffsetEmployee', '123', '2015-03-20', '80', 'info@OffsetEmployee.com', 1, NULL, NULL, 0, 0, 0, 0),
(13, 1, 'DP HOD', 'DPHOD', '123', '2015-03-20', '80', 'info@DPHOD.com', 1, NULL, NULL, 0, 0, 0, 0),
(14, 1, 'Dp Employee', 'dpemployee', '132', '2015-03-20', '80', 'info@DpEmployee.com', 1, NULL, NULL, 0, 0, 0, 0),
(15, 1, 'Coating Employee', 'CoatingEmployee', '123', '2015-03-20', '80', 'info@CoatingEmployeee.com', 1, NULL, NULL, 0, 0, 0, 0),
(16, 1, 'Coating HOD', 'CoatingHOD', '123', '2015-03-20', '80', 'info@CoatingHOD.com', 1, NULL, NULL, 0, 0, 0, 0),
(17, 1, 'Cutting Employee', 'CuttingEmployee', '123', '2015-03-20', '80', 'info@CuttingEmployee.com', 1, NULL, NULL, 0, 0, 0, 0),
(18, 1, 'Cutting HOD', 'CuttingHOD', '123', '2015-03-20', '80', 'info@CuttingHOD.com', 1, NULL, NULL, 0, 0, 0, 0),
(19, 1, 'Varnish Employee', 'VarnishEmployee', '123', '2015-03-20', '80', 'info@VarnishEmployee.com', 1, NULL, NULL, 0, 0, 0, 0),
(20, 1, 'Lamination Employee', 'LaminationEmployee', '123', '2015-03-20', '80', 'info@LaminationEmployee.com', 1, NULL, NULL, 0, 0, 0, 0),
(21, 1, 'Binding Employee', 'Binding Employee', '123', '2015-03-20', '80', 'be@hmail.com', 1, NULL, NULL, 0, 0, 0, 0),
(22, 1, 'VarnishHOD', 'VarnishHOD', '123', '2015-03-20', '80', 'info@VarnishHOD.com', 1, NULL, NULL, 0, 0, 0, 0),
(23, 1, 'Die Cut Employee', 'Die Cut Employee', '123', '2015-03-20', '80', 'dce@gmail.com', 1, NULL, NULL, 0, 0, 0, 0),
(24, 1, 'Uv Employee', 'UvEmployee', '123', '2015-03-20', '80', 'info@UvEmployee.com', 1, NULL, NULL, 0, 0, 0, 0),
(25, 1, 'Binding HOD', 'Binding HOD', '123', '2015-03-20', '80', 'bh@gmail.com', 1, NULL, NULL, 0, 0, 0, 0),
(26, 1, 'Lamination HOD', 'LaminationHOD', '123', '2015-03-20', '80', 'info@LaminationHOD.com', 1, NULL, NULL, 0, 0, 0, 0),
(27, 1, 'Die Cut HOD', 'die cut hod', '123', '2015-03-20', '80', 'dch@gmail.com', 1, NULL, NULL, 0, 0, 0, 0),
(28, 1, 'HotFoil Employee', 'HotFoilEmployee', '123', '2015-03-20', '80', 'info@HotFoilEmployee.com', 1, NULL, NULL, 0, 0, 0, 0),
(29, 1, 'UV HOD', 'UV HOD', '123', '2015-03-20', '80', 'uvh@gmail.com', 1, NULL, NULL, 0, 0, 0, 0),
(30, 1, 'Hot Foil HOD', 'HotFoilHOD', '123', '2015-03-20', '80', 'info@HotFoilHOD.com', 1, NULL, NULL, 0, 0, 0, 0),
(59, NULL, 'Ramesh', '', '', NULL, '50', 'ramesh@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, NULL, 'Ayushi', '', '', NULL, '50', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_custom_fields`
--

CREATE TABLE IF NOT EXISTS `user_custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_expandable` tinyint(1) DEFAULT NULL,
  `set_value` varchar(255) DEFAULT NULL,
  `mandatory` tinyint(1) DEFAULT NULL,
  `change` text,
  `is_editable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xai_blocks`
--

CREATE TABLE IF NOT EXISTS `xai_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `dimension_id` int(11) DEFAULT NULL,
  `iblock_id` varchar(255) DEFAULT NULL,
  `parent_iblock_id` varchar(255) DEFAULT NULL,
  `subpage` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_dimension_id` (`dimension_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xai_config`
--

CREATE TABLE IF NOT EXISTS `xai_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `keep_site_constant_for_session` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xai_data`
--

CREATE TABLE IF NOT EXISTS `xai_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) DEFAULT NULL,
  `name` text,
  PRIMARY KEY (`id`),
  KEY `fk_session_id` (`session_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=492 ;

--
-- Dumping data for table `xai_data`
--

INSERT INTO `xai_data` (`id`, `session_id`, `name`) VALUES
(1, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(2, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(3, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(4, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(5, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(6, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(7, 2, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(8, 2, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(9, 2, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(10, 2, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(11, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(12, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(13, 3, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(14, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(15, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(16, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(17, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(18, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(19, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(20, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(21, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(22, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(23, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(24, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(25, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(26, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(27, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(28, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(29, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(30, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(31, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(32, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(33, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(34, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(35, 2, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(36, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(37, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(38, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(39, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(40, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(41, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(42, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(43, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(44, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(45, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(46, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(47, 3, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(48, 4, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(49, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(50, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(51, 4, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(52, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(53, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(54, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(55, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(56, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(57, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(58, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(59, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(60, 5, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(61, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(62, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(63, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(64, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(65, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(66, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(67, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(68, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(69, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(70, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(71, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(72, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(73, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(74, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(75, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(76, 6, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(77, 7, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(78, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(79, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(80, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(81, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(82, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(83, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(84, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(85, 8, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(86, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(87, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(88, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(89, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(90, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(91, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(92, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(93, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(94, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(95, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(96, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(97, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(98, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(99, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(100, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(101, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(102, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(103, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(104, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(105, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(106, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(107, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(108, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(109, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(110, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(111, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(112, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(113, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(114, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(115, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(116, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(117, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(118, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(119, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(120, 10, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(121, 10, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(122, 10, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(123, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(124, 10, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(125, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(126, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(127, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(128, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(129, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(130, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(131, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(132, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(133, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(134, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(135, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(136, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(137, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(138, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(139, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(140, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(141, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(142, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(143, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(144, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(145, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(146, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(147, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(148, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(149, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(150, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(151, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(152, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(153, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(154, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(155, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(156, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(157, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(158, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(159, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(160, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(161, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(162, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(163, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(164, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(165, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(166, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(167, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(168, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(169, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(170, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(171, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(172, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(173, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(174, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(175, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(176, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(177, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(178, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(179, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(180, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(181, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(182, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(183, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(184, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(185, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(186, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(187, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(188, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(189, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(190, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(191, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(192, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(193, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(194, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(195, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(196, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(197, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(198, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(199, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(200, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(201, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(202, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(203, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(204, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(205, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(206, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(207, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(208, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(209, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(210, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(211, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(212, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(213, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(214, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(215, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(216, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(217, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(218, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(219, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(220, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(221, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(222, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(223, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(224, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(225, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(226, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(227, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(228, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(229, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(230, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(231, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(232, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(233, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(234, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(235, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(236, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(237, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(238, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(239, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(240, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(241, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(242, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(243, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(244, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(245, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(246, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(247, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(248, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(249, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(250, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(251, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(252, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(253, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(254, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(255, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(256, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(257, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(258, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(259, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(260, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(261, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(262, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(263, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(264, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(265, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(266, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(267, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(268, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(269, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(270, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(271, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(272, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(273, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(274, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(275, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(276, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(277, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(278, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(279, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(280, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(281, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(282, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(283, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(284, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(285, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(286, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(287, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(288, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(289, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(290, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(291, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(292, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(293, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(294, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(295, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(296, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(297, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(298, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(299, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(300, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(301, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(302, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(303, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(304, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(305, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(306, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(307, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(308, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(309, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(310, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(311, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(312, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(313, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(314, 11, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(315, 11, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(316, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(317, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(318, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(319, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(320, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(321, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(322, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(323, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(324, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(325, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(326, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(327, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(328, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(329, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(330, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(331, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(332, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(333, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(334, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(335, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(336, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(337, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(338, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(339, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(340, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(341, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(342, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(343, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(344, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(345, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(346, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(347, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(348, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(349, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(350, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(351, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(352, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(353, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(354, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(355, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(356, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(357, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(358, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(359, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(360, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(361, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(362, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(363, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(364, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(365, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(366, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(367, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(368, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(369, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(370, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(371, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(372, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(373, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(374, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(375, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(376, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(377, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(378, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(379, 12, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(380, 12, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(381, 12, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(382, 12, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(383, 12, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(384, 12, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(385, 12, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(386, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(387, 12, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(388, 13, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(389, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(390, 14, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(391, 14, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(392, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(393, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(394, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(395, 14, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(396, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(397, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(398, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(399, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(400, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(401, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(402, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(403, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(404, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(405, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(406, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(407, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(408, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(409, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(410, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(411, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(412, 14, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(413, 14, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(414, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(415, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(416, 14, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(417, 14, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(418, 14, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(419, 14, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(420, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(421, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(422, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(423, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(424, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(425, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(426, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(427, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(428, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(429, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(430, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(431, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(432, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(433, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(434, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(435, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(436, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(437, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(438, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(439, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(440, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(441, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(442, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(443, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(444, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(445, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(446, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(447, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(448, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(449, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(450, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(451, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(452, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(453, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(454, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(455, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(456, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(457, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(458, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(459, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(460, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(461, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(462, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(463, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(464, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(465, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(466, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(467, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(468, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(469, 17, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(470, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(471, 18, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(472, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(473, 19, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(474, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(475, 20, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(476, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(477, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(478, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(479, 22, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(480, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(481, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(482, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(483, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(484, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(485, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(486, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(487, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(488, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(489, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(490, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(491, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}');

-- --------------------------------------------------------

--
-- Table structure for table `xai_dimension`
--

CREATE TABLE IF NOT EXISTS `xai_dimension` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xai_Human`
--

CREATE TABLE IF NOT EXISTS `xai_Human` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xai_information`
--

CREATE TABLE IF NOT EXISTS `xai_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` int(11) DEFAULT NULL,
  `data_id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `meta_information_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_session_id` (`session_id`),
  KEY `fk_data_id` (`data_id`),
  KEY `fk_meta_information_id` (`meta_information_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xai_informationextractor`
--

CREATE TABLE IF NOT EXISTS `xai_informationextractor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_data_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` text,
  `order` int(11) DEFAULT NULL,
  `repetation_handler` varchar(255) DEFAULT NULL,
  `mark_triggering_information` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_meta_data_id` (`meta_data_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xai_meta_data`
--

CREATE TABLE IF NOT EXISTS `xai_meta_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `last_value` text,
  `description` text,
  `action` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

--
-- Dumping data for table `xai_meta_data`
--

INSERT INTO `xai_meta_data` (`id`, `from`, `name`, `last_value`, `description`, `action`) VALUES
(1, 'ALWAYS', 'ALWAYS', 'RUN', NULL, '2'),
(2, 'SERVER', 'HTTP_HOST', 'localhost', NULL, '-1'),
(3, 'SERVER', 'HTTP_USER_AGENT', 'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:32.0) Gecko/20100101 Firefox/32.0', NULL, '-1'),
(4, 'SERVER', 'HTTP_ACCEPT', 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8', NULL, '-1'),
(5, 'SERVER', 'HTTP_ACCEPT_LANGUAGE', 'en-US,en;q=0.5', NULL, '-1'),
(6, 'SERVER', 'HTTP_ACCEPT_ENCODING', 'gzip, deflate', NULL, '-1'),
(7, 'SERVER', 'HTTP_REFERER', 'http://localhost/xavoc_demo/?page=xShop_page_owner_shopsnblogs', NULL, '-1'),
(8, 'SERVER', 'HTTP_CONNECTION', 'keep-alive', NULL, '-1'),
(9, 'SERVER', 'PATH', '/usr/local/bin:/usr/bin:/bin', NULL, '-1'),
(10, 'SERVER', 'SERVER_SIGNATURE', '<address>Apache/2.2.22 (Ubuntu) Server at localhost Port 80</address>\n', NULL, '-1'),
(11, 'SERVER', 'SERVER_SOFTWARE', 'Apache/2.2.22 (Ubuntu)', NULL, '-1'),
(12, 'SERVER', 'SERVER_NAME', 'localhost', NULL, '-1'),
(13, 'SERVER', 'SERVER_ADDR', '127.0.0.1', NULL, '-1'),
(14, 'SERVER', 'SERVER_PORT', '80', NULL, '-1'),
(15, 'SERVER', 'REMOTE_ADDR', '127.0.0.1', NULL, '-1'),
(16, 'SERVER', 'DOCUMENT_ROOT', '/var/www', NULL, '-1'),
(17, 'SERVER', 'SERVER_ADMIN', 'webmaster@localhost', NULL, '-1'),
(18, 'SERVER', 'SCRIPT_FILENAME', '/var/www/xavoc_demo/index.php', NULL, '-1'),
(19, 'SERVER', 'REMOTE_PORT', '47051', NULL, '-1'),
(20, 'SERVER', 'GATEWAY_INTERFACE', 'CGI/1.1', NULL, '-1'),
(21, 'SERVER', 'SERVER_PROTOCOL', 'HTTP/1.1', NULL, '-1'),
(22, 'SERVER', 'REQUEST_METHOD', 'GET', NULL, '-1'),
(23, 'SERVER', 'QUERY_STRING', '', NULL, '-1'),
(24, 'SERVER', 'REQUEST_URI', '/xavoc_demo/', NULL, '-1'),
(25, 'SERVER', 'SCRIPT_NAME', '/xavoc_demo/index.php', NULL, '-1'),
(26, 'SERVER', 'PHP_SELF', '/xavoc_demo/index.php', NULL, '-1'),
(27, 'SERVER', 'REQUEST_TIME', '1425276825', NULL, '-1'),
(28, 'SERVER', 'REQUEST_SCHEME', 'http', NULL, '-1'),
(29, 'SERVER', 'CONTEXT_PREFIX', '', NULL, '-1'),
(30, 'SERVER', 'CONTEXT_DOCUMENT_ROOT', '/var/www/html', NULL, '-1'),
(31, 'SERVER', 'REQUEST_TIME_FLOAT', '1425285720.196', NULL, '-1'),
(32, 'SERVER', 'HTTP_VIA', '1.1 www.deshvikas.com (squid/3.3.8)', NULL, '-1'),
(33, 'SERVER', 'HTTP_X_FORWARDED_FOR', '192.168.1.105', NULL, '-1'),
(34, 'SERVER', 'HTTP_CACHE_CONTROL', 'max-age=259200', NULL, '-1'),
(35, 'SERVER', 'HTTP_COOKIE', 'web=k1noecm9tuo7tuk35sibmv07k1', NULL, '-1'),
(36, 'COOKIE', 'web', 'k1noecm9tuo7tuk35sibmv07k1', NULL, '-1'),
(37, 'COOKIE', '_ga', 'GA1.1.2128742106.1414400345', NULL, '-1'),
(38, 'COOKIE', 'xbank2', '9j9lk9l5l3eiv0j7hjdc9724o2', NULL, '-1'),
(39, 'SERVER', 'HTTP_PRAGMA', 'no-cache', NULL, '-1'),
(40, 'GET', 'department_id', '5', NULL, '-1'),
(41, 'SERVER', 'HTTP_X_REQUESTED_WITH', 'XMLHttpRequest', NULL, '-1'),
(42, 'SERVER', 'HTTP_X_ATK4_TIMEOUT', 'true', NULL, '-1'),
(43, 'GET', 'cut_object', 'web_slideshows_view_tools_awesomeslider', NULL, '-1'),
(44, 'GET', 'html_attributes', '{"id":"6f772cba-9ec2-4d70-f471-529ac2dbf3c1","component_namespace":"slideShows","component_type":"AwesomeSlider","data-responsible-namespace":"slideShows","data-responsible-view":"View_Tools_AwesomeSlider","data-is-serverside-component":"true","class":"epan-component ui-selected","style":"","awesomeslider-theme":"theme-bar"}', NULL, '-1'),
(45, 'GET', 'cut_page', '1', NULL, '-1'),
(46, 'SERVER', 'CONTENT_LENGTH', '79', NULL, '-1'),
(47, 'SERVER', 'HTTP_ORIGIN', 'http://localhost', NULL, '-1'),
(48, 'SERVER', 'CONTENT_TYPE', 'application/x-www-form-urlencoded; charset=UTF-8', NULL, '-1'),
(49, 'GET', 'submit', '358167dc__odule_faf66c24-b2e4-42bb-fa88-866d92d9deb4', NULL, '-1'),
(50, 'POST', 'ajax_submit', 'form_submit', NULL, '-1'),
(51, 'POST', 'a754a682__42bb-fa88-866d92d9deb4_email', 'info@xavoc.com', NULL, '-1'),
(52, 'GET', 'subpage', 'test', NULL, '-1'),
(53, 'GET', 'xsnb_category_id', '3', NULL, '-1'),
(54, 'GET', 'xsnb_item_id', '17', NULL, '-1'),
(55, 'GET', 'order_place', 'true', NULL, '-1'),
(56, 'GET', 'web_xshop_view_tools_xcart_button_2', 'clicked', NULL, '-1'),
(57, 'POST', 'ajaxec_loading', 'true', NULL, '-1'),
(58, 'GET', 'web_xshop_view_tools_xcart_button_3', 'clicked', NULL, '-1'),
(59, 'GET', 'web_xshop_view_tools_xcart_virtualpage', 'true', NULL, '-1'),
(60, 'GET', 'web_xshop_view_tools_xcart_button', 'clicked', NULL, '-1'),
(61, 'POST', 'web_xshop_view_tools_search_form_search', 'profes', NULL, '-1'),
(62, 'GET', 'search', 'profes', NULL, '-1'),
(63, 'POST', 'c0846e44__data_options', '1', NULL, '-1'),
(64, 'POST', 'fe72e045___tools_customeform__first_name', 'vijay', NULL, '-1'),
(65, 'POST', 'fe72e045___tools_customeform__last_name', 'mali', NULL, '-1'),
(66, 'POST', 'fe72e045___tools_customeform__Mobile_No', '9784954128', NULL, '-1'),
(67, 'POST', 'fe72e045___tools_customeform__Email', 'vijay.mali552@gmail.com', NULL, '-1'),
(68, 'POST', 'fe72e045___tools_customeform__Gander', 'Male', NULL, '-1'),
(69, 'GET', 'captcha_view', 'true', NULL, '-1'),
(70, 'GET', 'rand', '2527ec0d6529fd994497e7f28f2db217', NULL, '-1'),
(71, 'POST', 'fe72e045___tools_customeform__captcha', '', NULL, '-1'),
(72, 'COOKIE', 's', 'n86i7rqgfomuscr8e91eq2cag4', NULL, '-1');

-- --------------------------------------------------------

--
-- Table structure for table `xai_meta_information`
--

CREATE TABLE IF NOT EXISTS `xai_meta_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `is_triggering` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xai_sales_executive`
--

CREATE TABLE IF NOT EXISTS `xai_sales_executive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xai_session`
--

CREATE TABLE IF NOT EXISTS `xai_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `is_goal_achieved` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `xai_session`
--

INSERT INTO `xai_session` (`id`, `name`, `type`, `is_goal_achieved`, `created_at`, `updated_at`) VALUES
(1, '', 'website', 0, '2015-03-20 05:00:47', '2015-03-25 12:53:38'),
(2, 'ijqak82rmvjn9mau3co639nsm4', 'website', 0, '2015-03-20 11:26:40', '2015-03-20 11:26:40'),
(3, 'mgql9n3csnsltnn011pik0su77', 'website', 0, '2015-03-20 12:40:08', '2015-03-20 12:40:08'),
(4, 'rojt1ckpsi220jnherj0dt2iq1', 'website', 0, '2015-03-21 04:45:28', '2015-03-21 04:47:48'),
(5, '754q5n9iilskb9u0juh6924f33', 'website', 0, '2015-03-21 09:50:40', '2015-03-21 09:50:40'),
(6, '6t9p5pmrq7tkq86ef4lum8or33', 'website', 0, '2015-03-21 15:08:02', '2015-03-21 15:08:02'),
(7, '53skv8mcftad6cc8445rld47f2', 'website', 0, '2015-03-21 17:45:57', '2015-03-21 17:45:57'),
(8, '7472lmbdchhbflkdphhdqc3dm3', 'website', 0, '2015-03-23 08:44:13', '2015-03-23 08:44:13'),
(9, 's5voqjo2kaeokmjl6p085ct260', 'website', 0, '2015-03-24 05:12:35', '2015-03-24 10:35:39'),
(10, 'vrpl0he0vhfm9vg0uoc530mri0', 'website', 0, '2015-03-24 06:23:54', '2015-03-24 06:25:48'),
(11, '9d9bv9jpk8bvosbektbvhhq8f0', 'website', 0, '2015-03-24 07:42:03', '2015-03-24 07:42:10'),
(12, 'kvbkdri1dsprvg0c7qaam3nhi3', 'website', 0, '2015-03-24 09:39:21', '2015-03-24 10:36:24'),
(13, '1l19d5v3860i00oqko2v5cuig5', 'website', 0, '2015-03-24 11:02:06', '2015-03-24 11:02:06'),
(14, 'dm33uq01kq062cs26aq0nsc0c2', 'website', 0, '2015-03-24 11:03:21', '2015-03-24 11:30:51'),
(15, '6vbnbgpkep1khgmuvcp1c26ek5', 'website', 0, '2015-03-24 11:04:06', '2015-03-24 14:02:12'),
(16, 'h8ufhq3q3oh5evovmrbvgofuv0', 'website', 0, '2015-03-25 06:02:28', '2015-03-25 06:32:38'),
(17, 'r039fvudsikaefhnjcrtqn9446', 'website', 0, '2015-03-25 12:47:59', '2015-03-25 12:47:59'),
(18, '5tdjrnfi3pdfumgsf8bc15ugf4', 'website', 0, '2015-03-25 12:48:21', '2015-03-25 12:48:21'),
(19, 'oum93dqbg6bvd1jf0at1fd7br4', 'website', 0, '2015-03-25 12:51:24', '2015-03-25 12:51:24'),
(20, '6re21bqrvsbvorg9f9bc56i2k5', 'website', 0, '2015-03-25 12:52:36', '2015-03-25 12:52:36'),
(21, 'rogm5qo5deiomthio74l9c1a66', 'website', 0, '2015-03-25 12:53:11', '2015-03-25 12:53:11'),
(22, 'iqc1qh1s931n3pnsp2ook7t991', 'website', 0, '2015-03-25 12:53:39', '2015-03-25 12:53:39'),
(23, 'gj4s6tdo4i3vl76t21a4p0o8q6', 'website', 0, '2015-03-30 05:28:22', '2015-03-30 05:28:41');

-- --------------------------------------------------------

--
-- Table structure for table `xai_visual_analytic`
--

CREATE TABLE IF NOT EXISTS `xai_visual_analytic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `push_to_main_dashboard` tinyint(1) DEFAULT NULL,
  `push_to_analytic_dashboard` tinyint(1) DEFAULT NULL,
  `group_by` varchar(255) DEFAULT NULL,
  `visual_style` varchar(255) DEFAULT NULL,
  `use_gloabl_timespan` tinyint(1) DEFAULT NULL,
  `limit_top` varchar(255) DEFAULT NULL,
  `chart_title` varchar(255) DEFAULT NULL,
  `chart_sub_title` varchar(255) DEFAULT NULL,
  `grid_group_by_meta_information_id` int(11) DEFAULT NULL,
  `grid_value` varchar(255) DEFAULT NULL,
  `main_dashboard_order` int(11) DEFAULT NULL,
  `span_on_main_dashboard` int(11) DEFAULT NULL,
  `analytic_dashboard_order` int(11) DEFAULT NULL,
  `span_on_analytic_dashboard` int(11) DEFAULT NULL,
  `push_to_live_dashboard` tinyint(1) DEFAULT NULL,
  `live_dashboard_order` int(11) DEFAULT NULL,
  `span_on_live_dashboard` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_grid_group_by_meta_information_id` (`grid_group_by_meta_information_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `xai_visual_analytic`
--

INSERT INTO `xai_visual_analytic` (`id`, `name`, `push_to_main_dashboard`, `push_to_analytic_dashboard`, `group_by`, `visual_style`, `use_gloabl_timespan`, `limit_top`, `chart_title`, `chart_sub_title`, `grid_group_by_meta_information_id`, `grid_value`, `main_dashboard_order`, `span_on_main_dashboard`, `analytic_dashboard_order`, `span_on_analytic_dashboard`, `push_to_live_dashboard`, `live_dashboard_order`, `span_on_live_dashboard`) VALUES
(1, 'Total Visitors', 1, 1, 'Date', 'line', 1, '20', 'Total Visitors', '', NULL, '', 1, 6, 1, 6, 0, 0, 0),
(2, 'Top Landing Pages', 1, 1, '', 'grid', 1, '10', 'Landing Pages', '', NULL, 'WEIGHTSUM', 2, 3, 2, 2, 1, 2, 2),
(3, 'Top Browsers', 0, 1, '', 'grid', 1, '10', 'Browsers', '', 3, 'COUNT', 0, 0, 3, 2, 0, 0, 0),
(4, 'Top Exit Page', 1, 1, '', 'grid', 1, '10', 'Exit Pages', '', 6, 'COUNT', 4, 3, 4, 3, 0, 0, 0),
(5, 'Top Referrer Sites', 0, 1, '', 'grid', 1, '10', 'Referres', '', 11, 'WEIGHTSUM', 0, 0, 3, 2, 0, 0, 0),
(6, 'Users Live On Site', 0, 0, '', 'grid', 1, '20', 'Visitors', '', 7, 'COUNT', 0, 0, 0, 0, 1, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `xai_visual_analytic_series`
--

CREATE TABLE IF NOT EXISTS `xai_visual_analytic_series` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_information_id` int(11) DEFAULT NULL,
  `visual_analytic_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_meta_information_id` (`meta_information_id`),
  KEY `fk_visual_analytic_id` (`visual_analytic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xai_visual_analytic_series`
--

INSERT INTO `xai_visual_analytic_series` (`id`, `meta_information_id`, `visual_analytic_id`, `name`) VALUES
(1, 7, 1, 'SUM');

-- --------------------------------------------------------

--
-- Table structure for table `xcrm_document_activities`
--

CREATE TABLE IF NOT EXISTS `xcrm_document_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `from_id` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `to_id` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `action` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=32 ;

--
-- Dumping data for table `xcrm_document_activities`
--

INSERT INTO `xcrm_document_activities` (`id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`, `created_by_id`, `from`, `from_id`, `to`, `to_id`, `subject`, `message`, `action`) VALUES
(1, '1', 'xShop\\Order', 'xShop\\Order_Draft', '2015-03-23 06:11:29', '2015-03-23 06:11:29', 2, 'Employee', '2', NULL, NULL, 'Submitted', 'Document Status Changed', 'submitted'),
(2, '1', 'xShop\\Order', 'xShop\\Order_Submitted', '2015-03-23 06:15:07', '2015-03-23 06:15:07', 2, 'Employee', '2', NULL, NULL, 'Approved', 'Good work Rakesh', 'approved'),
(3, '1', 'xProduction\\JobCard', 'xProduction\\Jobcard_Approved', '2015-03-23 06:22:42', '2015-03-23 06:22:42', 2, 'Employee', '2', NULL, NULL, 'Received', 'Document Status Changed', 'received'),
(4, '1', 'xProduction\\JobCard', 'xProduction\\Jobcard_Received', '2015-03-23 06:25:58', '2015-03-23 06:25:58', 2, 'Employee', '2', NULL, NULL, 'Processing', 'Document Status Changed', 'processing'),
(5, '1', 'xProduction\\JobCard', 'xProduction\\Jobcard_Processing', '2015-03-23 06:27:36', '2015-03-23 06:27:36', 2, 'Employee', '2', NULL, NULL, 'Processed', 'Document Status Changed', 'processed'),
(6, '1', 'xStore\\StockMovement', 'xStore\\StockMovement_Draft', '2015-03-23 06:27:36', '2015-03-23 06:27:36', 2, 'Employee', '2', NULL, NULL, 'Accepted', 'Document Status Changed', 'accepted'),
(7, '1', 'xProduction\\JobCard', 'xProduction\\Jobcard_Processed', '2015-03-23 06:28:18', '2015-03-23 06:28:18', 2, 'Employee', '2', NULL, NULL, 'Forwarded', 'Document Status Changed', 'forwarded'),
(8, '1', 'xProduction\\JobCard', 'xProduction\\JobCard', '2015-03-23 06:29:36', '2015-03-23 06:29:36', 2, 'Employee', '2', NULL, NULL, 'Completed', 'Document Status Changed', 'completed'),
(9, '1', 'xShop\\Order', 'xShop\\Order', '2015-03-23 06:29:36', '2015-03-23 06:29:36', 2, 'Employee', '2', NULL, NULL, 'Processed', 'Document Status Changed', 'processed'),
(10, '2', 'xProduction\\JobCard', 'xProduction\\Jobcard_Approved', '2015-03-23 06:29:36', '2015-03-23 06:29:37', 2, 'Employee', '2', NULL, NULL, 'Received', 'Document Status Changed', 'received'),
(11, '2', 'xProduction\\JobCard', 'xProduction\\Jobcard_Received', '2015-03-23 06:32:44', '2015-03-23 06:32:44', 2, 'Employee', '2', NULL, NULL, 'Processed', 'Document Status Changed', 'processed'),
(12, '2', 'xStore\\StockMovement', 'xStore\\StockMovement_Draft', '2015-03-23 06:32:44', '2015-03-23 06:32:44', 2, 'Employee', '2', NULL, NULL, 'Accepted', 'Document Status Changed', 'accepted'),
(13, '2', 'xProduction\\JobCard', 'xProduction\\Jobcard_Processed', '2015-03-23 06:34:14', '2015-03-23 06:34:14', 2, 'Employee', '2', NULL, NULL, 'Forwarded', 'Document Status Changed', 'forwarded'),
(14, '2', 'xProduction\\JobCard', 'xProduction\\JobCard', '2015-03-23 06:35:30', '2015-03-23 06:35:30', 2, 'Employee', '2', NULL, NULL, 'Completed', 'Document Status Changed', 'completed'),
(15, '1', 'xShop\\Order', 'xShop\\Order', '2015-03-23 06:35:30', '2015-03-23 06:35:30', 2, 'Employee', '2', NULL, NULL, 'Processed', 'Document Status Changed', 'processed'),
(16, '3', 'xProduction\\JobCard', 'xProduction\\Jobcard_Approved', '2015-03-23 06:35:30', '2015-03-23 06:35:30', 2, 'Employee', '2', NULL, NULL, 'Received', 'Document Status Changed', 'received'),
(17, '3', 'xProduction\\JobCard', 'xProduction\\Jobcard_Received', '2015-03-23 06:36:01', '2015-03-23 06:36:01', 2, 'Employee', '2', NULL, NULL, 'Processed', 'Document Status Changed', 'processed'),
(18, '3', 'xStore\\StockMovement', 'xStore\\StockMovement_Draft', '2015-03-23 06:36:01', '2015-03-23 06:36:02', 2, 'Employee', '2', NULL, NULL, 'Accepted', 'Document Status Changed', 'accepted'),
(19, '1', 'xShop\\Quotation', 'xShop\\Quotation_Draft', '2015-03-23 06:54:34', '2015-03-23 06:54:34', 2, 'Employee', '2', NULL, NULL, 'Submitted', 'Document Status Changed', 'submitted'),
(20, '1', 'xMarketingCampaign\\Lead', NULL, '2015-03-23 10:21:40', '2015-03-23 10:21:40', 3, 'Employee', '3', NULL, NULL, 'school bug ', 'bvmlcvknlvbkmlmrtyh,rylt,r;,;fgn,gfhhrytyrty', 'comment'),
(21, '3', 'xProduction\\JobCard', 'xProduction\\Jobcard_Processed', '2015-03-23 10:37:51', '2015-03-23 10:37:51', 2, 'Employee', '2', NULL, NULL, 'Completed', 'Document Status Changed', 'completed'),
(22, '2', 'xShop\\Order', 'xShop\\Order_Draft', '2015-03-23 12:37:17', '2015-03-23 12:37:17', 3, 'Employee', '3', NULL, NULL, 'Submitted', 'Document Status Changed', 'submitted'),
(23, '2', 'xShop\\Order', 'xShop\\Order_Submitted', '2015-03-23 12:38:01', '2015-03-23 12:38:01', 3, 'Employee', '3', NULL, NULL, 'Approved', 'Document Status Changed', 'approved'),
(24, '2', 'xShop\\Order', 'xShop\\Order_Approved', '2015-03-23 12:53:21', '2015-03-23 12:53:21', 3, 'Employee', '3', NULL, NULL, 'Redesign', 'Document Status Changed', 'redesign'),
(25, '2', 'xShop\\Order', 'xShop\\Order_Redesign', '2015-03-23 12:58:29', '2015-03-23 12:58:29', 3, 'Employee', '3', NULL, NULL, 'Submitted', 'Document Status Changed', 'submitted'),
(26, '2', 'xShop\\Order', 'xShop\\Order_Submitted', '2015-03-23 12:58:47', '2015-03-23 12:58:47', 3, 'Employee', '3', NULL, NULL, 'Approved', 'Document Status Changed', 'approved'),
(27, '35', 'xStore\\MaterialRequestReceived', 'xStore\\MaterialRequestReceived_Approved', '2015-03-23 13:01:49', '2015-03-23 13:01:49', 3, 'Employee', '3', NULL, NULL, 'Received', 'Document Status Changed', 'received'),
(28, '35', 'xStore\\MaterialRequestReceived', 'xStore\\MaterialRequestReceived_Received', '2015-03-23 13:02:55', '2015-03-23 13:02:55', 3, 'Employee', '3', NULL, NULL, 'Processing', 'Document Status Changed', 'processing'),
(29, '35', 'xStore\\MaterialRequestReceived', 'xStore\\MaterialRequestReceived_Processing', '2015-03-23 13:03:25', '2015-03-23 13:03:25', 3, 'Employee', '3', NULL, NULL, 'Processed', 'Document Status Changed', 'processed'),
(30, '4', 'xStore\\StockMovement', 'xStore\\StockMovement', '2015-03-23 13:08:14', '2015-03-23 13:08:14', 3, 'Employee', '3', NULL, NULL, 'Accepted', 'Document Status Changed', 'accepted'),
(31, '35', 'xStore\\MaterialRequestSent', 'xStore\\MaterialRequestSent_Processed', '2015-03-23 13:08:14', '2015-03-23 13:08:14', 3, 'Employee', '3', NULL, NULL, 'Completed', 'Document Status Changed', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `xdispatch_delivery_note`
--

CREATE TABLE IF NOT EXISTS `xdispatch_delivery_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `orderitem_id` int(11) DEFAULT NULL,
  `to_department_id` int(11) DEFAULT NULL,
  `from_department_id` int(11) DEFAULT NULL,
  `dispatch_to_warehouse_id` int(11) DEFAULT NULL,
  `orderitem_departmental_status_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `to_memberdetails_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `shipping_address` text,
  `billing_address` text,
  `shipping_through` text,
  `narration` text,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_orderitem_id` (`orderitem_id`) USING BTREE,
  KEY `fk_to_department_id` (`to_department_id`) USING BTREE,
  KEY `fk_from_department_id` (`from_department_id`) USING BTREE,
  KEY `fk_dispatch_to_warehouse_id` (`dispatch_to_warehouse_id`) USING BTREE,
  KEY `fk_orderitem_departmental_status_id` (`orderitem_departmental_status_id`) USING BTREE,
  KEY `fk_order_id` (`order_id`) USING BTREE,
  KEY `fk_to_memberdetails_id` (`to_memberdetails_id`) USING BTREE,
  KEY `fk_warehouse_id` (`warehouse_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xdispatch_dispatch_request`
--

CREATE TABLE IF NOT EXISTS `xdispatch_dispatch_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `orderitem_id` int(11) DEFAULT NULL,
  `to_department_id` int(11) DEFAULT NULL,
  `from_department_id` int(11) DEFAULT NULL,
  `dispatch_to_warehouse_id` int(11) DEFAULT NULL,
  `orderitem_departmental_status_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_orderitem_id` (`orderitem_id`) USING BTREE,
  KEY `fk_to_department_id` (`to_department_id`) USING BTREE,
  KEY `fk_from_department_id` (`from_department_id`) USING BTREE,
  KEY `fk_dispatch_to_warehouse_id` (`dispatch_to_warehouse_id`) USING BTREE,
  KEY `fk_orderitem_departmental_status_id` (`orderitem_departmental_status_id`) USING BTREE,
  KEY `fk_order_id` (`order_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xdispatch_dispatch_request`
--

INSERT INTO `xdispatch_dispatch_request` (`id`, `status`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_by_id`, `orderitem_id`, `to_department_id`, `from_department_id`, `dispatch_to_warehouse_id`, `orderitem_departmental_status_id`, `type`, `name`, `order_id`, `created_at`, `updated_at`) VALUES
(1, 'approved', '1', 'xShop\\Order', 'xShop\\Order', 2, 1, 12, 18, 10, 4, 'DispatchRequest', 'xStore\\DispatchRequest 00001', 1, '2015-03-23 10:15:10', '2015-03-23 10:15:10');

-- --------------------------------------------------------

--
-- Table structure for table `xdispatch_dispatch_request_items`
--

CREATE TABLE IF NOT EXISTS `xdispatch_dispatch_request_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `dispatch_request_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_dispatch_request_id` (`dispatch_request_id`) USING BTREE,
  KEY `fk_item_id` (`item_id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xdispatch_dispatch_request_items`
--

INSERT INTO `xdispatch_dispatch_request_items` (`id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_by_id`, `dispatch_request_id`, `item_id`, `qty`, `unit`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, 2, 1, 10, '100.00', 'Nos', '2015-03-23 10:37:11', '2015-03-23 10:37:11');

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_Config`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_Config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `show_all_newsletters` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xEnquiryNSubscription_Config`
--

INSERT INTO `xEnquiryNSubscription_Config` (`id`, `epan_id`, `show_all_newsletters`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_custome_customFields`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_custome_customFields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forms_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `set_value` varchar(255) DEFAULT NULL,
  `mandatory` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_forms_id` (`forms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `xEnquiryNSubscription_custome_customFields`
--

INSERT INTO `xEnquiryNSubscription_custome_customFields` (`id`, `forms_id`, `name`, `type`, `set_value`, `mandatory`) VALUES
(1, 1, 'first name', 'line', '', 1),
(2, 1, 'last name', 'line', '', 1),
(3, 1, 'Mobile No: ', 'Number', '', 1),
(4, 1, 'Email ', 'email', '', 1),
(5, 1, 'Gander', 'radio', 'Male,Female', 1),
(6, 1, 'captcha', 'captcha', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_customformentry`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_customformentry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `forms_id` int(11) DEFAULT NULL,
  `create_at` date DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `message` text,
  `is_read` tinyint(1) DEFAULT NULL,
  `watch` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_forms_id` (`forms_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `xEnquiryNSubscription_customformentry`
--

INSERT INTO `xEnquiryNSubscription_customformentry` (`id`, `epan_id`, `forms_id`, `create_at`, `ip`, `message`, `is_read`, `watch`) VALUES
(1, 1, 1, '2015-03-24', '127.0.0.1', '<b>first name</b> : vijay<br/><b>last name</b> : mali<br/><b>Mobile No: </b> : 9784954128<br/><b>Email </b> : vijay.mali552@gmail.com<br/><b>Gander</b> : Male<br/>', 0, 0),
(2, 1, 1, '2015-03-24', '127.0.0.1', '<b>first name</b> : Gowrav<br/><b>last name</b> : vishwarkarma<br/><b>Mobile No: </b> : 75675675<br/><b>Email </b> : info@xavoc.com<br/><b>Gander</b> : Male<br/>', 0, 0),
(3, 1, 1, '2015-03-25', '127.0.0.1', '<b>first name</b> : vijay<br/><b>last name</b> : mali<br/><b>Mobile No: </b> : 7665036690<br/><b>Email </b> : vijay.mali552@gmail.com<br/><b>Gander</b> : Male<br/>', 0, 0),
(4, 1, 1, '2015-03-25', '127.0.0.1', '<b>first name</b> : rakesh<br/><b>last name</b> : sinha<br/><b>Mobile No: </b> : 874984654654<br/><b>Email </b> : rksinha.btech@gmail.com<br/><b>Gander</b> : Male<br/>', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_customForm_forms`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_customForm_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `receipent_email_id` varchar(255) DEFAULT NULL,
  `receive_mail` tinyint(1) DEFAULT NULL,
  `button_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xEnquiryNSubscription_customForm_forms`
--

INSERT INTO `xEnquiryNSubscription_customForm_forms` (`id`, `epan_id`, `name`, `receipent_email_id`, `receive_mail`, `button_name`) VALUES
(1, 1, 'demo', 'vijay.mali552@gmail.com', 0, 'Submit');

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_EmailJobs`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_EmailJobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsletter_id` int(11) DEFAULT NULL,
  `job_posted_at` datetime DEFAULT NULL,
  `processed_on` datetime DEFAULT NULL,
  `process_via` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_newsletter_id` (`newsletter_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xEnquiryNSubscription_EmailJobs`
--

INSERT INTO `xEnquiryNSubscription_EmailJobs` (`id`, `newsletter_id`, `job_posted_at`, `processed_on`, `process_via`) VALUES
(1, 1, '2015-03-23 09:57:21', NULL, 'xMarketingCampaign');

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_EmailQueue`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_EmailQueue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emailjobs_id` int(11) DEFAULT NULL,
  `subscriber_id` int(11) DEFAULT NULL,
  `is_sent` tinyint(1) DEFAULT NULL,
  `is_received` tinyint(1) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `is_clicked` tinyint(1) DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_emailjobs_id` (`emailjobs_id`),
  KEY `fk_subscriber_id` (`subscriber_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xEnquiryNSubscription_EmailQueue`
--

INSERT INTO `xEnquiryNSubscription_EmailQueue` (`id`, `emailjobs_id`, `subscriber_id`, `is_sent`, `is_received`, `is_read`, `is_clicked`, `sent_at`, `email`) VALUES
(1, 1, NULL, 0, 0, 0, 0, '2015-03-23 09:57:21', 'vijay.mali552@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_hosts_touched`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_hosts_touched` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_massemailconfiguration`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_massemailconfiguration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `use_mandril` tinyint(1) DEFAULT NULL,
  `mandril_api_key` varchar(255) DEFAULT NULL,
  `send_via_bcc` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_NewsLetter`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_NewsLetter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `matter` text,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xEnquiryNSubscription_NewsLetter`
--

INSERT INTO `xEnquiryNSubscription_NewsLetter` (`id`, `epan_id`, `name`, `email_subject`, `matter`, `created_at`, `created_by`, `category_id`, `is_active`, `updated_at`) VALUES
(1, 1, 'School Managment', 'Easily manage your  School Managment', '<p style="text-align: center;">&nbsp;</p>\r\n<table style="height: 56px;" width="862">\r\n<tbody>\r\n<tr>\r\n<td><img src="epans/web/sale_small.png" alt="" width="92" height="92" /></td>\r\n<td>\r\n<h2>&nbsp; Easily manage your&nbsp; School Managment</h2>\r\n</td>\r\n<td><img src="epans/web/Xavoc%20Technocrats%20Logo%20Small.png" alt="" width="171" height="99" /></td>\r\n</tr>\r\n<tr>\r\n<td colspan="3">\r\n<h3>&nbsp;&nbsp;&nbsp; Worlds'' true Drag And Drop,</h3>\r\n<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Extensible &amp; Open Source cms with its own market place</h3>\r\n<p>&nbsp;</p>\r\n<p>When I first hit by word "Inbound Marketing", I was exited. And as once you hit any thing that makes you exited, soon you will be seeing it everywhere around you (you have also felt it sometime). So as a sudden, "Inbound Marketing" was a new Buzz word. I started studying it. It was exiting but soon my Logical Mind made a ring. Since I am working on Artificial Intelligence I see everywhere logic. I search Why, What, Where etc. And during my study I have found that "Big Problems have simple solutions and simple solutions are complex in explanation.". So I study Inbound Marketing my way and found some interesting facts.</p>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n<td>&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>', '2015-03-23 09:52:52', 'xMarketingCampaign', 1, 1, '2015-03-23 09:56:50');

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_NewsLetterCategory`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_NewsLetterCategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xEnquiryNSubscription_NewsLetterCategory`
--

INSERT INTO `xEnquiryNSubscription_NewsLetterCategory` (`id`, `epan_id`, `name`) VALUES
(1, 1, 'school software');

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_SubsCatAss`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_SubsCatAss` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscriber_id` int(11) DEFAULT NULL,
  `subscribed_on` datetime DEFAULT NULL,
  `last_updated_on` datetime DEFAULT NULL,
  `send_news_letters` tinyint(1) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `unsubscribed_on` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_subscriber_id` (`subscriber_id`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xEnquiryNSubscription_SubsCatAss`
--

INSERT INTO `xEnquiryNSubscription_SubsCatAss` (`id`, `subscriber_id`, `subscribed_on`, `last_updated_on`, `send_news_letters`, `category_id`, `unsubscribed_on`) VALUES
(1, 1, '2015-03-24 05:56:38', '2015-03-24 05:56:38', 1, 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_Subscription`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_Subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `from_app` varchar(255) DEFAULT NULL,
  `from_id` int(11) DEFAULT NULL,
  `is_ok` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`) USING BTREE,
  KEY `from_id` (`from_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=6 ;

--
-- Dumping data for table `xEnquiryNSubscription_Subscription`
--

INSERT INTO `xEnquiryNSubscription_Subscription` (`id`, `epan_id`, `email`, `ip`, `created_at`, `from_app`, `from_id`, `is_ok`) VALUES
(1, 1, 'info@xavoc.com', '127.0.0.1', '2015-03-24 05:56:38', 'Website', NULL, 1),
(2, 1, 'vijay.mali552@gmail.com', '127.0.0.1', '2015-03-24 09:40:52', 'xEnquiryNSubscription/CustomForm', 1, 1),
(3, 1, 'info@xavoc.com', '127.0.0.1', '2015-03-24 09:52:59', 'xEnquiryNSubscription/CustomForm', 1, 1),
(4, 1, 'vijay.mali552@gmail.com', '127.0.0.1', '2015-03-25 06:03:42', 'xEnquiryNSubscription/CustomForm', 1, 1),
(5, 1, 'rksinha.btech@gmail.com', '127.0.0.1', '2015-03-25 06:11:49', 'xEnquiryNSubscription/CustomForm', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_Subscription_Categories`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_Subscription_Categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xEnquiryNSubscription_Subscription_Categories`
--

INSERT INTO `xEnquiryNSubscription_Subscription_Categories` (`id`, `epan_id`, `name`, `is_active`) VALUES
(1, 1, 'xavoc Subscriber', 1),
(2, 1, 'enquiry subscription', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xEnquiryNSubscription_Subscription_Config`
--

CREATE TABLE IF NOT EXISTS `xEnquiryNSubscription_Subscription_Config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `email_caption` varchar(255) DEFAULT NULL,
  `subscribe_caption` varchar(255) DEFAULT NULL,
  `placeholder_text` varchar(255) DEFAULT NULL,
  `thank_you_msg` varchar(255) DEFAULT NULL,
  `flip_the_html` text,
  `allow_non_email_entries` tinyint(1) DEFAULT NULL,
  `allow_re_subscribe` tinyint(1) DEFAULT NULL,
  `send_response_email` tinyint(1) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_body` text,
  PRIMARY KEY (`id`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xEnquiryNSubscription_Subscription_Config`
--

INSERT INTO `xEnquiryNSubscription_Subscription_Config` (`id`, `category_id`, `email_caption`, `subscribe_caption`, `placeholder_text`, `thank_you_msg`, `flip_the_html`, `allow_non_email_entries`, `allow_re_subscribe`, `send_response_email`, `email_subject`, `email_body`) VALUES
(1, 1, 'Email ID', 'Subscribe', 'Enter your Email Id', 'Thank You for Subscription', '<h2 class="alert alert-info"> Thank You :) <script>alert("Thank You");</script></h2>', 0, 1, 0, NULL, NULL),
(2, 2, 'Email ID', 'Subscribe', 'Enter your Email Id', 'Thank You for Subscription', '<h2 class="alert alert-info"> Thank You :) <script>alert("Thank You");</script></h2>', 0, 1, 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `xhr_departments`
--

CREATE TABLE IF NOT EXISTS `xhr_departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `proceed_after_previous_department` tinyint(1) DEFAULT NULL,
  `internal_approved` tinyint(1) DEFAULT NULL,
  `acl_approved` tinyint(1) DEFAULT NULL,
  `jobcard_assign_required` tinyint(1) DEFAULT NULL,
  `is_production_department` tinyint(1) DEFAULT NULL,
  `related_application_namespace` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `is_outsourced` tinyint(1) DEFAULT NULL,
  `is_system` tinyint(1) DEFAULT NULL,
  `jobcard_document` varchar(255) DEFAULT NULL,
  `production_level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `xhr_departments`
--

INSERT INTO `xhr_departments` (`id`, `branch_id`, `name`, `proceed_after_previous_department`, `internal_approved`, `acl_approved`, `jobcard_assign_required`, `is_production_department`, `related_application_namespace`, `is_active`, `is_outsourced`, `is_system`, `jobcard_document`, `production_level`) VALUES
(1, NULL, 'Company', NULL, NULL, NULL, NULL, 0, '', 1, NULL, 1, 'JobCard', NULL),
(2, NULL, 'HR', NULL, NULL, NULL, NULL, 0, 'xHR', 1, NULL, 1, 'JobCard', NULL),
(3, NULL, 'Marketing', NULL, NULL, NULL, NULL, 0, 'xMarketingCampaign', 1, NULL, 1, 'JobCard', NULL),
(4, NULL, 'Sales', NULL, NULL, NULL, NULL, 0, 'xShop', 1, NULL, 1, 'JobCard', NULL),
(5, NULL, 'Purchase', NULL, NULL, NULL, NULL, 1, 'xStore', 1, NULL, 1, 'MaterialRequest', -2),
(7, NULL, 'Accounts', NULL, NULL, NULL, NULL, 0, 'xAccount', 1, NULL, 1, 'JobCard', NULL),
(8, NULL, 'CRM', NULL, NULL, NULL, NULL, 0, 'xCRM', 1, NULL, 1, 'JobCard', NULL),
(9, NULL, 'Store', NULL, NULL, NULL, NULL, 1, 'xStore', 1, NULL, 1, 'MaterialRequest', -1),
(12, NULL, 'Dispatch And Delivery', NULL, NULL, NULL, NULL, 1, 'xDispatch', 1, NULL, 1, 'DispatchRequest', 100000),
(13, NULL, 'Designing', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 1),
(14, NULL, 'Digital Printing/Press', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 2),
(15, NULL, 'OffSet printing', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 2),
(16, NULL, 'Cotaing', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 3),
(17, NULL, 'UV', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 5),
(18, NULL, 'Lamination', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 4),
(19, NULL, 'Hot Foil', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 6),
(20, NULL, 'Screen printing', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 2),
(21, NULL, 'Large Formate Printing', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 2),
(22, NULL, 'Cutting', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 3),
(23, NULL, 'Varnish', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 3),
(24, NULL, 'Die Cut', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 7),
(25, NULL, 'Binding', NULL, NULL, NULL, NULL, 1, 'xProduction', 1, 0, 0, 'JobCard', 8);

-- --------------------------------------------------------

--
-- Table structure for table `xhr_departments_acl`
--

CREATE TABLE IF NOT EXISTS `xhr_departments_acl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `can_view` varchar(255) DEFAULT NULL,
  `can_submit` varchar(255) DEFAULT NULL,
  `can_approve` varchar(255) DEFAULT NULL,
  `allow_add` tinyint(1) DEFAULT NULL,
  `allow_edit` varchar(255) DEFAULT NULL,
  `allow_del` varchar(255) DEFAULT NULL,
  `can_reject` varchar(255) DEFAULT NULL,
  `can_forward` varchar(255) DEFAULT NULL,
  `can_receive` tinyint(1) DEFAULT NULL,
  `can_send_via_email` varchar(255) DEFAULT NULL,
  `can_assign` varchar(255) DEFAULT NULL,
  `can_select_outsource` varchar(255) DEFAULT NULL,
  `can_manage_tasks` varchar(255) DEFAULT NULL,
  `task_types` varchar(255) DEFAULT NULL,
  `can_assign_to` varchar(255) DEFAULT NULL,
  `can_start_processing` varchar(255) DEFAULT NULL,
  `can_mark_processed` varchar(255) DEFAULT NULL,
  `can_accept` varchar(255) DEFAULT NULL,
  `can_cancel` varchar(255) DEFAULT NULL,
  `can_redesign` varchar(255) DEFAULT NULL,
  `can_manage_attachments` varchar(255) DEFAULT NULL,
  `can_see_activities` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_document_id` (`document_id`),
  KEY `fk_post_id` (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=484 ;

--
-- Dumping data for table `xhr_departments_acl`
--

INSERT INTO `xhr_departments_acl` (`id`, `document_id`, `post_id`, `can_view`, `can_submit`, `can_approve`, `allow_add`, `allow_edit`, `allow_del`, `can_reject`, `can_forward`, `can_receive`, `can_send_via_email`, `can_assign`, `can_select_outsource`, `can_manage_tasks`, `task_types`, `can_assign_to`, `can_start_processing`, `can_mark_processed`, `can_accept`, `can_cancel`, `can_redesign`, `can_manage_attachments`, `can_see_activities`) VALUES
(1, 1, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(2, 2, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(3, 3, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(4, 4, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(5, 5, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(6, 6, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(7, 7, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(8, 8, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(9, 8, 30, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(10, 9, 30, 'Self Only', 'No', 'No', 1, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(11, 10, 30, 'All', 'Self Only', 'No', 1, 'Self Only', 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(12, 11, 30, 'All', 'No', 'All', 0, 'Self Only', 'No', 'All', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(13, 12, 30, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(14, 13, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(15, 14, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'No'),
(16, 15, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(17, 16, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(18, 17, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(19, 18, 30, 'All', 'No', 'No', 1, 'Self Only', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(20, 10, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(21, 11, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(22, 12, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(23, 13, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(24, 14, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(25, 15, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(26, 16, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(27, 17, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(28, 8, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(29, 9, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(30, 10, 36, 'Self Only', 'Self Only', 'No', 1, 'Self Only', 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(31, 11, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(32, 12, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(33, 13, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(34, 14, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(35, 15, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(36, 16, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(37, 17, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(38, 18, 36, 'Self Only', 'No', 'No', 1, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(39, 19, 36, 'All', 'No', 'No', 1, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(40, 20, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(41, 19, 30, 'All', 'No', 'No', 1, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(42, 20, 30, 'All', 'No', 'No', 1, 'All', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(43, 9, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(44, 21, 36, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(45, 21, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(46, 22, 36, 'Self Only', 'No', 'No', 1, 'Self Only', 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(47, 22, 30, 'All', 'No', 'No', 1, 'Self Only', 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(48, 23, 30, 'Self Only', 'All', 'No', 1, 'Self Only', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(49, 24, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(50, 25, 30, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(51, 26, 30, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'All', 'All', 'No', 'All', 'No', 'No', 'Deep'),
(52, 27, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(53, 28, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'All', 'No', 'No', 'No', 'No', 'No'),
(54, 29, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'All', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(55, 30, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(56, 31, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(57, 32, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(58, 33, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(59, 34, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(60, 35, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(61, 36, 30, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(62, 37, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(63, 38, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(64, 39, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(65, 40, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(66, 41, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(67, 42, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(68, 33, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(69, 34, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(70, 35, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(71, 36, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(72, 37, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(73, 38, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(74, 39, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(75, 40, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(76, 41, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(77, 42, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(78, 43, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(79, 44, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(80, 45, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(81, 46, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(82, 47, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(83, 48, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(84, 49, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(85, 43, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(86, 50, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(87, 44, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(88, 45, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(89, 46, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(90, 47, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(91, 48, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(92, 49, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(93, 50, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(94, 51, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(95, 51, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(96, 21, NULL, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(97, 52, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(98, 53, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(99, 54, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(100, 55, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(101, 56, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(102, 57, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(103, 58, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(104, 59, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(105, 60, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(106, 61, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(107, 62, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(108, 63, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(109, 64, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(110, 65, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(111, 66, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(112, 67, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(113, 68, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(114, 69, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(115, 70, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(116, 71, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(117, 72, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(118, 73, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(119, 74, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(120, 75, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(121, 76, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(122, 77, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(123, 78, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(124, 79, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(125, 80, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(126, 81, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(127, 82, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(128, 83, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(129, 84, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(130, 85, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(131, 86, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(132, 87, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(133, 88, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(134, 89, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(135, 90, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(136, 52, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(137, 53, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(138, 54, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(139, 55, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(140, 56, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(141, 57, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(142, 58, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(143, 59, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(144, 60, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(145, 61, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(146, 23, 3, 'All', 'All', 'No', 1, 'All', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(147, 24, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(148, 25, 3, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(149, 26, 3, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(150, 27, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(151, 28, 3, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'All', 'No', 'No', 'No', 'All', 'All'),
(152, 29, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(153, 30, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(154, 31, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(155, 32, 3, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(156, 10, 3, 'All', 'All', 'No', 1, 'All', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(157, 11, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(158, 12, 3, 'All', 'No', 'No', 0, 'Self Only', 'No', 'All', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(159, 13, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(160, 14, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(161, 15, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(162, 16, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(163, 17, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(164, 21, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(165, 91, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(166, 92, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(167, 93, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(168, 94, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(169, 95, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(170, 96, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(171, 97, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(172, 98, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(173, 99, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(174, 100, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(175, 101, 30, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(176, 19, 3, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(177, 102, 11, 'All', 'All', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(178, 103, 11, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(179, 104, 11, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(180, 105, 11, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'All', 'All', 'No', 'No', 'No', 'No', 'No'),
(181, 106, 11, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(182, 107, 11, 'All', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'All', 'No', 'No', 'No', 'No', 'No'),
(183, 108, 11, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(184, 109, 11, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(185, 110, 11, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(186, 111, 11, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(187, 29, 11, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(188, 28, 11, 'Self Only', 'No', 'No', 0, 'Self Only', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(189, 1, 30, 'Self Only', 'No', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(190, 2, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(191, 3, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(192, 4, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(193, 5, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(194, 6, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(195, 7, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(196, 112, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(197, 113, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(198, 114, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(199, 115, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(200, 116, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(201, 117, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(202, 118, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(203, 119, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(204, 120, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(205, 121, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(206, 122, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(207, 123, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(208, 124, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(209, 125, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(210, 126, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(211, 127, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(212, 128, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(213, 129, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(214, 130, 30, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(215, 131, 30, 'Self Only', 'Self Only', 'No', 1, 'No', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(216, 132, 30, 'Self Only', 'No', 'All', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(217, 133, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(218, 134, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(219, 135, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(220, 136, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(221, 137, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(222, 138, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(223, 139, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(224, 140, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(225, 141, 30, 'All', 'All', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(226, 142, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(227, 143, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(228, 144, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(229, 145, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(230, 146, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(231, 147, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(232, 148, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(233, 102, 30, 'All', 'All', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(234, 103, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(235, 104, 30, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(236, 105, 30, 'All', 'No', 'No', 0, 'All', 'No', 'No', 'No', 0, 'No', 'All', 'No', 'No', NULL, 'Dept. Teams', 'All', 'All', 'No', 'No', 'No', 'No', 'All'),
(237, 106, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(238, 107, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(239, 108, 30, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'All', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(240, 109, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(241, 110, 30, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(242, 111, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(243, 149, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(244, 150, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(245, 151, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(246, 152, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(247, 153, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(248, 154, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(249, 155, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(250, 156, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(251, 157, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(252, 158, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(253, 159, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(254, 160, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(255, 161, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(256, 162, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(257, 163, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(258, 164, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(259, 165, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(260, 166, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(261, 167, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(262, 168, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(263, 169, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(264, 170, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(265, 171, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(266, 172, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(267, 173, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(268, 174, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(269, 175, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(270, 176, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(271, 177, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(272, 178, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(273, 81, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(274, 82, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(275, 83, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(276, 84, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'All', 'No', 'No', 'No', 'No', 'No'),
(277, 85, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(278, 86, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(279, 87, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'All', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(280, 88, 30, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(281, 89, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(282, 90, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(283, 179, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(284, 180, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(285, 181, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(286, 182, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(287, 183, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(288, 184, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(289, 185, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(290, 186, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(291, 187, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(292, 188, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(293, 189, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(294, 190, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(295, 191, 30, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(296, 192, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(297, 193, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(298, 194, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(299, 195, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(300, 196, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(301, 197, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(302, 198, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(303, 199, 30, 'All', 'All', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(304, 200, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(305, 201, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(306, 202, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(307, 203, 30, 'Self Only', 'No', 'All', 1, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(308, 204, 30, 'All', 'No', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(309, 62, 3, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(310, 63, 3, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(311, 64, 3, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(312, 65, 3, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(313, 66, 3, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(314, 67, 3, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(315, 68, 3, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(316, 69, 3, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(317, 70, 3, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(318, 101, 3, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(319, 205, 30, 'All', 'No', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(320, 206, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(321, 207, 30, 'All', 'No', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(322, 208, 30, 'All', 'No', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(323, 209, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(324, 210, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(325, 211, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(326, 212, 30, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(327, 141, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(328, 112, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(329, 113, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(330, 114, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No');
INSERT INTO `xhr_departments_acl` (`id`, `document_id`, `post_id`, `can_view`, `can_submit`, `can_approve`, `allow_add`, `allow_edit`, `allow_del`, `can_reject`, `can_forward`, `can_receive`, `can_send_via_email`, `can_assign`, `can_select_outsource`, `can_manage_tasks`, `task_types`, `can_assign_to`, `can_start_processing`, `can_mark_processed`, `can_accept`, `can_cancel`, `can_redesign`, `can_manage_attachments`, `can_see_activities`) VALUES
(331, 115, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(332, 116, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(333, 117, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(334, 118, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(335, 119, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(336, 120, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(337, 121, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(338, 23, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(339, 24, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(340, 25, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(341, 26, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(342, 27, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(343, 28, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(344, 29, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(345, 30, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(346, 31, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(347, 32, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(348, 102, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(349, 103, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(350, 104, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(351, 105, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(352, 106, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(353, 107, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(354, 108, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(355, 109, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(356, 110, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(357, 111, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(358, 213, 30, 'All', 'No', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(359, 207, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(360, 207, 11, 'All', 'No', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(361, 214, 11, 'All', 'No', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(362, 215, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(363, 216, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(364, 217, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(365, 218, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(366, 219, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(367, 220, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(368, 221, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(369, 222, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(370, 223, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(371, 224, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(372, 10, 11, 'All', 'All', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(373, 11, 11, 'All', 'No', 'All', 0, 'All', 'No', 'All', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(374, 12, 11, 'All', 'No', 'No', 0, 'No', 'No', 'All', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(375, 13, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(376, 14, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(377, 15, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(378, 16, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(379, 17, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(380, 21, 11, 'All', 'All', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(381, 225, 11, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(382, 205, 11, 'All', 'No', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(383, 52, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(384, 53, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(385, 54, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(386, 55, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(387, 56, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(388, 57, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(389, 58, 11, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'All', 'No', 'No', 'No', 'No'),
(390, 59, 11, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(391, 60, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(392, 61, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(393, 1, 11, 'All', 'All', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All'),
(394, 2, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(395, 3, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(396, 4, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(397, 5, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(398, 6, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(399, 7, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(400, 226, 11, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'All', 'No', 'No', 'No', 'No', 'All', 'All'),
(401, 227, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(402, 228, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(403, 229, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(404, 230, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(405, 23, 11, 'All', 'All', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(406, 24, 11, 'All', 'No', 'All', 0, 'All', 'No', 'All', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(407, 25, 11, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(408, 26, 11, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'All', 'No', 'No', NULL, 'Dept. Teams', 'All', 'All', 'No', 'No', 'No', 'No', 'No'),
(409, 27, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(410, 30, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(411, 31, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(412, 32, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(413, 149, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(414, 150, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(415, 151, 11, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(416, 152, 11, 'All', 'No', 'No', 0, 'All', 'No', 'No', 'No', 0, 'No', 'All', 'No', 'No', NULL, 'Self Team Members', 'All', 'All', 'No', 'No', 'No', 'No', 'No'),
(417, 153, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(418, 154, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(419, 155, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(420, 156, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(421, 157, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(422, 158, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(423, 81, 11, 'All', 'All', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'All'),
(424, 82, 11, 'All', 'No', 'All', 0, 'All', 'No', 'All', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(425, 83, 11, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(426, 84, 11, 'All', 'No', 'No', 0, 'All', 'No', 'No', 'No', 0, 'No', 'All', 'No', 'No', NULL, 'Dept. Teams', 'All', 'All', 'No', 'No', 'No', 'No', 'No'),
(427, 85, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(428, 86, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(429, 87, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(430, 88, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(431, 89, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(432, 90, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(433, 33, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(434, 34, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(435, 35, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(436, 36, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(437, 37, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(438, 38, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(439, 39, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(440, 40, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(441, 41, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(442, 42, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(443, 43, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(444, 44, 11, 'All', 'No', 'No', 0, 'All', 'No', 'No', 'No', 0, 'No', 'All', 'No', 'No', NULL, 'Dept. Teams', 'All', 'All', 'No', 'No', 'No', 'No', 'No'),
(445, 45, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(446, 46, 11, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'All', 'No', 'No', 'No', 'No', 'No'),
(447, 47, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(448, 48, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(449, 49, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(450, 50, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(451, 51, 11, 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', 1, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(452, 19, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(453, 62, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(454, 63, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(455, 64, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(456, 65, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(457, 66, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(458, 67, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(459, 68, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(460, 69, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(461, 70, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(462, 231, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(463, 232, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(464, 233, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(465, 234, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(466, 235, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(467, 236, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(468, 237, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(469, 238, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(470, 239, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(471, 240, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(472, 241, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(473, 242, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(474, 243, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(475, 244, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(476, 245, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(477, 246, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(478, 247, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(479, 248, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(480, 249, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(481, 101, 11, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(482, 208, NULL, 'Self Only', 'No', 'No', 0, 'No', 'No', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'No', 'No'),
(483, 208, 11, 'All', 'No', 'No', 1, 'All', 'All', 'No', 'No', 0, 'No', 'No', 'No', 'No', NULL, 'No', 'No', 'No', 'No', 'No', 'No', 'All', 'All');

-- --------------------------------------------------------

--
-- Table structure for table `xhr_documents`
--

CREATE TABLE IF NOT EXISTS `xhr_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=250 ;

--
-- Dumping data for table `xhr_documents`
--

INSERT INTO `xhr_documents` (`id`, `department_id`, `name`) VALUES
(1, 5, 'xPurchase\\PurchaseOrder_Draft'),
(2, 5, 'xPurchase\\PurchaseOrder_Redesign'),
(3, 5, 'xPurchase\\PurchaseOrder_Submitted'),
(4, 5, 'xPurchase\\PurchaseOrder_Approved'),
(5, 5, 'xPurchase\\PurchaseOrder_Processing'),
(6, 5, 'xPurchase\\PurchaseOrder_Completed'),
(7, 5, 'xPurchase\\PurchaseOrder_Rejected'),
(8, 4, 'xShop\\Shop'),
(9, 4, 'xShop\\Category'),
(10, 4, 'xShop\\Order_Draft'),
(11, 4, 'xShop\\Order_Submitted'),
(12, 4, 'xShop\\Order_Approved'),
(13, 4, 'xShop\\Order_Processing'),
(14, 4, 'xShop\\Order_Processed'),
(15, 4, 'xShop\\Order_Shipping'),
(16, 4, 'xShop\\Order_Completed'),
(17, 4, 'xShop\\Order_Cancelled'),
(18, 4, 'xShop\\OrderDetails'),
(19, 4, 'xCRM\\Activity'),
(20, 4, 'xShop\\SalesOrderAttachment'),
(21, 4, 'xShop\\Order_Redesign'),
(22, 4, 'xShop\\SalesOrderDetailAttachment'),
(23, 13, 'xProduction\\Jobcard_Draft'),
(24, 13, 'xProduction\\Jobcard_Submitted'),
(25, 13, 'xProduction\\Jobcard_Approved'),
(26, 13, 'xProduction\\Jobcard_Received'),
(27, 13, 'xProduction\\Jobcard_Assigned'),
(28, 13, 'xProduction\\Jobcard_Processing'),
(29, 13, 'xProduction\\Jobcard_Processed'),
(30, 13, 'xProduction\\Jobcard_Forwarded'),
(31, 13, 'xProduction\\Jobcard_Completed'),
(32, 13, 'xProduction\\Jobcard_Cancelled'),
(33, 9, 'xStore\\MaterialRequestSent_Draft'),
(34, 9, 'xStore\\MaterialRequestSent_Submitted'),
(35, 9, 'xStore\\MaterialRequestSent_Approved'),
(36, 9, 'xStore\\MaterialRequestSent_Received'),
(37, 9, 'xStore\\MaterialRequestSent_Assigned'),
(38, 9, 'xStore\\MaterialRequestSent_Processing'),
(39, 9, 'xStore\\MaterialRequestSent_Processed'),
(40, 9, 'xStore\\MaterialRequestSent_Completed'),
(41, 9, 'xStore\\MaterialRequestSent_Cancelled'),
(42, 9, 'xStore\\MaterialRequestSent_Return'),
(43, 9, 'xStore\\MaterialRequestReceived_ToReceive'),
(44, 9, 'xStore\\MaterialRequestReceived_Received'),
(45, 9, 'xStore\\MaterialRequestReceived_Assigned'),
(46, 9, 'xStore\\MaterialRequestReceived_Processing'),
(47, 9, 'xStore\\MaterialRequestReceived_Processed'),
(48, 9, 'xStore\\MaterialRequestReceived_Completed'),
(49, 9, 'xStore\\MaterialRequestReceived_Cancelled'),
(50, 9, 'xStore\\MaterialRequestReceived_Return'),
(51, 9, 'xStore\\MaterialRequestReceived_Approved'),
(52, 13, 'xStore\\MaterialRequestSent_Draft'),
(53, 13, 'xStore\\MaterialRequestSent_Submitted'),
(54, 13, 'xStore\\MaterialRequestSent_Approved'),
(55, 13, 'xStore\\MaterialRequestSent_Received'),
(56, 13, 'xStore\\MaterialRequestSent_Assigned'),
(57, 13, 'xStore\\MaterialRequestSent_Processing'),
(58, 13, 'xStore\\MaterialRequestSent_Processed'),
(59, 13, 'xStore\\MaterialRequestSent_Completed'),
(60, 13, 'xStore\\MaterialRequestSent_Cancelled'),
(61, 13, 'xStore\\MaterialRequestSent_Return'),
(62, 13, 'xStore\\MaterialRequestReceived_ToReceive'),
(63, 13, 'xStore\\MaterialRequestReceived_Received'),
(64, 13, 'xStore\\MaterialRequestReceived_Assigned'),
(65, 13, 'xStore\\MaterialRequestReceived_Processing'),
(66, 13, 'xStore\\MaterialRequestReceived_Processed'),
(67, 13, 'xStore\\MaterialRequestReceived_Completed'),
(68, 13, 'xStore\\MaterialRequestReceived_Cancelled'),
(69, 13, 'xStore\\MaterialRequestReceived_Return'),
(70, 13, 'xStore\\MaterialRequestReceived_Approved'),
(71, 12, 'xStore\\MaterialRequestSent_Draft'),
(72, 12, 'xStore\\MaterialRequestSent_Submitted'),
(73, 12, 'xStore\\MaterialRequestSent_Approved'),
(74, 12, 'xStore\\MaterialRequestSent_Received'),
(75, 12, 'xStore\\MaterialRequestSent_Assigned'),
(76, 12, 'xStore\\MaterialRequestSent_Processing'),
(77, 12, 'xStore\\MaterialRequestSent_Processed'),
(78, 12, 'xStore\\MaterialRequestSent_Completed'),
(79, 12, 'xStore\\MaterialRequestSent_Cancelled'),
(80, 12, 'xStore\\MaterialRequestSent_Return'),
(81, 18, 'xProduction\\Jobcard_Draft'),
(82, 18, 'xProduction\\Jobcard_Submitted'),
(83, 18, 'xProduction\\Jobcard_Approved'),
(84, 18, 'xProduction\\Jobcard_Received'),
(85, 18, 'xProduction\\Jobcard_Assigned'),
(86, 18, 'xProduction\\Jobcard_Processing'),
(87, 18, 'xProduction\\Jobcard_Processed'),
(88, 18, 'xProduction\\Jobcard_Forwarded'),
(89, 18, 'xProduction\\Jobcard_Completed'),
(90, 18, 'xProduction\\Jobcard_Cancelled'),
(91, 2, 'xStore\\MaterialRequestSent_Draft'),
(92, 2, 'xStore\\MaterialRequestSent_Submitted'),
(93, 2, 'xStore\\MaterialRequestSent_Approved'),
(94, 2, 'xStore\\MaterialRequestSent_Received'),
(95, 2, 'xStore\\MaterialRequestSent_Assigned'),
(96, 2, 'xStore\\MaterialRequestSent_Processing'),
(97, 2, 'xStore\\MaterialRequestSent_Processed'),
(98, 2, 'xStore\\MaterialRequestSent_Completed'),
(99, 2, 'xStore\\MaterialRequestSent_Cancelled'),
(100, 2, 'xStore\\MaterialRequestSent_Return'),
(101, 13, 'xCRM\\Activity'),
(102, 14, 'xProduction\\Jobcard_Draft'),
(103, 14, 'xProduction\\Jobcard_Submitted'),
(104, 14, 'xProduction\\Jobcard_Approved'),
(105, 14, 'xProduction\\Jobcard_Received'),
(106, 14, 'xProduction\\Jobcard_Assigned'),
(107, 14, 'xProduction\\Jobcard_Processing'),
(108, 14, 'xProduction\\Jobcard_Processed'),
(109, 14, 'xProduction\\Jobcard_Forwarded'),
(110, 14, 'xProduction\\Jobcard_Completed'),
(111, 14, 'xProduction\\Jobcard_Cancelled'),
(112, 5, 'xStore\\MaterialRequestSent_Draft'),
(113, 5, 'xStore\\MaterialRequestSent_Submitted'),
(114, 5, 'xStore\\MaterialRequestSent_Approved'),
(115, 5, 'xStore\\MaterialRequestSent_Received'),
(116, 5, 'xStore\\MaterialRequestSent_Assigned'),
(117, 5, 'xStore\\MaterialRequestSent_Processing'),
(118, 5, 'xStore\\MaterialRequestSent_Processed'),
(119, 5, 'xStore\\MaterialRequestSent_Completed'),
(120, 5, 'xStore\\MaterialRequestSent_Cancelled'),
(121, 5, 'xStore\\MaterialRequestSent_Return'),
(122, 5, 'xStore\\MaterialRequestReceived_ToReceive'),
(123, 5, 'xStore\\MaterialRequestReceived_Received'),
(124, 5, 'xStore\\MaterialRequestReceived_Assigned'),
(125, 5, 'xStore\\MaterialRequestReceived_Processing'),
(126, 5, 'xStore\\MaterialRequestReceived_Processed'),
(127, 5, 'xStore\\MaterialRequestReceived_Completed'),
(128, 5, 'xStore\\MaterialRequestReceived_Cancelled'),
(129, 5, 'xStore\\MaterialRequestReceived_Return'),
(130, 5, 'xStore\\MaterialRequestReceived_Approved'),
(131, 4, 'xStore\\MaterialRequestSent_Draft'),
(132, 4, 'xStore\\MaterialRequestSent_Submitted'),
(133, 4, 'xStore\\MaterialRequestSent_Approved'),
(134, 4, 'xStore\\MaterialRequestSent_Received'),
(135, 4, 'xStore\\MaterialRequestSent_Assigned'),
(136, 4, 'xStore\\MaterialRequestSent_Processing'),
(137, 4, 'xStore\\MaterialRequestSent_Processed'),
(138, 4, 'xStore\\MaterialRequestSent_Completed'),
(139, 4, 'xStore\\MaterialRequestSent_Cancelled'),
(140, 4, 'xStore\\MaterialRequestSent_Return'),
(141, 12, 'xDispatch\\DispatchRequest_Draft'),
(142, 12, 'xDispatch\\DispatchRequest_Approved'),
(143, 12, 'xDispatch\\DispatchRequest_Received'),
(144, 12, 'xDispatch\\DispatchRequest_Assigned'),
(145, 12, 'xDispatch\\DispatchRequest_Processed'),
(146, 12, 'xDispatch\\DispatchRequest_Submitted'),
(147, 12, 'xDispatch\\DispatchRequest_Completed'),
(148, 12, 'xDispatch\\DispatchRequest_Cancelled'),
(149, 15, 'xProduction\\Jobcard_Draft'),
(150, 15, 'xProduction\\Jobcard_Submitted'),
(151, 15, 'xProduction\\Jobcard_Approved'),
(152, 15, 'xProduction\\Jobcard_Received'),
(153, 15, 'xProduction\\Jobcard_Assigned'),
(154, 15, 'xProduction\\Jobcard_Processing'),
(155, 15, 'xProduction\\Jobcard_Processed'),
(156, 15, 'xProduction\\Jobcard_Forwarded'),
(157, 15, 'xProduction\\Jobcard_Completed'),
(158, 15, 'xProduction\\Jobcard_Cancelled'),
(159, 16, 'xProduction\\Jobcard_Draft'),
(160, 16, 'xProduction\\Jobcard_Submitted'),
(161, 16, 'xProduction\\Jobcard_Approved'),
(162, 16, 'xProduction\\Jobcard_Received'),
(163, 16, 'xProduction\\Jobcard_Assigned'),
(164, 16, 'xProduction\\Jobcard_Processing'),
(165, 16, 'xProduction\\Jobcard_Processed'),
(166, 16, 'xProduction\\Jobcard_Forwarded'),
(167, 16, 'xProduction\\Jobcard_Completed'),
(168, 16, 'xProduction\\Jobcard_Cancelled'),
(169, 17, 'xProduction\\Jobcard_Draft'),
(170, 17, 'xProduction\\Jobcard_Submitted'),
(171, 17, 'xProduction\\Jobcard_Approved'),
(172, 17, 'xProduction\\Jobcard_Received'),
(173, 17, 'xProduction\\Jobcard_Assigned'),
(174, 17, 'xProduction\\Jobcard_Processing'),
(175, 17, 'xProduction\\Jobcard_Processed'),
(176, 17, 'xProduction\\Jobcard_Forwarded'),
(177, 17, 'xProduction\\Jobcard_Completed'),
(178, 17, 'xProduction\\Jobcard_Cancelled'),
(179, 19, 'xProduction\\Jobcard_Draft'),
(180, 19, 'xProduction\\Jobcard_Submitted'),
(181, 19, 'xProduction\\Jobcard_Approved'),
(182, 19, 'xProduction\\Jobcard_Received'),
(183, 19, 'xProduction\\Jobcard_Assigned'),
(184, 19, 'xProduction\\Jobcard_Processing'),
(185, 19, 'xProduction\\Jobcard_Processed'),
(186, 19, 'xProduction\\Jobcard_Forwarded'),
(187, 19, 'xProduction\\Jobcard_Completed'),
(188, 19, 'xProduction\\Jobcard_Cancelled'),
(189, 20, 'xProduction\\Jobcard_Draft'),
(190, 20, 'xProduction\\Jobcard_Submitted'),
(191, 20, 'xProduction\\Jobcard_Approved'),
(192, 20, 'xProduction\\Jobcard_Received'),
(193, 20, 'xProduction\\Jobcard_Assigned'),
(194, 20, 'xProduction\\Jobcard_Processing'),
(195, 20, 'xProduction\\Jobcard_Processed'),
(196, 20, 'xProduction\\Jobcard_Forwarded'),
(197, 20, 'xProduction\\Jobcard_Completed'),
(198, 20, 'xProduction\\Jobcard_Cancelled'),
(199, 4, 'xShop\\Quotation_Draft'),
(200, 4, 'xShop\\Quotation_Redesign'),
(201, 4, 'xShop\\Quotation_Approved'),
(202, 4, 'xShop\\Quotation_Cancelled'),
(203, 4, 'xShop\\Quotation_Submitted'),
(204, 4, 'xShop\\QuotationItem'),
(205, 4, 'xShop\\TermsAndCondition'),
(206, 14, 'xCRM\\Activity'),
(207, 3, 'xMarketingCampaign\\Lead'),
(208, 4, 'xShop\\Opportunity'),
(209, 12, 'xDispatch\\DeliveryNote_Draft'),
(210, 12, 'xDispatch\\DeliveryNote_Processing'),
(211, 12, 'xDispatch\\DeliveryNote_Assigned'),
(212, 12, 'xDispatch\\DeliveryNote_Processed'),
(213, 4, 'xShop\\Priority'),
(214, 3, 'xCRM\\Activity'),
(215, 3, 'xStore\\MaterialRequestSent_Draft'),
(216, 3, 'xStore\\MaterialRequestSent_Submitted'),
(217, 3, 'xStore\\MaterialRequestSent_Approved'),
(218, 3, 'xStore\\MaterialRequestSent_Received'),
(219, 3, 'xStore\\MaterialRequestSent_Assigned'),
(220, 3, 'xStore\\MaterialRequestSent_Processing'),
(221, 3, 'xStore\\MaterialRequestSent_Processed'),
(222, 3, 'xStore\\MaterialRequestSent_Completed'),
(223, 3, 'xStore\\MaterialRequestSent_Cancelled'),
(224, 3, 'xStore\\MaterialRequestSent_Return'),
(225, 4, 'xShop\\Customer'),
(226, 14, 'xProduction\\Task_Assigned'),
(227, 14, 'xProduction\\Task_Processing'),
(228, 14, 'xProduction\\Task_Processed'),
(229, 14, 'xProduction\\Task_Completed'),
(230, 14, 'xProduction\\Task_Cancelled'),
(231, 14, 'xStore\\MaterialRequestSent_Draft'),
(232, 14, 'xStore\\MaterialRequestSent_Submitted'),
(233, 14, 'xStore\\MaterialRequestSent_Approved'),
(234, 14, 'xStore\\MaterialRequestSent_Received'),
(235, 14, 'xStore\\MaterialRequestSent_Assigned'),
(236, 14, 'xStore\\MaterialRequestSent_Processing'),
(237, 14, 'xStore\\MaterialRequestSent_Processed'),
(238, 14, 'xStore\\MaterialRequestSent_Completed'),
(239, 14, 'xStore\\MaterialRequestSent_Cancelled'),
(240, 14, 'xStore\\MaterialRequestSent_Return'),
(241, 14, 'xStore\\MaterialRequestReceived_ToReceive'),
(242, 14, 'xStore\\MaterialRequestReceived_Received'),
(243, 14, 'xStore\\MaterialRequestReceived_Assigned'),
(244, 14, 'xStore\\MaterialRequestReceived_Processing'),
(245, 14, 'xStore\\MaterialRequestReceived_Processed'),
(246, 14, 'xStore\\MaterialRequestReceived_Completed'),
(247, 14, 'xStore\\MaterialRequestReceived_Cancelled'),
(248, 14, 'xStore\\MaterialRequestReceived_Return'),
(249, 14, 'xStore\\MaterialRequestReceived_Approved');

-- --------------------------------------------------------

--
-- Table structure for table `xhr_employees`
--

CREATE TABLE IF NOT EXISTS `xhr_employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `doj` date DEFAULT NULL,
  `offer_date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `contract_end_date` date DEFAULT NULL,
  `date_of_retirement` date DEFAULT NULL,
  `company_email_id` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `permanent_addesss` text,
  `current_address` text,
  `emergency_contact_no` varchar(255) DEFAULT NULL,
  `passport_no` varchar(255) DEFAULT NULL,
  `passport_issue_date` date DEFAULT NULL,
  `passport_expiry_date` date DEFAULT NULL,
  `passport_place_of_issue` varchar(255) DEFAULT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `family_background` text,
  `health_details` text,
  `qualifiction` varchar(255) DEFAULT NULL,
  `qualifiction_level` varchar(255) DEFAULT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `major_optional_subject` text,
  `previous_work_company` text,
  `previous_work_designation` varchar(255) DEFAULT NULL,
  `previous_work_salary` varchar(255) DEFAULT NULL,
  `previous_company_branch` varchar(255) DEFAULT NULL,
  `previous_company_department` varchar(255) DEFAULT NULL,
  `resignation_letter_date` date DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `relation` varchar(255) DEFAULT NULL,
  `emergency_contact_person` varchar(255) DEFAULT NULL,
  `personal_email` varchar(255) DEFAULT NULL,
  `previous_company_address` text,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `empolyee_image_id` int(11) DEFAULT NULL,
  `confirmation_date` date DEFAULT NULL,
  `pre_resignation_letter_date` date DEFAULT NULL,
  `pre_relieving_date` date DEFAULT NULL,
  `pre_reason_of_resignation` text,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_id` (`post_id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `xhr_employees`
--

INSERT INTO `xhr_employees` (`id`, `name`, `dob`, `doj`, `offer_date`, `status`, `contract_end_date`, `date_of_retirement`, `company_email_id`, `mobile_no`, `permanent_addesss`, `current_address`, `emergency_contact_no`, `passport_no`, `passport_issue_date`, `passport_expiry_date`, `passport_place_of_issue`, `blood_group`, `marital_status`, `family_background`, `health_details`, `qualifiction`, `qualifiction_level`, `pass`, `major_optional_subject`, `previous_work_company`, `previous_work_designation`, `previous_work_salary`, `previous_company_branch`, `previous_company_department`, `resignation_letter_date`, `gender`, `relation`, `emergency_contact_person`, `personal_email`, `previous_company_address`, `from_date`, `to_date`, `post_id`, `department_id`, `user_id`, `empolyee_image_id`, `confirmation_date`, `pre_resignation_letter_date`, `pre_relieving_date`, `pre_reason_of_resignation`, `is_active`) VALUES
(1, 'Ayushi Jain', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 31, 2, 2, NULL, NULL, NULL, NULL, NULL, 1),
(2, 'Rakesh Sinha', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 30, 4, 3, NULL, NULL, NULL, NULL, NULL, 1),
(3, 'Vijay Mali', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 31, 2, 4, NULL, NULL, NULL, NULL, NULL, 1),
(4, 'Designing Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, 4, 5, NULL, NULL, NULL, NULL, NULL, 1),
(5, 'Designing HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 3, 13, 6, NULL, NULL, NULL, NULL, NULL, 1),
(6, 'LFP HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 5, 21, 7, NULL, NULL, NULL, NULL, NULL, 1),
(7, 'LFP Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, 4, 8, NULL, NULL, NULL, NULL, NULL, 1),
(8, 'SP Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, 4, 9, NULL, NULL, NULL, NULL, NULL, 1),
(9, 'SP HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 30, 4, 10, NULL, NULL, NULL, NULL, NULL, 1),
(10, 'Offset HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 9, 15, 11, NULL, NULL, NULL, NULL, NULL, 1),
(11, 'Offset Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 10, 15, 12, NULL, NULL, NULL, NULL, NULL, 1),
(12, 'DP HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 11, 14, 13, NULL, NULL, NULL, NULL, NULL, 1),
(13, 'Dp Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 12, 14, 14, NULL, NULL, NULL, NULL, NULL, 1),
(14, 'Coating Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 14, 16, 15, NULL, NULL, NULL, NULL, NULL, 1),
(15, 'Coating HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 13, 16, 16, NULL, NULL, NULL, NULL, NULL, 1),
(16, 'Cutting Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, 22, 17, NULL, NULL, NULL, NULL, NULL, 1),
(17, 'Cutting HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 15, 22, 18, NULL, NULL, NULL, NULL, NULL, 1),
(18, 'Varnish Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 18, 23, 19, NULL, NULL, NULL, NULL, NULL, 1),
(19, 'Lamination Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 20, 18, 20, NULL, NULL, NULL, NULL, NULL, 1),
(20, 'Varnish HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 17, 23, 22, NULL, NULL, NULL, NULL, NULL, 1),
(21, 'Uv Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 36, 4, 24, NULL, NULL, NULL, NULL, NULL, 1),
(22, 'Lamination HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 19, 18, 26, NULL, NULL, NULL, NULL, NULL, 1),
(23, 'HotFoil Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 24, 19, 28, NULL, NULL, NULL, NULL, NULL, 1),
(24, 'UV HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 21, 17, 29, NULL, NULL, NULL, NULL, NULL, 1),
(25, 'Hot Foil HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 23, 19, 30, NULL, NULL, NULL, NULL, NULL, 1),
(26, 'Die Cut HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 25, 24, 27, NULL, NULL, NULL, NULL, NULL, 1),
(27, 'Binding HOD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 28, 25, 25, NULL, NULL, NULL, NULL, NULL, 1),
(28, 'Die Cut Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 26, 24, 23, NULL, NULL, NULL, NULL, NULL, 1),
(29, 'Binding Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 29, 25, 21, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xhr_employee_attendence`
--

CREATE TABLE IF NOT EXISTS `xhr_employee_attendence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `xhr_employee_attendence`
--

INSERT INTO `xhr_employee_attendence` (`id`, `employee_id`, `date`, `status`) VALUES
(2, 3, '2015-03-25', 'half_day'),
(3, 2, '2015-03-25', 'present'),
(4, 1, '2015-03-25', 'absent'),
(5, 1, '2015-03-24', 'absent'),
(6, 3, '2015-03-24', 'absent'),
(7, 2, '2015-03-24', 'absent'),
(8, 1, '2015-03-26', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `xhr_employee_leave`
--

CREATE TABLE IF NOT EXISTS `xhr_employee_leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `leave_type_id` int(11) DEFAULT NULL,
  `from_date` date DEFAULT NULL,
  `to_date` date DEFAULT NULL,
  `half_day` tinyint(1) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `reason` text,
  PRIMARY KEY (`id`),
  KEY `fk_employee_id` (`employee_id`),
  KEY `fk_leave_type_id` (`leave_type_id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `xhr_employee_leave`
--

INSERT INTO `xhr_employee_leave` (`id`, `employee_id`, `leave_type_id`, `from_date`, `to_date`, `half_day`, `department_id`, `reason`) VALUES
(1, 2, 1, '2015-03-03', '2015-03-08', 0, NULL, 'bimar he'),
(2, 1, 1, '2015-03-05', '2015-03-10', 0, NULL, 'Laapta he'),
(3, 3, 1, '2015-03-04', '2015-03-04', 0, NULL, ''),
(4, 5, 1, '2015-03-05', '2015-03-12', 0, NULL, '');

-- --------------------------------------------------------

--
-- Table structure for table `xhr_holiday_blocks`
--

CREATE TABLE IF NOT EXISTS `xhr_holiday_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xhr_holiday_blocks`
--

INSERT INTO `xhr_holiday_blocks` (`id`, `department_id`, `name`) VALUES
(1, 4, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `xhr_leave_types`
--

CREATE TABLE IF NOT EXISTS `xhr_leave_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `max_day_allow` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_carry_forward` tinyint(1) DEFAULT NULL,
  `is_lwp` tinyint(1) DEFAULT NULL,
  `allow_negative_balance` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xhr_leave_types`
--

INSERT INTO `xhr_leave_types` (`id`, `max_day_allow`, `name`, `is_carry_forward`, `is_lwp`, `allow_negative_balance`) VALUES
(1, 10, 'medical', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xhr_posts`
--

CREATE TABLE IF NOT EXISTS `xhr_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `parent_post_id` int(11) DEFAULT NULL,
  `can_create_team` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `xhr_posts`
--

INSERT INTO `xhr_posts` (`id`, `department_id`, `name`, `is_active`, `parent_post_id`, `can_create_team`) VALUES
(1, 1, 'Director', 1, NULL, 1),
(2, 1, 'CEO', 1, 1, 0),
(3, 13, 'Designer Head', 1, 2, 1),
(4, 13, 'Designer Employee', 1, 3, 0),
(5, 21, 'LFP Head', 1, 2, 1),
(6, 21, 'LFP Employee', 1, 5, 0),
(7, 20, 'SP Head', 1, 2, 1),
(8, 20, 'SP Employee', 1, 7, 0),
(9, 15, 'Offset Head', 1, 2, 1),
(10, 15, 'Offset Employee', 1, 9, 1),
(11, 14, 'Digital Press Head', 1, 2, 1),
(12, 14, 'Digital Press Employee', 1, 11, 0),
(13, 16, 'Coating Head', 1, 2, 1),
(14, 16, 'Coating Employee', 1, 13, 0),
(15, 22, 'Cutting Head', 1, 2, 1),
(16, 22, 'Cutting Employee', 1, 15, 0),
(17, 23, 'Varnish Head', 1, 2, 1),
(18, 23, 'Varnish Employee', 1, 17, 0),
(19, 18, 'Lamination Head', 1, 2, 1),
(20, 18, 'Lamination Employee', 1, 19, 0),
(21, 17, 'UV Head', 1, 2, 1),
(22, 17, 'UV Employee', 1, 21, 0),
(23, 19, 'Hot Foil Head', 1, 2, 1),
(24, 19, 'Hot Foil Employee', 1, 23, 0),
(25, 24, 'Die Cut Head', 1, 2, 1),
(26, 24, 'Die Cut Employee', 1, 25, 0),
(27, 5, 'Manager', 1, 2, 1),
(28, 25, 'Binding Head', 1, 2, 1),
(29, 25, 'Binding Employee', 1, 28, 0),
(30, 4, 'Sales Manager', 1, 2, 1),
(31, 2, 'HR Manager', 1, 2, 1),
(32, 2, 'HR Employee', 1, 31, 0),
(33, 5, 'Purchase Employee', 1, 27, 0),
(34, 9, 'Manager', 1, 2, 1),
(35, 9, 'Employee', 1, 34, 0),
(36, 4, 'Employee', 1, 30, 0);

-- --------------------------------------------------------

--
-- Table structure for table `xhr_salary`
--

CREATE TABLE IF NOT EXISTS `xhr_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) DEFAULT NULL,
  `salary_type_id` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_employee_id` (`employee_id`),
  KEY `fk_salary_type_id` (`salary_type_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xhr_salary_templates`
--

CREATE TABLE IF NOT EXISTS `xhr_salary_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_post_id` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xhr_salary_types`
--

CREATE TABLE IF NOT EXISTS `xhr_salary_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_template_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_salary_template_id` (`salary_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xhr_template_salary`
--

CREATE TABLE IF NOT EXISTS `xhr_template_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salary_template_id` int(11) DEFAULT NULL,
  `salary_type_id` int(11) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_salary_template_id` (`salary_template_id`),
  KEY `fk_salary_type_id` (`salary_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xImageGallery_gallery`
--

CREATE TABLE IF NOT EXISTS `xImageGallery_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xImageGallery_gallery`
--

INSERT INTO `xImageGallery_gallery` (`id`, `epan_id`, `name`) VALUES
(1, 1, 'social'),
(2, 1, 'tset');

-- --------------------------------------------------------

--
-- Table structure for table `xImageGallery_images`
--

CREATE TABLE IF NOT EXISTS `xImageGallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `name` text,
  `is_publish` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_id` (`gallery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `xImageGallery_images`
--

INSERT INTO `xImageGallery_images` (`id`, `gallery_id`, `image_url`, `title`, `name`, `is_publish`) VALUES
(1, 1, 'epans/web/bigstock-E-commerce-Shopping-cart-with-56191391-300x200.jpg', 'image1', '<p>page_xImageGallery_page_owner_dashboard</p>', 1),
(2, 1, 'epans/web/seo-puzzle-piece-300x200.jpg', 'image2', '<p>&nbsp;jgjghhjdghfdhh,l;h</p>\r\n<p>fhfg</p>\r\n<p>hfgh</p>\r\n<p>fghf</p>\r\n<p>hfg</p>\r\n<p>hfg</p>\r\n<p>hfh</p>\r\n<p>gh</p>\r\n<p>fgh</p>\r\n<p>fg</p>\r\n<p>hfhfgh</p>', 1),
(3, 1, 'epans/web/n1', 'image3', '<p>vckgnfhfghfghh</p>\r\n<p>fghfg</p>\r\n<p>hfg</p>\r\n<p>hfg</p>\r\n<p>hfh</p>\r\n<p>fgh</p>\r\n<p>fhfg</p>\r\n<p>hgf</p>\r\n<p>hfgh&nbsp;</p>', 1),
(4, 2, 'epans/web/bigstock-E-commerce-Shopping-cart-with-56191391-300x200.jpg', 'gfdgfdgd', '<p>&nbsp;gfdgfgfdgfdgdfg</p>\r\n<p>dfgdfgdfg</p>\r\n<p>fdgd</p>\r\n<p>fgdfg</p>\r\n<p>dfgd</p>\r\n<p>fgdf</p>\r\n<p>gdf</p>\r\n<p>gdfg</p>\r\n<p>df</p>\r\n<p>gdf</p>\r\n<p>gdfg</p>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_campaignnewsletter`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_campaignnewsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `newsletter_id` int(11) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_newsletter_id` (`newsletter_id`),
  KEY `fk_campaign_id` (`campaign_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xmarketingcampaign_campaignnewsletter`
--

INSERT INTO `xmarketingcampaign_campaignnewsletter` (`id`, `epan_id`, `newsletter_id`, `duration`, `campaign_id`) VALUES
(2, 1, 1, '2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_campaigns`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_campaigns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `starting_date` datetime DEFAULT NULL,
  `ending_date` datetime DEFAULT NULL,
  `effective_start_date` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xmarketingcampaign_campaigns`
--

INSERT INTO `xmarketingcampaign_campaigns` (`id`, `epan_id`, `name`, `starting_date`, `ending_date`, `effective_start_date`, `is_active`, `category_id`) VALUES
(1, 1, 'School Managment', '2015-03-23 00:00:00', '2015-03-31 00:00:00', 'CampaignDate', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_campaignsocialposts`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_campaignsocialposts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `socialpost_id` int(11) DEFAULT NULL,
  `post_on` date DEFAULT NULL,
  `at_hour` varchar(255) DEFAULT NULL,
  `at_minute` varchar(255) DEFAULT NULL,
  `is_posted` tinyint(1) DEFAULT NULL,
  `Facebook` tinyint(1) DEFAULT NULL,
  `GoogleBlogger` tinyint(1) DEFAULT NULL,
  `Linkedin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_campaign_id` (`campaign_id`),
  KEY `fk_socialpost_id` (`socialpost_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xmarketingcampaign_campaignsocialposts`
--

INSERT INTO `xmarketingcampaign_campaignsocialposts` (`id`, `epan_id`, `campaign_id`, `socialpost_id`, `post_on`, `at_hour`, `at_minute`, `is_posted`, `Facebook`, `GoogleBlogger`, `Linkedin`) VALUES
(1, 1, 1, 1, '2015-03-24', '00', '00', 0, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_campaigns_categories`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_campaigns_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xmarketingcampaign_campaigns_categories`
--

INSERT INTO `xmarketingcampaign_campaigns_categories` (`id`, `epan_id`, `name`) VALUES
(1, 1, 'school software');

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_config`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `email_host` varchar(255) DEFAULT NULL,
  `email_port` varchar(255) DEFAULT NULL,
  `email_username` varchar(255) DEFAULT NULL,
  `email_password` varchar(255) DEFAULT NULL,
  `email_reply_to` varchar(255) DEFAULT NULL,
  `email_reply_to_name` varchar(255) DEFAULT NULL,
  `sender_email` varchar(255) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `email_threshold` int(11) DEFAULT NULL,
  `smtp_auto_reconnect` int(11) DEFAULT NULL,
  `use_for_domains` varchar(255) DEFAULT NULL,
  `email_transport` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `encryption` varchar(255) DEFAULT NULL,
  `emails_in_BCC` int(11) DEFAULT NULL,
  `last_engaged_at` datetime DEFAULT NULL,
  `email_sent_in_this_minute` int(11) DEFAULT NULL,
  `return_path` varchar(255) DEFAULT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_cp_socialuser_cat`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_cp_socialuser_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `socialuser_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_campaign_id` (`campaign_id`),
  KEY `fk_socialuser_id` (`socialuser_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_cp_sub_cat`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_cp_sub_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_associate` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_campaign_id` (`campaign_id`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xmarketingcampaign_cp_sub_cat`
--

INSERT INTO `xmarketingcampaign_cp_sub_cat` (`id`, `epan_id`, `campaign_id`, `category_id`, `is_associate`) VALUES
(2, 1, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_data_grabber`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_data_grabber` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `site_url` varchar(255) DEFAULT NULL,
  `query_parameter` varchar(255) DEFAULT NULL,
  `paginator_parameter` varchar(255) DEFAULT NULL,
  `paginator_initial_value` varchar(255) DEFAULT NULL,
  `records_per_page` varchar(255) DEFAULT NULL,
  `paginator_based_on` varchar(255) DEFAULT NULL,
  `extra_url_parameters` varchar(255) DEFAULT NULL,
  `required_pause_between_hits` varchar(255) DEFAULT NULL,
  `result_selector` varchar(255) DEFAULT NULL,
  `result_format` varchar(255) DEFAULT NULL,
  `json_url_key` varchar(255) DEFAULT NULL,
  `reg_ex_on_href` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `last_run_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xMarketingCampaign_data_grabber`
--

INSERT INTO `xMarketingCampaign_data_grabber` (`id`, `epan_id`, `name`, `site_url`, `query_parameter`, `paginator_parameter`, `paginator_initial_value`, `records_per_page`, `paginator_based_on`, `extra_url_parameters`, `required_pause_between_hits`, `result_selector`, `result_format`, `json_url_key`, `reg_ex_on_href`, `created_at`, `last_run_at`, `is_active`) VALUES
(1, 1, 'xavoc Subscriber', 'google.com', '', '', '', '10', NULL, '', '', '', NULL, '', '', '2015-03-23 09:42:57', '2015-03-23 09:42:57', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_data_search_phrase`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_data_search_phrase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_grabber_id` int(11) DEFAULT NULL,
  `subscription_category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content_provided` longtext,
  `max_record_visit` varchar(255) DEFAULT NULL,
  `max_domain_depth` varchar(255) DEFAULT NULL,
  `max_page_depth` varchar(255) DEFAULT NULL,
  `page_parameter_start_value` varchar(255) DEFAULT NULL,
  `page_parameter_max_value` varchar(255) DEFAULT NULL,
  `last_page_checked_at` datetime DEFAULT NULL,
  `is_grabbed` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_data_grabber_id` (`data_grabber_id`),
  KEY `fk_subscription_category_id` (`subscription_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xMarketingCampaign_data_search_phrase`
--

INSERT INTO `xMarketingCampaign_data_search_phrase` (`id`, `data_grabber_id`, `subscription_category_id`, `name`, `content_provided`, `max_record_visit`, `max_domain_depth`, `max_page_depth`, `page_parameter_start_value`, `page_parameter_max_value`, `last_page_checked_at`, `is_grabbed`) VALUES
(1, 1, 1, 'hotel in udaipur', '<html lang="en-IN" itemtype="http://schema.org/WebPage" itemscope=""><head><meta itemprop="image" content="/images/google_favicon_128.png"><title>hotel in udaipur - Google Search</title>   <script src="https://apis.google.com/_/scs/abc-static/_/js/k=gapi.gapi.en.9Bct3OJ96gA.O/m=gapi_iframes,googleapis_client,plusone/rt=j/sv=1/d=1/ed=1/am=AAQ/rs=AItRSTPvFtsJdNTnw7r6dlELT3cG-Jn5Ow/cb=gapi.loaded_0" async=""></script><script>(function(){window.google={kEI:''2N8PVZ_DPJaQuATpzYHgBg'',kEXPI:''3700267,3700362,4011550,4011552,4011557,4011559,4020347,4021338,4023709,4024207,4024600,4028716,4028875,4028932,4029043,4029050,4029141,4029417,4029515,4029815,4030036,4030125,4030440,4031133,4031390,4031608,4031627,4031643,4031690,4031707,4031742,8300096,8500394,8500852,8501183,10200083'',authuser:0,j:{en:1,bv:21,pm:''p'',u:''c9c918f0'',qbp:0,rre:false},kSID:''2N8PVZ_DPJaQuATpzYHgBg''};google.kHL=''en-IN'';})();(function(){google.lc=[];google.li=0;google.getEI=function(a){for(var b;a&amp;&amp;(!a.getAttribute||!(b=a.getAttribute("eid")));)a=a.parentNode;return b||google.kEI};google.getLEI=function(a){for(var b=null;a&amp;&amp;(!a.getAttribute||!(b=a.getAttribute("leid")));)a=a.parentNode;return b};google.https=function(){return"https:"==window.location.protocol};google.ml=function(){};google.time=function(){return(new Date).getTime()};google.log=function(a,b,e,f,l){var d=new Image,h=google.lc,g=google.li,c="",m=google.ls||"";d.onerror=d.onload=d.onabort=function(){delete h[g]};h[g]=d;if(!e&amp;&amp;-1==b.search("&amp;ei=")){var k=google.getEI(f),c="&amp;ei="+k;-1==b.search("&amp;lei=")&amp;&amp;((f=google.getLEI(f))?c+="&amp;lei="+f:k!=google.kEI&amp;&amp;(c+="&amp;lei="+google.kEI))}a=e||"/"+(l||"gen_204")+"?atyp=i&amp;ct="+a+"&amp;cad="+b+c+m+"&amp;zx="+google.time();/^http:/i.test(a)&amp;&amp;google.https()?(google.ml(Error("a"),!1,{src:a,glmm:1}),delete h[g]):(d.src=a,google.li=g+1)};google.y={};google.x=function(a,b){google.y[a.id]=[a,b];return!1};google.load=function(a,b,e){google.x({id:a+n++},function(){google.load(a,b,e)})};var n=0;})();google.kCSI={};\r\ngoogle.j.b=(!!location.hash&amp;&amp;!!location.hash.match(''[#&amp;]((q|fp)=|tbs=rimg|tbs=simg|tbs=sbi)''))\r\n||(google.j.qbp==1);(function(){window.google.sn=''webhp'';google.timers={};google.startTick=function(a,b){google.timers[a]={t:{start:google.time()},bfr:!!b};window.performance&amp;&amp;window.performance.now&amp;&amp;(google.timers[a].wsrt=Math.floor(window.performance.now()))};google.tick=function(a,b,c){google.timers[a]||google.startTick(a);google.timers[a].t[b]=c||google.time()};google.startTick("load",!0);google.iml=function(a,b){google.tick("iml",a.id||a.src||a.name,b)};})();google.aft=function(){};(function(){''use strict'';var g=this,aa=function(a){var c=typeof a;if("object"==c)if(a){if(a instanceof Array)return"array";if(a instanceof Object)return c;var b=Object.prototype.toString.call(a);if("[object Window]"==b)return"object";if("[object Array]"==b||"number"==typeof a.length&amp;&amp;"undefined"!=typeof a.splice&amp;&amp;"undefined"!=typeof a.propertyIsEnumerable&amp;&amp;!a.propertyIsEnumerable("splice"))return"array";if("[object Function]"==b||"undefined"!=typeof a.call&amp;&amp;"undefined"!=typeof a.propertyIsEnumerable&amp;&amp;!a.propertyIsEnumerable("call"))return"function"}else return"null";else if("function"==c&amp;&amp;"undefined"==typeof a.call)return"object";return c},ba=Date.now||function(){return+new Date};var h={};var ca=function(a,c){if(null===c)return!1;if("contains"in a&amp;&amp;1==c.nodeType)return a.contains(c);if("compareDocumentPosition"in a)return a==c||Boolean(a.compareDocumentPosition(c)&amp;16);for(;c&amp;&amp;a!=c;)c=c.parentNode;return c==a};var da=function(a,c){return function(b){b||(b=window.event);return c.call(a,b)}},l=function(a){a=a.target||a.srcElement;!a.getAttribute&amp;&amp;a.parentNode&amp;&amp;(a=a.parentNode);return a},u="undefined"!=typeof navigator&amp;&amp;/Macintosh/.test(navigator.userAgent),ea="undefined"!=typeof navigator&amp;&amp;!/Opera/.test(navigator.userAgent)&amp;&amp;/WebKit/.test(navigator.userAgent),ga=function(a){var c=a.which||a.keyCode||a.key;ea&amp;&amp;3==c&amp;&amp;(c=13);if(13!=c&amp;&amp;32!=c)return!1;var b=l(a),d=(b.getAttribute("role")||b.type||b.tagName).toUpperCase(),e;(e="keydown"!=a.type)||("getAttribute"in b?(e=(b.getAttribute("role")||b.type||b.tagName).toUpperCase(),e="TEXT"!=e&amp;&amp;"TEXTAREA"!=e&amp;&amp;"PASSWORD"!=e&amp;&amp;"SEARCH"!=e&amp;&amp;("COMBOBOX"!=\r\ne||"INPUT"!=b.tagName.toUpperCase())&amp;&amp;!b.isContentEditable):e=!1,e=!e);if(e||a.ctrlKey||a.shiftKey||a.altKey||a.metaKey||"INPUT"==b.tagName.toUpperCase()&amp;&amp;b.type&amp;&amp;b.type.toUpperCase()in v&amp;&amp;32==c)return!1;if(a.originalTarget&amp;&amp;a.originalTarget!=b)return!0;(a=b.tagName in fa)||(a=b.getAttributeNode("tabindex"),a=null!=a&amp;&amp;a.specified);if(!(a&amp;&amp;0&lt;=b.tabIndex)||b.disabled)return!1;b="INPUT"!=b.tagName.toUpperCase()||b.type;a=!(d in w)&amp;&amp;13==c;return(0==w[d]%c||a)&amp;&amp;!!b},fa={A:1,INPUT:1,TEXTAREA:1,SELECT:1,BUTTON:1},w={A:13,BUTTON:0,CHECKBOX:32,COMBOBOX:13,LINK:13,LISTBOX:13,MENU:0,MENUBAR:0,MENUITEM:0,MENUITEMCHECKBOX:0,MENUITEMRADIO:0,OPTION:32,RADIO:32,RADIOGROUP:32,RESET:0,SUBMIT:0,TAB:0,TABLIST:0,TREE:13,TREEITEM:13},v={CHECKBOX:1,OPTION:1,RADIO:1};var z=function(){this.o=this.i=null},B=function(a,c){var b=A;b.i=a;b.o=c;return b};z.prototype.k=function(){var a=this.i;this.i&amp;&amp;this.i!=this.o?this.i=this.i.__owner||this.i.parentNode:this.i=null;return a};var C=function(){this.p=[];this.i=0;this.o=null;this.s=!1};C.prototype.k=function(){if(this.s)return A.k();if(this.i!=this.p.length){var a=this.p[this.i];this.i++;a!=this.o&amp;&amp;a&amp;&amp;a.__owner&amp;&amp;(this.s=!0,B(a.__owner,this.o));return a}return null};var A=new z,G=new C;var H;n:{var I=g.navigator;if(I){var J=I.userAgent;if(J){H=J;break n}}H=""}var K=function(a){return-1!=H.indexOf(a)};var L=function(){return K("Opera")||K("OPR")},M=function(){return K("Edge")||K("Trident")||K("MSIE")},N=function(){return(K("Chrome")||K("CriOS"))&amp;&amp;!L()&amp;&amp;!M()};var ha=L(),O=M(),ia=K("Gecko")&amp;&amp;!(-1!=H.toLowerCase().indexOf("webkit")&amp;&amp;!K("Edge"))&amp;&amp;!(K("Trident")||K("MSIE"))&amp;&amp;!K("Edge"),ja=-1!=H.toLowerCase().indexOf("webkit")&amp;&amp;!K("Edge"),ka=function(){var a=H;if(ia)return/rv\\:([^\\);]+)(\\)|;)/.exec(a);if(O&amp;&amp;K("Edge"))return/Edge\\/([\\d\\.]+)/.exec(a);if(O)return/\\b(?:MSIE|rv)[:]([^\\);]+)(\\)|;)/.exec(a);if(ja)return/WebKit\\/(\\S+)/.exec(a)};(function(){if(ha&amp;&amp;g.opera){var a=g.opera.version;return"function"==aa(a)?a():a}var a="",c=ka();c&amp;&amp;(a=c?c[1]:"");return O&amp;&amp;!K("Edge")&amp;&amp;(c=(c=g.document)?c.documentMode:void 0,c&gt;parseFloat(a))?String(c):a})();!K("Android")||N()||K("Firefox")||L();N();var Q=function(){this.B=[];this.i=[];this.k=[];this.s={};this.o=null;this.p=[];P(this,"_custom")},la="undefined"!=typeof navigator&amp;&amp;/iPhone|iPad|iPod/.test(navigator.userAgent),R=String.prototype.trim?function(a){return a.trim()}:function(a){return a.replace(/^\\s+/,"").replace(/\\s+$/,"")},ma=/\\s*;\\s*/,qa=function(a,c){return function(b){var d=c;if("_custom"==d){d=b.detail;if(!d||!d._type)return;d=d._type}var e;var f=d;"click"==f&amp;&amp;(u&amp;&amp;b.metaKey||!u&amp;&amp;b.ctrlKey||2==b.which||null==b.which&amp;&amp;4==b.button||b.shiftKey)?f="clickmod":ga(b)&amp;&amp;(f="clickkey");var k=b.srcElement||b.target,d=S(f,b,k,"",null),m,q;b.path?(G.p=b.path,G.i=0,G.o=this,G.s=!1,q=G):q=B(k,this);for(var r;r=q.k();){m=e=r;r=f;var n=m.__jsaction;if(!n){var x=void 0,n=null;"getAttribute"in m&amp;&amp;(n=m.getAttribute("jsaction"));if(x=\r\nn){n=h[x];if(!n){for(var n={},D=x.split(ma),E=0,oa=D?D.length:0;E&lt;oa;E++){var t=D[E];if(t){var F=t.indexOf(":"),U=-1!=F,pa=U?R(t.substr(0,F)):"click",t=U?R(t.substr(F+1)):t;n[pa]=t}}h[x]=n}m.__jsaction=n}else n=na,m.__jsaction=n}"clickkey"==r?r="click":"click"!=r||n.click||(r="clickonly");m={v:r,action:n[r]||"",event:null,D:!1};d=S(m.v,m.event||b,k,m.action||"",e,d.timeStamp);if(m.D||m.action)break}if(m&amp;&amp;m.action){if(k="clickkey"==f)k=l(b),k=(k.type||k.tagName).toUpperCase(),(k=32==(b.which||b.keyCode||\r\nb.key)&amp;&amp;"CHECKBOX"!=k)||(q=l(b),k=(q.getAttribute("role")||q.tagName).toUpperCase(),q=q.type,k="BUTTON"==k||!!q&amp;&amp;!(q.toUpperCase()in v));k&amp;&amp;(b.preventDefault?b.preventDefault():b.returnValue=!1);if("mouseenter"==f||"mouseleave"==f)if(k=b.relatedTarget,!("mouseover"==b.type&amp;&amp;"mouseenter"==f||"mouseout"==b.type&amp;&amp;"mouseleave"==f)||k&amp;&amp;(k===e||ca(e,k)))d.action="",d.actionElement=null;else{var f={},p;for(p in b)"function"!==typeof b[p]&amp;&amp;"srcElement"!==p&amp;&amp;"target"!==p&amp;&amp;(f[p]=b[p]);f.type="mouseover"==b.type?"mouseenter":"mouseleave";f.target=f.srcElement=e;f.bubbles=!1;d.event=f;d.targetElement=e}}else d.action="",d.actionElement=null;e=d;a.o&amp;&amp;(p=S(e.eventType,e.event,e.targetElement,e.action,e.actionElement,e.timeStamp),"clickonly"==p.eventType&amp;&amp;(p.eventType="click"),a.o(p,!0));if(e.actionElement)if("A"!=e.actionElement.tagName||"click"!=e.eventType&amp;&amp;"clickmod"!=e.eventType||(b.preventDefault?b.preventDefault():b.returnValue=!1),a.o)a.o(e);else{var y;if((p=g.document)&amp;&amp;!p.createEvent&amp;&amp;p.createEventObject)try{y=\r\np.createEventObject(b)}catch(ua){y=b}else y=b;e.event=y;a.p.push(e)}}},S=function(a,c,b,d,e,f){return{eventType:a,event:c,targetElement:b,action:d,actionElement:e,timeStamp:f||ba()}},na={},ra=function(a,c){return function(b){var d=a,e=c,f=!1;"mouseenter"==d?d="mouseover":"mouseleave"==d&amp;&amp;(d="mouseout");if(b.addEventListener){if("focus"==d||"blur"==d||"error"==d||"load"==d)f=!0;b.addEventListener(d,e,f)}else b.attachEvent&amp;&amp;("focus"==d?d="focusin":"blur"==d&amp;&amp;(d="focusout"),e=da(b,e),b.attachEvent("on"+d,e));return{v:d,w:e,C:f}}},P=function(a,c){if(!a.s.hasOwnProperty(c)){var b=qa(a,c),d=ra(c,b);a.s[c]=b;a.B.push(d);for(b=0;b&lt;a.i.length;++b){var e=a.i[b];e.k.push(d.call(null,e.i))}"click"==c&amp;&amp;P(a,"keydown")}};Q.prototype.w=function(a){return this.s[a]};var Y=function(a){var c=T,b=new sa(a);n:{for(var d=0;d&lt;c.i.length;d++)if(V(c.i[d],a)){a=!0;break n}a=!1}if(a)return c.k.push(b),b;W(c,b);c.i.push(b);X(c);return b},X=function(a){for(var c=a.k.concat(a.i),b=[],d=[],e=0;e&lt;a.i.length;++e){var f=a.i[e];Z(f,c)?(b.push(f),ta(f)):d.push(f)}for(e=0;e&lt;a.k.length;++e)f=a.k[e],Z(f,c)?b.push(f):(d.push(f),W(a,f));a.i=d;a.k=b},W=function(a,c){var b=c.i;la&amp;&amp;(b.style.cursor="pointer");for(b=0;b&lt;a.B.length;++b)c.k.push(a.B[b].call(null,c.i))},sa=function(a){this.i=a;this.k=[]},V=function(a,c){for(var b=a.i,d=c;b!=d&amp;&amp;d.parentNode;)d=d.parentNode;return b==d},Z=function(a,c){for(var b=0;b&lt;c.length;++b)if(c[b].i!=a.i&amp;&amp;V(c[b],a.i))return!0;return!1},ta=function(a){for(var c=0;c&lt;a.k.length;++c){var b=a.i,d=a.k[c];b.removeEventListener?b.removeEventListener(d.v,d.w,d.C):b.detachEvent&amp;&amp;b.detachEvent("on"+d.v,d.w)}a.k=[]};var T=new Q;Y(window.document.documentElement);P(T,"click");P(T,"focus");P(T,"focusin");P(T,"blur");P(T,"focusout");P(T,"error");P(T,"load");P(T,"change");P(T,"dblclick");P(T,"input");P(T,"keyup");P(T,"keydown");P(T,"keypress");P(T,"mousedown");P(T,"mouseenter");P(T,"mouseleave");P(T,"mouseout");P(T,"mouseover");P(T,"mouseup");P(T,"touchstart");P(T,"touchend");P(T,"touchcancel");P(T,"speech");window.google.jsad=function(a){var c=T;c.o=a;c.p&amp;&amp;(0&lt;c.p.length&amp;&amp;a(c.p),c.p=null)};window.google.jsaac=function(a){return Y(a)};window.google.jsarc=function(a){var c=T;ta(a);for(var b=!1,d=0;d&lt;c.i.length;++d)if(c.i[d]===a){c.i.splice(d,1);b=!0;break}if(!b)for(d=0;d&lt;c.k.length;++d)if(c.k[d]===a){c.k.splice(d,1);break}X(c)};}).call(window);(function(){''use strict'';var f=this,g=function(d,e){var b=d.split("."),a=f;b[0]in a||!a.execScript||a.execScript("var "+b[0]);for(var c;b.length&amp;&amp;(c=b.shift());)b.length||void 0===e?a[c]?a=a[c]:a=a[c]={}:a[c]=e};var h=[];g("google.jsc.xx",h);g("google.jsc.x",function(d){h.push(d)});}).call(window);google.arwt=function(a){a.href=document.getElementById(a.id.substring(1)).href;return!0};</script><style>[dir=''ltr''],[dir=''rtl'']{unicode-bidi:-moz-isolate;unicode-bidi:isolate}bdo[dir=''ltr''],bdo[dir=''rtl'']{unicode-bidi:bidi-override;unicode-bidi:-moz-isolate-override;unicode-bidi:isolate-override}#logo{display:block;height:37px;margin:0;overflow:hidden;position:relative;width:95px}#logo img{border:0;left:0;position:absolute;top:-41px}#logo span{background:url(/images/nav_logo195.png) no-repeat;cursor:pointer;overflow:hidden}#logocont{z-index:1;padding-left:13px;padding-right:10px;margin-top:-2px}.big #logocont{padding-left:13px;padding-right:12px}.sbibod{background-color:#fff;border:1px solid #d9d9d9;border-top-color:#c0c0c0;height:28px;vertical-align:top;}.lst{border:0;margin-top:4px;margin-bottom:0}.lst:focus{outline:none}#lst-ib{color:#000}.gsfi,.lst{line-height:1.2em !important;height:1.2em !important;font:16px arial,sans-serif;}.gsfs{font:16px arial,sans-serif}.lsb{background:transparent;border:0;font-size:0;height:30px;outline:0;width:100%}.sbico{background:url(/images/nav_logo195.png) no-repeat -113px -61px;color:transparent;display:inline-block;height:18px;margin:0 auto 2px;width:18px}#sblsbb{border-bottom-left-radius:0;border-top-left-radius:0;text-align:center;height:28px;margin:0;padding:0;width:58px}#sbds{border:0;margin-left:0}.hp .nojsb,.srp .jsb{display:none}.kpbb,.kprb,.kpgb,.kpgrb{-moz-border-radius:2px;border-radius:2px;color:#fff}.kpbb:hover,.kprb:hover,.kpgb:hover,.kpgrb:hover{-moz-box-shadow:0 1px 1px rgba(0,0,0,0.1);box-shadow:0 1px 1px rgba(0,0,0,0.1);color:#fff}.kpbb:active,.kprb:active,.kpgb:active,.kpgrb:active{-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);box-shadow:inset 0 1px 2px rgba(0,0,0,0.3)}.kpbb{background-color:#4d90fe;background-image:-moz-linear-gradient(top,#4d90fe,#4787ed);background-image:linear-gradient(top,#4d90fe,#4787ed);border:1px solid #3079ed}.kpbb:hover{background-color:#357ae8;background-image:-moz-linear-gradient(top,#4d90fe,#357ae8);background-image:linear-gradient(top,#4d90fe,#357ae8);border:1px solid #2f5bb7}a.kpbb:link,a.kpbb:visited{color:#fff}.kprb{background-color:#dd4b39;background-image:-moz-linear-gradient(top,#dd4b39,#d14836);background-image:linear-gradient(top,#dd4b39,#d14836);border:1px solid #dd4b39}.kprb:hover{background-color:#c53727;background-image:-moz-linear-gradient(top,#dd4b39,#c53727);background-image:linear-gradient(top,#dd4b39,#c53727);border:1px solid #b0281a;border-bottom-color:#af301f}.kprb:active{background-color:#b0281a;background-image:-moz-linear-gradient(top,#dd4b39,#b0281a);background-image:linear-gradient(top,#dd4b39,#b0281a)}.kpgb{background-color:#3d9400;background-image:-moz-linear-gradient(top,#3d9400,#398a00);background-image:linear-gradient(top,#3d9400,#398a00);border:1px solid #29691d}.kpgb:hover{background-color:#368200;background-image:-moz-linear-gradient(top,#3d9400,#368200);background-image:linear-gradient(top,#3d9400,#368200);border:1px solid #2d6200}.kpgrb{background-color:#f5f5f5;background-image:-moz-linear-gradient(top,#f5f5f5,#f1f1f1);background-image:linear-gradient(top,#f5f5f5,#f1f1f1);border:1px solid #dcdcdc;color:#555}.kpgrb:hover{background-color:#f8f8f8;background-image:-moz-linear-gradient(top,#f8f8f8,#f1f1f1);background-image:linear-gradient(top,#f8f8f8,#f1f1f1);border:1px solid #dcdcdc;color:#333}a.kpgrb:link,a.kpgrb:visited{color:#555}#sfopt{display:inline-block;float:right;line-height:normal}.lsd{font-size:11px;position:absolute;top:3px;left:16px}.sbsb_g{margin:3px 0 4px}.jhp input[type="submit"],.sbdd_a input,.gbqfba{background-image:-moz-linear-gradient(top,#f5f5f5,#f1f1f1);-moz-border-radius:2px;-moz-user-select:none;background-color:#f5f5f5;background-image:linear-gradient(top,#f5f5f5,#f1f1f1);background-image:-o-linear-gradient(top,#f5f5f5,#f1f1f1);border:1px solid #dcdcdc;border:1px solid rgba(0,0,0,0.1);border-radius:2px;color:#444;cursor:default;font-family:arial,sans-serif;font-size:11px;font-weight:bold;margin:11px 8px;min-width:54px;padding:0 8px;text-align:center}.jhp input[type="submit"],.gbqfba{height:29px;line-height:27px}.sbdd_a input{height:100%}.jhp input[type="submit"]:hover,.sbdd_a input:hover,.gbqfba:hover{background-image:-moz-linear-gradient(top,#f8f8f8,#f1f1f1);-moz-box-shadow:0 1px 1px rgba(0,0,0,0.1);background-color:#f8f8f8;background-image:linear-gradient(top,#f8f8f8,#f1f1f1);background-image:-o-linear-gradient(top,#f8f8f8,#f1f1f1);border:1px solid #c6c6c6;box-shadow:0 1px 1px rgba(0,0,0,0.1);color:#222}.jhp input[type="submit"]:focus,.sbdd_a input:focus{border:1px solid #4d90fe;outline:none}.sbdd_a input{margin:6px;height:27px}span.lsbb,.lsb input{-moz-transition:all 0.18s}@media only screen and (max-height:650px){span.lsbb{height:17px}}.tsf{background:none}.tsf-p{position:relative;}.logocont{left:0;position:absolute;}.sfibbbc{padding-bottom:2px;padding-top:3px}.sbtc{position:relative}.sbibtd{line-height:0;max-width:650px;overflow:visible;white-space:nowrap}.sbibps{width:472px;padding:0px 6px 0;}.sfopt{height:28px;position:relative}#sform{height:34px}.hp .sfsbc{display:none}#searchform{width:100%}.hp #searchform{position:absolute;top:310px}.srp #searchform{position:absolute;top:15px}#sfdiv{max-width:484px}.hp .big #sfdiv{max-width:568px}.srp #sfdiv{max-width:600px;overflow:hidden}.srp #tsf{position:relative;top:-2px}.sfsbc{display:inline-block;float:right;margin-right:1px;vertical-align:top}.sfbg{background:#f1f1f1;height:69px;left:0;position:absolute;width:100%}.sfbgg{background-color:#f1f1f1;border-bottom:1px solid #666;border-color:#e5e5e5;height:69px}#pocs{background:#fff1a8;color:#000;font-size:10pt;margin:0;padding:5px 7px}#pocs.sft{background:transparent;color:#777}#pocs a{color:#11c}#pocs.sft a{color:#36c}#pocs&gt;div{margin:0;padding:0}#cnt{padding-top:15px;}#subform_ctrl{min-height:11px}.gb_j .gbqfi::before{left:-56px;top:-35px}.gb_L .gbqfb:focus .gbqfi{outline:1px dotted #fff}@-moz-keyframes gb__a{0%{opacity:0}50%{opacity:1}}@keyframes gb__a{0%{opacity:0}50%{opacity:1}}#gb#gb a.gb_k,#gb#gb a.gb_l{color:#404040;text-decoration:none}#gb#gb a.gb_l:hover,#gb#gb a.gb_l:focus{color:#000;text-decoration:underline}.gb_m.gb_n{display:none;padding-left:15px;vertical-align:middle}.gb_m.gb_n:first-child{padding-left:0}.gb_o.gb_n{display:inline-block}.gb_p .gb_o.gb_n{flex:0 1 auto;flex:0 1 main-size;display:-webkit-flex;display:flex}.gb_q .gb_o.gb_n{display:none}.gb_m .gb_l{display:inline-block;line-height:24px;outline:none;vertical-align:middle}.gb_o .gb_l{min-width:60px;overflow:hidden;flex:0 1 auto;flex:0 1 main-size;text-overflow:ellipsis}.gb_r .gb_o .gb_l{min-width:0}.gb_s .gb_o .gb_l{width:0!important}.gb_t .gb_l{font-weight:bold;text-shadow:0 1px 1px rgba(255,255,255,.9)}.gb_u .gb_l{font-weight:bold;text-shadow:0 1px 1px rgba(0,0,0,.6)}#gb#gb.gb_u a.gb_l{color:#fff}.gb_J .gb_K{background-position:-326px -52px;opacity:.55}.gb_t .gb_J .gb_K{background-position:-97px -57px;opacity:.7}.gb_u .gb_J .gb_K{background-position:-214px 0;opacity:1}.gb_Vc{left:0;min-width:1152px;position:absolute;top:0;-moz-user-select:-moz-none;width:100%}.gb_3b{font:13px/27px Arial,sans-serif;position:relative;height:60px;width:100%}.gb_ha .gb_3b{height:28px}#gba{height:60px}#gba.gb_ha{height:28px}#gba.gb_Wc{height:90px}#gba.gb_Wc.gb_ha{height:58px}.gb_3b&gt;.gb_n{height:60px;line-height:58px;vertical-align:middle}.gb_ha .gb_3b&gt;.gb_n{height:28px;line-height:26px}.gb_3b::before{background:#e5e5e5;bottom:0;content:'''';display:none;height:1px;left:0;position:absolute;right:0}.gb_3b{background:#f1f1f1}.gb_Xc .gb_3b{background:#fff}.gb_Xc .gb_3b::before,.gb_ha .gb_3b::before{display:none}.gb_t .gb_3b,.gb_u .gb_3b,.gb_ha .gb_3b{background:transparent}.gb_t .gb_3b::before{background:#e1e1e1;background:rgba(0,0,0,.12)}.gb_u .gb_3b::before{background:#333;background:rgba(255,255,255,.2)}.gb_n{display:inline-block;flex:0 0 auto;flex:0 0 main-size}.gb_n.gb_Zc{float:right;order:1}.gb_0c{white-space:nowrap}.gb_p .gb_0c{display:-webkit-flex;display:flex}.gb_0c,.gb_n{margin-left:0!important;margin-right:0!important}.gb_0a{background-image:url(''//ssl.gstatic.com/gb/images/i1_71651352.png'');background-size:356px 144px}@media (min-resolution:1.25dppx),(-webkit-min-device-pixel-ratio:1.25),(min-device-pixel-ratio:1.25){.gb_0a{background-image:url(''//ssl.gstatic.com/gb/images/i2_9ef0f6fa.png'')}}.gb_qb{display:inline-block;padding:0 0 0 15px;vertical-align:middle}.gb_qb:first-child,#gbsfw:first-child+.gb_qb{padding-left:0}.gb_5a{position:relative}.gb_K{display:inline-block;outline:none;vertical-align:middle;-moz-border-radius:2px;border-radius:2px;-moz-box-sizing:border-box;box-sizing:border-box;height:30px;width:30px}#gb#gb a.gb_K{color:#404040;cursor:default;text-decoration:none}#gb#gb a.gb_K:hover,#gb#gb a.gb_K:focus{color:#000}.gb_pa{border-color:transparent;border-bottom-color:#fff;border-style:dashed dashed solid;border-width:0 8.5px 8.5px;display:none;position:absolute;left:6.5px;top:37px;z-index:1;height:0;width:0;-moz-animation:gb__a .2s;animation:gb__a .2s}.gb_qa{border-color:transparent;border-style:dashed dashed solid;border-width:0 8.5px 8.5px;display:none;position:absolute;left:6.5px;z-index:1;height:0;width:0;-moz-animation:gb__a .2s;animation:gb__a .2s;border-bottom-color:#ccc;border-bottom-color:rgba(0,0,0,.2);top:36px}x:-o-prefocus,div.gb_qa{border-bottom-color:#ccc}.gb_N{background:#fff;border:1px solid #ccc;border-color:rgba(0,0,0,.2);-moz-box-shadow:0 2px 10px rgba(0,0,0,.2);box-shadow:0 2px 10px rgba(0,0,0,.2);display:none;outline:none;overflow:hidden;position:absolute;right:0;top:44px;-moz-animation:gb__a .2s;animation:gb__a .2s;-moz-border-radius:2px;border-radius:2px;-moz-user-select:text}.gb_qb.gb_Ra .gb_pa,.gb_qb.gb_Ra .gb_qa,.gb_qb.gb_Ra .gb_N{display:block}.gb_nc{position:absolute;right:0;top:44px;z-index:-1}.gb_ha .gb_pa,.gb_ha .gb_qa,.gb_ha .gb_N{margin-top:-10px}.gb_da{background-size:32px 32px;-moz-border-radius:50%;border-radius:50%;display:block;margin:-1px;height:32px;width:32px}.gb_da:hover,.gb_da:focus{-moz-box-shadow:0 1px 0 rgba(0,0,0,.15);box-shadow:0 1px 0 rgba(0,0,0,.15)}.gb_da:active{-moz-box-shadow:inset 0 2px 0 rgba(0,0,0,.15);box-shadow:inset 0 2px 0 rgba(0,0,0,.15)}.gb_da:active::after{background:rgba(0,0,0,.1);-moz-border-radius:50%;border-radius:50%;content:'''';display:block;height:100%}.gb_ea:not(.gb_j) .gb_da::before,.gb_ea:not(.gb_j) .gb_fa::before{content:none}.gb_ga{cursor:pointer;line-height:30px;min-width:30px;overflow:hidden;vertical-align:middle;width:auto;text-overflow:ellipsis}.gb_ha .gb_ga,.gb_ha .gb_ia{line-height:26px}#gb#gb.gb_ha a.gb_ga,.gb_ha .gb_ia{color:#666;font-size:11px;height:auto}#gb#gb.gb_ha a.gb_ga:hover,#gb#gb.gb_ha a.gb_ga:focus{color:#000}.gb_ja{border-top:4px solid #404040;border-left:4px dashed transparent;border-right:4px dashed transparent;display:inline-block;margin-left:6px;vertical-align:middle}.gb_ha .gb_ja{border-top-color:#999}.gb_ka:hover .gb_ja{border-top-color:#000}.gb_t .gb_ga{font-weight:bold;text-shadow:0 1px 1px rgba(255,255,255,.9)}.gb_u .gb_ga{font-weight:bold;text-shadow:0 1px 1px rgba(0,0,0,.6)}#gb#gb.gb_u.gb_u a.gb_ga{color:#fff}.gb_u.gb_u .gb_ja{border-top-color:#fff}.gb_t .gb_da,.gb_u .gb_da{-moz-box-shadow:0 1px 2px rgba(0,0,0,.2);box-shadow:0 1px 2px rgba(0,0,0,.2)}.gb_t .gb_da:hover,.gb_u .gb_da:hover,.gb_t .gb_da:focus,.gb_u .gb_da:focus{-moz-box-shadow:0 1px 0 rgba(0,0,0,.15),0 1px 2px rgba(0,0,0,.2);box-shadow:0 1px 0 rgba(0,0,0,.15),0 1px 2px rgba(0,0,0,.2)}.gb_la .gb_ma,.gb_na .gb_ma{position:absolute;right:1px}.gb_ma.gb_n,.gb_oa.gb_n,.gb_ka.gb_n{flex:0 1 auto;flex:0 1 main-size}.gb_ea.gb_s .gb_ga{width:30px!important}.gb_4b{display:none!important}.gb_5{background:#f8f8f8;border:1px solid #c6c6c6;display:inline-block;line-height:28px;padding:0 12px;-moz-border-radius:2px;border-radius:2px}#gb a.gb_5.gb_5{color:#666;cursor:default;text-decoration:none}.gb_6{border:1px solid #4285f4;font-weight:bold;outline:none;background:#4285f4;background:-moz-linear-gradient(top,#4387fd,#4683ea);background:linear-gradient(top,#4387fd,#4683ea);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#4387fd,endColorstr=#4683ea,GradientType=0)}#gb a.gb_6.gb_6{color:#fff}.gb_6:hover{-moz-box-shadow:0 1px 0 rgba(0,0,0,.15);box-shadow:0 1px 0 rgba(0,0,0,.15)}.gb_6:active{-moz-box-shadow:inset 0 2px 0 rgba(0,0,0,.15);box-shadow:inset 0 2px 0 rgba(0,0,0,.15);background:#3c78dc;background:-moz-linear-gradient(top,#3c7ae4,#3f76d3);background:linear-gradient(top,#3c7ae4,#3f76d3);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#3c7ae4,endColorstr=#3f76d3,GradientType=0)}.gb_7{display:inline-block;line-height:normal;position:relative;z-index:987}#gbsfw{min-width:400px;overflow:visible}.gb_Qa,#gbsfw.gb_Ra{display:block;outline:none}#gbsfw.gb_V iframe{display:none}.gb_Sa{padding:118px 0;text-align:center}.gb_Ta{background:no-repeat center 0;color:#aaa;font-size:13px;line-height:20px;padding-top:76px;background-image:url(''//ssl.gstatic.com/gb/images/a/f5cdd88b65.png'')}.gb_Ta a{color:#4285f4;text-decoration:none}.gb_Ua{min-width:127px;overflow:hidden;position:relative;z-index:987}.gb_Va{position:absolute;padding:0 20px 0 15px}.gb_Wa .gb_Va{right:100%;margin-right:-127px}.gb_Xa{display:inline-block;outline:none;vertical-align:middle}.gb_Za .gb_Xa{position:relative;top:2px}.gb_Xa .gb_0a,.gb_1a{display:block}.gb_2a{border:none;display:block;visibility:hidden}.gb_Xa .gb_0a{background-position:0 -105px;height:33px;width:92px}.gb_1a{background-repeat:no-repeat}.gb_u .gb_Xa .gb_0a{background-position:-97px -92px;margin:-3px 0 0 -10px;height:52px;width:112px}.gb_t .gb_Xa .gb_0a{margin:-3px 0 0 -10px;height:52px;width:112px;background-position:-97px 0}@-moz-keyframes gb__nb{0%{-moz-transform:scale(0,0);transform:scale(0,0)}20%{-moz-transform:scale(1.4,1.4);transform:scale(1.4,1.4)}50%{-moz-transform:scale(.8,.8);transform:scale(.8,.8)}85%{-moz-transform:scale(1.1,1.1);transform:scale(1.1,1.1)}to{-moz-transform:scale(1.0,1.0);transform:scale(1.0,1.0)}}@keyframes gb__nb{0%{-moz-transform:scale(0,0);transform:scale(0,0)}20%{-moz-transform:scale(1.4,1.4);transform:scale(1.4,1.4)}50%{-moz-transform:scale(.8,.8);transform:scale(.8,.8)}85%{-moz-transform:scale(1.1,1.1);transform:scale(1.1,1.1)}to{-moz-transform:scale(1.0,1.0);transform:scale(1.0,1.0)}}.gb_4a .gb_5a{font-size:14px;font-weight:bold;top:0;right:0}.gb_4a .gb_K{display:inline-block;vertical-align:middle;-moz-box-sizing:border-box;box-sizing:border-box;height:30px;width:30px}.gb_6a{background-position:-56px 0;opacity:.55;height:100%;width:100%}.gb_K:hover .gb_6a,.gb_K:focus .gb_6a{opacity:.85}.gb_7a .gb_6a{background-position:-291px -103px}.gb_8a{background-color:#cb4437;-moz-border-radius:8px;border-radius:8px;font:bold 11px Arial;color:#fff;line-height:16px;min-width:14px;padding:0 1px;position:absolute;right:0;text-align:center;text-shadow:0 1px 0 rgba(0,0,0,0.1);top:0;visibility:hidden;z-index:990}.gb_9a .gb_8a,.gb_9a .gb_ab,.gb_9a .gb_ab.gb_bb{visibility:visible}.gb_ab{padding:0 2px;visibility:hidden}.gb_4a:not(.gb_cb) .gb_qa,.gb_4a:not(.gb_cb) .gb_pa{left:3px}.gb_4a .gb_pa{border-bottom-color:#e5e5e5}.gb_8a.gb_db{-moz-animation:gb__nb .6s 1s both ease-in-out;animation:gb__nb .6s 1s both ease-in-out;-moz-perspective-origin:top right;perspective-origin:top right;-moz-transform:scale(1,1);transform:scale(1,1);-moz-transform-origin:top right;transform-origin:top right}.gb_db .gb_ab{visibility:visible}.gb_eb{background-color:rgba(0,0,0,.55);color:#fff;font-size:12px;font-weight:bold;line-height:20px;margin:5px;padding:0 2px;text-align:center;-moz-box-sizing:border-box;box-sizing:border-box;-moz-border-radius:50%;border-radius:50%;height:20px;width:20px}.gb_eb.gb_fb{background-position:-214px -117px}.gb_eb.gb_gb{background-position:-256px -73px}.gb_K:hover .gb_eb,.gb_K:focus .gb_eb{background-color:rgba(0,0,0,.85)}#gbsfw.gb_hb{background:#e5e5e5;border-color:#ccc}.gb_t .gb_K .gb_6a{background-position:-167px -57px;opacity:.7}.gb_t .gb_7a .gb_6a{background-position:-132px -57px}.gb_t .gb_K:hover .gb_6a,.gb_t .gb_K:focus .gb_6a{opacity:.85}.gb_u .gb_K .gb_6a{background-position:-326px -87px;opacity:1}.gb_u .gb_7a .gb_6a{background-position:0 -70px}.gb_t .gb_8a,.gb_u .gb_8a{border:none;-moz-box-shadow:-1px 1px 1px rgba(0,0,0,.2);box-shadow:-1px 1px 1px rgba(0,0,0,.2)}.gb_t .gb_eb{background-color:rgba(0,0,0,.7);-moz-box-shadow:0 1px 2px rgba(255,255,255,.9);box-shadow:0 1px 2px rgba(255,255,255,.9)}.gb_u .gb_eb.gb_eb{background-color:#fff;color:#404040;-moz-box-shadow:0 1px 2px rgba(0,0,0,.2);box-shadow:0 1px 2px rgba(0,0,0,.2)}.gb_u .gb_eb.gb_fb{background-position:-326px -122px}.gb_u .gb_eb.gb_gb{background-position:-214px -92px}.gb_9a .gb_eb.gb_eb{background-color:#db4437;color:#fff}.gb_9a .gb_K:hover .gb_eb,.gb_9a .gb_K:focus .gb_eb{background-color:#a52714}.gb_9a .gb_eb.gb_gb{background-position:-256px -73px}.gb_Zb .gb_K{background-position:-326px -17px;opacity:.55;height:30px;width:30px}.gb_Zb .gb_K:hover,.gb_Zb .gb_K:focus{opacity:.85}.gb_Zb .gb_pa{border-bottom-color:#f5f5f5}#gbsfw.gb_0b{background:#f5f5f5;border-color:#ccc}.gb_u .gb_Zb .gb_K{background-position:0 -35px;opacity:1}.gb_t .gb_Zb .gb_K{background-position:-256px -103px;opacity:.7}.gb_t .gb_Zb .gb_K:hover,.gb_t .gb_Zb .gb_K:focus{opacity:.85}.gb_ea{min-width:315px;padding-left:30px;padding-right:30px;position:relative;text-align:right;z-index:986;align-items:center;justify-content:flex-end}.gb_ha .gb_ea{min-width:0}.gb_ea.gb_n{flex:1 1 auto;flex:1 1 main-size}.gb_Kc{line-height:normal;position:relative;text-align:left}.gb_Kc.gb_n,.gb_Lc.gb_n,.gb_ia.gb_n{flex:0 1 auto;flex:0 1 main-size}.gb_Mc,.gb_Nc{display:inline-block;padding:0 0 0 15px;position:relative;vertical-align:middle}.gb_Lc{line-height:normal;padding-right:15px}.gb_ea .gb_Lc.gb_q{padding-right:0}.gb_ia{color:#404040;line-height:30px;min-width:30px;overflow:hidden;vertical-align:middle;text-overflow:ellipsis}#gb.gb_ha.gb_ha .gb_gc,#gb.gb_ha.gb_ha .gb_Kc&gt;.gb_Nc .gb_hc{background:none;border:none;color:#36c;cursor:pointer;filter:none;font-size:11px;line-height:26px;padding:0;-moz-box-shadow:none;box-shadow:none}.gb_ha .gb_gc{text-transform:uppercase}.gb_ea.gb_r{padding-left:0;padding-right:29px}.gb_ea.gb_Oc{max-width:400px}.gb_Pc{background-clip:content-box;background-origin:content-box;opacity:.27;padding:22px;height:16px;width:16px}.gb_Pc.gb_n{display:none}.gb_Pc:hover,.gb_Pc:focus{opacity:.55}.gb_Qc{background-position:-35px 0}.gb_Rc{background-position:-291px -17px;padding-left:30px;padding-right:14px;position:absolute;right:0;top:0;z-index:990}.gb_la:not(.gb_na) .gb_Rc,.gb_r .gb_Qc{display:inline-block}.gb_la .gb_Qc{padding-left:30px;padding-right:0;width:0}.gb_la:not(.gb_na) .gb_Sc{display:none}.gb_ea.gb_n.gb_r,.gb_r:not(.gb_na) .gb_Kc{flex:0 0 auto;flex:0 0 main-size}.gb_Pc,.gb_r .gb_Lc,.gb_na .gb_Kc{overflow:hidden}.gb_la .gb_Lc{padding-right:0}.gb_r .gb_Kc{padding:1px 1px 1px 0}.gb_la .gb_Kc{width:75px}.gb_ea.gb_Tc,.gb_ea.gb_Tc .gb_Qc,.gb_ea.gb_Tc .gb_Qc::before,.gb_ea.gb_Tc .gb_Lc,.gb_ea.gb_Tc .gb_Kc{-moz-transition:width .5s ease-in-out,min-width .5s ease-in-out,max-width .5s ease-in-out,padding .5s ease-in-out,left .5s ease-in-out;transition:width .5s ease-in-out,min-width .5s ease-in-out,max-width .5s ease-in-out,padding .5s ease-in-out,left .5s ease-in-out}.gb_p .gb_ea{min-width:0}.gb_ea.gb_s,.gb_ea.gb_s .gb_Kc,.gb_ea.gb_Uc,.gb_ea.gb_Uc .gb_Kc{min-width:0!important}.gb_ea.gb_s,.gb_ea.gb_s .gb_n{flex:0 0 auto!important}.gb_ea.gb_s .gb_ia{width:30px!important}.gb_t .gb_ia{font-weight:bold;text-shadow:0 1px 1px rgba(255,255,255,.9)}.gb_u .gb_ia{color:#fff;font-weight:bold;text-shadow:0 1px 1px rgba(0,0,0,.6)}.gb_3b ::-webkit-scrollbar{height:15px;width:15px}.gb_3b ::-webkit-scrollbar-button{height:0;width:0}.gb_3b ::-webkit-scrollbar-thumb{background-clip:padding-box;background-color:rgba(0,0,0,.3);border:5px solid transparent;-moz-border-radius:10px;border-radius:10px;min-height:20px;min-width:20px;height:5px;width:5px}.gb_3b ::-webkit-scrollbar-thumb:hover,.gb_3b ::-webkit-scrollbar-thumb:active{background-color:rgba(0,0,0,.4)}#gb.gb_3c{min-width:980px}#gb.gb_3c .gb_Mb{min-width:0;position:static;width:0}.gb_3c .gb_3b{background:transparent;border-bottom-color:transparent}.gb_3c .gb_3b::before{display:none}.gb_3c.gb_3c .gb_m{display:inline-block}.gb_3c.gb_ea .gb_Lc.gb_q{padding-right:15px}.gb_p.gb_3c .gb_o.gb_n{display:-webkit-flex;display:flex}.gb_3c.gb_p #gbqf{display:block}.gb_3c #gbq{height:0;position:absolute}.gb_3c.gb_ea{z-index:987}.gb_Va.gb_4c{padding-left:30px}.gb_Wa .gb_4c{margin-right:-142px}sentinel{}.gbii{background-image:url(//ssl.gstatic.com/gb/images/silhouette_27.png)}.gbip{background-image:url()}.gbii::before{content:url(//ssl.gstatic.com/gb/images/silhouette_27.png);position:absolute}.gbip::before{content:url();position:absolute}@media (min-resolution:1.25dppx),(-o-min-device-pixel-ratio:5/4),(-webkit-min-device-pixel-ratio:1.25),(min-device-pixel-ratio:1.25){.gbii{background-image:url(//ssl.gstatic.com/gb/images/silhouette_27.png)}.gbii::before{content:url(//ssl.gstatic.com/gb/images/silhouette_27.png)}.gbip{background-image:url()}.gbip::before{content:url()}.gbii::before,.gbip::before{-webkit-transform:scale(.5);-moz-transform:scale(.5);-ms-transform:scale(.5);-o-transform:scale(.5);transform:scale(.5);-webkit-transform-origin:0 0;-moz-transform-origin:0 0;-ms-transform-origin:0 0;-o-transform-origin:0 0;transform-origin:0 0}}#gbq .gbgt-hvr,#gbq .gbgt:focus{background-color:transparent;background-image:none}.gbqfh#gbq1{display:none}.gbxx{display:none !important}#gbq{line-height:normal;position:relative;top:0px;white-space:nowrap}#gbq{left:0;width:100%}#gbq2{top:0px;z-index:986}#gbq4{display:inline-block;max-height:29px;overflow:hidden;position:relative}.gbqfh#gbq2{z-index:985}.gbqfh#gbq2{margin:0;margin-left:0 !important;padding-top:0;position:relative;top:310px}.gbqfh #gbqf{margin:auto;min-width:534px;padding:0 !important}.gbqfh #gbqfbw{display:none}.gbqfh #gbqfbwa{display:block}.gbqfh #gbqf{max-width:572px;min-width:572px}.gbqfh .gbqfqw{border-right-width:1px}.gsfe_a.gsfe_a{border-right-width:0;-moz-box-shadow:none;-webkit-box-shadow:none;box-shadow:none}.gsfe_b.gsfe_b{border-right-width:0;border-color:#4285f4;-moz-box-shadow:none;-webkit-box-shadow:none;box-shadow:none}.gbqfh .gsfe_a,.gbqfh .gsfe_b{border-width:1px}.gbm{background:#fff;border:1px solid #bebebe;box-shadow:0 2px 4px rgba(0,0,0,.2);-moz-box-shadow:-1px 1px 1px rgba(0,0,0,.2);-webkit-box-shadow:0 2px 4px rgba(0,0,0,.2);position:absolute;top:-999px;visibility:hidden;z-index:999}</style><style id="gstyle" data-jiis="cc">body{color:#000;margin:0;overflow-y:scroll}body{background:#fff}a.gb1,a.gb2,a.gb3,.link{color:#1a0dab !important}.ts{border-collapse:collapse}.ts td{padding:0}li{line-height:1.2}.ti,.bl{display:inline}.ti{display:inline-table}#rhs_block{padding-bottom:15px}a:link,.w,#prs a:visited,#prs a:active,.q:active,.q:visited,.kl:active,.tbotu{color:#1a0dab}.mblink:visited,a:visited{color:#609}.cur,.b{font-weight:bold}.j{width:42em;font-size:82%}.s{max-width:42em}.sl{font-size:82%}.hd{position:absolute;width:1px;height:1px;top:-1000em;overflow:hidden}.f,.f a:link,.m{color:#666}.c h2{color:#666}.mslg cite{display:none}.ng{color:#dd4b39}h1,ol,ul,li{margin:0;padding:0}.g,body,html,input,.std,h1{font-size:small;font-family:arial,sans-serif}.c h2,h1{font-weight:normal}.blk a{color:#000}#nav a{display:block}#nav .i{color:#a90a08;font-weight:bold}.csb,.ss,.micon,.close_btn,.mbi{background:url(/images/nav_logo195.png) no-repeat;overflow:hidden}.csb,.ss{background-position:0 0;height:40px;display:block}.mbi{background-position:-153px -70px;display:inline-block;float:left;height:13px;margin-right:3px;margin-top:4px;width:13px}.mbt{color:#11c;float:left;font-size:13px;margin-right:5px;position:relative}#nav td{padding:0;text-align:center}.ch{cursor:pointer}h3,.med{font-size:medium;font-weight:normal;margin:0;padding:0}#res h3{font-size:18px}.e{margin:2px 0 .75em}.slk div{padding-left:12px;text-indent:-10px}.blk{border-top:1px solid #6b90da;background:#f0f7f9}#cnt{clear:both}#res{padding-right:1em;margin:0 16px}.xsm{font-size:x-small}ol li{list-style:none}.sm li{margin:0}.gl,#foot a,.nobr{white-space:nowrap}.sl,.r{display:inline;font-weight:normal;margin:0}.r{font-size:medium}h4.r{font-size:small}.vshid{display:none}.gic{position:relative;overflow:hidden;z-index:0}.nwd{font-size:10px;padding:0 16px 30px 16px;text-align:center}#rhs{display:block;margin-left:712px;padding-bottom:10px;min-width:268px}#nyc{bottom:0;display:none;left:0;margin-left:663px;min-width:317px;overflow:hidden;position:fixed;right:0;visibility:visible}.mdm #nyc{margin-left:683px}.mdm #rhs{margin-left:732px}.big #nyc{margin-left:743px}.big #rhs{margin-left:792px;}body .big #subform_ctrl{margin-left:229px}.rhslink{width:68px}.rhsdw .rhslink{width:156px}.rhsimg{width:70px}.rhsimg.rhsdw{width:158px}.rhsimg.rhsn1st{margin-left:16px}#nyc .rhsvw,#rhs .scrt.rhsvw,#rhs table.rhsvw{border:0}#nyc .rhsvw{padding-left:0;padding-right:0}#rhs .rhsvw{border:1px solid #ebebeb;padding-left:15px;padding-right:15px;position:relative;width:424px}#nyc .rhsvw{width:424px}#center_col .rhsl4,#center_col .rhsl5,#center_col .rhsn5{display:none}#rhs .rhstc4 .rhsvw,#nyc.rhstc4 .rhsvw{width:336px}#rhs .rhstc3 .rhsvw,#nyc.rhstc3 .rhsvw{width:248px}.rhstc4 .rhsg4,.rhstc3 .rhsg4,.rhstc3 .rhsg3{background:none !important;display:none !important}.rhstc5 .rhsl5,.rhstc5 .rhsl4,.rhstc4 .rhsl4{background:none !important;display:none !important}.rhstc4 .rhsn4{background:none !important;display:none !important}.nrgt{margin-left:22px}.mslg .vsc{border:1px solid transparent;border-radius:2px;-moz-border-radius:2px;-moz-transition:opacity .2s ease;margin-top:2px;padding:3px 0 3px 5px;transition:opacity .2s ease;width:250px}.mslg&gt;td{padding-right:6px;padding-top:4px}button.vspib{display:none}div.vspib{background:transparent;bottom:0;cursor:default;height:auto;margin:0;min-height:40px;padding-left:9px;padding-right:4px;position:absolute;right:-37px;top:-2px;width:28px;z-index:3}.nyc_open div.vspib{z-index:103}div.vspib:focus{outline:none}.vspii .vspiic{background:url(/images/nav_logo195.png);background-position:-3px -260px;width:15px;height:13px;margin-left:6px;margin-top:-7px;opacity:.3;position:absolute;top:50%;visibility:hidden}.vsh .vsc:hover .vspii .vspiic{visibility:visible}.vsh .vspib .vspii:hover .vspiic{opacity:1;visibility:visible;-moz-transition:opacity .25s ease}.vsh .vsdth .vspiic{opacity:1;visibility:visible;-moz-transition:opacity 1.5s ease}.nyc_open.vsh .vsdth .vspiic,.nyc_open.vsh .vspib .vspii:hover .vspiic{-moz-transition:0}.vspib:focus .vspiic{opacity:1;visibility:visible}.vsh .vspib:focus .vspiic{opacity:.3;visibility:hidden}.vso .vspiic,.vso .vspib:focus .vspiic{opacity:1;visibility:visible}.vspii{border:1px solid transparent;border-radius:2px;border-right:none;cursor:default;user-select:none;-moz-user-select:none}.vsh.nyc_opening .vsc:hover .vspii,.vsh.nyc_open .vsc:hover .vspii,.vso .vspii{background-color:#fafafa;border-color:#e6e6e6;height:100%}.vsh.nyc_open .mslg .vsc:hover,.vsh.nyc_opening .mslg .vsc:hover{border-right-color:#ebebeb}.vso .vspib{padding-right:0}.nyc_open #nycx{background:url(/images/nav_logo195.png) no-repeat;background-position:-140px -230px;height:11px;width:11px}.vsc{display:inline-block;position:relative;width:100%}#nyc cite button.esw{display:none}button.esw{vertical-align:text-bottom;}#res h3.r{display:block;overflow:hidden;text-overflow:ellipsis;-moz-text-overflow:ellipsis;white-space:nowrap}#res h3.inl{display:inline;white-space:normal}em{font-weight:bold;font-style:normal}ol,ul,li{border:0;margin:0;padding:0}.g{margin-top:0;margin-bottom:23px}.ibk{display:-moz-inline-box;display:inline-block;vertical-align:top}.tsw{width:595px}#cnt{min-width:833px;margin-left:0}.mw{max-width:1197px}.big .mw{max-width:1250px}#cnt #center_col,#cnt #foot{width:528px}.gbh{top:24px}#gbar{margin-left:8px;height:20px}#guser{margin-right:8px;padding-bottom:5px !important}.mbi{margin-bottom:-1px}.uc{padding-left:8px;position:relative;margin-left:128px;}.ucm{padding-bottom:5px;padding-top:5px;margin-bottom:8px}.col{float:left}#leftnavc,#center_col,#rhs{position:relative}#center_col{margin-left:138px;margin-right:254px;padding:0 8px;padding:0 8px 0 8px}.mdm #center_col{margin-left:138px;padding:0 8px}.big #center_col{margin-left:138px;padding:0 8px}#subform_ctrl{font-size:11px;margin-right:480px;position:relative;z-index:99}#subform_ctrl a.gl{color:#1a0dab}#center_col{clear:both}#res{border:0;margin:0;padding:0 8px;}#ires{padding-top:6px}.micon,.close_btn{border:0}#tbbc{background:#ebeff9;margin-bottom:4px}#tbbc dfn{padding:4px}#tbbc.bigger .std{font-size:154%;font-weight:bold;text-decoration:none}#tbbc .tbbclm{text-decoration:none}.close_btn{background-position:-138px -84px;float:right;height:14px;width:14px}.mitem{border-bottom:1px solid transparent;line-height:29px;opacity:1.0;}.mitem .kl{padding-left:16px}.mitem .kl:hover,.msel .kls:hover{color:#222;display:block}.mitem&gt;.kl{color:#222;display:block}.msel{color:#dd4b39;cursor:pointer}.msel .kls{border-left:5px solid #dd4b39;padding-left:11px}.mitem&gt;.kl,.msel{font-size:13px}#tbd{display:block;min-height:1px}.tbt{font-size:13px;line-height:1.2}.tbnow{white-space:nowrap}.tbos,.tbots{font-weight:bold}.tbst{margin-top:8px}#iszlt_sel.tbcontrol_vis{margin-left:0}.tbpc,.tbpo{font-size:13px}.tbpc,.tbo .tbpo{display:inline}.tbo .tbpc,.tbpo,#set_location_section{display:none}.lco #set_location_section{display:block}#cdr_opt{padding-left:8px;text-indent:0}.tbou #cdr_frm{display:none}#cdr_frm,#cdr_min,#cdr_max{color:rgb(102,102,102)}#cdr_min,#cdr_max{font-family:arial,sans-serif;width:100%}#cdr_opt label{display:block;font-weight:normal;margin-right:2px;white-space:nowrap}a:link,.w,.q:active,.q:visited{cursor:pointer}.osl a,.gl a,#tsf a,a.mblink,a.gl,a.fl,.slk a,.bc a,.flt,a.flt u,.blg a,#appbar a{text-decoration:none}.osl a:hover,.gl a:hover,#tsf a:hover,a.mblink:hover,a.gl:hover,a.fl:hover,.slk a:hover,.bc a:hover,.flt:hover,a.flt:hover u,.tbotu:hover,.blg a:hover{text-decoration:underline}#tads a,#tadsb a,#res a,#rhs a,#taw a{text-decoration:none}#brs a,.nsa,.tbt a,.tbotu:hover,#tbpi,#nycntg a:hover,.fl,.navend span,#botstuff a,.flt:hover u,.mlocsel span,#rhs .gl a,#nav a.pn{text-decoration:none}#ss-box a:hover{text-decoration:none}.hpn,.osl{color:#777}#gbi,#gbg{border-color:#a2bff0 #558be3 #558be3 #a2bff0}#gbi a.gb2:hover,#gbg a.gb2:hover,.mi:hover{background-color:#558be3}#guser a.gb2:hover,.mi:hover,.mi:hover *{color:#fff !important}#guser{color:#000}#imagebox_bigimages .th{border:0}.vsc:hover .lupin,.intrlu:hover .lupin,.lupin.luhovm,#ires:hover .vsc:hover .lupin.luhovm{background-image:url(/images/mappins_red.png) !important}#ires:hover .lupin.luhovm{background-image:url(/images/mappins_grey.png) !important}.vsc:hover .lucir,.intrlu:hover .lucir,.lucir.luhovm,#ires:hover .vsc:hover .lucir.luhovm{background-image:url(/images/mapcircles_red.png) !important}#ires:hover .lucir.luhovm{background-image:url(/images/mapcircles_grey.png) !important}#foot .ftl{margin-right:12px}#foot{visibility:hidden}#fll a,#bfl a{color:#1a0dab;margin:0 12px;text-decoration:none}.stp{margin:7px 0 17px}body{color:#222}.s{color:#545454}.st em{color:#545454}.s a:visited em{color:#609}.s a:active em{color:#dd4b39}.sfcc{width:833px;}.big .sfcc{max-width:1129px}.big #tsf{}#topstuff .obp{padding-top:6px}.slk{margin-top:6px !important}.st{line-height:1.4;word-wrap:break-word}.kt{border-spacing:2px 0;margin-top:1px}.esw{vertical-align:text-bottom;}.cpbb,.kpbb,.kprb,.kpgb,.kpgrb,.ksb{-moz-border-radius:2px;border-radius:2px;cursor:default;font-family:arial,sans-serif;font-size:11px;font-weight:bold;height:27px;line-height:27px;margin:2px 0;min-width:54px;padding:0 8px;text-align:center;-moz-transition:all 0.218s;transition:all 0.218s,visibility 0s;-moz-user-select:none;}.ab_button{-moz-border-radius:2px;border-radius:2px;cursor:default;font-family:arial,sans-serif;font-size:11px;font-weight:bold;height:27px;line-height:27px;margin:2px 0;min-width:54px;padding:0 8px;text-align:center;-moz-transition:all 0.218s;transition:all 0.218s,visibility 0s;-moz-user-select:none;}.kbtn-small{min-width:26px;width:26px}.ab_button.left{-moz-border-radius:2px 0 0 2px;border-radius:2px 0 0 2px;border-right-color:transparent;margin-right:0}.ab_button.right{-moz-border-radius:0 2px 2px 0;border-radius:0 2px 2px 0;margin-left:-1px}.ksb{background-color:#f5f5f5;background-image:-moz-linear-gradient(top,#f5f5f5,#f1f1f1);background-image:linear-gradient(top,#f5f5f5,#f1f1f1);border:1px solid #dcdcdc;border:1px solid rgba(0,0,0,0.1);color:#444;}.ab_button{background-color:#f5f5f5;background-image:-moz-linear-gradient(top,#f5f5f5,#f1f1f1);background-image:linear-gradient(top,#f5f5f5,#f1f1f1);border:1px solid #dcdcdc;border:1px solid rgba(0,0,0,0.1);color:#444;}a.ksb,.div.ksb{color:#444;text-decoration:none;cursor:default}a.ab_button{color:#444;text-decoration:none;cursor:default}.cpbb:hover,.kpbb:hover,.kprb:hover,.kpgb:hover,.kpgrb:hover,.ksb:hover{-moz-box-shadow:0 1px 1px rgba(0,0,0,0.1);box-shadow:0 1px 1px rgba(0,0,0,0.1);-moz-transition:all 0.0s;transition:all 0.0s}.ab_button:hover{-moz-box-shadow:0 1px 1px rgba(0,0,0,0.1);box-shadow:0 1px 1px rgba(0,0,0,0.1);-moz-transition:all 0.0s;transition:all 0.0s}#hdtb_tls:hover{-moz-box-shadow:0 1px 1px rgba(0,0,0,0.1);box-shadow:0 1px 1px rgba(0,0,0,0.1);-moz-transition:all 0.0s;transition:all 0.0s}.ksb:hover{background-color:#f8f8f8;background-image:-moz-linear-gradient(top,#f8f8f8,#f1f1f1);background-image:linear-gradient(top,#f8f8f8,#f1f1f1);border:1px solid #c6c6c6;color:#222;}.ab_button:hover{background-color:#f8f8f8;background-image:-moz-linear-gradient(top,#f8f8f8,#f1f1f1);background-image:linear-gradient(top,#f8f8f8,#f1f1f1);border:1px solid #c6c6c6;color:#222;}#hdtb_tls:hover{background-color:#f8f8f8;background-image:-moz-linear-gradient(top,#f8f8f8,#f1f1f1);background-image:linear-gradient(top,#f8f8f8,#f1f1f1);border:1px solid #c6c6c6;color:#222;}.ksb:active{background-color:#f6f6f6;background-image:-moz-linear-gradient(top,#f6f6f6,#f1f1f1);background-image:linear-gradient(top,#f6f6f6,#f1f1f1);-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);}.ab_button:active{background-color:#f6f6f6;background-image:-moz-linear-gradient(top,#f6f6f6,#f1f1f1);background-image:linear-gradient(top,#f6f6f6,#f1f1f1);-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);}#hdtb_tls:active{background-color:#f6f6f6;background-image:-moz-linear-gradient(top,#f6f6f6,#f1f1f1);background-image:linear-gradient(top,#f6f6f6,#f1f1f1);-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);}.ksb.ksbs,.ksb.ksbs:hover{background-color:#eee;background-image:-moz-linear-gradient(top,#eee,#e0e0e0);background-image:linear-gradient(top,#eee,#e0e0e0);border:1px solid #ccc;-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);color:#222;margin:0}.ab_button.selected,.ab_button.selected:hover{background-color:#eee;background-image:-moz-linear-gradient(top,#eee,#e0e0e0);background-image:linear-gradient(top,#eee,#e0e0e0);border:1px solid #ccc;-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);color:#222;margin:0}.ksb.sbm{height:20px;line-height:18px;min-width:35px}.ksb.sbf{height:21px;line-height:21px;min-width:35px}.ksb.mini{-moz-box-sizing:content-box;box-sizing:content-box;height:17px;line-height:17px;min-width:0}.ksb.left{-webkit-border-radius:2px 0 0 2px}.ksb.mid{-webkit-border-radius:0;margin-left:-1px}.ksb.right{-webkit-border-radius:0 2px 2px 0;margin-left:-1px}.ktf{-moz-border-radius:1px;-moz-box-sizing:content-box;background-color:#fff;border:1px solid #d9d9d9;border-top:1px solid #c0c0c0;box-sizing:content-box;color:#333;display:inline-block;height:29px;line-height:27px;padding-left:8px;vertical-align:top}.ktf:hover{-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);border:1px solid #b9b9b9;border-top:1px solid #a0a0a0;box-shadow:inset 0 1px 2px rgba(0,0,0,0.1)}.ktf:focus{-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);border:1px solid #4d90fe;box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);outline:none}.ktf.mini{font-size:11px;height:17px;line-height:17px;padding:0 2px}.sbc,.sbm.sbc,.sbf.sbc{padding:0 2px;min-width:30px}#sbfrm_l{visibility:inherit !important}#rcnt{margin-top:3px;}#appbar,#rhscol{min-width:980px}#top_nav{min-width:980px}#appbar{background:white;-webkit-box-sizing:border-box;width:100%}.ab_wrp{height:57px;border-bottom:1px solid #ebebeb}#main{width:100%}#ab_name,#ab_shopping{color:#dd4b39;font:20px "Arial";margin-left:15px;position:absolute;top:17px}#ab_name a{color:#999}#ab_shopping a{color:#dd4b39}#ab_ctls{float:right;position:relative;right:28px;z-index:3}#sslock{background:url(images/srpr/safesearchlock_transparent.png) right top no-repeat;height:40px;position:absolute;right:0;top:0;width:260px;-moz-user-select:none;}.ab_ctl{display:inline-block;position:relative;margin-left:16px;margin-top:1px;vertical-align:middle}a.ab_button,a.ab_button:visited{display:inline-block;color:#444;margin:0}a.ab_button:hover{color:#222}#appbar a.ab_button:active,a.ab_button.selected,a.ab_button.selected:hover{color:#333}.ab_button:focus{border:1px solid #4d90fe;outline:none}.ab_button.selected:focus{border-color:#ccc}.ab_icon{background:url(/images/nav_logo195.png) no-repeat;display:inline-block;opacity:0.667;vertical-align:middle}.ab_button:hover&gt;span.ab_icon{opacity:0.9}#ab_opt_icon{background-position:-42px -259px;height:17px;margin-top:-2px;width:17px}.ab_dropdown{background:#fff;border:1px solid #dcdcdc;border:1px solid rgba(0,0,0,0.2);font-size:13px;padding:0 0 6px;position:absolute;right:0;top:28px;white-space:nowrap;z-index:3;-moz-transition:opacity 0.218s;transition:opacity 0.218s;-moz-box-shadow:0 2px 4px rgba(0,0,0,0.2);box-shadow:0 2px 4px rgba(0,0,0,0.2)}.ab_dropdown:focus,.ab_dropdownitem:focus,.ab_dropdownitem a:focus{outline:none}.ab_dropdownitem{margin:0;padding:0;-moz-user-select:none;}.ab_dropdownitem.selected{background-color:#eee}.ab_dropdownitem.checked{background-image:url(//ssl.gstatic.com/ui/v1/menu/checkmark.png);background-position:left center;background-repeat:no-repeat}.ab_dropdownitem.disabled{cursor:default;border:1px solid #f3f3f3;border:1px solid rgba(0,0,0,0.05);pointer-events:none}a.ab_dropdownitem.disabled{color:#b8b8b8}.ab_dropdownitem.active{-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);box-shadow:inset 0 1px 2px rgba(0,0,0,0.1)}.ab_arrow{background:url(//ssl.gstatic.com/ui/v1/zippy/arrow_down.png);background-position:right center;background-repeat:no-repeat;display:inline-block;height:4px;margin-left:3px;margin-top:-3px;vertical-align:middle;width:7px}.ab_dropdownlnk,.ab_dropdownlnkinfo{display:block;padding:8px 20px 8px 16px}a.ab_dropdownlnk,a.ab_dropdownlnk:visited,a.ab_dropdownlnk:hover,#appbar a.ab_dropdownlnk:active{color:#333}a.ab_dropdownlnkinfo,a.ab_dropdownlnkinfo:visited,a.ab_dropdownlnkinfo:hover,#appbar a.ab_dropdownlnkinfo:active{color:#15c}.ab_dropdownchecklist{padding-left:30px}.ab_dropdownrule{border-top:1px solid #ebebeb;margin-bottom:10px;margin-top:9px}#top_nav{-moz-user-select:none;}.ksb.mini{margin-top:0px;}.ab_tnav_wrp{height:35px}#hdtb_msb&gt;.hdtb_mitem:first-child,.ab_tnav_wrp,#cnt #center_col,.mw #center_col{margin-left:120px}.mw #rhs{margin-left:702px}.mw #nyc{margin-left:651px}.klnav.klleft{margin-left:14px !important}.tbt{margin-left:8px;margin-bottom:28px}#tbpi.pt.pi{margin-top:-20px}#tbpi.pi{margin-top:0}.tbo #tbpi.pt,.tbo #tbpi{margin-top:-20px}#tbpi.pt{margin-top:8px}#tbpi{margin-top:0}#tbrt{margin-top:-20px}.lnsep{border-bottom:1px solid #ebebeb;margin-bottom:14px;margin-left:10px;margin-right:4px;margin-top:14px}.tbos,.tbots,.tbotu{color:#dd4b39}.tbou&gt;a.q,#tbpi,#tbtro,.tbt label,#set_location_section a{color:#222}.th{border:1px solid #ebebeb}#resultStats{line-height:35px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}#resultStats{padding-left:16px;padding-top:0;padding-bottom:0;padding-right:8px}#subform_ctrl{margin-left:149px}.big #subform_ctrl{padding-right:2px;margin-left:229px}.mdm .mitem .kl{padding-left:28px}.big .mitem .kl{padding-left:44px}.mdm .msel .kls{padding-left:23px}.big .msel .kls{padding-left:39px}.obsmo .dp0,.dp1{display:none}.obsmo .dp1{display:inline}#obsmtc a,.rscontainer a{text-decoration:none}#obsmtc a:hover .ul,.rscontainer a:hover .ul{text-decoration:underline}.authorship_attr{white-space:nowrap}.currency input[type=text]{background-color:white;border:1px solid #d9d9d9;border-top:1px solid #c0c0c0;box-sizing:border-box;color:#333;display:inline-block;height:29px;line-height:27px;padding-left:8px;vertical-align:top;}.currency input[type=text]:hover{border:1px solid #b9b9b9;border-top:1px solid #a0a0a0;box-shadow:inset 0px 1px 2px rgba(0,0,0,0.1);-moz-box-shadow:inset 0px 1px 2px rgba(0,0,0,0.1);}.currency input[type=text]:focus{border:1px solid #4d90fe;box-shadow:inset 0px 1px 2px rgba(0,0,0,0.3);outline:none;-moz-box-shadow:inset 0px 1px 2px rgba(0,0,0,0.3);}body.vasq #hdtbSum{height:59px;line-height:54px}body.vasq #hdtb_msb .hdtb_mitem.hdtb_msel,body.vasq #hdtb_msb .hdtb_mitem.hdtb_msel_pre{height:54px}body.vasq .ab_tnav_wrp{height:43px}body.vasq #topabar.vasqHeight{margin-top:-44px !important}body.vasq #resultStats{line-height:43px}body.vasq .hdtb-mn-o,body.vasq .hdtb-mn-c{top:50px}.ellip{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}</style><style>#ss-box{background:#fff;border:1px solid;border-color:#c9d7f1 #36c #36c #a2bae7;left:0;margin-top:.1em;position:absolute;visibility:hidden;z-index:103}#ss-box a{display:block;padding:.2em .31em;text-decoration:none}#ss-box a:hover{background:#4d90fe;color:#fff !important}a.ss-selected{color:#222 !important;font-weight:bold}a.ss-unselected{color:#12c !important}.ss-selected .mark{display:inline}.ss-unselected .mark{visibility:hidden}#ss-barframe{background:#fff;left:0;position:absolute;visibility:hidden;z-index:100}.gl{white-space:nowrap}.big .tsf-p{padding-left:126px;padding-right:352px}.hp .tsf-p{padding-left:173px;padding-right:173px}.hp #tsf{margin:0 auto;width:833px}#tsf{width:833px}.big #tsf,.hp .big #tsf{width:1139px}.tsf-p{padding-left:126px;padding-right:46px}.hp .big .tsf-p{padding-left:284px;padding-right:284px}</style><script>var _gjwl=location;function _gjuc(){var a=_gjwl.href.indexOf("#");return 0&lt;=a&amp;&amp;(a=_gjwl.href.substring(a+1),/(^|&amp;)q=/.test(a)&amp;&amp;-1==a.indexOf("#")&amp;&amp;!/(^|&amp;)cad=h($|&amp;)/.test(a))?(_gjwl.replace("/search?"+a.replace(/(^|&amp;)fp=[^&amp;]*/g,"")+"&amp;cad=h"),1):0}function _gjh(){!_gjuc()&amp;&amp;google.x({id:"GJH"},function(){google.nav&amp;&amp;google.nav.gjh&amp;&amp;google.nav.gjh()})};(function(){window.google.dcl=!1;window.google.dclc=[];function b(){google.dcl=!0;google.dclc.forEach(function(a){a()});google.dclc={push:function(a){a()}};document.removeEventListener("DOMContentLoaded",b)}document.addEventListener("DOMContentLoaded",b);})();window.rwt=function(a,g,h,n,o,i,c,p,j,d){return true};\r\n(window[''gbar'']=window[''gbar'']||{})._CONFIG=[[[0,"www.gstatic.com","og.og2.en_US.sRuoagv5uoY.O","co.in","en","1",0,[3,2,".40.64.","","25657,3700267,3700362","1426472962","0"],"40400","2d8PVbsnlZC5BMSogaAI",0,0,"og.og2.-1jhde7hork6zn.L.F4.O","AItRSTNgi-7goTFqVQMx0CiFEom9PL77oQ","AItRSTPER3Q1XwZI0RFxqGSCpRG9B3lh9w","",2,0,200,"IND"],null,0,["m;/_/scs/abc-static/_/js/k=gapi.gapi.en.9Bct3OJ96gA.O/m=__features__/am=AAQ/rt=j/d=1/rs=AItRSTPvFtsJdNTnw7r6dlELT3cG-Jn5Ow","https://apis.google.com","","","","","",1,"es_plusone_gc_20150312.0_p0","en"],["1","gci_91f30755d6a6b787dcc2a4062e6e9824.js","googleapis.client:plusone:gapi.iframes","","en"],null,null,null,[0.009999999776482582,"co.in","1",[null,"","w",null,1,5184000,1,0],null,[["","","",0,0,-1]],[null,0,0],0,null,null,["5061492","google\\\\.(com|ru|ca|by|kz|com\\\\.mx)$",1]],null,[0,0,0,null,"","",""],[1,0.001000000047497451,1],[1,0.1000000014901161,2,1],[0,"",null,"",0,"There was an error loading your Marketplace apps.","You have no Marketplace apps.",0,[1,"https://www.google.co.in/webhp?tab=ww","Search","","0 -414px",null,0],0,0,1],[1],[0,1,["lg"],1,["lat"]],[["","","","","","","","","","","","","","","","","","","","def","","","",""],[""]],null,null,null,[30,127,1,0],["p5","of355d57savty","2iamtcugjzrjl3ih"],null,null,null,null,[1,1]]];(window[''gbar'']=window[''gbar'']||{})._DPG=[{''_fdm_'':[''_r''],''dbg'':[''sy10'',''sy4'',''sy5'',''sy8'',''sy9''],''def'':[''sy11'',''sy12'',''sy13'',''sy4'',''sy5'',''sy6'',''sy8'',''sy9''],''drt'':[''sy4'',''sy5'',''sy6'',''sy7''],''fg'':[''sy16''],''fot'':[''sy11'',''sy12'',''sy5'',''sy9''],''ig'':[''sy16''],''in'':[''_r''],''jb'':[''sy4'',''sy5'',''sy6'',''sy7''],''lat'':[''sy10'',''sy11'',''sy13'',''sy4'',''sy5'',''sy6'',''sy8'',''sy9''],''lg'':[''sy16''],''sg'':[''sy16''],''sy10'':[''sy4'',''sy5'',''sy8''],''sy11'':[''_r''],''sy12'':[''sy11'',''sy5'',''sy9''],''sy13'':[''sy11'',''sy4'',''sy5'',''sy6'',''sy8'',''sy9''],''sy16'':[''_r''],''sy4'':[''sy5''],''sy5'':[''_r''],''sy6'':[''sy4''],''sy7'':[''sy4'',''sy6''],''sy8'':[''sy4'',''sy5''],''sy9'':[''_r'']}];(window[''gbar'']=window[''gbar'']||{})._LDD=["in","fot"];this.gbar_=this.gbar_||{};(function(_){var window=this;\r\ntry{\r\nvar fa,ga;_.aa=_.aa||{};_.m=this;_.n=function(a){return void 0!==a};_.p=function(a,c){for(var d=a.split("."),e=c||_.m,f;f=d.shift();)if(null!=e[f])e=e[f];else return null;return e};_.ba=function(a){a.N=function(){return a.Je?a.Je:a.Je=new a}};\r\n_.ca=function(a){var c=typeof a;if("object"==c)if(a){if(a instanceof Array)return"array";if(a instanceof Object)return c;var d=Object.prototype.toString.call(a);if("[object Window]"==d)return"object";if("[object Array]"==d||"number"==typeof a.length&amp;&amp;"undefined"!=typeof a.splice&amp;&amp;"undefined"!=typeof a.propertyIsEnumerable&amp;&amp;!a.propertyIsEnumerable("splice"))return"array";if("[object Function]"==d||"undefined"!=typeof a.call&amp;&amp;"undefined"!=typeof a.propertyIsEnumerable&amp;&amp;!a.propertyIsEnumerable("call"))return"function"}else return"null";\r\nelse if("function"==c&amp;&amp;"undefined"==typeof a.call)return"object";return c};_.da=function(a){return"array"==_.ca(a)};_.t=function(a){return"string"==typeof a};_.ea="closure_uid_"+(1E9*Math.random()&gt;&gt;&gt;0);fa=function(a,c,d){return a.call.apply(a.bind,arguments)};\r\nga=function(a,c,d){if(!a)throw Error();if(2&lt;arguments.length){var e=Array.prototype.slice.call(arguments,2);return function(){var d=Array.prototype.slice.call(arguments);Array.prototype.unshift.apply(d,e);return a.apply(c,d)}}return function(){return a.apply(c,arguments)}};_.u=function(a,c,d){_.u=Function.prototype.bind&amp;&amp;-1!=Function.prototype.bind.toString().indexOf("native code")?fa:ga;return _.u.apply(null,arguments)};_.ha=Date.now||function(){return+new Date};\r\n_.v=function(a,c){var d=a.split("."),e=_.m;d[0]in e||!e.execScript||e.execScript("var "+d[0]);for(var f;d.length&amp;&amp;(f=d.shift());)!d.length&amp;&amp;_.n(c)?e[f]=c:e[f]?e=e[f]:e=e[f]={}};_.w=function(a,c){function d(){}d.prototype=c.prototype;a.G=c.prototype;a.prototype=new d;a.prototype.constructor=a;a.gi=function(a,d,g){for(var h=Array(arguments.length-2),l=2;l&lt;arguments.length;l++)h[l-2]=arguments[l];return c.prototype[d].apply(a,h)}};\r\n_.y=function(){this.ea=this.ea;this.Na=this.Na};_.y.prototype.ea=!1;_.y.prototype.Y=function(){this.ea||(this.ea=!0,this.L())};_.y.prototype.L=function(){if(this.Na)for(;this.Na.length;)this.Na.shift()()};_.ia=function(a){if(Error.captureStackTrace)Error.captureStackTrace(this,_.ia);else{var c=Error().stack;c&amp;&amp;(this.stack=c)}a&amp;&amp;(this.message=String(a))};_.w(_.ia,Error);_.ia.prototype.name="CustomError";_.ja=String.prototype.trim?function(a){return a.trim()}:function(a){return a.replace(/^[\\s\\xa0]+|[\\s\\xa0]+$/g,"")};_.ka=Array.prototype;_.la=_.ka.indexOf?function(a,c,d){return _.ka.indexOf.call(a,c,d)}:function(a,c,d){d=null==d?0:0&gt;d?Math.max(0,a.length+d):d;if(_.t(a))return _.t(c)&amp;&amp;1==c.length?a.indexOf(c,d):-1;for(;d&lt;a.length;d++)if(d in a&amp;&amp;a[d]===c)return d;return-1};_.ma=_.ka.forEach?function(a,c,d){_.ka.forEach.call(a,c,d)}:function(a,c,d){for(var e=a.length,f=_.t(a)?a.split(""):a,g=0;g&lt;e;g++)g in f&amp;&amp;c.call(d,f[g],g,a)};\r\n_.na=_.ka.filter?function(a,c,d){return _.ka.filter.call(a,c,d)}:function(a,c,d){for(var e=a.length,f=[],g=0,h=_.t(a)?a.split(""):a,l=0;l&lt;e;l++)if(l in h){var q=h[l];c.call(d,q,l,a)&amp;&amp;(f[g++]=q)}return f};_.oa=_.ka.map?function(a,c,d){return _.ka.map.call(a,c,d)}:function(a,c,d){for(var e=a.length,f=Array(e),g=_.t(a)?a.split(""):a,h=0;h&lt;e;h++)h in g&amp;&amp;(f[h]=c.call(d,g[h],h,a));return f};\r\n_.pa=_.ka.reduce?function(a,c,d,e){e&amp;&amp;(c=(0,_.u)(c,e));return _.ka.reduce.call(a,c,d)}:function(a,c,d,e){var f=d;(0,_.ma)(a,function(d,h){f=c.call(e,f,d,h,a)});return f};_.qa=_.ka.some?function(a,c,d){return _.ka.some.call(a,c,d)}:function(a,c,d){for(var e=a.length,f=_.t(a)?a.split(""):a,g=0;g&lt;e;g++)if(g in f&amp;&amp;c.call(d,f[g],g,a))return!0;return!1};_.ra=function(a,c){return 0&lt;=(0,_.la)(a,c)};\r\n_.sa=/\\uffff/.test("\\uffff")?/[\\\\\\"\\x00-\\x1f\\x7f-\\uffff]/g:/[\\\\\\"\\x00-\\x1f\\x7f-\\xff]/g;var ta;ta="constructor hasOwnProperty isPrototypeOf propertyIsEnumerable toLocaleString toString valueOf".split(" ");_.ua=function(a,c){for(var d,e,f=1;f&lt;arguments.length;f++){e=arguments[f];for(d in e)a[d]=e[d];for(var g=0;g&lt;ta.length;g++)d=ta[g],Object.prototype.hasOwnProperty.call(e,d)&amp;&amp;(a[d]=e[d])}};\r\n_.z=function(){};_.A=function(a,c,d,e){a.b=null;c||(c=d?[d]:[]);a.A=d?String(d):void 0;a.o=0===d?-1:0;a.d=c;a:{if(a.d.length&amp;&amp;(c=a.d.length-1,(d=a.d[c])&amp;&amp;"object"==typeof d&amp;&amp;!_.da(d))){a.w=c-a.o;a.k=d;break a}a.w=Number.MAX_VALUE}if(e)for(c=0;c&lt;e.length;c++)d=e[c],d&lt;a.w?(d+=a.o,a.d[d]=a.d[d]||_.va):a.k[d]=a.k[d]||_.va};_.va=[];_.B=function(a,c){if(c&lt;a.w){var d=c+a.o,e=a.d[d];return e===_.va?a.d[d]=[]:e}e=a.k[c];return e===_.va?a.k[c]=[]:e}; _.D=function(a,c,d){a.b||(a.b={});if(!a.b[d]){var e=_.B(a,d);e&amp;&amp;(a.b[d]=new c(e))}return a.b[d]};_.z.prototype.$a=function(){return this.d};_.z.prototype.toString=function(){return this.d.toString()};\r\n_.wa=function(a){_.A(this,a,0,null)};_.w(_.wa,_.z);var xa=function(a){_.A(this,a,0,null)};_.w(xa,_.z);var Ea;_.ya=function(){this.b={};this.d={}};_.ba(_.ya);_.Aa=function(a,c){a.N=function(){return _.za(_.ya.N(),c)};a.Mh=function(){return _.ya.N().b[c]||null}};_.E=function(a){return _.za(_.ya.N(),a)};_.Ca=function(a,c){var d=_.ya.N();if(a in d.b){if(d.b[a]!=c)throw new Ba(a);}else{d.b[a]=c;var e=d.d[a];if(e)for(var f=0,g=e.length;f&lt;g;f++)e[f].b(d.b,a);delete d.d[a]}};_.za=function(a,c){if(c in a.b)return a.b[c];throw new Da(c);};Ea=function(a){_.ia.call(this);this.aa=a};_.w(Ea,_.ia); var Ba=function(a){Ea.call(this,a)};_.w(Ba,Ea);var Da=function(a){Ea.call(this,a)};_.w(Da,Ea);\r\n_.Fa=function(a){_.A(this,a,0,null)};_.w(_.Fa,_.z);var Ga=function(a){_.A(this,a,0,null)};_.w(Ga,_.z);Ga.prototype.xc=function(){return _.D(this,_.Fa,14)};_.F=function(a,c){return null!=a?a:!!c};_.G=function(a){var c;void 0==c&amp;&amp;(c="");return null!=a?a:c};_.H=function(a,c){void 0==c&amp;&amp;(c=0);return null!=a?a:c};var Ha=new Ga(window.gbar&amp;&amp;window.gbar._CONFIG?window.gbar._CONFIG[0]:[[,,,,,,,[]],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[],[]]),Ia;Ia=_.B(Ha,3);_.Ja=_.F(Ia);_.I=function(){};_.v("gbar_._DumpException",function(a){if(_.Ja)throw a;_.I(a)});var Ka=function(){this.d=!1;this.b=[]};Ka.prototype.k=function(a){if(!this.d){this.d=!0;for(var c=0;c&lt;this.b.length;c++)try{this.b[c]()}catch(d){a(d)}this.b=null;try{_.E("api").Ta()}catch(e){}}};_.La=new Ka;var Ma=function(){_.y.call(this);this.ih=Ha};_.w(Ma,_.y);_.Aa(Ma,"cs");_.J=function(){return Ma.N().ih};_.Na=function(){return _.D(_.J(),xa,1)||new xa};_.Ca("cs",new Ma);var Oa=function(a,c,d){this.o=a;this.d=!1;this.b=c;this.k=d};Oa.prototype.Ta=function(a){if(this.d)throw Error("e`"+this.b);try{a.apply(this.o,this.k),this.d=!0}catch(c){}};var Pa=function(a){_.y.call(this);this.k=a;this.b=[];this.d={}};_.w(Pa,_.y);Pa.prototype.o=function(a){var c=(0,_.u)(function(){this.b.push(new Oa(this.k,a,Array.prototype.slice.call(arguments)))},this);return this.d[a]=c};\r\nPa.prototype.Ta=function(){for(var a=this.b.length,c=this.b,d=[],e=0;e&lt;a;++e){var f=c[e].b,g;a:{g=this.k;for(var h=f.split("."),l=h.length,q=0;q&lt;l;++q)if(g[h[q]])g=g[h[q]];else{g=null;break a}g=g instanceof Function?g:null}if(g&amp;&amp;g!=this.d[f])try{c[e].Ta(g)}catch(r){}else d.push(c[e])}this.b=d.concat(c.slice(a))};\r\nvar Ra;_.Qa="bbh bbr bbs has prm sngw so".split(" ");Ra=new Pa(_.m);_.Ca("api",Ra);\r\nfor(var Sa="addExtraLink addLink aomc asmc close cp.c cp.l cp.me cp.ml cp.rc cp.rel ela elc elh gpca gpcr lGC lPWF ldb mls noam paa pc pca pcm pw.clk pw.hvr qfaae qfaas qfaau qfae qfas qfau qfhi qm qs qsi rtl sa setContinueCb snaw sncw som sp spd spn spp sps tsl tst up.aeh up.aop up.dpc up.iic up.nap up.r up.sl up.spd up.tp upel upes upet".split(" ").concat(_.Qa),Ta=(0,_.u)(Ra.o,Ra),Ua=0;Ua&lt;Sa.length;Ua++){var Va="gbar."+Sa[Ua];null==_.p(Va,window)&amp;&amp;_.v(Va,Ta(Va))}_.v("gbar.up.gpd",function(){return""});\r\nvar Wa=_.Na(),Xa=_.D(Wa,_.wa,8)||new _.wa,Ya;Ya=_.B(Xa,2);var Za=_.H(Ya),$a;$a=_.B(Xa,4);var ab=_.G($a),bb=_.G(_.B(Xa,3)),cb;cb=_.B(Xa,5);var db=_.G(cb),eb;eb=null!=_.B(Xa,1)?_.B(Xa,1):1;var fb=_.H(eb,1);_.B(Xa,6);_.B(Xa,7);_.v("gbar.bv",{n:Za,r:ab,f:bb,e:db,m:fb});_.v("gbar.kn",function(){return!0});_.v("gbar.sb",function(){return!1});\r\n}catch(e){_._DumpException(e)}\r\ntry{\r\n_.v("gbar.elr",function(){return{es:{f:152,h:60,m:30},mo:"md",vh:window.innerHeight||0,vw:window.innerWidth||0}});\r\n}catch(e){_._DumpException(e)}\r\n})(this.gbar_);\r\n// Google Inc.\r\n</script><link rel="canonical" href="/?ei=zd8PVditOujA8gea8IGwBg"><style type="text/css">#qbi.gssi_a{background:url(data:image/gif;base64,R0lGODlhEgANAOMKAAAAABUVFRoaGisrKzk5OUxMTGRkZLS0tM/Pz9/f3////////////////////////yH5BAEKAA8ALAAAAAASAA0AAART8Ml5Arg3nMkluQIhXMRUYNiwSceAnYAwAkOCGISBJC4mSKMDwpJBHFC/h+xhQAEMSuSo9EFRnSCmEzrDComAgBGbsuF0PHJq9WipnYJB9/UmFyIAOw==) no-repeat center;cursor:pointer;display:inline-block;height:13px;padding:0;width:18px}.gsok_a{background:url(data:image/gif;base64,R0lGODlhEwALAKECAAAAABISEv///////yH5BAEKAAIALAAAAAATAAsAAAIdDI6pZ+suQJyy0ocV3bbm33EcCArmiUYk1qxAUAAAOw==) no-repeat center;display:inline-block;height:11px;line-height:0;width:19px}.gsok_a img{border:none;visibility:hidden}.gsst_a{display:inline-block}.gsst_a{cursor:pointer;padding:0 4px}.gsst_a:hover{text-decoration:none!important}.gsst_b{font-size:16px;padding:0 2px;position:relative;user-select:none;-moz-user-select:none;white-space:nowrap}.gsst_e{vertical-align:middle;opacity:0.6;}.gsst_a:hover .gsst_e,.gsst_a:focus .gsst_e{opacity:0.8;}.gsst_a:active .gsst_e{opacity:1;}.sbib_a{background:#fff;box-sizing:border-box;-moz-box-sizing:border-box;}.sbib_b{box-sizing:border-box;-moz-box-sizing:border-box;height:100%;overflow:hidden;padding:4px 6px 0}.sbib_c[dir=ltr]{float:right}.sbib_c[dir=rtl]{float:left}.sbib_d{box-sizing:border-box;-moz-box-sizing:border-box;height:100%;unicode-bidi:embed;white-space:nowrap}.sbib_d[dir=ltr]{float:left}.sbib_d[dir=rtl]{float:right}.sbib_a,.sbib_c{vertical-align:top}.sbdd_a{z-index:989}.sbdd_a[dir=ltr] .fl, .sbdd_a[dir=rtl] .fr{float:left}.sbdd_a[dir=ltr] .fr, .sbdd_a[dir=rtl] .fl{float:right}.sbdd_b{background:#fff;border:1px solid #ccc;border-top-color:#d9d9d9;box-shadow:0 2px 4px rgba(0,0,0,0.2);-moz-box-shadow:0 2px 4px rgba(0,0,0,0.2);cursor:default}.sbdd_c{border:0;display:block;position:absolute;top:0;z-index:988}.sbpqs_a{color:#52188c}.sbdd_a[dir=ltr] .sbpqs_a{padding-right:8px}.sbdd_a[dir=rtl] .sbpqs_a{padding-left:8px}.sbdd_a[dir=ltr] .sbpqs_b{padding-right:3px}.sbdd_a[dir=rtl] .sbpqs_b{padding-left:3px}.sbpqs_c{color:#666;line-height:22px}.sben_a{color:#333}.gspr_a{padding-right:1px}.sbsb_c[dir=ltr] .sbqs_a{float:right}.sbsb_c[dir=rtl] .sbqs_a{float:left}.sbqs_b{visibility:hidden}.sbsb_d .sbqs_b{visibility:visible}.sbsb_c[dir=ltr] .sbqs_b{padding-left:5px;}.sbsb_c[dir=rtl] .sbqs_b{padding-right:5px;}.sbqs_c{word-wrap:break-word}.sbsb_a{background:#fff}.sbsb_b{list-style-type:none;margin:0;padding:0}.sbsb_c{line-height:22px;overflow:hidden;padding:0 7px}.sbsb_d{background:#eee}.sbsb_e{height:1px;background-color:#e5e5e5}#sbsb_f{font-size:11px;color:#36c;text-decoration:none}#sbsb_f:hover{font-size:11px;color:#36c;text-decoration:underline}.sbsb_g{text-align:center;padding:8px 0 7px;position:relative}.sbsb_h{font-size:15px;height:28px;margin:0.2em}.sbsb_i{font-size:13px;color:#36c;text-decoration:none;line-height:100%}.sbsb_i:hover{text-decoration:underline}.sbsb_j{padding-top:1px 0 2px 0;font-size:11px}.sbdd_a[dir=ltr] .sbsb_j{padding-right:4px;text-align:right}.sbdd_a[dir=rtl] .sbsb_j{padding-left:4px;text-align:left}.gscp_a,.gscp_c,.gscp_d,.gscp_e,.gscp_f{display:inline-block;vertical-align:bottom}.gscp_f{border:none}.gscp_a{background:#d9e7fe;border:1px solid #9cb0d8;cursor:default;outline:none;text-decoration:none!important;user-select:none;-moz-user-select:none;}.gscp_a:hover{border-color:#869ec9}.gscp_a.gscp_b{background:#4787ec;border-color:#3967bf}.gscp_c{color:#444;font-size:13px;font-weight:bold}.gscp_d{color:#aeb8cb;cursor:pointer;font:21px arial,sans-serif;line-height:inherit;padding:0 7px}.gscp_a:hover .gscp_d{color:#575b66}.gscp_c:hover,.gscp_a .gscp_d:hover{color:#222}.gscp_a.gscp_b .gscp_c,.gscp_a.gscp_b .gscp_d{color:#fff}.gscp_e{height:100%;padding:0 4px}.gsc_b{background:url(data:image/gif;base64,R0lGODlhCgAEAMIEAP9BGP6pl//Wy/7//P///////////////yH5BAEKAAQALAAAAAAKAAQAAAMROCOhK0oA0MIUMmTAZhsWBCYAOw==) repeat-x scroll 0 100% transparent;display:inline-block;padding-bottom:1px}.sbhcn{border:1px solid #b9b9b9;border-top-color:#a0a0a0}.sbfcn{border:1px solid #4d90fe}.sbsb_c{padding:0 10px}.sbdd_a{z-index:1001}.sbib_b{padding:5px 9px 0}.srp.vasq .sbhcn,.srp.vasq .sbfcn{border-right-width:0}</style><script async="" type="text/javascript" charset="UTF-8" src="//www.gstatic.com/og/_/js/k=og.og2.en_US.sRuoagv5uoY.O/rt=j/m=sy4,sy6,sy8,sy13,def/rs=AItRSTNgi-7goTFqVQMx0CiFEom9PL77oQ"></script></head><body bgcolor="#fff" alink="#dd4b39" vlink="#61c" text="#222" link="#12c" id="gsr" onload="try{if(!google.j.b){document.f&amp;&amp;document.f.q.focus();document.gbqf&amp;&amp;document.gbqf.q.focus();}}catch(e){}if(document.images)new Image().src=''/images/nav_logo195.png''" class="vasq srp vsh" style=""><div id="viewport" class="ctr-p"><div id="doc-info" data-jiis="cc"></div><div id="cst" data-jiis="cc"><style>.fade #center_col,.fade #rhs,.fade #leftnav,.fade #brs,.fade #footcnt{filter:alpha(opacity=33.3);opacity:0.333}.fade-hidden #center_col,.fade-hidden #rhs,.fade-hidden #leftnav{visibility:hidden}.flyr-o,.flyr-w{position:absolute;background-color:#fff;z-index:3;display:block;}.flyr-o{filter:alpha(opacity=66.6);opacity:0.666}.flyr-w{filter:alpha(opacity=20.0);opacity:0.2}.flyr-h{filter:alpha(opacity=0);opacity:0}.flyr-c{display:none}.flt,.flt u,a.fl{text-decoration:none}.flt:hover,.flt:hover u,a.fl:hover{text-decoration:underline}#knavm{color:#4273db;display:inline;font:11px arial,sans-serif !important;left:-13px;position:absolute;top:2px;z-index:2}#pnprev #knavm{bottom:1px;top:auto}#pnnext #knavm{bottom:1px;left:40px;top:auto}a.noline{outline:0}.y.yp{display:none}.y.yf,.y.ys{display:block}.yi{}#ataw{margin-left:120px}._Rm{font-size:14px;}.kv,.slp{display:block;}.f,.f a:link{color:#808080}.a,cite,cite a:link,cite a:visited,.cite,.cite:link,#_bGc&gt;i,.bc a:link{color:#006621;font-style:normal}a.fl:link,.fl a,.flt,a.flt,.gl a:link,a.mblink,.mblink b{color:#1a0dab}#resultStats{color:#808080}.osl{margin-top:0px}#ires .kv{height:17px;line-height:16px}#rcnt a:hover,#brs a:hover,#nycp a:hover,#nav a.pn:hover{text-decoration:underline}#rcnt .ab_dropdownitem a:hover,#rcnt [role=button]:hover,#rcnt .kno-fb-ctx&gt;a:hover,#nycp a.ab_button:hover,#rcnt a.kpbb:hover{text-decoration:none}._wI,._wI a{font-size:18px;line-height:18px}body.fp-fb{overflow:hidden}.fp-fb .fp-f{bottom:0;height:auto;left:0;position:fixed;right:0;top:0;width:auto;z-index:103}.fp-h{display:none !important}.fp-sosr{position:relative;z-index:103}.fp-sofp{position:absolute;top:0;z-index:104}.rc{position:relative}.gl:visited{color:#666}.rc .s{line-height:18px}.srg .g:last-of-type{margin-bottom:16px}#hdtb{background:#fff;color:#666;font-size:small;outline-width:0;outline:none;position:relative;z-index:102}.hdtb_mitem a,#hdtb_more_mn a{padding:0 16px;color:#777;text-decoration:none;display:block}.hdtb_mitem a{margin:0 8px;padding:0 8px}.hdtbItm label:hover,.hdtbItm a:hover,#hdtb_more_mn a:hover,#hdtb .hdtb_mitem a:hover,.hdtb-mn-hd:hover,#hdtb_more:hover,#hdtb_tls:hover{color:#222}#hdtb.notl a,#hdtb.notl div,#hdtb.notl li{outline-width:0;outline:none}#hdtb .hdtb_mitem a:active,#hdtb_more:active,.hdtb-mn-hd:active{color:#dd4b39}#hdtb_more_mn a:hover,.hdtbItm.hdtbSel:hover,.hdtbItm a:hover,#cdrlnk:hover{background-color:#f1f1f1}.hdtbItm.hdtbSel,#hdtb .hdtbItm a,#hdtb_more_mn a,#cdrlnk{color:#777;text-decoration:none;padding:6px 44px 6px 30px;line-height:17px;display:block}.hdtb_mitem a{display:inline-block}#hdtb_more_mn a{display:block;padding:6px 16px;margin:0}#hdtb_more_mn{min-width:120px}#hdtbMenus{background:#fff;padding-bottom:5px;padding-top:7px;top:0;width:100%;height:22px;position:absolute;transition:top 220ms ease-in-out;-moz-transition:top 220ms ease-in-out;}.hdtb-td-h{display:none}#hdtbMenus.hdtb-td-o{top:40px;}body.vasq #hdtbMenus.hdtb-td-o{top:59px}#hdtbMenus.hdtb-td-c{overflow:hidden;border-top:0;display:none;}.hdtb-ab-o #botabar{border-top:1px solid #ebebeb}#hdtbSum{background:#fff;border-bottom:1px solid #ebebeb;height:40px;line-height:35px;padding:0;position:relative;z-index:102}.hdtb-mn-o,.hdtb-mn-c{-moz-box-shadow:0 2px 4px #d6d6d6;background:#fff;border:1px solid #d6d6d6;box-shadow:0 2px 4px #d6d6d6;color:#333;position:absolute;z-index:103;line-height:17px;padding-top:5px;padding-bottom:5px;top:36px}.hdtb-mn-c{display:none}#hdtb_msb{display:inline-block;float:left;position:relative;white-space:nowrap}#hdtb_msb .hdtb_mitem{display:inline-block}#hdtb_more_mn .hdtb_mitem{display:block}#hdtb_msb .hdtb_mitem:first-child.hdtb_imb{margin-left:120px}#hdtb_msb .hdtb_mitem:first-child.hdtb_msel,#hdtb_msb .hdtb_mitem:first-child.hdtb_msel_pre{margin-left:128px}#hdtb_msb .hdtb_mitem.hdtb_msel,#hdtb_msb .hdtb_mitem.hdtb_msel_pre{border-bottom:3px solid #dd4b39;color:#dd4b39;font-weight:bold;height:35px;margin:2px 8px 0;padding:0 8px}#hdtb_msb .hdtb_mitem.hdtb_msel:hover{cursor:pointer}#hdtb_msb .hdtb_mitem.hdtb_msel:active{background:none}#hdtb .hdtb_mitem a{color:#777}#hdtb_msb #hdtb_more,#hdtb_msb #hdtb_tls{color:#777}#hdtb_tls{text-decoration:none}#hdtb_more{display:inline-block;padding:0 16px;position:relative;-moz-tap-highlight-color:rgba(255,255,255,0)}#hdtb_more:hover{cursor:pointer}.hdtb_mitem .micon,#hdtbMenus .lnsep{display:none}.mn-hd-txt{display:inline-block;padding-right:6px;white-space:nowrap}.mn-dwn-arw{border-color:#909090 transparent;border-style:solid;border-width:4px 4px 0 4px;width:0;height:0;margin-left:-2px;top:50%;margin-top:-2px;position:absolute}.hdtb-mn-hd:hover .mn-dwn-arw,#hdtb_more:hover .mn-dwn-arw{border-color:#222 transparent}.hdtb-mn-hd:active .mn-dwn-arw,#hdtb_more:active .mn-dwn-arw{border-color:#dd4b39 transparent}.hdtb-tl{border:1px solid transparent;display:inline-block;min-width:54px;text-align:center;border-radius:2px;padding:4px 8px;line-height:19px;margin-left:9px;cursor:pointer;margin-right:24px}#hdtb_msb .hdtb-tl-sel,#hdtb_msb .hdtb-tl-sel:hover{background:-moz-linear-gradient(top,#eee,#e0e0e0);-moz-box-shadow:inset 0 1px 2px 0 rgba(0,0,0,0.1);border:1px solid #d7d7d7;box-shadow:inset 0 1px 2px 0 rgba(0,0,0,0.1);margin-left:9px}#hdtb #hdtb_tls:active{color:#000}.mn-hd-txt&gt;.simg_thmb{display:none}.tmlo #hdtbSum,.tmlo #hdtbMenus,.tmhi #hdtbSum,.tmhi #hdtbMenus{padding-left:0}.mn-hd-txt .mn-col{width:14px;height:14px;border:1px solid #ccc;display:inline-block;margin-top:7px}.exylnk{cursor:pointer}.exyfrm{padding:0 15px}.exyttl{color:#222 !important;font-size:16px;left:42px;position:absolute;top:34px}.exymml{color:#222;right:177px;margin-top:5px;position:absolute}.exymm{display:inline;font-size:13px !important;height:27px;left:101px;margin:0 4px;padding:5px !important;position:absolute;top:5px;width:84px !important}.exypx{color:#222;left:210px;margin-top:5px;position:absolute}.exyw,.exywl,.exywpx{top:69px}.exyh,.exyhl,.exyhpx{top:108px}.exyhlt{background-color:#f1f1f1;border-radius:2px;height:37px;left:100px;position:absolute;top:65px;-moz-transition:top .13s linear;width:105px !important}.exyhhl{top:104px !important}.exytn{-moz-transition:none}#exygo{color:#222 !important;left:122px;padding:3px 15px;position:absolute;top:150px}.exydlg{background:#fff;box-shadow:0 4px 16px rgba(0,0,0,.2);border:1px solid #c5c5c5;height:195px;left:50%;margin-left:-137px;position:fixed;top:250px;width:275px;z-index:1001}.exybg{background:#fff;height:100%;left:0;opacity:.75;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=75)";position:fixed;top:0;width:100%;z-index:1000}.exycls{background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAoAAAAKBAMAAAB/HNKOAAAAElBMVEX////39/e9vb2zs7PCwsLv7++5ffrDAAAAL0lEQVQI12MIEWBgdGVwVmQQMmEQMhJUVmRgVFYyEmBgEDJWZICSEBGILEQlWBcAq64Ft1WDk9gAAAAASUVORK5CYII=) center no-repeat;cursor:pointer;height:20px;position:absolute;right:11px;top:10px;-moz-user-select:none;width:20px}#isz_lt.hdtbSel{padding-right:0;padding-left:30px}.tnv-lt-m{cursor:pointer}.tnv-lt-sm{display:inline-block;height:94.5%;left:100%;overflow-y:scroll;position:absolute;top:-1px;transition:visibility 400ms ease-in-out;-moz-transition:visibility 400ms ease-in-out;visibility:hidden}.tnv-lt-m:hover+.tnv-lt-sm,.tnv-lt-arw:hover+.tnv-lt-sm,.tnv-lt-sm:hover{visibility:visible}.tnv-lt-arw{border-color:transparent #909090;border-style:solid;border-width:4px;border-right-width:0;height:0;left:100%;margin-left:-15px;margin-top:-2px;position:absolute;top:133px;width:0}.action-menu,.action-menu-button,.action-menu-item,.action-menu-panel,.action-menu-toggled-item,.selected{}._Fmb,._Fmb:hover,._Fmb.selected,._Fmb.selected:hover{background-color:white;background-image:none;border:0;border-radius:0;box-shadow:0 0 0 0;cursor:pointer;filter:none;height:12px;min-width:0;padding:0;transition:none;-moz-user-select:none;width:13px}.action-menu .mn-dwn-arw{border-color:#006621 transparent;margin-top:-4px;margin-left:3px;left:0;}.action-menu:hover .mn-dwn-arw{border-color:#00591E transparent}.action-menu{display:inline;margin:0 3px;position:relative;-moz-user-select:none}.action-menu-panel{left:0;padding:0;right:auto;top:12px;visibility:hidden}.action-menu-item,.action-menu-toggled-item{cursor:pointer;-moz-user-select:none}.action-menu-item:hover{background-color:#eee}.action-menu-button,.action-menu-item a.fl,.action-menu-toggled-item div{color:#333;display:block;padding:7px 18px;text-decoration:none;outline:0}._tgd{display:block;line-height:20px;position:relative;white-space:nowrap}._XQd{padding-right:0;white-space:normal}._vgd{left:0;position:absolute;top:0}._wgd{display:inline-block;max-width:100%}._xgd{color:#222;overflow:hidden;text-overflow:ellipsis}._VQd{margin-top:4px}._vdf{text-decoration:none;white-space:nowrap}._vdf:hover{text-decoration:underline}._vdf:visited{color:#666}._cwc{color:#666;display:table;white-space:nowrap;margin:5px 0}._pgd{display:table-cell;padding-left:15px;vertical-align:top}._qgd{display:table-cell}._sgd{display:table-row;vertical-align:top}._WQd{display:table-caption;caption-side:bottom}._rgd{color:#999}._Tib,._Tib a.fl{color:#808080;}._ygd{position:absolute}._lyb{background-color:#fff;float:left;overflow:hidden;margin-top:4px;position:relative}._YQd{background-color:#000}._Bgd{border:none;bottom:0;font-weight:bold;position:absolute;left:0;text-align:right;text-decoration:none}._dwc{bottom:0;font-size:11px;font-weight:bold;padding:1px 3px;position:absolute;right:0;text-align:right;text-decoration:none;background-color:rgba(0,0,0,.7);color:#fff}.bc{}._SWb a.fl{font-size:14px}._SWb._fof{overflow:hidden;text-overflow:ellipsis}._ewc{height:16px;margin-right:6px;position:relative;top:2px}.st sup{line-height:0.9}.rgsep{background-color:rgba(0,0,0,0.07);border-width:0;color:rgba(0,0,0,0.07);height:1px;margin:0 -8px 16px -8px}._l4.rgsep,.ct-lgsep.rgsep{margin-top:22px}.vk_h{}.vk_c a{text-decoration:none}.vk_gn{color:#3d9400 !important}.vk_rd{color:#dd4b39 !important}.vk_dgy{color:#545454 !important}.vk_gy{color:#878787 !important}.vk_lgy{color:#bababa !important}.vk_blgy{border-color:#bababa}.vk_bk{color:#212121 !important}.vk_fl a{color:#878787}.vk_fl a:hover{color:#12c}.vk_ans{font-weight:lighter !important;margin-bottom:5px}.vk_ans{font-size:xx-large !important}.vk_ans.vk_long{font-size:20px !important}.vk_h{font-weight:lighter !important}.vk_h{font-size:x-large !important}.vk_sh,.vk_hs,.vk_med{font-weight:lighter !important}.vk_sh{font-size:medium !important}.vk_txt{font-weight:lighter !important}.vk_txt{font-size:small !important}.vk_lt{font-weight:lighter !important}.vk_cdns{font-size:13px !important}._ks{font-weight:bold !important}.vk_c,.vk_cxp,#rhs ._CC{-moz-box-shadow:0px 1px 4px 0px rgba(0,0,0,0.2);box-shadow:0px 1px 4px 0px rgba(0,0,0,0.2)}#rhs ._CC{border:none;margin-left:2px}.vk_c,.vk_cxp{background-color:#fff;position:relative}.vkc_np{margin-left:-20px;margin-right:-20px}._Vi,.ts ._Vi{padding-left:20px}._Wi,.ts ._Wi{padding-right:20px}.vk_pt,.ts .vk_pt{padding-top:20px}._Kid{padding-bottom:20px}li.vk_c,.vk_c,.vk_cxp{margin-left:-8px;margin-right:-35px}li.vk_c,.vk_c,.vk_cxp,.vk_ic{padding:20px 20px 24px}.vk_c .vk_c,.vk_c .vk_cxp{-moz-border-radius:0;-moz-box-shadow:none;background-color:transparent;border:0;box-shadow:none;margin:0;padding:0;position:static}.vk_cxp{padding-top:30px;padding-bottom:34px}.vk_c_cxp{margin-top:10px;margin-bottom:10px}.vk_gbb{border-bottom:1px solid #eee}.vk_gbr{border-right:1px solid #eee}.vk_gbt{border-top:1px solid #eee}.vk_cf{margin:0 -20px 0 -20px;padding:16px 20px 16px 20px}.vk_cf a,.vk_cf a:link,a.vk_cf,a.vk_cf:link{color:#878787}.vk_cf a:hover,a.vk_cf:hover{color:#12c}.vk_slic{display:inline-block;margin-top:-3px;margin-right:16px;position:relative;height:24px;width:24px;vertical-align:middle}.vk_sli,.vk_slih{border:none;position:absolute;top:0;left:0;height:24px;width:24px}a:hover .vk_sli,.vk_slih{display:none}a:hover .vk_slih,.vk_sli{display:inline-block}.vk_cba{padding:10px;margin-top:10px;margin-bottom:-10px;font-size:14px !important}.vk_spc{height:16px;width:100%}.vk_ra{-moz-transform:rotate(90deg)}.vk_arc{border-top:1px solid #ebebeb;cursor:pointer;height:0px;margin-bottom:-23px;overflow:hidden;padding:20px 0;text-align:center}.vk_ard{top:-11px}.vk_aru{bottom:-6px}.vk_ard,.vk_aru{background-color:#e5e5e5;margin-left:auto;margin-right:auto;position:relative}.vk_ard,.vk_aru{height:6px;width:64px}.vk_ard:after,.vk_ard:before,.vk_aru:after,.vk_aru:before{content:'' '';height:0;left:0;position:absolute;width:0}.vk_ard:after,.vk_ard:before,.vk_aru:after,.vk_aru:before{border-left:32px solid rgba(229,229,229,0);border-right:32px solid rgba(229,229,229,0)}.vk_ard:before{border-top:16px solid #e5e5e5;top:6px}.vk_aru:before{border-bottom:16px solid #e5e5e5;bottom:6px}.vk_ard:after{top:0}.vk_ard:after{border-top:16px solid #fff}.vk_aru:after{bottom:0}.vk_aru:after{border-bottom:16px solid #fff}.vk_bk.vk_ard,.vk_bk.vk_aru{background-color:#212121}.vk_bk.vk_ard:before{border-top-color:#212121}.vk_bk.vk_aru:before{border-bottom-color:#212121}._vm{font-size:11px !important;padding:6px 8px}#center_col ._vm{margin:0 -35px 0 -8px;padding:6px 20px 0}#rhs ._vm{margin-left:2px;padding-bottom:5px;padding-top:5px}._vm,._vm a{color:#878787 !important;text-decoration:none}._vm a:hover{text-decoration:underline}._srb.vk_c{padding-top:24px;padding-bottom:20px}._srb .vk_ans{margin-bottom:0}._srb .vk_gy{margin-bottom:5px}._xk{background-color:#ebebeb;height:1px}.vk_tbl{border-collapse:collapse}.vk_tbl td{padding:0}.xpdclps,.xpdxpnd{overflow:hidden}.xpdclps,.xpdxpnd{-moz-transition:max-height 0.3s}.xpdxpnd,.xpdopen .xpdclps,.xpdopen .xpdxpnd.xpdnoxpnd{max-height:0}.xpdopen .xpdxpnd{max-height:none}.xpdopen .xpdbox .xpdxpnd,.xpdopen .xpdbox.xpdopen .xpdclps{max-height:0}.xpdopen .xpdbox.xpdopen .xpdxpnd,.xpdopen .xpdbox .xpdclps{max-height:none}.xpdclose ._o0,.xpdopen .xpdclps-nt{display:none}#tads h3,#tadsb h3,#mbEnd h3{font-size:18px !important;}#center_col .ads-ad:not(:first-child),#rhs .ads-ad:not(:first-child){border-top:1px solid transparent}#center_col ._Ak,#rhs ._Ak{color:#545454}.ads-ad{line-height:18px}._Ak a{text-decoration:none}._Ak a:hover{text-decoration:underline}#center_col ._Ak a{color:#1a0dab}#center_col ._Ak a:visited,#center_col ._Ak a._kBb,#rhs ._Ak a:visited,#rhs ._Ak a._kBb{color:#609}#center_col ._Ak a:active,#rhs ._Ak a:active{color:#dd4b39}#center_col ._Ak ._Bu,#center_col ._Ak ._Bu a,#rhs ._Ak ._Bu,#rhs ._Ak ._Bu a{color:#808080}._LEc&gt;li{display:inline;margin:0;padding:0}._LEc&gt;li+li:before{content:'' - ''}._vj{display:inline-block;padding:0 12px;text-align:center;white-space:nowrap;border:1px solid #dcdcdc;border-radius:2px;background:#f5f5f5;background-image:-moz-gradient(linear,left top,left bottom,from(#f5f5f5),to(#f1f1f1));background-image:-moz-linear-gradient(top,#f5f5f5,#f1f1f1);background-image:linear-gradient(#f5f5f5,#f1f1f1);filter:progid:DXImageTransform.Microsoft.gradient(startColorStr=''#f5f5f5'',EndColorStr=''#f1f1f1'')}._vj:active,._vj:hover{border-color:#c6c6c6;background:#f8f8f8;background-image:-moz-gradient(linear,left top,left bottom,from(#f8f8f8),to(#f1f1f1));background-image:-moz-linear-gradient(top,#f8f8f8,#f1f1f1);background-image:linear-gradient(#f8f8f8,#f1f1f1);filter:progid:DXImageTransform.Microsoft.gradient(startColorStr=''#f8f8f8'',EndColorStr=''#f1f1f1'')}._vj:hover{box-shadow:0px 1px 1px rgba(0,0,0,0.1);-moz-box-shadow:0px 1px 1px rgba(0,0,0,0.1)}._vj:focus{outline:none}._vj:active,._vj:hover:active,._vj._d2b{box-shadow:inset 0px 1px 2px rgba(0,0,0,0.1);-moz-box-shadow:inset 0px 1px 2px rgba(0,0,0,0.1)}._hnd{line-height:27px}._vj._ind{line-height:17px}._K0{padding:0 2px;line-height:31px;min-width:66px}._vj,._Vx{color:#333;font-size:11px;font-weight:bold}._Vx{opacity:1}._vj._d2b,._vj._d2b ._Vx,._vj:active,._vj:hover,._vj:active ._Vx,._vj:hover ._Vx{color:#212121}._C8{display:inline-block;position:relative;vertical-align:middle;width:18px;height:18px;background-repeat:no-repeat;margin:0 -2px}._C8+._Vx{margin-left:8px;margin-right:2px}._LC{background-color:#fff;border:1px solid #d9d9d9;border-top-color:#c0c0c0;box-sizing:content-box;-moz-box-sizing:content-box;color:#545454;display:inline-block;height:19px;line-height:19px;margin:0;font-size:inherit}._LC:hover{border-color:#b9b9b9;border-top-color:#a0a0a0;box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.1)}._LC:focus{border-color:#4d90fe;box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);outline:none}._LC._mFc{color:#999}#center_col ._x2b{margin-left:-8px;margin-right:-8px}#center_col ._tve{border-top:1px solid #ebebeb;margin-right:-8px}._Tv{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.kno-ecr-pt{}.kno-ecr-pt{color:#000;font-family:arial,sans-serif-light,sans-serif;font-size:30px;font-weight:normal;position:relative;overflow:hidden;-moz-transform-origin:left;transform-origin:left}.shop__a{text-decoration:none}.shop__a{color:#1a0dab}.shop__a:active{color:#1a0dab}.shop__clear{clear:both}.shop__secondary,.shop__secondary:link,.shop__secondary:visited{color:#666}a.shop__secondary,.shop__a.shop__secondary{text-decoration:none}.shop__a:hover{cursor:pointer;text-decoration:underline}a.shop__secondary:hover,.shop__a.shop__secondary:hover{text-decoration:underline}#ss-box{background:#fff;border:1px solid;border-color:#c9d7f1 #36c #36c #a2bae7;left:0;margin-top:.1em;position:absolute;visibility:hidden;z-index:103}#ss-box a{display:block;padding:.2em .31em;text-decoration:none}#ss-box a:hover{background:#4d90fe;color:#fff !important}a.ss-selected{color:#222 !important;font-weight:bold}a.ss-unselected{color:#12c !important}.ss-selected .mark{display:inline}.ss-unselected .mark{visibility:hidden}#ss-barframe{background:#fff;left:0;position:absolute;visibility:hidden;z-index:100}</style></div> <a style="left:-1000em;position:absolute" href="/setprefs?suggon=2&amp;prev=https://www.google.co.in/?gfe_rd%3Dcr%26ei%3Dzd8PVditOujA8gea8IGwBg%26gws_rd%3Dssl&amp;sig=0_tpZvcbukZPrPYQMLEY5wKNYxp1M%3D">Screen-reader users, click here to turn off Google Instant.</a>  <textarea style="display:none" id="csi"></textarea><script>if(google.j.b)document.body.style.visibility=''hidden'';</script><div id="searchform" class="big"><script>(function(){var _j=1250;try{var s=document.getElementById(''searchform'');var w=document[''body'']&amp;&amp;document.body[''offsetWidth''];if(s&amp;&amp;w&amp;&amp;w&gt;=_j){s.className+='' big'';}\r\n}catch(e){}\r\n})();</script>   <style>div#searchform{min-width:980px;z-index:103}div.sfbg,div.sfbgg{height:59px}.big form#tsf,form#tsf{width:auto;max-width:784px;overflow:hidden}#searchform.big&gt;#tsf{max-width:784px}.big div.tsf-p,form&gt;div.tsf-p{margin:-1px 0 0;padding-right:0}#gb{font-size:13px}div#viewport{position:absolute;top:0;width:100%}div#searchform.jhp{margin-top:0}#searchform.big.jhp&gt;#tsf{max-width:none}.jhp&gt;#gb{position:absolute;top:-295px;right:0;width:100%}.jhp&gt;#tsf{max-width:none}</style> <div id="gb" class="gb_p"> <div id="gbw">   <div style="top:0;width:100%">  <div class="gb_ea gb_0c gb_n gb_Zc gb_p" style="min-width: 116px;"><div class="gb_Lc gb_n gb_0c gb_Sc gb_q"><div class="gb_m gb_n gb_o gb_0c"><a data-ved="0CA8Qwi4oAA" data-pid="119" href="https://plus.google.com/?gpsrc=ogpy0&amp;tab=wX" class="gb_l gb_n">+You</a></div><div class="gb_m gb_n"><a data-ved="0CBAQwi4oAQ" data-pid="23" href="https://mail.google.com/mail/?tab=wm" class="gb_l">Gmail</a></div><div class="gb_m gb_n"><a data-pid="2" href="https://www.google.co.in/imghp?hl=en&amp;tab=wi&amp;ei=2d8PVbsnlZC5BMSogaAI&amp;ved=0CBEQqi4oAg" class="gb_l">Images</a></div></div><div class="gb_Kc gb_0c gb_n" style="min-width: 116px;"><div id="gbsfw" class="gb_N"></div><div id="gbwa" class="gb_J gb_qb gb_n"><div class="gb_5a"><a data-ved="0CBIQvSc" aria-expanded="false" aria-haspopup="true" title="Apps" href="http://www.google.co.in/intl/en/options/" class="gb_K gb_0a" data-eqid="0click"></a><div class="gb_qa"></div><div class="gb_pa"></div></div><div tabindex="0" aria-hidden="true" role="region" aria-label="Apps" class="gb_5b gb_N gb_W"><ul aria-dropeffect="move" class="gb_P gb_H"><li aria-grabbed="false" class="gb_v"><a data-ved="0CAAQwS4oAA" data-pid="119" href="https://plus.google.com/?gpsrc=ogpy0&amp;tab=wX" id="gb119" class="gb_k"><span style="background-position:0 -207px" class="gb_z"></span><span class="gb_A">+You</span></a></li><li aria-grabbed="false" class="gb_v"><a data-pid="1" href="https://www.google.co.in/webhp?tab=ww&amp;ei=2d8PVbsnlZC5BMSogaAI&amp;ved=0CAEQqS4oAQ" id="gb1" class="gb_k"><span style="background-position:0 -414px" class="gb_z"></span><span class="gb_A">Search</span></a></li><li aria-grabbed="false" class="gb_v"><a data-ved="0CAIQwS4oAg" data-pid="36" href="https://www.youtube.com/?gl=IN" id="gb36" class="gb_k"><span style="background-position:0 -1449px" class="gb_z"></span><span class="gb_A">YouTube</span></a></li><li aria-grabbed="false" class="gb_v"><a data-ved="0CAMQwS4oAw" data-pid="8" href="https://maps.google.co.in/maps?hl=en&amp;tab=wl" id="gb8" class="gb_k"><span style="background-position:0 -828px" class="gb_z"></span><span class="gb_A">Maps</span></a></li><li aria-grabbed="false" class="gb_v"><a data-ved="0CAQQwS4oBA" data-pid="78" href="https://play.google.com/?hl=en&amp;tab=w8" id="gb78" class="gb_k"><span style="background-position:0 -1725px" class="gb_z"></span><span class="gb_A">Play</span></a></li><li aria-grabbed="false" class="gb_v"><a data-pid="5" href="https://news.google.co.in/nwshp?hl=en&amp;tab=wn&amp;ei=2d8PVbsnlZC5BMSogaAI&amp;ved=0CAUQqS4oBQ" id="gb5" class="gb_k"><span style="background-position:0 -1656px" class="gb_z"></span><span class="gb_A">News</span></a></li><li aria-grabbed="false" class="gb_v"><a data-ved="0CAYQwS4oBg" data-pid="23" href="https://mail.google.com/mail/?tab=wm" id="gb23" class="gb_k"><span style="background-position:0 -690px" class="gb_z"></span><span class="gb_A">Gmail</span></a></li><li aria-grabbed="false" class="gb_v"><a data-ved="0CAcQwS4oBw" data-pid="49" href="https://drive.google.com/?tab=wo" id="gb49" class="gb_k"><span style="background-position:0 -1242px" class="gb_z"></span><span class="gb_A">Drive</span></a></li><li aria-grabbed="false" class="gb_v"><a data-ved="0CAgQwS4oCA" data-pid="24" href="https://www.google.com/calendar?tab=wc" id="gb24" class="gb_k"><span style="background-position:0 -1518px" class="gb_z"></span><span class="gb_A">Calendar</span></a></li></ul><a href="http://www.google.co.in/intl/en/options/" class="gb_M gb_cc" aria-expanded="false" aria-hidden="true">More</a><span class="gb_Q"></span><ul aria-dropeffect="move" class="gb_P gb_I" aria-hidden="true"><li aria-grabbed="false" class="gb_v"><a data-ved="0CAkQwS4oCQ" data-pid="51" href="https://translate.google.co.in/?hl=en&amp;tab=wT" id="gb51" class="gb_k"><span style="background-position:0 -1587px" class="gb_z"></span><span class="gb_A">Translate</span></a></li><li aria-grabbed="false" class="gb_v"><a data-pid="10" href="https://books.google.co.in/bkshp?hl=en&amp;tab=wp&amp;ei=2d8PVbsnlZC5BMSogaAI&amp;ved=0CAoQqS4oCg" id="gb10" class="gb_k"><span style="background-position:0 -138px" class="gb_z"></span><span class="gb_A">Books</span></a></li><li aria-grabbed="false" class="gb_v"><a data-ved="0CAsQwS4oCw" data-pid="30" href="https://www.blogger.com/?tab=wj" id="gb30" class="gb_k"><span style="background-position:0 -1311px" class="gb_z"></span><span class="gb_A">Blogger</span></a></li><li aria-grabbed="false" class="gb_v"><a data-ved="0CAwQwS4oDA" data-pid="31" href="https://plus.google.com/photos?tab=wq" id="gb31" class="gb_k"><span style="background-position:0 -966px" class="gb_z"></span><span class="gb_A">Photos</span></a></li><li aria-grabbed="false" class="gb_v"><a data-ved="0CA0QwS4oDQ" data-pid="25" href="https://docs.google.com/document/?usp=docs_alc" id="gb25" class="gb_k"><span style="background-position:0 -483px" class="gb_z"></span><span class="gb_A">Docs</span></a></li></ul><a href="http://www.google.co.in/intl/en/options/" class="gb_Q gb_6b" aria-hidden="true">Even more from Google</a></div></div><div class="gb_Mc gb_n"><div class="gb_5a"><a target="_top" href="https://accounts.google.com/ServiceLogin?hl=en&amp;continue=https://www.google.co.in/%3Fgfe_rd%3Dcr%26ei%3Dzd8PVditOujA8gea8IGwBg%26gws_rd%3Dssl" id="gb_70" class="gb_gc gb_6 gb_5">Sign in</a><div class="gb_qa"></div><div class="gb_pa"></div></div></div></div></div>  </div> </div> </div>      <div style="margin-top: -15px; visibility: visible;" class="sfbg nojsv"><div class="sfbgg"></div></div><form role="search" onsubmit="return q.value!=''''" name="f" method="GET" id="tsf" style="overflow:visible" action="/search" class="tsf"><input type="hidden" name="sclient" value="psy-ab"><div id="tophf" data-jiis="uc" data-jibp=""><input type="hidden" value="1366" name="biw"><input type="hidden" value="351" name="bih"></div><div class="tsf-p"><div id="logocont" class="nojsv logocont" style="visibility: visible;"><h1><a title="Go to Google Home" href="https://www.google.co.in/webhp?hl=en" id="logo"><img width="167" height="373" alt="Google" src="/images/nav_logo195.png"></a></h1></div><div class="sfibbbc"><div id="sbtc" class="sbtc" style="text-align: left;"><div class="sbibtd"><div id="sfopt" class="nojsv sfopt" style="visibility: visible;"><div class="lsd"><div data-jiis="uc" style="white-space: nowrap; z-index: 98;" id="ss-bar"></div></div></div><div class="sfsbc"><div class="nojsb" style="display: block;"> <div id="sbds" class="ds"> <div id="sblsbb" class="lsbb kpbb">  <button type="submit" name="btnG" aria-label="Google Search" value="Search" class="lsb"> <span class="sbico"></span> </button> </div> </div> </div></div><div id="sfdiv" class="sbibod ">   <div class="gstl_0 sbib_a" style="height: 27px;"><div class="sbib_d" id="sb_chc0" dir="ltr"></div><div class="gsst_b sbib_c" id="gs_st0" style="line-height: 27px; display: none;" dir="ltr"></div><div class="sbib_b" id="sb_ifc0" dir="ltr"><div id="gs_lc0" style="position: relative;"><input type="text" aria-label="Search" value="" title="Search" autocomplete="off" name="q" maxlength="2048" id="lst-ib" class="gsfi" aria-haspopup="false" role="combobox" aria-autocomplete="both" style="border: medium none; padding: 0px; margin: 0px; height: auto; width: 100%; background: url(&quot;data:image/gif;base64,R0lGODlhAQABAID/AMDAwAAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw%3D%3D&quot;) repeat scroll 0% 0% transparent; position: absolute; z-index: 6; left: 0px; outline: medium none;" dir="ltr" spellcheck="false"><div class="gsfi" style="background: none repeat scroll 0% 0% transparent; color: transparent; padding: 0px; position: absolute; z-index: 2; white-space: pre; visibility: hidden;" id="gs_sc0"></div><input class="gsfi" disabled="" autocomplete="off" aria-hidden="true" style="border: medium none; padding: 0px; margin: 0px; height: auto; width: 100%; position: absolute; z-index: 1; background-color: transparent; color: silver; left: 0px; visibility: hidden;" id="gs_taif0" dir="ltr"><input class="gsfi" disabled="" autocomplete="off" aria-hidden="true" style="border: medium none; padding: 0px; margin: 0px; height: auto; width: 100%; position: absolute; z-index: 1; background-color: transparent; color: silver; transition: all 0.218s ease 0s; opacity: 0; left: 0px; text-align: left;" id="gs_htif0" dir="ltr"></div></div></div> </div></div><div class="gstl_0 sbdd_a" style="min-width: 589px; top: 27px; position: absolute; text-align: left; left: 0px;" dir="ltr"><div class="fl"></div><div><div class="sbdd_b" style="display: none;"><div class="sbsb_a"><ul class="sbsb_b" role="listbox"></ul></div></div><div><div style="left: 0px; white-space: nowrap; position: absolute; z-index: 987; display: none; margin-top: 16px;" id="pocs" class="sft"><div id="pocs0" style="display: none;"><span><span>Google</span> Instant is unavailable. Press Enter to search.</span>&nbsp;<a href="/support/websearch/bin/answer.py?answer=186645&amp;form=bb&amp;hl=en-IN">Learn more</a></div><div id="pocs1" style="display: none;"><span>Google</span> Instant is off due to connection speed. Press Enter to search.</div><div id="pocs2">Press Enter to search.</div></div></div></div></div></div><div></div></div><div style="padding-top: 2px; display: none;" class="jsb"><center><input type="submit" jsaction="sf.chk" name="btnK" aria-label="Google Search" value="Google Search"><input type="submit" jsaction="sf.lck" name="btnI" aria-label="I''m Feeling Lucky" value="I''m Feeling Lucky"></center></div></div><input type="hidden" name="oq" value=""><input type="hidden" name="gs_l" value=""><input type="hidden" name="pbx" value="1"><div class="gsfi" style="background: none repeat scroll 0% 0% transparent; color: rgb(0, 0, 0); padding: 0px; position: absolute; white-space: pre; visibility: hidden;"></div></form></div><div id="gac_scont"></div><div id="main" data-jiis="cc" class="content"><div id="ilrpc" data-jiis="uc" data-jibp="h" style=""></div><div id="easter-egg" data-jiis="uc" data-jibp=""></div><div id="cnt" data-jiis="bp" class="big"><script>(function(){var j=1250;try{var c=document.getElementById(''cnt'');var s=document.getElementById(''searchform'');var n='''';if(window.gbar&amp;&amp;gbar.elr){var m=gbar.elr().mo;n=(m==''md''?'' mdm'':(m==''lg''?'' big'':''''));}else{var w=document.body&amp;&amp;document.body.offsetWidth;if(w&amp;&amp;w&gt;=j){n='' big'';}\r\n}\r\nc&amp;&amp;(c.className+=n);s&amp;&amp;(s.className+=n);}catch(e){}\r\n})();</script><div class="mw"><div id="sfcnt"><div id="sform"></div></div><div id="dc" data-jiis="uc" data-jibp="h" style=""></div><div id="subform_ctrl" style="visibility: visible;"></div></div><div style="display: none;" id="bst" data-jiis="uc" data-jibp="h"><style>._Mrd{margin-top:6px;height:16px;position:relative}._hMc{left:5px;position:relative;color:#888;font-size:11px}._iMc ._hMc{font-size:13px}._Prd{top:0px;position:absolute;width:534px;text-align:right}._gMc{font-size:13px;text-decoration:none}._gMc:hover{text-decoration:underline}._Ba ._Dt{filter:alpha(opacity=50);opacity:0.5}._Nrd{padding:6px 0}._MV{width:540px}._MV table{top:3px;position:relative;text-align:center;font-size:13px;margin:0 auto;border-spacing:18px 1px}._MV td{width:100px}._Ea{display:block;font-size:16px;text-decoration:none}._Ea:hover{text-decoration:underline}._LV{color:#888;padding:6px 0 3px 20px;text-align:center;font-size:13px}._dxc{text-decoration:none}._dxc:hover{text-decoration:underline}._xhd{color:#888;padding:6px 0 3px 20px;text-align:center;font-size:13px}._DJ{width:540px}._DJ table{top:3px;position:relative;font-size:13px;margin:0 auto;border-collapse:collapse;width:100%}._DJ td{padding:6px 8px 3px 8px;white-space:nowrap}._DJ ._bN{font-weight:bold;color:#222;padding-left:3px}._vFb{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}._aN{text-decoration:none}._aN:hover{text-decoration:underline}._KV{color:#888}._Ca{color:#888}._Da{padding-right:0}._Ord{color:#222;font-weight:bold}._Fa{color:#DD4B39}._LV{color:#888;padding:6px 0 3px 20px;text-align:center;font-size:13px;filter:alpha(opacity=50);opacity:0.5}._Ga{padding-left:6px;padding-right:6px;display:inline-block;position:relative;top:2px}._eMc td{padding:7px 6px 0px 6px;white-space:nowrap}._eMc ._bN{color:#222;padding-left:3px}._fMc td{padding:3px 5px 0px 0px;white-space:nowrap}._fMc ._bN{color:#222;padding-left:3px;font-weight:bold}._Zge._eMc td{padding:8px 6px 0px 6px;white-space:nowrap}._Zge._fMc td{padding:10px 5px 0px 0px;white-space:nowrap}._TZ{background-color:#f5f5f5;font-size:13px;height:27px;margin-bottom:3px;margin-top:6px;padding:5px 0 5px 6px;position:relative;width:534px}._s7 ._TZ{background-color:white;margin-bottom:5px;margin-top:2px}._RZ{left:7px;position:absolute;top:5px;white-space:nowrap}._s7 ._RZ{left:1px}._SZ{right:7px;position:absolute;top:5px;white-space:nowrap}._s7 ._SZ{right:0}._KI{background-color:white;border:1px solid #d9d9d9;border-top:1px solid #c0c0c0;cursor:default;display:inline-block;margin-left:5px;padding:5px 6px 4px 7px;position:relative;width:177px}._s7 ._KI{margin-left:0;padding:7px 8px 7px 9px;width:235px}._KI:hover{border:1px solid #b9b9b9;border-top:1px solid #a0a0a0;box-shadow:inset 0px 1px 2px rgba(0,0,0,0.1);-moz-box-shadow:inset 0px 1px 2px rgba(0,0,0,0.1);-webkit-box-shadow:inset 0px 1px 2px rgba(0,0,0,0.1)}._qq{color:#555;cursor:pointer;font-size:11px;font-weight:bold;height:auto;margin:0 0 0 -1px;min-width:0;overflow:hidden;padding:5px 9px 4px 9px;position:absolute;top:4px}._s7 ._qq{top:5px;padding:5px 9px 5px 9px}._Pwc{background:white;border:1px solid #ddd;opacity:0.5;pointer-events:none}._bE{border-radius:2px 0 0 2px;-moz-border-radius:2px 0 0 2px;-webkit-border-radius:2px 0 0 2px;right:26px}._s7 ._bE{right:28px}._cE{border-radius:0 2px 2px 0;-moz-border-radius:0 2px 2px 0;-webkit-border-radius:0 2px 2px 0;right:4px}._s7 ._cE{right:6px}._cG{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAAGCAYAAAAG5SQMAAAAG0lEQVR42mNggIKMjIz/cAaYA2NgclCUIRsAAN75GpU2/c3lAAAAAElFTkSuQmCC);display:block;height:6px;width:3px}._dG{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAAGCAYAAAAG5SQMAAAAHUlEQVR42mPIyMj4zwADIA5cAMYBC2DlwJXB9AMAJegalUu/AOoAAAAASUVORK5CYII=);display:block;height:6px;width:3px}._Owc{background-image:url(data:image/png;base64,R0lGODlhDAAMAKIAAFFRUfLy8nV1df///3l5ef///wAAAAAAACH5BAEHAAUALAAAAAAMAAwAAAMgKLDc2pCFSeuqOFwNBJ8bKH4gMYbaCYCdmlnrCz7RIiQAOw==);height:12px;position:absolute;right:60px;top:9px;width:12px}._wXb ._TZ{padding:5px 0;width:540px}._wXb ._RZ{float:left;position:static;left:1px}._wXb ._SZ{float:left;position:static}._wXb ._KI{margin-left:0;padding:7px 8px 7px 9px;width:146px}._nhd{float:right;position:static;margin:0;height:31px}._Vb{background-color:white;border:1px solid #b4b4b4;box-shadow:0 2px 4px rgba(0,0,0,0.2);-moz-box-shadow:0 2px 4px rgba(0,0,0,0.2);-webkit-box-shadow:0 2px 4px rgba(0,0,0,0.2);position:absolute}._Vb .goog-date-picker{background-color:white;border:0;outline:0;padding:0}._ohd{display:inline-block;width:30px;text-align:center}._Vb #goog-dp-0,._Vb #goog-dp-1,._Vb #goog-dp-2,._Vb #goog-dp-3,._Vb #goog-dp-4,._Vb #goog-dp-5,._Vb #goog-dp-6,._Vb #goog-dp-7,._Vb #goog-dp-13,._Vb #goog-dp-14,._Vb #goog-dp-20,._Vb #goog-dp-21,._Vb #goog-dp-27,._Vb #goog-dp-28,._Vb #goog-dp-34,._Vb #goog-dp-35,._Vb #goog-dp-36,._Vb #goog-dp-37,._Vb #goog-dp-38,._Vb #goog-dp-39,._Vb #goog-dp-40,._Vb #goog-dp-41{border:0}._Vb .goog-date-picker table{margin:16px;width:auto}._Vb .goog-date-picker thead td{padding-bottom:5px}._Vb .goog-date-picker td,._Vb .goog-date-picker th{background-color:white;color:#666;font-size:11px;font-weight:normal;height:20px;padding:0;text-align:center;width:20px}._Vb .goog-date-picker th:first-child{width:1px}._Vb .goog-date-picker td.goog-date-picker-monthyear{font-size:13px;text-align:center}._Vb .goog-date-picker button.goog-date-picker-btn{background:none;border:0;color:black;cursor:pointer;font-size:13px;padding:0 3px 0 3px;position:relative;top:-1px}._Vb .goog-date-picker td.goog-date-picker-date{cursor:pointer}._Vb .goog-date-picker .goog-date-picker-btn:hover,._Vb .goog-date-picker td.goog-date-picker-date:hover,._Vb .goog-date-picker ._Rwc{background-color:#f0f0f0}._Vb .goog-date-picker td.goog-date-picker-other-month,._Vb .goog-date-picker ._djb{color:#aaa}._Vb .goog-date-picker td.goog-date-picker-today{border:0}._Vb .goog-date-picker ._djb{pointer-events:none}#lclbox.g{margin-bottom:16px}.luibli{float:left;margin-right:1px}.luibr{float:right}.luibbri{margin-top:1px}.luib .thumb{position:relative}.luib .thumb .cptn{background:rgb(0,0,0);background:rgba(0,0,0,0.6);bottom:0;color:#fff;font-size:larger;padding:5px 10px;position:absolute;right:0}#annot .so{color:#222;display:table-cell;vertical-align:middle;width:inherit}#annot .fl{color:#222 !important}#annot .soha{color:#1a0dab !important}.intrjus .so{margin:0}</style></div><div id="top_nav" data-jiis="uc" data-jibp="h" style=""><style>#ab_ctls a{text-decoration:none}#ab_ctls a.ab_button:active,#ab_ctls a.ab_dropdownlnk:active{color:#333}</style><div class="r-top_nav-1" jsl="$t t--24YyUDCiR8;$x 0;"><div tabindex="0" role="navigation" id="hdtb" class="hdtbna notl"><div id="hdtbSum"><div style="white-space:nowrap" id="hdtb_s"><div id="hdtb_msb"><div class="hdtb_mitem hdtb_msel hdtb_imb">Web</div><div class="hdtb_mitem hdtb_imb"><a href="https://maps.google.co.in/maps?q=hotel+in+udaipur&amp;bav=on.2,or.&amp;bvm=bv.88528373,d.c2E&amp;biw=1366&amp;bih=648&amp;dpr=1&amp;um=1&amp;ie=UTF-8&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CAYQ_AUoAQ" class="q qs">Maps</a></div><div class="hdtb_mitem hdtb_imb"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnms&amp;tbm=isch&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CAcQ_AUoAg" class="q qs">Images</a></div><div class="hdtb_mitem hdtb_imb"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnms&amp;tbm=nws&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CAgQ_AUoAw" class="q qs">News</a></div><div class="hdtb_mitem hdtb_imb"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnms&amp;tbm=vid&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CAkQ_AUoBA" class="q qs">Videos</a></div><a tabindex="0" role="menu" id="hdtb_more" aria-label="More"><span class="mn-hd-txt">More</span><span class="mn-dwn-arw"></span></a><a data-ved="0CAoQ2x8oBQ" tabindex="0" role="button" id="hdtb_tls" class="hdtb-tl">Search tools</a></div><ol id="ab_ctls"><li class="ab_ctl"><a jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" unselectable="on" tabindex="0" role="button" id="abar_button_opt" aria-haspopup="true" aria-expanded="false" href="/preferences?hl=en" class="ab_button"><span unselectable="on" id="ab_opt_icon" title="Options" class="ab_icon"></span></a><div style="visibility:hidden" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" id="ab_options" class="ab_dropdown"><ul><li role="menuitem" aria-selected="false" class="ab_dropdownitem"><a tabindex="-1" href="/preferences?hl=en&amp;prev=https://www.google.co.in/search?sclient%3Dpsy-ab%26site%26source%3Dhp%26q%3Dhotel%2Bin%2Budaipur%26oq%26gs_l%26pbx%3D1%26bav%3Don.2,or.%26bvm%3Dbv.88528373,d.c2E%26biw%3D1366%26bih%3D648%26dpr%3D1%26pf%3Dp" class="ab_dropdownlnk"><div>Search settings</div></a></li><li role="menuitem" aria-selected="false" class="ab_dropdownitem"><a tabindex="-1" href="/preferences?hl=en&amp;prev=https://www.google.co.in/search?sclient%3Dpsy-ab%26site%26source%3Dhp%26q%3Dhotel%2Bin%2Budaipur%26oq%26gs_l%26pbx%3D1%26bav%3Don.2,or.%26bvm%3Dbv.88528373,d.c2E%26biw%3D1366%26bih%3D648%26dpr%3D1%26pf%3Dp#languages" class="ab_dropdownlnk"><span>Languages</span></a></li><li role="menuitem" aria-selected="false" class="ab_dropdownitem"><a jsaction="ab.cbbl" tabindex="-1" id="safesearch" class="ab_dropdownlnk" href="/setprefs?safeui=on&amp;sig=0_tpZvcbukZPrPYQMLEY5wKNYxp1M%3D&amp;prev=https://www.google.co.in/search?sclient%3Dpsy-ab%26site%26source%3Dhp%26q%3Dhotel%2Bin%2Budaipur%26oq%26gs_l%26pbx%3D1%26bav%3Don.2,or.%26bvm%3Dbv.88528373,d.c2E%26biw%3D1366%26bih%3D648%26dpr%3D1%26pf%3Dp"><div>Turn on SafeSearch</div></a></li><li role="menuitem" aria-selected="false" class="ab_dropdownitem"><a tabindex="-1" id="ab_as" href="/advanced_search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;hl=en" class="ab_dropdownlnk"><div>Advanced search</div></a></li><li role="menuitem" aria-selected="false" class="ab_dropdownitem"><a tabindex="-1" href="/history/optout?hl=en" class="ab_dropdownlnk"><div>History</div></a></li><li role="menuitem" aria-selected="false" class="ab_dropdownitem"><a tabindex="-1" href="//www.google.com/support/websearch/?source=g&amp;hl=en-IN" class="ab_dropdownlnk"><div>Search help</div></a></li></ul></div></li></ol></div></div><div data-ved="0CAsQ2h8oAA" class="hdtb-mn-c" id="hdtb_more_mn"><div class="hdtb_mitem"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnms&amp;tbm=bks&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CAwQ_AUoAA" class="q qs">Books</a></div><div class="hdtb_mitem"><a href="https://www.google.co.in/flights/gwsredirect?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnms&amp;tbm=flm&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CA0Q_AUoAQ" class="q qs">Flights</a></div><div class="hdtb_mitem"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnms&amp;tbm=app&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CA4Q_AUoAg" class="q qs">Apps</a></div></div><div data-ved="0CA8Q3B8" tabindex="0" id="hdtbMenus" aria-expanded="false" class="hdtb-td-c hdtb-td-h"><div class="hdtb-mn-cont"><div id="hdtb-mn-gp"></div><div tabindex="0" role="button" aria-haspopup="true" class="hdtb-mn-hd" aria-label="Any country"><div class="mn-hd-txt">Any country</div><span class="mn-dwn-arw"></span></div><ul class="hdtbU hdtb-mn-c"><li tabindex="0" id="lr_" class="hdtbItm hdtbSel">Any country</li><li id="ctr_countryIN" class="hdtbItm"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnt&amp;tbs=ctr:countryIN&amp;cr=countryIN&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CBMQpwU" class="q qs">Country: India</a></li></ul><span class="_Vxd"></span><div tabindex="0" role="button" aria-haspopup="true" class="hdtb-mn-hd" aria-label="Any time"><div class="mn-hd-txt">Any time</div><span class="mn-dwn-arw"></span></div><ul class="hdtbU hdtb-mn-c"><li tabindex="0" id="qdr_" class="hdtbItm hdtbSel">Any time</li><li id="qdr_h" class="hdtbItm"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnt&amp;tbs=qdr:h&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CBMQpwU" class="q qs">Past hour</a></li><li id="qdr_d" class="hdtbItm"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnt&amp;tbs=qdr:d&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CBMQpwU" class="q qs">Past 24 hours</a></li><li id="qdr_w" class="hdtbItm"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnt&amp;tbs=qdr:w&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CBMQpwU" class="q qs">Past week</a></li><li id="qdr_m" class="hdtbItm"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnt&amp;tbs=qdr:m&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CBMQpwU" class="q qs">Past month</a></li><li id="qdr_y" class="hdtbItm"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnt&amp;tbs=qdr:y&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CBMQpwU" class="q qs">Past year</a></li><li id="cdr_opt" class="hdtbItm"><div class="r-top_nav-2" jsl="$t t-t_nYWbCdeK4;$x 0;"><div class="cdr_sep"></div><span data-ved="0CBMQpwU" jsl="$x 1;" data-rtid="top_nav-2" jsaction="r.FRTb2aDIjnc" tabindex="0" id="cdrlnk" class="q">Custom range...</span><div style="display:none" class="cdr_cont top_nav-2--t6VZ5o0Dhc"><div jsl="$x 2;" data-rtid="top_nav-2" jsaction="r.GnxOjRBdeA8" class="cdr_bg"></div><div class="cdr_dlg"><div class="cdr_ttl">Customised date range</div><label for="cdr_min" class="cdr_mml cdr_minl">From</label><label for="cdr_max" class="cdr_mml cdr_maxl">To</label><div jsl="$x 3;" data-rtid="top_nav-2" jsaction="r.GnxOjRBdeA8" class="cdr_cls"></div><div class="cdr_sft"><div class="cdr_highl"></div><form method="get" class="cdr_frm" action="/search"><input type="hidden" value="hotel in udaipur" name="q"><input type="hidden" value="1366" name="biw"><input type="hidden" value="648" name="bih"><input type="hidden" value="lnt" name="source"><input type="hidden" name="tbs" class="ctbs" value="cdr:1,cd_min:x,cd_max:x"><input type="hidden" name="tbm" value=""><input type="text" jsl="$x 4;" data-rtid="top_nav-2" jsaction="focus:r.9Ak-cPSnJQs" tabindex="1" autocomplete="off" class="ktf mini cdr_mm cdr_min" value=""><input type="text" jsl="$x 5;" data-rtid="top_nav-2" jsaction="focus:r.9Ak-cPSnJQs" tabindex="1" autocomplete="off" class="ktf mini cdr_mm cdr_max" value=""><input type="submit" jsaction="tbt.scf" tabindex="1" value="Go" class="ksb mini cdr_go"></form></div></div></div></div></li></ul><span class="_Vxd"></span><div tabindex="0" role="button" aria-haspopup="true" class="hdtb-mn-hd" aria-label="All results"><div class="mn-hd-txt">All results</div><span class="mn-dwn-arw"></span></div><ul class="hdtbU hdtb-mn-c"><li tabindex="0" id="whv_" class="hdtbItm hdtbSel">All results</li><li id="rl_1" class="hdtbItm"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnt&amp;tbs=rl:1&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CBMQpwU" class="q qs">Reading level</a></li><li id="li_1" class="hdtbItm"><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;source=lnt&amp;tbs=li:1&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CBMQpwU" class="q qs">Verbatim</a></li></ul><span class="_Vxd"></span><div tabindex="0" role="button" aria-haspopup="true" class="hdtb-mn-hd" aria-label="Udaipur, Rajasthan"><div class="mn-hd-txt">Udaipur, Rajasthan</div><span class="mn-dwn-arw"></span></div><ul class="hdtbU hdtb-mn-c"><li tabindex="0" class="hdtbItm hdtbSel">Udaipur, Rajasthan</li><li style="display:block" id="set_location_section"><ul><li class="hdtbItm"><a jsaction="loc.dloc" href="#">Use my location</a><a href="/support/websearch/bin/answer.py?answer=179386&amp;hl=en" class="fl"><span style="font-size:11px">Auto-detected</span></a></li><li class="hdtbItm hdtb-loc"><div id="_Zpd"><input type="text" jsaction="keypress:loc.kp;blur:loc.stt;focus:loc.htt" value="Enter location" id="lc-input" style="margin-left:0" class="ktf mini"><input type="submit" jsaction="loc.s" value="Set" style="margin-left:5px" class="ksb mini"></div><div style="display:block;font-size:11px" id="error_section"></div></li></ul></li></ul></div></div></div></div></div><div id="appbar" data-jiis="uc" data-jibp="h" class="appbar" style=""><style>#resultStats{position:absolute;top:0;-moz-transition:all 220ms ease-in-out}.hdtb-ab-o #resultStats{opacity:0;top:13px}</style><div id="extabar"><div style="position:relative" id="topabar"><div id="slim_appbar" class="ab_tnav_wrp"><div id="sbfrm_l" style="visibility: visible;"><div id="resultStats">About 2,11,00,000 results<nobr> (0.40 seconds)&nbsp;</nobr></div></div></div></div><div style="display:none" id="botabar"></div></div><div></div></div><div id="ucs" data-jiis="uc" data-jibp="h" class="mw" style=""></div><div class="mw"><div id="akp" data-jiis="uc" data-jibp="h" style=""></div><div style="clear:both;position:relative;zoom:1" id="rcnt"><div id="ataw" data-jiis="uc" data-jibp="h" style=""><div id="atvcap"></div></div><div id="bcenter" data-jiis="uc" data-jibp="h" style=""><div id="er" style="display:none;visibility:visible"></div><div id="gko-srp-sp"></div><div style="width:0" class="col"></div></div><div style="width:0" class="col"><div id="center_col" style="visibility: visible; padding-top: 0px;"><div id="taw" data-jiis="uc" data-jibp="h" style=""><style>.ads-ad{padding-top:11px;padding-bottom:11px}#center_col ._Ak{position:relative;margin-left:0px;margin-right:0px}#tads{padding-top:2px;padding-bottom:2px;margin-top:-6px;margin-bottom:6px}#tadsb{padding-top:0;padding-bottom:9px;margin-top:-10px;margin-bottom:16px}#center_col .ads-ad{padding-left:8px;padding-right:8px}#rhs ._Ak{margin:5px 0px 32px 16px;padding-top:3px;padding-bottom:0px}#rhs .ads-ad{padding-left:0px;padding-right:0px}#center_col ._Ak{border-bottom:1px solid #ebebeb}#center_col ._hM{margin:12px -17px 0 0;padding:0}#center_col ._hM{font-weight:normal;font-size:13px;float:right}._hM span+span{margin-left:3px}#rhs ._hM{font-weight:normal;font-size:13px;margin:0;padding:0;}.ads-bbl-container{background-color:#fff;border:1px solid rgba(0,0,0,0.2);box-shadow:0 4px 16px rgba(0,0,0,0.2);color:#666;position:absolute;z-index:120}.ads-lb{}.ads-bbl-container.ads-lb{background-color:#2d2d2d;border:1px solid rgba(0,0,0,0.5);color:#adadad;max-height:80px;overflow:auto;z-index:9100}.ads-bbl-triangle{border-left-color:transparent;border-right-color:transparent;border-width:0 9.5px 9.5px 9.5px;width:0px;border-style:solid;border-top-color:transparent;height:0px;position:absolute;z-index:121}.ads-bbl-triangle.ads-lb{z-index:9101}.ads-bbl-triangle-bg{border-bottom-color:#bababa}.ads-bbl-triangle-bg.ads-lb{border-bottom-color:#0e0e0e}.ads-bbl-triangle-fg{border-bottom-color:#fff;margin-left:-9px;margin-top:1px}.ads-lb .ads-bbl-triangle-fg{border-bottom-color:#2d2d2d}.ads-bblc{display:none}._lBb{padding:16px}._zFc{padding-top:12px}._lBb a{text-decoration:none}._lBb a:hover{text-decoration:underline}._NU{background:url(/images/nav_logo195.png);background-position:0 -106px;display:inline-block;height:12px;margin-top:-2px;position:relative;top:2px;width:12px;text-indent:100%;white-space:nowrap;overflow:hidden}.ads-visurl{color:#006621;white-space:nowrap;font-size:14px}#center_col .ads-visurl cite{color:#006621;vertical-align:bottom}.ads-visurl ._mB{margin-right:7px;margin-left:0px}._mB{background-color:#efc439;border-radius:2px;color:#fff;display:inline-block;font-size:12px;padding:0 2px;line-height:14px;vertical-align:baseline}._Ak .action-menu{line-height:0}#center_col ._Ak .action-menu .mn-dwn-arw{border-color:#006621 transparent}#center_col ._Ak .action-menu:hover .mn-dwn-arw{border-color:#00591E transparent}#center_col ._r2b{color:#545454;font-size:small;margin-left:8px;white-space:nowrap;vertical-align:bottom}._mDc{display:-webkit-box;min-height:36px;overflow:hidden;text-overflow:ellipsis;-webkit-box-orient:vertical;-webkit-line-clamp:2}.ads-creative b{color:#545454}._zKf{color:#808080}#center_col #tads{border-bottom-color:transparent}.commercial-unit{background-color:#fff}.commercial-unit ._Sb{background:#fff;color:#666;float:right;font-weight:normal;padding-left:2px;position:relative;vertical-align:top}.commercial-unit-desktop-top{border:1px solid #eee;margin:0 0 14px;padding:1px 7px;width:540px}.commercial-unit-desktop-top h3{font-size:18px}.commercial-unit-desktop-top ._Sb,._u1d ._Sb{font-size:13px;margin-bottom:0;margin-top:8px;padding:0 2px}._IV{left:-1px;margin-left:5px;position:relative;top:-1px;}._HV{padding:16px;color:#666}</style><div></div><div style="padding:0 8px"><div class="med"></div></div><div id="tvcap"><div data-ved="0CBgQGA" id="tads" class="_Ak c"><h2 class="_hM"><span class="r-taw-3" jsl="$x 0;$t t-A6yEzBVJ018;$x 0;"><a data-ved="0CBkQJw" jsl="$x 1;" data-rtid="taw-3" jsaction="r.Wea0zbgTzNI" data-width="230" href="javascript:void(0)" class="ads-bbll"><span title="Why these ads?" class="_NU">Why these ads?</span></a><div data-ved="0CBoQKA" class="ads-bblc"><div class="_lBb"><div>These ads are based on your current search terms.</div><div jsl="$t t-YDfv1cNv3GI;$x 0;" class="_zFc r-taw-4">Visit Google’s <a data-ved="0CBsQKQ" jsl="$x 8;" data-rtid="taw-4" jsaction="r.8Na6VOGeTa8" href="javascript:void();">Ads Settings</a> to learn more or opt out.</div></div></div></span></h2><ol><li data-hveid="28" class="ads-ad"><h3><a id="s0p1" href="http://www.googleadservices.com/pagead/aclk?sa=L&amp;ai=Cn20z_N8PVcirEdWouASGtoAwwu-hkwby1e2awQG4seNCCAAQASgCYOWK6IPUDqABiKqK7QPIAQGpAoF3sIVKPlE-qgQjT9B1pf39jx1FsyHBCOa3geq0LZQOrvw_Tf4iD6rtAvPedDe6BRMIxJD625e-xAIVAr6OCh3QlQABygUAiAYBgAfg1fUSkAcDqAemvhvYBwE&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;ohost=www.google.co.in&amp;cid=5Gi375HIp3STy0oHygEi78JHkdywobzQ21Oq5yKohB77YQ&amp;sig=AOD64_0-VZAyKGh8V8NEmOeC_xDICX3YCA&amp;rct=j&amp;q=&amp;sqi=2&amp;ved=0CB0Q0Qw&amp;adurl=http://www.thelalit.com/the-lalit-laxmi-vilas-palace-udaipur/suitesandrooms-en.html" style="display:none"></a><a class="r-taw-5" jsl="$t t-zxXzjt1d4B0;$x 0;" onmousedown="return google.arwt(this)" id="vs0p1" href="http://www.thelalit.com/the-lalit-laxmi-vilas-palace-udaipur/suitesandrooms-en.html">5 Star Hotel in Udaipur - Free Breakfast &amp; Free WiFi&lrm;</a></h3><div class="ads-visurl"><span class="_mB">Ad</span><cite>www.thelalit.com/5-star-<b>hotel</b>/</cite>&lrm;<div class="action-menu ab_ctl"><a data-ved="0CB4Q7B0" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b324758258" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CB8QqR8" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li data-type="why_this_ad" role="menuitem" class="action-menu-item ab_dropdownitem"><div data-ved="0CCAQgRM" jsaction="am.itemclk" tabindex="-1" role="menuitem" class="action-menu-button">Why this ad?</div></li></ul></div></div><span class="_r2b">011 4444 7474</span></div><div class="ads-creative">Best Rate Guaranteed, Book Today!</div><div class="_knd _Tv">Best Offers&nbsp;·&nbsp;24x7 Customer Service&nbsp;·&nbsp;Get Free WiFi&nbsp;·&nbsp;Book Early &amp; Save 15%</div><div class="_Bu _NEc"><a onmousedown="return rwt(this,'''','''','''','''',''AFQjCNH72xkJUEKG7Bs9uUqrWoTjEW5YnQ'','''',''0CCQQ8h0'','''','''',event)" href="https://plus.google.com/116826386288801459694">The LaLiT Hotels, Palaces &amp; Resorts</a> has 149 followers on Google+</div></li><li data-hveid="37" class="ads-ad"><h3><a id="s0p2" href="http://www.googleadservices.com/pagead/aclk?sa=L&amp;ai=CXSQN_N8PVcirEdWouASGtoAwkbL6ywmx0f6HwgG4seNCCAAQAigCYOWK6IPUDqABl7WQuAPIAQGpAoF3sIVKPlE-qgQgT9A1mIXAjx5Fs2nB4MpBLZh5l4Qa845WjCG8GQej8Ae6BRMIxJD625e-xAIVAr6OCh3QlQABygUAiAYBgAfRyu9HkAcDqAemvhvYBwE&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;ohost=www.google.co.in&amp;cid=5Gi375HIp3STy0oHygEi78JHkdywobzQ21Oq5yKohB77YQ&amp;sig=AOD64_1ZCO1YYWaM9pXjBOn6nqgpfeac9Q&amp;rct=j&amp;q=&amp;sqi=2&amp;ved=0CCYQ0Qw&amp;adurl=http://amantrahotel.com" style="display:none"></a><a class="r-taw-6" jsl="$t t-zxXzjt1d4B0;$x 0;" onmousedown="return google.arwt(this)" id="vs0p2" href="http://amantrahotel.com/">Top 10 Hotel in Udaipur - amantrahotel.com&lrm;</a></h3><div class="ads-visurl"><span class="_mB">Ad</span><cite>www.amantra<b>hotel</b>.com/</cite>&lrm;<div class="action-menu ab_ctl"><a data-ved="0CCcQ7B0" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b553625777" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CCgQqR8" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li data-type="why_this_ad" role="menuitem" class="action-menu-item ab_dropdownitem"><div data-ved="0CCkQgRM" jsaction="am.itemclk" tabindex="-1" role="menuitem" class="action-menu-button">Why this ad?</div></li></ul></div></div></div><div class="ads-creative">Amantra Comfort ranked top choice <b>hotel in Udaipur</b></div></li></ol></div><div class="c commercial-unit commercial-unit-desktop-top"><span class="_Sb">Sponsored<span jsl="$t t-A6yEzBVJ018;$x 0;" class="_IV r-taw-7"><a data-ved="0CCsQzhk" jsl="$x 1;" data-rtid="taw-7" jsaction="r.Wea0zbgTzNI" data-width="380" href="javascript:void(0)" class="ads-bbll"><span title="Why these sponsored results?" class="_NU">Why these sponsored results?</span></a><div data-ved="0CCwQzRk" class="ads-bblc"><div class="_HV">Based on your search query, we think you are trying to find a hotel.  Clicking in this box will show you results from providers that can fulfill your request. Google may be compensated by some of these providers.</div></div></span></span><div style="padding:0" class="no-sep tpo"><div id="_w6b" class="_iMc"><div class="_Nrd"><h3 style="line-height:normal" class="r"><a href="/aclk?sa=L&amp;ai=CaF7q_N8PVcirEdWouASGtoAw6Lif8QGo6ub8IozH4gQIBRABYOWK6IPUDsgBAaoEHE_QhQg445ckfWqiT8A5ZPg_an-1Di_VLjzrswm6BRMIxJD625e-xAIVAr6OCh3QlQABygUAoAYagAfwjuYXkAcDqAemvhvYBwE&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sig=AOD64_3kzYbAqAu5YLKKITxWhT2gLx6-yA&amp;xparam=d%3D2015-04-05%26n%3D1&amp;sqi=2&amp;ved=0CC4QuB0&amp;adurl=http://www.google.co.in/hotels/ad%3Fl%3DUdaipur,%2BIndia%26q%3Dhotel%2Bin%2Budaipur%26gl%3DIN%26cu_link%3D1"><b>Hotels</b> in <b>Udaipur</b> on Google</a></h3><input type="hidden" id="_x6b" value=""><div id="_BId"><div id="_wFb"><div class="_DJ _Dt"><table style="border-spacing:0"><tbody><tr><td style="padding-left:0" class="_bN">Rs.&nbsp;1500</td><td><div style="max-width:150px;width:150px" class="_vFb"><a href="/aclk?sa=L&amp;ai=CaF7q_N8PVcirEdWouASGtoAw6Lif8QGo6ub8IozH4gQIBRABYOWK6IPUDsgBAaoEHE_QhQg445ckfWqiT8A5ZPg_an-1Di_VLjzrswm6BRMIxJD625e-xAIVAr6OCh3QlQABygUAoAYagAfwjuYXkAcDqAemvhvYBwE&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sig=AOD64_3kzYbAqAu5YLKKITxWhT2gLx6-yA&amp;xparam=d%3D2015-04-05%26n%3D1%26h%3D15423467455361941477&amp;sqi=2&amp;ved=0CDAQuR0oAA&amp;adurl=http://www.google.co.in/hotels/ad%3Fl%3DUdaipur,%2BIndia%26q%3Dhotel%2Bin%2Budaipur%26gl%3DIN%26cu_link%3D1" class="_aN">The Tiger Hotel</a></div></td><td class="_KV"><span><span style="color:#666">2-star hotel</span></span></td><td style="padding-right:0" class="_Ca"><span class="_Da"><span style="min-width:20px;display:inline-block;color:#e7711b" class="_Fa">4.1</span><span class="_Ga"><span style="display:inline-block;padding-right:1px;background:url(/images/nav_logo195.png);background-position:-110px -230px;height:13px;width:13px"></span><span style="display:inline-block;padding-right:1px;background:url(/images/nav_logo195.png);background-position:-110px -230px;height:13px;width:13px"></span><span style="display:inline-block;padding-right:1px;background:url(/images/nav_logo195.png);background-position:-110px -230px;height:13px;width:13px"></span><span style="display:inline-block;padding-right:1px;background:url(/images/nav_logo195.png);background-position:-110px -230px;height:13px;width:13px"></span><span style="display:inline-block;padding-right:1px;background:url(/images/nav_logo195.png);background-position:-68px -230px;height:13px;width:13px"></span></span></span><span style="color:#c6c6c6">(6)</span></td></tr><tr><td style="padding-left:0" class="_bN">Rs.&nbsp;7103</td><td><div style="max-width:150px;width:150px" class="_vFb"><a href="/aclk?sa=L&amp;ai=CaF7q_N8PVcirEdWouASGtoAw6Lif8QGo6ub8IozH4gQIBRABYOWK6IPUDsgBAaoEHE_QhQg445ckfWqiT8A5ZPg_an-1Di_VLjzrswm6BRMIxJD625e-xAIVAr6OCh3QlQABygUAoAYagAfwjuYXkAcDqAemvhvYBwE&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sig=AOD64_3kzYbAqAu5YLKKITxWhT2gLx6-yA&amp;xparam=d%3D2015-04-05%26n%3D1%26h%3D2622470239510700696&amp;sqi=2&amp;ved=0CDEQuR0oAQ&amp;adurl=http://www.google.co.in/hotels/ad%3Fl%3DUdaipur,%2BIndia%26q%3Dhotel%2Bin%2Budaipur%26gl%3DIN%26cu_link%3D1" class="_aN">The Lalit Laxmi Vilas Palace Udaipur</a></div></td><td class="_KV"><span><span style="color:#666">5-star hotel</span></span></td><td style="padding-right:0" class="_Ca"><span class="_Da"><span style="min-width:20px;display:inline-block;color:#e7711b" class="_Fa">4.5</span><span class="_Ga"><span style="display:inline-block;padding-right:1px;background:url(/images/nav_logo195.png);background-position:-110px -230px;height:13px;width:13px"></span><span style="display:inline-block;padding-right:1px;background:url(/images/nav_logo195.png);background-position:-110px -230px;height:13px;width:13px"></span><span style="display:inline-block;padding-right:1px;background:url(/images/nav_logo195.png);background-position:-110px -230px;height:13px;width:13px"></span><span style="display:inline-block;padding-right:1px;background:url(/images/nav_logo195.png);background-position:-110px -230px;height:13px;width:13px"></span><span style="display:inline-block;padding-right:1px;background:url(/images/nav_logo195.png);background-position:-82px -230px;height:13px;width:13px"></span></span></span><span style="color:#c6c6c6">(11)</span></td></tr><tr><td style="padding-left:0" class="_bN">Rs.&nbsp;875</td><td><div style="max-width:150px;width:150px" class="_vFb"><a href="/aclk?sa=L&amp;ai=CaF7q_N8PVcirEdWouASGtoAw6Lif8QGo6ub8IozH4gQIBRABYOWK6IPUDsgBAaoEHE_QhQg445ckfWqiT8A5ZPg_an-1Di_VLjzrswm6BRMIxJD625e-xAIVAr6OCh3QlQABygUAoAYagAfwjuYXkAcDqAemvhvYBwE&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sig=AOD64_3kzYbAqAu5YLKKITxWhT2gLx6-yA&amp;xparam=d%3D2015-04-05%26n%3D1%26h%3D2753972407685064923&amp;sqi=2&amp;ved=0CDIQuR0oAg&amp;adurl=http://www.google.co.in/hotels/ad%3Fl%3DUdaipur,%2BIndia%26q%3Dhotel%2Bin%2Budaipur%26gl%3DIN%26cu_link%3D1" class="_aN">Hotel Minerwa</a></div></td><td class="_KV"><span><span style="color:#666">3-star hotel</span></span></td><td style="padding-right:0" class="_Ca"></td></tr></tbody></table></div></div></div></div></div></div></div></div><form class="r-taw-8" jsl="$t t-y3Vq91bkxp8;$x 0;" method="post" action="/settings/ads/preferences"><input type="hidden" name="token" value="ADvV1Id8FmjiK_ajtqYCRJS6-HyQ7Rg9pDoxNDI3MTAzNzQwMjMz"><input type="hidden" name="reasons" value="ChBob3RlbCBpbiB1ZGFpcHVyGhQIARABIg4I2tHV1sMBELix40IgABoUCAEQAiIOCMnl19vBARC4seNCIAAaFwgBEIGABCIPCMfel_TTARDaqri8ASABGhYIARCCgAQiDgikzYOE6AEQuLHjQiABGhcIAhCDgAQiDwjNmJmm2QEQwJ_Io1YgARonCAEQhIAEIh8IrKul7NcBELix40IgAToHKAEyAzEwMDoGKAIyAjQ1GhcIAhCFgAQiDwip5ZKB3AEQwJ_Io1YgARoYCAEQhoAEIhAIgpv1-NIBEMrv9KKXAyABGhcIARCHgAQiDwiT8umN3QEQ2fCe8SYgARoWCAEQiIAEIg4IwamU-eIBEMCm5jUgASDEkPrbl77EAioQd3d3Lmdvb2dsZS5jby5pbjLsAWh0dHBzOi8vd3d3Lmdvb2dsZS5jby5pbi9zZWFyY2g_c2NsaWVudD1wc3ktYWImc2l0ZT0mc291cmNlPWhwJnE9aG90ZWwraW4rdWRhaXB1ciZvcT0mZ3NfbD0mcGJ4PTEmYmF2PW9uLjIsb3IuJmJ2bT1idi44ODUyODM3MyxkLmMyRSZmcD1lMzJlMGE3ZjAxNmZhMmNmJmJpdz0xMzY2JmJpaD02NDgmZHByPTEmcGY9cCZ0Y2g9MSZlY2g9MjEmcHNpPTJOOFBWWl9EUEphUXVBVHB6WUhnQmcuMTQyNzEwMzgxMTk0My4xOjZQUkVGPUlEPTAwMDAwMDAwMDAwMDAwMDA6VT0wMDAwMDAwMDAwMDAwMDAwOkZGPTA6TEQ9ZW4="><input type="hidden" name="hl" value="en-IN"></form></div><div role="main" id="res" class="med"><div id="topstuff" data-jiis="uc" data-jibp="h" style=""><style>.spell{font-size:18px}.spell_orig{font-size:15px}#mss p{margin:0;padding-top:5px}</style><div style="display:none" id="msg_box" class="_cy"><p class="card-section ps-sru"><span><span id="srfm" class="spell"></span>&nbsp;<a id="srfl" class="spell"></a><br></span><span id="sif"><span id="sifm" class="spell_orig"></span>&nbsp;<a id="sifl" class="spell_orig"></a><br></span></p></div></div><div id="search" data-jiis="uc" data-jibp="h" style=""><style>._xse{display:inline-block;width:100%}.intrlu{padding-bottom:8px;}.rtng{color:#e7711b;white-space:nowrap}.star{background-repeat:repeat-x;display:inline-block;overflow:hidden;position:relative;top:1px}.star span{background-repeat:repeat-x;display:block}.star-s{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAANCAQAAAAz1Zf0AAAAWklEQVR4AY3O0QbDQBCG0UNYQi0hhBJqr8Iy7/94vewYlp65/Ay//4WlLnQLt3BbeIRH5jBFPVMHmlHS0CRnSqdiT3GH1edb8RGmoy4GwrBhM4Qmebn8XDrwBW7xChrojlOZAAAAAElFTkSuQmCC)}.star-s span{background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAANCAYAAACZ3F9/AAAAcklEQVQoz2NgoDZ4Xij9nxxNASCNIJpUjQugGheQqvEBVOMDfIoSgPg9VCEh/B7F+UCOAhDvJ6AJJK+Ay/Z8HJryCfnNAIdGA0IaC3BonEBI4wakQIgH4vsEQxeqERYIAlC+AFKg4QwYByCuxyFXj56KAEHuodjGnEtTAAAAAElFTkSuQmCC)}.star-s,.star-s span{background-size:14px 13px;height:13px;width:69px}._eF ._aD{color:inherit}._aD{color:#878787}.review-dialog ::-webkit-scrollbar{width:9px}.review-dialog ::-webkit-scrollbar-track{background:none}.review-dialog ::-webkit-scrollbar-thumb{background-color:#cbcbcb;border:1px solid #b7b7b7;border-radius:0;border-right:0}._wqf{cursor:pointer;position:absolute;z-index:9002}._SWe,._xXe{bottom:0;cursor:pointer;left:0;position:fixed;right:0;text-align:center;top:0;z-index:9000}._SWe:after,._xXe:after{content:'''';display:inline-block;height:100%;vertical-align:middle}._yXe{cursor:default;display:inline-block;min-height:10px;min-width:10px;padding:0;position:relative;text-align:left;z-index:9001;vertical-align:middle}._pYe{background-image:url(//ssl.gstatic.com/gb/images/spinner_32.gif);left:50%;position:fixed;top:50%}._R5e{background-color:rgba(0,0,0,0.9)}._S5e{background-color:rgba(245,245,245,0.95)}._Arf{color:black}._Brf{color:white}._wqf{background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADQAAAAzAgMAAAClE8PAAAAABGdBTUEAALGPC/xhBQAAAAlQTFRFVVVVVVVVVVVVMVQQFQAAAAJ0Uk5TAH+2KaGVAAAAqElEQVQoU32SsRVDIQhFr0UcwmnMBn8Op7HKBDYyZQpRfCliocLhCsIDXc+5vSCNY5VKnsdqnWzVjWSdZN2tbBXaBsvcG7h7gwvZoHsddMIPd66QDazzVNEGV6IyA1tBUWCyu3jaCAzKDAyyvQ8GyT6BQbPAoFhgkC/s19JIeUUzaHatTKrWH+lvtRPSJe2gdlc7L1PRiek0ddKiAlWIqkeVpapTRf5ZX+r5VzHujtLrAAAAAElFTkSuQmCC) no-repeat;background-size:24px 24px;height:24px;opacity:.78;right:32px;top:32px;width:24px}._wqf:hover{opacity:1}._pYe{background-size:20px 20px;height:20px;margin-left:-10px;margin-top:-10px;width:20px}</style><div data-ved="0CDQQGg"><!--a--><h2 class="hd">Search Results</h2><div id="ires" data-async-context="query:hotel%20in%20udaipur"><ol id="rso" eid="_N8PVcSiDoL8ugTQq4II"><div data-ved="0CDUQ8UE" id="akp_target"></div><div class="srg"><li class="g"><!--m--><div data-hveid="55" class="rc"><h3 class="r"><a onmousedown="return rwt(this,'''','''','''',''1'',''AFQjCNHVatNWPLmLP8Bo6vTwriJBGoMl0A'','''',''0CDgQFjAA'','''','''',event)" href="http://www.tripadvisor.in/Hotels-g297672-Udaipur_Rajasthan-Hotels.html">30 Best Udaipur Hotels on TripAdvisor - Prices &amp; Reviews ...</a></h3><div class="s"><div><div style="white-space:nowrap" class="f kv _SWb"><cite class="_Rm">www.tripadvisor.in/<b>Hotels</b>-g297672-<b>Udaipur</b>_Rajasthan-<b>Hotels</b>.html</cite><div class="action-menu ab_ctl"><a data-ved="0CDkQ7B0wAA" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b0" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CDoQqR8wAA" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li role="menuitem" class="action-menu-item ab_dropdownitem"><a onmousedown="return rwt(this,'''','''','''',''1'',''AFQjCNEM4t1D4VxrOiMFdRRJ_L1AED5q4Q'','''',''0CDsQIDAA'','''','''',event)" href="http://webcache.googleusercontent.com/search?q=cache:0rkg5fD-GtkJ:www.tripadvisor.in/Hotels-g297672-Udaipur_Rajasthan-Hotels.html+&amp;cd=1&amp;hl=en&amp;ct=clnk&amp;gl=in" class="fl">Cached</a></li><li role="menuitem" class="action-menu-item ab_dropdownitem"><a href="/search?biw=1366&amp;bih=648&amp;q=related:www.tripadvisor.in/Hotels-g297672-Udaipur_Rajasthan-Hotels.html+hotel+in+udaipur&amp;tbo=1&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CDwQHzAA" class="fl">Similar</a></li></ul></div></div></div><div class="f slp"></div><span class="st">Best Udaipur Hotels on TripAdvisor: Find 20655 traveller reviews, 12865 candid photos, and prices for 119 <em>hotels in Udaipur</em>, India.</span><div class="osl">&lrm;<a onmousedown="return rwt(this,'''','''','''',''1'',''AFQjCNEkVeq4fWBAFKwWuOVLf-R2zEPimQ'','''',''0CD4Q0gIoADAA'','''','''',event)" href="http://www.tripadvisor.in/Hotel_Review-g297672-d545796-Reviews-Jaiwana_Haveli-Udaipur_Rajasthan.html" class="fl">Jaiwana Haveli</a> -&nbsp;&lrm;<a onmousedown="return rwt(this,'''','''','''',''1'',''AFQjCNEvXHtgxi10cngURlWeUHNHgPvx1A'','''',''0CD8Q0gIoATAA'','''','''',event)" href="http://www.tripadvisor.in/Hotel_Review-g297672-d3683087-Reviews-Boheda_Palace-Udaipur_Rajasthan.html" class="fl">Boheda Palace</a> -&nbsp;&lrm;<a onmousedown="return rwt(this,'''','''','''',''1'',''AFQjCNFhPSw4ScZ_vNnqIluDp-HoKKK5qA'','''',''0CEAQ0gIoAjAA'','''','''',event)" href="http://www.tripadvisor.in/Hotel_Review-g297672-d302377-Reviews-Taj_Lake_Palace_Udaipur-Udaipur_Rajasthan.html" class="fl">Taj Lake Palace Udaipur</a> -&nbsp;&lrm;<a onmousedown="return rwt(this,'''','''','''',''1'',''AFQjCNFGDidk3H2zOThT4p2NeuE2R09_mw'','''',''0CEEQ0gIoAzAA'','''','''',event)" href="http://www.tripadvisor.in/Hotel_Review-g297672-d735414-Reviews-Rajputana_Udaipur_A_Justa_Resort-Udaipur_Rajasthan.html" class="fl">Rajputana Udaipur</a></div></div></div></div><!--n--></li><li class="g"><!--m--><div data-hveid="66" class="rc"><h3 class="r"><a onmousedown="return rwt(this,'''','''','''',''2'',''AFQjCNECKoBJPMLGvhbbt3MTHhM85hEVkA'','''',''0CEMQFjAB'','''','''',event)" href="http://www.cleartrip.com/hotels/india/udaipur/">Hotels in Udaipur | Udaipur Hotel Booking | Book Budget ...</a></h3><div class="s"><div><div style="white-space:nowrap" class="f kv _SWb"><cite class="_Rm">www.cleartrip.com/<b>hotels</b>/india/<b>udaipur</b>/</cite><div class="action-menu ab_ctl"><a data-ved="0CEQQ7B0wAQ" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b1" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CEUQqR8wAQ" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li role="menuitem" class="action-menu-item ab_dropdownitem"><a onmousedown="return rwt(this,'''','''','''',''2'',''AFQjCNH4JMCdJ9MUqg9-ZRtNtiOnTD2kkA'','''',''0CEYQIDAB'','''','''',event)" href="http://webcache.googleusercontent.com/search?q=cache:ULY_561GRC8J:www.cleartrip.com/hotels/india/udaipur/+&amp;cd=2&amp;hl=en&amp;ct=clnk&amp;gl=in" class="fl">Cached</a></li><li role="menuitem" class="action-menu-item ab_dropdownitem"><a href="/search?biw=1366&amp;bih=648&amp;q=related:www.cleartrip.com/hotels/india/udaipur/+hotel+in+udaipur&amp;tbo=1&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CEcQHzAB" class="fl">Similar</a></li></ul></div></div></div><div class="f slp"></div><span class="st"><em>Hotels in Udaipur</em> India - Find Budget, Cheap and Luxury Udaipur hotels and resorts at Cleartrip.com. Find best offers and deals on <em>hotels in Udaipur</em>.</span><div class="osl">&lrm;<a onmousedown="return rwt(this,'''','''','''',''2'',''AFQjCNE3DQdRevnHRXczxcGwasknADb2SQ'','''',''0CEkQ0gIoADAB'','''','''',event)" href="http://www.cleartrip.com/hotels/india/udaipur/?p=2" class="fl">Hotels in Udaipur</a> -&nbsp;&lrm;<a onmousedown="return rwt(this,'''','''','''',''2'',''AFQjCNGckd6dggUFTimo1mco0IQPbJws4w'','''',''0CEoQ0gIoATAB'','''','''',event)" href="http://www.cleartrip.com/hotels/india/udaipur/stars/3/" class="fl">3 Star Hotels in Udaipur</a> -&nbsp;&lrm;<a onmousedown="return rwt(this,'''','''','''',''2'',''AFQjCNELGZqTlNcgUP2RyhEt4iPdGu79ig'','''',''0CEsQ0gIoAjAB'','''','''',event)" href="http://www.cleartrip.com/hotels/india/udaipur/stars/5/" class="fl">5 Star Hotels in Udaipur</a> -&nbsp;&lrm;<a onmousedown="return rwt(this,'''','''','''',''2'',''AFQjCNHWgyj6llhQQDGcYNAvQJKa5fbS6A'','''',''0CEwQ0gIoAzAB'','''','''',event)" href="http://www.cleartrip.com/hotels/india/udaipur/locality/bhuwana/" class="fl">Bhuwana 5</a></div></div></div></div><!--n--></li><li class="g"><!--m--><div data-hveid="77" class="rc"><h3 class="r"><a onmousedown="return rwt(this,'''','''','''',''3'',''AFQjCNHWjveCfKRiHT-Pn-LcdtA9j0fPTw'','''',''0CE4QFjAC'','''','''',event)" href="http://www.makemytrip.com/hotels/udaipur-hotels.html">Hotels in Udaipur - MakeMyTrip</a></h3><div class="s"><div><div style="white-space:nowrap" class="f kv _SWb"><cite class="_Rm">www.makemytrip.com/<b>hotels</b>/<b>udaipur</b>-<b>hotels</b>.html</cite><div class="action-menu ab_ctl"><a data-ved="0CE8Q7B0wAg" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b2" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CFAQqR8wAg" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li role="menuitem" class="action-menu-item ab_dropdownitem"><a onmousedown="return rwt(this,'''','''','''',''3'',''AFQjCNFq2Vns80UC9YHVM3CUP4cEnrTJ6A'','''',''0CFEQIDAC'','''','''',event)" href="http://webcache.googleusercontent.com/search?q=cache:rOFMz14aMLQJ:www.makemytrip.com/hotels/udaipur-hotels.html+&amp;cd=3&amp;hl=en&amp;ct=clnk&amp;gl=in" class="fl">Cached</a></li><li role="menuitem" class="action-menu-item ab_dropdownitem"><a href="/search?biw=1366&amp;bih=648&amp;q=related:www.makemytrip.com/hotels/udaipur-hotels.html+hotel+in+udaipur&amp;tbo=1&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CFIQHzAC" class="fl">Similar</a></li></ul></div></div></div><div class="f slp"></div><span class="st"><em>Hotels in Udaipur</em>, India: Book Budget, Star &amp; Luxury Udaipur hotels &amp; Resorts at MakeMyTrip. Best Accommodation offers on <em>Hotels in Udaipur</em>. Check Udaipur&nbsp;...</span></div></div></div><!--n--></li></div><hr class="rgsep"><div data-hveid="83"><li id="lclbox" data-akp-stick="" data-akp-oq="hotel in udaipur" class="g no-sep _uDf"><div style="line-height:normal;margin-top:7px"><div class="intrlu"><div sig="xkv" data-extra="ludocid=2444188424022556314&amp;lumarker=A" data-ri="3" data-cid="2444188424022556314" class="_xse vsc vscl vslru">  <div data-ved="0CFUQkgowAw">  <div data-ved="0CFYQkQowAw"> </div>   </div>   <!--m--><div style="padding-top:2px;line-height:18px" class="g"><div style="width:318px;float:left"><h3 style="line-height:normal" class="r"><a onmousedown="return rwt(this,'''','''','''',''4'',''AFQjCNFp2ZjRvbgQLDcmD3XenfZpy8p3Mg'','''',''0CFcQoAIwAw'','''','''',event)" href="http://www.oberoihotels.com/hotels-in-udaipur/" class="l">The Oberoi Udaivilas</a></h3><span><cite class="_Rm">www.oberoi<b>hotel</b>s.com</cite></span><br><div style="display:inline-block;margin-right:5px"><span aria-hidden="true" class="rtng" style="margin-right:5px">4.6</span><span aria-label="Rated4.6out of5" class="star star-s"><span style="width:63px"></span></span></div><a data-ved="0CFoQiSswAw" jsl="$t t-SQvYJToREhU;$x 0;" data-rtid="search-9" jsaction="r.BMsjWllwe1s" data-async-trigger="reviewDialog" data-fid="0x396ccf804ea9e2f3:0x21eb806bf9fc7e9a" href="javascript:void(0)" class="fl r-search-9"><span><span style="white-space:nowrap">36 Google reviews</span></span></a>&nbsp;·&nbsp;<a onmousedown="return rwt(this,'''','''','''',''4'',''AFQjCNHoqEMenGX5xWHXd86kDKbOWP4diQ'','''',''0CFsQwh8wAw'','''','''',event)" href="https://plus.google.com/110841364625697665709/?hl=en&amp;socfid=web:lu:unknown:pluspage&amp;socpid=1" class="fl">Google+ page</a> - <span class="r-search-10" jsl="$t t-9yGOL8ZmD70;$x 0;"><a data-ved="0CFwQ1QkwAw" jsl="$x 1;" data-rtid="search-10" jsaction="r.v5XlE647GEg" id="hu-18222597225991982926" class="fl nj _uTc search-10-3sPkwCJYygM" href="javascript:void(0);">Rs.&nbsp;36,099<small>?</small><div data-ved="0CF0Q1wkwAw" class="hppc"><div data-ved="0CF4Q1gkwAw" class="hpplc"></div></div></a></span></div><div style="margin-left:26px;width:22px;float:left"><span style="height:38px;padding:0;width:22px"><a style="border:none;display:block;overflow:hidden;height:30px;width:16px" class="l" tabindex="0" href="/maps/place/hotel+in+udaipur/@24.577698,73.671397,15z/data=!4m2!3m1!1s0x0:0x21eb806bf9fc7e9a?sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CF8QrwswAw"><span style="display:block;background:url(/images/mappins_grey.png) no-repeat;background-position:0 -35px;background-size:;height:30px;width:16px" class="lupin"></span></a></span></div><div style="width:146px;float:left;color:#808080;line-height:18px"><span>Haridasji Ki Magri, Near Mallatalai Chowraha</span><br><span>Udaipur, Rajasthan</span><br><nobr><span>0294 243 3300</span></nobr></div><!--n--></div><div class="vspib" aria-label="Result details" role="button" tabindex="0"><div class="vspii"><div class="vspiic"></div></div></div></div></div><div class="intrlu"><div sig="R7C" data-extra="ludocid=2812662043869934659&amp;lumarker=B" data-ri="4" data-cid="2812662043869934659" class="_xse vsc vscl vslru">  <div data-ved="0CGIQkgowBA">  <div data-ved="0CGMQkQowBA"> </div>   </div>   <!--m--><div style="padding-top:2px;line-height:18px" class="g"><div style="width:318px;float:left"><h3 style="line-height:normal" class="r"><a onmousedown="return rwt(this,'''','''','''',''5'',''AFQjCNHy1z-CdzjHN1i8OWbHKaY8Lf11xg'','''',''0CGQQoAIwBA'','''','''',event)" href="http://www.tajhotels.com/" class="l">Taj Lake Palace</a></h3><span><cite class="_Rm">www.taj<b>hotel</b>s.com</cite></span><br><div style="display:inline-block;margin-right:5px"><span aria-hidden="true" class="rtng" style="margin-right:5px">4.4</span><span aria-label="Rated4.4out of5" class="star star-s"><span style="width:63px"></span></span></div><a data-ved="0CGcQiSswBA" jsl="$t t-SQvYJToREhU;$x 0;" data-rtid="search-11" jsaction="r.BMsjWllwe1s" data-async-trigger="reviewDialog" data-fid="0x3967efecf87f0b8b:0x2708953a0e177443" href="javascript:void(0)" class="fl r-search-11"><span><span style="white-space:nowrap">100 Google reviews</span></span></a> - <span class="r-search-12" jsl="$t t-9yGOL8ZmD70;$x 0;"><a data-ved="0CGgQ1QkwBA" jsl="$x 1;" data-rtid="search-12" jsaction="r.v5XlE647GEg" id="hu-5688668178641500843" class="fl nj _uTc search-12-3sPkwCJYygM" href="javascript:void(0);">Rs.&nbsp;38,629<small>?</small><div data-ved="0CGkQ1wkwBA" class="hppc"><div data-ved="0CGoQ1gkwBA" class="hpplc"></div></div></a></span></div><div style="margin-left:26px;width:22px;float:left"><span style="height:38px;padding:0;width:22px"><a style="border:none;display:block;overflow:hidden;height:30px;width:16px" class="l" tabindex="0" href="/maps/place/hotel+in+udaipur/@24.575363,73.679936,15z/data=!4m2!3m1!1s0x0:0x2708953a0e177443?sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CGsQrwswBA"><span style="display:block;background:url(/images/mappins_grey.png) no-repeat;background-position:0 -70px;background-size:;height:30px;width:16px" class="lupin"></span></a></span></div><div style="width:146px;float:left;color:#808080;line-height:18px"><span>Udaipur, Rajasthan</span><br><nobr><span>0294 242 8800</span></nobr></div><!--n--></div><div class="vspib" aria-label="Result details" role="button" tabindex="0"><div class="vspii"><div class="vspiic"></div></div></div></div></div><div class="intrlu"><div sig="tA3" data-extra="ludocid=13691445501602073001&amp;lumarker=C" data-ri="5" data-cid="13691445501602073001" class="_xse vsc vscl vslru">  <div data-ved="0CG4QkgowBQ">  <div data-ved="0CG8QkQowBQ"> </div>   </div>   <!--m--><div style="padding-top:2px;line-height:18px" class="g"><div style="width:318px;float:left"><h3 style="line-height:normal" class="r"><a onmousedown="return rwt(this,'''','''','''',''6'',''AFQjCNEGNrV3oQPgX73_F61XqRgfoyFf3w'','''',''0CHAQoAIwBQ'','''','''',event)" href="https://www.theleela.com/hotel-udaipur.html" class="l">The Leela Palace</a></h3><span><cite class="_Rm">www.theleela.com</cite></span><br><div style="display:inline-block;margin-right:5px"><span aria-hidden="true" class="rtng" style="margin-right:5px">4.6</span><span aria-label="Rated4.6out of5" class="star star-s"><span style="width:63px"></span></span></div><a data-ved="0CHMQiSswBQ" jsl="$t t-SQvYJToREhU;$x 0;" data-rtid="search-13" jsaction="r.BMsjWllwe1s" data-async-trigger="reviewDialog" data-fid="0x3967e55d8714f8bd:0xbe01c924b09c89a9" href="javascript:void(0)" class="fl r-search-13"><span><span style="white-space:nowrap">37 Google reviews</span></span></a>&nbsp;·&nbsp;<a onmousedown="return rwt(this,'''','''','''',''6'',''AFQjCNF14eTIHZLZZ6qIDP_XiLe3Ao98kw'','''',''0CHQQwh8wBQ'','''','''',event)" href="https://plus.google.com/114004211905091160356/?hl=en&amp;socfid=web:lu:unknown:pluspage&amp;socpid=1" class="fl">Google+ page</a> - <span class="r-search-14" jsl="$t t-9yGOL8ZmD70;$x 0;"><a data-ved="0CHUQ1QkwBQ" jsl="$x 1;" data-rtid="search-14" jsaction="r.v5XlE647GEg" id="hu-9608916247815826996" class="fl nj _uTc search-14-3sPkwCJYygM" href="javascript:void(0);">Rs.&nbsp;31,149<small>?</small><div data-ved="0CHYQ1wkwBQ" class="hppc"><div data-ved="0CHcQ1gkwBQ" class="hpplc"></div></div></a></span></div><div style="margin-left:26px;width:22px;float:left"><span style="height:38px;padding:0;width:22px"><a style="border:none;display:block;overflow:hidden;height:30px;width:16px" class="l" tabindex="0" href="/maps/place/hotel+in+udaipur/@24.578427,73.677058,15z/data=!4m2!3m1!1s0x0:0xbe01c924b09c89a9?sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CHgQrwswBQ"><span style="display:block;background:url(/images/mappins_grey.png) no-repeat;background-position:0 -105px;background-size:;height:30px;width:16px" class="lupin"></span></a></span></div><div style="width:146px;float:left;color:#808080;line-height:18px"><span>Lake Pichola</span><br><span>Udaipur, Rajasthan</span><br><nobr><span>0294 670 1234</span></nobr></div><!--n--></div><div class="vspib" aria-label="Result details" role="button" tabindex="0"><div class="vspii"><div class="vspiic"></div></div></div></div></div><div class="intrlu"><div sig="pTM" data-extra="ludocid=16183137597538285113&amp;lumarker=D" data-ri="6" data-cid="16183137597538285113" class="_xse vsc vscl vslru">  <div data-ved="0CHsQkgowBg">  <div data-ved="0CHwQkQowBg"> </div>   </div>   <!--m--><div style="padding-top:2px;line-height:18px" class="g"><div style="width:318px;float:left"><h3 style="line-height:normal" class="r"><a onmousedown="return rwt(this,'''','''','''',''7'',''AFQjCNHmP4S-Sg9PFhiXEWQd_-mtmheStA'','''',''0CH0QoAIwBg'','''','''',event)" href="http://www.jaiwanahaveli.com/" class="l">Jaiwana Haveli</a></h3><span><cite class="_Rm">www.jaiwanahaveli.com</cite></span><br><div style="display:inline-block;margin-right:5px"><span aria-hidden="true" class="rtng" style="margin-right:5px">4.1</span><span aria-label="Rated4.1out of5" class="star star-s"><span style="width:56px"></span></span></div><a data-ved="0CIABEIkrMAY" jsl="$t t-SQvYJToREhU;$x 0;" data-rtid="search-15" jsaction="r.BMsjWllwe1s" data-async-trigger="reviewDialog" data-fid="0x3967ef878151935b:0xe0960de72c89b639" href="javascript:void(0)" class="fl r-search-15"><span><span style="white-space:nowrap">6 Google reviews</span></span></a> - <span class="r-search-16" jsl="$t t-9yGOL8ZmD70;$x 0;"><a data-ved="0CIEBENUJMAY" jsl="$x 1;" data-rtid="search-16" jsaction="r.v5XlE647GEg" id="hu-11036616001797658676" class="fl nj _uTc search-16-3sPkwCJYygM" href="javascript:void(0);">Rs.&nbsp;3454<small>?</small><div data-ved="0CIIBENcJMAY" class="hppc"><div data-ved="0CIMBENYJMAY" class="hpplc"></div></div></a></span></div><div style="margin-left:26px;width:22px;float:left"><span style="height:38px;padding:0;width:22px"><a style="border:none;display:block;overflow:hidden;height:30px;width:16px" class="l" tabindex="0" href="/maps/place/hotel+in+udaipur/@24.579219,73.682584,15z/data=!4m2!3m1!1s0x0:0xe0960de72c89b639?sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CIQBEK8LMAY"><span style="display:block;background:url(/images/mappins_grey.png) no-repeat;background-position:0 -140px;background-size:;height:30px;width:16px" class="lupin"></span></a></span></div><div style="width:146px;float:left;color:#808080;line-height:18px"><span>14, Lal Ghat Road, Near Jagdish Chowk</span><br><span>Udaipur, Rajasthan</span><br><nobr><span>098290 05859</span></nobr></div><!--n--></div><div class="vspib" aria-label="Result details" role="button" tabindex="0"><div class="vspii"><div class="vspiic"></div></div></div></div></div><div class="intrlu"><div sig="tRE" data-extra="ludocid=7289077235145864026&amp;lumarker=E" data-ri="7" data-cid="7289077235145864026" class="_xse vsc vscl vslru">  <div data-ved="0CIcBEJIKMAc">  <div data-ved="0CIgBEJEKMAc"> </div>   </div>   <!--m--><div style="padding-top:2px;line-height:18px" class="g"><div style="width:318px;float:left"><h3 style="line-height:normal" class="r"><a onmousedown="return rwt(this,'''','''','''',''8'',''AFQjCNHkXbP2XUlk7aO8qpQ6t3AGafEeIA'','''',''0CIkBEKACMAc'','''','''',event)" href="http://www.udaipurhotelhilltoppalace.com/" class="l">Hotel Hilltop Palace</a></h3><span><cite class="_Rm">www.<b>udaipur</b><b>hotel</b>hilltoppalace.com</cite></span><br><div style="display:inline-block;margin-right:5px"><span aria-hidden="true" class="rtng" style="margin-right:5px">3.7</span><span aria-label="Rated3.7out of5" class="star star-s"><span style="width:49px"></span></span></div><a data-ved="0CIwBEIkrMAc" jsl="$t t-SQvYJToREhU;$x 0;" data-rtid="search-17" jsaction="r.BMsjWllwe1s" data-async-trigger="reviewDialog" data-fid="0x3967ef878151b84b:0x652801204d41735a" href="javascript:void(0)" class="fl r-search-17"><span><span style="white-space:nowrap">32 Google reviews</span></span></a>&nbsp;·&nbsp;<a onmousedown="return rwt(this,'''','''','''',''8'',''AFQjCNHSzQKaO3hvB9F2RhIVB-gB2qoGBw'','''',''0CI0BEMIfMAc'','''','''',event)" href="https://plus.google.com/101631592214019775408/?hl=en&amp;socfid=web:lu:unknown:pluspage&amp;socpid=1" class="fl">Google+ page</a> - <span class="r-search-18" jsl="$t t-9yGOL8ZmD70;$x 0;"><a data-ved="0CI4BENUJMAc" jsl="$x 1;" data-rtid="search-18" jsaction="r.v5XlE647GEg" id="hu-4736755651684622536" class="fl nj _uTc search-18-3sPkwCJYygM" href="javascript:void(0);">Rs.&nbsp;3000<small>?</small><div data-ved="0CI8BENcJMAc" class="hppc"><div data-ved="0CJABENYJMAc" class="hpplc"></div></div></a></span></div><div style="margin-left:26px;width:22px;float:left"><span style="height:38px;padding:0;width:22px"><a style="border:none;display:block;overflow:hidden;height:30px;width:16px" class="l" tabindex="0" href="/maps/place/hotel+in+udaipur/@24.590627,73.681748,15z/data=!4m2!3m1!1s0x0:0x652801204d41735a?sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CJEBEK8LMAc"><span style="display:block;background:url(/images/mappins_grey.png) no-repeat;background-position:0 -175px;background-size:;height:30px;width:16px" class="lupin"></span></a></span></div><div style="width:146px;float:left;color:#808080;line-height:18px"><span>5 Ambavgarh, Fatehsagar</span><br><span>Udaipur, Rajasthan</span><br><nobr><span>0294 243 2245</span></nobr></div><!--n--></div><div class="vspib" aria-label="Result details" role="button" tabindex="0"><div class="vspii"><div class="vspiic"></div></div></div></div></div><div class="intrlu"><div sig="JKs" data-extra="ludocid=13821642921912103343&amp;lumarker=F" data-ri="8" data-cid="13821642921912103343" class="_xse vsc vscl vslru">  <div data-ved="0CJQBEJIKMAg">  <div data-ved="0CJUBEJEKMAg"> </div>   </div>   <!--m--><div style="padding-top:2px;line-height:18px" class="g"><div style="width:318px;float:left"><h3 style="line-height:normal" class="r"><a onmousedown="return rwt(this,'''','''','''',''9'',''AFQjCNGBPbJK2T3KiQOI4h02yVoPOZE6ZA'','''',''0CJYBEKACMAg'','''','''',event)" href="http://www.anjanihotel.com/" class="l">Anjani Hotel</a></h3><span><cite class="_Rm">www.anjani<b>hotel</b>.com</cite></span><br><div style="display:inline-block;margin-right:5px"><span aria-hidden="true" class="rtng" style="margin-right:5px">3.3</span><span aria-label="Rated3.3out of5" class="star star-s"><span style="width:49px"></span></span></div><a data-ved="0CJkBEIkrMAg" jsl="$t t-SQvYJToREhU;$x 0;" data-rtid="search-19" jsaction="r.BMsjWllwe1s" data-async-trigger="reviewDialog" data-fid="0x3967e5667430c88d:0xbfd05701dcdcf1af" href="javascript:void(0)" class="fl r-search-19"><span><span style="white-space:nowrap">7 Google reviews</span></span></a> - <span class="r-search-20" jsl="$t t-9yGOL8ZmD70;$x 0;"><a data-ved="0CJoBENUJMAg" jsl="$x 1;" data-rtid="search-20" jsaction="r.v5XlE647GEg" id="hu-11350637285775910635" class="fl nj _uTc search-20-3sPkwCJYygM" href="javascript:void(0);">Rs.&nbsp;1101<small>?</small><div data-ved="0CJsBENcJMAg" class="hppc"><div data-ved="0CJwBENYJMAg" class="hpplc"></div></div></a></span></div><div style="margin-left:26px;width:22px;float:left"><span style="height:38px;padding:0;width:22px"><a style="border:none;display:block;overflow:hidden;height:30px;width:16px" class="l" tabindex="0" href="/maps/place/hotel+in+udaipur/@24.579852,73.679791,15z/data=!4m2!3m1!1s0x0:0xbfd05701dcdcf1af?sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CJ0BEK8LMAg"><span style="display:block;background:url(/images/mappins_grey.png) no-repeat;background-position:0 -210px;background-size:;height:30px;width:16px" class="lupin"></span></a></span></div><div style="width:146px;float:left;color:#808080;line-height:18px"><span>Gangaur Ghat</span><br><span>Pichola, Udaipur, Rajasthan</span><br><nobr><span>0294 242 1770</span></nobr></div><!--n--></div><div class="vspib" aria-label="Result details" role="button" tabindex="0"><div class="vspii"><div class="vspiic"></div></div></div></div></div><div class="intrlu"><div sig="9vw" data-extra="ludocid=6432694147088773307&amp;lumarker=G" data-ri="9" data-cid="6432694147088773307" class="_xse vsc vscl vslru">  <div data-ved="0CKABEJIKMAk">  <div data-ved="0CKEBEJEKMAk"> </div>   </div>   <!--m--><div style="padding-top:2px;line-height:18px" class="g"><div style="width:318px;float:left"><h3 style="line-height:normal" class="r"><a onmousedown="return rwt(this,'''','''','''',''10'',''AFQjCNHAEGZfC_IuUEHXxnEeRgdXW9m5eA'','''',''0CKIBEKACMAk'','''','''',event)" href="http://www.mandirampalace.com/" class="l">Hotel Mandiram Palace</a></h3><span><cite class="_Rm">www.mandirampalace.com</cite></span><br><div style="display:inline-block;margin-right:5px"><span aria-hidden="true" class="rtng" style="margin-right:5px">4.0</span><span aria-label="Rated4.0out of5" class="star star-s"><span style="width:56px"></span></span></div><a data-ved="0CKUBEIkrMAk" jsl="$t t-SQvYJToREhU;$x 0;" data-rtid="search-21" jsaction="r.BMsjWllwe1s" data-async-trigger="reviewDialog" data-fid="0x396ccf652de67aed:0x5945853eb1f5f0bb" href="javascript:void(0)" class="fl r-search-21"><span><span style="white-space:nowrap">6 Google reviews</span></span></a>&nbsp;·&nbsp;<a onmousedown="return rwt(this,'''','''','''',''10'',''AFQjCNERYZtTTZVopPl8aBGrDjG0dXMmcA'','''',''0CKYBEMIfMAk'','''','''',event)" href="https://plus.google.com/110531253398215268719/?hl=en&amp;socfid=web:lu:unknown:pluspage&amp;socpid=1" class="fl">Google+ page</a> - <span class="r-search-22" jsl="$t t-9yGOL8ZmD70;$x 0;"><a data-ved="0CKcBENUJMAk" jsl="$x 1;" data-rtid="search-22" jsaction="r.v5XlE647GEg" id="hu-15445488307212559634" class="fl nj _uTc search-22-3sPkwCJYygM" href="javascript:void(0);">Rs.&nbsp;1611<small>?</small><div data-ved="0CKgBENcJMAk" class="hppc"><div data-ved="0CKkBENYJMAk" class="hpplc"></div></div></a></span></div><div style="margin-left:26px;width:22px;float:left"><span style="height:38px;padding:0;width:22px"><a style="border:none;display:block;overflow:hidden;height:30px;width:16px" class="l" tabindex="0" href="/maps/place/hotel+in+udaipur/@24.579692,73.680091,15z/data=!4m2!3m1!1s0x0:0x5945853eb1f5f0bb?sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CKoBEK8LMAk"><span style="display:block;background:url(/images/mappins_grey.png) no-repeat;background-position:0 -245px;background-size:;height:30px;width:16px" class="lupin"></span></a></span></div><div style="width:146px;float:left;color:#808080;line-height:18px"><span>71 - Panchdevri, Hanuman Ghat Ramdwara Chawk, Outside Chandpol</span><br><span>Udaipur, Rajasthan</span><br><nobr><span>0294 243 4279</span></nobr></div><!--n--></div><div class="vspib" aria-label="Result details" role="button" tabindex="0"><div class="vspii"><div class="vspiic"></div></div></div></div></div></div><a style="font-size:16px" class="fl _Eu" tabindex="0" href="/maps/search/hotel+in+udaipur/@24.582995,73.6769905,15z/data=!3m1!4b1?sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CKwBELcD">Map results for hotel in udaipur</a></li></div><hr class="rgsep"><div class="srg"><li class="g"><!--m--><div data-hveid="174" class="rc"><h3 class="r"><a onmousedown="return rwt(this,'''','''','''',''11'',''AFQjCNFwyPb6hEHp2a8YsULXqC78cskAnA'','''',''0CK8BEBYwCg'','''','''',event)" href="http://www.hotelsudaipur.net/">Hotels in Udaipur, Udaipur Heritage Hotels, Udaipur Hotels ...</a></h3><div class="s"><div><div style="white-space:nowrap" class="f kv _SWb"><cite class="_Rm">www.<b>hotelsudaipur</b>.net/</cite><div class="action-menu ab_ctl"><a data-ved="0CLABEOwdMAo" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b10" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CLEBEKkfMAo" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li role="menuitem" class="action-menu-item ab_dropdownitem"><a onmousedown="return rwt(this,'''','''','''',''11'',''AFQjCNGXhz4kYcOFbiUohlwsz_CFpBYMqg'','''',''0CLIBECAwCg'','''','''',event)" href="http://webcache.googleusercontent.com/search?q=cache:xx4t_4bKtmwJ:www.hotelsudaipur.net/+&amp;cd=11&amp;hl=en&amp;ct=clnk&amp;gl=in" class="fl">Cached</a></li><li role="menuitem" class="action-menu-item ab_dropdownitem"><a href="/search?biw=1366&amp;bih=648&amp;q=related:www.hotelsudaipur.net/+hotel+in+udaipur&amp;tbo=1&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CLMBEB8wCg" class="fl">Similar</a></li></ul></div></div></div><div class="f slp"></div><span class="st">Udaipur Hotels presents Udaipur Hotels, Heritage Hotels of Udaipur, UdaipurHotels, Luxury <em>Hotels in Udaipur</em> India, Budget <em>Hotels in Udaipur</em>, Economy <em>Hotels</em>&nbsp;...</span></div></div></div><!--n--></li><li class="g"><!--m--><div data-hveid="180" class="rc"><h3 class="r"><a onmousedown="return rwt(this,'''','''','''',''12'',''AFQjCNFzBNvoKB4NUTlHRKt59qxFz3fnLA'','''',''0CLUBEBYwCw'','''','''',event)" href="http://www.yatra.com/hotels/hotels-in-udaipur">Hotels in Udaipur, Book Udaipur Hotel Room Online at ...</a></h3><div class="s"><div><div style="white-space:nowrap" class="f kv _SWb"><cite class="_Rm bc">www.yatra.com › Hotels in India</cite><div class="action-menu ab_ctl"><a data-ved="0CLcBEOwdMAs" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b11" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CLgBEKkfMAs" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li role="menuitem" class="action-menu-item ab_dropdownitem"><a onmousedown="return rwt(this,'''','''','''',''12'',''AFQjCNGmIE8hK7-JulG2qIw9Cfr6dyAHKA'','''',''0CLkBECAwCw'','''','''',event)" href="http://webcache.googleusercontent.com/search?q=cache:y6FCW-EedrYJ:www.yatra.com/hotels/hotels-in-udaipur+&amp;cd=12&amp;hl=en&amp;ct=clnk&amp;gl=in" class="fl">Cached</a></li><li role="menuitem" class="action-menu-item ab_dropdownitem"><a href="/search?biw=1366&amp;bih=648&amp;q=related:www.yatra.com/hotels/hotels-in-udaipur+hotel+in+udaipur&amp;tbo=1&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CLoBEB8wCw" class="fl">Similar</a></li></ul></div></div></div><div class="f slp"></div><span class="st">Find 142 <em>hotels in Udaipur</em> with photos, hotel map locations on Yatra.com. Lowest rates guaranteed for Udaipur accommodations, book online and Save.</span></div></div></div><!--n--></li><li class="g"><!--m--><div data-hveid="187" class="rc"><h3 class="r"><a onmousedown="return rwt(this,'''','''','''',''13'',''AFQjCNEdPDZQOtN0YhQqAAONd8cBXXNEuA'','''',''0CLwBEBYwDA'','''','''',event)" href="http://www.tridenthotels.com/hotels-in-udaipur">Hotels in Udaipur - 5 Star Hotels in Udaipur - Trident Hotels</a></h3><div class="s"><div><div style="white-space:nowrap" class="f kv _SWb"><cite class="_Rm">www.trident<b>hotels</b>.com/<b>hotels-in-udaipur</b></cite><div class="action-menu ab_ctl"><a data-ved="0CL0BEOwdMAw" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b12" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CL4BEKkfMAw" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li role="menuitem" class="action-menu-item ab_dropdownitem"><a onmousedown="return rwt(this,'''','''','''',''13'',''AFQjCNGE7zC9lzTbdQi4yLQyjlc9cki5SA'','''',''0CL8BECAwDA'','''','''',event)" href="http://webcache.googleusercontent.com/search?q=cache:OCR8naW4tx8J:www.tridenthotels.com/hotels-in-udaipur+&amp;cd=13&amp;hl=en&amp;ct=clnk&amp;gl=in" class="fl">Cached</a></li></ul></div></div></div><div class="f slp"></div><span class="st">Trident Hotel is among the best <em>hotels in Udaipur</em>. Enjoy your stay at this <em>hotel in Udaipur</em> and get all comforts and a range of world class facilities.</span></div></div></div><!--n--></li><li class="g"><!--m--><div data-hveid="192" class="rc"><h3 class="r"><a onmousedown="return rwt(this,'''','''','''',''14'',''AFQjCNFiCR006n9u99K17NFxVv68InTAqg'','''',''0CMEBEBYwDQ'','''','''',event)" href="http://www.booking.com/city/in/udaipur.html">128 Hotels in Udaipur, India - Best Price Guarantee ...</a></h3><div class="s"><div><div style="white-space:nowrap" class="f kv _SWb"><cite class="_Rm bc">www.booking.com › India › Rajasthan</cite><div class="action-menu ab_ctl"><a data-ved="0CMMBEOwdMA0" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b13" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CMQBEKkfMA0" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li role="menuitem" class="action-menu-item ab_dropdownitem"><a onmousedown="return rwt(this,'''','''','''',''14'',''AFQjCNHwuaHCfehT0ylosEf29rVJKiaAAQ'','''',''0CMUBECAwDQ'','''','''',event)" href="http://webcache.googleusercontent.com/search?q=cache:HIHcEtwGpe0J:www.booking.com/city/in/udaipur.html+&amp;cd=14&amp;hl=en&amp;ct=clnk&amp;gl=in" class="fl">Cached</a></li><li role="menuitem" class="action-menu-item ab_dropdownitem"><a href="/search?biw=1366&amp;bih=648&amp;q=related:www.booking.com/city/in/udaipur.html+hotel+in+udaipur&amp;tbo=1&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CMYBEB8wDQ" class="fl">Similar</a></li></ul></div></div></div><div class="f slp"></div><span class="st">Great savings on <em>hotels in Udaipur</em>, India online. Good availability and great rates<wbr></wbr>. Read hotel reviews and choose the best hotel deal for your stay.</span></div></div></div><!--n--></li><li class="g"><!--m--><div data-hveid="199" class="rc"><h3 class="r"><a onmousedown="return rwt(this,'''','''','''',''15'',''AFQjCNGJIb3qIt_nuTC6bdtrLplhSMfqNw'','''',''0CMgBEBYwDg'','''','''',event)" href="http://www.expedia.co.in/Udaipur-Hotels.d6052923.Travel-Guide-Hotels">Udaipur Hotels: Cheap Hotels in Udaipur, India | Expedia.co.in</a></h3><div class="s"><div><div style="white-space:nowrap" class="f kv _SWb"><cite class="_Rm bc">www.expedia.co.in › Hotels › India</cite><div class="action-menu ab_ctl"><a data-ved="0CMoBEOwdMA4" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b14" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CMsBEKkfMA4" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li role="menuitem" class="action-menu-item ab_dropdownitem"><a onmousedown="return rwt(this,'''','''','''',''15'',''AFQjCNGTg8N37a8HwN2dhPa77KRJe5vB8g'','''',''0CMwBECAwDg'','''','''',event)" href="http://webcache.googleusercontent.com/search?q=cache:bpm0-pDfEQwJ:www.expedia.co.in/Udaipur-Hotels.d6052923.Travel-Guide-Hotels+&amp;cd=15&amp;hl=en&amp;ct=clnk&amp;gl=in" class="fl">Cached</a></li><li role="menuitem" class="action-menu-item ab_dropdownitem"><a href="/search?biw=1366&amp;bih=648&amp;q=related:www.expedia.co.in/Udaipur-Hotels.d6052923.Travel-Guide-Hotels+hotel+in+udaipur&amp;tbo=1&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CM0BEB8wDg" class="fl">Similar</a></li></ul></div></div></div><div class="f slp"></div><span class="st">Compare deals from over 81 <em>hotels in Udaipur</em>, India and find the perfect hotel room. Book with Expedia.co.in &amp; save: lowest prices &amp; instant confirmation.</span></div></div></div><!--n--></li><li class="g"><!--m--><div data-hveid="206" class="rc"><h3 class="r"><a onmousedown="return rwt(this,'''','''','''',''16'',''AFQjCNFp2ZjRvbgQLDcmD3XenfZpy8p3Mg'','''',''0CM8BEBYwDw'','''','''',event)" href="http://www.oberoihotels.com/hotels-in-udaipur/">Hotels in Udaipur, Luxury Hotel in Udaipur, India, The ...</a></h3><div class="s"><div><div style="white-space:nowrap" class="f kv _SWb"><cite class="_Rm">www.oberoi<b>hotels</b>.com/<b>hotels-in-udaipur</b>/</cite><div class="action-menu ab_ctl"><a data-ved="0CNABEOwdMA8" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b15" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CNEBEKkfMA8" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li role="menuitem" class="action-menu-item ab_dropdownitem"><a onmousedown="return rwt(this,'''','''','''',''16'',''AFQjCNFShibZW0A_KXUby0BjOi7TiZ91tg'','''',''0CNIBECAwDw'','''','''',event)" href="http://webcache.googleusercontent.com/search?q=cache:Q_hWrkEzUtgJ:www.oberoihotels.com/hotels-in-udaipur/+&amp;cd=16&amp;hl=en&amp;ct=clnk&amp;gl=in" class="fl">Cached</a></li></ul></div></div></div><div class="f slp"></div><span class="st"><em>Hotels in Udaipur</em>, Find the best premium luxury <em>hotel in Udaipur</em>. The Oberoi Udaivilas, Udaipur is located on the banks of Lake Pichola in Udaipur, Rajasthan<wbr></wbr>.</span></div></div></div><!--n--></li><li class="g"><!--m--><div data-hveid="211" class="rc"><h3 class="r"><a onmousedown="return rwt(this,'''','''','''',''17'',''AFQjCNEXPpyYY_5juAWrUWMqG_jRxosy5A'','''',''0CNQBEBYwEA'','''','''',event)" href="http://www.hrhhotels.com/royal_retreats/garden_hotel/index.aspx">Garden Hotel, Udaipur - HRH Hotels</a></h3><div class="s"><div><div style="white-space:nowrap" class="f kv _SWb"><cite class="_Rm bc">www.hrhhotels.com › Our Hotels › Royal Retreats › Garden Hotel</cite><div class="action-menu ab_ctl"><a data-ved="0CNYBEOwdMBA" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b16" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CNcBEKkfMBA" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li role="menuitem" class="action-menu-item ab_dropdownitem"><a onmousedown="return rwt(this,'''','''','''',''17'',''AFQjCNGF2yhF6TUd0fYqS1WyIBqysEEgfg'','''',''0CNgBECAwEA'','''','''',event)" href="http://webcache.googleusercontent.com/search?q=cache:N4pFrkxGgj8J:www.hrhhotels.com/royal_retreats/garden_hotel/index.aspx+&amp;cd=17&amp;hl=en&amp;ct=clnk&amp;gl=in" class="fl">Cached</a></li><li role="menuitem" class="action-menu-item ab_dropdownitem"><a href="/search?biw=1366&amp;bih=648&amp;q=related:www.hrhhotels.com/royal_retreats/garden_hotel/index.aspx+hotel+in+udaipur&amp;tbo=1&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CNkBEB8wEA" class="fl">Similar</a></li></ul></div></div></div><div class="f slp"></div><span class="st">The serene and green Garden <em>Hotel</em>, offers comfortable suites and rooms for business and leisure travellers wishing to explore <em>Udaipur</em> and the City Palace&nbsp;...</span></div></div></div><!--n--></li></div><hr class="rgsep"></ol></div><!--z--><div class="r-search-23" jsl="$t t-RyNGFvRvxmg;$x 0;"><g-lightbox class="r-search-24" jsl="$x 1;$t t-ONSAXnzyl6g;$x 0;" data-rtid="search-23" jsaction="lcm_lightbox_closed:r.66wbyzIibio"><div jsl="$x 1;" data-rtid="search-24" jsaction="lcm_load_lightbox:r.UOUIu-IH67I;lcm_load_close_lightbox:r.L2xduk0K6EI;lcm_open_lightbox:r.HDu3AM_jzMw;lcm_close_lightbox:r.azUBSiGnWok"><div data-ved="0CNoBEPlD" style="display:none" class="_SWe _S5e search-24-20H57zYdxbY"><div jsl="$x 2;" data-rtid="search-24" jsaction="r.azUBSiGnWok" class="_xXe"><div style="display:none" class="_pYe search-24-rviw6i-qB2Y"></div></div><div data-ved="0CNsBEPhD" jsl="$x 3;" data-rtid="search-24" jsaction="r.azUBSiGnWok" class="_wqf"></div><div style="display:none" class="_yXe search-24-0078sLar460"><div data-ved="0CNwBEMQs" id="reviewDialog" data-async-type="reviewDialog" data-jiis="up" class="_krf review-dialog y yp"></div></div></div></div></g-lightbox></div></div></div></div><div id="bottomads" data-jiis="uc" data-jibp="h" style=""></div><div style="padding:0 8px" id="extrares" class="med"><div id="botstuff" data-jiis="uc" data-jibp="h" style=""><style>.mfr{margin-top:1em;margin-bottom:1em}#brs{}#brs{margin-bottom:16px}#brs .med{color:#808080;height:auto;padding-bottom:7px}.brs_col{display:inline-block;font-size:13px;margin-top:-1px;padding-bottom:1px;float:left;padding-right:16px;line-height:20px}#brs ._e4b{margin:0;padding-top:5px;}.uh_h,.uh_hp,.uh_hv{display:none;position:fixed}.uh_h{height:0px;left:0px;top:0px;width:0px}.uh_hv{background:#fff;border:1px solid #ccc;-moz-box-shadow:0 4px 16px rgba(0,0,0,0.2);margin:-8px;padding:8px;background-color:#fff}.uh_hp,.uh_hv,#uh_hp.v{display:block;z-index:5000}#uh_hp{-moz-box-shadow:0px 2px 4px rgba(0,0,0,0.2);display:none;opacity:.7;position:fixed}#uh_hpl{cursor:pointer;display:block;height:100%;outline-color:-moz-use-text-color;outline-style:none;outline-width:medium;width:100%}.uh_hi{border:0;display:block;margin:0 auto 4px}.uh_hx{opacity:0.5}.uh_hx:hover{opacity:1}.uh_hn,.uh_hr,.uh_hs,.uh_ht,.uh_ha{margin:0 1px -1px;padding-bottom:1px;overflow:hidden}.uh_ht{font-size:123%;line-height:120%;max-height:1.2em;word-wrap:break-word}.uh_hn{line-height:120%;max-height:2.4em}.uh_hr{color:#093;white-space:nowrap}.uh_hs{color:#093;white-space:normal}.uh_ha{color:#777;white-space:nowrap}a.uh_hal{color:#36c;text-decoration:none}a:hover.uh_hal{text-decoration:underline}</style><div data-ved="0CN0BEAg"><div id="brs" style="clear:both;overflow:hidden"><h3 style="text-align:left" class="med _kk _wI">Searches related to hotel in udaipur</h3><div class="card-section"><div class="brs_col"><p class="_e4b"><a href="/search?biw=1366&amp;bih=648&amp;q=budget+hotel+in+udaipur+with+tariff&amp;revid=687677405&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0CN8BENUCKAA"><b>budget</b> hotel in udaipur <b>with tariff</b></a></p><p class="_e4b"><a href="/search?biw=1366&amp;bih=648&amp;q=3+star+hotel+in+udaipur&amp;revid=687677405&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0COABENUCKAE"><b>3 star</b> hotel in udaipur</a></p><p class="_e4b"><a href="/search?biw=1366&amp;bih=648&amp;q=5+star+hotel+in+udaipur&amp;revid=687677405&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0COEBENUCKAI"><b>5 star</b> hotel in udaipur</a></p><p class="_e4b"><a href="/search?biw=1366&amp;bih=648&amp;q=hotel+in+udaipur+with+swimming+pool&amp;revid=687677405&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0COIBENUCKAM">hotel in udaipur <b>with swimming pool</b></a></p></div><div class="brs_col"><p class="_e4b"><a href="/search?biw=1366&amp;bih=648&amp;q=sheraton+udaipur&amp;revid=687677405&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0COMBENUCKAQ"><b>sheraton</b> udaipur</a></p><p class="_e4b"><a href="/search?biw=1366&amp;bih=648&amp;q=4+star+hotel+in+udaipur&amp;revid=687677405&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0COQBENUCKAU"><b>4 star</b> hotel in udaipur</a></p><p class="_e4b"><a href="/search?biw=1366&amp;bih=648&amp;q=hotel+in+udaipur+near+railway+station&amp;revid=687677405&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0COUBENUCKAY">hotel in udaipur <b>near railway station</b></a></p><p class="_e4b"><a href="/search?biw=1366&amp;bih=648&amp;q=hotel+in+udaipur+near+bus+stand&amp;revid=687677405&amp;sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0COYBENUCKAc">hotel in udaipur <b>near bus stand</b></a></p></div></div></div><hr class="rgsep"><div id="uh_hp" class=""><a id="uh_hpl" href="#"></a></div><div id="uh_h"><a id="uh_hl"></a></div></div></div></div><div><div role="contentinfo" id="foot"><div id="cljs" data-jiis="uc" data-jibp="h" style=""></div><span id="xjs" data-jiis="uc" data-jibp="h" style=""><div id="navcnt"><table id="nav" style="border-collapse:collapse;text-align:left;margin:30px auto 30px"><tbody><tr valign="top"><td class="b navend"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-24px 0;width:28px" class="csb gbil"></span></td><td class="cur"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-53px 0;width:20px" class="csb gbil"></span>1</td><td><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;start=10&amp;sa=N" class="fl"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-74px 0;width:20px" class="csb gbil ch"></span>2</a></td><td><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;start=20&amp;sa=N" class="fl"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-74px 0;width:20px" class="csb gbil ch"></span>3</a></td><td><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;start=30&amp;sa=N" class="fl"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-74px 0;width:20px" class="csb gbil ch"></span>4</a></td><td><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;start=40&amp;sa=N" class="fl"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-74px 0;width:20px" class="csb gbil ch"></span>5</a></td><td><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;start=50&amp;sa=N" class="fl"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-74px 0;width:20px" class="csb gbil ch"></span>6</a></td><td><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;start=60&amp;sa=N" class="fl"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-74px 0;width:20px" class="csb gbil ch"></span>7</a></td><td><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;start=70&amp;sa=N" class="fl"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-74px 0;width:20px" class="csb gbil ch"></span>8</a></td><td><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;start=80&amp;sa=N" class="fl"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-74px 0;width:20px" class="csb gbil ch"></span>9</a></td><td><a href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;start=90&amp;sa=N" class="fl"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-74px 0;width:20px" class="csb gbil ch"></span>10</a></td><td class="b navend"><a style="text-align:left" id="pnnext" href="/search?q=hotel+in+udaipur&amp;biw=1366&amp;bih=648&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;start=10&amp;sa=N" class="pn"><span style="background:url(/images/nav_logo195.png) no-repeat;background-position:-96px 0;width:71px" class="csb gbil ch"></span><span style="display:block;margin-left:53px">Next</span></a></td></tr></tbody></table></div></span><div id="gfn" data-jiis="uc" data-jibp="h" style=""><style>#foot{visibility:inherit}</style></div></div></div></div></div><div id="rhscol" data-jiis="uc" data-jibp="h" class="col" style=""><style>._LPe{margin:6px 2px 16px 0}._LPe._UQe{margin-bottom:24px}._LPe._qQe{margin-top:13px}._LPe._pQe{height:100%;min-height:311px;padding:0 15px 15px}._g4b{margin-top:0.5em}._ehe{margin-right:85px}._dhe{margin-top:0;position:absolute;right:-10px;top:2px}._Hlf{position:relative;padding-top:10px}._Kbe{position:absolute;right:0;margin-top:-2px}#rhs ._Kbe{margin-right:12px}._See{position:relative;zoom:1;margin:0;font-size:0}._See ._Kfe{position:absolute;bottom:0;right:2px;display:block;height:12px;width:12px}.ads-ad{padding-top:11px;padding-bottom:11px}#center_col ._Ak{position:relative;margin-left:0px;margin-right:0px}#tads{padding-top:2px;padding-bottom:2px;margin-top:-6px;margin-bottom:6px}#tadsb{padding-top:0;padding-bottom:9px;margin-top:-10px;margin-bottom:16px}#center_col .ads-ad{padding-left:8px;padding-right:8px}#rhs ._Ak{margin:5px 0px 32px 16px;padding-top:3px;padding-bottom:0px}#rhs .ads-ad{padding-left:0px;padding-right:0px}#center_col ._Ak{border-bottom:1px solid #ebebeb}#center_col ._hM{margin:12px -17px 0 0;padding:0}#center_col ._hM{font-weight:normal;font-size:13px;float:right}._hM span+span{margin-left:3px}#rhs ._hM{font-weight:normal;font-size:13px;margin:0;padding:0;}._mB{background-color:#efc439;border-radius:2px;color:#fff;display:inline-block;font-size:12px;padding:0 2px;line-height:14px;vertical-align:baseline}.ads-bbl-container{background-color:#fff;border:1px solid rgba(0,0,0,0.2);box-shadow:0 4px 16px rgba(0,0,0,0.2);color:#666;position:absolute;z-index:120}.ads-lb{}.ads-bbl-container.ads-lb{background-color:#2d2d2d;border:1px solid rgba(0,0,0,0.5);color:#adadad;max-height:80px;overflow:auto;z-index:9100}.ads-bbl-triangle{border-left-color:transparent;border-right-color:transparent;border-width:0 9.5px 9.5px 9.5px;width:0px;border-style:solid;border-top-color:transparent;height:0px;position:absolute;z-index:121}.ads-bbl-triangle.ads-lb{z-index:9101}.ads-bbl-triangle-bg{border-bottom-color:#bababa}.ads-bbl-triangle-bg.ads-lb{border-bottom-color:#0e0e0e}.ads-bbl-triangle-fg{border-bottom-color:#fff;margin-left:-9px;margin-top:1px}.ads-lb .ads-bbl-triangle-fg{border-bottom-color:#2d2d2d}.ads-bblc{display:none}._lBb{padding:16px}._zFc{padding-top:12px}._lBb a{text-decoration:none}._lBb a:hover{text-decoration:underline}._NU{background:url(/images/nav_logo195.png);background-position:0 -106px;display:inline-block;height:12px;margin-top:-2px;position:relative;top:2px;width:12px;text-indent:100%;white-space:nowrap;overflow:hidden}.ads-visurl{color:#006621;white-space:nowrap;font-size:14px}#center_col .ads-visurl cite{color:#006621;vertical-align:bottom}._Ak .action-menu{line-height:0}#center_col ._Ak .action-menu .mn-dwn-arw{border-color:#006621 transparent}#center_col ._Ak .action-menu:hover .mn-dwn-arw{border-color:#00591E transparent}._mDc{display:-webkit-box;min-height:36px;overflow:hidden;text-overflow:ellipsis;-webkit-box-orient:vertical;-webkit-line-clamp:2}.ads-creative b{color:#545454}._zKf{color:#808080}._M2b a{font-size:11px}#rhs ._Ak ._M2b a:visited{color:#1a0dab}</style><div id="rhs"><div class="r-rhscol-25 rhstc5" jsl="$t t-5RRekjfu2Ys;$x 0;" id="rhs_block"><script>(function(){var c4=1072;var c5=1160;try{var w=document.body.offsetWidth,n=3;if(w&gt;=c4)n=w&lt;c5?4:5;document.getElementById(''rhs_block'').className+='' rhstc''+n;}catch(e){}\r\n})();</script>   <div style="overflow: hidden; background-color: rgb(255, 255, 255);" id="lu_pinned_rhs"><div style="position:relative;padding-bottom:15px" class="_LPe rhsvw _CC"><div style="margin:0 -15px"><div style="height:120px;width:278px" data-mw="278" data-mh="120" class="rhsl4 rhsmap3col"></div><div style="height:120px;width:366px" data-mw="366" data-mh="120" class="rhsg3 rhsl5 rhsmap4col"></div><div style="height:120px;width:454px" data-mw="454" data-mh="120" class="rhsg4 rhsmap5col"><a style="position:relative;height:120px;width:454px;display:block" tabindex="0" href="https://www.google.co.in/maps/search/hotel+in+udaipur/@24.582995,73.6769905,15z/data=!3m1!4b1?sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0COsBELYD"><img width="454" height="120" border="0" alt="" src="/maps/vt/data=U4aSnIyhBFNIJ3A8fCzUmaVIwyWq6RtIfB4QKiGq_w,urrKeiJ_ilAofoZAYZlXnJmvVbS13M01eEgPoa67hyXhrJnQ6Tb-3wX00EbxSiB8Wai7qSN9Tb8y1-QkSxtkrLzJXutTwf0LHzS6qWrp6SpFaf0a6ryxJFpqfUVEa8HP_7wE1WsF8gsWPznkxcccxXZoww9dX1TWNL-aa1xalaPQrCQvHM3wQYc1rg3jmLzC7LEEyWc6nGttKrf-QYaQ7rt1TOPk46jEQaszTjXKQU_kKWORGDO1dxa5pLXW5dWaFlGQMg4U7st845AuVTPJ5kkdJQZSJQbrjw8gNhk-PDzu8XnzON70x9cqJW3iY54Ht0Rid2mfGJSgtSvVskHwG35-uAOLFOwkwPPgO6u8sW1Ju6gO3RmP9vuOfLr4Lqa1zO_1EX9h3oPOU5qOCDKHdmYLlTzqwKcZWf_V5C_-gBeyFtmZeFt4t1oHRpRZylo" id="lu_map"></a></div></div><div style="position:relative"><div class="_Hlf"><a style="font-size:medium" class="fl" tabindex="0" href="/maps/search/hotel+in+udaipur/@24.582995,73.6769905,15z/data=!3m1!4b1?sa=X&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;sqi=2&amp;ved=0COwBEMgT">Map for hotel in udaipur</a>  </div></div></div></div> <div data-ved="0CO0BEBc" id="mbEnd" class="_Ak"><h2 class="_hM"><span class="_mB">Ads</span><span class="r-rhscol-26" jsl="$x 0;$t t-A6yEzBVJ018;$x 0;"><a data-ved="0CO4BECc" jsl="$x 1;" data-rtid="rhscol-26" jsaction="r.Wea0zbgTzNI" data-width="230" href="javascript:void(0)" class="ads-bbll"><span title="Why these ads?" class="_NU">Why these ads?</span></a><div data-ved="0CO8BECg" class="ads-bblc"><div class="_lBb"><div>These ads are based on your current search terms.</div><div jsl="$t t-YDfv1cNv3GI;$x 0;" class="_zFc r-rhscol-27">Visit Google’s <a data-ved="0CPABECk" jsl="$x 8;" data-rtid="rhscol-27" jsaction="r.8Na6VOGeTa8" href="javascript:void();">Ads Settings</a> to learn more or opt out.</div></div></div></span></h2><ol><li data-hveid="241" class="ads-ad"><h3><a id="s1p1" href="http://www.googleadservices.com/pagead/aclk?sa=L&amp;ai=CpE_U_N8PVcirEdWouASGtoAwj9750gOP9rCy1AHaqri8ARABKAhg5Yrog9QOoAHfgfr1A8gBAakCbixXadofsj6qBB9P0AWlIcuUJH17oxSn2pqaQvbSWtyZSzj4pVroJpIougUTCMSQ-tuXvsQCFQK-jgod0JUAAcoFAIgGAYAH14mqK5AHA6gHpr4b2AcB&amp;num=3&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;ohost=www.google.co.in&amp;cid=5Gi375HIp3STy0oHygEi78JHkdywobzQ21Oq5yKohB77YQ&amp;sig=AOD64_0RNSJZ95jER0H6_jgGOBSixdi3bw&amp;rct=j&amp;q=&amp;sqi=2&amp;ved=0CPIBENEM&amp;adurl=http://www.trivago.in/%3FiSemThemeId%3D10982%26iPathId%3D93979%26sem_keyword%3Dhotel%2520in%2520udaipur%26sem_creativeid%3D56883539783%26sem_matchtype%3De%26sem_network%3Dg%26sem_device%3Dc%26sem_placement%3D%26sem_target%3D%26sem_adposition%3D1s1%26sem_param1%3D%26sem_param2%3D%26cip%3D9112001011" style="display:none"></a><a class="r-rhscol-28" jsl="$t t-zxXzjt1d4B0;$x 0;" onmousedown="return google.arwt(this)" id="vs1p1" href="http://www.trivago.in/?iSemThemeId=10982&amp;iPathId=93979&amp;sem_keyword=udaipur%20hotell&amp;sem_creativeid=56883539783&amp;sem_matchtype=&amp;sem_network=g&amp;sem_device=c&amp;sem_placement=&amp;sem_target=&amp;sem_adposition=none&amp;sem_param1=&amp;sem_param2=&amp;cip=9112001011">192 Hotels in Udaipur&lrm;</a></h3><div class="ads-visurl"><cite>www.trivago.in/<b>Hotel</b></cite>&lrm;<div class="action-menu ab_ctl"><a data-ved="0CPMBEOwd" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b1179400975" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CPQBEKkf" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li data-type="why_this_ad" role="menuitem" class="action-menu-item ab_dropdownitem"><div data-ved="0CPUBEIET" jsaction="am.itemclk" tabindex="-1" role="menuitem" class="action-menu-button">Why this ad?</div></li></ul></div></div></div><div class="ads-creative">trivago&trade; Save up to 78% on <b>Hotels</b>.<br>Compare over 200 Booking Sites.</div></li><li data-hveid="246" class="ads-ad"><h3><a id="s1p2" href="http://www.googleadservices.com/pagead/aclk?sa=L&amp;ai=CWxfW_N8PVcirEdWouASGtoAwjIynkQacyr_25wG4seNCEAIoCGDliuiD1A6gAez-sckDyAEBqQJS3-MChTxRPqoEI0_QRb7iyI8YRbMhwQjmt9ej1kmUDq78P03-Ig-q7QKThicTugUTCMSQ-tuXvsQCFQK-jgod0JUAAcoFAIgGAYAH_IDONpAHA6gHpr4b2AcB&amp;num=4&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;ohost=www.google.co.in&amp;cid=5Gi375HIp3STy0oHygEi78JHkdywobzQ21Oq5yKohB77YQ&amp;sig=AOD64_0nvHmY-ua1TtHz42BXOWBDTlb6pg&amp;rct=j&amp;q=&amp;sqi=2&amp;ved=0CPcBENEM&amp;adurl=http://www.chundapalace.com" style="display:none"></a><a class="r-rhscol-29" jsl="$t t-zxXzjt1d4B0;$x 0;" onmousedown="return google.arwt(this)" id="vs1p2" href="http://www.chundapalace.com/">Chunda Palace Udaipur&lrm;</a></h3><div class="ads-visurl"><cite>www.chundapalace.com/Best-<b>Hotel</b></cite>&lrm;<div class="action-menu ab_ctl"><a data-ved="0CPgBEOwd" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b2127553820" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CPkBEKkf" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li data-type="why_this_ad" role="menuitem" class="action-menu-item ab_dropdownitem"><div data-ved="0CPoBEIET" jsaction="am.itemclk" tabindex="-1" role="menuitem" class="action-menu-button">Why this ad?</div></li></ul></div></div></div><div class="ads-creative">Luxury Boutique <b>Hotel</b> Near Lake<br>Pichola. Great Services. Book Now!</div></li><li data-hveid="251" class="ads-ad"><h3><a id="s1p3" href="http://www.googleadservices.com/pagead/aclk?sa=L&amp;ai=C8p7h_N8PVcirEdWouASGtoAw7YXh0galtrmv2AHAn8ijVhADKAhg5Yrog9QOoAGjxsDIA8gBAakCgXewhUo-UT6qBCVP0BXA4sqPGU2ymcPBLCi9lS3CToHrIvknO0x7Lg4EryJL89GRugUTCMSQ-tuXvsQCFQK-jgod0JUAAcoFAIgGAYAHxbm_N5AHA6gHpr4b2AcB&amp;num=5&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;ohost=www.google.co.in&amp;cid=5Gi375HIp3STy0oHygEi78JHkdywobzQ21Oq5yKohB77YQ&amp;sig=AOD64_28W7StZhQOn9FJQqht4kd05P4-Rg&amp;rct=j&amp;q=&amp;sqi=2&amp;ved=0CPwBENEM&amp;adurl=http://theamargarhudaipur.com/" style="display:none"></a><a class="r-rhscol-30" jsl="$t t-zxXzjt1d4B0;$x 0;" onmousedown="return google.arwt(this)" id="vs1p3" href="http://theamargarhudaipur.com/">Hotel Amargarh Udaipur&lrm;</a></h3><div class="ads-visurl"><cite>www.theamargarh<b>udaipur</b>.com/</cite>&lrm;<div class="action-menu ab_ctl"><a data-ved="0CP0BEOwd" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b-2047976667" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CP4BEKkf" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li data-type="why_this_ad" role="menuitem" class="action-menu-item ab_dropdownitem"><div data-ved="0CP8BEIET" jsaction="am.itemclk" tabindex="-1" role="menuitem" class="action-menu-button">Why this ad?</div></li></ul></div></div></div><div class="ads-creative">Lowest Price Available on Official<br>Site Book Your Stay Now!</div></li><li data-hveid="256" class="ads-ad"><h3><a id="s1p4" href="http://www.googleadservices.com/pagead/aclk?sa=L&amp;ai=CxlU1_N8PVcirEdWouASGtoAw3KiJmAbMxJ2A2AG4seNCEAQoCGDliuiD1A6gAez1-9cDyAEBqQJS3-MChTxRPqoEI0_QFcCx2I8aRbMhwQjmt8es0EKUDq78P03-Ig-q7QKrlEYDugUTCMSQ-tuXvsQCFQK-jgod0JUAAcoFAIgGAYAH_ImEKJAHA6gHpr4b2AcB&amp;num=6&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;ohost=www.google.co.in&amp;cid=5Gi375HIp3STy0oHygEi78JHkdywobzQ21Oq5yKohB77YQ&amp;sig=AOD64_2ocQxoKe_6w2jlEoXK_9wjxFtrFA&amp;rct=j&amp;q=&amp;sqi=2&amp;ved=0CIECENEM&amp;adurl=http://clickserve.dartsearch.net/link/click%3Flid%3D43700002119522726%26ds_s_kwgid%3D58700000331197525%26ds_e_adid%3D57940727212%26ds_e_matchtype%3Dsearch%26ds_e_device%3Dc%26ds_url_v%3D2%26utm_source%3Dgoogle%26utm_medium%3Dcpc%26utm_campaign%3DHotel_Destination_Udaipur%26utm_adgroup%3DUdaipur%2520Hotels%2520Generic%26sid%3Dgoogle%26fid%3DHotel_Destination_Udaipur%26xtor%3DSEC-159%5BHotel_Destination_Udaipur%5D-GOO-%5BUdaipur%2520Hotels%2520Generic%5D--%5BS%5D-%5Bhotel%2520in%2520udaipur%5D" style="display:none"></a><a class="r-rhscol-31" jsl="$t t-zxXzjt1d4B0;$x 0;" onmousedown="return google.arwt(this)" id="vs1p4" href="http://www.goibibo.com/hotels/find-hotels-in-udaipur/3369724356477798574/3369724356477798574/?utm_source=google&amp;utm_medium=cpc&amp;utm_campaign=Hotel_Destination_Udaipur&amp;utm_adgroup=Udaipur%20Hotels%20Generic&amp;sid=google&amp;fid=Hotel_Destination_Udaipur&amp;xtor=SEC-159%5BHotel_Destination_Udaipur%5D-GOO-%5BUdaipur%20Hotels%20Generic%5D--%5BS%5D-%5Bhotel%20in%20udaipur%5D">Hotels In Udaipur&lrm;</a></h3><div class="ads-visurl"><cite>www.goibibo.com/<b>Udaipur</b>-<b>Hotels</b></cite>&lrm;<div class="action-menu ab_ctl"><a data-ved="0CIICEOwd" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b-2146999732" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CIMCEKkf" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li data-type="why_this_ad" role="menuitem" class="action-menu-item ab_dropdownitem"><div data-ved="0CIQCEIET" jsaction="am.itemclk" tabindex="-1" role="menuitem" class="action-menu-button">Why this ad?</div></li></ul></div></div></div><div class="ads-creative">Why Pay More? Flat 100% Cashback*<br>on <b>Hotel</b> Bookings. Expiring Soon!</div></li><li data-hveid="261" class="ads-ad"><h3><a id="s1p5" href="http://www.googleadservices.com/pagead/aclk?sa=L&amp;ai=CH9a8_N8PVcirEdWouASGtoAw-aPptQap2rah3AHAn8ijVhAFKAhg5Yrog9QOoAHX9_PGA8gBAakCgXewhUo-UT6qBCVP0HXJv8aPG02ymcPBLBzExCfCToHrIvknO0x7Lg4EryIH-OCeugUTCMSQ-tuXvsQCFQK-jgod0JUAAcoFAIgGAYAHkYiMOZAHA6gHpr4b2AcB&amp;num=7&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;ohost=www.google.co.in&amp;cid=5Gi375HIp3STy0oHygEi78JHkdywobzQ21Oq5yKohB77YQ&amp;sig=AOD64_0sbD-krr6ussqgp89Neh4c8eONwg&amp;rct=j&amp;q=&amp;sqi=2&amp;ved=0CIYCENEM&amp;adurl=http://theudaibagh.com/" style="display:none"></a><a class="r-rhscol-32" jsl="$t t-zxXzjt1d4B0;$x 0;" onmousedown="return google.arwt(this)" id="vs1p5" href="http://theudaibagh.com/">Hotel Udaibagh Udaipur&lrm;</a></h3><div class="ads-visurl"><cite>www.theudaibagh.com/</cite>&lrm;<div class="action-menu ab_ctl"><a data-ved="0CIcCEOwd" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b-1003639511" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CIgCEKkf" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li data-type="why_this_ad" role="menuitem" class="action-menu-item ab_dropdownitem"><div data-ved="0CIkCEIET" jsaction="am.itemclk" tabindex="-1" role="menuitem" class="action-menu-button">Why this ad?</div></li></ul></div></div></div><div class="_r2b"><span>0294 662 5772</span></div><div class="ads-creative">Lowest Price Available on Official<br>Site Reserve Your Stay Now!</div></li><li data-hveid="267" class="ads-ad"><h3><a id="s1p6" href="http://www.googleadservices.com/pagead/aclk?sa=L&amp;ai=CtAnw_N8PVcirEdWouASGtoAw-rD0_Qay39jr0gHK7_SilwMQBigIYOWK6IPUDqABrqXD0wPIAQGpAqRdT1oqPFE-qgQjT9AVlZjYjxRFsyHBCOa38czBUpQOrvw_Tf4iD6rtAq2IAg-6BRMIxJD625e-xAIVAr6OCh3QlQABygUAiAYBoAYsgAe62rwskAcDqAemvhvYBwE&amp;num=8&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;ohost=www.google.co.in&amp;cid=5Gi375HIp3STy0oHygEi78JHkdywobzQ21Oq5yKohB77YQ&amp;sig=AOD64_3_zZB4o7D-9gY2zSJlzVFaJgyNfw&amp;rct=j&amp;q=&amp;sqi=2&amp;ved=0CIwCENEM&amp;adurl=http://www.cleartrip.com/hotels/india/udaipur/%3Frpn%3Dma%26rpv%3DGulab%2Bbagh" style="display:none"></a><a class="r-rhscol-33" jsl="$t t-zxXzjt1d4B0;$x 0;" onmousedown="return google.arwt(this)" id="vs1p6" href="http://www.cleartrip.com/hotels/india/udaipur/?rpn=ma&amp;rpv=Gulab+bagh">Udaipur Hotel Booking&lrm;</a></h3><div class="ads-visurl"><cite>www.cleartrip.com/<b>Hotels</b></cite>&lrm;<div class="action-menu ab_ctl"><a data-ved="0CI0CEOwd" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b762720178" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CI4CEKkf" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li data-type="why_this_ad" role="menuitem" class="action-menu-item ab_dropdownitem"><div data-ved="0CI8CEIET" jsaction="am.itemclk" tabindex="-1" role="menuitem" class="action-menu-button">Why this ad?</div></li></ul></div></div></div><div class="ads-creative">Get Upto 50% Instant Cashback Using<br>Coupon Code SUMMERSALE Book Today!</div></li><li data-hveid="272" class="ads-ad"><h3><a id="s1p7" href="http://www.googleadservices.com/pagead/aclk?sa=L&amp;ai=C-4nl_N8PVcirEdWouASGtoAwk9LdvgfTwamU3QHZ8J7xJhAHKAhg5Yrog9QOoAHF1JHLA8gBAakCUt_jAoU8UT6qBCNP0HXr7sGPFUWzIcEI5reQ-9lDlA6u_D9N_iIPqu0CtKlhEboFEwjEkPrbl77EAhUCvo4KHdCVAAHKBQCIBgGAB6Or7jSQBwOoB6a-G9gHAQ&amp;num=9&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;ohost=www.google.co.in&amp;cid=5Gi375HIp3STy0oHygEi78JHkdywobzQ21Oq5yKohB77YQ&amp;sig=AOD64_0GBf9VEy24A95ACJxgJR90S-m_jg&amp;rct=j&amp;q=&amp;sqi=2&amp;ved=0CJECENEM&amp;adurl=http://www.hotelmahimapalace.com/" style="display:none"></a><a class="r-rhscol-34" jsl="$t t-zxXzjt1d4B0;$x 0;" onmousedown="return google.arwt(this)" id="vs1p7" href="http://www.hotelmahimapalace.com/">Hotel Mahima Palace&lrm;</a></h3><div class="ads-visurl"><cite>www.<b>hotel</b>mahimapalace.com/Best-<b>Hotel</b></cite>&lrm;<div class="action-menu ab_ctl"><a data-ved="0CJICEOwd" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b-762683181" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CJMCEKkf" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li data-type="why_this_ad" role="menuitem" class="action-menu-item ab_dropdownitem"><div data-ved="0CJQCEIET" jsaction="am.itemclk" tabindex="-1" role="menuitem" class="action-menu-button">Why this ad?</div></li></ul></div></div></div><div class="ads-creative">Stay at Best <b>Hotel</b> Nr. Fateh Sagar.<br>Affordable Price. Book Now!</div></li><li data-hveid="277" class="ads-ad"><h3><a id="s1p8" href="http://www.googleadservices.com/pagead/aclk?sa=L&amp;ai=CLenj_N8PVcirEdWouASGtoAw6f7zhAWxw9mO4wHApuY1EAgoCGDliuiD1A6gAe-iofsDyAEBqQKBd7CFSj5RPqoEIE_QFbme1o8WRbNpwZCiOwCYeZeEGvOOVowhvBlP2JZLugUTCMSQ-tuXvsQCFQK-jgod0JUAAcoFAIgGAYAH-dzeBJAHA6gHpr4b2AcB&amp;num=10&amp;ei=_N8PVcSiDoL8ugTQq4II&amp;ohost=www.google.co.in&amp;cid=5Gi375HIp3STy0oHygEi78JHkdywobzQ21Oq5yKohB77YQ&amp;sig=AOD64_2LdLJnUbKctE3iS-INhyfXn1R0rA&amp;rct=j&amp;q=&amp;sqi=2&amp;ved=0CJYCENEM&amp;adurl=http://www.stayzilla.com/ps.php%3Ftag%3Dadwords%26camp%3DAutoad_Catchall_Rs10%26Adgroup%3DHotels_CatchAll%26keyword%3Dhotel%2520in%2520udaipur%26source%3DAdWords%26utm_medium%3DSearch%26utm_campaign%3DAutoad_Catchall_Rs10" style="display:none"></a><a class="r-rhscol-35" jsl="$t t-zxXzjt1d4B0;$x 0;" onmousedown="return google.arwt(this)" id="vs1p8" href="http://www.stayzilla.com/ps.php?kw=Shirdi&amp;tag=adwords_postpaid&amp;camp=Shirdi_search&amp;adgroup=deals_Shirdi_exact&amp;keyword=deals%20in%20shirdi&amp;utm_source=adwords&amp;utm_medium=search&amp;utm_campaign=Shirdi_search">Hotel In Udaipur from Rs 300&lrm;</a></h3><div class="ads-visurl"><cite>www.stayzilla.com/Save_Money</cite>&lrm;<div class="action-menu ab_ctl"><a data-ved="0CJcCEOwd" jsaction="ab.tdd;keydown:ab.hbke;keypress:ab.mskpe" role="button" aria-haspopup="true" aria-expanded="false" aria-label="Result details" id="am-b836133297" href="#" class="_Fmb ab_button"><span class="mn-dwn-arw"></span></a><div data-ved="0CJgCEKkf" jsaction="keydown:ab.hdke;mouseover:ab.hdhne;mouseout:ab.hdhue" tabindex="-1" role="menu" class="action-menu-panel ab_dropdown"><ul><li data-type="why_this_ad" role="menuitem" class="action-menu-item ab_dropdownitem"><div data-ved="0CJkCEIET" jsaction="am.itemclk" tabindex="-1" role="menuitem" class="action-menu-button">Why this ad?</div></li></ul></div></div></div><div class="ads-creative">Save upto 80%*. Lowest Price Offer.<br>Expiring soon. Hurry, Book Now!</div></li></ol><div class="_M2b"><a onmousedown="return rwt(this,'''','''','''','''',''AFQjCNFLkim8l08ueCRgQ1-82jR2euDwQQ'','''',''0CJoCEO4q'','''','''',event)" href="https://adwords.google.com/um/StartNewLogin?service=adwords&amp;sourceid=awo&amp;hl=en-IN&amp;subid=in-en-IN-et-symh">See your ad here&nbsp;»</a></div></div></div></div></div><div style="clear:both"></div></div><div id="bfoot" data-jiis="uc" data-jibp="h" style=""><style>#nycprv .kp-blk{-webkit-box-shadow:none;box-shadow:none}#nycprv .kp-blk{line-height:1.24;margin:6px -32px 0 2px}#nycprv .kp-blk .mod:not(.fwm){padding-left:15px;padding-right:15px}#nycprv .mod.fwm ._pk,#nycprv .mod.fwm ._X5e{margin-left:15px;margin-right:15px}#nycprv .kno-vrt-t{padding-left:16px}</style>   <div style="display:none" role="dialog" id="nyc" class="rhstc5"> <div id="nycp"> <div id="nycxh"> <button id="nycx" title="Hide result details"></button> </div> <div id="nycntg"></div> <div id="nycpp"> <div style="position:absolute;left:0;right:0;text-align:center;top:45%"> <img id="nycli"> <div id="nycm"></div> </div> <div id="nycprv">  <div data-async-context-required="id" data-async-type="lcl_akp" data-jiis="up" id="lcl_akp0" style="display:none" class="rhsvw g-blk y yp"></div><div data-async-context-required="id" data-async-type="lcl_akp" data-jiis="up" id="lcl_akp1" style="display:none" class="rhsvw g-blk y yp"></div><div data-async-context-required="id" data-async-type="lcl_akp" data-jiis="up" id="lcl_akp2" style="display:none" class="rhsvw g-blk y yp"></div><div data-async-context-required="id" data-async-type="lcl_akp" data-jiis="up" id="lcl_akp3" style="display:none" class="rhsvw g-blk y yp"></div><div data-async-context-required="id" data-async-type="lcl_akp" data-jiis="up" id="lcl_akp4" style="display:none" class="rhsvw g-blk y yp"></div><div data-async-context-required="id" data-async-type="lcl_akp" data-jiis="up" id="lcl_akp5" style="display:none" class="rhsvw g-blk y yp"></div><div data-async-context-required="id" data-async-type="lcl_akp" data-jiis="up" id="lcl_akp6" style="display:none" class="rhsvw g-blk y yp"></div>  </div> </div> </div> <div id="nyccur"></div> </div> <div id="nycf"></div>  </div></div><div id="footcnt">   <div> <style>.fmulti{}._dQc{bottom:0;left:0;position:absolute;right:0}._GR{background:#f2f2f2;left:0;right:0;-webkit-text-size-adjust:none}.fbar p{display:inline}.fbar a,#fsettl{text-decoration:none;white-space:nowrap}.fbar{margin-left:-27px}._Gs{padding-left:27px;margin:0 !important}._eA{padding:0 !important;margin:0 !important}#fbarcnt{display:block}._E2 a:hover{text-decoration:underline}._HR img{margin-right:4px}._HR a,._GR #swml a{text-decoration:none}.fmulti{text-align:center}.fmulti #fsr{display:block;float:none}.fmulti #fuser{display:block;float:none}#fuserm{line-height:25px}#fsr{float:right;white-space:nowrap}#fsl{white-space:nowrap}#fsett{background:#fff;border:1px solid #999;bottom:30px;padding:10px 0;position:absolute;box-shadow:0 2px 4px rgba(0,0,0,0.2);-moz-box-shadow:0 2px 4px rgba(0,0,0,0.2);text-align:left;z-index:100}#fsett a{display:block;line-height:44px;padding:0 20px;text-decoration:none;white-space:nowrap}._E2 #fsettl:hover{text-decoration:underline}._E2 #fsett a:hover{text-decoration:underline}._mk{color:#777}._Nh{color:#222;font-size:14px;font-weight:normal;-moz-tap-highlight-color:rgba(0,0,0,0)}._Nh:hover,._Nh:active{color:#444}._Mo{display:inline-block;position:relative}._Nh ._Mo ._cuf{opacity:0.55}a._Nh:hover ._Mo ._cuf,a._Nh:active ._Mo ._cuf{opacity:1.0}._ri,._Wk{height:13px;width:8px}._cuf{border:8px solid rgba(255,255,255,0);border-radius:8px;position:absolute}._ri ._cuf{border-left:8px solid #777;left:1px}._Wk ._cuf{border-right:8px solid #777;left:-9px}._ri ._duf,._Wk ._duf{border:12px solid rgba(255,255,255,0);position:absolute;top:-4px}._ri ._duf{border-left:10px solid #f6f6f6;left:-4px}._Wk ._duf{border-right:10px solid #f6f6f6;left:-10px}._Nh{padding:8px 16px;margin-right:10px}._mk{margin:40px 0}._dD{margin-right:10px}._nW{margin-left:135px}#fbar{background:#f2f2f2;border-top:1px solid #e4e4e4;line-height:40px;min-width:980px}._xac{margin-left:135px}.fbar p,.fbar a,#fsettl,#fsett a{color:#777}.fbar a:hover,#fsett a:hover{color:#333}.fbar{font-size:small}#fuser{float:right}._HR{margin-left:135px;line-height:15px;}</style>  <div style="position: relative; height: auto; visibility: visible;" id="fbarcnt" data-jiis="uc" data-jibp="h"><style>.known_loc{background:#1898C7;box-shadow:0 0 0 1px #1F8FC2}.unknown_loc{background:#9A9FA4;box-shadow:0 0 0 1px #97999D}.known_loc,.unknown_loc{border-radius:100%;display:inline-block;height:8px;margin:7px 5px 10px 1px;vertical-align:middle;width:8px}._uIb{display:inline-block}#fbar._Zvd{padding-top:18px}._HR{color:#aaa}._HR a,#swml a{color:#777}._HR a,#swml a:hover{color:#333}</style> <div style="left: 0px; right: 0px;" class="_Zvd" id="fbar">  <div id="swml" class="_HR" style="visibility: visible;"><div class="_uIb"><span class="unknown_loc"></span><span id="swml_addr">Udaipur, Rajasthan</span> - <span>From your Internet address</span> - <a href="#">Use precise location</a></div><div class="_uIb"><span id="swml_lmsep">&nbsp;-&nbsp;</span><a onmousedown="return rwt(this,'''','''','''','''',''AFQjCNF6NKvZDx4cTna7tVFnVjhlNhp3NQ'','''',''0CJwCELcu'','''','''',event)" href="https://support.google.com/websearch?p=ws_settings_location&amp;hl=en-IN">Learn more</a>&nbsp;&nbsp;&nbsp;</div></div>   <div class="fbar"> <span class="_nW">  <span id="fsl">   <a href="//support.google.com/websearch/?p=ws_results_help&amp;hl=en-IN&amp;fg=1" class="_Gs">Help</a>  <a data-ved="0CJ0CEC4" jsaction="gf.sf" target="_blank" id="_Yvd" data-bucket="websearch" class="_Gs" href="javascript:void(0)">  Send feedback </a>    <a href="//www.google.co.in/intl/en/policies/privacy/?fg=1" class="_Gs">Privacy</a> <a href="//www.google.co.in/intl/en/policies/terms/?fg=1" class="_Gs">Terms</a>    </span> </span> </div> </div> </div> </div> </div><style>.hdtbU{top:-500px;white-space:nowrap}.hdtbU .hdtbItm,.hdtbU li{list-style:none outside none}#hdtb form{display:inline}.hdtbSel,.hdtbSel span.q{color:#000;cursor:default;padding-right:15px;text-decoration:none}#cdr_opt{background-image:none;background:#fff;padding:0 !important}.cdr_sep{border-top:1px solid #ebebeb;height:0;margin:5px 0;width:100%}#cdrlnk{cursor:pointer}.hdtbItm{background:#fff}.hdtbSel,.hdtbSel #cdrlnk{background-image:url(//ssl.gstatic.com/ui/v1/menu/checkmark2.png);background-position:left center;background-repeat:no-repeat}.hdtb-mn-cont{height:22px;white-space:nowrap}.hdtb-mn-hd{color:#777;display:inline-block;position:relative;padding-top:0;padding-bottom:0;padding-right:22px;padding-left:16px;line-height:22px;cursor:pointer}#hdtb-mn-gp{display:inline-block;width:120px}.hdtb-loc{border-top:1px solid #ebebeb;padding-bottom:10px;padding-right:16px;padding-top:15px;padding-left:27px}.hdtb-loc .ksb.mini{margin-top:0}</style><div id="fai" data-jiis="uc" data-jibp="h" style=""></div><div id="footc" data-jiis="uc" data-jibp="h" style=""><div data-jiis="bp" id="xfootw"><div id="xfoot"><div id="xjsd"></div><div data-jiis="bp" id="xjsi"><script>(function(){function c(b){window.setTimeout(function(){var a=document.createElement("script");a.src=b;document.getElementById("xjsd").appendChild(a)},0)}google.dljp=function(b,a){google.xjsu=b;c(a)};google.dlj=c;})();(function(){window.google.xjsrm=[''tnv'',''bbl'',''apml'',''adtt'',''apmf'',''lor'',''me''];})();if(google.y)google.y.first=[];google.pmc={"sx":{},"c":{"mcr":5},"sb":{"agen":false,"cgen":true,"client":"serp","dh":true,"ds":"","exp":"msedr","fl":true,"host":"google.co.in","jam":1,"msgs":{"cibl":"Clear Search","dym":"Did you mean:","lcky":"I\\u0026#39;m Feeling Lucky","lml":"Learn more","oskt":"Input tools","psrc":"This search was removed from your \\u003Ca href=\\"/history\\"\\u003EWeb History\\u003C/a\\u003E","psrl":"Remove","sbit":"Search by image","srch":"Google Search"},"ovr":{},"pq":"hotel in udaipur","psy":"p","refoq":true,"refpd":true,"rfs":["budget hotel in udaipur with tariff","3 star hotel in udaipur","5 star hotel in udaipur","hotel in udaipur with swimming pool","sheraton udaipur","4 star hotel in udaipur","hotel in udaipur near railway station","hotel in udaipur near bus stand"],"scd":10,"sce":4,"stok":"XuCwqH4-JsLJwbxGGxeMfVp_Vys"},"abd":{"abd":true,"dabp":false,"deb":false,"der":true,"det":true,"psa":false,"sup":false},"aldd":{},"am":{},"aspn":{},"async":{},"cdos":{"bih":648,"biw":1366,"dpr":"1"},"cr":{"eup":false,"qir":false,"rctj":true,"ref":true,"uff":false},"ddls":{},"dvl":{"cookie_timeout":86400,"driver_ui_type":2,"iosui_maxlca":0,"mnr_crd":"1","msg_dsc":"From your Internet address","msg_dvl":"Reported by this computer","msg_err":"Location unavailable","msg_gps":"Using GPS","msg_unk":"Unknown","msg_upd":"Update location","msg_use":"Use precise location","uul_text":"Udaipur, Rajasthan"},"elog":{},"erh":{},"foot":{"pf":true,"po":false,"qe":false},"fpe":{"js":true},"gf":{"pid":196},"hv":{},"idck":{},"ipv6":{},"jsa":{},"jsaleg":{},"lc":{},"llc":{},"lu":{"cids":["2444188424022556314","2812662043869934659","13691445501602073001","16183137597538285113","7289077235145864026","13821642921912103343","6432694147088773307"],"fm":"6kGq9LEDoIwglMg5sxvE5wj2WbCApWYqRAC-XkWUwmGf9kU6xkrMMtmpjCd9dV75iH4"},"m":{"ab":{"on":true},"ajax":{"gl":"in","hl":"en","q":"hotel in udaipur"},"css":{"showTopNav":true},"exp":{"kvs":true,"lrb":false,"tnav":true},"msgs":{"details":"Result details","hPers":"Hide private results","hPersD":"Currently hiding private results","loading":"Still loading...","mute":"Mute","noPreview":"Preview not available","sPers":"Show all results","sPersD":"Currently showing private results","unmute":"Unmute"},"time":{"hUnit":1500}},"r":{},"rk":{"bl":"Feedback","db":"Reported","di":"Thank you.","dl":"Report another problem","efe":true,"rb":"Wrong?","ri":"Please report the problem.","rl":"Cancel"},"rkab":{},"rmcl":{"bl":"Feedback","db":"Reported","di":"Thank you.","dl":"Report another problem","rb":"Wrong?","ri":"Please report the problem.","rl":"Cancel"},"sf":{},"st":{},"vm":{"bv":88528373},"vs":{},"hsm":{},"j":{},"p":{"ae":true,"avgTtfc":2000,"brba":false,"dlen":24,"dper":3,"eae":true,"fbdc":500,"fbdu":-1,"fbh":true,"fd":1000000,"focus":true,"gpsj":true,"hiue":true,"hpt":310,"iavgTtfc":2000,"knrt":true,"lpu":[],"maxCbt":1500,"mds":"prc,sp,mbl_he,mbl_hs,mbl_re,mbl_rs,mbl_sv","msg":{"dym":"Did you mean:","gs":"Google Search","kntt":"Use the up and down arrow keys to select each result. Press Enter to go to the selection.","pcnt":"New Tab","sif":"Search instead for","srf":"Showing results for"},"nprr":1,"ohpt":false,"ophe":true,"pmt":250,"pq":true,"rpt":15,"sc":"psy-ab","tdur":50,"ufl":true},"d":{},"csi":{"acsi":true},"TG8rFw":{"sd":"1"},"hLaaFQ":{"ed":"Please enter a description.","eu":"Please enter a valid URL."},"q1cupA":{},"8AF24Q":{},"bnhGTQ":{},"4RZUyg":{},"/nNC3A":{},"CjL7kw":{},"ITl3wQ":{},"FmbnUA":{},"c+PT4g":{},"/1S6iw":{},"GqeGtQ":{},"+idT0Q":{},"NpA8BQ":{},"BwDLOw":{},"8aqNqA":{},"A/Ucpg":{},"cm4D8w":{},"GfrcvQ":{}};google.y.first.push(function(){google.loadAll([''abd'',''aspn'',''async'',''dvl'',''erh'',''foot'',''fpe'',''hv'',''idck'',''ipv6'',''lc'',''lu'',''m'',''sf'',''vm'',''vs''].concat(google.xjsrm||[]));(function(){window.jsl=window.jsl||{};window.jsl.dh=window.jsl.dh||function(i,c,d){try{var e=document.getElementById(i);if(e){e.innerHTML=c;if(d){d();}}else{if(window.jsl.el){window.jsl.el(new Error(''Missing ID.''),{''id'':i});}}}catch(e){if(window.jsl.el){window.jsl.el(new Error(''jsl.dh''));}}};})();(function(){window.jsl.dh(''hdtb_more_mn'',''\\x3cdiv class\\x3d\\x22hdtb_mitem\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22/search?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnms\\x26amp;tbm\\x3dbks\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CAwQ_AUoAA\\x22\\x3eBooks\\x3c/a\\x3e\\x3c/div\\x3e\\x3cdiv class\\x3d\\x22hdtb_mitem\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22https://www.google.co.in/flights/gwsredirect?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnms\\x26amp;tbm\\x3dflm\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CA0Q_AUoAQ\\x22\\x3eFlights\\x3c/a\\x3e\\x3c/div\\x3e\\x3cdiv class\\x3d\\x22hdtb_mitem\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22/search?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnms\\x26amp;tbm\\x3dapp\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CA4Q_AUoAg\\x22\\x3eApps\\x3c/a\\x3e\\x3c/div\\x3e'');})();(function(){window.jsl.dh(''hdtbMenus'',''\\x3cdiv class\\x3d\\x22hdtb-mn-cont\\x22\\x3e\\x3cdiv id\\x3d\\x22hdtb-mn-gp\\x22\\x3e\\x3c/div\\x3e\\x3cdiv class\\x3d\\x22hdtb-mn-hd\\x22 aria-haspopup\\x3d\\x22true\\x22 role\\x3d\\x22button\\x22 tabindex\\x3d\\x220\\x22\\x3e\\x3cdiv class\\x3d\\x22mn-hd-txt\\x22\\x3eAny country\\x3c/div\\x3e\\x3cspan class\\x3d\\x22mn-dwn-arw\\x22\\x3e\\x3c/span\\x3e\\x3c/div\\x3e\\x3cul class\\x3d\\x22hdtbU hdtb-mn-c\\x22\\x3e\\x3cli class\\x3d\\x22hdtbItm hdtbSel\\x22 id\\x3d\\x22lr_\\x22 tabindex\\x3d\\x220\\x22\\x3eAny country\\x3c/li\\x3e\\x3cli class\\x3d\\x22hdtbItm\\x22 id\\x3d\\x22ctr_countryIN\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22/search?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnt\\x26amp;tbs\\x3dctr:countryIN\\x26amp;cr\\x3dcountryIN\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CBMQpwU\\x22\\x3eCountry: India\\x3c/a\\x3e\\x3c/li\\x3e\\x3c/ul\\x3e\\x3cspan class\\x3d\\x22_Vxd\\x22\\x3e\\x3c/span\\x3e\\x3cdiv class\\x3d\\x22hdtb-mn-hd\\x22 aria-haspopup\\x3d\\x22true\\x22 role\\x3d\\x22button\\x22 tabindex\\x3d\\x220\\x22\\x3e\\x3cdiv class\\x3d\\x22mn-hd-txt\\x22\\x3eAny time\\x3c/div\\x3e\\x3cspan class\\x3d\\x22mn-dwn-arw\\x22\\x3e\\x3c/span\\x3e\\x3c/div\\x3e\\x3cul class\\x3d\\x22hdtbU hdtb-mn-c\\x22\\x3e\\x3cli class\\x3d\\x22hdtbItm hdtbSel\\x22 id\\x3d\\x22qdr_\\x22 tabindex\\x3d\\x220\\x22\\x3eAny time\\x3c/li\\x3e\\x3cli class\\x3d\\x22hdtbItm\\x22 id\\x3d\\x22qdr_h\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22/search?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnt\\x26amp;tbs\\x3dqdr:h\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CBMQpwU\\x22\\x3ePast hour\\x3c/a\\x3e\\x3c/li\\x3e\\x3cli class\\x3d\\x22hdtbItm\\x22 id\\x3d\\x22qdr_d\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22/search?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnt\\x26amp;tbs\\x3dqdr:d\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CBMQpwU\\x22\\x3ePast 24 hours\\x3c/a\\x3e\\x3c/li\\x3e\\x3cli class\\x3d\\x22hdtbItm\\x22 id\\x3d\\x22qdr_w\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22/search?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnt\\x26amp;tbs\\x3dqdr:w\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CBMQpwU\\x22\\x3ePast week\\x3c/a\\x3e\\x3c/li\\x3e\\x3cli class\\x3d\\x22hdtbItm\\x22 id\\x3d\\x22qdr_m\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22/search?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnt\\x26amp;tbs\\x3dqdr:m\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CBMQpwU\\x22\\x3ePast month\\x3c/a\\x3e\\x3c/li\\x3e\\x3cli class\\x3d\\x22hdtbItm\\x22 id\\x3d\\x22qdr_y\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22/search?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnt\\x26amp;tbs\\x3dqdr:y\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CBMQpwU\\x22\\x3ePast year\\x3c/a\\x3e\\x3c/li\\x3e\\x3cli class\\x3d\\x22hdtbItm\\x22 id\\x3d\\x22cdr_opt\\x22\\x3e\\x3cdiv jsl\\x3d\\x22$t t-t_nYWbCdeK4;$x 0;\\x22 class\\x3d\\x22r-top_nav-2\\x22\\x3e\\x3cdiv class\\x3d\\x22cdr_sep\\x22\\x3e\\x3c/div\\x3e\\x3cspan class\\x3d\\x22q\\x22 id\\x3d\\x22cdrlnk\\x22 tabindex\\x3d\\x220\\x22 jsaction\\x3d\\x22r.FRTb2aDIjnc\\x22 data-rtid\\x3d\\x22top_nav-2\\x22 jsl\\x3d\\x22$x 1;\\x22 data-ved\\x3d\\x220CBMQpwU\\x22\\x3eCustom range...\\x3c/span\\x3e\\x3cdiv class\\x3d\\x22cdr_cont top_nav-2--t6VZ5o0Dhc\\x22 style\\x3d\\x22display:none\\x22\\x3e\\x3cdiv class\\x3d\\x22cdr_bg\\x22 jsaction\\x3d\\x22r.GnxOjRBdeA8\\x22 data-rtid\\x3d\\x22top_nav-2\\x22 jsl\\x3d\\x22$x 2;\\x22\\x3e\\x3c/div\\x3e\\x3cdiv class\\x3d\\x22cdr_dlg\\x22\\x3e\\x3cdiv class\\x3d\\x22cdr_ttl\\x22\\x3eCustomised date range\\x3c/div\\x3e\\x3clabel class\\x3d\\x22cdr_mml cdr_minl\\x22 for\\x3d\\x22cdr_min\\x22\\x3eFrom\\x3c/label\\x3e\\x3clabel class\\x3d\\x22cdr_mml cdr_maxl\\x22 for\\x3d\\x22cdr_max\\x22\\x3eTo\\x3c/label\\x3e\\x3cdiv class\\x3d\\x22cdr_cls\\x22 jsaction\\x3d\\x22r.GnxOjRBdeA8\\x22 data-rtid\\x3d\\x22top_nav-2\\x22 jsl\\x3d\\x22$x 3;\\x22\\x3e\\x3c/div\\x3e\\x3cdiv class\\x3d\\x22cdr_sft\\x22\\x3e\\x3cdiv class\\x3d\\x22cdr_highl\\x22\\x3e\\x3c/div\\x3e\\x3cform action\\x3d\\x22/search\\x22 class\\x3d\\x22cdr_frm\\x22 method\\x3d\\x22get\\x22\\x3e\\x3cinput type\\x3dhidden name\\x3dq value\\x3d\\x22hotel in udaipur\\x22\\x3e\\x3cinput type\\x3dhidden name\\x3dbiw value\\x3d\\x221366\\x22\\x3e\\x3cinput type\\x3dhidden name\\x3dbih value\\x3d\\x22648\\x22\\x3e\\x3cinput name\\x3d\\x22source\\x22 type\\x3d\\x22hidden\\x22 value\\x3d\\x22lnt\\x22\\x3e\\x3cinput value\\x3d\\x22cdr:1,cd_min:x,cd_max:x\\x22 class\\x3d\\x22ctbs\\x22 name\\x3d\\x22tbs\\x22 type\\x3d\\x22hidden\\x22\\x3e\\x3cinput value\\x3d\\x22\\x22 name\\x3d\\x22tbm\\x22 type\\x3d\\x22hidden\\x22\\x3e\\x3cinput type\\x3d\\x22text\\x22 value\\x3d\\x22\\x22 class\\x3d\\x22ktf mini cdr_mm cdr_min\\x22 autocomplete\\x3d\\x22off\\x22 tabindex\\x3d\\x221\\x22 jsaction\\x3d\\x22focus:r.9Ak-cPSnJQs\\x22 data-rtid\\x3d\\x22top_nav-2\\x22 jsl\\x3d\\x22$x 4;\\x22\\x3e\\x3cinput type\\x3d\\x22text\\x22 value\\x3d\\x22\\x22 class\\x3d\\x22ktf mini cdr_mm cdr_max\\x22 autocomplete\\x3d\\x22off\\x22 tabindex\\x3d\\x221\\x22 jsaction\\x3d\\x22focus:r.9Ak-cPSnJQs\\x22 data-rtid\\x3d\\x22top_nav-2\\x22 jsl\\x3d\\x22$x 5;\\x22\\x3e\\x3cinput class\\x3d\\x22ksb mini cdr_go\\x22 value\\x3d\\x22Go\\x22 tabindex\\x3d\\x221\\x22 type\\x3d\\x22submit\\x22 jsaction\\x3d\\x22tbt.scf\\x22\\x3e\\x3c/form\\x3e\\x3c/div\\x3e\\x3c/div\\x3e\\x3c/div\\x3e\\x3c/div\\x3e\\x3c/li\\x3e\\x3c/ul\\x3e\\x3cspan class\\x3d\\x22_Vxd\\x22\\x3e\\x3c/span\\x3e\\x3cdiv class\\x3d\\x22hdtb-mn-hd\\x22 aria-haspopup\\x3d\\x22true\\x22 role\\x3d\\x22button\\x22 tabindex\\x3d\\x220\\x22\\x3e\\x3cdiv class\\x3d\\x22mn-hd-txt\\x22\\x3eAll results\\x3c/div\\x3e\\x3cspan class\\x3d\\x22mn-dwn-arw\\x22\\x3e\\x3c/span\\x3e\\x3c/div\\x3e\\x3cul class\\x3d\\x22hdtbU hdtb-mn-c\\x22\\x3e\\x3cli class\\x3d\\x22hdtbItm hdtbSel\\x22 id\\x3d\\x22whv_\\x22 tabindex\\x3d\\x220\\x22\\x3eAll results\\x3c/li\\x3e\\x3cli class\\x3d\\x22hdtbItm\\x22 id\\x3d\\x22rl_1\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22/search?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnt\\x26amp;tbs\\x3drl:1\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CBMQpwU\\x22\\x3eReading level\\x3c/a\\x3e\\x3c/li\\x3e\\x3cli class\\x3d\\x22hdtbItm\\x22 id\\x3d\\x22li_1\\x22\\x3e\\x3ca class\\x3d\\x22q qs\\x22 href\\x3d\\x22/search?q\\x3dhotel+in+udaipur\\x26amp;biw\\x3d1366\\x26amp;bih\\x3d648\\x26amp;source\\x3dlnt\\x26amp;tbs\\x3dli:1\\x26amp;sa\\x3dX\\x26amp;ei\\x3d_N8PVcSiDoL8ugTQq4II\\x26amp;sqi\\x3d2\\x26amp;ved\\x3d0CBMQpwU\\x22\\x3eVerbatim\\x3c/a\\x3e\\x3c/li\\x3e\\x3c/ul\\x3e\\x3cspan class\\x3d\\x22_Vxd\\x22\\x3e\\x3c/span\\x3e\\x3cdiv class\\x3d\\x22hdtb-mn-hd\\x22 aria-haspopup\\x3d\\x22true\\x22 role\\x3d\\x22button\\x22 tabindex\\x3d\\x220\\x22\\x3e\\x3cdiv class\\x3d\\x22mn-hd-txt\\x22\\x3eUdaipur, Rajasthan\\x3c/div\\x3e\\x3cspan class\\x3d\\x22mn-dwn-arw\\x22\\x3e\\x3c/span\\x3e\\x3c/div\\x3e\\x3cul class\\x3d\\x22hdtbU hdtb-mn-c\\x22\\x3e\\x3cli class\\x3d\\x22hdtbItm hdtbSel\\x22 tabindex\\x3d\\x220\\x22\\x3eUdaipur, Rajasthan\\x3c/li\\x3e\\x3cli id\\x3d\\x22set_location_section\\x22 style\\x3d\\x22display:block\\x22\\x3e\\x3cul\\x3e\\x3cli class\\x3d\\x22hdtbItm\\x22\\x3e\\x3ca href\\x3d\\x22#\\x22 jsaction\\x3d\\x22loc.dloc\\x22\\x3eUse my location\\x3c/a\\x3e\\x3ca class\\x3d\\x22fl\\x22 href\\x3d\\x22/support/websearch/bin/answer.py?answer\\x3d179386\\x26amp;hl\\x3den\\x22\\x3e\\x3cspan style\\x3d\\x22font-size:11px\\x22\\x3eAuto-detected\\x3c/span\\x3e\\x3c/a\\x3e\\x3c/li\\x3e\\x3cli class\\x3d\\x22hdtbItm hdtb-loc\\x22\\x3e\\x3cdiv id\\x3d\\x22_Zpd\\x22\\x3e\\x3cinput class\\x3d\\x22ktf mini\\x22 style\\x3d\\x22margin-left:0\\x22 id\\x3d\\x22lc-input\\x22 value\\x3d\\x22Enter location\\x22 type\\x3d\\x22text\\x22 jsaction\\x3d\\x22keypress:loc.kp;blur:loc.stt;focus:loc.htt\\x22\\x3e\\x3cinput class\\x3d\\x22ksb mini\\x22 style\\x3d\\x22margin-left:5px\\x22 value\\x3d\\x22Set\\x22 type\\x3d\\x22submit\\x22 jsaction\\x3d\\x22loc.s\\x22\\x3e\\x3c/div\\x3e\\x3cdiv id\\x3d\\x22error_section\\x22 style\\x3d\\x22display:block;font-size:11px\\x22\\x3e\\x3c/div\\x3e\\x3c/li\\x3e\\x3c/ul\\x3e\\x3c/li\\x3e\\x3c/ul\\x3e\\x3c/div\\x3e'');})();(function(){(function(){var sn=''web'';google.sn=sn;})();})();(function(){(function(){var s=''0_tpZvcbukZPrPYQMLEY5wKNYxp1M\\075'';google.loc=google.loc||{};google.loc.s=s;})();})();(function(){(function(){var ctx=["top_nav",[["t--24YyUDCiR8","top_nav-1","r-top_nav-1",[["top_nav","1",[2,182]\r\n,[-1,-1]\r\n]\r\n]\r\n]\r\n,["t-t_nYWbCdeK4","top_nav-2","r-top_nav-2",[["data","1",[2,182,4,3,1,4,2,4]\r\n,[-1,-1,-1,-1,1,-1,6,-1]\r\n]\r\n]\r\n,,"ttbcdr"]\r\n]\r\n,,,[["1","[,[,,,{\\"182\\":[0,0,0,[,,[[[]\\n,[,,,[,[[]\\n,[]\\n,[]\\n,[]\\n,[]\\n,[]\\n,[,,,[,,,,,,,,,1]\\n]\\n]\\n]\\n]\\n]\\n]\\n]\\n,,,,,1]\\n}]\\n]\\n"]\r\n]\r\n]\r\n;try{google.jsc.x(ctx);}catch(e){}})();})();(function(){(function(){var ctx=["taw",[["t-A6yEzBVJ018","taw-3","r-taw-3"]\r\n,["t-YDfv1cNv3GI","taw-4","r-taw-4"]\r\n,["t-zxXzjt1d4B0","taw-5","r-taw-5",[["tweaks_feature","g-qwseIMlKvck"]\r\n]\r\n]\r\n,["t-zxXzjt1d4B0","taw-6","r-taw-6",[["tweaks_feature","g-qwseIMlKvck"]\r\n]\r\n]\r\n,["t-A6yEzBVJ018","taw-7","r-taw-7"]\r\n,["t-y3Vq91bkxp8","taw-8","r-taw-8"]\r\n]\r\n,,,[["g-qwseIMlKvck","[{\\"25572067\\":2,\\"79907896\\":0,\\"240748472\\":0}]\\n",,,,,1]\r\n]\r\n]\r\n;try{google.jsc.x(ctx);}catch(e){}})();})();(function(){(function(){var ctx=["search",[["t-SQvYJToREhU","search-9","r-search-9"]\r\n,["t-9yGOL8ZmD70","search-10","r-search-10",[["data","1",[2,157,1,2,23126780,4,22]\r\n,[-1,-1,1,-1,-1,0,-1]\r\n]\r\n]\r\n,,"hp"]\r\n,["t-SQvYJToREhU","search-11","r-search-11"]\r\n,["t-9yGOL8ZmD70","search-12","r-search-12",[["data","1",[2,157,1,2,23126780,4,22]\r\n,[-1,-1,1,-1,-1,1,-1]\r\n]\r\n]\r\n,,"hp"]\r\n,["t-SQvYJToREhU","search-13","r-search-13"]\r\n,["t-9yGOL8ZmD70","search-14","r-search-14",[["data","1",[2,157,1,2,23126780,4,22]\r\n,[-1,-1,1,-1,-1,2,-1]\r\n]\r\n]\r\n,,"hp"]\r\n,["t-SQvYJToREhU","search-15","r-search-15"]\r\n,["t-9yGOL8ZmD70","search-16","r-search-16",[["data","1",[2,157,1,2,23126780,4,22]\r\n,[-1,-1,1,-1,-1,3,-1]\r\n]\r\n]\r\n,,"hp"]\r\n,["t-SQvYJToREhU","search-17","r-search-17"]\r\n,["t-9yGOL8ZmD70","search-18","r-search-18",[["data","1",[2,157,1,2,23126780,4,22]\r\n,[-1,-1,1,-1,-1,4,-1]\r\n]\r\n]\r\n,,"hp"]\r\n,["t-SQvYJToREhU","search-19","r-search-19"]\r\n,["t-9yGOL8ZmD70","search-20","r-search-20",[["data","1",[2,157,1,2,23126780,4,22]\r\n,[-1,-1,1,-1,-1,5,-1]\r\n]\r\n]\r\n,,"hp"]\r\n,["t-SQvYJToREhU","search-21","r-search-21"]\r\n,["t-9yGOL8ZmD70","search-22","r-search-22",[["data","1",[2,157,1,2,23126780,4,22]\r\n,[-1,-1,1,-1,-1,6,-1]\r\n]\r\n]\r\n,,"hp"]\r\n,["t-RyNGFvRvxmg","search-23","r-search-23"]\r\n,["t-ONSAXnzyl6g","search-24","r-search-24",[["ux","g-Ujq4GsYYEvU"]\r\n]\r\n,,"lcm"]\r\n]\r\n,,,[["1","[,[,,,{\\"157\\":[[[]\\n,[,[,,,,,,,,,,,,,,{\\"23126780\\":[,,,[[,,,,,,,,,,,,,,,,,,,,,[\\"Rs.&nbsp;36,099\\",\\"18222597225991982926\\",,,[[[\\"\\\\u003cb\\\\u003eRs.&nbsp;35,000\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Agoda.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DWwAAAHbhY9INjSW4B_XjSIJ31KQ4XadC7ZOgpVkkgPTjGHgxNjb1XCdL9B-WIN9HEDQ2JH1pDMVrGwibcG9bpO5PtlDc9AUQF4MUdAbi_94_oGw6wmICom9M7EAu2SdXOnFgvg\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGILGv4Z29Rmv1Q-BGm3W1oCNEFmg\\",\\"Rs.&nbsp;36,099\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;35,000\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Booking.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DYQAAAFNoNuJmfaaU0_ugOdoJ6wc4XadC7ZOgpVkkgPTjGHgxNsermwnOOScpUkJ4xOOPjzcmhnGdF01_UaHv_aBzbKpHP6L-ULTX3WWF0uVGZmGYp41EVDs3fXJWRaA8W4rVb41RrshM_r5sq_8solqF4F4\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNG0mOJfFWnPkn05afrYDwD1UcSnXw\\",\\"Rs.&nbsp;41,097\\",0]\\n]\\n,0,\\"2015-04-05\\",\\"2015-04-06\\",\\"dd/MM\\",\\"www.oberoihotels.com\\",\\"http://www.google.co.in/url?url\\\\u003dhttp://www.oberoihotels.com/hotels-in-udaipur/\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGJkgNy3ZGz8mG-Kwd-TcugiDJklg\\",\\"Currency disclaimer\\",\\"Owner site\\",\\"Ads\\",\\"Updating...\\",\\"Check in:\\",\\"Check out:\\",\\"per night\\",\\"No known availability for these dates\\",\\"CJWhgdyXvsQCFQQ8jgodojsAFA\\",\\"18222597225991982926;2444188424022556314;2015-04-05;1\\"]\\n]\\n]\\n,[,,,,,,,,,,,,,,,,,,,,,[\\"Rs.&nbsp;38,629\\",\\"5688668178641500843\\",,,[[[\\"\\\\u003cb\\\\u003eRs.&nbsp;33,000\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Agoda.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DWwAAAHbhY9INjSW4B_XjSIJ31KTuOBilZtqm9-Ut8oQOB7vgKXgn_09DE9S-vTUQLUm9q_EeQgWM8yAps8Lv7G9Cl9Dc9AUQF4MUdAbi_94_oGw6wmICom9M7EAu2SdXOnFgvg\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNE3djZVAZpWZNTXpm05g65__wpCtQ\\",\\"Rs.&nbsp;38,749\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;33,000\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Booking.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DYQAAAFNoNuJmfaaU0_ugOdoJ6wfuOBilZtqm9-Ut8oQOB7vgkP5-BUod8s-Twtjk_tJHvoFvQ7ZAfylqu0h1mLM_xP1T7RhQ_euCMrwRIQJDagCnp41EVDs3fXJWRaA8W4rVb41RrshM_r5sq_8solqF4F4\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGfsgFlJT2fk2sS-qkPd5tSdppo2Q\\",\\"Rs.&nbsp;38,749\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;32,898\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Hotels.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DaAAAACl0KlSMl2wXAIdmbb6jbOTuOBilZtqm9-Ut8oQOB7vgvga4XUlLgA7i9RlgzYsm9LjnyGCwFK11S_lY18INOxAVv1UGM7mXdlwVOl1mZ0sO2KsO80wWupYBiJxRjOs7aG3AFfD4xK7tXgpoHdoHol0\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNFtKh7Huz4T3nyfqM-f5cVd5eAGyQ\\",\\"Rs.&nbsp;38,629\\",0]\\n]\\n,1,\\"2015-04-05\\",\\"2015-04-06\\",\\"dd/MM\\",\\"www.tajhotels.com\\",\\"http://www.google.co.in/url?url\\\\u003dhttp://www.tajhotels.com/\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGa8643_7CuIONnpbD1NUiccYwlbw\\",\\"Currency disclaimer\\",\\"Owner site\\",\\"Ads\\",\\"Updating...\\",\\"Check in:\\",\\"Check out:\\",\\"per night\\",\\"No known availability for these dates\\",\\"CJWhgdyXvsQCFQQ8jgodojsAFA\\",\\"5688668178641500843;2812662043869934659;2015-04-05;1\\"]\\n]\\n]\\n,[,,,,,,,,,,,,,,,,,,,,,[\\"Rs.&nbsp;31,149\\",\\"9608916247815826996\\",,,[[[\\"\\\\u003cb\\\\u003eRs.&nbsp;29,000\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Cleartrip.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DXwAAAB2AHwTs5d42FO6FtwwNmZpHR8igPnKan-U5oafKp6MFVDa2kGOTPtK4vydexccmhpyiIPfmp4ZEHY2MqwiU7SZzdxMYVM0c24ZeVyAUpHZC9qretgO-sUJrhPGfrbz-7Q\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNG6-tJGGQVXwQgvJh78vAB8Yo2gIA\\",\\"Rs.&nbsp;31,152\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;29,000\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Agoda.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DWwAAAHbhY9INjSW4B_XjSIJ31KRHR8igPnKan-U5oafKp6MF0ei3VkBWx0v2muBbjvHGrswaadWhRYzcCDw2IV__6WXc9AUQF4MUdAbi_94_oGw6wmICom9M7EAu2SdXOnFgvg\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNG4JrdW_E85GbuwoplDAuDdGsGAyQ\\",\\"Rs.&nbsp;31,149\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;29,000\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Booking.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DYQAAAFNoNuJmfaaU0_ugOdoJ6wdHR8igPnKan-U5oafKp6MFWT85e3s5eizXqPK36XRvOd9fLukAPd7GJy5HOCMEswVukvbZkx9BDTU2pY0wnN7zp41EVDs3fXJWRaA8W4rVb41RrshM_r5sq_8solqF4F4\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNG6FCxhRVAeGojWtMz4A8L7SnzmrQ\\",\\"Rs.&nbsp;31,152\\",0]\\n]\\n,0,\\"2015-04-05\\",\\"2015-04-06\\",\\"dd/MM\\",\\"www.theleela.com\\",\\"/url?url\\\\u003dhttps://www.theleela.com/hotel-udaipur.html\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGTeGHTMTUZnVumTSbIV1SM0aA-ZQ\\",\\"Currency disclaimer\\",\\"Owner site\\",\\"Ads\\",\\"Updating...\\",\\"Check in:\\",\\"Check out:\\",\\"per night\\",\\"No known availability for these dates\\",\\"CJWhgdyXvsQCFQQ8jgodojsAFA\\",\\"9608916247815826996;13691445501602073001;2015-04-05;1\\"]\\n]\\n]\\n,[,,,,,,,,,,,,,,,,,,,,,[\\"Rs.&nbsp;3454\\",\\"11036616001797658676\\",,,[[[\\"\\\\u003cb\\\\u003eRs.&nbsp;3495\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Cleartrip.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DXgAAAG1sqERoEvj3yjryzGTjvH2DYKQ3_kUGeV3subq3BGORMVSdeUEOc_F5en0qNQUg67uR9gOM1R8rRknASqsn1EHoovCuxk61UsLtVrfkj74_O7RDrh0_0PYD8w9wZnuA2g\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNFLdw8aREcgmGuj8H7YRyiIk00TRQ\\",\\"Rs.&nbsp;3495\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;3141\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Expedia.co.in\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DZAAAAO001mPleXZXNh9f9gIuJyeDYKQ3_kUGeV3subq3BGORxMHOWC-M1M12UGiwABJlOfsBd_OV_QkM7muuEtkWqPlE0FC7fL7qCwWgh9nBtdOTnCBi_lVABZpfWD1QmksDNHSOs8G3tmyqn26851eFdlI\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGT0jIoi79YICxwR5cYFRHT5Pythw\\",\\"Rs.&nbsp;3454\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;3254\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Agoda.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DWgAAAPYryaG66eMBJm5y746cmq6DYKQ3_kUGeV3subq3BGORGT5iibkDnDACSgD2EJsIYqxJjjYVT-xqeeYD3sAeLkk1eBS7bTtZsJMTIm49zMhjt3dmdGlLxaLePymyL-HEMg\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNFbgD3D7-lMK2yaEutu-XrzaNMDag\\",\\"Rs.&nbsp;3495\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;3254\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Booking.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DYAAAAB0XAeKlWPCyp3ZzOP0AZSCDYKQ3_kUGeV3subq3BGORKPO_5KqUXBU63pWSURnoJz1xFfx1jpKqs1wRXx__LeNGlGKb9XZV5Ux4mBAihCELlxVgmftAOp4uYcqKPBIq7g\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGAdHnuE4BM05199EKiob8OTV1biA\\",\\"Rs.&nbsp;3495\\",0]\\n]\\n,1,\\"2015-04-05\\",\\"2015-04-06\\",\\"dd/MM\\",\\"www.jaiwanahaveli.com\\",\\"http://www.google.co.in/url?url\\\\u003dhttp://www.jaiwanahaveli.com/\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNFpVaLsoD7JO6W4ezEtJXrvzgXJwA\\",\\"Currency disclaimer\\",\\"Owner site\\",\\"Ads\\",\\"Updating...\\",\\"Check in:\\",\\"Check out:\\",\\"per night\\",\\"No known availability for these dates\\",\\"CJWhgdyXvsQCFQQ8jgodojsAFA\\",\\"11036616001797658676;16183137597538285113;2015-04-05;1\\"]\\n]\\n]\\n,[,,,,,,,,,,,,,,,,,,,,,[\\"Rs.&nbsp;3000\\",\\"4736755651684622536\\",,,[[[\\"\\\\u003cb\\\\u003eRs.&nbsp;3000\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Cleartrip.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DXgAAAG1sqERoEvj3yjryzGTjvH2ezYk1FRiRrgekH89ZsqfosQ6zRoehUK2YENifOakdoC4AOFssnFn20GSihAuIg8HoovCuxk61UsLtVrfkj74_O7RDrh0_0PYD8w9wZnuA2g\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGIUgGYxuwSd1aYVKGHTYCY1pA5kg\\",\\"Rs.&nbsp;3000\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;2555\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Agoda.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DWgAAAPYryaG66eMBJm5y746cmq6ezYk1FRiRrgekH89ZsqfotqdKOREY-6YsCy4ERI2_HmokMKKHFqW75A9LBTo9Wcw1eBS7bTtZsJMTIm49zMhjt3dmdGlLxaLePymyL-HEMg\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNF9E9ku6BCHQmQj9gt4Tvp-VzPryw\\",\\"Rs.&nbsp;3000\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;4500\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Booking.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DYAAAAB0XAeKlWPCyp3ZzOP0AZSCezYk1FRiRrgekH89Zsqfo2O8RzHcyE41iSB-0a6NkwjIW73iXjl9TEpGIO5wYa4G-mXhP7GhQ5EttoeuJ3QKBlxVgmftAOp4uYcqKPBIq7g\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGX7FMaP3DZSPebkKN6rgQt8t8-BA\\",\\"Rs.&nbsp;4834\\",0]\\n]\\n,0,\\"2015-04-05\\",\\"2015-04-06\\",\\"dd/MM\\",\\"www.udaipurhotelhilltoppalace.com\\",\\"http://www.google.co.in/url?url\\\\u003dhttp://www.udaipurhotelhilltoppalace.com/\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNHpmR3xHSpRqqCfCZVbv_8nJ2i-2A\\",\\"Currency disclaimer\\",\\"Owner site\\",\\"Ads\\",\\"Updating...\\",\\"Check in:\\",\\"Check out:\\",\\"per night\\",\\"No known availability for these dates\\",\\"CJWhgdyXvsQCFQQ8jgodojsAFA\\",\\"4736755651684622536;7289077235145864026;2015-04-05;1\\"]\\n]\\n]\\n,[,,,,,,,,,,,,,,,,,,,,,[\\"Rs.&nbsp;1101\\",\\"11350637285775910635\\",,,[[[\\"\\\\u003cb\\\\u003eRs.&nbsp;1101\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Cleartrip.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DXgAAAG1sqERoEvj3yjryzGTjvH3n_HtQYjx-K68G6tqZbaPDCdb298h0ruCzFNeYmYdL-KAzLKbByEhML2aa3M2xzqvoovCuxk61UsLtVrfkj74_O7RDrh0_0PYD8w9wZnuA2g\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNEeAjhxKf5u_v2K6maARrKsb34YMg\\",\\"Rs.&nbsp;1101\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;1101\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"MakeMyTrip.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DXwAAAB2AHwTs5d42FO6FtwwNmZrn_HtQYjx-K68G6tqZbaPDGACTbOdTnk2J-6NZkENMdFh2vtRTBrXqKIcjzU0WaRpQWe-qsiYb3jeMVBvhEPTa9qretgO-sUJrhPGfrbz-7Q\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNEsJ1LzcuEjNn-TMkVXDN-dUdoXxw\\",\\"Rs.&nbsp;1101\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;1338\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Hotels.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DZwAAAEUCu0z28y-auwrCKRTco4bn_HtQYjx-K68G6tqZbaPD_kTScSMKLHgDLYYkZ4RpGy7xwNYM0nexmL_jTebr3OqHAejMwFutwS9m10eeBPjAEoLRuteam8cuxFouQLbNNuka8R_QRVyJn8ondMmdI74\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNE13I7wwOW6x66VuyyOu-Yy51_10A\\",\\"Rs.&nbsp;1572\\",0]\\n,[\\"\\\\u003cb\\\\u003eRs.&nbsp;1618\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Agoda.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DWgAAAPYryaG66eMBJm5y746cmq7n_HtQYjx-K68G6tqZbaPDD2NnMM6m0ocrcUybCrlVeesJ00PtCygXkSYAon-iJPY1eBS7bTtZsJMTIm49zMhjt3dmdGlLxaLePymyL-HEMg\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGZgpySr3me4M6xZT-Flwl1LjCAxg\\",\\"Rs.&nbsp;1900\\",0]\\n]\\n,1,\\"2015-04-05\\",\\"2015-04-06\\",\\"dd/MM\\",\\"www.anjanihotel.com\\",\\"http://www.google.co.in/url?url\\\\u003dhttp://www.anjanihotel.com/\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGZAt07ARkr4Fpkyv-FNi_-_-RkNA\\",\\"Currency disclaimer\\",\\"Owner site\\",\\"Ads\\",\\"Updating...\\",\\"Check in:\\",\\"Check out:\\",\\"per night\\",\\"No known availability for these dates\\",\\"CJWhgdyXvsQCFQQ8jgodojsAFA\\",\\"11350637285775910635;13821642921912103343;2015-04-05;1\\"]\\n]\\n]\\n,[,,,,,,,,,,,,,,,,,,,,,[\\"Rs.&nbsp;1611\\",\\"15445488307212559634\\",,,[[[\\"\\\\u003cb\\\\u003eRs.&nbsp;1372\\\\u003c/b\\\\u003e plus taxes \\\\u0026amp; fees\\",\\"Agoda.com\\",\\"/url?url\\\\u003dhttps://www.google.com/travel/clk%3Fpc%3DWgAAAPYryaG66eMBJm5y746cmq56V4YsfxV7Zbr7KTo-lNFRWPQxEbnlrT1Q3NRnXYvju1RFZ1uwy3jHwl8ZE0NaLG81eBS7bTtZsJMTIm49zMhjt3dmdGlLxaLePymyL-HEMg\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNG5hcHF6UfeKs7YaeFC3eosrfM1Lg\\",\\"Rs.&nbsp;1611\\",0]\\n]\\n,0,\\"2015-04-05\\",\\"2015-04-06\\",\\"dd/MM\\",\\"www.mandirampalace.com\\",\\"http://www.google.co.in/url?url\\\\u003dhttp://www.mandirampalace.com/\\\\u0026rct\\\\u003dj\\\\u0026q\\\\u003d\\\\u0026esrc\\\\u003ds\\\\u0026usg\\\\u003dAFQjCNGcz3TcTOau5vHWYnm2PVEFFyEGQA\\",\\"Currency disclaimer\\",\\"Owner site\\",\\"Ads\\",\\"Updating...\\",\\"Check in:\\",\\"Check out:\\",\\"per night\\",\\"No known availability for these dates\\",\\"CJWhgdyXvsQCFQQ8jgodojsAFA\\",\\"15445488307212559634;6432694147088773307;2015-04-05;1\\"]\\n]\\n]\\n]\\n]\\n}]\\n]\\n]\\n]\\n}]\\n]\\n"]\r\n,["g-Ujq4GsYYEvU","[{\\"180490977\\":0}]\\n",,,,,1]\r\n]\r\n]\r\n;try{google.jsc.x(ctx);}catch(e){}})();})();(function(){(function(){var ctx=["rhscol",[["t-5RRekjfu2Ys","rhscol-25","r-rhscol-25",[["ec","1",[2,72,27]\r\n,[-1,-1,-1]\r\n]\r\n]\r\n]\r\n,["t-A6yEzBVJ018","rhscol-26","r-rhscol-26"]\r\n,["t-YDfv1cNv3GI","rhscol-27","r-rhscol-27"]\r\n,["t-zxXzjt1d4B0","rhscol-28","r-rhscol-28",[["tweaks_feature","g-qwseIMlKvck"]\r\n]\r\n]\r\n,["t-zxXzjt1d4B0","rhscol-29","r-rhscol-29",[["tweaks_feature","g-qwseIMlKvck"]\r\n]\r\n]\r\n,["t-zxXzjt1d4B0","rhscol-30","r-rhscol-30",[["tweaks_feature","g-qwseIMlKvck"]\r\n]\r\n]\r\n,["t-zxXzjt1d4B0","rhscol-31","r-rhscol-31",[["tweaks_feature","g-qwseIMlKvck"]\r\n]\r\n]\r\n,["t-zxXzjt1d4B0","rhscol-32","r-rhscol-32",[["tweaks_feature","g-qwseIMlKvck"]\r\n]\r\n]\r\n,["t-zxXzjt1d4B0","rhscol-33","r-rhscol-33",[["tweaks_feature","g-qwseIMlKvck"]\r\n]\r\n]\r\n,["t-zxXzjt1d4B0","rhscol-34","r-rhscol-34",[["tweaks_feature","g-qwseIMlKvck"]\r\n]\r\n]\r\n,["t-zxXzjt1d4B0","rhscol-35","r-rhscol-35",[["tweaks_feature","g-qwseIMlKvck"]\r\n]\r\n]\r\n]\r\n,,,[["1","[,[,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,[,,,,,,,,,,,,,,,,,,,,,,,,,,[1,1,,1072,1160]\\n]\\n]\\n]\\n"]\r\n,["g-qwseIMlKvck","[{\\"25572067\\":2,\\"79907896\\":0,\\"240748472\\":0}]\\n",,,,,1]\r\n]\r\n]\r\n;try{google.jsc.x(ctx);}catch(e){}})();})();if(google.med){google.med(''init'');google.initHistory();google.med(''history'');}});if(google.j&amp;&amp;google.j.en&amp;&amp;google.j.xi){window.setTimeout(google.j.xi,0);}\r\n</script></div></div></div></div><div id="lfoot" data-jiis="uc" data-jibp="h" style=""></div></div></div><script>(function(){var _mstr=''\\74span class\\75ctr-p id\\75body data-jiis\\75bp\\76\\74/span\\76\\74span class\\75ctr-p id\\75footer data-jiis\\75bp\\76\\74/span\\76\\74span id\\75xjsi\\76\\74/span\\076'';var commands = [];var index = 0;var gstyle = document.getElementById(''gstyle'');if (gstyle){commands[index++]=\r\n{''n'':''pcs'',''i'':''gstyle'',''css'':gstyle.innerHTML,''is'':'''',''r'':true,''sc'':true};}\r\ncommands[index++]=\r\n{''n'':''pc'',''i'':''cst'',''h'':document.getElementById(''cst'').innerHTML,''is'':'''',''r'':true,''sc'':true};commands[index]=\r\n{''n'':''pc'',''i'':''main'',''h'':_mstr,''is'':'''',''r'':true,''sc'':true};google.j[1]={cmds:commands};})();</script><script id="ecs" data-url="/extern_chrome/e32e0a7f016fa2cf.js?bav=or."></script><script>this.gbar_=this.gbar_||{};(function(_){var window=this;\r\ntry{\r\n_.jb=function(a){var c=_.La;c.d?a():c.b.push(a)};_.kb=function(){};_.lb=function(a){_.lb[" "](a);return a};_.lb[" "]=_.kb;\r\n}catch(e){_._DumpException(e)}\r\ntry{\r\nvar gh;gh=function(a){if(a.classList)return a.classList;a=a.className;return _.t(a)&amp;&amp;a.match(/\\S+/g)||[]};_.R=function(a,c){return a.classList?a.classList.contains(c):_.ra(gh(a),c)};_.S=function(a,c){a.classList?a.classList.add(c):_.R(a,c)||(a.className+=0&lt;a.className.length?" "+c:c)};\r\n_.hh=function(a,c){if(a.classList)(0,_.ma)(c,function(c){_.S(a,c)});else{var d={};(0,_.ma)(gh(a),function(a){d[a]=!0});(0,_.ma)(c,function(a){d[a]=!0});a.className="";for(var e in d)a.className+=0&lt;a.className.length?" "+e:e}};_.T=function(a,c){a.classList?a.classList.remove(c):_.R(a,c)&amp;&amp;(a.className=(0,_.na)(gh(a),function(a){return a!=c}).join(" "))};_.ih=function(a,c){a.classList?(0,_.ma)(c,function(c){_.T(a,c)}):a.className=(0,_.na)(gh(a),function(a){return!_.ra(c,a)}).join(" ")};\r\n\r\n}catch(e){_._DumpException(e)}\r\ntry{\r\nvar ak,ik,lk,kk;_.Vj=function(a){_.A(this,a,0,null)};_.w(_.Vj,_.z);_.Wj=function(){return _.D(_.J(),_.Vj,11)};_.Xj=function(a){_.A(this,a,0,null)};_.w(_.Xj,_.z);_.Zj=function(){var a=_.Yj();return _.B(a,9)};ak=function(a){_.A(this,a,0,null)};_.w(ak,_.z);_.bk=function(a){return null!=_.B(a,2)?_.B(a,2):.001};_.ck=function(a){_.A(this,a,0,null)};_.w(_.ck,_.z);var dk=function(a){return null!=_.B(a,3)?_.B(a,3):1},ek=function(a){return null!=_.B(a,2)?_.B(a,2):1E-4},fk=function(a){_.A(this,a,0,null)};\r\n_.w(fk,_.z);_.gk=function(a){return _.B(a,10)};_.hk=function(a){return _.B(a,5)};_.Yj=function(){return _.D(_.J(),ak,4)||new ak};_.jk=function(a){var c="//www.google.com/gen_204?",c=c+a.d(2040-c.length);ik(c)};ik=function(a){var c=new window.Image,d=kk;c.onerror=c.onload=c.onabort=function(){d in lk&amp;&amp;delete lk[d]};lk[kk++]=c;c.src=a};lk=[];kk=0;\r\n_.mk=function(){this.data={}};_.mk.prototype.b=function(){window.console&amp;&amp;window.console.log&amp;&amp;window.console.log("Log data: ",this.data)};_.mk.prototype.d=function(a){var c=[],d;for(d in this.data)c.push((0,window.encodeURIComponent)(d)+"="+(0,window.encodeURIComponent)(String(this.data[d])));return("atyp=i&amp;zx="+(new Date).getTime()+"&amp;"+c.join("&amp;")).substr(0,a)};\r\nvar nk=function(a){this.b=a};nk.prototype.log=function(a,c){try{if(this.A(a)){var d=this.k(a,c);this.d(d)}}catch(e){}};nk.prototype.d=function(a){this.b?a.b():_.jk(a)};var ok=function(a,c){this.data={};var d=_.D(a,_.wa,8)||new _.wa;this.data.ei=_.G(_.gk(a));this.data.ogf=_.G(_.B(d,3));var e;e=window.google&amp;&amp;window.google.sn?/.*hp$/.test(window.google.sn)?!1:!0:_.F(_.B(a,7));this.data.ogrp=e?"1":"";this.data.ogv=_.G(_.B(d,6))+"."+_.G(_.B(d,7));this.data.ogd=_.G(_.B(a,21));this.data.ogc=_.G(_.B(a,20));this.data.ogl=_.G(_.hk(a));c&amp;&amp;(this.data.oggv=c)};_.w(ok,_.mk);\r\n_.pk=function(a,c,d,e,f){ok.call(this,a,c);_.ua(this.data,{jexpid:_.G(_.B(a,9)),srcpg:"prop="+_.G(_.B(a,6)),jsr:Math.round(1/e),emsg:d.name+":"+d.message});if(f){f._sn&amp;&amp;(f._sn="og."+f._sn);for(var g in f)this.data[(0,window.encodeURIComponent)(g)]=f[g]}};_.w(_.pk,ok);\r\nvar qk=[1,2,3,4,5,6,9,10,11,13,14,28,29,30,34,35,37,38,39,40,41,42,43,48,49,50,51,52,53,500],tk=function(a,c,d,e,f,g){ok.call(this,a,c);_.ua(this.data,{oge:e,ogex:_.G(_.B(a,9)),ogp:_.G(_.B(a,6)),ogsr:Math.round(1/(rk(e)?_.H(dk(d)):_.H(ek(d)))),ogus:f});if(g){"ogw"in g&amp;&amp;(this.data.ogw=g.ogw,delete g.ogw);"ved"in g&amp;&amp;(this.data.ved=g.ved,delete g.ved);a=[];for(var h in g)0!=a.length&amp;&amp;a.push(","),a.push(sk(h)),a.push("."),a.push(sk(g[h]));g=a.join("");""!=g&amp;&amp;(this.data.ogad=g)}};_.w(tk,ok); var sk=function(a){return(a+"").replace(".","%2E").replace(",","%2C")},uk=null,rk=function(a){if(!uk){uk={};for(var c=0;c&lt;qk.length;c++)uk[qk[c]]=!0}return!!uk[a]};\r\nvar vk=function(a,c,d,e,f){this.b=f;this.F=a;this.O=c;this.ea=e;this.B=_.H(ek(a),1E-4);this.w=_.H(dk(a),1);c=Math.random();this.C=_.F(_.B(a,1))&amp;&amp;c&lt;this.B;this.o=_.F(_.B(a,1))&amp;&amp;c&lt;this.w;a=0;_.F(_.B(d,1))&amp;&amp;(a|=1);_.F(_.B(d,2))&amp;&amp;(a|=2);_.F(_.B(d,3))&amp;&amp;(a|=4);this.J=a};_.w(vk,nk);vk.prototype.A=function(a){return this.b||(rk(a)?this.o:this.C)};vk.prototype.k=function(a,c){return new tk(this.O,this.ea,this.F,a,this.J,c)};\r\nvar wk=function(a,c,d,e){this.b=e;this.F=c;this.ea=d;this.w=_.H(_.bk(a),.001);this.O=_.F(_.B(a,1))&amp;&amp;Math.random()&lt;this.w;c=null!=_.B(a,3)?_.B(a,3):1;this.C=_.H(c,1);this.o=0;a=null!=_.B(a,4)?_.B(a,4):!0;this.B=_.F(a,!0)};_.w(wk,nk);wk.prototype.log=function(a,c){wk.G.log.call(this,a,c);if(this.b&amp;&amp;this.B)throw a;};wk.prototype.A=function(){return this.b||this.O&amp;&amp;this.o&lt;this.C};wk.prototype.k=function(a,c){try{return _.za(_.ya.N(),"lm").uf(a,c)}catch(d){return new _.pk(this.F,this.ea,a,this.w,c)}}; wk.prototype.d=function(a){wk.G.d.call(this,a);this.o++};\r\nvar xk;xk=null;_.yk=function(){if(!xk){var a=_.D(_.J(),_.ck,13)||new _.ck,c=_.Na(),d=_.Zj();xk=new wk(a,c,d,_.Ja)}return xk};_.I=function(a,c){_.yk().log(a,c)};_.zk=function(a,c){return function(){try{return a.apply(c,arguments)}catch(d){_.I(d)}}};var Ak;Ak=null;_.Bk=function(){if(!Ak){var a=_.D(_.J(),fk,12)||new fk,c=_.Na(),d=_.Wj()||new _.Vj,e=_.Zj();Ak=new vk(a,c,d,e,_.Ja)}return Ak};_.V=function(a,c){_.Bk().log(a,c)};_.V(8,{m:"BackCompat"==window.document.compatMode?"q":"s"});\r\n}catch(e){_._DumpException(e)}\r\ntry{\r\nvar Ck,Gk,Ik;Ck=[3,5];_.Dk=function(a){_.A(this,a,0,Ck)};_.w(_.Dk,_.z);var Ek=function(a){_.A(this,a,0,null)};_.w(Ek,_.z);_.Fk=function(a){_.A(this,a,0,null)};_.w(_.Fk,_.z);_.Fk.prototype.Qa=function(){return _.B(this,6)};\r\n_.Hk=function(a,c,d,e,f,g){_.y.call(this);this.F=c;this.J=f;this.o=g;this.S=!1;this.k={"":!0};this.H={"":!0};this.A=[];this.w=[];this.R=["//"+_.G(_.B(a,2)),"og/_/js","k="+_.G(_.B(a,3)),"rt=j"];this.O=""==_.G(_.B(a,14))?null:_.B(a,14);this.K=["//"+_.G(_.B(a,2)),"og/_/ss","k="+_.G(_.B(a,13))];this.B=""==_.G(_.B(a,15))?null:_.B(a,15);this.U=_.F(_.B(a,1))?"?host=www.gstatic.com&amp;bust="+_.G(_.B(a,16)):"";this.T=_.F(_.B(a,1))?"?host=www.gstatic.com&amp;bust="+1E11*Math.random():"";this.d=d;_.B(a,19);a=null!=\r\n_.B(a,17)?_.B(a,17):1;this.b=_.H(a,1);a=0;for(c=e[a];a&lt;e.length;a++,c=e[a])Gk(this,c,!0)};_.w(_.Hk,_.y);_.Aa(_.Hk,"m");Gk=function(a,c,d){if(!a.k[c]&amp;&amp;(a.k[c]=!0,d&amp;&amp;a.d[c]))for(var e=0;e&lt;a.d[c].length;e++)Gk(a,a.d[c][e],d)};Ik=function(a,c){for(var d=[],e=0;e&lt;c.length;e++){var f=c[e];if(!a.k[f]){var g=a.d[f];g&amp;&amp;(g=Ik(a,g),d=d.concat(g));d.push(f);a.k[f]=!0}}return d};\r\n_.Kk=function(a,c,d){c=Ik(a,c);0&lt;c.length&amp;&amp;(c=a.R.join("/")+"/"+("m="+c.join(",")),a.O&amp;&amp;(c+="/rs="+a.O),c=c+a.U,Jk(a,c,(0,_.u)(a.P,a,d)),a.A.push(c))};_.Hk.prototype.P=function(a){_.E("api").Ta();for(var c=0;c&lt;this.w.length;c++)this.w[c].call(null);a&amp;&amp;a.call(null)};\r\nvar Jk=function(a,c,d,e){var f=window.document.createElement("SCRIPT");f.async=!0;f.type="text/javascript";f.charset="UTF-8";f.src=c;var g=!0,h=e||1;e=(0,_.u)(function(){g=!1;this.o.log(47,{att:h,max:a.b,url:c});h&lt;a.b?Jk(a,c,d,h+1):this.J.log(Error("V`"+h+"`"+a.b),{url:c})},a);var l=(0,_.u)(function(){g&amp;&amp;(this.o.log(46,{att:h,max:a.b,url:c}),g=!1,d&amp;&amp;d.call(null))},a),q=function(a){"loaded"==a.readyState||"complete"==a.readyState?l():g&amp;&amp;window.setTimeout(function(){q(a)},100)};"undefined"!==typeof f.addEventListener?\r\nf.onload=function(){l()}:f.onreadystatechange=function(){f.onreadystatechange=null;q(f)};f.onerror=e;a.o.log(45,{att:h,max:a.b,url:c});window.document.getElementsByTagName("HEAD")[0].appendChild(f)};_.Hk.prototype.Jd=function(a,c){for(var d=[],e=0,f=a[e];e&lt;a.length;e++,f=a[e])this.H[f]||(d.push(f),this.H[f]=!0);0&lt;d.length&amp;&amp;(d=this.K.join("/")+"/"+("m="+d.join(",")),this.B&amp;&amp;(d+="/rs="+this.B),d+=this.T,Lk(d,c))};\r\nvar Lk=function(a,c){var d=window.document.createElement("LINK");d.setAttribute("rel","stylesheet");d.setAttribute("type","text/css");d.setAttribute("href",a);d.onload=d.onreadystatechange=function(){d.readyState&amp;&amp;"loaded"!=d.readyState&amp;&amp;"complete"!=d.readyState||c&amp;&amp;c.call(null)};window.document.getElementsByTagName("HEAD")[0].appendChild(d)};\r\n_.Hk.prototype.C=function(a){this.S||(void 0!=a?window.setTimeout((0,_.u)(this.C,this,void 0),a):(_.Kk(this,_.B(this.F,1),(0,_.u)(this.Q,this)),this.Jd(_.B(this.F,2)),this.S=!0))};_.Hk.prototype.Q=function(){_.v("gbar.qm",(0,_.u)(function(a){try{a()}catch(c){this.J.log(c)}},this))};\r\nvar Mk=function(a,c){var d={};d._sn=["v.gas",c].join(".");_.I(a,d)};var Nk=["gbq1","gbq2","gbqfbwa"],Ok=function(a){var c=window.document.getElementById("gbqld");c&amp;&amp;(c.style.display=a?"none":"block",c=window.document.getElementById("gbql"))&amp;&amp;(c.style.display=a?"block":"none")};var Pk=function(){};var Qk=function(a,c,d){this.d=a;this.k=c;this.b=d||_.m};var Rk=function(){this.b=[]};Rk.prototype.A=function(a,c,d){this.F(a,c,d);this.b.push(new Qk(a,c,d))};Rk.prototype.F=function(a,c,d){d=d||_.m;for(var e=0,f=this.b.length;e&lt;f;e++){var g=this.b[e];if(g.d==a&amp;&amp;g.k==c&amp;&amp;g.b==d){this.b.splice(e,1);break}}};Rk.prototype.w=function(a){for(var c=0,d=this.b.length;c&lt;d;c++){var e=this.b[c];"hrc"==e.d&amp;&amp;e.k.call(e.b,a)}};\r\nvar Sk,Uk,Vk,Wk,Xk;Sk=null;_.Tk=function(){if(null!=Sk)return Sk;var a=window.document.body.style;if(!(a="flexGrow"in a||"webkitFlexGrow"in a))a:{if(a=window.navigator.userAgent){var c=/Trident\\/(\\d+)/.exec(a);if(c&amp;&amp;7&lt;=Number(c[1])){a=/\\bMSIE (\\d+)/.exec(a);a=!a||"10"==a[1];break a}}a=!1}return Sk=a};\r\nUk=function(a,c,d){var e=window.NaN;window.getComputedStyle&amp;&amp;(a=window.getComputedStyle(a,null).getPropertyValue(c))&amp;&amp;"px"==a.substr(a.length-2)&amp;&amp;(e=d?(0,window.parseFloat)(a.substr(0,a.length-2)):(0,window.parseInt)(a.substr(0,a.length-2),10));return e};\r\nVk=function(a){var c=a.offsetWidth,d=Uk(a,"width");if(!(0,window.isNaN)(d))return c-d;var e=a.style.padding,f=a.style.paddingLeft,g=a.style.paddingRight;a.style.padding=a.style.paddingLeft=a.style.paddingRight=0;d=a.clientWidth;a.style.padding=e;a.style.paddingLeft=f;a.style.paddingRight=g;return c-d};\r\nWk=function(a){var c=Uk(a,"min-width");if(!(0,window.isNaN)(c))return c;var d=a.style.width,e=a.style.padding,f=a.style.paddingLeft,g=a.style.paddingRight;a.style.width=a.style.padding=a.style.paddingLeft=a.style.paddingRight=0;c=a.clientWidth;a.style.width=d;a.style.padding=e;a.style.paddingLeft=f;a.style.paddingRight=g;return c};Xk=function(a,c){c||-.5!=a-Math.round(a)||(a-=.5);return Math.round(a)}; _.Yk=function(a){if(a){var c=a.style.opacity;a.style.opacity=".99";_.lb(a.offsetWidth);a.style.opacity=c}};\r\nvar Zk=function(a){_.y.call(this);this.b=a;this.d=[];this.k=[]};_.w(Zk,_.y);Zk.prototype.L=function(){Zk.G.L.call(this);this.b=null;for(var a=0;a&lt;this.d.length;a++)this.d[a].Y();for(a=0;a&lt;this.k.length;a++)this.k[a].Y();this.d=this.k=null};\r\nZk.prototype.La=function(a){void 0==a&amp;&amp;(a=this.b.offsetWidth);for(var c=Vk(this.b),d=[],e=0,f=0,g=0,h=0,l=0;l&lt;this.d.length;l++){var q=this.d[l],r=$k(q),x=Vk(q.b);d.push({item:q,gb:r,sh:x,tc:0});e+=r.Gc;f+=r.Vc;g+=r.Sb;h+=x}a=a-h-c-g;e=0&lt;a?e:f;f=a;c=d;do{g=!0;h=[];for(l=q=0;l&lt;c.length;l++){var r=c[l],x=0&lt;f?r.gb.Gc:r.gb.Vc,C=0==e?0:x/e*f+r.tc,C=Xk(C,g),g=!g;r.tc=al(r.item,C,r.sh,r.gb.Sb);0&lt;x&amp;&amp;C==r.tc&amp;&amp;(h.push(r),q+=x)}c=h;f=a-(0,_.pa)(d,function(a,c){return a+c.tc},0);e=q}while(0!=f&amp;&amp;0!=c.length);\r\nfor(l=0;l&lt;this.k.length;l++)this.k[l].La()};var cl=function(a){var c={};c.items=(0,_.oa)(a.d,function(a){return bl(a)});c.children=(0,_.oa)(a.k,function(a){return cl(a)});return c},dl=function(a,c){for(var d=0;d&lt;a.d.length;d++)a.d[d].b.style.width=c.items[d];for(d=0;d&lt;a.k.length;d++)dl(a.k[d],c.children[d])};Zk.prototype.M=function(){return this.b};\r\nvar el=function(a,c,d,e){Zk.call(this,a);this.w=c;this.A=d;this.o=e};_.w(el,Zk);\r\nvar $k=function(a,c){var d=a.w,e=a.A,f;if(-1==a.o){var g=c;void 0==g&amp;&amp;(g=Vk(a.b));f=bl(a);var h=cl(a),l=Uk(a.b,"width",!0);(0,window.isNaN)(l)&amp;&amp;(l=a.b.offsetWidth-g);g=Math.ceil(l);a.b.style.width=f;dl(a,h);f=g}else f=a.o;return{Gc:d,Vc:e,Sb:f}},al=function(a,c,d,e){void 0==d&amp;&amp;(d=Vk(a.b));void 0==e&amp;&amp;(e=$k(a,d).Sb);c=e+c;0&gt;c&amp;&amp;(c=0);a.b.style.width=c+"px";d=a.b.offsetWidth-d;a.b.style.width=d+"px";return d-e},bl=function(a){var c=a.b.style.width;a.b.style.width="";return c};\r\nvar fl=function(a,c,d){var e;void 0==e&amp;&amp;(e=-1);return{className:a,gb:{Gc:c||0,Vc:d||0,Sb:e}}},gl={className:"gb_3b",items:[fl("gb_Ua"),fl("gb_ic"),fl("gb_Mb",0,2),fl("gb_jc"),fl("gb_ea",1,1)],eb:[{className:"gb_ea",items:[fl("gb_Lc",0,1),fl("gb_Kc",0,1)],eb:[function(a){a=a.gb_Lc;var c;if(a)c=a.M();else{c=window.document.querySelector(".gb_Lc");if(!c)return null;a=new Zk(c)}c=c.querySelectorAll(".gb_m");for(var d=0;d&lt;c.length;d++){var e;if(_.R(c[d],"gb_o")){e=new el(c[d],0,1,-1);var f=c[d].querySelector(".gb_l");\r\nf&amp;&amp;(f=new el(f,0,1,-1),e.d.push(f),a.k.push(e))}else e=new el(c[d],0,0,-1);a.d.push(e)}return a},{className:"gb_Kc",items:[fl("gb_J"),fl("gb_4a"),fl("gb_Zb"),fl("gb_ma",0,1),fl("gb_Mc"),fl("gb_ia",0,1),fl("gb_Nc"),fl("gb_lc")],eb:[{className:"gb_ma",items:[fl("gb_oa",0,1)],eb:[{className:"gb_oa",items:[fl("gb_ka",0,1)],eb:[]}]}]}]},{className:"gb_fc",items:[fl("gbqff",1,1),fl("gb_ec")],eb:[]}]},hl=function(a,c){var d=c;if(!d){d=window.document.querySelector("."+a.className);if(!d)return null;d=new Zk(d)}for(var e=\r\n{},f=0;f&lt;a.items.length;f++){var g=a.items[f],h;h=g;var l=window.document.querySelector("."+h.className);if(h=l?new el(l,h.gb.Gc,h.gb.Vc,h.gb.Sb):null)d.d.push(h),e[g.className]=h}for(f=0;f&lt;a.eb.length;f++){var g=a.eb[f],q;"function"==typeof g?q=g(e):q=hl(g,e[g.className]);q&amp;&amp;d.k.push(q)}return d};\r\n_.kl=function(a){_.y.call(this);this.B=new Rk;this.d=window.document.getElementById("gb");this.O=(this.b=window.document.querySelector(".gb_ea"))?this.b.querySelector(".gb_Kc"):null;this.C=[];this.he=60;this.J=_.B(a,4);this.Ch=_.H(_.B(a,2),152);this.If=_.H(_.B(a,1),30);this.k=null;this.Ke=_.F(_.B(a,3),!0);this.o=1;this.d&amp;&amp;this.J&amp;&amp;(this.d.style.minWidth=this.J+"px");_.il(this);this.Ke&amp;&amp;(this.d&amp;&amp;(jl(this),_.S(this.d,"gb_p"),this.b&amp;&amp;_.S(this.b,"gb_p"),_.Tk()||(this.k=hl(gl))),this.La(),window.setTimeout((0,_.u)(this.La,\r\nthis),0));_.v("gbar.elc",(0,_.u)(this.K,this));_.v("gbar.ela",_.kb);_.v("gbar.elh",(0,_.u)(this.S,this))};_.w(_.kl,_.y);_.Aa(_.kl,"el");var ll=function(){var a=_.kl.Mh();return{es:a?{f:a.Ch,h:a.he,m:a.If}:{f:152,h:60,m:30},mo:"md",vh:window.innerHeight||0,vw:window.innerWidth||0}};_.kl.prototype.L=function(){_.kl.G.L.call(this)};_.kl.prototype.La=function(a){a&amp;&amp;jl(this);this.k&amp;&amp;this.k.La(Math.max(window.document.documentElement.clientWidth,Wk(this.d)));_.Yk(this.b)};\r\n_.kl.prototype.H=function(){try{var a=window.document.getElementById("gb"),c=a.querySelector(".gb_ea");_.T(a,"gb_3c");c&amp;&amp;_.T(c,"gb_3c");for(var a=0,d;d=Nk[a];a++){var e=window.document.getElementById(d);e&amp;&amp;_.T(e,"gbqfh")}Ok(!1)}catch(f){Mk(f,"rhcc")}this.La(!0)};\r\n_.kl.prototype.T=function(){try{var a=window.document.getElementById("gb"),c=a.querySelector(".gb_ea");_.S(a,"gb_3c");c&amp;&amp;_.S(c,"gb_3c");for(var a=0,d;d=Nk[a];a++){var e=window.document.getElementById(d);e&amp;&amp;_.S(e,"gbqfh")}Ok(!0)}catch(f){Mk(f,"ahcc")}this.La(!0)};_.il=function(a){if(a.d){var c=a.d.offsetWidth;0==a.o?900&lt;=c&amp;&amp;(a.o=1,a.w(new Pk)):900&gt;c&amp;&amp;(a.o=0,a.w(new Pk))}};_.kl.prototype.K=function(a){this.C.push(a)};_.kl.prototype.S=function(a){var c=ll().es.h;this.he=c+a;for(a=0;a&lt;this.C.length;a++)try{this.C[a](ll())}catch(d){_.I(d)}};\r\nvar jl=function(a){if(a.b){var c;a.k&amp;&amp;(c=cl(a.k));_.S(a.b,"gb_s");a.b.style.minWidth=a.b.offsetWidth-Vk(a.b)+"px";a.O.style.minWidth=a.O.offsetWidth-Vk(a.O)+"px";_.T(a.b,"gb_s");c&amp;&amp;dl(a.k,c)}};_.kl.prototype.A=function(a,c,d){this.B.A(a,c,d)};_.kl.prototype.F=function(a,c){this.B.F(a,c)};_.kl.prototype.w=function(a){this.B.w(a)};\r\n_.jb(function(){var a=_.D(_.J(),Ek,21)||new Ek,a=new _.kl(a);_.Ca("el",a);_.v("gbar.gpca",(0,_.u)(a.T,a));_.v("gbar.gpcr",(0,_.u)(a.H,a))});_.v("gbar.elr",ll);_.ml=function(a){this.k=_.kl.N();this.d=a};_.ml.prototype.b=function(a,c){0==this.k.o?(_.S(a,"gb_r"),c?(_.T(a,"gb_la"),_.S(a,"gb_Oc")):(_.T(a,"gb_Oc"),_.S(a,"gb_la"))):_.ih(a,["gb_r","gb_la","gb_Oc"])};_.v("gbar.sos",function(){return window.document.querySelectorAll(".gb_hc")});_.v("gbar.si",function(){return window.document.querySelector(".gb_gc")});\r\n_.jb(function(){if(_.D(_.J(),_.Dk,16)){var a=window.document.querySelector(".gb_ea"),c=_.D(_.J(),_.Dk,16)||new _.Dk,c=_.F(_.B(c,1),!1),c=new _.ml(c);a&amp;&amp;c.d&amp;&amp;c.b(a,!1)}});\r\n}catch(e){_._DumpException(e)}\r\ntry{\r\nvar nl=function(){_.La.k(_.I)};var ol=function(a,c){var d=_.zk(nl);a.addEventListener?a.addEventListener(c,d):a.attachEvent("on"+c,d)};var pl=[1,2],ql=function(a,c){a.w.push(c)},rl=function(a){_.A(this,a,0,pl)};_.w(rl,_.z);var sl=function(){_.y.call(this);this.o=this.b=null;this.d={};this.w={};this.k={}};_.w(sl,_.y);_.k=sl.prototype;_.k.Ze=function(a){a&amp;&amp;this.b&amp;&amp;a!=this.b&amp;&amp;this.b.close();this.b=a};_.k.Me=function(a){a=this.k[a]||a;return this.b==a};_.k.Gh=function(a){this.o=a};\r\n_.k.Le=function(a){return this.o==a};_.k.hd=function(){this.b&amp;&amp;this.b.close();this.b=null};_.k.tf=function(a){this.b&amp;&amp;this.b.getId()==a&amp;&amp;this.hd()};_.k.Pb=function(a,c,d){this.d[a]=this.d[a]||{};this.d[a][c]=this.d[a][c]||[];this.d[a][c].push(d)};_.k.fd=function(a,c){var d=c.getId();if(this.d[a]&amp;&amp;this.d[a][d])for(var e=0;e&lt;this.d[a][d].length;e++)try{this.d[a][d][e]()}catch(f){_.I(f)}};_.k.Ih=function(a,c){this.w[a]=c};_.k.rf=function(a){return!this.w[a.getId()]};\r\n_.k.Qg=function(){return!!this.b&amp;&amp;this.b.V};_.k.qf=function(){return!!this.b};_.k.Re=function(){this.b&amp;&amp;this.b.la()};_.k.cf=function(a){this.k[a]&amp;&amp;(this.b&amp;&amp;this.b.getId()==a||this.k[a].open())};_.k.jh=function(a){this.k[a.getId()]=a};var tl;window.gbar&amp;&amp;window.gbar._DPG?tl=window.gbar._DPG[0]||{}:tl={};var ul;window.gbar&amp;&amp;window.gbar._LDD?ul=window.gbar._LDD:ul=[];var vl=_.Na(),wl=new _.Hk(vl,_.D(_.J(),rl,17)||new rl,tl,ul,_.yk(),_.Bk());_.Ca("m",wl); if(_.F(_.B(vl,18),!0))wl.C();else{var xl=_.H(_.B(vl,19),200),yl=(0,_.u)(wl.C,wl,xl);_.jb(yl)}ol(window.document,"DOMContentLoaded");ol(window,"load");\r\n_.v("gbar.ldb",(0,_.u)(_.La.k,_.La));_.v("gbar.mls",function(){});var zl=function(){_.y.call(this);this.k=this.b=null;this.w=0;this.o={};this.d=!1;var a=window.navigator.userAgent;0&lt;=a.indexOf("MSIE")&amp;&amp;0&lt;=a.indexOf("Trident")&amp;&amp;(a=/\\b(?:MSIE|rv)[: ]([^\\);]+)(\\)|;)/.exec(a))&amp;&amp;a[1]&amp;&amp;9&gt;(0,window.parseFloat)(a[1])&amp;&amp;(this.d=!0)};_.w(zl,_.y);\r\nvar Al=function(a,c,d){if(!a.d)if(d instanceof Array)for(var e in d)Al(a,c,d[e]);else{e=(0,_.u)(a.A,a,c);var f=a.w+d;a.w++;c.setAttribute("data-eqid",f);a.o[f]=e;c&amp;&amp;c.addEventListener?c.addEventListener(d,e,!1):c&amp;&amp;c.attachEvent?c.attachEvent("on"+d,e):_.I(Error("W`"+c))}};\r\nzl.prototype.Ne=function(a,c){if(this.d)return null;if(c instanceof Array){var d=null,e;for(e in c){var f=this.Ne(a,c[e]);f&amp;&amp;(d=f)}return d}d=null;this.b&amp;&amp;this.b.type==c&amp;&amp;this.k==a&amp;&amp;(d=this.b,this.b=null);if(e=a.getAttribute("data-eqid"))a.removeAttribute("data-eqid"),(e=this.o[e])?a.removeEventListener?a.removeEventListener(c,e,!1):a.detachEvent&amp;&amp;a.detachEvent("on"+c,e):_.I(Error("X`"+a));return d};zl.prototype.A=function(a,c){this.b=c;this.k=a;c.preventDefault?c.preventDefault():c.returnValue=!1};\r\n_.Ca("eq",new zl);var Bl=function(){_.y.call(this);this.ge=[];this.jd=[]};_.w(Bl,_.y);Bl.prototype.b=function(a,c){this.ge.push({uc:a,options:c})};Bl.prototype.init=function(){window.gapi={};var a=_.Yj(),c=window.___jsl={};c.h=_.G(_.B(a,1));c.ms=_.G(_.B(a,2));c.m=_.G(_.B(a,3));c.l=[];a=_.D(_.J(),_.Xj,5)||new _.Xj;_.B(a,1)&amp;&amp;(a=_.B(a,3))&amp;&amp;this.jd.push(a);a=_.D(_.J(),_.Fk,6)||new _.Fk;_.B(a,1)&amp;&amp;(a=_.B(a,2))&amp;&amp;this.jd.push(a);_.v("gapi.load",(0,_.u)(this.b,this));return this};\r\nvar Cl=window,Dl,El=_.Yj();Dl=_.B(El,7);Cl.__PVT=_.G(Dl);_.Ca("gs",(new Bl).init());(function(){for(var a=function(a){return function(){_.V(44,{n:a})}},c=0;c&lt;_.Qa.length;c++){var d="gbar."+_.Qa[c];_.v(d,a(d))}var e=_.ya.N();_.za(e,"api").Ta();ql(_.za(e,"m"),function(){_.za(e,"api").Ta()})})();var Fl=function(a){_.jb(function(){var c=window.document.querySelector("."+a);c&amp;&amp;(c=c.querySelector(".gb_K"))&amp;&amp;Al(_.E("eq"),c,"click")})};var Gl=window.document.querySelector(".gb_J"),Hl=/(\\s+|^)gb_dc(\\s+|$)/;Gl&amp;&amp;!Hl.test(Gl.className)&amp;&amp;Fl("gb_J");var Il=new sl;_.Ca("dd",Il);_.v("gbar.close",(0,_.u)(Il.hd,Il));_.v("gbar.cls",(0,_.u)(Il.tf,Il));_.v("gbar.abh",(0,_.u)(Il.Pb,Il,0));_.v("gbar.adh",(0,_.u)(Il.Pb,Il,1));_.v("gbar.ach",(0,_.u)(Il.Pb,Il,2));_.v("gbar.aeh",(0,_.u)(Il.Ih,Il));_.v("gbar.bsy",(0,_.u)(Il.Qg,Il));_.v("gbar.op",(0,_.u)(Il.qf,Il));\r\nFl("gb_ma");_.jb(function(){var a=window.document.querySelector(".gb_Xa");a&amp;&amp;Al(_.E("eq"),a,"click")});Fl("gb_4a");_.v("gbar.qfgw",(0,_.u)(window.document.getElementById,window.document,"gbqfqw"));_.v("gbar.qfgq",(0,_.u)(window.document.getElementById,window.document,"gbqfq"));_.v("gbar.qfgf",(0,_.u)(window.document.getElementById,window.document,"gbqf"));_.v("gbar.qfsb",(0,_.u)(window.document.getElementById,window.document,"gbqfb"));\r\nFl("gb_Zb");Fl("gb_lc");\r\n}catch(e){_._DumpException(e)}\r\n})(this.gbar_);\r\n// Google Inc.\r\n</script><div class="gb_4b"></div><style>.gb_j .gbqfi::before{left:-56px;top:-35px}.gb_L .gbqfb:focus .gbqfi{outline:1px dotted #fff}@-moz-keyframes gb__a{0%{opacity:0}50%{opacity:1}}@keyframes gb__a{0%{opacity:0}50%{opacity:1}}#gb#gb a.gb_k,#gb#gb a.gb_l{color:#404040;text-decoration:none}#gb#gb a.gb_l:hover,#gb#gb a.gb_l:focus{color:#000;text-decoration:underline}.gb_m.gb_n{display:none;padding-left:15px;vertical-align:middle}.gb_m.gb_n:first-child{padding-left:0}.gb_o.gb_n{display:inline-block}.gb_p .gb_o.gb_n{flex:0 1 auto;flex:0 1 main-size;display:-webkit-flex;display:flex}.gb_q .gb_o.gb_n{display:none}.gb_m .gb_l{display:inline-block;line-height:24px;outline:none;vertical-align:middle}.gb_o .gb_l{min-width:60px;overflow:hidden;flex:0 1 auto;flex:0 1 main-size;text-overflow:ellipsis}.gb_r .gb_o .gb_l{min-width:0}.gb_s .gb_o .gb_l{width:0!important}.gb_t .gb_l{font-weight:bold;text-shadow:0 1px 1px rgba(255,255,255,.9)}.gb_u .gb_l{font-weight:bold;text-shadow:0 1px 1px rgba(0,0,0,.6)}#gb#gb.gb_u a.gb_l{color:#fff}.gb_J .gb_K{background-position:-326px -52px;opacity:.55}.gb_t .gb_J .gb_K{background-position:-97px -57px;opacity:.7}.gb_u .gb_J .gb_K{background-position:-214px 0;opacity:1}.gb_Vc{left:0;min-width:1152px;position:absolute;top:0;-moz-user-select:-moz-none;width:100%}.gb_3b{font:13px/27px Arial,sans-serif;position:relative;height:60px;width:100%}.gb_ha .gb_3b{height:28px}#gba{height:60px}#gba.gb_ha{height:28px}#gba.gb_Wc{height:90px}#gba.gb_Wc.gb_ha{height:58px}.gb_3b&gt;.gb_n{height:60px;line-height:58px;vertical-align:middle}.gb_ha .gb_3b&gt;.gb_n{height:28px;line-height:26px}.gb_3b::before{background:#e5e5e5;bottom:0;content:'''';display:none;height:1px;left:0;position:absolute;right:0}.gb_3b{background:#f1f1f1}.gb_Xc .gb_3b{background:#fff}.gb_Xc .gb_3b::before,.gb_ha .gb_3b::before{display:none}.gb_t .gb_3b,.gb_u .gb_3b,.gb_ha .gb_3b{background:transparent}.gb_t .gb_3b::before{background:#e1e1e1;background:rgba(0,0,0,.12)}.gb_u .gb_3b::before{background:#333;background:rgba(255,255,255,.2)}.gb_n{display:inline-block;flex:0 0 auto;flex:0 0 main-size}.gb_n.gb_Zc{float:right;order:1}.gb_0c{white-space:nowrap}.gb_p .gb_0c{display:-webkit-flex;display:flex}.gb_0c,.gb_n{margin-left:0!important;margin-right:0!important}.gb_0a{background-image:url(''//ssl.gstatic.com/gb/images/i1_71651352.png'');background-size:356px 144px}@media (min-resolution:1.25dppx),(-webkit-min-device-pixel-ratio:1.25),(min-device-pixel-ratio:1.25){.gb_0a{background-image:url(''//ssl.gstatic.com/gb/images/i2_9ef0f6fa.png'')}}.gb_qb{display:inline-block;padding:0 0 0 15px;vertical-align:middle}.gb_qb:first-child,#gbsfw:first-child+.gb_qb{padding-left:0}.gb_5a{position:relative}.gb_K{display:inline-block;outline:none;vertical-align:middle;-moz-border-radius:2px;border-radius:2px;-moz-box-sizing:border-box;box-sizing:border-box;height:30px;width:30px}#gb#gb a.gb_K{color:#404040;cursor:default;text-decoration:none}#gb#gb a.gb_K:hover,#gb#gb a.gb_K:focus{color:#000}.gb_pa{border-color:transparent;border-bottom-color:#fff;border-style:dashed dashed solid;border-width:0 8.5px 8.5px;display:none;position:absolute;left:6.5px;top:37px;z-index:1;height:0;width:0;-moz-animation:gb__a .2s;animation:gb__a .2s}.gb_qa{border-color:transparent;border-style:dashed dashed solid;border-width:0 8.5px 8.5px;display:none;position:absolute;left:6.5px;z-index:1;height:0;width:0;-moz-animation:gb__a .2s;animation:gb__a .2s;border-bottom-color:#ccc;border-bottom-color:rgba(0,0,0,.2);top:36px}x:-o-prefocus,div.gb_qa{border-bottom-color:#ccc}.gb_N{background:#fff;border:1px solid #ccc;border-color:rgba(0,0,0,.2);-moz-box-shadow:0 2px 10px rgba(0,0,0,.2);box-shadow:0 2px 10px rgba(0,0,0,.2);display:none;outline:none;overflow:hidden;position:absolute;right:0;top:44px;-moz-animation:gb__a .2s;animation:gb__a .2s;-moz-border-radius:2px;border-radius:2px;-moz-user-select:text}.gb_qb.gb_Ra .gb_pa,.gb_qb.gb_Ra .gb_qa,.gb_qb.gb_Ra .gb_N{display:block}.gb_nc{position:absolute;right:0;top:44px;z-index:-1}.gb_ha .gb_pa,.gb_ha .gb_qa,.gb_ha .gb_N{margin-top:-10px}.gb_da{background-size:32px 32px;-moz-border-radius:50%;border-radius:50%;display:block;margin:-1px;height:32px;width:32px}.gb_da:hover,.gb_da:focus{-moz-box-shadow:0 1px 0 rgba(0,0,0,.15);box-shadow:0 1px 0 rgba(0,0,0,.15)}.gb_da:active{-moz-box-shadow:inset 0 2px 0 rgba(0,0,0,.15);box-shadow:inset 0 2px 0 rgba(0,0,0,.15)}.gb_da:active::after{background:rgba(0,0,0,.1);-moz-border-radius:50%;border-radius:50%;content:'''';display:block;height:100%}.gb_ea:not(.gb_j) .gb_da::before,.gb_ea:not(.gb_j) .gb_fa::before{content:none}.gb_ga{cursor:pointer;line-height:30px;min-width:30px;overflow:hidden;vertical-align:middle;width:auto;text-overflow:ellipsis}.gb_ha .gb_ga,.gb_ha .gb_ia{line-height:26px}#gb#gb.gb_ha a.gb_ga,.gb_ha .gb_ia{color:#666;font-size:11px;height:auto}#gb#gb.gb_ha a.gb_ga:hover,#gb#gb.gb_ha a.gb_ga:focus{color:#000}.gb_ja{border-top:4px solid #404040;border-left:4px dashed transparent;border-right:4px dashed transparent;display:inline-block;margin-left:6px;vertical-align:middle}.gb_ha .gb_ja{border-top-color:#999}.gb_ka:hover .gb_ja{border-top-color:#000}.gb_t .gb_ga{font-weight:bold;text-shadow:0 1px 1px rgba(255,255,255,.9)}.gb_u .gb_ga{font-weight:bold;text-shadow:0 1px 1px rgba(0,0,0,.6)}#gb#gb.gb_u.gb_u a.gb_ga{color:#fff}.gb_u.gb_u .gb_ja{border-top-color:#fff}.gb_t .gb_da,.gb_u .gb_da{-moz-box-shadow:0 1px 2px rgba(0,0,0,.2);box-shadow:0 1px 2px rgba(0,0,0,.2)}.gb_t .gb_da:hover,.gb_u .gb_da:hover,.gb_t .gb_da:focus,.gb_u .gb_da:focus{-moz-box-shadow:0 1px 0 rgba(0,0,0,.15),0 1px 2px rgba(0,0,0,.2);box-shadow:0 1px 0 rgba(0,0,0,.15),0 1px 2px rgba(0,0,0,.2)}.gb_la .gb_ma,.gb_na .gb_ma{position:absolute;right:1px}.gb_ma.gb_n,.gb_oa.gb_n,.gb_ka.gb_n{flex:0 1 auto;flex:0 1 main-size}.gb_ea.gb_s .gb_ga{width:30px!important}.gb_4b{display:none!important}.gb_j .gb_J .gb_K::before{left:-326px;top:-52px}.gb_j.gb_t .gb_J .gb_K::before{left:-97px;top:-57px}.gb_j.gb_u .gb_J .gb_K::before{left:-214px;top:0}.gb_L .gb_M{position:relative}.gb_j .gb_Xa .gb_0a::before{left:0;top:-105px}.gb_j.gb_u .gb_Xa .gb_0a::before{left:-97px;top:-92px}.gb_j.gb_t .gb_Xa .gb_0a::before{left:-97px;top:0}.gb_j .gb_1a{background-image:none!important}.gb_j .gb_2a{visibility:visible}.gb_L .gb_3a span{background:transparent}.gb_j .gb_6a::before{left:-56px;top:0}.gb_j .gb_7a .gb_6a::before{left:-291px;top:-103px}.gb_j.gb_t .gb_K .gb_6a::before{left:-167px;top:-57px}.gb_j.gb_t .gb_7a .gb_6a::before{left:-132px;top:-57px}.gb_j.gb_u .gb_K .gb_6a::before{left:-326px;top:-87px}.gb_j.gb_u .gb_7a .gb_6a::before{left:0;top:-70px}.gb_L .gb_eb{border:1px solid #fff;color:#fff}.gb_L.gb_t .gb_eb{border-color:#000;color:#000}.gb_j .gb_eb.gb_fb::before,.gb_L.gb_j.gb_u .gb_eb.gb_fb::before{left:-214px;top:-117px}.gb_j .gb_eb.gb_gb::before,.gb_L.gb_j.gb_u .gb_eb.gb_gb::before{left:-256px;top:-73px}.gb_j.gb_u .gb_eb.gb_fb::before,.gb_L.gb_j.gb_t .gb_eb.gb_fb::before{left:-326px;top:-122px}.gb_j.gb_u .gb_eb.gb_gb::before,.gb_L.gb_j.gb_t .gb_eb.gb_gb::before{left:-214px;top:-92px}.gb_jb{display:none;margin:28px;margin-bottom:-12px;outline:none;position:relative;width:264px;z-index:1;-moz-border-radius:2px;border-radius:2px;-moz-box-shadow:0 1px 2px rgba(0,0,0,0.1),0 0 1px rgba(0,0,0,0.1);box-shadow:0 1px 2px rgba(0,0,0,0.1),0 0 1px rgba(0,0,0,0.1)}.gb_jb.gb_Ra{display:block}.gb_ib{background-size:64px 64px;display:inline-block;margin:12px;vertical-align:top;height:64px;width:64px}.gb_lb{display:inline-block;padding:16px 16px 16px 0;vertical-align:top;white-space:normal}.gb_ib~.gb_lb{margin-right:88px}.gb_lb:first-child{padding-left:16px}.gb_mb{color:#262626;font:16px/24px Arial,sans-serif}.gb_nb{color:#737373;font:13px/18px Arial,sans-serif}#gb#gb .gb_jb .gb_ob{color:#427fed;text-decoration:none}#gb#gb .gb_jb .gb_ob:hover{text-decoration:underline}.gb_jb .gb_kb{background-position:-256px 0;cursor:pointer;opacity:.27;outline:none;position:absolute;right:4px;top:4px;height:12px;width:12px}.gb_jb .gb_kb:hover{opacity:.55}.gb_qb.gb_rb{padding:0}.gb_rb .gb_N{padding:26px 26px 22px 13px;background:#ffffff}.gb_sb.gb_rb .gb_N{background:#4d90fe}a.gb_tb{color:#666666!important;font-size:22px;height:9px;opacity:.8;position:absolute;right:14px;top:4px;text-decoration:none!important;width:9px}.gb_sb a.gb_tb{color:#c1d1f4!important}a.gb_tb:hover,a.gb_tb:active{opacity:1}.gb_ub{padding:0;width:258px;white-space:normal;display:table}.gb_sb .gb_ub{width:200px}.gb_vb{color:#333333;font-size:16px;line-height:20px;margin:0;margin-bottom:16px}.gb_sb .gb_vb{color:#ffffff}.gb_wb{color:#666666;line-height:17px;margin:0;margin-bottom:5px}.gb_sb .gb_wb{color:#ffffff}.gb_xb{position:absolute;background:transparent;top:-999px;z-index:-1;visibility:hidden;margin-top:1px;margin-left:1px}#gb .gb_rb{margin:0}.gb_rb .gb_5{background:#4d90fe;border-color:#3079ed;margin-top:15px}#gb .gb_rb a.gb_5.gb_5{color:#ffffff}.gb_rb .gb_5:hover{background:#357ae8;border-color:#2f5bb7}.gb_yb .gb_5a .gb_pa{border-bottom-color:#ffffff;display:block}.gb_zb .gb_5a .gb_pa{border-bottom-color:#4d90fe;display:block}.gb_yb .gb_5a .gb_qa,.gb_zb .gb_5a .gb_qa{display:block}.gb_Ab,.gb_Bb{display:table-cell}.gb_Ab{vertical-align:middle}.gb_Bb{padding-left:13px;width:100%}.gb_Cb{margin-bottom:32px;font-size:small}.gb_Cb .gb_Db{margin-right:5px}.gb_Cb .gb_Eb{color:red}.gb_Fb{color:#ffffff;font-size:13px;font-weight:bold;height:25px;line-height:19px;padding-top:5px;padding-left:12px;position:relative;background-color:#4d90fe}.gb_Fb .gb_kb{color:#ffffff;cursor:default;font-size:22px;font-weight:normal;position:absolute;right:12px;top:5px}.gb_Fb .gb_ob,.gb_Fb .gb_Hb{color:#ffffff;display:inline-block;font-size:11px;margin-left:16px;padding:0 8px;white-space:nowrap}.gb_Ib{background:none;background-image:-moz-linear-gradient(top,rgba(0,0,0,0.16),rgba(0,0,0,0.2));background-image:linear-gradient(top,rgba(0,0,0,0.16),rgba(0,0,0,0.2));background-image:-moz-linear-gradient(top,rgba(0,0,0,0.16),rgba(0,0,0,0.2));-moz-border-radius:2px;border-radius:2px;border:1px solid #dcdcdc;border:1px solid rgba(0,0,0,0.1);cursor:default!important;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#160000ff,endColorstr=#220000ff);text-decoration:none!important}.gb_Ib:hover{background:none;background-image:-moz-linear-gradient(top,rgba(0,0,0,0.14),rgba(0,0,0,0.2));background-image:linear-gradient(top,rgba(0,0,0,0.14),rgba(0,0,0,0.2));background-image:-moz-linear-gradient(top,rgba(0,0,0,0.14),rgba(0,0,0,0.2));border:1px solid rgba(0,0,0,0.2);box-shadow:0 1px 1px rgba(0,0,0,0.1);-moz-box-shadow:0 1px 1px rgba(0,0,0,0.1);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#14000000,endColorstr=#22000000)}.gb_Ib:active{box-shadow:inset 0 1px 2px rgba(0,0,0,0.3);-moz-box-shadow:inset 0 1px 2px rgba(0,0,0,0.3)}.gb_pb{display:none}.gb_pb.gb_Ra{display:block}.gb_j .gb_ib{background-image:none!important}.gb_j .gb_ib::before{display:inline-block;-moz-transform:scale(.5);transform:scale(.5);-moz-transform-origin:0 0;transform-origin:0 0}.gb_j .gb_jb .gb_kb{position:absolute}.gb_j .gb_jb .gb_kb::before{left:-256px;top:0}.gb_j .gb_Zb .gb_K::before{left:-326px;top:-17px}.gb_j.gb_t .gb_Zb .gb_K::before{left:-256px;top:-103px}.gb_j.gb_u .gb_Zb .gb_K::before{left:0;top:-35px}.gb_L .gb_qa{border:0;border-left:1px solid rgba(0,0,0,.2);border-top:1px solid rgba(0,0,0,.2);height:14px;width:14px;-moz-transform:rotate(45deg);transform:rotate(45deg)}.gb_L .gb_pa{border:0;border-left:1px solid rgba(0,0,0,.2);border-top:1px solid rgba(0,0,0,.2);height:14px;width:14px;-moz-transform:rotate(45deg);transform:rotate(45deg);border-color:#fff;background:#fff}.gb_j .gb_Qc::before{clip:rect(-0 51px 16px 35px);left:-13px;top:22px}.gb_j .gb_0a.gb_Rc{position:absolute}.gb_j .gb_Rc::before{clip:rect(17px 307px 33px 291px);left:-261px;top:5px}.gb_j .gb_la .gb_Qc::before{left:-5px}@media (min-resolution:1.25dppx),(-webkit-min-device-pixel-ratio:1.25),(min-device-pixel-ratio:1.25){.gb_j .gb_Qc::before{clip:rect(-0 102px 32px 70px)}.gb_j .gb_Rc::before{clip:rect(34px 614px 66px 582px)}}.gb_j .gb_0a,.gb_j .gbii,.gb_j .gbip{background-image:none;overflow:hidden;position:relative}.gb_j .gb_0a::before{content:url(''//ssl.gstatic.com/gb/images/i1_71651352.png'');position:absolute}@media (min-resolution:1.25dppx),(-webkit-min-device-pixel-ratio:1.25),(min-device-pixel-ratio:1.25){.gb_j .gb_0a::before{content:url(''//ssl.gstatic.com/gb/images/i2_9ef0f6fa.png'');-moz-transform:scale(.5);transform:scale(.5);-moz-transform-origin:0 0;transform-origin:0 0}}.gb_L a:focus{outline:1px dotted #fff!important}sentinel{}</style><div id="xjsd"><script src="/xjs/_/js/k=xjs.s.en.OubCwNWBjj0.O/m=sx,c,sb,cdos,cr,elog,jsa,r,hsm,j,p,d,csi/am=hET9LUYIyoIagSgD/rt=j/d=1/t=zcms/rs=ACT90oE88yTl3YMkLvnC-_aiA1t11-9dIQ"></script><script src="/extern_chrome/e32e0a7f016fa2cf.js?bav=on.2,or."></script></div><div data-jiis="bp" id="xjsi"><script>(function(){function c(b){window.setTimeout(function(){var a=document.createElement("script");a.src=b;document.getElementById("xjsd").appendChild(a)},0)}google.dljp=function(b,a){google.xjsu=b;c(a)};google.dlj=c;})();(function(){window.google.xjsrm=[];})();if(google.y)google.y.first=[];if(!google.xjs){window._=window._||{};window._._DumpException=function(e){throw e};if(google.timers&amp;&amp;google.timers.load.t){google.timers.load.t.xjsls=new Date().getTime();}google.dljp(''/xjs/_/js/k\\x3dxjs.s.en.OubCwNWBjj0.O/m\\x3dsx,c,sb,cdos,cr,elog,jsa,r,hsm,j,p,d,csi/am\\x3dhET9LUYIyoIagSgD/rt\\x3dj/d\\x3d1/t\\x3dzcms/rs\\x3dACT90oE88yTl3YMkLvnC-_aiA1t11-9dIQ'',''/xjs/_/js/k\\x3dxjs.s.en.OubCwNWBjj0.O/m\\x3dsx,c,sb,cdos,cr,elog,jsa,r,hsm,j,p,d,csi/am\\x3dhET9LUYIyoIagSgD/rt\\x3dj/d\\x3d1/t\\x3dzcms/rs\\x3dACT90oE88yTl3YMkLvnC-_aiA1t11-9dIQ'');google.xjs=1;}google.pmc={"sx":{},"c":{"mcr":5},"sb":{"agen":false,"cgen":true,"client":"hp","dh":true,"ds":"","exp":"msedr","fl":true,"host":"google.co.in","jam":1,"msgs":{"cibl":"Clear Search","dym":"Did you mean:","lcky":"I\\u0026#39;m Feeling Lucky","lml":"Learn more","oskt":"Input tools","psrc":"This search was removed from your \\u003Ca href=\\"/history\\"\\u003EWeb History\\u003C/a\\u003E","psrl":"Remove","sbit":"Search by image","srch":"Google Search"},"ovr":{},"pq":"","psy":"p","refoq":true,"refpd":true,"rfs":[],"scd":10,"sce":4,"stok":"XuCwqH4-JsLJwbxGGxeMfVp_Vys"},"abd":{"abd":false,"dabp":false,"deb":false,"der":false,"det":false,"psa":false,"sup":false},"aldd":{},"async":{},"cdos":{"bih":648,"biw":1366,"dpr":"1"},"cr":{"eup":false,"qir":false,"rctj":true,"ref":true,"uff":false},"ddls":{},"elog":{},"erh":{},"foot":{"pf":true,"po":false,"qe":false},"fpe":{"js":true},"gf":{"pid":196},"hv":{},"idck":{},"ipv6":{},"jsa":{},"jsaleg":{},"lc":{},"llc":{},"lu":{},"m":{"ab":{"on":true},"ajax":{"gl":"in","hl":"en","q":""},"css":{"showTopNav":true},"exp":{"lrb":true,"tnav":true},"msgs":{"details":"Result details","hPers":"Hide private results","hPersD":"Currently hiding private results","loading":"Still loading...","mute":"Mute","noPreview":"Preview not available","sPers":"Show all results","sPersD":"Currently showing private results","unmute":"Unmute"},"time":{"hUnit":1500}},"r":{},"rk":{"bl":"Feedback","db":"Reported","di":"Thank you.","dl":"Report another problem","efe":true,"rb":"Wrong?","ri":"Please report the problem.","rl":"Cancel"},"rkab":{},"rmcl":{"bl":"Feedback","db":"Reported","di":"Thank you.","dl":"Report another problem","rb":"Wrong?","ri":"Please report the problem.","rl":"Cancel"},"sf":{},"st":{},"vm":{"bv":88528373,"d":"c2E","tc":true,"te":true,"tk":true,"ts":true},"hsm":{},"j":{"ajrp":true,"cmt":true,"ftwd":200,"icmt":false,"lbtfdr":10000,"lcuwl":true,"mcr":5,"miml":true,"prwnj":true,"scmt":true,"tct":" \\\\u3000?","tlh":true,"ufl":true,"witu":false},"p":{"ae":true,"avgTtfc":2000,"brba":false,"dlen":24,"dper":3,"eae":true,"fbdc":500,"fbdu":-1,"fbh":true,"fd":1000000,"focus":true,"gpsj":true,"hiue":true,"hpt":310,"iavgTtfc":2000,"knrt":true,"maxCbt":1500,"mds":"prc,sp,mbl_he,mbl_hs,mbl_re,mbl_rs,mbl_sv","msg":{"dym":"Did you mean:","gs":"Google Search","kntt":"Use the up and down arrow keys to select each result. Press Enter to go to the selection.","pcnt":"New Tab","sif":"Search instead for","srf":"Showing results for"},"nprr":1,"ohpt":false,"ophe":true,"pmt":250,"pq":true,"rpt":15,"sc":"psy-ab","tdur":50,"ufl":true},"d":{},"csi":{"acsi":true},"TG8rFw":{"sd":"1"},"hLaaFQ":{"ed":"Please enter a description.","eu":"Please enter a valid URL."},"q1cupA":{},"8AF24Q":{},"bnhGTQ":{},"4RZUyg":{},"/nNC3A":{},"CjL7kw":{},"ITl3wQ":{},"FmbnUA":{},"c+PT4g":{},"/1S6iw":{},"GqeGtQ":{},"+idT0Q":{},"NpA8BQ":{},"BwDLOw":{},"8aqNqA":{},"A/Ucpg":{},"cm4D8w":{},"GfrcvQ":{}};google.y.first.push(function(){google.loadAll([''abd'',''async'',''erh'',''foot'',''fpe'',''hv'',''idck'',''ipv6'',''lc'',''lu'',''m'',''sf'',''vm''].concat(google.xjsrm||[]));if(google.med){google.med(''init'');google.initHistory();google.med(''history'');}});if(google.j&amp;&amp;google.j.en&amp;&amp;google.j.xi){window.setTimeout(google.j.xi,0);}\r\n</script></div><script>(function(){var cfd={a:false,d:false,i:false,m:true};if(google.timers&amp;&amp;google.timers.load.t){var f=function(){google.timers.load.t&amp;&amp;(google.timers.load.t.ol=google.time(),google.timers.load.t.iml=b,google.kCSI.imc=c,google.kCSI.imn=d,google.kCSI.imp=e,google.stt&amp;&amp;(google.kCSI.stt=google.stt),google.csiReport&amp;&amp;google.csiReport())},h=function(a){b=google.time();++c;a=a||window.event;a=a.target||a.srcElement;var g=h;a.removeEventListener?(a.removeEventListener("load",g,!1),a.removeEventListener("error",g,!1)):(a.detachEvent("onload",g),a.detachEvent("onerror",g));google.iml(a,b);cfd.a&amp;&amp;google.aft(a,b,!0)},d,c,e,b;cfd.a&amp;&amp;(google.tick("aft","start"),google.afte=!1);var k=document.getElementsByTagName("img");d=k.length;for(var l=c=0,m;l&lt;d;++l)if(m=k[l],cfd.i&amp;&amp;"none"==m.style.display)++c;else{var n="string"!=typeof m.src||!m.src,p=n||m.complete;cfd.m&amp;&amp;n&amp;&amp;m.getAttribute("data-bsrc")&amp;&amp;(p=!1);cfd.d&amp;&amp;m.getAttribute("data-deferred")&amp;&amp;(p=!1);p?++c:m.addEventListener?(m.addEventListener("load",h,!1),m.addEventListener("error",h,!1)):(m.attachEvent("onload",h),m.attachEvent("onerror",h))}e=d-c;window.addEventListener?window.addEventListener("load",f,!1):window.attachEvent&amp;&amp;window.attachEvent("onload",f);google.timers.load.t.prt=b=google.time()};})();</script></div><script src="/xjs/_/js/k=xjs.s.en.OubCwNWBjj0.O/m=sy26,abd,sy59,sy58,sy60,async,erh,sy61,foot,fpe,sy149,hv,idck,ipv6,lc,sy112,sy123,lu,sy342,m,sf,vm/am=hET9LUYIyoIagSgD/rt=j/d=0/t=zcms/rs=ACT90oE88yTl3YMkLvnC-_aiA1t11-9dIQ" gapi_processed="true"></script><script src="/xjs/_/js/k=xjs.s.en.OubCwNWBjj0.O/m=aspn,sy163,sy324,sy325,sy10,sy78,sy326,sy333,sy22,sy334,dvl,sy84,sy85,sy111,em8,vs,sy64,sy65,sy67,sy69,sy66,sy70,sy62,sy68,sy71,tnv,sy202,bbl,apml,sy76,sy77,adtt,apmf,sy75,sy99,sy168,sy169,sy96,sy98,sy100,sy170,sy167,sy173,sy171,sy172,sy174,sy175,sy81,sy113,sy310,sy130,sy199,sy311,lor,me/am=hET9LUYIyoIagSgD/rt=j/d=0/t=zcms/rs=ACT90oE88yTl3YMkLvnC-_aiA1t11-9dIQ"></script><div style="position: fixed; transition-duration: 0.1s, 0.1s; transition-property: left, top; z-index: 102; display: none;"><div class="lu_map_tooltip" style="position: absolute; border: 1px solid rgba(0, 0, 0, 0.2); border-radius: 2px; padding: 6px 12px; line-height: 1.2; font-size: 85%; background-color: white; white-space: nowrap; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2); right: 0px;"></div></div><style type="text/css">#nycntg{margin:6px 25px 10px 0}#nycp{background-color:#fafafa;border-left:1px solid #ebebeb;bottom:0;left:0;margin-left:33px;min-width:240px;position:absolute;right:0;top:0;visibility:hidden;z-index:102;padding:38px 16px 10px 14px}.nyc_open #nycp{visibility:visible}#nycf{display:none;height:1px;left:0;min-width:940px;position:absolute;visibility:hidden;z-index:-1}.nyc_open #nycf{display:block}.nyc_opening #nycp,.nyc_opening #nycprv{display:block;visibility:hidden!important}#nyccur{background:#fafafa;height:100%;left:33px;opacity:0;position:absolute;top:0;width:0;z-index:120}#nyccur.wipeRight{border-right:1px solid #e8e8e8;opacity:1;-moz-transition:width 0.08s ease-in;width:100%}#nyccur.fadeOut{opacity:0;-moz-transition:opacity 0.08s linear;width:100%}#nyccur.fadeIn{opacity:1;-moz-transition:opacity 0.08s linear;width:100%}#nyccur.wipeLeft{border-right:1px solid #eee;opacity:1;-moz-transition:width 0.08s ease-out;width:0}.nyc_open .vspib,.nyc_opening .vspib{padding-right:0;-moz-transition:padding-right .2s ease}.nyc_open .vspib .vspii,.nyc_opening .vspib .vspii{-moz-border-top-right-radius:0;-moz-border-bottom-right-radius:0;border-right:none}.nyc_open #nycxh{cursor:pointer;opacity:0.7;padding:15px;position:absolute;right:1px;top:12px}.nyc_open #nycxh:hover{opacity:1}#nycx{display:none}.nyc_open #nycx{border:none;cursor:pointer;display:block;padding:0}#nycntg h3 .esw{display:none}#nyc .vshid{display:inline}#nyc #nycntg .vshid a{white-space:nowrap}#nycntg a:link{border:0;text-decoration:none}#nycntg a:hover{text-decoration:underline}#vsi,.vsi{border:none;width:100%}.vslru.vso:before{bottom:-8px;top:-7px;left:-7px;right:-9px;content:"";position:absolute;z-index:-1}.vslru div.vspib{bottom:-6px;top:-7px}.vslru div.vspib .vspii{border-radius:0}.vscl.vso.vslru:before,.vscl.vslru div.vspib{top:-4px}</style><div class="ads-bbl-container" id="abbl" style="display: none;"></div><div class="ads-bbl-triangle-bg ads-bbl-triangle" id="abblt" style="display: none;"><div class="ads-bbl-triangle-fg ads-bbl-triangle"></div></div></body></html>', '', '1', '2', '0', NULL, '2015-03-23 09:44:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_FacebookConfig`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_FacebookConfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `appId` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `is_access_token_valid` tinyint(1) DEFAULT NULL,
  `userid_returned` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_GoogleBloggerConfig`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_GoogleBloggerConfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `userid_returned` varchar(255) DEFAULT NULL,
  `appId` varchar(255) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `access_token` text,
  `is_access_token_valid` tinyint(1) DEFAULT NULL,
  `refresh_token` text,
  `blogid` varchar(255) DEFAULT NULL,
  `access_token_secret` text,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xMarketingCampaign_GoogleBloggerConfig`
--

INSERT INTO `xMarketingCampaign_GoogleBloggerConfig` (`id`, `name`, `userid`, `userid_returned`, `appId`, `secret`, `access_token`, `is_access_token_valid`, `refresh_token`, `blogid`, `access_token_secret`, `is_active`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_leads`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `source_id` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `lead_type` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xmarketingcampaign_leads`
--

INSERT INTO `xmarketingcampaign_leads` (`id`, `epan_id`, `name`, `organization_name`, `email_id`, `source`, `source_id`, `phone`, `mobile_no`, `fax`, `website`, `lead_type`, `created_by_id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'vijay', 'xavoc', 'vijay.mali552@gmail.com', 'DataFeed', '0', '9784954128', '7665036690', '', 'xavoc.com', 'Sales', NULL, NULL, NULL, NULL, '2015-03-23 10:18:08', '2015-03-23 10:18:08');

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_LinkedinConfig`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_LinkedinConfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `appId` varchar(255) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `post_in_groups` tinyint(1) DEFAULT NULL,
  `filter_repeated_posts` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_SocialConfig`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_SocialConfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `social_app` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `appId` text,
  `secret` text,
  `post_in_groups` tinyint(1) DEFAULT NULL,
  `filter_repeated_posts` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xMarketingCampaign_SocialConfig`
--

INSERT INTO `xMarketingCampaign_SocialConfig` (`id`, `social_app`, `name`, `appId`, `secret`, `post_in_groups`, `filter_repeated_posts`) VALUES
(1, 'Facebook', 'online store', '751198844995552', '01c0724d9d1973619f0d948c1d93b948', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_SocialPostings`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_SocialPostings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `campaign_id` int(11) DEFAULT NULL,
  `post_type` varchar(255) DEFAULT NULL,
  `postid_returned` varchar(255) DEFAULT NULL,
  `posted_on` datetime DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `likes` varchar(255) DEFAULT NULL,
  `share` varchar(255) DEFAULT NULL,
  `is_monitoring` tinyint(1) DEFAULT NULL,
  `force_monitor` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_post_id` (`post_id`),
  KEY `fk_campaign_id` (`campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_SocialPostings_Activities`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_SocialPostings_Activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posting_id` int(11) DEFAULT NULL,
  `activityid_returned` varchar(255) DEFAULT NULL,
  `activity_type` varchar(255) DEFAULT NULL,
  `activity_on` datetime DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `activity_by` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `action_allowed` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posting_id` (`posting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_SocialPosts`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_SocialPosts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `post_title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `message_160_chars` varchar(255) DEFAULT NULL,
  `message_255_chars` varchar(255) DEFAULT NULL,
  `message_blog` text,
  `is_active` tinyint(1) DEFAULT NULL,
  `message_3000_chars` text,
  `epan_id` int(11) DEFAULT NULL,
  `post_leg_allowed` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xMarketingCampaign_SocialPosts`
--

INSERT INTO `xMarketingCampaign_SocialPosts` (`id`, `name`, `post_title`, `url`, `image`, `message_160_chars`, `message_255_chars`, `message_blog`, `is_active`, `message_3000_chars`, `epan_id`, `post_leg_allowed`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'create your online store', 'create your online store', 'xepan.org', 'epans/web/Xavoc%20Technocrats%20Logo%20Small.png', 'xCIDeveloper Is a great approach to put together both worlds, I haven’t detected any bug since I started using it. My issues are more related with the fact that I’m newbie on the CI&Joomla development worlds. ... These guys are very diligent and willing t', 'xCIDeveloper Is a great approach to put together both worlds, I haven’t detected any bug since I started using it. My issues are more related with the fact that I’m newbie on the CI&Joomla development worlds. ... These guys are very diligent and willing t', '', 1, 'xCIDeveloper Is a great approach to put together both worlds, I haven’t detected any bug since I started using it. My issues are more related with the fact that I’m newbie on the CI&Joomla development worlds. ... These guys are very diligent and willing to support you, even beyond what the product itself contains. I’ve sent several inquiries and they are quite fast to respond, even without being on a paid support program yet.', 1, NULL, 1, '2015-03-23 09:59:55', '2015-03-23 09:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_SocialPost_Categories`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_SocialPost_Categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xMarketingCampaign_SocialPost_Categories`
--

INSERT INTO `xMarketingCampaign_SocialPost_Categories` (`id`, `epan_id`, `name`) VALUES
(1, 1, 'facebook Social Post');

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_SocialUsers`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_SocialUsers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `config_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `userid_returned` varchar(255) DEFAULT NULL,
  `access_token` text,
  `access_token_secret` text,
  `access_token_expiry` datetime DEFAULT NULL,
  `is_access_token_valid` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_config_id` (`config_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_employee_team_associations`
--

CREATE TABLE IF NOT EXISTS `xproduction_employee_team_associations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `is_team_leader` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_team_id` (`team_id`),
  KEY `fk_employee_id` (`employee_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xproduction_employee_team_associations`
--

INSERT INTO `xproduction_employee_team_associations` (`id`, `team_id`, `employee_id`, `is_team_leader`) VALUES
(1, 1, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_jobcard`
--

CREATE TABLE IF NOT EXISTS `xproduction_jobcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderitem_id` int(11) DEFAULT NULL,
  `orderitem_departmental_status_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `from_department_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `to_department_id` int(11) DEFAULT NULL,
  `dispatch_to_warehouse_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orderitem_id` (`orderitem_id`),
  KEY `fk_orderitem_departmental_status_id` (`orderitem_departmental_status_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_from_department_id` (`from_department_id`),
  KEY `fk_to_department_id` (`to_department_id`) USING BTREE,
  KEY `fk_dispatch_to_warehouse_id` (`dispatch_to_warehouse_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `xproduction_jobcard`
--

INSERT INTO `xproduction_jobcard` (`id`, `orderitem_id`, `orderitem_departmental_status_id`, `name`, `status`, `created_at`, `created_by_id`, `type`, `from_department_id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `to_department_id`, `dispatch_to_warehouse_id`, `updated_at`) VALUES
(1, 1, 1, '2168', 'completed', '2015-03-23 06:15:07', 2, 'JobCard', 4, NULL, NULL, NULL, 13, NULL, '2015-03-23 06:29:36'),
(2, 1, 2, '2987', 'completed', '2015-03-23 06:28:18', 2, 'JobCard', 4, NULL, NULL, NULL, 14, NULL, '2015-03-23 06:35:30'),
(3, 1, 3, '1809', 'completed', '2015-03-23 06:34:14', 2, 'JobCard', 4, NULL, NULL, NULL, 18, NULL, '2015-03-23 10:37:51'),
(4, 2, 6, '8923', 'approved', '2015-03-23 13:03:24', 3, 'JobCard', 4, NULL, NULL, NULL, 13, NULL, '2015-03-23 13:03:24');

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_material_requirment`
--

CREATE TABLE IF NOT EXISTS `xproduction_material_requirment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `jobcard_id` int(11) DEFAULT NULL,
  `orderitem_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_jobcard_id` (`jobcard_id`),
  KEY `fk_orderitem_id` (`orderitem_id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_material_requirment_DELETE`
--

CREATE TABLE IF NOT EXISTS `xproduction_material_requirment_DELETE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `jobcard_id` int(11) DEFAULT NULL,
  `orderitem_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_jobcard_id` (`jobcard_id`),
  KEY `fk_orderitem_id` (`orderitem_id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_outsource_party_dept_associations`
--

CREATE TABLE IF NOT EXISTS `xproduction_outsource_party_dept_associations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `out_source_party_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_out_source_party_id` (`out_source_party_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_out_source_parties`
--

CREATE TABLE IF NOT EXISTS `xproduction_out_source_parties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `maintain_stock` tinyint(1) DEFAULT NULL,
  `contact_no` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `xproduction_out_source_parties`
--

INSERT INTO `xproduction_out_source_parties` (`id`, `name`, `code`, `maintain_stock`, `contact_no`, `address`) VALUES
(1, 'Paliwal Printers', 'PPUDR', 1, 2147483647, 'Udaipur'),
(2, 'Le Griffe Offset PVt Ltd', 'LGABD', 1, 789880, 'Ahmdabad'),
(3, 'OM Offset', 'OOABD', 0, 68798080, 'Ahmdabad'),
(4, 'Akar Printer', 'APUDR', 0, 6789907, 'Udaipur'),
(5, 'Sunjari Offset', 'SOUDR', 0, 658798980, 'Udaipur'),
(6, 'Multi Print', 'MPUDR', 0, 7987090, 'udaipur'),
(7, 'Perfact Post Press', 'PPPABD', 0, 445765768, 'Ahmdabad'),
(8, 'Post Press Solutions', 'PPSABD', 0, 2147483647, 'Ahmdabad');

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_tasks`
--

CREATE TABLE IF NOT EXISTS `xproduction_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `root_document_name` varchar(255) DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_id` varchar(255) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `Priority` varchar(255) DEFAULT NULL,
  `expected_start_date` datetime DEFAULT NULL,
  `expected_end_date` datetime DEFAULT NULL,
  `is_default_jobcard_task` tinyint(1) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_team_id` (`team_id`),
  KEY `fk_employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_teams`
--

CREATE TABLE IF NOT EXISTS `xproduction_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xproduction_teams`
--

INSERT INTO `xproduction_teams` (`id`, `department_id`, `name`) VALUES
(1, 14, 'xavoc Subscriber');

-- --------------------------------------------------------

--
-- Table structure for table `xpurcahse_material_request`
--

CREATE TABLE IF NOT EXISTS `xpurcahse_material_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `from_department_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_from_department_id` (`from_department_id`),
  KEY `fk_order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xpurcahse_material_request_DELETE`
--

CREATE TABLE IF NOT EXISTS `xpurcahse_material_request_DELETE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `from_department_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_from_department_id` (`from_department_id`),
  KEY `fk_order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xpurchase_purchase_material_request_items`
--

CREATE TABLE IF NOT EXISTS `xpurchase_purchase_material_request_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_material_request_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_purchase_material_request_id` (`purchase_material_request_id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xpurchase_purchase_material_request_items_DELETE`
--

CREATE TABLE IF NOT EXISTS `xpurchase_purchase_material_request_items_DELETE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purchase_material_request_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_purchase_material_request_id` (`purchase_material_request_id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xpurchase_purchase_order`
--

CREATE TABLE IF NOT EXISTS `xpurchase_purchase_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `xpurchase_supplier_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_xpurchase_supplier_id` (`xpurchase_supplier_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xpurchase_purchase_order`
--

INSERT INTO `xpurchase_purchase_order` (`id`, `created_at`, `status`, `created_by_id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `xpurchase_supplier_id`, `updated_at`) VALUES
(1, '2015-03-23 12:17:53', 'draft', 3, NULL, NULL, NULL, 1, '2015-03-23 12:17:53');

-- --------------------------------------------------------

--
-- Table structure for table `xpurchase_purchase_order_item`
--

CREATE TABLE IF NOT EXISTS `xpurchase_purchase_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `custom_fields` text,
  `po_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_po_id` (`po_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xpurchase_supplier`
--

CREATE TABLE IF NOT EXISTS `xpurchase_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `pin_code` varchar(255) DEFAULT NULL,
  `fax_number` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xpurchase_supplier`
--

INSERT INTO `xpurchase_supplier` (`id`, `name`, `owner_name`, `code`, `address`, `city`, `contact_no`, `email`, `created_at`, `state`, `pin_code`, `fax_number`, `is_active`) VALUES
(1, 'Xavoc', 'Gowrav Vishwakarma', '123', 'kangi ka hata', 'udaipur', '7986709567890', 'info@xavoc.com', '2015-03-23 00:00:00', 'rajasthan', '313001', '43253677', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_addblock`
--

CREATE TABLE IF NOT EXISTS `xshop_addblock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_affiliate`
--

CREATE TABLE IF NOT EXISTS `xshop_affiliate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `affiliatetype_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `office_address` text,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `description` text,
  `application_id` int(11) DEFAULT NULL,
  `logo_url_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_affiliatetype_id` (`affiliatetype_id`),
  KEY `fk_application_id` (`application_id`),
  KEY `fk_logo_url_id` (`logo_url_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_affiliatetype`
--

CREATE TABLE IF NOT EXISTS `xshop_affiliatetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_application_id` (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_application`
--

CREATE TABLE IF NOT EXISTS `xshop_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xshop_application`
--

INSERT INTO `xshop_application` (`id`, `epan_id`, `name`, `type`, `created_by_id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`) VALUES
(1, 1, 'Prime Scan', 'Shop', 2, NULL, NULL, NULL, NULL, '2015-03-22 12:11:10');

-- --------------------------------------------------------

--
-- Table structure for table `xshop_attachments`
--

CREATE TABLE IF NOT EXISTS `xshop_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `attachment_url` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `attachment_url_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_attachment_url_id` (`attachment_url_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_blockimages`
--

CREATE TABLE IF NOT EXISTS `xshop_blockimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_block_id` (`block_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_categories`
--

CREATE TABLE IF NOT EXISTS `xshop_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  `order_no` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `description` text,
  `image_url_id` int(11) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `xshop_categories`
--

INSERT INTO `xshop_categories` (`id`, `name`, `parent_id`, `epan_id`, `application_id`, `order_no`, `is_active`, `description`, `image_url_id`, `alt_text`, `meta_title`, `meta_description`, `meta_keywords`, `created_by_id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`) VALUES
(1, 'Visting Cards', NULL, 1, 1, 0, 1, '', NULL, '', '', '', '', 2, NULL, NULL, NULL, '2015-03-20 07:59:45', '2015-03-20 08:13:43'),
(2, 'Brochers', NULL, 1, 1, 0, 1, '', NULL, '', '', '', '', 2, NULL, NULL, NULL, '2015-03-20 08:00:35', '2015-03-20 08:13:23'),
(3, 'Laminated Card', 1, 1, 1, 0, 1, '', NULL, '', '', '', '', 2, NULL, NULL, NULL, '2015-03-20 08:13:59', '2015-03-20 08:13:59');

-- --------------------------------------------------------

--
-- Table structure for table `xshop_categorygroup`
--

CREATE TABLE IF NOT EXISTS `xshop_categorygroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_categorygroup_DELETE`
--

CREATE TABLE IF NOT EXISTS `xshop_categorygroup_DELETE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_category_item`
--

CREATE TABLE IF NOT EXISTS `xshop_category_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `is_associate` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_id` (`category_id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xshop_category_item`
--

INSERT INTO `xshop_category_item` (`id`, `category_id`, `item_id`, `is_associate`) VALUES
(1, 1, 17, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_category_product_TODELETE`
--

CREATE TABLE IF NOT EXISTS `xshop_category_product_TODELETE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `is_associate` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_id` (`category_id`),
  KEY `fk_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_configuration`
--

CREATE TABLE IF NOT EXISTS `xshop_configuration` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `disqus_code` text,
  `add_custom_button` tinyint(1) DEFAULT NULL,
  `custom_button_text` varchar(255) DEFAULT NULL,
  `custom_button_url` varchar(255) DEFAULT NULL,
  `order_detail_email_subject` varchar(255) DEFAULT NULL,
  `order_detail_email_body` text,
  `application_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_application_id` (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_customfiledvalue_filter_ass`
--

CREATE TABLE IF NOT EXISTS `xshop_customfiledvalue_filter_ass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `customfield_id` int(11) DEFAULT NULL,
  `customefieldvalue_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_customfield_id` (`customfield_id`),
  KEY `fk_customefieldvalue_id` (`customefieldvalue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_customrate_custome_value_conditions`
--

CREATE TABLE IF NOT EXISTS `xshop_customrate_custome_value_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_rate_id` int(11) DEFAULT NULL,
  `custom_field_value_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_custom_rate_id` (`custom_rate_id`),
  KEY `fk_custom_field_value_id` (`custom_field_value_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_custom_fields`
--

CREATE TABLE IF NOT EXISTS `xshop_custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_application_id` (`application_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `xshop_custom_fields`
--

INSERT INTO `xshop_custom_fields` (`id`, `name`, `epan_id`, `application_id`, `type`) VALUES
(1, 'Sides', 1, 1, 'DropDown'),
(2, 'Paper', 1, 1, 'DropDown'),
(3, ' Paper GSM', 1, 1, 'DropDown'),
(4, 'Lamination', 1, 1, 'DropDown'),
(5, 'Varnish', 1, 1, 'DropDown'),
(6, 'UV Type', 1, 1, 'DropDown'),
(7, 'Full UV Type', 1, 1, 'DropDown'),
(8, 'Spot UV Type', 1, 1, 'DropDown'),
(9, 'Hot Foil Type', 1, 1, 'DropDown'),
(10, 'Embose-Debose', 1, 1, 'DropDown'),
(11, 'Binding', 1, 1, 'DropDown'),
(12, 'Size', 1, 1, 'DropDown'),
(13, 'Pages', 1, 1, 'DropDown'),
(14, 'Lamination On', 1, 1, 'DropDown');

-- --------------------------------------------------------

--
-- Table structure for table `xshop_custom_fields_value`
--

CREATE TABLE IF NOT EXISTS `xshop_custom_fields_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `itemcustomfiledasso_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `customfield_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_itemcustomfiledasso_id` (`itemcustomfiledasso_id`),
  KEY `fk_customfield_id` (`customfield_id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=220 ;

--
-- Dumping data for table `xshop_custom_fields_value`
--

INSERT INTO `xshop_custom_fields_value` (`id`, `name`, `itemcustomfiledasso_id`, `created_at`, `is_active`, `customfield_id`, `item_id`) VALUES
(1, 'Front', 1, '2015-03-20 09:03:37', 1, 1, 10),
(2, 'Front Back', 1, '2015-03-20 09:03:59', 1, 1, 10),
(3, 'Art', 2, '2015-03-20 09:16:46', 1, 2, 10),
(4, 'Textured', 2, '2015-03-20 09:17:09', 1, 2, 10),
(5, 'Maplitho', 2, '2015-03-20 09:17:26', 1, 2, 10),
(6, '100', 3, '2015-03-20 09:17:55', 1, 3, 10),
(7, '130', 3, '2015-03-20 09:18:05', 1, 3, 10),
(8, '170', 3, '2015-03-20 09:18:16', 1, 3, 10),
(9, '220', 3, '2015-03-20 09:18:25', 1, 3, 10),
(10, '250', 3, '2015-03-20 09:18:38', 1, 3, 10),
(11, '300', 3, '2015-03-20 09:18:58', 1, 3, 10),
(12, '240', 3, '2015-03-20 09:19:12', 1, 3, 10),
(13, '270', 3, '2015-03-20 09:19:43', 1, 3, 10),
(14, 'Art', 4, '2015-03-20 09:20:09', 1, 2, 10),
(15, 'Textured', 4, '2015-03-20 09:20:21', 1, 2, 10),
(16, 'Maplitho', 4, '2015-03-20 09:20:31', 1, 2, 10),
(17, '100', 5, '2015-03-20 09:20:54', 1, 3, 10),
(18, '130', 5, '2015-03-20 09:21:02', 1, 3, 10),
(19, '170', 5, '2015-03-20 09:21:10', 1, 3, 10),
(20, '220', 5, '2015-03-20 09:21:18', 1, 3, 10),
(21, '250', 5, '2015-03-20 09:21:26', 1, 3, 10),
(22, '270', 5, '2015-03-20 09:21:36', 1, 3, 10),
(23, 'Art', 6, '2015-03-20 09:21:51', 1, 2, 10),
(24, 'Textured', 6, '2015-03-20 09:21:59', 1, 2, 10),
(25, 'Maplitho', 6, '2015-03-20 09:22:26', 1, 2, 10),
(26, '100', 7, '2015-03-20 09:23:12', 1, 3, 10),
(27, '220', 7, '2015-03-20 09:23:22', 1, 3, 10),
(28, '240', 7, '2015-03-20 09:23:31', 1, 3, 10),
(29, '300', 7, '2015-03-20 09:23:39', 1, 3, 10),
(30, 'Art', 8, '2015-03-20 09:24:03', 1, 2, 10),
(31, 'Textured', 8, '2015-03-20 09:24:14', 1, 2, 10),
(32, 'Maplitho', 8, '2015-03-20 09:24:23', 1, 2, 10),
(33, '100', 9, '2015-03-20 09:24:38', 1, 3, 10),
(34, '220', 9, '2015-03-20 09:24:45', 1, 3, 10),
(35, '240', 9, '2015-03-20 09:24:53', 1, 3, 10),
(36, '300', 9, '2015-03-20 09:25:02', 1, 3, 10),
(37, 'gloss', 10, '2015-03-20 09:25:34', 1, 5, 10),
(38, 'matt', 10, '2015-03-20 09:25:42', 1, 5, 10),
(39, 'Front', 11, '2015-03-20 09:26:01', 1, 1, 10),
(40, 'Front Back', 11, '2015-03-20 09:26:10', 1, 1, 10),
(41, 'MATT', 12, '2015-03-20 09:26:28', 1, 4, 10),
(42, 'Gloss', 12, '2015-03-20 09:26:50', 1, 4, 10),
(43, 'Full UV TYPE 1', 13, '2015-03-20 09:27:21', 1, 7, 10),
(44, 'Full UV TYPE 2', 13, '2015-03-20 09:27:32', 1, 7, 10),
(45, 'Spot UV TYPE 1', 14, '2015-03-20 09:28:02', 1, 8, 10),
(46, 'Spot UV TYPE 2', 14, '2015-03-20 09:28:13', 1, 8, 10),
(47, 'Hot Foil TYPE 1', 15, '2015-03-20 09:28:39', 1, 9, 10),
(48, 'Hot Foil TYPE 2', 15, '2015-03-20 09:28:48', 1, 9, 10),
(49, 'Binding TYPE 1', 16, '2015-03-20 09:29:13', 1, 11, 10),
(50, 'Binding TYPE 2', 16, '2015-03-20 09:29:25', 1, 11, 10),
(51, '11', 19, '2015-03-22 08:20:29', 1, 12, 10),
(52, '15', 19, '2015-03-22 08:20:33', 1, 12, 10),
(53, '20', 19, '2015-03-22 08:20:36', 1, 12, 10),
(54, 'signle', 20, '2015-03-22 08:22:17', 1, 13, 10),
(55, 'both', 20, '2015-03-22 08:22:23', 1, 13, 10),
(56, 'Front', 21, '2015-03-22 12:33:19', 1, 1, 19),
(57, 'Front Back', 21, '2015-03-22 12:33:19', 1, 1, 19),
(58, 'Art', 22, '2015-03-22 12:33:20', 1, 2, 19),
(59, 'Textured', 22, '2015-03-22 12:33:20', 1, 2, 19),
(60, 'Maplitho', 22, '2015-03-22 12:33:20', 1, 2, 19),
(61, '100', 23, '2015-03-22 12:33:20', 1, 3, 19),
(62, '130', 23, '2015-03-22 12:33:20', 1, 3, 19),
(63, '170', 23, '2015-03-22 12:33:20', 1, 3, 19),
(64, '220', 23, '2015-03-22 12:33:20', 1, 3, 19),
(65, '250', 23, '2015-03-22 12:33:20', 1, 3, 19),
(66, '300', 23, '2015-03-22 12:33:20', 1, 3, 19),
(67, '240', 23, '2015-03-22 12:33:21', 1, 3, 19),
(68, '270', 23, '2015-03-22 12:33:21', 1, 3, 19),
(69, 'Front', 24, '2015-03-22 12:35:00', 1, 1, 20),
(70, 'Front Back', 24, '2015-03-22 12:35:00', 1, 1, 20),
(71, 'Art', 25, '2015-03-22 12:35:00', 1, 2, 20),
(72, 'Textured', 25, '2015-03-22 12:35:00', 1, 2, 20),
(73, 'Maplitho', 25, '2015-03-22 12:35:00', 1, 2, 20),
(74, '100', 26, '2015-03-22 12:35:00', 1, 3, 20),
(75, '130', 26, '2015-03-22 12:35:00', 1, 3, 20),
(76, '170', 26, '2015-03-22 12:35:01', 1, 3, 20),
(77, '220', 26, '2015-03-22 12:35:01', 1, 3, 20),
(78, '250', 26, '2015-03-22 12:35:01', 1, 3, 20),
(79, '300', 26, '2015-03-22 12:35:01', 1, 3, 20),
(80, '240', 26, '2015-03-22 12:35:01', 1, 3, 20),
(81, '270', 26, '2015-03-22 12:35:01', 1, 3, 20),
(82, 'Art', 27, '2015-03-22 12:35:01', 1, 2, 20),
(83, 'Textured', 27, '2015-03-22 12:35:01', 1, 2, 20),
(84, 'Maplitho', 27, '2015-03-22 12:35:01', 1, 2, 20),
(85, '100', 28, '2015-03-22 12:35:02', 1, 3, 20),
(86, '130', 28, '2015-03-22 12:35:02', 1, 3, 20),
(87, '170', 28, '2015-03-22 12:35:02', 1, 3, 20),
(88, '220', 28, '2015-03-22 12:35:02', 1, 3, 20),
(89, '250', 28, '2015-03-22 12:35:02', 1, 3, 20),
(90, '270', 28, '2015-03-22 12:35:03', 1, 3, 20),
(91, 'Art', 29, '2015-03-22 12:35:03', 1, 2, 20),
(92, 'Textured', 29, '2015-03-22 12:35:03', 1, 2, 20),
(93, 'Maplitho', 29, '2015-03-22 12:35:04', 1, 2, 20),
(94, '100', 30, '2015-03-22 12:35:04', 1, 3, 20),
(95, '220', 30, '2015-03-22 12:35:04', 1, 3, 20),
(96, '240', 30, '2015-03-22 12:35:04', 1, 3, 20),
(97, '300', 30, '2015-03-22 12:35:04', 1, 3, 20),
(98, 'Art', 31, '2015-03-22 12:35:04', 1, 2, 20),
(99, 'Textured', 31, '2015-03-22 12:35:04', 1, 2, 20),
(100, 'Maplitho', 31, '2015-03-22 12:35:04', 1, 2, 20),
(101, '100', 32, '2015-03-22 12:35:05', 1, 3, 20),
(102, '220', 32, '2015-03-22 12:35:05', 1, 3, 20),
(103, '240', 32, '2015-03-22 12:35:05', 1, 3, 20),
(104, '300', 32, '2015-03-22 12:35:05', 1, 3, 20),
(105, 'gloss', 33, '2015-03-22 12:35:05', 1, 5, 20),
(106, 'matt', 33, '2015-03-22 12:35:05', 1, 5, 20),
(107, 'Front', 34, '2015-03-22 12:35:05', 1, 1, 20),
(108, 'Front Back', 34, '2015-03-22 12:35:05', 1, 1, 20),
(109, 'MATT', 35, '2015-03-22 12:35:05', 1, 4, 20),
(110, 'Gloss', 35, '2015-03-22 12:35:06', 1, 4, 20),
(111, 'Full UV TYPE 1', 36, '2015-03-22 12:35:06', 1, 7, 20),
(112, 'Full UV TYPE 2', 36, '2015-03-22 12:35:06', 1, 7, 20),
(113, 'Spot UV TYPE 1', 37, '2015-03-22 12:35:06', 1, 8, 20),
(114, 'Spot UV TYPE 2', 37, '2015-03-22 12:35:06', 1, 8, 20),
(115, 'Hot Foil TYPE 1', 38, '2015-03-22 12:35:06', 1, 9, 20),
(116, 'Hot Foil TYPE 2', 38, '2015-03-22 12:35:06', 1, 9, 20),
(117, 'Binding TYPE 1', 39, '2015-03-22 12:35:07', 1, 11, 20),
(118, 'Binding TYPE 2', 39, '2015-03-22 12:35:07', 1, 11, 20),
(119, '11', 40, '2015-03-22 12:35:07', 1, 12, 20),
(120, '15', 40, '2015-03-22 12:35:07', 1, 12, 20),
(121, '20', 40, '2015-03-22 12:35:07', 1, 12, 20),
(122, 'signle', 41, '2015-03-22 12:35:07', 1, 13, 20),
(123, 'both', 41, '2015-03-22 12:35:08', 1, 13, 20),
(163, 'Front', 51, '2015-03-22 12:38:15', 1, 1, 24),
(164, 'Front Back', 51, '2015-03-22 12:38:15', 1, 1, 24),
(165, 'Art', 52, '2015-03-22 12:38:15', 1, 2, 24),
(166, 'Textured', 52, '2015-03-22 12:38:15', 1, 2, 24),
(167, 'Maplitho', 52, '2015-03-22 12:38:15', 1, 2, 24),
(168, '100', 53, '2015-03-22 12:38:15', 1, 3, 24),
(169, '130', 53, '2015-03-22 12:38:16', 1, 3, 24),
(170, '170', 53, '2015-03-22 12:38:16', 1, 3, 24),
(171, '220', 53, '2015-03-22 12:38:16', 1, 3, 24),
(172, '250', 53, '2015-03-22 12:38:16', 1, 3, 24),
(173, '300', 53, '2015-03-22 12:38:16', 1, 3, 24),
(174, '240', 53, '2015-03-22 12:38:16', 1, 3, 24),
(175, '270', 53, '2015-03-22 12:38:16', 1, 3, 24),
(176, 'Art', 54, '2015-03-22 12:38:16', 1, 2, 24),
(177, 'Textured', 54, '2015-03-22 12:38:16', 1, 2, 24),
(178, 'Maplitho', 54, '2015-03-22 12:38:16', 1, 2, 24),
(179, '100', 55, '2015-03-22 12:38:16', 1, 3, 24),
(180, '130', 55, '2015-03-22 12:38:16', 1, 3, 24),
(181, '170', 55, '2015-03-22 12:38:16', 1, 3, 24),
(182, '220', 55, '2015-03-22 12:38:16', 1, 3, 24),
(183, '250', 55, '2015-03-22 12:38:16', 1, 3, 24),
(184, '270', 55, '2015-03-22 12:38:16', 1, 3, 24),
(185, 'Art', 56, '2015-03-22 12:38:16', 1, 2, 24),
(186, 'Textured', 56, '2015-03-22 12:38:16', 1, 2, 24),
(187, 'Maplitho', 56, '2015-03-22 12:38:16', 1, 2, 24),
(188, '100', 57, '2015-03-22 12:38:16', 1, 3, 24),
(189, '220', 57, '2015-03-22 12:38:17', 1, 3, 24),
(190, '240', 57, '2015-03-22 12:38:17', 1, 3, 24),
(191, '300', 57, '2015-03-22 12:38:17', 1, 3, 24),
(192, 'Art', 58, '2015-03-22 12:38:17', 1, 2, 24),
(193, 'Textured', 58, '2015-03-22 12:38:17', 1, 2, 24),
(194, 'Maplitho', 58, '2015-03-22 12:38:17', 1, 2, 24),
(195, '100', 59, '2015-03-22 12:38:17', 1, 3, 24),
(196, '220', 59, '2015-03-22 12:38:17', 1, 3, 24),
(197, '240', 59, '2015-03-22 12:38:17', 1, 3, 24),
(198, '300', 59, '2015-03-22 12:38:17', 1, 3, 24),
(199, 'gloss', 60, '2015-03-22 12:38:17', 1, 5, 24),
(200, 'matt', 60, '2015-03-22 12:38:17', 1, 5, 24),
(201, 'Front', 61, '2015-03-22 12:38:17', 1, 1, 24),
(202, 'Front Back', 61, '2015-03-22 12:38:17', 1, 1, 24),
(203, 'MATT', 62, '2015-03-22 12:38:17', 1, 4, 24),
(204, 'Gloss', 62, '2015-03-22 12:38:17', 1, 4, 24),
(205, 'Full UV TYPE 1', 63, '2015-03-22 12:38:17', 1, 7, 24),
(206, 'Full UV TYPE 2', 63, '2015-03-22 12:38:17', 1, 7, 24),
(207, 'Spot UV TYPE 1', 64, '2015-03-22 12:38:18', 1, 8, 24),
(208, 'Spot UV TYPE 2', 64, '2015-03-22 12:38:18', 1, 8, 24),
(209, 'Hot Foil TYPE 1', 65, '2015-03-22 12:38:18', 1, 9, 24),
(210, 'Hot Foil TYPE 2', 65, '2015-03-22 12:38:18', 1, 9, 24),
(211, 'Binding TYPE 1', 66, '2015-03-22 12:38:18', 1, 11, 24),
(212, 'Binding TYPE 2', 66, '2015-03-22 12:38:18', 1, 11, 24),
(213, '11', 67, '2015-03-22 12:38:18', 1, 12, 24),
(214, '15', 67, '2015-03-22 12:38:18', 1, 12, 24),
(215, '20', 67, '2015-03-22 12:38:18', 1, 12, 24),
(216, 'signle', 68, '2015-03-22 12:38:18', 1, 13, 24),
(217, 'both', 68, '2015-03-22 12:38:18', 1, 13, 24),
(218, '100 GSm', 17, '2015-03-24 07:16:39', 1, 2, 17),
(219, '120GSM', 18, '2015-03-24 07:16:49', 1, 3, 17);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_discount_vouchers`
--

CREATE TABLE IF NOT EXISTS `xshop_discount_vouchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `from` date DEFAULT NULL,
  `to` date DEFAULT NULL,
  `no_person` varchar(255) DEFAULT NULL,
  `discount_amount` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_discount_vouchers_used`
--

CREATE TABLE IF NOT EXISTS `xshop_discount_vouchers_used` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `discountvoucher_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_discountvoucher_id` (`discountvoucher_id`),
  KEY `fk_member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_group`
--

CREATE TABLE IF NOT EXISTS `xshop_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_itemenquiry`
--

CREATE TABLE IF NOT EXISTS `xshop_itemenquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `message` text,
  `item_name` varchar(255) DEFAULT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_itemoffers`
--

CREATE TABLE IF NOT EXISTS `xshop_itemoffers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `offer_image_id` int(11) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_offer_image_id` (`offer_image_id`),
  KEY `fk_application_id` (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_items`
--

CREATE TABLE IF NOT EXISTS `xshop_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `is_publish` tinyint(1) DEFAULT NULL,
  `short_description` text,
  `original_price` decimal(10,2) DEFAULT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `rank_weight` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `description` text,
  `search_string` text,
  `show_detail` tinyint(1) DEFAULT NULL,
  `show_price` tinyint(1) DEFAULT NULL,
  `new` tinyint(1) DEFAULT NULL,
  `feature` tinyint(1) DEFAULT NULL,
  `latest` tinyint(1) DEFAULT NULL,
  `mostviewed` tinyint(1) DEFAULT NULL,
  `Item_enquiry_auto_reply` tinyint(1) DEFAULT NULL,
  `allow_comments` tinyint(1) DEFAULT NULL,
  `comment_api` varchar(255) DEFAULT NULL,
  `add_custom_button` tinyint(1) DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `custom_button_url` varchar(255) DEFAULT NULL,
  `tags` text,
  `is_designable` tinyint(1) DEFAULT NULL,
  `designs` text,
  `designer_id` int(11) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `theme_code` varchar(255) DEFAULT NULL,
  `is_party_publish` tinyint(1) DEFAULT NULL,
  `minimum_order_qty` int(11) DEFAULT NULL,
  `maximum_order_qty` int(11) DEFAULT NULL,
  `qty_unit` varchar(255) DEFAULT NULL,
  `is_attachment_allow` tinyint(1) DEFAULT NULL,
  `is_saleable` tinyint(1) DEFAULT NULL,
  `is_downloadable` tinyint(1) DEFAULT NULL,
  `is_rentable` tinyint(1) DEFAULT NULL,
  `is_enquiry_allow` tinyint(1) DEFAULT NULL,
  `is_template` tinyint(1) DEFAULT NULL,
  `negative_qty_allowed` varchar(255) DEFAULT NULL,
  `is_visible_sold` tinyint(1) DEFAULT NULL,
  `offer_id` int(11) DEFAULT NULL,
  `offer_position` varchar(255) DEFAULT NULL,
  `enquiry_send_to_admin` tinyint(1) DEFAULT NULL,
  `watermark_image_id` int(11) DEFAULT NULL,
  `watermark_text` text,
  `watermark_position` varchar(255) DEFAULT NULL,
  `watermark_opacity` varchar(255) DEFAULT NULL,
  `qty_from_set_only` tinyint(1) DEFAULT NULL,
  `custom_button_label` varchar(255) DEFAULT NULL,
  `quotation_id` int(11) DEFAULT NULL,
  `is_servicable` tinyint(1) DEFAULT NULL,
  `is_purchasable` tinyint(1) DEFAULT NULL,
  `mantain_inventory` tinyint(1) DEFAULT NULL,
  `website_display` tinyint(1) DEFAULT NULL,
  `allow_negative_stock` tinyint(1) DEFAULT NULL,
  `is_productionable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_application_id` (`application_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_designer_id` (`designer_id`),
  KEY `fk_offer_id` (`offer_id`),
  KEY `fk_watermark_image_id` (`watermark_image_id`),
  KEY `fk_quotation_id` (`quotation_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `xshop_items`
--

INSERT INTO `xshop_items` (`id`, `application_id`, `epan_id`, `name`, `sku`, `is_publish`, `short_description`, `original_price`, `sale_price`, `rank_weight`, `created_at`, `expiry_date`, `description`, `search_string`, `show_detail`, `show_price`, `new`, `feature`, `latest`, `mostviewed`, `Item_enquiry_auto_reply`, `allow_comments`, `comment_api`, `add_custom_button`, `meta_title`, `meta_description`, `custom_button_url`, `tags`, `is_designable`, `designs`, `designer_id`, `reference`, `theme_code`, `is_party_publish`, `minimum_order_qty`, `maximum_order_qty`, `qty_unit`, `is_attachment_allow`, `is_saleable`, `is_downloadable`, `is_rentable`, `is_enquiry_allow`, `is_template`, `negative_qty_allowed`, `is_visible_sold`, `offer_id`, `offer_position`, `enquiry_send_to_admin`, `watermark_image_id`, `watermark_text`, `watermark_position`, `watermark_opacity`, `qty_from_set_only`, `custom_button_label`, `quotation_id`, `is_servicable`, `is_purchasable`, `mantain_inventory`, `website_display`, `allow_negative_stock`, `is_productionable`) VALUES
(1, 1, 1, '100 GSM Maphlitho', 'GNF001', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' 100 GSM Maphlitho GNF001     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, '', '', 1, 1, NULL, 'pcs', NULL, 0, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 1, 1, 0, 0, 0),
(2, 1, 1, '130 GSM Art Paper', 'GNVC00', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' 130 GSM Art Paper GNVC00     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, '', '', 1, 1, NULL, 'pcs', NULL, 0, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 1, 1, 0, 0, 0),
(3, 1, 1, '170 GSM Art Paper', '009', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' 170 GSM Art Paper 009     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, '', '', 1, 1, NULL, 'pcs', NULL, 0, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 1, 1, 0, 0, 0),
(4, 1, 1, '220 GSM Art Card', 'GNVC00', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' 220 GSM Art Card GNVC00     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, '', '', 1, 1, NULL, 'pcs', NULL, 0, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 1, 1, 0, 0, 0),
(5, 1, 1, '250 GSM Art Card', '007', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' 250 GSM Art Card 007     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, '', '', 1, 1, NULL, 'pcs', NULL, 0, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 1, 1, 0, 0, 0),
(6, 1, 1, '300 GSM Art Card', '003', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' 300 GSM Art Card 003     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, '', '', 1, 1, NULL, 'pcs', NULL, 0, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 1, 1, 0, 0, 0),
(7, 1, 1, '240 GSM Textured Card', '8877', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' 240 GSM Textured Card 8877     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, '', '', 1, 1, NULL, 'pcs', NULL, 0, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 1, 1, 0, 0, 0),
(8, 1, 1, '250 GSM Textured Card', '555', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' 250 GSM Textured Card 555     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, '', '', 1, 1, NULL, 'pcs', NULL, 0, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 1, 1, 0, 0, 0),
(9, 1, 1, '270 GSM Textured Card', '270', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' 270 GSM Textured Card 270     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, '', '', 1, 1, NULL, 'pcs', NULL, 0, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 1, 1, 0, 0, 0),
(10, 1, 1, 'Visting Card', 'V88', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' Visting Card V88     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 1, NULL, NULL, '', '', 1, 1, NULL, 'pcs', NULL, 1, 0, NULL, 0, 1, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 0, 0, 0, 0, 1),
(11, 1, 1, 'Poster', 'poo111', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' Poster poo111     0', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, 'pcs', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(12, 1, 1, 'Stickers', 'sk77', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' Stickers sk77     0', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, 'pcs', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(13, 1, 1, 'Flayers', 'GNF007', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' Flayers GNF007     0', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, 'pcs', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, 1, 1, 'Brochures', 'BH88', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', ' Brochures BH88     0', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, 'pcs', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, 1, 1, 'Professional Busness card', '10000', 1, '', 0.00, 0.00, '0', '2015-03-20', NULL, '', 'Visting Cards Professional Busness card 10000     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 0, NULL, NULL, NULL, NULL, 1, 1, NULL, 'pcs', NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 1, 1, 'Visting Card-Copy', 'V88-18', 0, '', 0.00, 0.00, '0', '2015-03-22', NULL, '', ' Visting Card-Copy V88-18     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 1, NULL, 2, '', '', 1, 1, NULL, 'pcs', NULL, 1, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 0, 0, 0, 0, 1),
(19, 1, 1, 'Visting Card-Copy', 'V88-19', 0, '', 0.00, 0.00, '0', '2015-03-22', NULL, '', ' Visting Card-Copy V88-19     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 1, NULL, 2, '', '', 1, 1, NULL, 'pcs', NULL, 1, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 0, 0, 0, 0, 1),
(20, 1, 1, 'Visting Card-Copy', 'V88-20', 0, '', 0.00, 0.00, '0', '2015-03-22', NULL, '', ' Visting Card-Copy V88-20     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 1, NULL, 2, '', '', 1, 1, NULL, 'pcs', NULL, 1, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 0, 0, 0, 0, 1),
(24, 1, 1, 'Visting Card-Copy', 'V88-24', 0, '', 0.00, 0.00, '0', '2015-03-22', NULL, '', ' Visting Card-Copy V88-24     0.00', 1, 0, 1, 0, 0, 0, NULL, 0, NULL, 0, '', '', '', '', 1, NULL, 2, '', '', 1, 1, NULL, 'pcs', NULL, 1, 0, NULL, 0, 0, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, '', NULL, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_affiliate_ass`
--

CREATE TABLE IF NOT EXISTS `xshop_item_affiliate_ass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `affiliate_id` int(11) DEFAULT NULL,
  `affiliatetype_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_affiliate_id` (`affiliate_id`),
  KEY `fk_affiliatetype_id` (`affiliatetype_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_compositions`
--

CREATE TABLE IF NOT EXISTS `xshop_item_compositions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `composition_item_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_composition_item_id` (`composition_item_id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xshop_item_compositions`
--

INSERT INTO `xshop_item_compositions` (`id`, `item_id`, `composition_item_id`, `qty`, `department_id`, `unit`) VALUES
(1, 24, NULL, NULL, 16, NULL),
(2, 24, 1, '100', 23, '');

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_customfields_assos`
--

CREATE TABLE IF NOT EXISTS `xshop_item_customfields_assos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `customfield_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `department_phase_id` int(11) DEFAULT NULL,
  `can_effect_stock` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_customfield_id` (`customfield_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_department_phase_id` (`department_phase_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `xshop_item_customfields_assos`
--

INSERT INTO `xshop_item_customfields_assos` (`id`, `epan_id`, `customfield_id`, `item_id`, `created_at`, `is_active`, `department_phase_id`, `can_effect_stock`) VALUES
(1, 1, 1, 10, '2015-03-20 09:03:21', 1, 13, 0),
(2, 1, 2, 10, '2015-03-20 09:05:08', 1, 21, 0),
(3, 1, 3, 10, '2015-03-20 09:05:24', 1, 21, 0),
(4, 1, 2, 10, '2015-03-20 09:05:43', 1, 15, 0),
(5, 1, 3, 10, '2015-03-20 09:08:26', 1, 15, 0),
(6, 1, 2, 10, '2015-03-20 09:08:57', 1, 14, 0),
(7, 1, 3, 10, '2015-03-20 09:09:20', 1, 14, 0),
(8, 1, 2, 10, '2015-03-20 09:09:47', 1, 20, 0),
(9, 1, 3, 10, '2015-03-20 09:10:23', 1, 20, 0),
(10, 1, 5, 10, '2015-03-20 09:11:01', 1, 23, 0),
(11, 1, 1, 10, '2015-03-20 09:11:39', 1, 18, 0),
(12, 1, 4, 10, '2015-03-20 09:11:58', 1, 18, 0),
(13, 1, 7, 10, '2015-03-20 09:12:42', 1, 17, 0),
(14, 1, 8, 10, '2015-03-20 09:12:59', 1, 17, 0),
(15, 1, 9, 10, '2015-03-20 09:13:24', 1, 19, 0),
(16, 1, 11, 10, '2015-03-20 09:13:51', 1, 25, 0),
(17, 1, 2, 17, '2015-03-20 12:38:49', 1, 14, 0),
(18, 1, 3, 17, '2015-03-20 12:39:06', 1, 14, 0),
(19, 1, 12, 10, '2015-03-22 08:20:21', 1, 9, 1),
(20, 1, 13, 10, '2015-03-22 08:21:09', 1, 9, 1),
(21, 1, 1, 19, '2015-03-22 12:33:19', 1, NULL, 0),
(22, 1, 2, 19, '2015-03-22 12:33:20', 1, NULL, 0),
(23, 1, 3, 19, '2015-03-22 12:33:20', 1, NULL, 0),
(24, 1, 1, 20, '2015-03-22 12:35:00', 1, 13, 0),
(25, 1, 2, 20, '2015-03-22 12:35:00', 1, 21, 0),
(26, 1, 3, 20, '2015-03-22 12:35:00', 1, 21, 0),
(27, 1, 2, 20, '2015-03-22 12:35:01', 1, 15, 0),
(28, 1, 3, 20, '2015-03-22 12:35:01', 1, 15, 0),
(29, 1, 2, 20, '2015-03-22 12:35:03', 1, 14, 0),
(30, 1, 3, 20, '2015-03-22 12:35:04', 1, 14, 0),
(31, 1, 2, 20, '2015-03-22 12:35:04', 1, 20, 0),
(32, 1, 3, 20, '2015-03-22 12:35:04', 1, 20, 0),
(33, 1, 5, 20, '2015-03-22 12:35:05', 1, 23, 0),
(34, 1, 1, 20, '2015-03-22 12:35:05', 1, 18, 0),
(35, 1, 4, 20, '2015-03-22 12:35:05', 1, 18, 0),
(36, 1, 7, 20, '2015-03-22 12:35:06', 1, 17, 0),
(37, 1, 8, 20, '2015-03-22 12:35:06', 1, 17, 0),
(38, 1, 9, 20, '2015-03-22 12:35:06', 1, 19, 0),
(39, 1, 11, 20, '2015-03-22 12:35:07', 1, 25, 0),
(40, 1, 12, 20, '2015-03-22 12:35:07', 1, 9, 1),
(41, 1, 13, 20, '2015-03-22 12:35:07', 1, 9, 1),
(51, 1, 1, 24, '2015-03-22 12:38:15', 1, 13, 0),
(52, 1, 2, 24, '2015-03-22 12:38:15', 1, 21, 0),
(53, 1, 3, 24, '2015-03-22 12:38:15', 1, 21, 0),
(54, 1, 2, 24, '2015-03-22 12:38:16', 1, 15, 0),
(55, 1, 3, 24, '2015-03-22 12:38:16', 1, 15, 0),
(56, 1, 2, 24, '2015-03-22 12:38:16', 1, 14, 0),
(57, 1, 3, 24, '2015-03-22 12:38:16', 1, 14, 0),
(58, 1, 2, 24, '2015-03-22 12:38:17', 1, 20, 0),
(59, 1, 3, 24, '2015-03-22 12:38:17', 1, 20, 0),
(60, 1, 5, 24, '2015-03-22 12:38:17', 1, 23, 0),
(61, 1, 1, 24, '2015-03-22 12:38:17', 1, 18, 0),
(62, 1, 4, 24, '2015-03-22 12:38:17', 1, 18, 0),
(63, 1, 7, 24, '2015-03-22 12:38:17', 1, 17, 0),
(64, 1, 8, 24, '2015-03-22 12:38:18', 1, 17, 0),
(65, 1, 9, 24, '2015-03-22 12:38:18', 1, 19, 0),
(66, 1, 11, 24, '2015-03-22 12:38:18', 1, 25, 0),
(67, 1, 12, 24, '2015-03-22 12:38:18', 1, 9, 1),
(68, 1, 13, 24, '2015-03-22 12:38:18', 1, 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_custom_rates`
--

CREATE TABLE IF NOT EXISTS `xshop_item_custom_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_department_asso`
--

CREATE TABLE IF NOT EXISTS `xshop_item_department_asso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `can_redefine_qty` tinyint(1) DEFAULT NULL,
  `can_redefine_items` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_department_id` (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `xshop_item_department_asso`
--

INSERT INTO `xshop_item_department_asso` (`id`, `item_id`, `department_id`, `is_active`, `can_redefine_qty`, `can_redefine_items`) VALUES
(1, 10, 13, 1, 1, 1),
(2, 10, 21, 1, 1, 1),
(3, 10, 15, 1, 1, 1),
(4, 10, 14, 1, 1, 1),
(5, 10, 20, 1, 1, 1),
(6, 10, 16, 1, 1, 1),
(7, 10, 22, 1, 1, 1),
(8, 10, 23, 1, 1, 1),
(9, 10, 18, 1, 1, 1),
(10, 10, 17, 1, 1, 1),
(11, 10, 19, 1, 1, 1),
(12, 10, 25, 1, 1, 1),
(13, 10, 12, 1, 1, 1),
(14, 10, 9, 1, 1, 1),
(15, 24, 13, 0, 1, 1),
(16, 24, 23, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_images`
--

CREATE TABLE IF NOT EXISTS `xshop_item_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `item_image_id` int(11) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `customefieldvalue_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_customefieldvalue_id` (`customefieldvalue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xshop_item_images`
--

INSERT INTO `xshop_item_images` (`id`, `item_id`, `item_image_id`, `alt_text`, `title`, `customefieldvalue_id`) VALUES
(1, 17, 2, '', 'xCI', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_member_designs`
--

CREATE TABLE IF NOT EXISTS `xshop_item_member_designs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `last_modified` date DEFAULT NULL,
  `is_ordered` tinyint(1) DEFAULT NULL,
  `designs` text,
  `is_dummy` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_quantity_sets`
--

CREATE TABLE IF NOT EXISTS `xshop_item_quantity_sets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `old_price` decimal(10,2) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `xshop_item_quantity_sets`
--

INSERT INTO `xshop_item_quantity_sets` (`id`, `item_id`, `name`, `qty`, `price`, `old_price`, `is_default`) VALUES
(1, 1, 'Default', '1', 0.00, 0.00, 1),
(2, 2, 'Default', '1', 0.00, 0.00, 1),
(3, 3, 'Default', '1', 0.00, 0.00, 1),
(4, 4, 'Default', '1', 0.00, 0.00, 1),
(5, 5, 'Default', '1', 0.00, 0.00, 1),
(6, 6, 'Default', '1', 0.00, 0.00, 1),
(7, 7, 'Default', '1', 0.00, 0.00, 1),
(8, 8, 'Default', '1', 0.00, 0.00, 1),
(9, 9, 'Default', '1', 0.00, 0.00, 1),
(10, 10, 'Default', '1', 0.00, 0.00, 1),
(11, 11, 'Default', '1', 0.00, 0.00, 1),
(12, 12, 'Default', '1', 0.00, 0.00, 1),
(13, 13, 'Default', '1', 0.00, 0.00, 1),
(14, 14, 'Default', '1', 0.00, 0.00, 1),
(15, 15, 'Default', '1', 0.00, 0.00, 1),
(16, 16, 'Default', '1', 0.00, 0.00, 1),
(17, 17, 'Default', '1', 0.00, 0.00, 1),
(18, 18, 'Default', '1', 0.00, 0.00, 1),
(19, 19, 'Default', '1', 0.00, 0.00, 1),
(20, 20, 'Default', '1', 0.00, 0.00, 1),
(24, 24, 'Default', '1', 0.00, 0.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_quantity_set_conditions`
--

CREATE TABLE IF NOT EXISTS `xshop_item_quantity_set_conditions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quantityset_id` int(11) DEFAULT NULL,
  `custom_field_value_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `customfield_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quantityset_id` (`quantityset_id`),
  KEY `fk_custom_field_value_id` (`custom_field_value_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_customfield_id` (`customfield_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_rate_charts`
--

CREATE TABLE IF NOT EXISTS `xshop_item_rate_charts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_reviews`
--

CREATE TABLE IF NOT EXISTS `xshop_item_reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `review` text,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_spec_ass`
--

CREATE TABLE IF NOT EXISTS `xshop_item_spec_ass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `specification_id` int(11) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `highlight_it` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_specification_id` (`specification_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `xshop_item_spec_ass`
--

INSERT INTO `xshop_item_spec_ass` (`id`, `item_id`, `specification_id`, `value`, `highlight_it`) VALUES
(1, 10, 1, '4*6', 0),
(2, 10, 2, '13 Mp', 0),
(3, 18, 1, '4*6', 0),
(4, 18, 2, '13 Mp', 0),
(5, 19, 1, '4*6', 0),
(6, 19, 2, '13 Mp', 0),
(7, 20, 1, '4*6', 0),
(8, 20, 2, '13 Mp', 0),
(15, 24, 1, '4*6', 0),
(16, 24, 2, '13 Mp', 0);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_manufacturer`
--

CREATE TABLE IF NOT EXISTS `xshop_manufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `website_url` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `office_address` text,
  `zip_code` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_memberdetails`
--

CREATE TABLE IF NOT EXISTS `xshop_memberdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) DEFAULT NULL,
  `address` text,
  `billing_address` text,
  `shipping_address` text,
  `landmark` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `pincode` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_id` (`users_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `xshop_memberdetails`
--

INSERT INTO `xshop_memberdetails` (`id`, `users_id`, `address`, `billing_address`, `shipping_address`, `landmark`, `city`, `state`, `country`, `mobile_number`, `pincode`, `epan_id`, `is_active`, `created_by_id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 05:04:23', '2015-03-20 05:04:23'),
(2, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 05:04:51', '2015-03-20 05:04:51'),
(3, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 05:05:54', '2015-03-20 05:05:54'),
(4, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:07:05', '2015-03-20 07:07:05'),
(5, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:07:44', '2015-03-20 07:07:44'),
(6, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:08:21', '2015-03-20 07:08:21'),
(7, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:09:01', '2015-03-20 07:09:01'),
(8, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:09:41', '2015-03-20 07:09:41'),
(9, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:10:57', '2015-03-20 07:10:57'),
(10, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:12:10', '2015-03-20 07:12:10'),
(11, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:12:47', '2015-03-20 07:12:47'),
(12, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:13:20', '2015-03-20 07:13:20'),
(13, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:14:00', '2015-03-20 07:14:00'),
(14, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:14:47', '2015-03-20 07:14:47'),
(15, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:15:24', '2015-03-20 07:15:24'),
(16, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:16:23', '2015-03-20 07:16:23'),
(17, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:17:02', '2015-03-20 07:17:02'),
(18, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:17:45', '2015-03-20 07:17:45'),
(19, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:18:47', '2015-03-20 07:18:47'),
(20, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:18:57', '2015-03-20 07:18:57'),
(21, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:19:27', '2015-03-20 07:19:27'),
(22, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:20:12', '2015-03-20 07:20:12'),
(23, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:20:39', '2015-03-20 07:20:39'),
(24, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:20:55', '2015-03-20 07:20:55'),
(25, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:21:24', '2015-03-20 07:21:24'),
(26, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:21:53', '2015-03-20 07:21:53'),
(27, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:22:15', '2015-03-20 07:22:15'),
(28, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:22:43', '2015-03-20 07:22:43'),
(29, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, NULL, NULL, '2015-03-20 07:22:59', '2015-03-20 07:22:59'),
(58, 59, '', '', '', '', '', '', '', '8787656565', '', 1, 1, 2, NULL, NULL, NULL, '2015-03-23 06:00:45', '2015-03-23 06:00:45'),
(59, 60, '', '', '', '', '', '', '', '', '', 1, 1, 2, NULL, NULL, NULL, '2015-03-23 10:04:45', '2015-03-23 10:04:45');

-- --------------------------------------------------------

--
-- Table structure for table `xshop_member_images`
--

CREATE TABLE IF NOT EXISTS `xshop_member_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(11) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_image_id` (`image_id`),
  KEY `fk_member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_opportunity`
--

CREATE TABLE IF NOT EXISTS `xshop_opportunity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lead_id` (`lead_id`) USING BTREE,
  KEY `fk_customer_id` (`customer_id`) USING BTREE,
  KEY `fk_employee_id` (`employee_id`) USING BTREE,
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_orderDetails`
--

CREATE TABLE IF NOT EXISTS `xshop_orderDetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `custom_fields` text,
  `created_by_id` int(11) DEFAULT NULL,
  `narration` text,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_id` (`order_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xshop_orderDetails`
--

INSERT INTO `xshop_orderDetails` (`id`, `order_id`, `qty`, `unit`, `rate`, `amount`, `epan_id`, `item_id`, `custom_fields`, `created_by_id`, `narration`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`) VALUES
(1, 1, 100.00, NULL, 20.00, 2000.00, 1, 10, '{"13":{"1":"2"},"14":{"2":"24","3":"27"},"18":{"1":"40","4":"41"},"12":[]}', 2, NULL, NULL, NULL, NULL, '2015-03-23 06:10:58', '2015-03-23 06:10:58'),
(2, 2, 1000.00, NULL, 50.00, 5000.00, 1, 10, '{"9":{"12":"51","13":"54"},"13":{"1":"1"}}', 3, NULL, NULL, NULL, NULL, '2015-03-23 12:57:43', '2015-03-23 12:57:43');

-- --------------------------------------------------------

--
-- Table structure for table `xshop_orderitem_departmental_status`
--

CREATE TABLE IF NOT EXISTS `xshop_orderitem_departmental_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderitem_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `outsource_party_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `is_open` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orderitem_id` (`orderitem_id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_outsource_party_id` (`outsource_party_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `xshop_orderitem_departmental_status`
--

INSERT INTO `xshop_orderitem_departmental_status` (`id`, `orderitem_id`, `department_id`, `outsource_party_id`, `status`, `is_open`) VALUES
(1, 1, 13, NULL, 'Completed in Designing', 1),
(2, 1, 14, NULL, 'Completed in Digital Printing/Press', 1),
(3, 1, 18, NULL, 'Completed in Lamination', 1),
(4, 1, 12, NULL, 'Sent To Dispatch And Delivery', 1),
(5, 2, 9, NULL, 'Completed in Store', 1),
(6, 2, 13, NULL, 'Sent To Designing', 1);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_orders`
--

CREATE TABLE IF NOT EXISTS `xshop_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `discount_voucher` varchar(255) DEFAULT NULL,
  `discount_voucher_amount` varchar(255) DEFAULT NULL,
  `net_amount` varchar(255) DEFAULT NULL,
  `order_summary` text,
  `billing_address` varchar(255) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `paymentgateway_id` int(11) DEFAULT NULL,
  `transaction_reference` varchar(255) DEFAULT NULL,
  `transaction_response_data` text,
  `status` varchar(255) DEFAULT NULL,
  `order_from` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `termsandcondition_id` int(11) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_member_id` (`member_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_termsandcondition_id` (`termsandcondition_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `xshop_orders`
--

INSERT INTO `xshop_orders` (`id`, `member_id`, `name`, `amount`, `discount_voucher`, `discount_voucher_amount`, `net_amount`, `order_summary`, `billing_address`, `shipping_address`, `epan_id`, `paymentgateway_id`, `transaction_reference`, `transaction_response_data`, `status`, `order_from`, `created_by_id`, `email`, `mobile`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`, `termsandcondition_id`, `delivery_date`, `priority_id`) VALUES
(1, 58, '6466', NULL, NULL, NULL, NULL, 'Ramesh Order\r\nvisitng cards 1000 single side .. xyz', NULL, NULL, 1, NULL, NULL, NULL, 'processed', 'offline', 2, NULL, NULL, NULL, NULL, NULL, '2015-03-23 06:01:42', '2015-03-23 06:35:30', 1, NULL, NULL),
(2, 59, '5448', NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, NULL, NULL, 'approved', 'offline', 2, NULL, NULL, NULL, NULL, NULL, '2015-03-23 10:04:51', '2015-03-23 12:58:47', NULL, '2015-03-24', NULL),
(3, 59, '5421', NULL, NULL, NULL, NULL, '', NULL, NULL, 1, NULL, NULL, NULL, 'draft', 'offline', 2, NULL, NULL, NULL, NULL, NULL, '2015-03-23 10:27:11', '2015-03-23 10:27:11', NULL, '2015-03-04', 4),
(14, NULL, '5520', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'submitted', 'online', NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-24 07:35:41', '2015-03-24 07:35:41', NULL, NULL, NULL),
(15, NULL, '6228', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'submitted', 'online', NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-24 07:36:04', '2015-03-24 07:36:04', NULL, NULL, NULL),
(16, NULL, '4553', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'submitted', 'online', NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-24 07:36:58', '2015-03-24 07:36:58', NULL, NULL, NULL),
(17, NULL, '6826', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'submitted', 'online', NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-24 07:37:06', '2015-03-24 07:37:06', NULL, NULL, NULL),
(18, NULL, '9602', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'submitted', 'online', NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-24 07:38:49', '2015-03-24 07:38:49', NULL, NULL, NULL),
(19, NULL, '3586', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, 'submitted', 'online', NULL, NULL, NULL, NULL, NULL, NULL, '2015-03-24 07:39:04', '2015-03-24 07:39:04', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_party`
--

CREATE TABLE IF NOT EXISTS `xshop_party` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `company_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `office_address` text,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `description` text,
  `party_type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_partytype`
--

CREATE TABLE IF NOT EXISTS `xshop_partytype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_payment_gateways`
--

CREATE TABLE IF NOT EXISTS `xshop_payment_gateways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `parameters` text,
  `processing` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `default_parameters` text,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_priorities`
--

CREATE TABLE IF NOT EXISTS `xshop_priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `xshop_priorities`
--

INSERT INTO `xshop_priorities` (`id`, `name`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`, `created_by_id`) VALUES
(5, 'Low', NULL, NULL, NULL, '2015-03-23 10:00:26', '2015-03-23 10:00:26', 2),
(2, 'High', NULL, NULL, NULL, '2015-03-23 09:57:47', '2015-03-23 09:57:47', 2),
(3, 'Medium', NULL, NULL, NULL, '2015-03-23 09:58:06', '2015-03-23 09:58:06', 2),
(4, 'Urgent', NULL, NULL, NULL, '2015-03-23 09:59:16', '2015-03-23 09:59:17', 2);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_productenquiry`
--

CREATE TABLE IF NOT EXISTS `xshop_productenquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `message` text,
  `product_name` varchar(255) DEFAULT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_products`
--

CREATE TABLE IF NOT EXISTS `xshop_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `original_price` varchar(255) DEFAULT NULL,
  `sale_price` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_publish` tinyint(1) DEFAULT NULL,
  `search_string` text,
  `show_offer` tinyint(1) DEFAULT NULL,
  `allow_saleable` tinyint(1) DEFAULT NULL,
  `short_description` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `new` tinyint(1) DEFAULT NULL,
  `feature` tinyint(1) DEFAULT NULL,
  `latest` tinyint(1) DEFAULT NULL,
  `mostviewed` tinyint(1) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `tags` text,
  `show_price` tinyint(1) DEFAULT NULL,
  `enquiry_send_to_self` tinyint(1) DEFAULT NULL,
  `enquiry_send_to_supplier` tinyint(1) DEFAULT NULL,
  `enquiry_send_to_manufacturer` tinyint(1) DEFAULT NULL,
  `product_enquiry_auto_reply` tinyint(1) DEFAULT NULL,
  `allow_comments` tinyint(1) DEFAULT NULL,
  `rank_weight` varchar(255) DEFAULT NULL,
  `comment_api` varchar(255) DEFAULT NULL,
  `show_manufacturer_detail` tinyint(1) DEFAULT NULL,
  `show_supplier_detail` tinyint(1) DEFAULT NULL,
  `show_detail` tinyint(1) DEFAULT NULL,
  `allow_attachment` tinyint(1) DEFAULT NULL,
  `allow_enquiry` tinyint(1) DEFAULT NULL,
  `add_custom_button` tinyint(1) DEFAULT NULL,
  `custom_button_text` varchar(255) DEFAULT NULL,
  `custom_button_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_supplier_id` (`supplier_id`),
  KEY `fk_manufacturer_id` (`manufacturer_id`),
  KEY `fk_epan_id` (`epan_id`),
  FULLTEXT KEY `search_string` (`search_string`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_products_DELETE`
--

CREATE TABLE IF NOT EXISTS `xshop_products_DELETE` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `original_price` varchar(255) DEFAULT NULL,
  `sale_price` int(11) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `is_publish` tinyint(1) DEFAULT NULL,
  `search_string` text,
  `show_offer` tinyint(1) DEFAULT NULL,
  `allow_saleable` tinyint(1) DEFAULT NULL,
  `short_description` text,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text,
  `new` tinyint(1) DEFAULT NULL,
  `feature` tinyint(1) DEFAULT NULL,
  `latest` tinyint(1) DEFAULT NULL,
  `mostviewed` tinyint(1) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `tags` text,
  `show_price` tinyint(1) DEFAULT NULL,
  `enquiry_send_to_self` tinyint(1) DEFAULT NULL,
  `enquiry_send_to_supplier` tinyint(1) DEFAULT NULL,
  `enquiry_send_to_manufacturer` tinyint(1) DEFAULT NULL,
  `product_enquiry_auto_reply` tinyint(1) DEFAULT NULL,
  `allow_comments` tinyint(1) DEFAULT NULL,
  `rank_weight` varchar(255) DEFAULT NULL,
  `comment_api` varchar(255) DEFAULT NULL,
  `show_manufacturer_detail` tinyint(1) DEFAULT NULL,
  `show_supplier_detail` tinyint(1) DEFAULT NULL,
  `show_detail` tinyint(1) DEFAULT NULL,
  `allow_attachment` tinyint(1) DEFAULT NULL,
  `allow_enquiry` tinyint(1) DEFAULT NULL,
  `add_custom_button` tinyint(1) DEFAULT NULL,
  `custom_button_text` varchar(255) DEFAULT NULL,
  `custom_button_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_supplier_id` (`supplier_id`),
  KEY `fk_manufacturer_id` (`manufacturer_id`),
  KEY `fk_epan_id` (`epan_id`),
  FULLTEXT KEY `search_string` (`search_string`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_product_images`
--

CREATE TABLE IF NOT EXISTS `xshop_product_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_quotation`
--

CREATE TABLE IF NOT EXISTS `xshop_quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) DEFAULT NULL,
  `opportunity_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `termsandcondition_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lead_id` (`lead_id`),
  KEY `fk_termsandcondition_id` (`termsandcondition_id`),
  KEY `fk_customer_id` (`customer_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_oppertunity_id` (`opportunity_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xshop_quotation`
--

INSERT INTO `xshop_quotation` (`id`, `lead_id`, `opportunity_id`, `name`, `status`, `termsandcondition_id`, `customer_id`, `created_by_id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'xShop\\Quotation 00001', 'submitted', 1, 58, 2, NULL, NULL, NULL, '2015-03-23 06:50:11', '2015-03-23 06:54:34'),
(2, 1, NULL, 'xShop\\Quotation 00002', 'draft', 1, NULL, 2, NULL, NULL, NULL, '2015-03-23 10:40:21', '2015-03-23 10:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `xshop_quotation_item`
--

CREATE TABLE IF NOT EXISTS `xshop_quotation_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quotation_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `custom_fields` text,
  PRIMARY KEY (`id`),
  KEY `fk_quotation_id` (`quotation_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xshop_quotation_item`
--

INSERT INTO `xshop_quotation_item` (`id`, `quotation_id`, `item_id`, `created_by_id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`, `qty`, `rate`, `amount`, `narration`, `custom_fields`) VALUES
(1, 1, 10, 2, NULL, NULL, NULL, '2015-03-23 06:52:24', '2015-03-23 06:52:24', '50', '1', '50', '', '{"13":{"1":"1"},"20":{"2":"30","3":"33"},"18":{"1":"39","4":"41"},"12":[]}');

-- --------------------------------------------------------

--
-- Table structure for table `xshop_specifications`
--

CREATE TABLE IF NOT EXISTS `xshop_specifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_application_id` (`application_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xshop_specifications`
--

INSERT INTO `xshop_specifications` (`id`, `epan_id`, `application_id`, `name`) VALUES
(1, 1, 1, 'Size'),
(2, 1, 1, 'Camera');

-- --------------------------------------------------------

--
-- Table structure for table `xShop_supplier`
--

CREATE TABLE IF NOT EXISTS `xShop_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `email_id` varchar(255) DEFAULT NULL,
  `phone_no` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `address` text,
  `office_address` text,
  `zip_code` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_termsandcondition`
--

CREATE TABLE IF NOT EXISTS `xshop_termsandcondition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `terms_and_condition` text,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xshop_termsandcondition`
--

INSERT INTO `xshop_termsandcondition` (`id`, `terms_and_condition`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_at`, `updated_at`, `created_by_id`, `name`) VALUES
(1, '<p>The following Terms &amp; Conditions are attached with this document:</p>\r\n<ul>\r\n<li>Company will not deliver items unless specified.</li>\r\n<li>If goods not collected within 15 days of notification/pre-given date. Company will not bear any liability of goods.</li>\r\n<li>Refund is only allowed in case of job wrongly done. Proof reading will be used for such comparisions.</li>\r\n</ul>', NULL, NULL, NULL, '2015-03-23 05:20:03', '2015-03-23 05:20:03', 2, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `xstore_material_request`
--

CREATE TABLE IF NOT EXISTS `xstore_material_request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `from_department_id` int(11) DEFAULT NULL,
  `to_department_id` int(11) DEFAULT NULL,
  `orderitem_id` int(11) DEFAULT NULL,
  `dispatch_to_warehouse_id` int(11) DEFAULT NULL,
  `orderitem_departmental_status_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_from_department_id` (`from_department_id`),
  KEY `fk_to_department_id` (`to_department_id`),
  KEY `fk_orderitem_id` (`orderitem_id`),
  KEY `fk_dispatch_to_warehouse_id` (`dispatch_to_warehouse_id`),
  KEY `fk_orderitem_departmental_status_id` (`orderitem_departmental_status_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `xstore_material_request`
--

INSERT INTO `xstore_material_request` (`id`, `status`, `created_by_id`, `related_document_id`, `related_root_document_name`, `related_document_name`, `from_department_id`, `to_department_id`, `orderitem_id`, `dispatch_to_warehouse_id`, `orderitem_departmental_status_id`, `type`, `name`, `created_at`, `updated_at`) VALUES
(33, 'approved', 2, '3', 'xProduction\\JobCard', 'xProduction\\Jobcard_Processed', 12, 18, 1, 5, 3, 'MaterialRequest', 'xStore\\MaterialRequest 00033', '2015-03-23 10:36:44', '2015-03-23 10:36:45'),
(34, 'approved', 2, '3', 'xProduction\\JobCard', 'xProduction\\Jobcard_Processed', 12, 18, 1, 5, 3, 'MaterialRequest', 'xStore\\MaterialRequest 00034', '2015-03-23 10:37:10', '2015-03-23 10:37:10'),
(35, 'completed', 3, '2', 'xShop\\Order', 'xShop\\Order', 13, 9, 2, 2, 5, 'MaterialRequest', 'xStore\\MaterialRequest 00035', '2015-03-23 12:58:47', '2015-03-23 13:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `xstore_material_request_items`
--

CREATE TABLE IF NOT EXISTS `xstore_material_request_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `material_request_jobcard_id` int(11) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  `custom_fields` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_material_request_jobcard_id` (`material_request_jobcard_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `xstore_material_request_items`
--

INSERT INTO `xstore_material_request_items` (`id`, `item_id`, `qty`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_by_id`, `unit`, `material_request_jobcard_id`, `narration`, `custom_fields`, `created_at`, `updated_at`) VALUES
(15, 10, NULL, NULL, NULL, NULL, 2, NULL, 33, NULL, NULL, '2015-03-23 10:36:45', '2015-03-23 10:36:45'),
(16, 10, NULL, NULL, NULL, NULL, 2, NULL, 34, NULL, NULL, '2015-03-23 10:37:10', '2015-03-23 10:37:10'),
(17, 10, '1000.00', NULL, NULL, NULL, 3, 'pcs', 35, NULL, '{"9":{"12":"51","13":"54"},"13":{"1":"1"}}', '2015-03-23 12:58:47', '2015-03-23 12:58:47');

-- --------------------------------------------------------

--
-- Table structure for table `xstore_stock`
--

CREATE TABLE IF NOT EXISTS `xstore_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `custom_fields` text,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_warehouse_id` (`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xstore_stock_movement_items`
--

CREATE TABLE IF NOT EXISTS `xstore_stock_movement_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_movement_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `custom_fields` text,
  PRIMARY KEY (`id`),
  KEY `fk_stock_movement_id` (`stock_movement_id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xstore_stock_movement_items`
--

INSERT INTO `xstore_stock_movement_items` (`id`, `stock_movement_id`, `item_id`, `qty`, `unit`, `custom_fields`) VALUES
(1, 4, 10, '1000.00', 'pcs', '{"9":{"12":"51","13":"54"},"13":{"1":"1"}}');

-- --------------------------------------------------------

--
-- Table structure for table `xstore_stock_movement_master`
--

CREATE TABLE IF NOT EXISTS `xstore_stock_movement_master` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `from_supplier_id` int(11) DEFAULT NULL,
  `to_supplier_id` int(11) DEFAULT NULL,
  `from_memberdetails_id` int(11) DEFAULT NULL,
  `to_memberdetails_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `from_warehouse_id` int(11) DEFAULT NULL,
  `to_warehouse_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `jobcard_id` int(11) DEFAULT NULL,
  `material_request_jobcard_id` int(11) DEFAULT NULL,
  `dispatch_request_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_from_supplier_id` (`from_supplier_id`),
  KEY `fk_to_supplier_id` (`to_supplier_id`),
  KEY `fk_from_memberdetails_id` (`from_memberdetails_id`),
  KEY `fk_to_memberdetails_id` (`to_memberdetails_id`),
  KEY `fk_from_warehouse_id` (`from_warehouse_id`),
  KEY `fk_to_warehouse_id` (`to_warehouse_id`),
  KEY `fk_po_id` (`po_id`),
  KEY `fk_jobcard_id` (`jobcard_id`),
  KEY `fk_material_request_jobcard_id` (`material_request_jobcard_id`) USING BTREE
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `xstore_stock_movement_master`
--

INSERT INTO `xstore_stock_movement_master` (`id`, `status`, `related_document_id`, `related_root_document_name`, `related_document_name`, `created_by_id`, `from_supplier_id`, `to_supplier_id`, `from_memberdetails_id`, `to_memberdetails_id`, `type`, `created_at`, `from_warehouse_id`, `to_warehouse_id`, `po_id`, `jobcard_id`, `material_request_jobcard_id`, `dispatch_request_id`, `updated_at`) VALUES
(1, 'accepted', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 'ProductionConsume', '2015-03-23 06:25:49', 2, NULL, NULL, 1, NULL, NULL, '2015-03-23 06:27:36'),
(2, 'accepted', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 'ProductionConsume', '2015-03-23 06:32:40', 9, NULL, NULL, 2, NULL, NULL, '2015-03-23 06:32:44'),
(3, 'accepted', NULL, NULL, NULL, 2, NULL, NULL, NULL, NULL, 'ProductionConsume', '2015-03-23 06:35:59', 10, NULL, NULL, 3, NULL, NULL, '2015-03-23 06:36:02'),
(4, 'accepted', '35', 'xStore\\MaterialRequestReceived', 'xStore\\MaterialRequestReceived_Processing', 3, NULL, NULL, NULL, NULL, 'StockTransfer', '2015-03-23 13:03:24', 1, 2, NULL, NULL, 35, NULL, '2015-03-23 13:08:14');

-- --------------------------------------------------------

--
-- Table structure for table `xstore_warehouse`
--

CREATE TABLE IF NOT EXISTS `xstore_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `out_source_party_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_out_source_party_id` (`out_source_party_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `xstore_warehouse`
--

INSERT INTO `xstore_warehouse` (`id`, `name`, `department_id`, `out_source_party_id`) VALUES
(1, 'store ka warehouse', 9, NULL),
(2, 'Designing', 13, NULL),
(5, 'Dispatch And Delivery', 12, NULL),
(6, 'CRM', 8, NULL),
(8, 'Screen printing', 20, NULL),
(9, 'Digital Printing/Press', 14, NULL),
(10, 'Lamination', 18, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `xhr_employee_attendence`
--
ALTER TABLE `xhr_employee_attendence`
  ADD CONSTRAINT `xhr_employee_attendence_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `xhr_employees` (`id`);

--
-- Constraints for table `xhr_employee_leave`
--
ALTER TABLE `xhr_employee_leave`
  ADD CONSTRAINT `xhr_employee_leave_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xhr_employee_leave_ibfk_2` FOREIGN KEY (`leave_type_id`) REFERENCES `xhr_leave_types` (`id`),
  ADD CONSTRAINT `xhr_employee_leave_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`);

--
-- Constraints for table `xproduction_jobcard`
--
ALTER TABLE `xproduction_jobcard`
  ADD CONSTRAINT `xproduction_jobcard_ibfk_1` FOREIGN KEY (`to_department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xproduction_jobcard_ibfk_2` FOREIGN KEY (`dispatch_to_warehouse_id`) REFERENCES `xstore_warehouse` (`id`);

--
-- Constraints for table `xpurchase_purchase_order`
--
ALTER TABLE `xpurchase_purchase_order`
  ADD CONSTRAINT `xpurchase_purchase_order_ibfk_1` FOREIGN KEY (`xpurchase_supplier_id`) REFERENCES `xpurchase_supplier` (`id`);

--
-- Constraints for table `xshop_orders`
--
ALTER TABLE `xshop_orders`
  ADD CONSTRAINT `xshop_orders_ibfk_1` FOREIGN KEY (`termsandcondition_id`) REFERENCES `xshop_termsandcondition` (`id`);

--
-- Constraints for table `xshop_termsandcondition`
--
ALTER TABLE `xshop_termsandcondition`
  ADD CONSTRAINT `xshop_termsandcondition_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`);

--
-- Constraints for table `xstore_material_request_items`
--
ALTER TABLE `xstore_material_request_items`
  ADD CONSTRAINT `xstore_material_request_items_ibfk_1` FOREIGN KEY (`material_request_jobcard_id`) REFERENCES `xstore_material_request` (`id`);

--
-- Constraints for table `xstore_stock_movement_master`
--
ALTER TABLE `xstore_stock_movement_master`
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_1` FOREIGN KEY (`material_request_jobcard_id`) REFERENCES `xstore_material_request` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
