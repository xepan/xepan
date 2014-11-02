-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 02, 2014 at 02:27 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xepan-marketing`
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
  `is_frontent_regiatrstion_allowed` tinyint(1) DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  KEY `fk_epan_staff1` (`staff_id`),
  KEY `fk_epan_epan_categories1` (`category_id`),
  FULLTEXT KEY `tags_description_full_text` (`keywords`,`description`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan`
--

INSERT INTO `epan` (`id`, `name`, `staff_id`, `branch_id`, `password`, `fund_alloted`, `created_at`, `category_id`, `company_name`, `contact_person_name`, `mobile_no`, `address`, `city`, `state`, `country`, `email_id`, `keywords`, `description`, `website`, `is_active`, `is_approved`, `last_email_sent`, `allowed_aliases`, `parked_domain`, `email_host`, `email_port`, `email_username`, `email_password`, `email_reply_to`, `email_reply_to_name`, `is_frontent_regiatrstion_allowed`, `user_activation`, `email_threshold`, `user_registration_email_subject`, `user_registration_email_message_body`, `email_transport`, `encryption`, `from_email`, `from_name`, `sender_email`, `sender_name`, `return_path`, `smtp_auto_reconnect`, `emails_in_BCC`, `last_emailed_at`, `email_sent_in_this_minute`) VALUES
(1, 'web', 1, 1, 'admin', '5000000', '2014-01-26', 1, 'Xavoc Technocrats Pvt. Ltd.', 'Xavoc Admin', '+91 8875191258', '18/436, Gayatri marg, Kanji Ka hata, Udaipur, Rajasthan , India', 'Udaipur', 'Rajasthan', 'India', '', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'http://www.xavoc.com', 1, 1, NULL, 1, NULL, '', '', '', '', '', '', 1, 'self_activated', 200, NULL, NULL, 'SendmailTransport', 'ssl', '', '', '', '', '', 0, NULL, NULL, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `epan_components_plugins`
--

INSERT INTO `epan_components_plugins` (`id`, `component_id`, `name`, `event`, `params`, `is_system`) VALUES
(53, 51, 'RemoveContentEditable', 'content-fetched', '$page', 1),
(54, 51, 'RunServerSideComponent', 'content-fetched', '$page', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=233 ;

--
-- Dumping data for table `epan_components_tools`
--

INSERT INTO `epan_components_tools` (`id`, `component_id`, `name`, `is_serverside`, `is_sortable`, `is_resizable`, `display_name`, `order`) VALUES
(208, 51, 'User Panel', 1, 0, 0, NULL, NULL),
(207, 51, 'Html Block', 0, 0, 0, NULL, NULL),
(206, 51, 'Text', 0, 0, 0, NULL, NULL),
(205, 51, 'Title', 0, 0, 0, NULL, NULL),
(204, 51, 'Image', 0, 0, 0, NULL, NULL),
(203, 51, 'Container', 0, 1, 0, NULL, NULL),
(202, 51, 'Row', 0, 1, 0, NULL, NULL),
(201, 51, 'Column', 0, 1, 0, NULL, NULL),
(200, 51, 'Template Content Region', 0, 1, 0, NULL, NULL);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

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
(33, 1, 77, 1, NULL, '2014-10-24');

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
(1, 0, 'home', 'Home', 1, 0, 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '', '; cursor: default;', NULL, '2014-11-02 14:23:58', 'public', 1);

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
