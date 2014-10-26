-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 26, 2014 at 01:49 PM
-- Server version: 5.5.38
-- PHP Version: 5.3.10-1ubuntu3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xepanai`
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
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `branch`
--

INSERT INTO `branch` (`id`, `name`, `points`, `owner_name`, `mobile_number`, `address`, `created_at`, `email_id`) VALUES
(1, 'Default', '500000', 'Xavoc Technocrats', '+91 8875191258', '18/436 Gayatri Marg, Kanji Ka Hata, Dhabai Ji Ka Wada, udaipur', '2011-12-12', 'info@xavoc.com');

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
  `email_from` varchar(255) DEFAULT NULL,
  `email_from_name` varchar(255) DEFAULT NULL,
  `is_frontent_regiatrstion_allowed` tinyint(1) DEFAULT NULL,
  `user_activation` varchar(255) DEFAULT NULL,
  `email_threshold` varchar(255) DEFAULT NULL,
  `user_registration_email_subject` varchar(255) DEFAULT NULL,
  `user_registration_email_message_body` text,
  PRIMARY KEY (`id`),
  KEY `fk_epan_staff1` (`staff_id`),
  KEY `fk_epan_epan_categories1` (`category_id`),
  FULLTEXT KEY `tags_description_full_text` (`keywords`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan`
--

