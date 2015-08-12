-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 12, 2015 at 02:15 PM
-- Server version: 5.5.43
-- PHP Version: 5.5.26-1+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `erp`
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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_attachment_url_id` (`attachment_url_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

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
-- Table structure for table `developerzone_editor_tools`
--

CREATE TABLE IF NOT EXISTS `developerzone_editor_tools` (
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
-- Dumping data for table `developerzone_editor_tools`
--

INSERT INTO `developerzone_editor_tools` (`id`, `category`, `name`, `template`, `is_output_multibranch`, `special_php_handler`, `icon`, `order`, `type`, `instance_ports`, `is_for_editor`, `js_widget`, `can_add_ports`) VALUES
(1, 'General', 'Code Block', '// _name_  \\n \\t _code_  \\n\\t  // _name_', NULL, NULL, 'fa fa-users fa-2x', NULL, 'Process', '[]', 1, 'CodeBlock', 1),
(3, 'General', 'ConnectorPort', NULL, NULL, NULL, 'port fa fa-play ', NULL, 'in-out', NULL, 0, 'Port', 0),
(5, 'General', 'A>B ?', 'if( _port_A_ > _port_B) {\\n \\t _branch_true_code_ \\n\\t} else  { \\n\\t  _branch_false_code \\n\\t}', NULL, 'If', 'fa fa-cog fa-2x', NULL, 'PHPFunc', '[{"type":"DATA-IN","name":"A","mandatory":"YES","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"B","mandatory":"YES","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"true","creates_block":"TRUE_BLOCK","caption":""},{"type":"DATA-OUT","name":"false","creates_block":"FALSE_BLOCK","caption":""}]', 0, 'Node', 0),
(6, 'General', 'Variable', '$_name_ = _name_', NULL, 'Variable', NULL, NULL, 'PHPFunc', '[{"type":"DATA-OUT","name":"value","creates_block":"NO","caption":""}]', NULL, 'Node', 0),
(7, 'General', 'ForEach', 'foreach ( \\n\\t $_port_items_name_ as $_port_key_name_ => $_port_value_name_) { _branch_value_code_ }', NULL, 'Foreach', NULL, NULL, 'PHPFunc', '[{"type":"DATA-IN","name":"A","mandatory":"YES","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"B","mandatory":"YES","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"key","creates_block":"FOREACH_BLOCK","caption":""},{"type":"DATA-OUT","name":"values","creates_block":"FOREACH_BLOCK","caption":""}]', NULL, 'Node', 0),
(8, 'General', 'Method Call', NULL, NULL, 'method_call', 'fa fa-calendar fa-2x', NULL, 'PHPFunc', '[]', NULL, 'MethodCall', 0);

-- --------------------------------------------------------

--
-- Table structure for table `developerzone_entities`
--

CREATE TABLE IF NOT EXISTS `developerzone_entities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `component_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `parent_class` varchar(255) DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `is_class` tinyint(1) DEFAULT NULL,
  `instance_ports` text,
  `is_framework_class` tinyint(1) DEFAULT NULL,
  `js_widget` varchar(255) DEFAULT NULL,
  `css_class` varchar(255) DEFAULT NULL,
  `code_structure` text,
  PRIMARY KEY (`id`),
  KEY `fk_component_id` (`component_id`),
  KEY `fk_owner_id` (`owner_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `developerzone_entities`
--

INSERT INTO `developerzone_entities` (`id`, `component_id`, `name`, `type`, `table_name`, `parent_class`, `owner_id`, `is_class`, `instance_ports`, `is_framework_class`, `js_widget`, `css_class`, `code_structure`) VALUES
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
INSERT INTO `developerzone_entities` (`id`, `component_id`, `name`, `type`, `table_name`, `parent_class`, `owner_id`, `is_class`, `instance_ports`, `is_framework_class`, `js_widget`, `css_class`, `code_structure`) VALUES
(12, NULL, 'View_Columns', 'Object', NULL, NULL, 7, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"addColumn","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"width","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"auto"},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":52,"top":46,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"12"}'),
(13, NULL, 'SQL_Model', 'Object', NULL, NULL, 8, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"addField","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"actual_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":20,"top":20,"width":159,"height":66,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"_dsql","uuid":"6","type":"Method","Ports":{"1":{"type":"Out","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":312.35000610352,"top":20,"width":151,"height":70,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"dsql","uuid":"9","type":"Method","Ports":{"1":{"type":"Out","name":"_dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":599.46670532227,"top":20,"width":166,"height":76,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"selectQuery","uuid":"12","type":"Method","Ports":{"1":{"type":"In","name":"fields","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"_selectQuery","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":20,"top":95.16667175293,"width":116,"height":84,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"fieldQuery","uuid":"21","type":"Method","Ports":{"1":{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":200.93333435059,"top":88.933334350586,"width":120,"height":92,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"titleQuery","uuid":"25","type":"Method","Ports":{"1":{"type":"Out","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":795.11666870117,"top":20,"width":162,"height":82,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addExpression","uuid":"28","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"expression","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"expression","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":54.466674804688,"top":193.93334960938,"width":128,"height":71,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"join","uuid":"33","type":"Method","Ports":{"1":{"type":"In","name":"foreign_table","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"master_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"join_kind","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"In","name":"$_foreign_alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"5":{"type":"In","name":"relation","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"6":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":577.75003051758,"top":116.63333129883,"width":160,"height":79,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"leftJoin","uuid":"47","type":"Method","Ports":{"1":{"type":"In","name":"foreign_table","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"master_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"join_kind","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"In","name":"_foreign_alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"5":{"type":"In","name":"relation","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"6":{"type":"Out","name":"join","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":406.16665649414,"top":100.16667175293,"width":145,"height":88,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"hasOne","uuid":"55","type":"Method","Ports":{"1":{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"display_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"In","name":"as_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"5":{"type":"Out","name":"Field_Reference","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":44.050003051758,"top":262.04998779297,"width":140,"height":81,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"hasMany","uuid":"62","type":"Method","Ports":{"1":{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"their_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"4":{"type":"In","name":"as_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"5":{"type":"Out","name":"SQL_Many","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":464.05001831055,"top":208.04998779297,"width":138,"height":98,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"ref","uuid":"69","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"load","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":801.58334350586,"top":127.58331298828,"width":152,"height":69,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"refSQL","uuid":"74","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":264.46667480469,"top":195.46667480469,"width":129,"height":88,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"getRef","uuid":"83","type":"Method","Ports":{"1":{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"load","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"3":{"type":"Out","name":"ref (name, load )","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":462.70001220703,"top":347.70001220703,"width":153,"height":73,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addCondition","uuid":"88","type":"Method","Ports":{"1":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"3":{"type":"In","name":"cond","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},"4":{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},"5":{"type":"In","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"}},"Nodes":[],"Connections":[],"left":683.05001831055,"top":224.04998779297,"width":135,"height":78,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"sum","uuid":"95","type":"Method","Ports":{"1":{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":137.46667480469,"top":349.46667480469,"width":171,"height":88,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"_load","uuid":"99","type":"Method","Ports":{"1":{"type":"In","name":"id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"ignore_missing","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"false"},"3":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":720.9333190918,"top":347.93334960938,"width":124,"height":67,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"loadData","uuid":"104","type":"Method","Ports":{"1":{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":42.466674804688,"top":437.46667480469,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"saveAndUnload","uuid":"108","type":"Method","Ports":{"1":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":365.35000610352,"top":447.34997558594,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"update","uuid":"111","type":"Method","Ports":{"1":{"type":"In","name":"data","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array"},"2":{"type":"Out","name":"save","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":693.58334350586,"top":458.58331298828,"width":123,"height":67,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"tryDelete","uuid":"115","type":"Method","Ports":{"1":{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":638.23330688477,"top":544.23333740234,"width":109,"height":59,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setActualFields","uuid":"119","type":"Method","Ports":{"1":{"type":"In","name":"array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"3":{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":271.46667480469,"top":557.46667480469,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"13"}'),
(14, NULL, 'View_Box', 'Object', NULL, NULL, 7, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"addIcon","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":55,"top":70,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"addButton","uuid":"5","type":"Method","Ports":{"1":{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Continue"},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":305,"top":35,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"14"}'),
(15, NULL, 'View_Badge', 'Object', NULL, NULL, 7, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"setCount","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"count","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":22,"top":33,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setCountSwatch","uuid":"5","type":"Method","Ports":{"1":{"type":"In","name":"swatch","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":311,"top":49,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"setBadgeSwatch","uuid":"9","type":"Method","Ports":{"1":{"type":"In","name":"swatch","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":20,"top":187,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"15"}'),
(16, NULL, 'DB', 'Object', NULL, NULL, 5, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', '{"name":"init","class":"View","attributes":[],"Method":[{"name":"connect","uuid":"1","type":"Method","Ports":{"1":{"type":"In","name":"dsn","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":52,"top":32,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"dsql","uuid":"5","type":"Method","Ports":{"1":{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},"2":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":324,"top":47,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"},{"name":"query","uuid":"9","type":"Method","Ports":{"1":{"type":"In","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},"2":{"type":"In","name":"params","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array()"},"3":{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}},"Nodes":[],"Connections":[],"left":654,"top":35,"width":200,"height":100,"ports_obj":[],"js_widget":"CodeBlock"}],"id":"16"}'),
(17, NULL, 'Model_Table', 'Object', NULL, NULL, 13, 1, '[{"type":"DATA-IN","name":"owner","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"options","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"spot","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-IN","name":"template","mandatory":"NO","caption":"","is_singlaton":"YES"},{"type":"DATA-OUT","name":"object","creates_block":"NO","caption":""}]', 0, 'Node', 'Node', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `developerzone_entity_attributes`
--

CREATE TABLE IF NOT EXISTS `developerzone_entity_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `developerzone_entities_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_developerZone_entities_id` (`developerzone_entities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `developerzone_entity_methods`
--

CREATE TABLE IF NOT EXISTS `developerzone_entity_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `method_type` varchar(255) DEFAULT NULL,
  `properties` varchar(255) DEFAULT NULL,
  `default_ports` text,
  `developerzone_entities_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_developerZone_entities_id` (`developerzone_entities_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=847 ;

--
-- Dumping data for table `developerzone_entity_methods`
--

INSERT INTO `developerzone_entity_methods` (`id`, `name`, `method_type`, `properties`, `default_ports`, `developerzone_entities_id`) VALUES
(206, 'destroy', 'public', NULL, '[{"type":"In","name":"recursive","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"}]', NULL),
(207, 'removeElement', 'public', NULL, '[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(208, 'getElement', 'public', NULL, '[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(209, 'hasElement', 'public', NULL, '[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(210, 'rename', 'public', NULL, '[{"type":"In","name":"short_name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(211, 'setModel', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(212, 'memorize', 'public', NULL, '[{"type":"In","name":"key","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(213, 'recall', 'public', NULL, '[{"type":"In","name":"key","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"default","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(217, 'setModel', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"actual_fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(218, 'getHTML', 'public', NULL, '[{"type":"In","name":"destroy","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"},{"type":"In","name":"execute_js","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"},{"type":"Out","name":"html","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(219, 'js', 'public', NULL, '[{"type":"In","name":"when","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"code","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"instance","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"jQuery_Chain","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(297, 'setElement', 'public', NULL, '[{"type":"In","name":"element","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(298, 'setAttr', 'public', NULL, '[{"type":"In","name":"attribute","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(299, 'setClass', 'public', NULL, '[{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(300, 'addClass', 'public', NULL, '[{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(301, 'setStyle', 'public', NULL, '[{"type":"In","name":"property","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"style","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(302, 'addStyle', 'public', NULL, '[{"type":"In","name":"property","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"style","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(303, 'set', 'public', NULL, '[{"type":"In","name":"text","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(304, 'setText', 'public', NULL, '[{"type":"In","name":"text","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(305, 'setHTML', 'public', NULL, '[{"type":"In","name":"html","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(377, 'setSource', 'public', NULL, '[{"type":"In","name":"source","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(463, 'addTitle', 'public', NULL, '[{"type":"In","name":"title","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Menu_Advanced_Title"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(464, 'addItem', 'public', NULL, '[{"type":"In","name":"title","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"action","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Menu_Advanced_Item"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(465, 'addMenu', 'public', NULL, '[{"type":"In","name":"title","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"options","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array()"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(466, 'addMenuItem', 'public', NULL, '[{"type":"In","name":"page","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(503, 'addField', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(504, 'addExpression', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"expression","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"field_class","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(505, 'set', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"mix","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(506, 'get', 'public', NULL, '[{"type":"In","name":"name","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"data","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(507, 'getGroupField', 'public', NULL, '[{"type":"In","name":"group","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"all"},{"type":"Out","name":"array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(508, 'setActualFields', 'public', NULL, '[{"type":"In","name":"group","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"array the actual fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(509, 'getActualFields', 'public', NULL, '[{"type":"Out","name":"array the actual fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(510, 'getTitleField', 'public', NULL, '[{"type":"Out","name":"string the title field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(511, 'setDirty', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(512, 'isDirty', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"bool","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(513, 'setSource', 'public', NULL, '[{"type":"In","name":"controller","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"table","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(514, 'load', 'public', NULL, '[{"type":"In","name":"id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(515, 'tryLoad', 'public', NULL, '[{"type":"In","name":"id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(516, 'loadAny', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(517, 'tryLoadAny', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(518, 'loadBy', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"cond","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(519, 'tryLoadBy', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"cond","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(520, 'loaded', 'public', NULL, '[{"type":"Out","name":"boolean","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(521, 'unload', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(522, 'reset', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(523, 'save', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(524, 'saveAndUnload', 'public', NULL, '[{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(525, 'delete', 'public', NULL, '[{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(526, 'deleteAll', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(527, 'reload', 'public', NULL, '[{"type":"Out","name":"current record id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(528, 'addCondition', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"operator","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(529, 'setLimit', 'public', NULL, '[{"type":"In","name":"count","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"offset","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(530, 'setOrder', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"desc","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(531, 'count', 'public', NULL, '[{"type":"In","name":"alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"integer","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(532, 'getRows', 'public', NULL, '[{"type":"In","name":"fields","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(533, 'hasField', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(534, 'getField', 'public', NULL, '[{"type":"In","name":"f","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(535, 'hasOne', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"In","name":"field_class","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"Out","name":"expr","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(536, 'hasMany', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"their_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"In","name":"our_field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"UNDEFINED"},{"type":"In","name":"reference_name","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"null","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(537, 'ref', 'public', NULL, '[{"type":"In","name":"ref1","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"type","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(538, 'debug', 'public', NULL, '[{"type":"In","name":"debug","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"true"},{"type":"Out","name":"debug","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(544, 'addColumn', 'public', NULL, '[{"type":"In","name":"width","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"auto"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(568, 'setCount', 'public', NULL, '[{"type":"In","name":"count","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(569, 'setCountSwatch', 'public', NULL, '[{"type":"In","name":"swatch","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(570, 'setBadgeSwatch', 'public', NULL, '[{"type":"In","name":"swatch","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(577, 'connect', 'public', NULL, '[{"type":"In","name":"dsn","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(578, 'dsql', 'public', NULL, '[{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(579, 'query', 'public', NULL, '[{"type":"In","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"params","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array()"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(690, 'addIcon', 'public', NULL, '[{"type":"In","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(691, 'addButton', 'public', NULL, '[{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Continue"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(714, 'addField', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"actual_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(715, '_dsql', 'public', NULL, '[{"type":"Out","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(716, 'dsql', 'public', NULL, '[{"type":"Out","name":"_dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(717, 'selectQuery', 'public', NULL, '[{"type":"In","name":"fields","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"_selectQuery","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(718, 'fieldQuery', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(719, 'titleQuery', 'public', NULL, '[{"type":"Out","name":"query","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(720, 'addExpression', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"expression","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"expression","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(721, 'join', 'public', NULL, '[{"type":"In","name":"foreign_table","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"master_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"join_kind","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"$_foreign_alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"relation","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(722, 'leftJoin', 'public', NULL, '[{"type":"In","name":"foreign_table","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"master_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"join_kind","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"_foreign_alias","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"relation","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"join","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(723, 'hasOne', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"display_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"as_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"Field_Reference","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(724, 'hasMany', 'public', NULL, '[{"type":"In","name":"model","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"their_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"our_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"as_field","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"SQL_Many","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(725, 'ref', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"load","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(726, 'refSQL', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(727, 'getRef', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"load","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"ref (name, load )","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(728, 'addCondition', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"cond","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},{"type":"In","name":"value","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},{"type":"In","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"}]', NULL),
(729, 'sum', 'public', NULL, '[{"type":"In","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"dsql","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(730, '_load', 'public', NULL, '[{"type":"In","name":"id","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"ignore_missing","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"false"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(731, 'loadData', 'public', NULL, '[{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(732, 'saveAndUnload', 'public', NULL, '[{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(733, 'update', 'public', NULL, '[{"type":"In","name":"data","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"array"},{"type":"Out","name":"save","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(734, 'tryDelete', 'public', NULL, '[{"type":"In","name":"id","mandatory":false,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(735, 'setActualFields', 'public', NULL, '[{"type":"In","name":"array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"fields","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"this","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(831, 'addField', 'public', NULL, '[{"type":"In","name":"type","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"options","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"caption","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"In","name":"attr","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"field","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(832, 'set', 'public', NULL, '[{"type":"In","name":"field_or_array","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"value","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"undefined"},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(833, 'getAllFields', 'public', NULL, '[{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(834, 'addSubmit', 'public', NULL, '[{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Save"},{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"submit","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(835, 'addButton', 'public', NULL, '[{"type":"In","name":"label","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"Button"},{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":"null"},{"type":"Out","name":"button","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(836, 'update', 'public', NULL, '[{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(837, 'save', 'public', NULL, '[{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(838, 'submitted', 'public', NULL, '[{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(839, 'isSubmitted', 'public', NULL, '[{"type":"Out","name":"result","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(840, 'onSubmit', 'public', NULL, '[{"type":"In","name":"callback","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(841, 'hasField', 'public', NULL, '[{"type":"In","name":"","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"Out","name":"object","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(842, 'isClicked', 'public', NULL, '[{"type":"In","name":"name","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(843, 'addClass', 'public', NULL, '[{"type":"Out","name":"$_POST","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""},{"type":"In","name":"class","mandatory":true,"is_singlaton":true,"left":0,"top":0,"creates_block":false,"default_value":""}]', NULL),
(846, 'init', 'public', NULL, '[]', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `developerzone_events`
--

CREATE TABLE IF NOT EXISTS `developerzone_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `fire_spot` varchar(255) DEFAULT NULL,
  `developerzone_entities_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_developerZone_entities_id` (`developerzone_entities_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `developerzone_method_nodes`
--

CREATE TABLE IF NOT EXISTS `developerzone_method_nodes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `developerzone_entity_methods_id` int(11) DEFAULT NULL,
  `developerzone_entities_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_developerZone_entity_methods_id` (`developerzone_entity_methods_id`),
  KEY `fk_developerZone_entities_id` (`developerzone_entities_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `developerzone_method_nodes`
--

INSERT INTO `developerzone_method_nodes` (`id`, `name`, `inputs`, `outputs`, `reference_obj`, `action`, `is_processed`, `parent_node_id`, `branch`, `total_ins`, `input_resolved_for_branch`, `developerzone_entity_methods_id`, `developerzone_entities_id`) VALUES
(1, 'Draft Quotations', NULL, NULL, NULL, 'Block', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Model Quotation', NULL, NULL, NULL, 'Add', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'status', 'status', NULL, NULL, 'Variable', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'draft', 'draft', NULL, NULL, 'Variable', 1, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'addCondition', NULL, NULL, '2', 'methodCall', 0, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'CRUD', NULL, NULL, NULL, 'Add', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(7, 'setModel', NULL, NULL, '6', 'methodCall', 0, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `developerzone_method_nodes_connections`
--

CREATE TABLE IF NOT EXISTS `developerzone_method_nodes_connections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `from_port_id` int(11) DEFAULT NULL,
  `to_port_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_from_port_id` (`from_port_id`),
  KEY `fk_to_port_id` (`to_port_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `developerzone_method_nodes_connections`
--

INSERT INTO `developerzone_method_nodes_connections` (`id`, `name`, `from_port_id`, `to_port_id`) VALUES
(1, 'addCond->field', 3, 5),
(2, 'addCond->value', 4, 5),
(3, 'addCond_obj', 2, 8),
(4, 'block_out_set', 12, 1),
(5, 'model->setModel', 1, 11),
(6, 'setModel->obj', 9, 10);

-- --------------------------------------------------------

--
-- Table structure for table `developerzone_method_node_ports`
--

CREATE TABLE IF NOT EXISTS `developerzone_method_node_ports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `node_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_node_id` (`node_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `developerzone_method_node_ports`
--

INSERT INTO `developerzone_method_node_ports` (`id`, `node_id`, `name`, `type`) VALUES
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
  `pin_code` varchar(255) DEFAULT NULL,
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
  `gateway_url` varchar(255) DEFAULT NULL,
  `sms_password` varchar(255) DEFAULT NULL,
  `sms_username` varchar(255) DEFAULT NULL,
  `sms_user_name_qs_param` varchar(255) DEFAULT NULL,
  `sms_password_qs_param` varchar(255) DEFAULT NULL,
  `sms_number_qs_param` varchar(255) DEFAULT NULL,
  `sm_message_qs_param` varchar(255) DEFAULT NULL,
  `sms_prefix` varchar(255) DEFAULT NULL,
  `sms_postfix` varchar(255) DEFAULT NULL,
  `time_zone` varchar(255) DEFAULT NULL,
  `bounce_imap_email_host` varchar(255) DEFAULT NULL,
  `bounce_imap_email_port` varchar(255) DEFAULT NULL,
  `bounce_imap_email_password` varchar(255) DEFAULT NULL,
  `bounce_imap_flags` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_staff1` (`staff_id`),
  KEY `fk_epan_epan_categories1` (`category_id`),
  KEY `fk_branch_id` (`branch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan`
--

INSERT INTO `epan` (`id`, `name`, `staff_id`, `branch_id`, `password`, `fund_alloted`, `created_at`, `category_id`, `company_name`, `contact_person_name`, `mobile_no`, `address`, `city`, `state`, `country`, `pin_code`, `email_id`, `keywords`, `description`, `website`, `is_active`, `is_approved`, `last_email_sent`, `allowed_aliases`, `parked_domain`, `email_host`, `email_port`, `email_username`, `email_password`, `email_reply_to`, `email_reply_to_name`, `user_activation`, `email_threshold`, `user_registration_email_subject`, `user_registration_email_message_body`, `email_transport`, `encryption`, `from_email`, `from_name`, `sender_email`, `sender_name`, `return_path`, `smtp_auto_reconnect`, `emails_in_BCC`, `last_emailed_at`, `email_sent_in_this_minute`, `is_frontend_registration_allowed`, `gateway_url`, `sms_password`, `sms_username`, `sms_user_name_qs_param`, `sms_password_qs_param`, `sms_number_qs_param`, `sm_message_qs_param`, `sms_prefix`, `sms_postfix`, `time_zone`, `bounce_imap_email_host`, `bounce_imap_email_port`, `bounce_imap_email_password`, `bounce_imap_flags`) VALUES
(1, 'web', NULL, NULL, NULL, '5000000', '2014-01-26', 1, 'Xavoc Technocrats Pvt. Ltd.', 'Gowrav Vishwakarma', '+91 8875191258', '18/436, Gayatri marg, Kanji Ka hata, Udaipur, Rajasthan , India', 'Udaipur', 'Rajasthan', 'India', '313001', 'info@xavoc.com', 'PHP development, Web, Online, Android, development company, xepan, cms developer, drag and drop website builder developer, ERP developer, Developers tools developer, Artificial Intelligent application/software developer.', 'Xavoc is a world class company providing cutting edge technology to next generation, Xavoc works in developing new tools for web and mobile like Artificial Intelligent website builder or cms like xEpan. Developer of xCIDeveloper, A tool to let you write Joomla components in CodeIgniter. Developer of xJDataMapper, a ruby style ORM for JAVA. Contributor in spreading agiletoolkit, a great PHP framework. In Short, Not just another IT Company in town.', 'http://www.xavoc.com', 1, 1, NULL, 1, NULL, 'mail.xavoc.com', '465', 'info@xavoc.com', 'Gowrav@123', 'info@xavoc.com', 'XTPL :: Xavoc Technocrats Pvt. Ltd.', 'self_activated', 3, '', '', 'SmtpTransport', 'ssl', 'info@xavoc.com', 'XTPL :: Xavoc Technocrats Pvt. Ltd.', 'info@xavoc.com', 'XTPL :: Xavoc Technocrats Pvt. Ltd.', 'bounce@xavoc.com', 100, NULL, NULL, 1, NULL, 'http://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&v=1.1&format=text&msg_type=TEXT', 'ant55', '2000059879', 'userid', 'password', 'send_to', 'msg', '', '-Xavoc', 'Asia/Kolkata', 'sun.rightdns.com', '993', 'Gowrav@123', '/imap/ssl/novalidate-cert\r\n');

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
(1, 'Default', 'Default', NULL);

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
(80, 'Production Management', '0', '0', 'xProduction', 'application', 0, '0', 1, 0, 0, NULL, 0, 'https://github.com/xepan/xProduction.git', 1, NULL),
(81, 'Customer Relation Management', '0', '0', 'xCRM', 'application', 0, '0', 1, 0, 0, NULL, 0, 'https://github.com/xepan/xCRM.git', 1, NULL),
(82, 'Accounts Mangement Application', '0', '0', 'xAccount', 'application', 0, '0', 1, 0, 0, NULL, 0, 'https://github.com/xepan/xAccount.git', 1, NULL),
(83, 'Stock Mangement Application', '0', '0', 'xStore', 'application', 0, '0', 1, 0, 0, NULL, 0, 'https://github.com/xepan/xStore.git', 1, NULL),
(84, 'Purchase Management Application', '0', '0', 'xPurchase', 'application', 0, '0', 1, 1, 0, NULL, 0, 'https://github.com/xepan/xPurchase.git', 1, NULL),
(85, 'Dispatch Management Application', '0', '0', 'xDispatch', 'application', 0, '0', 1, 0, 0, NULL, 0, 'https://github.com/xepan/xDispatch.git', 1, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=442 ;

--
-- Dumping data for table `epan_components_plugins`
--

INSERT INTO `epan_components_plugins` (`id`, `component_id`, `name`, `event`, `params`, `is_system`) VALUES
(387, 78, 'epanDeleted', 'epan_before_delete', '$epan', 1),
(388, 78, 'epanCreated', 'epan_after_created', '$epan', 1),
(389, 80, 'epanDelete', 'epanDeleted', '#epan', 1),
(390, 81, 'epanDelete', 'epanDeleted', '$epan', 1),
(391, 82, 'epanDelete', 'epan_before_delete', '$epan', 1),
(392, 82, 'epanCreated', 'epan_after_created', '$epan', 1),
(393, 83, 'epanDelete', 'epanDeleted', '$epan', 1),
(395, 85, 'epanDelete', 'epanDeleted', '$epan', 1),
(420, 84, 'epanDelete', 'epanDeleted', '$epan', 1),
(424, 69, 'epanDeleted', 'epan_before_delete', '$epan', 1),
(425, 70, 'BeforeSaveIBlockExtract', 'epan-page-before-save', '$page', 0),
(426, 70, 'ImplementIntelligence', 'beforeTemplateInit', '$page', 0),
(427, 74, 'epanDelete', 'epanDeleted', '$epan', 1),
(428, 75, 'Newsletter Delete', 'xenq_n_subs_newletter_before_delete', '$newsletter', 0),
(429, 75, 'epanDelete', 'epan_before_delete', '$epan', 1),
(430, 75, 'epanCreated', 'epan_after_created', '$epan', 1),
(435, 51, 'RunServerSideComponent', 'content-fetched', '$page', 1),
(436, 51, 'RemoveContentEditable', 'content-fetched', '$page', 1),
(437, 51, 'RegisterEvent', 'register-event', '$events_obj', 0),
(438, 77, 'userRegistration', 'new_user_registered', '$user_model', 0),
(439, 77, 'Register Event', 'register-event', '$events_array', 0),
(440, 77, 'epanDeleted', 'epan_before_delete', '$epan', 1),
(441, 77, 'epanCreated', 'epan_after_created', '$epan', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1166 ;

--
-- Dumping data for table `epan_components_tools`
--

INSERT INTO `epan_components_tools` (`id`, `component_id`, `name`, `is_serverside`, `is_sortable`, `is_resizable`, `display_name`, `order`) VALUES
(1120, 69, 'CustomeForm', 1, 0, 0, '', 2),
(1121, 69, 'SubscriptionModule', 1, 0, 0, '', 3),
(1122, 69, 'EnquiryForm', 0, 0, 0, '', 1),
(1123, 69, 'unSubscribe', 1, 0, 0, 'Un Subscriber', 4),
(1124, 70, 'IntelligentBlock', 0, 1, 0, 'IBlock', 0),
(1125, 71, 'Marquee', 0, 1, 0, '', 1),
(1126, 71, 'PopupTooltip', 0, 0, 0, 'Popup Window', 2),
(1127, 72, 'ThumbnailSlider', 1, 0, 0, '', 0),
(1128, 72, 'AwesomeSlider', 1, 0, 0, '', 0),
(1129, 72, 'BootStrap Carousel', 0, 0, 0, '', 0),
(1130, 72, 'WaterWheelCarousel', 1, 0, 0, '', 0),
(1131, 72, 'TransformGallery', 1, 0, 0, '3D transforms', 0),
(1132, 73, 'xSVG', 0, 0, 0, '', 0),
(1133, 73, 'Image With Description 1', 0, 0, 0, '', 0),
(1134, 74, 'GoogleImageGallery', 1, 0, 0, '', 0),
(1135, 76, 'Bootstrap Menus', 0, 0, 0, '', 0),
(1147, 51, 'Template Content Region', 0, 1, 0, '', 0),
(1148, 51, 'User Panel', 1, 0, 0, '', 7),
(1149, 51, 'Html Block', 0, 0, 0, '', 6),
(1150, 51, 'Text', 0, 0, 0, '', 4),
(1151, 51, 'Title', 0, 0, 0, '', 3),
(1152, 51, 'Image', 0, 0, 0, '', 5),
(1153, 51, 'Container', 0, 1, 0, '', 1),
(1154, 51, 'Columns', 0, 0, 0, 'Columns', 2),
(1155, 77, 'Add Block', 1, 0, 0, '', 8),
(1156, 77, 'Member Account', 1, 0, 0, '', 7),
(1157, 77, 'Checkout', 1, 0, 0, '', 6),
(1158, 77, 'Search', 1, 0, 0, '', 5),
(1159, 77, 'xCart', 1, 0, 0, '', 4),
(1160, 77, 'Category', 1, 0, 0, '', 1),
(1161, 77, 'Item', 1, 0, 0, '', 2),
(1162, 77, 'ItemDetail', 1, 0, 0, '', 3),
(1163, 77, 'Designer', 1, 0, 0, 'Designer', 9),
(1164, 77, 'ItemImages', 1, 0, 0, 'Item Images', 0),
(1165, 77, 'Blog', 1, 0, 0, 'Blog', 0);

-- --------------------------------------------------------

--
-- Table structure for table `epan_guide`
--

CREATE TABLE IF NOT EXISTS `epan_guide` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `epan_guide_steps`
--

CREATE TABLE IF NOT EXISTS `epan_guide_steps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guide_id` int(11) DEFAULT NULL,
  `selector` varchar(255) DEFAULT NULL,
  `intro` text,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_guide_id` (`guide_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_component_id` (`component_id`)
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
-- Table structure for table `epan_layout`
--

CREATE TABLE IF NOT EXISTS `epan_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `content` text,
  `is_user_created` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  KEY `fk_template_id` (`template_id`),
  KEY `fk_parent_page_id` (`parent_page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan_page`
--

INSERT INTO `epan_page` (`id`, `parent_page_id`, `name`, `menu_caption`, `epan_id`, `is_template`, `title`, `description`, `keywords`, `content`, `body_attributes`, `created_on`, `updated_on`, `access_level`, `template_id`) VALUES
(1, NULL, 'home', 'Home', 1, 0, 'XTPL :: PHP development, Web, Online, Android, development company, xepan, cms developer, drag and drop website builder developer, ERP developer, Developers tools developer, Artificial Intelligent application/software developer.', 'Xavoc is a world class company providing cutting edge technology to next generation, Xavoc works in developing new tools for web and mobile like Artificial Intelligent website builder or cms like xEpan. Developer of xCIDeveloper, A tool to let you write Joomla components in CodeIgniter. Developer of xJDataMapper, a ruby style ORM for JAVA. Contributor in spreading agiletoolkit, a great PHP framework. In Short, Not just another IT Company in town.', 'PHP development, Web, Online, Android, development company, xepan, cms developer, drag and drop website builder developer, ERP developer, Developers tools developer, Artificial Intelligent application/software developer.', '', 'cursor: default; overflow: hidden;; cursor: default; overflow: auto; background-image: none;', NULL, '2015-08-11 11:40:28', '0', 1);

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
  PRIMARY KEY (`id`),
  KEY `fk_epan_page_id` (`epan_page_id`)
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
(1, 1, 'default', 'cursor: default; overflow: hidden;', '<div id="78b495fd-6ba5-4a73-97b0-2c7ca59b4e12" component_namespace="baseElements" component_type="Container" class="epan-container  epan-sortable-component epan-component  ui-sortable" style=" "> 	 <nav id="c074b09e-5613-4d95-b711-6603d6d27606" component_namespace="xMenus" component_type="BootstrapMenus" class="navbar navbar-default epan-component" style=" " role="navigation"> 		<!-- Brand and toggle get grouped for better mobile display --> 		<div class="navbar-header"> 			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse"> 				<span class="sr-only">Toggle navigation</span> 				<span class="icon-bar"></span> 				<span class="icon-bar"></span> 				<span class="icon-bar"></span> 			</button> 			<div class="epan-component epan-sortable-component editor navbar-brand ui-sortable editor-attached" component_type="Container" component_namespace="baseElements" contenteditable="true">Xavoc Technocrats Pvt. Ltd (5.0)<br></div> 		</div> 	 		<!-- Collect the nav links, forms, and other content for toggling --> 		<div class="collapse navbar-collapse navbar-ex1-collapse"> 			<ul id="xMenu-boostrap-ul" class="nav navbar-nav ui-sortable"><li><a href="index.php?subpage=home">Home</a></li></ul> 			<div style="" class="epan-sortable-component epan-component navbar-form navbar-left ui-sortable" component_type="Container" component_namespace="baseElements"> 				 			</div> 			 		</div><!-- /.navbar-collapse --> 		 </nav><div id="4e8497e5-4537-43b8-8b67-1bb6b0a33096" component_namespace="baseElements" component_type="TemplateContentRegion" class="epan-sortable-component epan-component  ui-sortable" style="" contenteditable="false">~~Content~~</div><div id="c77477ec-160c-446a-adad-4983c09d515e" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style=" "> 	 <div id="957c9311-1232-4eb5-e7b4-5928012a5709" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable" span="4" style=" "> 	 <div data-extra-classes="atk-swatch-red text-center atk-box" id="01c79907-f1c5-4099-e2fe-4c39dd0694a3" component_namespace="baseElements" component_type="Title" class="epan-component atk-swatch-red text-center atk-box" style=" "> 	<h3 class="editor editor-attached" contenteditable="true">xEpan</h3> </div></div><div id="f73b23b8-5cc0-4364-f516-2d7326b5f9e1" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable" span="4" style=" "> 	 <div data-extra-classes="atk-swatch-green text-center atk-box" id="7ffb30cf-b8fd-44a9-d8a3-f290a9d4a597" component_namespace="baseElements" component_type="Title" class="epan-component atk-swatch-green text-center atk-box" style=" "> 	<h3 class="editor editor-attached" contenteditable="true">xCIDeveloper</h3> </div></div><div id="5cdc46ad-7451-4e22-8438-21453345bbcb" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable" span="4" style=" "> 	 <div data-extra-classes="atk-swatch-blue text-center atk-box" id="5dc75b65-f1a8-43a1-e936-e9329ac2d12a" component_namespace="baseElements" component_type="Title" class="epan-component atk-swatch-blue text-center atk-box" style=" "> 	<h3 class="editor editor-attached" contenteditable="true">Agiletoolkit</h3> </div></div></div></div>', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `filestore_file`
--

CREATE TABLE IF NOT EXISTS `filestore_file` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filestore_type_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'File type',
  `filestore_volume_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Volume',
  `original_filename` varchar(255) NOT NULL DEFAULT '' COMMENT 'Original Name',
  `filename` varchar(255) NOT NULL DEFAULT '' COMMENT 'Internal Name',
  `filesize` int(11) NOT NULL DEFAULT '0' COMMENT 'File size',
  `deleted` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Deleted file',
  PRIMARY KEY (`id`),
  KEY `fk_filestore_file_filestore_type1_idx` (`filestore_type_id`),
  KEY `fk_filestore_file_filestore_volume1_idx` (`filestore_volume_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `filestore_image`
--

CREATE TABLE IF NOT EXISTS `filestore_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `original_file_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Original File',
  `thumb_file_id` int(10) unsigned DEFAULT NULL COMMENT 'Thumbnail file',
  PRIMARY KEY (`id`),
  KEY `fk_filestore_image_filestore_file1_idx` (`original_file_id`),
  KEY `fk_filestore_image_filestore_file2_idx` (`thumb_file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `filestore_type`
--

CREATE TABLE IF NOT EXISTS `filestore_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT 'Name',
  `mime_type` varchar(64) NOT NULL DEFAULT '' COMMENT 'MIME type',
  `extension` varchar(5) NOT NULL DEFAULT '' COMMENT 'Filename extension',
  `allow` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `filestore_type`
--

INSERT INTO `filestore_type` (`id`, `name`, `mime_type`, `extension`, `allow`) VALUES
(1, 'png', 'image/png', 'png', 1),
(2, 'jpeg', 'image/jpeg', 'jpg', 1),
(3, 'gif', 'image/gif', 'gif', 1),
(4, 'pdf', 'application/pdf', 'pdf', 1),
(5, 'doc', 'application/doc', 'doc', 1),
(6, 'xls', 'application/xls', 'xls', 1),
(7, 'txt', 'text/plain', 'txt', 1),
(8, 'application/zip', 'application/zip', '', 1),
(9, 'text/html', 'text/html', '', 1),
(10, 'application/msword', 'application/msword', '', 1),
(11, 'application/vnd.ms-excel', 'application/vnd.ms-excel', '', 1),
(12, 'text/rtf', 'text/rtf', '', 1),
(13, 'application/vnd.openxmlformats-officedocument.wordprocessingml.d', 'application/vnd.openxmlformats-officedocument.wordprocessingml.d', '', 1),
(14, 'application/vnd.oasis.opendocument.spreadsheet', 'application/vnd.oasis.opendocument.spreadsheet', '', 1),
(15, 'application/vnd.ms-office', 'application/vnd.ms-office', '', 1),
(16, 'application/x-rar', 'application/x-rar', '', 1),
(17, 'application/vnd.openxmlformats-officedocument.wordprocessingml.d', 'application/vnd.openxmlformats-officedocument.wordprocessingml.d', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `filestore_volume`
--

CREATE TABLE IF NOT EXISTS `filestore_volume` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT 'Volume name',
  `dirname` varchar(128) NOT NULL DEFAULT '' COMMENT 'Folder name',
  `total_space` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Total space (not implemented)',
  `used_space` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Used space (not implemented)',
  `stored_files_cnt` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Approximate count of stored files',
  `enabled` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Volume enabled?',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `filestore_volume`
--

INSERT INTO `filestore_volume` (`id`, `name`, `dirname`, `total_space`, `used_space`, `stored_files_cnt`, `enabled`) VALUES
(1, 'upload', 'upload', 1000000000, 0, 67, 1);

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_employee_id` (`employee_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `slideshows_thumbnailslidergallery`
--

CREATE TABLE IF NOT EXISTS `slideshows_thumbnailslidergallery` (
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

-- --------------------------------------------------------

--
-- Table structure for table `slideshows_thumbnailsliderimages`
--

CREATE TABLE IF NOT EXISTS `slideshows_thumbnailsliderimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `tooltip` text,
  `order_no` int(11) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_id` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `slideshows_transformgallery`
--

CREATE TABLE IF NOT EXISTS `slideshows_transformgallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `autoplay` tinyint(1) DEFAULT NULL,
  `interval` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `slideshows_transformgalleryimages`
--

CREATE TABLE IF NOT EXISTS `slideshows_transformgalleryimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_id` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `slideshows_waterwheelgallery`
--

CREATE TABLE IF NOT EXISTS `slideshows_waterwheelgallery` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `slideshows_waterwheelimages`
--

CREATE TABLE IF NOT EXISTS `slideshows_waterwheelimages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text,
  `is_publish` tinyint(1) DEFAULT NULL,
  `start_item` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_id` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `last_login_date` datetime DEFAULT NULL,
  `user_management` tinyint(1) DEFAULT NULL,
  `general_settings` tinyint(1) DEFAULT NULL,
  `application_management` tinyint(1) DEFAULT NULL,
  `website_designing` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=88 ;

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
-- Table structure for table `user_custom_field_value`
--

CREATE TABLE IF NOT EXISTS `user_custom_field_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `usercustomefield_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_usercustomefield_id` (`usercustomefield_id`),
  KEY `fk_users_id` (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xaccount_account`
--

CREATE TABLE IF NOT EXISTS `xaccount_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `account_type` varchar(255) DEFAULT NULL,
  `AccountDisplayName` varchar(255) DEFAULT NULL,
  `OpeningBalanceDr` decimal(14,2) DEFAULT NULL,
  `OpeningBalanceCr` decimal(14,2) DEFAULT NULL,
  `affectsBalanceSheet` tinyint(1) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `out_source_party_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `CurrentBalanceDr` decimal(14,2) DEFAULT NULL,
  `CurrentBalanceCr` decimal(14,2) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_supplier_id` (`supplier_id`) USING BTREE,
  KEY `fk_out_source_party_id` (`out_source_party_id`) USING BTREE,
  KEY `fk_group_id` (`group_id`) USING BTREE,
  KEY `fk_employee_id` (`employee_id`) USING BTREE,
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_customer_id` (`customer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Table structure for table `xaccount_balance_sheet`
--

CREATE TABLE IF NOT EXISTS `xaccount_balance_sheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `positive_side` varchar(255) DEFAULT NULL,
  `is_pandl` tinyint(1) DEFAULT NULL,
  `show_sub` varchar(255) DEFAULT NULL,
  `subtract_from` varchar(255) DEFAULT NULL,
  `order` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `xaccount_balance_sheet`
--

INSERT INTO `xaccount_balance_sheet` (`id`, `name`, `created_at`, `positive_side`, `is_pandl`, `show_sub`, `subtract_from`, `order`, `related_document_id`, `related_root_document_name`, `related_document_name`, `updated_at`, `created_by_id`, `epan_id`) VALUES
(1, 'Deposits - Liabilities', '0000-00-00 00:00:00', '', NULL, '', '', '', '', '', '', '0000-00-00 00:00:00', NULL, 1),
(2, 'Current Assets', '0000-00-00 00:00:00', '', NULL, '', '', '', '', '', '', '0000-00-00 00:00:00', NULL, 1),
(4, 'Expenses', '0000-00-00 00:00:00', '', NULL, '', '', '', '', '', '', '0000-00-00 00:00:00', NULL, 1),
(5, 'Income', '0000-00-00 00:00:00', '', NULL, '', '', '', '', '', '', '0000-00-00 00:00:00', NULL, 1),
(6, 'Suspence Account', '0000-00-00 00:00:00', '', NULL, '', '', '', '', '', '', '0000-00-00 00:00:00', NULL, 1),
(7, 'Fixed Assets', '0000-00-00 00:00:00', '', NULL, '', '', '', '', '', '', '0000-00-00 00:00:00', NULL, 1),
(8, 'Branch/Divisions', '0000-00-00 00:00:00', '', NULL, '', '', '', '', '', '', '0000-00-00 00:00:00', NULL, 1),
(9, 'Current Liabilities', '0000-00-00 00:00:00', '', NULL, '', '', '', '', '', '', '0000-00-00 00:00:00', NULL, 1),
(10, 'Duties & Taxes', '0000-00-00 00:00:00', '', NULL, '', '', '', '', '', '', '0000-00-00 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xaccount_group`
--

CREATE TABLE IF NOT EXISTS `xaccount_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `balance_sheet_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_balance_sheet_id` (`balance_sheet_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=8 ;

--
-- Dumping data for table `xaccount_group`
--

INSERT INTO `xaccount_group` (`id`, `name`, `created_at`, `balance_sheet_id`, `epan_id`) VALUES
(2, 'Direct Income', '2015-04-10', 5, 1),
(3, 'Duties & Taxes', '2015-04-10', 10, 1),
(4, 'Direct Expenses', '2015-04-10', 4, 1),
(5, 'Sundry Debtor', '2015-04-10', 2, 1),
(6, 'Cash Account', '2015-04-15', 2, 1),
(7, 'Bank Accounts', '2015-04-15', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `xaccount_transaction`
--

CREATE TABLE IF NOT EXISTS `xaccount_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `transaction_type_id` int(11) DEFAULT NULL,
  `Narration` text,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_transaction_type_id` (`transaction_type_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Table structure for table `xaccount_transaction_row`
--

CREATE TABLE IF NOT EXISTS `xaccount_transaction_row` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `amountDr` decimal(14,2) DEFAULT NULL,
  `amountCr` decimal(14,2) DEFAULT NULL,
  `side` varchar(255) DEFAULT NULL,
  `accounts_in_side` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transaction_id` (`transaction_id`) USING BTREE,
  KEY `fk_account_id` (`account_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xaccount_transaction_types`
--

CREATE TABLE IF NOT EXISTS `xaccount_transaction_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `FromAC` varchar(255) DEFAULT NULL,
  `ToAC` varchar(255) DEFAULT NULL,
  `Default_Narration` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=9 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=296 ;

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
-- Table structure for table `xai_human`
--

CREATE TABLE IF NOT EXISTS `xai_human` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=56 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=50 ;

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
(2, 'Top Landing Pages', 1, 1, '', 'grid', 1, '10', 'Landing Pages', '', 5, 'WEIGHTSUM', 2, 3, 2, 2, 1, 2, 2),
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
  `email_to` varchar(255) DEFAULT NULL,
  `sms_to` varchar(255) DEFAULT NULL,
  `notify_via_email` tinyint(1) DEFAULT NULL,
  `notify_via_sms` tinyint(1) DEFAULT NULL,
  `attachment_id` int(10) unsigned DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_attachment_id` (`attachment_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xcrm_emails`
--

CREATE TABLE IF NOT EXISTS `xcrm_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `from_id` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `to_id` varchar(255) DEFAULT NULL,
  `cc` text,
  `bcc` text,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `from_email` varchar(255) DEFAULT NULL,
  `to_email` varchar(255) DEFAULT NULL,
  `read_by_employee_id` int(11) DEFAULT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `attachments` text,
  `direction` varchar(255) DEFAULT NULL,
  `keep_unread` tinyint(1) DEFAULT NULL,
  `task_status` varchar(255) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_read_by_employee_id` (`read_by_employee_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xcrm_smses`
--

CREATE TABLE IF NOT EXISTS `xcrm_smses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `name` text,
  `message` varchar(255) DEFAULT NULL,
  `return` text,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xcrm_tickets`
--

CREATE TABLE IF NOT EXISTS `xcrm_tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `uid` varchar(255) DEFAULT NULL,
  `from` varchar(255) DEFAULT NULL,
  `from_id` varchar(255) DEFAULT NULL,
  `from_email` varchar(255) DEFAULT NULL,
  `from_name` varchar(255) DEFAULT NULL,
  `to` varchar(255) DEFAULT NULL,
  `to_id` varchar(255) DEFAULT NULL,
  `to_email` varchar(255) DEFAULT NULL,
  `cc` text,
  `bcc` text,
  `subject` varchar(255) DEFAULT NULL,
  `message` text,
  `priority` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_customer_id` (`customer_id`),
  KEY `fk_order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `narration` text,
  `updated_at` datetime DEFAULT NULL,
  `shipping_via` text,
  `docket_no` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_orderitem_id` (`orderitem_id`) USING BTREE,
  KEY `fk_to_department_id` (`to_department_id`) USING BTREE,
  KEY `fk_from_department_id` (`from_department_id`) USING BTREE,
  KEY `fk_dispatch_to_warehouse_id` (`dispatch_to_warehouse_id`) USING BTREE,
  KEY `fk_orderitem_departmental_status_id` (`orderitem_departmental_status_id`) USING BTREE,
  KEY `fk_order_id` (`order_id`) USING BTREE,
  KEY `fk_to_memberdetails_id` (`to_memberdetails_id`) USING BTREE,
  KEY `fk_warehouse_id` (`warehouse_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xdispatch_delivery_note_items`
--

CREATE TABLE IF NOT EXISTS `xdispatch_delivery_note_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `orderitem_id` int(11) DEFAULT NULL,
  `delivery_note_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_orderitem_id` (`orderitem_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_delivery_note_id` (`delivery_note_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_orderitem_id` (`orderitem_id`) USING BTREE,
  KEY `fk_to_department_id` (`to_department_id`) USING BTREE,
  KEY `fk_from_department_id` (`from_department_id`) USING BTREE,
  KEY `fk_dispatch_to_warehouse_id` (`dispatch_to_warehouse_id`) USING BTREE,
  KEY `fk_orderitem_departmental_status_id` (`orderitem_departmental_status_id`) USING BTREE,
  KEY `fk_order_id` (`order_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

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
  `status` varchar(255) DEFAULT NULL,
  `deliverynote_id` int(11) DEFAULT NULL,
  `custom_fields` varchar(255) DEFAULT NULL,
  `orderitem_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_dispatch_request_id` (`dispatch_request_id`) USING BTREE,
  KEY `fk_item_id` (`item_id`) USING BTREE,
  KEY `fk_deliverynote_id` (`deliverynote_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_orderitem_id` (`orderitem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_config`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `show_all_newsletters` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_custome_customfields`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_custome_customfields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `forms_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `set_value` varchar(255) DEFAULT NULL,
  `mandatory` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_forms_id` (`forms_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_customformentry`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_customformentry` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_customform_forms`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_customform_forms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `receipent_email_id` varchar(255) DEFAULT NULL,
  `receive_mail` tinyint(1) DEFAULT NULL,
  `button_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_emailjobs`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_emailjobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsletter_id` int(11) DEFAULT NULL,
  `job_posted_at` datetime DEFAULT NULL,
  `processed_on` datetime DEFAULT NULL,
  `process_via` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_newsletter_id` (`newsletter_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_emailqueue`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_emailqueue` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_hosts_touched`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_hosts_touched` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_massemailconfiguration`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_massemailconfiguration` (
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
-- Table structure for table `xenquirynsubscription_newsletter`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_newsletter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `matter` text,
  `created_at` datetime DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `created_by_app` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_category_id` (`category_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_newslettercategory`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_newslettercategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_newsletter_templates`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_newsletter_templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `content` text,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_subscatass`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_subscatass` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_subscription`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_subscription` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `from_app` varchar(255) DEFAULT NULL,
  `from_id` int(11) DEFAULT NULL,
  `is_ok` tinyint(1) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `lead_type` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `organization_name` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `remark` text,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`) USING BTREE,
  KEY `from_id` (`from_id`) USING BTREE,
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=601 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_subscription_categories`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_subscription_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `xenquirynsubscription_subscription_config`
--

CREATE TABLE IF NOT EXISTS `xenquirynsubscription_subscription_config` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xepan_generic_documents`
--

CREATE TABLE IF NOT EXISTS `xepan_generic_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `content` text,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `generic_doc_category_id` int(11) DEFAULT NULL,
  `is_template` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_generic_doc_category_id` (`generic_doc_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xepan_generic_documents_category`
--

CREATE TABLE IF NOT EXISTS `xepan_generic_documents_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_branch_id` (`branch_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `xhr_departments`
--

INSERT INTO `xhr_departments` (`id`, `branch_id`, `name`, `proceed_after_previous_department`, `internal_approved`, `acl_approved`, `jobcard_assign_required`, `is_production_department`, `related_application_namespace`, `is_active`, `is_outsourced`, `is_system`, `jobcard_document`, `production_level`, `epan_id`) VALUES
(1, NULL, 'Company', NULL, NULL, NULL, NULL, 0, '', 1, NULL, 1, 'xProduction\\Model_JobCard', NULL, 1),
(2, NULL, 'HR', NULL, NULL, NULL, NULL, 0, 'xHR', 1, NULL, 1, 'xProduction\\Model_JobCard', NULL, 1),
(3, NULL, 'Marketing', NULL, NULL, NULL, NULL, 0, 'xMarketingCampaign', 1, NULL, 1, 'xProduction\\Model_JobCard', NULL, 1),
(4, NULL, 'Sales', NULL, NULL, NULL, NULL, 0, 'xShop', 1, NULL, 1, 'xProduction\\Model_JobCard', NULL, 1),
(5, NULL, 'Purchase', NULL, NULL, NULL, NULL, 1, 'xStore', 1, NULL, 1, 'xStore\\Model_MaterialRequest', -2, 1),
(7, NULL, 'Accounts', NULL, NULL, NULL, NULL, 0, 'xAccount', 1, NULL, 1, 'xProduction\\Model_JobCard', NULL, 1),
(8, NULL, 'CRM', NULL, NULL, NULL, NULL, 0, 'xCRM', 1, NULL, 1, 'xProduction\\Model_JobCard', NULL, 1),
(9, NULL, 'Store', NULL, NULL, NULL, NULL, 1, 'xStore', 1, NULL, 1, 'xStore\\Model_MaterialRequest', -1, 1),
(12, NULL, 'Dispatch And Delivery', NULL, NULL, NULL, NULL, 1, 'xDispatch', 1, NULL, 1, 'xDispatch\\Model_DispatchRequest', 100000, 1);

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
  `can_forcedelete` varchar(255) DEFAULT NULL,
  `can_create_activity` tinyint(1) DEFAULT NULL,
  `can_create_ticket` tinyint(1) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_document_id` (`document_id`),
  KEY `fk_post_id` (`post_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xhr_documents`
--

CREATE TABLE IF NOT EXISTS `xhr_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=177 ;

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
  `empolyee_image_id` int(10) unsigned DEFAULT NULL,
  `confirmation_date` date DEFAULT NULL,
  `pre_resignation_letter_date` date DEFAULT NULL,
  `pre_relieving_date` date DEFAULT NULL,
  `pre_reason_of_resignation` text,
  `is_active` tinyint(1) DEFAULT NULL,
  `seen_till` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_id` (`post_id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_empolyee_image_id` (`empolyee_image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `xhr_employee_attendence`
--

CREATE TABLE IF NOT EXISTS `xhr_employee_attendence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xhr_employee_leave`
--

CREATE TABLE IF NOT EXISTS `xhr_employee_leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `leave_type_id` int(11) DEFAULT NULL,
  `from_date` datetime DEFAULT NULL,
  `to_date` datetime DEFAULT NULL,
  `reason` text,
  `half_day` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_employee_id` (`employee_id`),
  KEY `fk_leave_type_id` (`leave_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xhr_holiday_blocks`
--

CREATE TABLE IF NOT EXISTS `xhr_holiday_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xhr_leave_types`
--

CREATE TABLE IF NOT EXISTS `xhr_leave_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `max_day_allow` int(11) DEFAULT NULL,
  `is_carry_forward` tinyint(1) DEFAULT NULL,
  `is_lwp` tinyint(1) DEFAULT NULL,
  `allow_negative_balance` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xhr_official_emails`
--

CREATE TABLE IF NOT EXISTS `xhr_official_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `email_transport` varchar(255) DEFAULT NULL,
  `encryption` varchar(255) DEFAULT NULL,
  `email_host` varchar(255) DEFAULT NULL,
  `email_port` varchar(255) DEFAULT NULL,
  `email_username` varchar(255) DEFAULT NULL,
  `email_password` varchar(255) DEFAULT NULL,
  `imap_email_host` varchar(255) DEFAULT NULL,
  `imap_email_port` varchar(255) DEFAULT NULL,
  `imap_email_username` varchar(255) DEFAULT NULL,
  `imap_email_password` varchar(255) DEFAULT NULL,
  `imap_flags` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `is_support_email` tinyint(1) DEFAULT NULL,
  `auto_reply` tinyint(1) DEFAULT NULL,
  `email_subject` varchar(255) DEFAULT NULL,
  `email_body` text,
  `footer` text,
  `denied_email_subject` varchar(255) DEFAULT NULL,
  `denied_email_body` text,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_employee_id` (`employee_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_parent_post_id` (`parent_post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `xhr_posts`
--

INSERT INTO `xhr_posts` (`id`, `department_id`, `name`, `is_active`, `parent_post_id`, `can_create_team`, `epan_id`) VALUES
(1, 1, 'Director', 1, NULL, 1, 1);

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_employee_id` (`employee_id`),
  KEY `fk_salary_type_id` (`salary_type_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`)
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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_post_id` (`post_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xhr_salary_types`
--

CREATE TABLE IF NOT EXISTS `xhr_salary_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_salary_template_id` (`salary_template_id`),
  KEY `fk_salary_type_id` (`salary_type_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ximagegallery_gallery`
--

CREATE TABLE IF NOT EXISTS `ximagegallery_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ximagegallery_images`
--

CREATE TABLE IF NOT EXISTS `ximagegallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `name` text,
  `is_publish` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_gallery_id` (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_campaign_id` (`campaign_id`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_data_grabber`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_data_grabber` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_data_search_phrase`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_data_search_phrase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_grabber_id` int(11) DEFAULT NULL,
  `subscription_category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `content_provided` varchar(255) DEFAULT NULL,
  `max_record_visit` varchar(255) DEFAULT NULL,
  `max_domain_depth` varchar(255) DEFAULT NULL,
  `max_page_depth` varchar(255) DEFAULT NULL,
  `page_parameter_start_value` varchar(255) DEFAULT NULL,
  `page_parameter_max_value` varchar(255) DEFAULT NULL,
  `last_page_checked_at` datetime DEFAULT NULL,
  `is_grabbed` tinyint(1) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_data_grabber_id` (`data_grabber_id`),
  KEY `fk_subscription_category_id` (`subscription_category_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_facebookconfig`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_facebookconfig` (
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
-- Table structure for table `xmarketingcampaign_googlebloggerconfig`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_googlebloggerconfig` (
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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xmarketingcampaign_googlebloggerconfig`
--

INSERT INTO `xmarketingcampaign_googlebloggerconfig` (`id`, `name`, `userid`, `userid_returned`, `appId`, `secret`, `access_token`, `is_access_token_valid`, `refresh_token`, `blogid`, `access_token_secret`, `is_active`, `epan_id`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, 1, 1);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_lead_categories`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_lead_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_linkedinconfig`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_linkedinconfig` (
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
-- Table structure for table `xmarketingcampaign_socialconfig`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_socialconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `social_app` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `appId` text,
  `secret` text,
  `post_in_groups` tinyint(1) DEFAULT NULL,
  `filter_repeated_posts` tinyint(1) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_socialpostings`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_socialpostings` (
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
-- Table structure for table `xmarketingcampaign_socialpostings_activities`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_socialpostings_activities` (
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
-- Table structure for table `xmarketingcampaign_socialposts`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_socialposts` (
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

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_socialpost_categories`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_socialpost_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `xmarketingcampaign_socialusers`
--

CREATE TABLE IF NOT EXISTS `xmarketingcampaign_socialusers` (
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orderitem_id` (`orderitem_id`),
  KEY `fk_orderitem_departmental_status_id` (`orderitem_departmental_status_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_from_department_id` (`from_department_id`),
  KEY `fk_to_department_id` (`to_department_id`) USING BTREE,
  KEY `fk_dispatch_to_warehouse_id` (`dispatch_to_warehouse_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

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
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_jobcard_id` (`jobcard_id`) USING BTREE,
  KEY `fk_orderitem_id` (`orderitem_id`) USING BTREE,
  KEY `fk_department_id` (`department_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_jobcard_id` (`jobcard_id`) USING BTREE,
  KEY `fk_orderitem_id` (`orderitem_id`) USING BTREE,
  KEY `fk_department_id` (`department_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_outsource_party_dept_associations`
--

CREATE TABLE IF NOT EXISTS `xproduction_outsource_party_dept_associations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `out_source_party_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_out_source_party_id` (`out_source_party_id`),
  KEY `fk_epan_id` (`epan_id`)
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
  `contact_no` varchar(255) DEFAULT NULL,
  `address` text,
  `epan_id` int(11) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `email_id` varchar(255) DEFAULT NULL,
  `bank_detail` text,
  `pan_it_no` varchar(255) DEFAULT NULL,
  `tin_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_tasks`
--

CREATE TABLE IF NOT EXISTS `xproduction_tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
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
  `subject` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_team_id` (`team_id`),
  KEY `fk_employee_id` (`employee_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `xproduction_teams`
--

CREATE TABLE IF NOT EXISTS `xproduction_teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_from_department_id` (`from_department_id`) USING BTREE,
  KEY `fk_order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_from_department_id` (`from_department_id`) USING BTREE,
  KEY `fk_order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  KEY `fk_purchase_material_request_id` (`purchase_material_request_id`) USING BTREE,
  KEY `fk_item_id` (`item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  KEY `fk_purchase_material_request_id` (`purchase_material_request_id`) USING BTREE,
  KEY `fk_item_id` (`item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  `supplier_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `priority_id` int(11) DEFAULT NULL,
  `order_summary` text,
  `order_date` datetime DEFAULT NULL,
  `total_amount` decimal(14,2) DEFAULT NULL,
  `tax` decimal(14,2) DEFAULT NULL,
  `net_amount` decimal(14,2) DEFAULT NULL,
  `delivery_to` text,
  `epan_id` int(11) DEFAULT NULL,
  `termsandcondition_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_xpurchase_supplier_id` (`supplier_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_priority_id` (`priority_id`),
  KEY `fk_termsandcondition_id` (`termsandcondition_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xpurchase_purchase_order_item`
--

CREATE TABLE IF NOT EXISTS `xpurchase_purchase_order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `custom_fields` text,
  `po_id` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `narration` text,
  `rate` decimal(14,2) DEFAULT NULL,
  `amount` decimal(14,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `received_qty` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_po_id` (`po_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_invoice_id` (`invoice_id`)
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
  `address` text,
  `city` varchar(255) DEFAULT NULL,
  `contact_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `fax_number` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `accounts_person_name` varchar(255) DEFAULT NULL,
  `contact_person_name` varchar(255) DEFAULT NULL,
  `tin_no` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `logo_url_id` int(10) unsigned DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_affiliatetype_id` (`affiliatetype_id`),
  KEY `fk_application_id` (`application_id`),
  KEY `fk_logo_url_id` (`logo_url_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_affiliatetype`
--

CREATE TABLE IF NOT EXISTS `xshop_affiliatetype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_application_id` (`application_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_block_id` (`block_id`),
  KEY `fk_epan_id` (`epan_id`)
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
  `image_url_id` int(10) unsigned DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_application_id` (`application_id`),
  KEY `fk_parent_id` (`parent_id`),
  KEY `fk_image_url_id` (`image_url_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_categorygroup`
--

CREATE TABLE IF NOT EXISTS `xshop_categorygroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  `purchase_order_detail_email_subject` varchar(255) DEFAULT NULL,
  `purchase_order_detail_email_body` text,
  `quotation_email_subject` varchar(255) DEFAULT NULL,
  `quotation_email_body` text,
  `invoice_email_subject` varchar(255) DEFAULT NULL,
  `invoice_email_body` text,
  `purchase_invoice_email_subject` varchar(255) DEFAULT NULL,
  `purchase_invoice_email_body` text,
  `cash_voucher_email_subject` varchar(255) DEFAULT NULL,
  `cash_voucher_email_body` text,
  `quotation_starting_number` varchar(255) DEFAULT NULL,
  `sale_order_starting_number` varchar(255) DEFAULT NULL,
  `purchase_order_starting_number` varchar(255) DEFAULT NULL,
  `sale_invoice_starting_number` varchar(255) DEFAULT NULL,
  `purchase_invoice_starting_number` varchar(255) DEFAULT NULL,
  `outsource_email_subject` varchar(255) DEFAULT NULL,
  `outsource_email_body` text,
  `is_round_amount_calculation` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_application_id` (`application_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_currency`
--

CREATE TABLE IF NOT EXISTS `xshop_currency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `Value` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_customfield_id` (`customfield_id`),
  KEY `fk_customefieldvalue_id` (`customefieldvalue_id`),
  KEY `fk_epan_id` (`epan_id`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_itemcustomfiledasso_id` (`itemcustomfiledasso_id`),
  KEY `fk_customfield_id` (`customfield_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

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
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_created_by_id` (`created_by_id`)
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
  KEY `fk_epan_id` (`epan_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_image_library_category`
--

CREATE TABLE IF NOT EXISTS `xshop_image_library_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_invoices`
--

CREATE TABLE IF NOT EXISTS `xshop_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `sales_order_id` int(11) DEFAULT NULL,
  `po_id` int(11) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `discount` decimal(14,2) DEFAULT NULL,
  `tax` decimal(14,2) DEFAULT NULL,
  `net_amount` decimal(14,2) DEFAULT NULL,
  `billing_address` text,
  `orderitem_id` int(11) DEFAULT NULL,
  `name` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `total_amount` decimal(14,2) DEFAULT NULL,
  `transaction_reference` text,
  `transaction_response_data` text,
  `termsandcondition_id` int(11) DEFAULT NULL,
  `gross_amount` decimal(14,2) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `shipping_charge` decimal(14,2) DEFAULT NULL,
  `narration` text,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_po_id` (`po_id`) USING BTREE,
  KEY `fk_sales_order_id` (`sales_order_id`) USING BTREE,
  KEY `fk_orderitem_id` (`orderitem_id`) USING BTREE,
  KEY `fk_customer_id` (`customer_id`) USING BTREE,
  KEY `fk_termsandcondition_id` (`termsandcondition_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_supplier_id` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_invoice_item`
--

CREATE TABLE IF NOT EXISTS `xshop_invoice_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `narration` text,
  `custom_fields` text,
  `status` varchar(255) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `rate` decimal(14,2) DEFAULT NULL,
  `orderitem_id` int(11) DEFAULT NULL,
  `amount` decimal(14,2) DEFAULT NULL,
  `apply_tax` tinyint(1) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_invoice_id` (`invoice_id`) USING BTREE,
  KEY `fk_item_id` (`item_id`) USING BTREE,
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_orderitem_id` (`orderitem_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_tax_id` (`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  `offer_image_id` int(10) unsigned DEFAULT NULL,
  `application_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_offer_image_id` (`offer_image_id`),
  KEY `fk_application_id` (`application_id`),
  KEY `fk_epan_id` (`epan_id`)
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
  `original_price` decimal(14,2) DEFAULT NULL,
  `sale_price` decimal(14,2) DEFAULT NULL,
  `rank_weight` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
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
  `is_fixed_asset` tinyint(1) DEFAULT NULL,
  `negative_qty_allowed` varchar(255) DEFAULT NULL,
  `is_visible_sold` tinyint(1) DEFAULT NULL,
  `offer_id` int(11) DEFAULT NULL,
  `offer_position` varchar(255) DEFAULT NULL,
  `enquiry_send_to_admin` tinyint(1) DEFAULT NULL,
  `watermark_image_id` int(10) unsigned DEFAULT NULL,
  `watermark_text` text,
  `watermark_position` varchar(255) DEFAULT NULL,
  `watermark_opacity` varchar(255) DEFAULT NULL,
  `qty_from_set_only` tinyint(1) DEFAULT NULL,
  `custom_button_label` varchar(255) DEFAULT NULL,
  `is_servicable` tinyint(1) DEFAULT NULL,
  `is_purchasable` tinyint(1) DEFAULT NULL,
  `mantain_inventory` tinyint(1) DEFAULT NULL,
  `website_display` tinyint(1) DEFAULT NULL,
  `allow_negative_stock` tinyint(1) DEFAULT NULL,
  `is_productionable` tinyint(1) DEFAULT NULL,
  `warrenty_days` int(11) DEFAULT NULL,
  `terms_condition` text,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `is_blog` tinyint(1) DEFAULT NULL,
  `duplicate_from_item_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_application_id` (`application_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_designer_id` (`designer_id`),
  KEY `fk_offer_id` (`offer_id`),
  KEY `fk_watermark_image_id` (`watermark_image_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_itemtaxasso`
--

CREATE TABLE IF NOT EXISTS `xshop_itemtaxasso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_tax_id` (`tax_id`) USING BTREE,
  KEY `fk_item_id` (`item_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_affiliate_id` (`affiliate_id`),
  KEY `fk_affiliatetype_id` (`affiliatetype_id`),
  KEY `fk_epan_id` (`epan_id`)
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
  `custom_fields` text,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_composition_item_id` (`composition_item_id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_custom_rates`
--

CREATE TABLE IF NOT EXISTS `xshop_item_custom_rates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `price` decimal(14,2) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_epan_id` (`epan_id`)
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_item_images`
--

CREATE TABLE IF NOT EXISTS `xshop_item_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `item_image_id` int(10) unsigned DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `customefieldvalue_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_customefieldvalue_id` (`customefieldvalue_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_item_image_id` (`item_image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `price` decimal(14,2) DEFAULT NULL,
  `old_price` decimal(14,2) DEFAULT NULL,
  `is_default` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

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
  `department_phase_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quantityset_id` (`quantityset_id`),
  KEY `fk_custom_field_value_id` (`custom_field_value_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_customfield_id` (`customfield_id`),
  KEY `fk_department_phase_id` (`department_phase_id`)
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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_epan_id` (`epan_id`)
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `organization_name` varchar(255) DEFAULT NULL,
  `address` text,
  `billing_address` text,
  `shipping_address` text,
  `landmark` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `pincode` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `tin_no` varchar(255) DEFAULT NULL,
  `pan_no` varchar(255) DEFAULT NULL,
  `other_emails` text,
  `website` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_id` (`users_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_created_by_id` (`created_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_member_images`
--

CREATE TABLE IF NOT EXISTS `xshop_member_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image_id` int(10) unsigned DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_image_id` (`image_id`),
  KEY `fk_member_id` (`member_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_opportunity`
--

CREATE TABLE IF NOT EXISTS `xshop_opportunity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lead_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `opportunity` text,
  PRIMARY KEY (`id`),
  KEY `fk_lead_id` (`lead_id`) USING BTREE,
  KEY `fk_customer_id` (`customer_id`) USING BTREE,
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_orderdetails`
--

CREATE TABLE IF NOT EXISTS `xshop_orderdetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `qty` varchar(255) DEFAULT NULL,
  `rate` decimal(14,2) DEFAULT NULL,
  `amount` decimal(14,2) DEFAULT NULL,
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
  `invoice_id` int(11) DEFAULT NULL,
  `apply_tax` tinyint(1) DEFAULT NULL,
  `tax_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_id` (`order_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_invoice_id` (`invoice_id`),
  KEY `fk_tax_id` (`tax_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_orders`
--

CREATE TABLE IF NOT EXISTS `xshop_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `total_amount` decimal(14,2) DEFAULT NULL,
  `discount_voucher` varchar(255) DEFAULT NULL,
  `discount_voucher_amount` varchar(255) DEFAULT NULL,
  `tax` decimal(14,2) DEFAULT NULL,
  `net_amount` decimal(14,2) DEFAULT NULL,
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
  `priority_id` int(11) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `gross_amount` decimal(14,2) DEFAULT NULL,
  `billing_landmark` varchar(255) DEFAULT NULL,
  `billing_city` varchar(255) DEFAULT NULL,
  `billing_state` varchar(255) DEFAULT NULL,
  `billing_country` varchar(255) DEFAULT NULL,
  `billing_zip` varchar(255) DEFAULT NULL,
  `billing_tel` varchar(255) DEFAULT NULL,
  `billing_email` varchar(255) DEFAULT NULL,
  `shipping_landmark` varchar(255) DEFAULT NULL,
  `shipping_city` varchar(255) DEFAULT NULL,
  `shipping_state` varchar(255) DEFAULT NULL,
  `shipping_country` varchar(255) DEFAULT NULL,
  `shipping_zip` varchar(255) DEFAULT NULL,
  `shipping_tel` varchar(255) DEFAULT NULL,
  `shipping_email` varchar(255) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_member_id` (`member_id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_termsandcondition_id` (`termsandcondition_id`) USING BTREE,
  KEY `fk_paymentgateway_id` (`paymentgateway_id`),
  KEY `fk_priority_id` (`priority_id`),
  KEY `fk_currency_id` (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

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
  `gateway_image_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_gateway_image_id` (`gateway_image_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `xshop_payment_gateways`
--

INSERT INTO `xshop_payment_gateways` (`id`, `epan_id`, `name`, `parameters`, `processing`, `is_active`, `default_parameters`, `gateway_image_id`) VALUES
(1, 1, 'AuthorizeNet_AIM', NULL, 'OffSite', 1, '{"apiLoginId":"","transactionKey":"","testMode":false,"developerMode":false}', NULL),
(2, 1, 'AuthorizeNet_SIM', NULL, 'OffSite', 1, '{"apiLoginId":"","transactionKey":"","testMode":false,"developerMode":false,"hashSecret":""}', NULL),
(3, 1, 'Buckaroo_Ideal', NULL, 'OffSite', 1, '{"websiteKey":"","secretKey":"","testMode":false}', NULL),
(4, 1, 'Buckaroo_PayPal', NULL, 'OffSite', 1, '{"websiteKey":"","secretKey":"","testMode":false}', NULL),
(5, 1, 'CardSave', NULL, 'OffSite', 1, '{"merchantId":"","password":""}', NULL),
(6, 1, 'Coinbase', NULL, 'OffSite', 1, '{"apiKey":"","secret":"","accountId":""}', NULL),
(7, 1, 'Dummy', NULL, 'OffSite', 1, '[]', NULL),
(8, 1, 'Eway_Rapid', NULL, 'OffSite', 1, '{"apiKey":"","password":"","testMode":false}', NULL),
(9, 1, 'FirstData_Connect', NULL, 'OffSite', 1, '{"storeId":"","sharedSecret":"","testMode":false}', NULL),
(10, 1, 'GoCardless', NULL, 'OffSite', 1, '{"appId":"","appSecret":"","merchantId":"","accessToken":"","testMode":false}', NULL),
(11, 1, 'Manual', NULL, 'OffSite', 1, '[]', NULL),
(12, 1, 'Migs_ThreeParty', NULL, 'OffSite', 1, '{"merchantId":"","merchantAccessCode":"","secureHash":""}', NULL),
(13, 1, 'Migs_TwoParty', NULL, 'OffSite', 1, '{"merchantId":"","merchantAccessCode":"","secureHash":""}', NULL),
(14, 1, 'Mollie', NULL, 'OffSite', 1, '{"apiKey":""}', NULL),
(15, 1, 'MultiSafepay', NULL, 'OffSite', 1, '{"accountId":"","siteId":"","siteCode":"","testMode":false}', NULL),
(16, 1, 'Netaxept', NULL, 'OffSite', 1, '{"merchantId":"","password":"","testMode":false}', NULL),
(17, 1, 'NetBanx', NULL, 'OffSite', 1, '{"accountNumber":"","storeId":"","storePassword":"","testMode":false}', NULL),
(18, 1, 'PayFast', NULL, 'OffSite', 1, '{"merchantId":"","merchantKey":"","pdtKey":"","testMode":false}', NULL),
(19, 1, 'Payflow_Pro', NULL, 'OffSite', 1, '{"username":"","password":"","vendor":"","partner":"","testMode":false}', NULL),
(20, 1, 'PaymentExpress_PxPay', NULL, 'OffSite', 1, '{"username":"","password":""}', NULL),
(21, 1, 'PaymentExpress_PxPost', NULL, 'OffSite', 1, '{"username":"","password":""}', NULL),
(22, 1, 'PayPal_Express', NULL, 'OffSite', 1, '{"username":"","password":"","signature":"","testMode":false,"solutionType":["Sole","Mark"],"landingPage":["Billing","Login"],"brandName":"","headerImageUrl":"","logoImageUrl":"","borderColor":""}', NULL),
(23, 1, 'PayPal_Pro', NULL, 'OffSite', 1, '{"username":"","password":"","signature":"","testMode":false}', NULL),
(24, 1, 'SagePay_Direct', NULL, 'OffSite', 1, '{"vendor":"","testMode":false,"simulatorMode":false}', NULL),
(25, 1, 'SagePay_Server', NULL, 'OffSite', 1, '{"vendor":"","testMode":false,"simulatorMode":false}', NULL),
(26, 1, 'Stripe', NULL, 'OffSite', 1, '{"apiKey":""}', NULL),
(27, 1, 'TwoCheckout', NULL, 'OffSite', 1, '{"accountNumber":"","secretWord":"","testMode":false}', NULL),
(28, 1, 'WorldPay', NULL, 'OffSite', 1, '{"installationId":"","accountId":"","secretWord":"","callbackPassword":"","testMode":false}', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `xshop_priorities`
--

CREATE TABLE IF NOT EXISTS `xshop_priorities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

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
  KEY `fk_epan_id` (`epan_id`) USING BTREE,
  KEY `fk_product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  KEY `fk_product_id` (`product_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=1 ;

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
  `total_amount` decimal(14,2) DEFAULT NULL,
  `gross_amount` decimal(14,2) DEFAULT NULL,
  `discount_voucher_amount` varchar(255) DEFAULT NULL,
  `tax` decimal(14,2) DEFAULT NULL,
  `net_amount` decimal(14,2) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `narration` text,
  `currency_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_lead_id` (`lead_id`),
  KEY `fk_termsandcondition_id` (`termsandcondition_id`),
  KEY `fk_customer_id` (`customer_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_oppertunity_id` (`opportunity_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_currency_id` (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
  `rate` decimal(14,2) DEFAULT NULL,
  `amount` decimal(14,2) DEFAULT NULL,
  `narration` text,
  `custom_fields` text,
  `apply_tax` tinyint(1) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_quotation_id` (`quotation_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_supplier`
--

CREATE TABLE IF NOT EXISTS `xshop_supplier` (
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
-- Table structure for table `xshop_taxs`
--

CREATE TABLE IF NOT EXISTS `xshop_taxs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `related_document_id` varchar(255) DEFAULT NULL,
  `related_root_document_name` varchar(255) DEFAULT NULL,
  `related_document_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=2 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_from_department_id` (`from_department_id`),
  KEY `fk_to_department_id` (`to_department_id`),
  KEY `fk_orderitem_id` (`orderitem_id`),
  KEY `fk_dispatch_to_warehouse_id` (`dispatch_to_warehouse_id`),
  KEY `fk_orderitem_departmental_status_id` (`orderitem_departmental_status_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
  `narration` text,
  `custom_fields` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_created_by_id` (`created_by_id`),
  KEY `fk_material_request_jobcard_id` (`material_request_jobcard_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_warehouse_id` (`warehouse_id`),
  KEY `fk_epan_id` (`epan_id`)
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
  `custom_fields` text,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_stock_movement_id` (`stock_movement_id`),
  KEY `fk_item_id` (`item_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `name` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
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
  KEY `fk_material_request_jobcard_id` (`material_request_jobcard_id`) USING BTREE,
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_dispatch_request_id` (`dispatch_request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xstore_warehouse`
--

CREATE TABLE IF NOT EXISTS `xstore_warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `out_source_party_id` int(11) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_department_id` (`department_id`),
  KEY `fk_out_source_party_id` (`out_source_party_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `developerzone_entities`
--
ALTER TABLE `developerzone_entities`
  ADD CONSTRAINT `developerzone_entities_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `epan_components_marketplace` (`id`),
  ADD CONSTRAINT `developerzone_entities_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `developerzone_entities` (`id`);

--
-- Constraints for table `developerzone_entity_attributes`
--
ALTER TABLE `developerzone_entity_attributes`
  ADD CONSTRAINT `developerzone_entity_attributes_ibfk_1` FOREIGN KEY (`developerzone_entities_id`) REFERENCES `developerzone_entities` (`id`);

--
-- Constraints for table `developerzone_entity_methods`
--
ALTER TABLE `developerzone_entity_methods`
  ADD CONSTRAINT `developerzone_entity_methods_ibfk_1` FOREIGN KEY (`developerzone_entities_id`) REFERENCES `developerzone_entities` (`id`);

--
-- Constraints for table `developerzone_events`
--
ALTER TABLE `developerzone_events`
  ADD CONSTRAINT `developerzone_events_ibfk_1` FOREIGN KEY (`developerzone_entities_id`) REFERENCES `developerzone_entities` (`id`);

--
-- Constraints for table `developerzone_method_nodes`
--
ALTER TABLE `developerzone_method_nodes`
  ADD CONSTRAINT `developerzone_method_nodes_ibfk_1` FOREIGN KEY (`developerzone_entity_methods_id`) REFERENCES `developerzone_entity_methods` (`id`),
  ADD CONSTRAINT `developerzone_method_nodes_ibfk_2` FOREIGN KEY (`developerzone_entities_id`) REFERENCES `developerzone_entities` (`id`);

--
-- Constraints for table `developerzone_method_nodes_connections`
--
ALTER TABLE `developerzone_method_nodes_connections`
  ADD CONSTRAINT `developerzone_method_nodes_connections_ibfk_1` FOREIGN KEY (`from_port_id`) REFERENCES `developerzone_method_node_ports` (`id`),
  ADD CONSTRAINT `developerzone_method_nodes_connections_ibfk_2` FOREIGN KEY (`to_port_id`) REFERENCES `developerzone_method_node_ports` (`id`);

--
-- Constraints for table `developerzone_method_node_ports`
--
ALTER TABLE `developerzone_method_node_ports`
  ADD CONSTRAINT `developerzone_method_node_ports_ibfk_1` FOREIGN KEY (`node_id`) REFERENCES `developerzone_method_nodes` (`id`);

--
-- Constraints for table `epan`
--
ALTER TABLE `epan`
  ADD CONSTRAINT `epan_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`),
  ADD CONSTRAINT `epan_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  ADD CONSTRAINT `epan_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `epan_categories` (`id`);

--
-- Constraints for table `epan_aliases`
--
ALTER TABLE `epan_aliases`
  ADD CONSTRAINT `epan_aliases_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `epan_categories`
--
ALTER TABLE `epan_categories`
  ADD CONSTRAINT `epan_categories_ibfk_1` FOREIGN KEY (`parent_category_id`) REFERENCES `epan_categories` (`id`);

--
-- Constraints for table `epan_components_plugins`
--
ALTER TABLE `epan_components_plugins`
  ADD CONSTRAINT `epan_components_plugins_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `epan_components_marketplace` (`id`);

--
-- Constraints for table `epan_components_tools`
--
ALTER TABLE `epan_components_tools`
  ADD CONSTRAINT `epan_components_tools_ibfk_1` FOREIGN KEY (`component_id`) REFERENCES `epan_components_marketplace` (`id`);

--
-- Constraints for table `epan_guide_steps`
--
ALTER TABLE `epan_guide_steps`
  ADD CONSTRAINT `epan_guide_steps_ibfk_1` FOREIGN KEY (`guide_id`) REFERENCES `epan_guide` (`id`);

--
-- Constraints for table `epan_installed_components`
--
ALTER TABLE `epan_installed_components`
  ADD CONSTRAINT `epan_installed_components_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `epan_installed_components_ibfk_2` FOREIGN KEY (`component_id`) REFERENCES `epan_components_marketplace` (`id`);

--
-- Constraints for table `epan_page`
--
ALTER TABLE `epan_page`
  ADD CONSTRAINT `epan_page_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `epan_page_ibfk_2` FOREIGN KEY (`parent_page_id`) REFERENCES `epan_page` (`id`),
  ADD CONSTRAINT `epan_page_ibfk_3` FOREIGN KEY (`template_id`) REFERENCES `epan_templates` (`id`);

--
-- Constraints for table `epan_page_snapshots`
--
ALTER TABLE `epan_page_snapshots`
  ADD CONSTRAINT `epan_page_snapshots_ibfk_1` FOREIGN KEY (`epan_page_id`) REFERENCES `epan_page` (`id`);

--
-- Constraints for table `epan_templates`
--
ALTER TABLE `epan_templates`
  ADD CONSTRAINT `epan_templates_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `last_seen_updates`
--
ALTER TABLE `last_seen_updates`
  ADD CONSTRAINT `last_seen_updates_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `last_seen_updates_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `xhr_employees` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `slideshows_awesomeimages`
--
ALTER TABLE `slideshows_awesomeimages`
  ADD CONSTRAINT `slideshows_awesomeimages_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `slideshows_awesomeslider` (`id`);

--
-- Constraints for table `slideshows_awesomeslider`
--
ALTER TABLE `slideshows_awesomeslider`
  ADD CONSTRAINT `slideshows_awesomeslider_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `slideshows_thumbnailslidergallery`
--
ALTER TABLE `slideshows_thumbnailslidergallery`
  ADD CONSTRAINT `slideshows_thumbnailslidergallery_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `slideshows_thumbnailsliderimages`
--
ALTER TABLE `slideshows_thumbnailsliderimages`
  ADD CONSTRAINT `slideshows_thumbnailsliderimages_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `slideshows_thumbnailslidergallery` (`id`);

--
-- Constraints for table `slideshows_transformgallery`
--
ALTER TABLE `slideshows_transformgallery`
  ADD CONSTRAINT `slideshows_transformgallery_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `slideshows_transformgalleryimages`
--
ALTER TABLE `slideshows_transformgalleryimages`
  ADD CONSTRAINT `slideshows_transformgalleryimages_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `slideshows_transformgallery` (`id`);

--
-- Constraints for table `slideshows_waterwheelgallery`
--
ALTER TABLE `slideshows_waterwheelgallery`
  ADD CONSTRAINT `slideshows_waterwheelgallery_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `slideshows_waterwheelimages`
--
ALTER TABLE `slideshows_waterwheelimages`
  ADD CONSTRAINT `slideshows_waterwheelimages_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `slideshows_waterwheelgallery` (`id`);

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`);

--
-- Constraints for table `userappaccess`
--
ALTER TABLE `userappaccess`
  ADD CONSTRAINT `userappaccess_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `userappaccess_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `userappaccess_ibfk_3` FOREIGN KEY (`installed_app_id`) REFERENCES `epan_installed_components` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `user_custom_fields`
--
ALTER TABLE `user_custom_fields`
  ADD CONSTRAINT `user_custom_fields_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `user_custom_field_value`
--
ALTER TABLE `user_custom_field_value`
  ADD CONSTRAINT `user_custom_field_value_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `user_custom_field_value_ibfk_2` FOREIGN KEY (`usercustomefield_id`) REFERENCES `user_custom_fields` (`id`),
  ADD CONSTRAINT `user_custom_field_value_ibfk_3` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `xaccount_account`
--
ALTER TABLE `xaccount_account`
  ADD CONSTRAINT `xaccount_account_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xaccount_account_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xaccount_account_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `xpurchase_supplier` (`id`),
  ADD CONSTRAINT `xaccount_account_ibfk_4` FOREIGN KEY (`out_source_party_id`) REFERENCES `xproduction_out_source_parties` (`id`),
  ADD CONSTRAINT `xaccount_account_ibfk_5` FOREIGN KEY (`customer_id`) REFERENCES `xshop_memberdetails` (`id`),
  ADD CONSTRAINT `xaccount_account_ibfk_6` FOREIGN KEY (`employee_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xaccount_account_ibfk_7` FOREIGN KEY (`group_id`) REFERENCES `xaccount_group` (`id`);

--
-- Constraints for table `xaccount_balance_sheet`
--
ALTER TABLE `xaccount_balance_sheet`
  ADD CONSTRAINT `xaccount_balance_sheet_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xaccount_balance_sheet_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xaccount_group`
--
ALTER TABLE `xaccount_group`
  ADD CONSTRAINT `xaccount_group_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xaccount_group_ibfk_2` FOREIGN KEY (`balance_sheet_id`) REFERENCES `xaccount_balance_sheet` (`id`);

--
-- Constraints for table `xaccount_transaction`
--
ALTER TABLE `xaccount_transaction`
  ADD CONSTRAINT `xaccount_transaction_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xaccount_transaction_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xaccount_transaction_ibfk_3` FOREIGN KEY (`transaction_type_id`) REFERENCES `xaccount_transaction_types` (`id`);

--
-- Constraints for table `xaccount_transaction_row`
--
ALTER TABLE `xaccount_transaction_row`
  ADD CONSTRAINT `xaccount_transaction_row_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xaccount_transaction_row_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `xaccount_transaction` (`id`),
  ADD CONSTRAINT `xaccount_transaction_row_ibfk_3` FOREIGN KEY (`account_id`) REFERENCES `xaccount_account` (`id`);

--
-- Constraints for table `xaccount_transaction_types`
--
ALTER TABLE `xaccount_transaction_types`
  ADD CONSTRAINT `xaccount_transaction_types_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xai_blocks`
--
ALTER TABLE `xai_blocks`
  ADD CONSTRAINT `xai_blocks_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xai_blocks_ibfk_2` FOREIGN KEY (`dimension_id`) REFERENCES `xai_dimension` (`id`);

--
-- Constraints for table `xai_config`
--
ALTER TABLE `xai_config`
  ADD CONSTRAINT `xai_config_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xai_data`
--
ALTER TABLE `xai_data`
  ADD CONSTRAINT `xai_data_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `xai_session` (`id`);

--
-- Constraints for table `xai_dimension`
--
ALTER TABLE `xai_dimension`
  ADD CONSTRAINT `xai_dimension_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xai_information`
--
ALTER TABLE `xai_information`
  ADD CONSTRAINT `xai_information_ibfk_1` FOREIGN KEY (`session_id`) REFERENCES `xai_session` (`id`),
  ADD CONSTRAINT `xai_information_ibfk_2` FOREIGN KEY (`data_id`) REFERENCES `xai_data` (`id`),
  ADD CONSTRAINT `xai_information_ibfk_3` FOREIGN KEY (`meta_information_id`) REFERENCES `xai_meta_information` (`id`);

--
-- Constraints for table `xai_informationextractor`
--
ALTER TABLE `xai_informationextractor`
  ADD CONSTRAINT `xai_informationextractor_ibfk_1` FOREIGN KEY (`meta_data_id`) REFERENCES `xai_meta_data` (`id`);

--
-- Constraints for table `xcrm_document_activities`
--
ALTER TABLE `xcrm_document_activities`
  ADD CONSTRAINT `xcrm_document_activities_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xcrm_document_activities_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xcrm_document_activities_ibfk_3` FOREIGN KEY (`attachment_id`) REFERENCES `filestore_file` (`id`);

--
-- Constraints for table `xcrm_emails`
--
ALTER TABLE `xcrm_emails`
  ADD CONSTRAINT `xcrm_emails_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xcrm_emails_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xcrm_emails_ibfk_3` FOREIGN KEY (`task_id`) REFERENCES `xproduction_tasks` (`id`),
  ADD CONSTRAINT `xcrm_emails_ibfk_4` FOREIGN KEY (`read_by_employee_id`) REFERENCES `xhr_employees` (`id`);

--
-- Constraints for table `xcrm_smses`
--
ALTER TABLE `xcrm_smses`
  ADD CONSTRAINT `xcrm_smses_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xcrm_smses_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xcrm_tickets`
--
ALTER TABLE `xcrm_tickets`
  ADD CONSTRAINT `xcrm_tickets_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xcrm_tickets_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xcrm_tickets_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `xshop_memberdetails` (`id`),
  ADD CONSTRAINT `xcrm_tickets_ibfk_4` FOREIGN KEY (`order_id`) REFERENCES `xshop_orders` (`id`);

--
-- Constraints for table `xdispatch_delivery_note`
--
ALTER TABLE `xdispatch_delivery_note`
  ADD CONSTRAINT `xdispatch_delivery_note_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `xstore_warehouse` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_ibfk_3` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_ibfk_4` FOREIGN KEY (`orderitem_id`) REFERENCES `xshop_orderdetails` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_ibfk_5` FOREIGN KEY (`to_department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_ibfk_6` FOREIGN KEY (`from_department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_ibfk_7` FOREIGN KEY (`dispatch_to_warehouse_id`) REFERENCES `xstore_warehouse` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_ibfk_8` FOREIGN KEY (`orderitem_departmental_status_id`) REFERENCES `xshop_orderitem_departmental_status` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_ibfk_9` FOREIGN KEY (`order_id`) REFERENCES `xshop_orders` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_ibfk_10` FOREIGN KEY (`to_memberdetails_id`) REFERENCES `xshop_memberdetails` (`id`);

--
-- Constraints for table `xdispatch_delivery_note_items`
--
ALTER TABLE `xdispatch_delivery_note_items`
  ADD CONSTRAINT `xdispatch_delivery_note_items_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_items_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_items_ibfk_3` FOREIGN KEY (`orderitem_id`) REFERENCES `xshop_orderdetails` (`id`),
  ADD CONSTRAINT `xdispatch_delivery_note_items_ibfk_4` FOREIGN KEY (`delivery_note_id`) REFERENCES `xdispatch_delivery_note` (`id`);

--
-- Constraints for table `xdispatch_dispatch_request`
--
ALTER TABLE `xdispatch_dispatch_request`
  ADD CONSTRAINT `xdispatch_dispatch_request_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_ibfk_3` FOREIGN KEY (`orderitem_id`) REFERENCES `xshop_orderdetails` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_ibfk_4` FOREIGN KEY (`to_department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_ibfk_5` FOREIGN KEY (`from_department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_ibfk_6` FOREIGN KEY (`dispatch_to_warehouse_id`) REFERENCES `xstore_warehouse` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_ibfk_7` FOREIGN KEY (`orderitem_departmental_status_id`) REFERENCES `xshop_orderitem_departmental_status` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_ibfk_8` FOREIGN KEY (`order_id`) REFERENCES `xshop_orders` (`id`);

--
-- Constraints for table `xdispatch_dispatch_request_items`
--
ALTER TABLE `xdispatch_dispatch_request_items`
  ADD CONSTRAINT `xdispatch_dispatch_request_items_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_items_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_items_ibfk_3` FOREIGN KEY (`orderitem_id`) REFERENCES `xshop_orderdetails` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_items_ibfk_4` FOREIGN KEY (`deliverynote_id`) REFERENCES `xdispatch_delivery_note` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_items_ibfk_5` FOREIGN KEY (`dispatch_request_id`) REFERENCES `xdispatch_dispatch_request` (`id`),
  ADD CONSTRAINT `xdispatch_dispatch_request_items_ibfk_6` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xenquirynsubscription_config`
--
ALTER TABLE `xenquirynsubscription_config`
  ADD CONSTRAINT `xenquirynsubscription_config_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xenquirynsubscription_custome_customfields`
--
ALTER TABLE `xenquirynsubscription_custome_customfields`
  ADD CONSTRAINT `xenquirynsubscription_custome_customfields_ibfk_1` FOREIGN KEY (`forms_id`) REFERENCES `xenquirynsubscription_customform_forms` (`id`);

--
-- Constraints for table `xenquirynsubscription_customformentry`
--
ALTER TABLE `xenquirynsubscription_customformentry`
  ADD CONSTRAINT `xenquirynsubscription_customformentry_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xenquirynsubscription_customformentry_ibfk_2` FOREIGN KEY (`forms_id`) REFERENCES `xenquirynsubscription_customform_forms` (`id`);

--
-- Constraints for table `xenquirynsubscription_customform_forms`
--
ALTER TABLE `xenquirynsubscription_customform_forms`
  ADD CONSTRAINT `xenquirynsubscription_customform_forms_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xenquirynsubscription_emailjobs`
--
ALTER TABLE `xenquirynsubscription_emailjobs`
  ADD CONSTRAINT `xenquirynsubscription_emailjobs_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xenquirynsubscription_emailjobs_ibfk_2` FOREIGN KEY (`newsletter_id`) REFERENCES `xenquirynsubscription_newsletter` (`id`);

--
-- Constraints for table `xenquirynsubscription_emailqueue`
--
ALTER TABLE `xenquirynsubscription_emailqueue`
  ADD CONSTRAINT `xenquirynsubscription_emailqueue_ibfk_1` FOREIGN KEY (`emailjobs_id`) REFERENCES `xenquirynsubscription_emailjobs` (`id`),
  ADD CONSTRAINT `xenquirynsubscription_emailqueue_ibfk_2` FOREIGN KEY (`subscriber_id`) REFERENCES `xenquirynsubscription_subscription` (`id`);

--
-- Constraints for table `xenquirynsubscription_hosts_touched`
--
ALTER TABLE `xenquirynsubscription_hosts_touched`
  ADD CONSTRAINT `xenquirynsubscription_hosts_touched_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `xenquirynsubscription_subscription_categories` (`id`);

--
-- Constraints for table `xenquirynsubscription_massemailconfiguration`
--
ALTER TABLE `xenquirynsubscription_massemailconfiguration`
  ADD CONSTRAINT `xenquirynsubscription_massemailconfiguration_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xenquirynsubscription_newsletter`
--
ALTER TABLE `xenquirynsubscription_newsletter`
  ADD CONSTRAINT `xenquirynsubscription_newsletter_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xenquirynsubscription_newsletter_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xenquirynsubscription_newsletter_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `xenquirynsubscription_newslettercategory` (`id`);

--
-- Constraints for table `xenquirynsubscription_newslettercategory`
--
ALTER TABLE `xenquirynsubscription_newslettercategory`
  ADD CONSTRAINT `xenquirynsubscription_newslettercategory_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xenquirynsubscription_newslettercategory_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xenquirynsubscription_newsletter_templates`
--
ALTER TABLE `xenquirynsubscription_newsletter_templates`
  ADD CONSTRAINT `xenquirynsubscription_newsletter_templates_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xenquirynsubscription_newsletter_templates_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xenquirynsubscription_subscatass`
--
ALTER TABLE `xenquirynsubscription_subscatass`
  ADD CONSTRAINT `xenquirynsubscription_subscatass_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `xenquirynsubscription_subscription_categories` (`id`),
  ADD CONSTRAINT `xenquirynsubscription_subscatass_ibfk_2` FOREIGN KEY (`subscriber_id`) REFERENCES `xenquirynsubscription_subscription` (`id`);

--
-- Constraints for table `xenquirynsubscription_subscription`
--
ALTER TABLE `xenquirynsubscription_subscription`
  ADD CONSTRAINT `xenquirynsubscription_subscription_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xenquirynsubscription_subscription_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xenquirynsubscription_subscription_categories`
--
ALTER TABLE `xenquirynsubscription_subscription_categories`
  ADD CONSTRAINT `xenquirynsubscription_subscription_categories_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xenquirynsubscription_subscription_categories_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xenquirynsubscription_subscription_config`
--
ALTER TABLE `xenquirynsubscription_subscription_config`
  ADD CONSTRAINT `xenquirynsubscription_subscription_config_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `xenquirynsubscription_subscription_categories` (`id`);

--
-- Constraints for table `xepan_generic_documents`
--
ALTER TABLE `xepan_generic_documents`
  ADD CONSTRAINT `xepan_generic_documents_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xepan_generic_documents_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xepan_generic_documents_ibfk_3` FOREIGN KEY (`generic_doc_category_id`) REFERENCES `xepan_generic_documents_category` (`id`);

--
-- Constraints for table `xepan_generic_documents_category`
--
ALTER TABLE `xepan_generic_documents_category`
  ADD CONSTRAINT `xepan_generic_documents_category_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`);

--
-- Constraints for table `xhr_departments`
--
ALTER TABLE `xhr_departments`
  ADD CONSTRAINT `xhr_departments_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_departments_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`);

--
-- Constraints for table `xhr_departments_acl`
--
ALTER TABLE `xhr_departments_acl`
  ADD CONSTRAINT `xhr_departments_acl_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_departments_acl_ibfk_2` FOREIGN KEY (`document_id`) REFERENCES `xhr_documents` (`id`),
  ADD CONSTRAINT `xhr_departments_acl_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `xhr_posts` (`id`);

--
-- Constraints for table `xhr_documents`
--
ALTER TABLE `xhr_documents`
  ADD CONSTRAINT `xhr_documents_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_documents_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`);

--
-- Constraints for table `xhr_employees`
--
ALTER TABLE `xhr_employees`
  ADD CONSTRAINT `xhr_employees_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_employees_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `xhr_posts` (`id`),
  ADD CONSTRAINT `xhr_employees_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `xhr_employees_ibfk_4` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xhr_employees_ibfk_5` FOREIGN KEY (`empolyee_image_id`) REFERENCES `filestore_file` (`id`);

--
-- Constraints for table `xhr_employee_attendence`
--
ALTER TABLE `xhr_employee_attendence`
  ADD CONSTRAINT `xhr_employee_attendence_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_employee_attendence_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `xhr_employees` (`id`);

--
-- Constraints for table `xhr_employee_leave`
--
ALTER TABLE `xhr_employee_leave`
  ADD CONSTRAINT `xhr_employee_leave_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_employee_leave_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xhr_employee_leave_ibfk_3` FOREIGN KEY (`leave_type_id`) REFERENCES `xhr_leave_types` (`id`);

--
-- Constraints for table `xhr_holiday_blocks`
--
ALTER TABLE `xhr_holiday_blocks`
  ADD CONSTRAINT `xhr_holiday_blocks_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_holiday_blocks_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`);

--
-- Constraints for table `xhr_leave_types`
--
ALTER TABLE `xhr_leave_types`
  ADD CONSTRAINT `xhr_leave_types_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xhr_official_emails`
--
ALTER TABLE `xhr_official_emails`
  ADD CONSTRAINT `xhr_official_emails_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xhr_official_emails_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_official_emails_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xhr_official_emails_ibfk_4` FOREIGN KEY (`employee_id`) REFERENCES `xhr_employees` (`id`);

--
-- Constraints for table `xhr_posts`
--
ALTER TABLE `xhr_posts`
  ADD CONSTRAINT `xhr_posts_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_posts_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xhr_posts_ibfk_3` FOREIGN KEY (`parent_post_id`) REFERENCES `xhr_posts` (`id`);

--
-- Constraints for table `xhr_salary`
--
ALTER TABLE `xhr_salary`
  ADD CONSTRAINT `xhr_salary_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_salary_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xhr_salary_ibfk_3` FOREIGN KEY (`salary_type_id`) REFERENCES `xhr_salary_types` (`id`),
  ADD CONSTRAINT `xhr_salary_ibfk_4` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`);

--
-- Constraints for table `xhr_salary_templates`
--
ALTER TABLE `xhr_salary_templates`
  ADD CONSTRAINT `xhr_salary_templates_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_salary_templates_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xhr_salary_templates_ibfk_3` FOREIGN KEY (`post_id`) REFERENCES `xhr_posts` (`id`);

--
-- Constraints for table `xhr_salary_types`
--
ALTER TABLE `xhr_salary_types`
  ADD CONSTRAINT `xhr_salary_types_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xhr_template_salary`
--
ALTER TABLE `xhr_template_salary`
  ADD CONSTRAINT `xhr_template_salary_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xhr_template_salary_ibfk_2` FOREIGN KEY (`salary_template_id`) REFERENCES `xhr_salary_templates` (`id`),
  ADD CONSTRAINT `xhr_template_salary_ibfk_3` FOREIGN KEY (`salary_type_id`) REFERENCES `xhr_salary_types` (`id`);

--
-- Constraints for table `ximagegallery_gallery`
--
ALTER TABLE `ximagegallery_gallery`
  ADD CONSTRAINT `ximagegallery_gallery_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `ximagegallery_images`
--
ALTER TABLE `ximagegallery_images`
  ADD CONSTRAINT `ximagegallery_images_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `ximagegallery_gallery` (`id`);

--
-- Constraints for table `xmarketingcampaign_campaignnewsletter`
--
ALTER TABLE `xmarketingcampaign_campaignnewsletter`
  ADD CONSTRAINT `xmarketingcampaign_campaignnewsletter_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_campaignnewsletter_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `xmarketingcampaign_campaigns` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_campaignnewsletter_ibfk_3` FOREIGN KEY (`newsletter_id`) REFERENCES `xenquirynsubscription_newsletter` (`id`);

--
-- Constraints for table `xmarketingcampaign_campaigns`
--
ALTER TABLE `xmarketingcampaign_campaigns`
  ADD CONSTRAINT `xmarketingcampaign_campaigns_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_campaigns_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `xmarketingcampaign_campaigns_categories` (`id`);

--
-- Constraints for table `xmarketingcampaign_campaignsocialposts`
--
ALTER TABLE `xmarketingcampaign_campaignsocialposts`
  ADD CONSTRAINT `xmarketingcampaign_campaignsocialposts_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_campaignsocialposts_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `xmarketingcampaign_campaigns` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_campaignsocialposts_ibfk_3` FOREIGN KEY (`socialpost_id`) REFERENCES `xmarketingcampaign_socialposts` (`id`);

--
-- Constraints for table `xmarketingcampaign_campaigns_categories`
--
ALTER TABLE `xmarketingcampaign_campaigns_categories`
  ADD CONSTRAINT `xmarketingcampaign_campaigns_categories_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xmarketingcampaign_config`
--
ALTER TABLE `xmarketingcampaign_config`
  ADD CONSTRAINT `xmarketingcampaign_config_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xmarketingcampaign_cp_socialuser_cat`
--
ALTER TABLE `xmarketingcampaign_cp_socialuser_cat`
  ADD CONSTRAINT `xmarketingcampaign_cp_socialuser_cat_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_cp_socialuser_cat_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `xmarketingcampaign_campaigns` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_cp_socialuser_cat_ibfk_3` FOREIGN KEY (`socialuser_id`) REFERENCES `xmarketingcampaign_socialusers` (`id`);

--
-- Constraints for table `xmarketingcampaign_cp_sub_cat`
--
ALTER TABLE `xmarketingcampaign_cp_sub_cat`
  ADD CONSTRAINT `xmarketingcampaign_cp_sub_cat_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_cp_sub_cat_ibfk_2` FOREIGN KEY (`campaign_id`) REFERENCES `xmarketingcampaign_campaigns` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_cp_sub_cat_ibfk_3` FOREIGN KEY (`category_id`) REFERENCES `xenquirynsubscription_subscription_categories` (`id`);

--
-- Constraints for table `xmarketingcampaign_data_grabber`
--
ALTER TABLE `xmarketingcampaign_data_grabber`
  ADD CONSTRAINT `xmarketingcampaign_data_grabber_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xmarketingcampaign_data_search_phrase`
--
ALTER TABLE `xmarketingcampaign_data_search_phrase`
  ADD CONSTRAINT `xmarketingcampaign_data_search_phrase_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_data_search_phrase_ibfk_2` FOREIGN KEY (`data_grabber_id`) REFERENCES `xmarketingcampaign_data_grabber` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_data_search_phrase_ibfk_3` FOREIGN KEY (`subscription_category_id`) REFERENCES `xenquirynsubscription_subscription_categories` (`id`);

--
-- Constraints for table `xmarketingcampaign_googlebloggerconfig`
--
ALTER TABLE `xmarketingcampaign_googlebloggerconfig`
  ADD CONSTRAINT `xmarketingcampaign_googlebloggerconfig_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xmarketingcampaign_socialconfig`
--
ALTER TABLE `xmarketingcampaign_socialconfig`
  ADD CONSTRAINT `xmarketingcampaign_socialconfig_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xmarketingcampaign_socialpostings`
--
ALTER TABLE `xmarketingcampaign_socialpostings`
  ADD CONSTRAINT `xmarketingcampaign_socialpostings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `xmarketingcampaign_socialusers` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_socialpostings_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `xmarketingcampaign_socialposts` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_socialpostings_ibfk_3` FOREIGN KEY (`campaign_id`) REFERENCES `xmarketingcampaign_campaigns` (`id`);

--
-- Constraints for table `xmarketingcampaign_socialpostings_activities`
--
ALTER TABLE `xmarketingcampaign_socialpostings_activities`
  ADD CONSTRAINT `xmarketingcampaign_socialpostings_activities_ibfk_1` FOREIGN KEY (`posting_id`) REFERENCES `xmarketingcampaign_socialpostings` (`id`);

--
-- Constraints for table `xmarketingcampaign_socialposts`
--
ALTER TABLE `xmarketingcampaign_socialposts`
  ADD CONSTRAINT `xmarketingcampaign_socialposts_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xmarketingcampaign_socialposts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `xmarketingcampaign_socialpost_categories` (`id`);

--
-- Constraints for table `xmarketingcampaign_socialpost_categories`
--
ALTER TABLE `xmarketingcampaign_socialpost_categories`
  ADD CONSTRAINT `xmarketingcampaign_socialpost_categories_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xmarketingcampaign_socialusers`
--
ALTER TABLE `xmarketingcampaign_socialusers`
  ADD CONSTRAINT `xmarketingcampaign_socialusers_ibfk_1` FOREIGN KEY (`config_id`) REFERENCES `xmarketingcampaign_socialconfig` (`id`);

--
-- Constraints for table `xproduction_employee_team_associations`
--
ALTER TABLE `xproduction_employee_team_associations`
  ADD CONSTRAINT `xproduction_employee_team_associations_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `xproduction_teams` (`id`),
  ADD CONSTRAINT `xproduction_employee_team_associations_ibfk_2` FOREIGN KEY (`employee_id`) REFERENCES `xhr_employees` (`id`);

--
-- Constraints for table `xproduction_jobcard`
--
ALTER TABLE `xproduction_jobcard`
  ADD CONSTRAINT `xproduction_jobcard_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xproduction_jobcard_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xproduction_jobcard_ibfk_3` FOREIGN KEY (`orderitem_id`) REFERENCES `xshop_orderdetails` (`id`),
  ADD CONSTRAINT `xproduction_jobcard_ibfk_4` FOREIGN KEY (`to_department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xproduction_jobcard_ibfk_5` FOREIGN KEY (`from_department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xproduction_jobcard_ibfk_6` FOREIGN KEY (`dispatch_to_warehouse_id`) REFERENCES `xstore_warehouse` (`id`),
  ADD CONSTRAINT `xproduction_jobcard_ibfk_7` FOREIGN KEY (`orderitem_departmental_status_id`) REFERENCES `xshop_orderitem_departmental_status` (`id`);

--
-- Constraints for table `xproduction_outsource_party_dept_associations`
--
ALTER TABLE `xproduction_outsource_party_dept_associations`
  ADD CONSTRAINT `xproduction_outsource_party_dept_associations_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xproduction_outsource_party_dept_associations_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xproduction_outsource_party_dept_associations_ibfk_3` FOREIGN KEY (`out_source_party_id`) REFERENCES `xproduction_out_source_parties` (`id`);

--
-- Constraints for table `xproduction_out_source_parties`
--
ALTER TABLE `xproduction_out_source_parties`
  ADD CONSTRAINT `xproduction_out_source_parties_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xproduction_tasks`
--
ALTER TABLE `xproduction_tasks`
  ADD CONSTRAINT `xproduction_tasks_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xproduction_tasks_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xproduction_tasks_ibfk_3` FOREIGN KEY (`team_id`) REFERENCES `xproduction_teams` (`id`),
  ADD CONSTRAINT `xproduction_tasks_ibfk_4` FOREIGN KEY (`employee_id`) REFERENCES `xhr_employees` (`id`);

--
-- Constraints for table `xproduction_teams`
--
ALTER TABLE `xproduction_teams`
  ADD CONSTRAINT `xproduction_teams_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xproduction_teams_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`);

--
-- Constraints for table `xpurchase_purchase_order`
--
ALTER TABLE `xpurchase_purchase_order`
  ADD CONSTRAINT `xpurchase_purchase_order_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xpurchase_purchase_order_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xpurchase_purchase_order_ibfk_3` FOREIGN KEY (`termsandcondition_id`) REFERENCES `xshop_termsandcondition` (`id`),
  ADD CONSTRAINT `xpurchase_purchase_order_ibfk_4` FOREIGN KEY (`supplier_id`) REFERENCES `xpurchase_supplier` (`id`),
  ADD CONSTRAINT `xpurchase_purchase_order_ibfk_5` FOREIGN KEY (`priority_id`) REFERENCES `xshop_priorities` (`id`);

--
-- Constraints for table `xpurchase_purchase_order_item`
--
ALTER TABLE `xpurchase_purchase_order_item`
  ADD CONSTRAINT `xpurchase_purchase_order_item_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xpurchase_purchase_order_item_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xpurchase_purchase_order_item_ibfk_3` FOREIGN KEY (`po_id`) REFERENCES `xpurchase_purchase_order` (`id`),
  ADD CONSTRAINT `xpurchase_purchase_order_item_ibfk_4` FOREIGN KEY (`invoice_id`) REFERENCES `xshop_invoices` (`id`),
  ADD CONSTRAINT `xpurchase_purchase_order_item_ibfk_5` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xpurchase_supplier`
--
ALTER TABLE `xpurchase_supplier`
  ADD CONSTRAINT `xpurchase_supplier_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xpurchase_supplier_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xshop_addblock`
--
ALTER TABLE `xshop_addblock`
  ADD CONSTRAINT `xshop_addblock_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xshop_affiliate`
--
ALTER TABLE `xshop_affiliate`
  ADD CONSTRAINT `xshop_affiliate_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_affiliate_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_affiliate_ibfk_3` FOREIGN KEY (`application_id`) REFERENCES `xshop_application` (`id`),
  ADD CONSTRAINT `xshop_affiliate_ibfk_4` FOREIGN KEY (`affiliatetype_id`) REFERENCES `xshop_affiliatetype` (`id`),
  ADD CONSTRAINT `xshop_affiliate_ibfk_5` FOREIGN KEY (`logo_url_id`) REFERENCES `filestore_file` (`id`);

--
-- Constraints for table `xshop_affiliatetype`
--
ALTER TABLE `xshop_affiliatetype`
  ADD CONSTRAINT `xshop_affiliatetype_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_affiliatetype_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_affiliatetype_ibfk_3` FOREIGN KEY (`application_id`) REFERENCES `xshop_application` (`id`);

--
-- Constraints for table `xshop_application`
--
ALTER TABLE `xshop_application`
  ADD CONSTRAINT `xshop_application_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_application_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xshop_blockimages`
--
ALTER TABLE `xshop_blockimages`
  ADD CONSTRAINT `xshop_blockimages_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_blockimages_ibfk_2` FOREIGN KEY (`block_id`) REFERENCES `xshop_addblock` (`id`);

--
-- Constraints for table `xshop_categories`
--
ALTER TABLE `xshop_categories`
  ADD CONSTRAINT `xshop_categories_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_categories_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_categories_ibfk_3` FOREIGN KEY (`application_id`) REFERENCES `xshop_application` (`id`),
  ADD CONSTRAINT `xshop_categories_ibfk_4` FOREIGN KEY (`parent_id`) REFERENCES `xshop_categories` (`id`),
  ADD CONSTRAINT `xshop_categories_ibfk_5` FOREIGN KEY (`image_url_id`) REFERENCES `filestore_file` (`id`);

--
-- Constraints for table `xshop_category_item`
--
ALTER TABLE `xshop_category_item`
  ADD CONSTRAINT `xshop_category_item_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `xshop_categories` (`id`),
  ADD CONSTRAINT `xshop_category_item_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xshop_configuration`
--
ALTER TABLE `xshop_configuration`
  ADD CONSTRAINT `xshop_configuration_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_configuration_ibfk_2` FOREIGN KEY (`application_id`) REFERENCES `xshop_application` (`id`);

--
-- Constraints for table `xshop_customfiledvalue_filter_ass`
--
ALTER TABLE `xshop_customfiledvalue_filter_ass`
  ADD CONSTRAINT `xshop_customfiledvalue_filter_ass_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_customfiledvalue_filter_ass_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`),
  ADD CONSTRAINT `xshop_customfiledvalue_filter_ass_ibfk_3` FOREIGN KEY (`customfield_id`) REFERENCES `xshop_custom_fields` (`id`),
  ADD CONSTRAINT `xshop_customfiledvalue_filter_ass_ibfk_4` FOREIGN KEY (`customefieldvalue_id`) REFERENCES `xshop_custom_fields_value` (`id`);

--
-- Constraints for table `xshop_customrate_custome_value_conditions`
--
ALTER TABLE `xshop_customrate_custome_value_conditions`
  ADD CONSTRAINT `xshop_customrate_custome_value_conditions_ibfk_1` FOREIGN KEY (`custom_rate_id`) REFERENCES `xshop_item_custom_rates` (`id`),
  ADD CONSTRAINT `xshop_customrate_custome_value_conditions_ibfk_2` FOREIGN KEY (`custom_field_value_id`) REFERENCES `xshop_custom_fields_value` (`id`);

--
-- Constraints for table `xshop_custom_fields`
--
ALTER TABLE `xshop_custom_fields`
  ADD CONSTRAINT `xshop_custom_fields_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_custom_fields_ibfk_2` FOREIGN KEY (`application_id`) REFERENCES `xshop_application` (`id`);

--
-- Constraints for table `xshop_custom_fields_value`
--
ALTER TABLE `xshop_custom_fields_value`
  ADD CONSTRAINT `xshop_custom_fields_value_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_custom_fields_value_ibfk_2` FOREIGN KEY (`itemcustomfiledasso_id`) REFERENCES `xshop_item_customfields_assos` (`id`),
  ADD CONSTRAINT `xshop_custom_fields_value_ibfk_3` FOREIGN KEY (`customfield_id`) REFERENCES `xshop_custom_fields` (`id`),
  ADD CONSTRAINT `xshop_custom_fields_value_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xshop_discount_vouchers`
--
ALTER TABLE `xshop_discount_vouchers`
  ADD CONSTRAINT `xshop_discount_vouchers_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_discount_vouchers_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xshop_discount_vouchers_used`
--
ALTER TABLE `xshop_discount_vouchers_used`
  ADD CONSTRAINT `xshop_discount_vouchers_used_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_discount_vouchers_used_ibfk_2` FOREIGN KEY (`discountvoucher_id`) REFERENCES `xshop_discount_vouchers` (`id`),
  ADD CONSTRAINT `xshop_discount_vouchers_used_ibfk_3` FOREIGN KEY (`member_id`) REFERENCES `xshop_memberdetails` (`id`);

--
-- Constraints for table `xshop_image_library_category`
--
ALTER TABLE `xshop_image_library_category`
  ADD CONSTRAINT `xshop_image_library_category_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xshop_invoices`
--
ALTER TABLE `xshop_invoices`
  ADD CONSTRAINT `xshop_invoices_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_invoices_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_invoices_ibfk_3` FOREIGN KEY (`orderitem_id`) REFERENCES `xshop_orderdetails` (`id`),
  ADD CONSTRAINT `xshop_invoices_ibfk_4` FOREIGN KEY (`customer_id`) REFERENCES `xshop_memberdetails` (`id`),
  ADD CONSTRAINT `xshop_invoices_ibfk_5` FOREIGN KEY (`supplier_id`) REFERENCES `xpurchase_supplier` (`id`),
  ADD CONSTRAINT `xshop_invoices_ibfk_6` FOREIGN KEY (`sales_order_id`) REFERENCES `xshop_orders` (`id`),
  ADD CONSTRAINT `xshop_invoices_ibfk_7` FOREIGN KEY (`po_id`) REFERENCES `xpurchase_purchase_order` (`id`),
  ADD CONSTRAINT `xshop_invoices_ibfk_8` FOREIGN KEY (`termsandcondition_id`) REFERENCES `xshop_termsandcondition` (`id`);

--
-- Constraints for table `xshop_invoice_item`
--
ALTER TABLE `xshop_invoice_item`
  ADD CONSTRAINT `xshop_invoice_item_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_invoice_item_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_invoice_item_ibfk_3` FOREIGN KEY (`invoice_id`) REFERENCES `xshop_invoices` (`id`),
  ADD CONSTRAINT `xshop_invoice_item_ibfk_4` FOREIGN KEY (`orderitem_id`) REFERENCES `xshop_orderdetails` (`id`),
  ADD CONSTRAINT `xshop_invoice_item_ibfk_5` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`),
  ADD CONSTRAINT `xshop_invoice_item_ibfk_6` FOREIGN KEY (`tax_id`) REFERENCES `xshop_taxs` (`id`);

--
-- Constraints for table `xshop_itemenquiry`
--
ALTER TABLE `xshop_itemenquiry`
  ADD CONSTRAINT `xshop_itemenquiry_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_itemenquiry_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xshop_itemoffers`
--
ALTER TABLE `xshop_itemoffers`
  ADD CONSTRAINT `xshop_itemoffers_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_itemoffers_ibfk_2` FOREIGN KEY (`application_id`) REFERENCES `xshop_application` (`id`),
  ADD CONSTRAINT `xshop_itemoffers_ibfk_3` FOREIGN KEY (`offer_image_id`) REFERENCES `filestore_file` (`id`);

--
-- Constraints for table `xshop_items`
--
ALTER TABLE `xshop_items`
  ADD CONSTRAINT `xshop_items_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_items_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_items_ibfk_3` FOREIGN KEY (`application_id`) REFERENCES `xshop_application` (`id`),
  ADD CONSTRAINT `xshop_items_ibfk_4` FOREIGN KEY (`designer_id`) REFERENCES `xshop_memberdetails` (`id`),
  ADD CONSTRAINT `xshop_items_ibfk_5` FOREIGN KEY (`offer_id`) REFERENCES `xshop_itemoffers` (`id`),
  ADD CONSTRAINT `xshop_items_ibfk_6` FOREIGN KEY (`watermark_image_id`) REFERENCES `filestore_file` (`id`);

--
-- Constraints for table `xshop_item_affiliate_ass`
--
ALTER TABLE `xshop_item_affiliate_ass`
  ADD CONSTRAINT `xshop_item_affiliate_ass_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_item_affiliate_ass_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`),
  ADD CONSTRAINT `xshop_item_affiliate_ass_ibfk_3` FOREIGN KEY (`affiliatetype_id`) REFERENCES `xshop_affiliatetype` (`id`),
  ADD CONSTRAINT `xshop_item_affiliate_ass_ibfk_4` FOREIGN KEY (`affiliate_id`) REFERENCES `xshop_affiliate` (`id`);

--
-- Constraints for table `xshop_item_compositions`
--
ALTER TABLE `xshop_item_compositions`
  ADD CONSTRAINT `xshop_item_compositions_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_item_compositions_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`),
  ADD CONSTRAINT `xshop_item_compositions_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xshop_item_compositions_ibfk_4` FOREIGN KEY (`composition_item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xshop_item_customfields_assos`
--
ALTER TABLE `xshop_item_customfields_assos`
  ADD CONSTRAINT `xshop_item_customfields_assos_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_item_customfields_assos_ibfk_2` FOREIGN KEY (`customfield_id`) REFERENCES `xshop_custom_fields` (`id`),
  ADD CONSTRAINT `xshop_item_customfields_assos_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`),
  ADD CONSTRAINT `xshop_item_customfields_assos_ibfk_4` FOREIGN KEY (`department_phase_id`) REFERENCES `xhr_departments` (`id`);

--
-- Constraints for table `xshop_item_custom_rates`
--
ALTER TABLE `xshop_item_custom_rates`
  ADD CONSTRAINT `xshop_item_custom_rates_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_item_custom_rates_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xshop_item_department_asso`
--
ALTER TABLE `xshop_item_department_asso`
  ADD CONSTRAINT `xshop_item_department_asso_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`),
  ADD CONSTRAINT `xshop_item_department_asso_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`);

--
-- Constraints for table `xshop_item_images`
--
ALTER TABLE `xshop_item_images`
  ADD CONSTRAINT `xshop_item_images_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_item_images_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`),
  ADD CONSTRAINT `xshop_item_images_ibfk_3` FOREIGN KEY (`customefieldvalue_id`) REFERENCES `xshop_custom_fields_value` (`id`),
  ADD CONSTRAINT `xshop_item_images_ibfk_4` FOREIGN KEY (`item_image_id`) REFERENCES `filestore_file` (`id`);

--
-- Constraints for table `xshop_item_member_designs`
--
ALTER TABLE `xshop_item_member_designs`
  ADD CONSTRAINT `xshop_item_member_designs_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_item_member_designs_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`),
  ADD CONSTRAINT `xshop_item_member_designs_ibfk_3` FOREIGN KEY (`member_id`) REFERENCES `xshop_memberdetails` (`id`);

--
-- Constraints for table `xshop_item_quantity_sets`
--
ALTER TABLE `xshop_item_quantity_sets`
  ADD CONSTRAINT `xshop_item_quantity_sets_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xshop_item_quantity_set_conditions`
--
ALTER TABLE `xshop_item_quantity_set_conditions`
  ADD CONSTRAINT `xshop_item_quantity_set_conditions_ibfk_1` FOREIGN KEY (`department_phase_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xshop_item_quantity_set_conditions_ibfk_2` FOREIGN KEY (`quantityset_id`) REFERENCES `xshop_item_quantity_sets` (`id`),
  ADD CONSTRAINT `xshop_item_quantity_set_conditions_ibfk_3` FOREIGN KEY (`custom_field_value_id`) REFERENCES `xshop_custom_fields_value` (`id`),
  ADD CONSTRAINT `xshop_item_quantity_set_conditions_ibfk_4` FOREIGN KEY (`customfield_id`) REFERENCES `xshop_custom_fields` (`id`),
  ADD CONSTRAINT `xshop_item_quantity_set_conditions_ibfk_5` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xshop_item_reviews`
--
ALTER TABLE `xshop_item_reviews`
  ADD CONSTRAINT `xshop_item_reviews_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_item_reviews_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xshop_item_spec_ass`
--
ALTER TABLE `xshop_item_spec_ass`
  ADD CONSTRAINT `xshop_item_spec_ass_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`),
  ADD CONSTRAINT `xshop_item_spec_ass_ibfk_2` FOREIGN KEY (`specification_id`) REFERENCES `xshop_specifications` (`id`);

--
-- Constraints for table `xshop_memberdetails`
--
ALTER TABLE `xshop_memberdetails`
  ADD CONSTRAINT `xshop_memberdetails_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_memberdetails_ibfk_2` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `xshop_memberdetails_ibfk_3` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xshop_member_images`
--
ALTER TABLE `xshop_member_images`
  ADD CONSTRAINT `xshop_member_images_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_member_images_ibfk_2` FOREIGN KEY (`member_id`) REFERENCES `xshop_memberdetails` (`id`),
  ADD CONSTRAINT `xshop_member_images_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `filestore_file` (`id`);

--
-- Constraints for table `xshop_opportunity`
--
ALTER TABLE `xshop_opportunity`
  ADD CONSTRAINT `xshop_opportunity_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_opportunity_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_opportunity_ibfk_3` FOREIGN KEY (`lead_id`) REFERENCES `xenquirynsubscription_subscription` (`id`),
  ADD CONSTRAINT `xshop_opportunity_ibfk_4` FOREIGN KEY (`customer_id`) REFERENCES `xshop_memberdetails` (`id`);

--
-- Constraints for table `xshop_orderdetails`
--
ALTER TABLE `xshop_orderdetails`
  ADD CONSTRAINT `xshop_orderdetails_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_orderdetails_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_orderdetails_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `xshop_orders` (`id`),
  ADD CONSTRAINT `xshop_orderdetails_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`),
  ADD CONSTRAINT `xshop_orderdetails_ibfk_5` FOREIGN KEY (`invoice_id`) REFERENCES `xshop_invoices` (`id`),
  ADD CONSTRAINT `xshop_orderdetails_ibfk_6` FOREIGN KEY (`tax_id`) REFERENCES `xshop_taxs` (`id`);

--
-- Constraints for table `xshop_orderitem_departmental_status`
--
ALTER TABLE `xshop_orderitem_departmental_status`
  ADD CONSTRAINT `xshop_orderitem_departmental_status_ibfk_1` FOREIGN KEY (`orderitem_id`) REFERENCES `xshop_orderdetails` (`id`),
  ADD CONSTRAINT `xshop_orderitem_departmental_status_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xshop_orderitem_departmental_status_ibfk_3` FOREIGN KEY (`outsource_party_id`) REFERENCES `xproduction_out_source_parties` (`id`);

--
-- Constraints for table `xshop_orders`
--
ALTER TABLE `xshop_orders`
  ADD CONSTRAINT `xshop_orders_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_orders_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_orders_ibfk_3` FOREIGN KEY (`paymentgateway_id`) REFERENCES `xshop_payment_gateways` (`id`),
  ADD CONSTRAINT `xshop_orders_ibfk_4` FOREIGN KEY (`termsandcondition_id`) REFERENCES `xshop_termsandcondition` (`id`),
  ADD CONSTRAINT `xshop_orders_ibfk_5` FOREIGN KEY (`priority_id`) REFERENCES `xshop_priorities` (`id`),
  ADD CONSTRAINT `xshop_orders_ibfk_6` FOREIGN KEY (`member_id`) REFERENCES `xshop_memberdetails` (`id`),
  ADD CONSTRAINT `xshop_orders_ibfk_7` FOREIGN KEY (`currency_id`) REFERENCES `xshop_currency` (`id`);

--
-- Constraints for table `xshop_payment_gateways`
--
ALTER TABLE `xshop_payment_gateways`
  ADD CONSTRAINT `xshop_payment_gateways_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_payment_gateways_ibfk_2` FOREIGN KEY (`gateway_image_id`) REFERENCES `filestore_file` (`id`);

--
-- Constraints for table `xshop_priorities`
--
ALTER TABLE `xshop_priorities`
  ADD CONSTRAINT `xshop_priorities_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_priorities_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xshop_quotation`
--
ALTER TABLE `xshop_quotation`
  ADD CONSTRAINT `xshop_quotation_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_quotation_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_quotation_ibfk_3` FOREIGN KEY (`lead_id`) REFERENCES `xenquirynsubscription_subscription` (`id`),
  ADD CONSTRAINT `xshop_quotation_ibfk_4` FOREIGN KEY (`opportunity_id`) REFERENCES `xshop_opportunity` (`id`),
  ADD CONSTRAINT `xshop_quotation_ibfk_5` FOREIGN KEY (`customer_id`) REFERENCES `xshop_memberdetails` (`id`),
  ADD CONSTRAINT `xshop_quotation_ibfk_6` FOREIGN KEY (`termsandcondition_id`) REFERENCES `xshop_termsandcondition` (`id`),
  ADD CONSTRAINT `xshop_quotation_ibfk_7` FOREIGN KEY (`currency_id`) REFERENCES `xshop_currency` (`id`);

--
-- Constraints for table `xshop_quotation_item`
--
ALTER TABLE `xshop_quotation_item`
  ADD CONSTRAINT `xshop_quotation_item_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_quotation_item_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_quotation_item_ibfk_3` FOREIGN KEY (`quotation_id`) REFERENCES `xshop_quotation` (`id`),
  ADD CONSTRAINT `xshop_quotation_item_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xshop_specifications`
--
ALTER TABLE `xshop_specifications`
  ADD CONSTRAINT `xshop_specifications_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xshop_specifications_ibfk_2` FOREIGN KEY (`application_id`) REFERENCES `xshop_application` (`id`);

--
-- Constraints for table `xshop_taxs`
--
ALTER TABLE `xshop_taxs`
  ADD CONSTRAINT `xshop_taxs_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_taxs_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xshop_termsandcondition`
--
ALTER TABLE `xshop_termsandcondition`
  ADD CONSTRAINT `xshop_termsandcondition_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xshop_termsandcondition_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`);

--
-- Constraints for table `xstore_material_request`
--
ALTER TABLE `xstore_material_request`
  ADD CONSTRAINT `xstore_material_request_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xstore_material_request_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xstore_material_request_ibfk_3` FOREIGN KEY (`orderitem_id`) REFERENCES `xshop_orderdetails` (`id`),
  ADD CONSTRAINT `xstore_material_request_ibfk_4` FOREIGN KEY (`to_department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xstore_material_request_ibfk_5` FOREIGN KEY (`from_department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xstore_material_request_ibfk_6` FOREIGN KEY (`dispatch_to_warehouse_id`) REFERENCES `xstore_warehouse` (`id`),
  ADD CONSTRAINT `xstore_material_request_ibfk_7` FOREIGN KEY (`orderitem_departmental_status_id`) REFERENCES `xshop_orderitem_departmental_status` (`id`);

--
-- Constraints for table `xstore_material_request_items`
--
ALTER TABLE `xstore_material_request_items`
  ADD CONSTRAINT `xstore_material_request_items_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xstore_material_request_items_ibfk_2` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xstore_material_request_items_ibfk_3` FOREIGN KEY (`material_request_jobcard_id`) REFERENCES `xstore_material_request` (`id`),
  ADD CONSTRAINT `xstore_material_request_items_ibfk_4` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xstore_stock`
--
ALTER TABLE `xstore_stock`
  ADD CONSTRAINT `xstore_stock_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xstore_stock_ibfk_2` FOREIGN KEY (`warehouse_id`) REFERENCES `xstore_warehouse` (`id`),
  ADD CONSTRAINT `xstore_stock_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xstore_stock_movement_items`
--
ALTER TABLE `xstore_stock_movement_items`
  ADD CONSTRAINT `xstore_stock_movement_items_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_items_ibfk_2` FOREIGN KEY (`stock_movement_id`) REFERENCES `xstore_stock_movement_master` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_items_ibfk_3` FOREIGN KEY (`item_id`) REFERENCES `xshop_items` (`id`);

--
-- Constraints for table `xstore_stock_movement_master`
--
ALTER TABLE `xstore_stock_movement_master`
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_1` FOREIGN KEY (`created_by_id`) REFERENCES `xhr_employees` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_2` FOREIGN KEY (`jobcard_id`) REFERENCES `xproduction_jobcard` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_3` FOREIGN KEY (`po_id`) REFERENCES `xpurchase_purchase_order` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_4` FOREIGN KEY (`dispatch_request_id`) REFERENCES `xdispatch_dispatch_request` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_5` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_6` FOREIGN KEY (`from_warehouse_id`) REFERENCES `xstore_warehouse` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_7` FOREIGN KEY (`to_warehouse_id`) REFERENCES `xstore_warehouse` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_8` FOREIGN KEY (`from_supplier_id`) REFERENCES `xpurchase_supplier` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_9` FOREIGN KEY (`to_supplier_id`) REFERENCES `xpurchase_supplier` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_10` FOREIGN KEY (`from_memberdetails_id`) REFERENCES `xshop_memberdetails` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_11` FOREIGN KEY (`to_memberdetails_id`) REFERENCES `xshop_memberdetails` (`id`),
  ADD CONSTRAINT `xstore_stock_movement_master_ibfk_12` FOREIGN KEY (`material_request_jobcard_id`) REFERENCES `xstore_material_request` (`id`);

--
-- Constraints for table `xstore_warehouse`
--
ALTER TABLE `xstore_warehouse`
  ADD CONSTRAINT `xstore_warehouse_ibfk_1` FOREIGN KEY (`epan_id`) REFERENCES `epan` (`id`),
  ADD CONSTRAINT `xstore_warehouse_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `xhr_departments` (`id`),
  ADD CONSTRAINT `xstore_warehouse_ibfk_3` FOREIGN KEY (`out_source_party_id`) REFERENCES `xproduction_out_source_parties` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