INSERT INTO `epan` (`id`, `name`, `staff_id`, `branch_id`, `password`, `fund_alloted`, `created_at`, `category_id`, `company_name`, `contact_person_name`, `mobile_no`, `address`, `city`, `state`, `country`, `email_id`, `keywords`, `description`, `website`, `is_active`, `is_approved`, `last_email_sent`, `allowed_aliases`, `parked_domain`, `email_host`, `email_port`, `email_username`, `email_password`, `email_reply_to`, `email_reply_to_name`, `email_from`, `email_from_name`, `is_frontent_regiatrstion_allowed`, `user_activation`, `email_threshold`, `user_registration_email_subject`, `user_registration_email_message_body`) VALUES
(1, 'web', 1, 1, 'admin', '5000000', '2014-01-26', 1, 'Xavoc Technocrats Pvt. Ltd.', 'Xavoc Admin', '+91 8875191258', '18/436, Gayatri marg, Kanji Ka hata, Udaipur, Rajasthan , India', 'Udaipur', 'Rajasthan', 'India', '', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'http://www.xavoc.com', 1, 1, NULL, 1, NULL, 'ssl://mail.xavoc.com', '465', 'developer@xavoc.com', 'Developer@123', 'developer@xavoc.com', 'xEpan Support System', 'developer@xavoc.com', 'xEpan Support System', 1, 'self_activated', '200', NULL, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan_aliases`
--

INSERT INTO `epan_aliases` (`id`, `epan_id`, `name`) VALUES
(1, 1, 'web');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=78 ;

--
-- Dumping data for table `epan_components_marketplace`
--

INSERT INTO `epan_components_marketplace` (`id`, `name`, `allowed_children`, `specific_to`, `namespace`, `type`, `is_system`, `description`, `default_enabled`, `has_toolbar_tools`, `has_owner_modules`, `has_plugins`, `has_live_edit_app_page`, `git_path`, `initialize_and_clone_from_git`, `category`) VALUES
(51, 'Basic Web Elements And Plugins', '0', '0', 'baseElements', 'element', 1, '0', 1, 1, 0, NULL, 0, '', 0, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `epan_components_plugins`
--

INSERT INTO `epan_components_plugins` (`id`, `component_id`, `name`, `event`, `params`, `is_system`) VALUES
(55, 51, 'RemoveContentEditable', 'content-fetched', '$page', 1),
(56, 51, 'RunServerSideComponent', 'content-fetched', '$page', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=240 ;

--
-- Dumping data for table `epan_components_tools`
--

INSERT INTO `epan_components_tools` (`id`, `component_id`, `name`, `is_serverside`, `is_sortable`, `is_resizable`, `display_name`, `order`) VALUES
(231, 51, 'Template Content Region', 0, 1, 0, NULL, NULL),
(232, 51, 'Column', 0, 1, 0, NULL, NULL),
(233, 51, 'Row', 0, 1, 0, NULL, NULL),
(234, 51, 'Container', 0, 1, 0, NULL, NULL),
(235, 51, 'Image', 0, 0, 0, NULL, NULL),
(236, 51, 'Title', 0, 0, 0, NULL, NULL),
(237, 51, 'Text', 0, 0, 0, NULL, NULL),
(238, 51, 'Html Block', 0, 0, 0, NULL, NULL),
(239, 51, 'User Panel', 1, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `epan_data_grabber`
--

CREATE TABLE IF NOT EXISTS `epan_data_grabber` (
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
  `created_at` datetime DEFAULT NULL,
  `last_run_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `result_format` varchar(255) DEFAULT NULL,
  `json_url_key` varchar(255) DEFAULT NULL,
  `reg_ex_on_href` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan_data_grabber`
--

INSERT INTO `epan_data_grabber` (`id`, `epan_id`, `name`, `site_url`, `query_parameter`, `paginator_parameter`, `paginator_initial_value`, `records_per_page`, `paginator_based_on`, `extra_url_parameters`, `required_pause_between_hits`, `result_selector`, `created_at`, `last_run_at`, `is_active`, `result_format`, `json_url_key`, `reg_ex_on_href`) VALUES
(1, 1, 'http://www.google.co.in', 'http://google.com/search', 'q', 'start', '0', '10', 'records', '', '10', '#ires', '2014-10-20 15:16:16', '2014-10-20 20:21:40', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `epan_data_search_phrase`
--

CREATE TABLE IF NOT EXISTS `epan_data_search_phrase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_grabber_id` int(11) DEFAULT NULL,
  `subscription_category_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `max_record_visit` varchar(255) DEFAULT NULL,
  `max_domain_depth` varchar(255) DEFAULT NULL,
  `max_page_depth` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `page_parameter_start_value` varchar(255) DEFAULT NULL,
  `page_parameter_max_value` varchar(255) DEFAULT NULL,
  `last_page_checked_at` datetime DEFAULT NULL,
  `content_provided` text,
  PRIMARY KEY (`id`),
  KEY `fk_data_grabber_id` (`data_grabber_id`),
  KEY `fk_subscription_category_id` (`subscription_category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
  KEY `fk_template_id` (`template_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `epan_page`
--

INSERT INTO `epan_page` (`id`, `parent_page_id`, `name`, `menu_caption`, `epan_id`, `is_template`, `title`, `description`, `keywords`, `content`, `body_attributes`, `created_on`, `updated_on`, `access_level`, `template_id`) VALUES
(1, 0, 'home', 'Home', 1, 0, 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '', NULL, NULL, '2014-10-25 17:18:04', 'public', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan_page_snapshots`
--

INSERT INTO `epan_page_snapshots` (`id`, `epan_page_id`, `created_on`, `updated_on`, `title`, `keywords`, `description`, `body_attributes`, `content`, `name`) VALUES
(1, 1, '2014-09-29 10:00:31', '2014-09-29 10:00:31', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'cursor: auto; overflow: auto; background-color: rgb(255, 255, 255);', '<div id="08dad680-8429-4da9-b706-d3160de0d8dd" component_namespace="baseElements" component_type="Container" class="epan-container  epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding" style=" ">   <div id="4f31de8a-0ddb-46d7-f93a-cd2dc3fe2a65" component_namespace="baseElements" component_type="Title" class="epan-component component-outline" style=" ">   <h3 class="editor editor-attached" contenteditable="true">Container in no IBlock<br>\n</h3> </div>\n</div>\n<div id="e843134f-e3bf-43de-ab35-4bb091565305" data-dimesion-id="1" component_namespace="Ai" component_type="IntelligentBlock" class="epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding" style=" "><div id="005eafc4-3fac-4c89-a79a-07adf69d421b" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding" style=" ">    <div id="4d4162aa-1db2-41d7-aff9-93da30b1e1c8" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding" span="4" style=" ">   <div id="a755d5c2-0d3d-4e3b-fa6a-4f7dd9fa4697" data-dimesion-id="1" component_namespace="Ai" component_type="IntelligentBlock" class="epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding" style=" ">   <div id="47971366-fd18-41cf-baf0-8c19a8a9c936" component_namespace="baseElements" component_type="Title" class="epan-component  component-outline" style=" ">  <h3 class="editor" contenteditable="true">This is Title 1<br></h3> </div></div></div><div id="46229782-f5e1-4008-f5a8-3f2353e944a3" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding" span="4" style=" ">   <div id="7e467c96-8b48-4b31-ef29-2f13e96b278c" data-dimesion-id="1" component_namespace="Ai" component_type="IntelligentBlock" class="epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding" style=" ">   <div id="67043a51-88f8-449f-9285-c51375cb8c3f" component_namespace="baseElements" component_type="Title" class="epan-component  component-outline" style=" ">  <h3 class="editor" contenteditable="true">This is Title 2<br></h3> </div></div></div><div id="451e844c-571c-4c7a-d082-5ae54ef2b015" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding" span="4" style=" ">   <div id="e6f6b921-343c-4e6f-964c-a7a292bb2d73" data-dimesion-id="1" component_namespace="Ai" component_type="IntelligentBlock" class="epan-sortable-component epan-component  ui-sortable component-outline epan-sortable-extra-padding" style=" ">   <div id="813e7c3e-77ff-47e7-e63c-d7eb2748489c" component_namespace="baseElements" component_type="Title" class="epan-component  component-outline" style=" ">  <h3 class="editor" contenteditable="true">This is Title 3<br></h3> </div></div></div></div></div>', 'A');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `epan_templates`
--

INSERT INTO `epan_templates` (`id`, `epan_id`, `name`, `body_attributes`, `content`, `is_current`, `css`) VALUES
(1, 1, 'default', NULL, '<div id="6b9c7e51-526c-41f1-c404-66b136b60a83" component_namespace="baseElements" component_type="TemplateContentRegion" class="epan-sortable-component epan-component  ui-sortable" style="" contenteditable="false">   {{Content}} </div>', 1, NULL);

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
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `type` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `last_login_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
