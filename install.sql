-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 20, 2014 at 12:52 PM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xepan105`
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
(1, 'web', 1, 1, 'admin', '5000000', '2014-01-26', 1, 'Xavoc Technocrats Pvt. Ltd.', 'Xavoc Admin', '+91 8875191258', '18/436, Gayatri marg, Kanji Ka hata, Udaipur, Rajasthan , India', 'Udaipur', 'Rajasthan', 'India', '', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'http://www.xavoc.com', 1, 1, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 200, '', '', 'SmtpTransport', 'ssl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=79 ;

--
-- Dumping data for table `epan_components_marketplace`
--

INSERT INTO `epan_components_marketplace` (`id`, `name`, `allowed_children`, `specific_to`, `namespace`, `type`, `is_system`, `description`, `default_enabled`, `has_toolbar_tools`, `has_owner_modules`, `has_plugins`, `has_live_edit_app_page`, `git_path`, `initialize_and_clone_from_git`, `category`) VALUES
(51, 'Basic Web Elements And Plugins', '0', '0', 'baseElements', 'element', 1, '0', 1, 1, 0, NULL, 0, '0', 0, NULL),
(67, 'Developer Zone', '0', '0', 'developerZone', 'application', 0, '0', 1, 0, 0, NULL, 0, '0', 0, NULL),
(71, 'Extended Element', '0', '0', 'ExtendedElement', 'module', 0, '0', 1, 1, 0, NULL, 0, '0', 0, NULL),
(69, 'Enquiry And Subscriptions', '0', '0', 'xEnquiryNSubscription', 'application', 0, '0', 1, 1, 0, NULL, 0, '0', 0, NULL),
(70, 'xAtrificial Intelligence', '0', '0', 'xAi', 'application', 0, '0', 1, 1, 1, NULL, 0, 'https://github.com/xepan/xAi.git', 1, NULL),
(72, 'Slide Shows', '0', '0', 'slideShows', 'application', 0, '0', 1, 1, 0, NULL, 0, '0', 1, NULL),
(73, 'Extended Images', '0', '0', 'extendedImages', 'module', 0, '0', 1, 1, 0, NULL, 0, '0', 0, NULL),
(74, 'Image Galley', '0', '0', 'xImageGallery', 'application', 0, '0', 1, 1, 0, NULL, 0, 'https://github.com/xepan/xImageGallery', 1, NULL),
(75, 'xMarketingCampaign', '0', '0', 'xMarketingCampaign', 'application', 0, '0', 1, 0, 0, NULL, 0, 'https://github.com/xepan/xMarketingCampaign', 0, NULL),
(76, 'Menus', '0', '0', 'xMenus', 'application', 0, '0', 1, 1, 0, NULL, 0, '0', 0, NULL),
(77, 'xShop & Blog', '0', '0', 'xShop', 'application', 0, '0', 1, 1, 0, NULL, 0, 'https://github.com/xepan/xShop', 1, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `epan_components_plugins`
--

INSERT INTO `epan_components_plugins` (`id`, `component_id`, `name`, `event`, `params`, `is_system`) VALUES
(58, 51, 'RunServerSideComponent', 'content-fetched', '$page', 1),
(57, 51, 'RemoveContentEditable', 'content-fetched', '$page', 1),
(62, 70, 'ImplementIntelligence', 'beforeTemplateInit', '$page', 0),
(61, 70, 'BeforeSaveIBlockExtract', 'epan-page-before-save', '$page', 0),
(63, 77, 'Register Event', 'register-event', '$events_array', 0),
(64, 69, 'RegisterEvent', 'register-event', '$events_obj', 0);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=305 ;

--
-- Dumping data for table `epan_components_tools`
--

INSERT INTO `epan_components_tools` (`id`, `component_id`, `name`, `is_serverside`, `is_sortable`, `is_resizable`, `display_name`, `order`) VALUES
(304, 77, 'Add Block', 1, 0, 0, '', 8),
(294, 73, 'Image With Description 1', 0, 0, 0, '', 0),
(285, 70, 'IntelligentBlock', 0, 1, 0, 'IBlock', 0),
(252, 51, 'Template Content Region', 0, 1, 0, '', 9),
(251, 51, 'Column', 0, 1, 0, '', 3),
(250, 51, 'User Panel', 1, 0, 0, '', 8),
(284, 69, 'unSubscribe', 1, 0, 0, 'Un Subscriber', 4),
(283, 69, 'EnquiryForm', 0, 0, 0, '', 1),
(249, 51, 'Html Block', 0, 0, 0, '', 7),
(248, 51, 'Text', 0, 0, 0, '', 5),
(287, 71, 'PopupTooltip', 0, 0, 0, 'Popup Window', 2),
(291, 72, 'WaterWheelCarousel', 1, 0, 0, '', 0),
(290, 72, 'BootStrap Carousel', 0, 0, 0, '', 0),
(289, 72, 'AwesomeSlider', 1, 0, 0, '', 0),
(293, 73, 'xSVG', 0, 0, 0, '', 0),
(295, 74, 'GoogleImageGallery', 1, 0, 0, '', 0),
(296, 76, 'Bootstrap Menus', 0, 0, 0, '', 0),
(303, 77, 'Member Account', 1, 0, 0, '', 7),
(247, 51, 'Title', 0, 0, 0, '', 4),
(246, 51, 'Image', 0, 0, 0, '', 6),
(245, 51, 'Container', 0, 1, 0, '', 1),
(244, 51, 'Row', 0, 1, 0, '', 2),
(286, 71, 'Marquee', 0, 1, 0, '', 1),
(282, 69, 'SubscriptionModule', 1, 0, 0, '', 3),
(281, 69, 'CustomeForm', 1, 0, 0, '', 2),
(302, 77, 'Checkout', 1, 0, 0, '', 6),
(301, 77, 'Search', 1, 0, 0, '', 5),
(300, 77, 'xCart', 1, 0, 0, '', 4),
(299, 77, 'Category', 1, 0, 0, '', 1),
(298, 77, 'Product', 1, 0, 0, '', 2),
(297, 77, 'ProductDetail', 1, 0, 0, '', 3),
(288, 72, 'ThumbnailSlider', 1, 0, 0, '', 0),
(292, 72, 'TransformGallery', 1, 0, 0, '3D transforms', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `epan_page`
--

INSERT INTO `epan_page` (`id`, `parent_page_id`, `name`, `menu_caption`, `epan_id`, `is_template`, `title`, `description`, `keywords`, `content`, `body_attributes`, `created_on`, `updated_on`, `access_level`, `template_id`) VALUES
(1, NULL, 'home', 'Home', 1, 0, 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '<div id="456df3c0-451b-4fbb-e82d-a7180942ebd4" component_namespace="baseElements" component_type="Container" class="epan-container  epan-sortable-component epan-component  ui-sortable component-outline" style=" "> 	 <div data-extra-classes="text-center" id="55a14c2c-ced3-4b2a-b98c-baec52d97a64" component_namespace="baseElements" component_type="Text" class="editor epan-component  text-center editor-attached component-outline" style="font-size: 21px;" contenteditable="true">I AM HOME PAGE, TRY DOUBLE CLICKING ANYTHING AND PLAY :)<br>xEpan CMS your one stop solution for all your Digital Presence. .. changed<br>Remarkable features that sets us apart ...&nbsp;<br><br>\n</div>\n<div data-options="2" id="1c25df5d-c555-4220-e8ea-a03e138616d1" component_namespace="xEnquiryNSubscription" component_type="CustomeForm" data-responsible-namespace="xEnquiryNSubscription" data-responsible-view="View_Tools_CustomeForm" data-is-serverside-component="true" class="epan-component component-outline" style=""></div>\n<div id="5bc2c88f-807f-46c9-affe-904517c39390" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable component-outline" style=" "> 	 \n<div id="fbe6151e-af04-4880-a314-9e4c20c50d59" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable component-outline" span="4" style=" "> 	 <div id="610067cb-63e3-4e88-be24-0d1b79b4036d" component_namespace="baseElements" component_type="Image" class="epan-component component-outline" style=" "> 	<img src="epans/web/untitled%20folder/draganddrop.jpg" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n<div data-extra-classes="text-center" id="ea9fdc29-ae9e-475f-a298-d04285dfe5ae" component_namespace="baseElements" component_type="Text" class="text-center" style="font-family: Aclonica; font-size: 16px;" contenteditable="true"> 	Default Text </div>\n<div id="01ec8a02-e9ec-4c5d-e716-b10ac7d5ce96" component_namespace="baseElements" component_type="HtmlBlock" class="epan-component component-outline" style=" "> 	<i>Double click me to get <b>option</b> and change my html</i> </div>\n</div><div id="fbe6151e-af04-4880-a314-9e4c20c50d59" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable component-outline" span="4" style=" "> 	 \n\n<div id="610067cb-63e3-4e88-be24-0d1b79b4036d" component_namespace="baseElements" component_type="Image" class="epan-component component-outline" style=" "> 	<img src="epans/web/s1.png" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n<div id="fbe6151e-af04-4880-a314-9e4c20c50d59" component_namespace="baseElements" component_type="Column" class="col-md-4  epan-sortable-component epan-component  ui-sortable component-outline" span="4" style=" "> 	 <div id="610067cb-63e3-4e88-be24-0d1b79b4036d" component_namespace="baseElements" component_type="Image" class="epan-component component-outline" style=" "> 	<img src="epans/web/untitled%20folder/marketplace.jpg" style="max-width:100%; height: auto; width:100%" data-extra-classes="" class="ui-resizable">\n</div>\n</div>\n</div>\n</div>\n<link style="" href="http://fonts.googleapis.com/css?family=Aclonica" rel="stylesheet" type="text/css">\n<link style="" href="http://fonts.googleapis.com/css?family=Allan" rel="stylesheet" type="text/css">\n<link style="" href="http://fonts.googleapis.com/css?family=Annie+Use+Your+Telescope" rel="stylesheet" type="text/css">\n<link style="" href="http://fonts.googleapis.com/css?family=Anonymous+Pro" rel="stylesheet" type="text/css">\n<link style="" href="http://fonts.googleapis.com/css?family=Allerta+Stencil" rel="stylesheet" type="text/css">\n<link style="" href="http://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet" type="text/css">\n<link style="" href="http://fonts.googleapis.com/css?family=Anton" rel="stylesheet" type="text/css">', 'cursor: default;; cursor: default;; cursor: default; overflow: auto;', NULL, '2014-12-19 07:58:23', '0', 1),
(8, NULL, 'about', 'About Us', 1, 0, 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '<div data-extra-classes="text-center" id="2799440b-45ef-4842-fd24-ce8b9831b34d" component_namespace="baseElements" component_type="Text" class="editor epan-component  text-center editor-attached" style=" " contenteditable="true"> 	Play with me here or Remove the page from DASHBOARD &gt; Epan Pages Menu<br>\n</div>', 'cursor: default;; cursor: default;', '2014-11-20 12:50:43', '2014-12-18 15:02:08', '0', 1),
(9, NULL, 'contact', 'Contact', 1, 0, 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', 'World''s best and easiest cms :)', 'xEpan CMS, an innovative approach towards Drag And Drop CMS.', '<div id="a1bb10d8-f38c-4eac-d5f8-f24947e42fe4" component_namespace="baseElements" component_type="Container" class="epan-container  epan-sortable-component epan-component  ui-sortable" style=" "> 	 <div id="903ebc03-8b7a-43d4-a228-0068cac03b80" component_namespace="baseElements" component_type="Text" class="editor epan-component  editor-attached" style=" " contenteditable="true">Below is HTML TEXT (Copy Past of Google Map Code). You cannot select it by double clicking so .. Lets Try Some keyboard shortcuts<br>TAB = Select Next Component<br>SHIFT+TAB = Select Previous Component<br>F1 = For more shortcuts and help <br><br>\n</div>\n<div id="7de184c0-aadf-4a04-b2c7-d34a44e85b00" component_namespace="baseElements" component_type="HtmlBlock" class="epan-component" style=" "><iframe scrolling="no" src="https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Xavoc+Technocrats+Pvt.+Ltd.,+University+Road+Udaipur,+Rajasthan&amp;aq=t&amp;sll=24.587202,73.710801&amp;sspn=0.185131,0.338173&amp;ie=UTF8&amp;hq=&amp;hnear=&amp;ll=24.588776,73.714278&amp;spn=0.006295,0.006295&amp;t=m&amp;iwloc=A&amp;output=embed" marginwidth="0" marginheight="0" frameborder="0" height="350" width="100%"></iframe></div>\n\n<div id="c1ef9bad-353b-460a-db02-70b26bd83cd3" component_namespace="baseElements" component_type="Row" class="row  epan-sortable-component epan-component  ui-sortable" style="margin-top: 10px;"> 	 \n<div id="421ed8b1-6ced-4568-ddaa-72d38fbf341f" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-4" span="4" style=" "> 	 \n<div data-extra-classes="alert alert-info" id="18d1c1b6-8647-4e73-edc1-fab592dc497a" component_namespace="baseElements" component_type="Text" class="editor epan-component  alert alert-info editor-attached" style=" " contenteditable="true"> 	Get in Touch<br>(See Bootstrap classes on me in options)<br>\n</div>\n<div data-extra-classes="text-center" id="6d46601e-34a9-41a4-da91-62b2c6be1fb6" component_namespace="baseElements" component_type="Text" class="editor epan-component text-center editor-attached" style=" " contenteditable="true">Below is Server side component. Double click it and click Server Side button to play more with it.<br>\n</div>\n<div data-options="1" id="e74c1f70-76e2-4972-ab37-1789fe2f81a7" component_namespace="xEnquiryNSubscription" component_type="CustomeForm" data-responsible-namespace="xEnquiryNSubscription" data-responsible-view="View_Tools_CustomeForm" data-is-serverside-component="true" class="epan-component" style=""></div>\n</div>\n<div id="421ed8b1-6ced-4568-ddaa-72d38fbf341f" component_namespace="baseElements" component_type="Column" class="epan-sortable-component epan-component  ui-sortable col-md-8" span="8" style=" "> 	 \n<div data-extra-classes="" id="86dd9a1a-1fd9-4ef1-ea17-5deacd90e659" component_namespace="baseElements" component_type="Text" class="editor epan-component  editor-attached" style="font-size: 16px;" contenteditable="true"> 	xEpan CMS<br><div data-extra-classes="panel penel-info" id="e8e1f8a9-4c95-41e7-f74b-cdb75147d58d" class="editor epan-component panel penel-info editor-attached" style="font-size: 15px; font-family: Allerta; margin-top: 21px;" contenteditable="false"> 	<b>Reg</b>. Office: 18/436, Gaytri Marg, Kanji ka hata, <br> Dhabai Ji ka wada, <br> Udaipur (Rajasthan) -313001 (INDIA) </div>\n<div data-extra-classes="panel penel-info" id="e8e1f8a9-4c95-41e7-f74b-cdb75147d58d" class="editor epan-component editor-attached panel penel-info" style="font-size: 16px; font-family: Allerta; margin-top: 21px;" contenteditable="false"> 	<b>Head.</b> Office: 17, First Floor, sai Darshan Complex, Opp Eden International School University Road,<br>&nbsp;Udaipur (Rajasthan) -313001 (INDIA) </div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n\n\n\n			<b class="glyphicon glyphicon-envelope">    Email</b>: support@xepan.org<br>&nbsp;<br><p class=""><b class="glyphicon glyphicon-earphone"> Management:&nbsp; + 91<b>-</b>9782-300-801 </b><br><b class="glyphicon glyphicon-earphone"> Technical: &nbsp;&nbsp; +&nbsp; </b>91-8875-191-258 </p> </div>\n</div>\n</div>\n</div>', 'cursor: default; overflow: auto;', '2014-11-20 12:51:00', '2014-12-18 15:02:08', '0', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `epan_templates`
--

INSERT INTO `epan_templates` (`id`, `epan_id`, `name`, `body_attributes`, `content`, `is_current`, `css`) VALUES
(1, 1, 'default', 'cursor: default;', '<div id="6b9c7e51-526c-41f1-c404-66b136b60a83" component_namespace="baseElements" component_type="TemplateContentRegion" class="epan-sortable-component epan-component  ui-sortable" style="display: block; opacity: 1; margin-bottom: 5px; height: auto;" contenteditable="false">~~Content~~<div style="top: -33px; left: 1259px; display: block;" class="tooltip fade top in"><div class="tooltip-arrow"></div><div class="tooltip-inner">TemplateContentRegion</div></div></div>', 1, NULL);

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
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `slideshows_awesomeimages`
--

INSERT INTO `slideshows_awesomeimages` (`id`, `gallery_id`, `image`, `tag`, `order_no`, `effects`, `is_publish`) VALUES
(2, 2, 'epans/web/untitled%20folder/xRobo.png', '', 1, NULL, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `slideshows_awesomeslider`
--

INSERT INTO `slideshows_awesomeslider` (`id`, `epan_id`, `name`, `pause_time`, `on_hover`, `control_nav`, `image_paginator`, `folder_path`, `is_publish`) VALUES
(2, 1, 'Demo', '3000', 1, 1, NULL, '', 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
-- Table structure for table `userappaccess`
--

CREATE TABLE IF NOT EXISTS `userappaccess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `is_allowed` tinyint(1) DEFAULT NULL,
  `installed_app_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_installed_app_id` (`installed_app_id`)
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
  `type` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `last_login_date` date DEFAULT NULL,
  `user_management` tinyint(1) DEFAULT NULL,
  `general_settings` tinyint(1) DEFAULT NULL,
  `application_management` tinyint(1) DEFAULT NULL,
  `website_desinging` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=537 ;

--
-- Dumping data for table `xai_data`
--

INSERT INTO `xai_data` (`id`, `session_id`, `name`) VALUES
(1, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(2, 2, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(3, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(4, 2, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(5, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/"}}}'),
(6, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(7, 3, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(8, 4, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(9, 5, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(10, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(11, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(12, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(13, 6, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=xAi_page_owner_main"}}}'),
(14, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(15, 7, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/theroundtable\\/"}}}'),
(16, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(17, 8, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/theroundtable\\/"}}}'),
(18, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(19, 9, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/theroundtable\\/"}}}'),
(20, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(21, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(22, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(23, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(24, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(25, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(26, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(27, 10, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(28, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(29, 11, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/"}}}'),
(30, 11, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(31, 11, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(32, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/theroundtable\\/?page=xMarketingCampaign_page_owner_main"}}}'),
(33, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(34, 13, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(35, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(36, 14, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(37, 13, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(38, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(39, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/theroundtable\\/?page=xMarketingCampaign_page_owner_main"}}}'),
(40, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(41, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(42, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(43, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(44, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(45, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(46, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=xMarketingCampaign_page_owner_main"}}}'),
(47, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=xMarketingCampaign_page_owner_main"}}}'),
(48, 15, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=xMarketingCampaign_page_owner_main"}}}'),
(49, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(50, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(51, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(52, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=owner_users"}}}'),
(53, 16, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(54, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=owner_dashboard"}}}'),
(55, 17, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=owner_dashboard"}}}'),
(56, 17, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(57, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(58, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(59, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(60, 18, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=owner_dashboard"}}}'),
(61, 18, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(62, 18, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(63, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?epan=web&subpage=about"}}}'),
(64, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(65, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(66, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(67, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(68, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(69, 19, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(70, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(71, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(72, 20, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(73, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(74, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(75, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(76, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(77, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(78, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(79, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(80, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(81, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(82, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(83, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(84, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(85, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(86, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(87, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(88, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(89, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(90, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(91, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(92, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(93, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(94, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(95, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(96, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(97, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=owner_dashboard"}}}'),
(98, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/index.php"}}}'),
(99, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/index.php"}}}'),
(100, 21, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/index.php?edit_template=1"}}}'),
(101, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/index.php?subpage=home"}}}'),
(102, 22, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(103, 23, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=owner_dashboard"}}}'),
(104, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(105, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(106, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(107, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(108, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(109, 24, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/theroundtable\\/?page=slideShows_page_owner_main"}}}'),
(110, 25, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=xShop_page_owner_main"}}}'),
(111, 24, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(112, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(113, 24, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(114, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(115, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(116, 26, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(117, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(118, 27, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(119, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(120, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(121, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(122, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(123, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(124, 28, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(125, 29, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(126, 28, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(127, 28, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(128, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(129, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(130, 30, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(131, 30, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(132, 30, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(133, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(134, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(135, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(136, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(137, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(138, 31, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(139, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(140, 31, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(141, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(142, 31, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(143, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(144, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(145, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(146, 32, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(147, 32, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(148, 32, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(149, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(150, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(151, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"theroundtable.in"}}}'),
(152, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(153, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(154, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(155, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(156, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(157, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(158, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(159, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(160, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(161, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"theroundtable.in"}}}'),
(162, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(163, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(164, 33, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/"}}}'),
(165, 33, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(166, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(167, 33, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(168, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(169, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(170, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(171, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(172, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(173, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(174, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(175, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(176, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(177, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/theroundtable.in\\/?page=xMarketingCampaign_page_owner_main"}}}'),
(178, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(179, 34, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/theroundtable\\/?page=xEnquiryNSubscription_page_owner_form"}}}'),
(180, 34, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(181, 34, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(182, 34, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(183, 34, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(184, 34, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(185, 34, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(186, 34, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(187, 34, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(188, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(189, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(190, 35, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/l.facebook.com\\/l.php?u=http%3A%2F%2Ftheroundtable.in%2F&h=6AQEphXF7&s=1"}}}'),
(191, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(192, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(193, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(194, 36, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(195, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(196, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(197, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/www.google.co.in\\/url?sa=t&rct=j&q=&esrc=s&source=web&cd=40&ved=0COABEBYwJw&url=http%3A%2F%2Ftheroundtable.in%2F&ei=mYWCVMDBJoWUuASgnIKIAw&usg=AFQjCNHcGMvqmHhzu6_Gvhsmm4ZB3N9pEQ&sig2=1WbJyZ7MBTbe2LSUngs_rw"}}}'),
(198, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(199, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(200, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(201, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(202, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(203, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(204, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(205, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(206, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(207, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(208, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(209, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(210, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(211, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(212, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(213, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(214, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(215, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(216, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(217, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(218, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(219, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(220, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(221, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(222, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(223, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(224, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(225, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(226, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(227, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(228, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(229, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(230, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(231, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(232, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(233, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(234, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(235, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(236, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(237, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(238, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(239, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(240, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(241, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(242, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(243, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(244, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(245, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(246, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(247, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(248, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(249, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(250, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(251, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(252, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(253, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(254, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(255, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(256, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(257, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(258, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(259, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(260, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(261, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(262, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/"}}}'),
(263, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/index.php?subpage=about"}}}'),
(264, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/"}}}'),
(265, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/index.php?subpage=about"}}}'),
(266, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/"}}}'),
(267, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/index.php?subpage=about"}}}'),
(268, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/index.php?subpage=about"}}}'),
(269, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/index.php?subpage=about"}}}'),
(270, 37, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_dashboard"}}}'),
(271, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_users"}}}'),
(272, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_users"}}}'),
(273, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(274, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(275, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(276, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(277, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(278, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(279, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(280, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(281, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(282, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(283, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(284, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(285, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(286, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(287, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(288, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(289, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(290, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(291, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(292, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(293, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(294, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(295, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(296, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(297, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(298, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(299, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(300, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(301, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(302, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(303, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(304, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(305, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(306, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(307, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(308, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(309, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(310, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(311, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(312, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(313, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(314, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(315, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(316, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(317, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(318, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(319, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(320, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(321, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(322, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(323, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(324, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(325, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(326, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(327, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(328, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(329, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(330, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(331, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(332, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(333, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(334, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(335, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(336, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(337, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(338, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(339, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(340, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(341, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(342, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(343, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(344, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(345, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(346, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(347, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(348, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(349, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(350, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(351, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(352, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(353, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(354, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(355, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(356, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(357, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(358, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(359, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(360, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(361, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(362, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(363, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(364, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(365, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(366, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(367, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(368, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(369, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(370, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(371, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(372, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(373, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(374, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(375, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(376, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(377, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(378, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(379, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(380, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(381, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(382, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(383, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(384, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(385, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(386, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(387, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(388, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(389, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(390, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(391, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(392, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(393, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(394, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(395, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(396, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(397, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(398, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(399, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(400, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(401, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(402, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(403, 38, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(404, 39, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=xEnquiryNSubscription_page_owner_subscriptions"}}}'),
(405, 40, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=developerZone_page_owner_component_edit&component=baseElements"}}}'),
(406, 41, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_dashboard"}}}'),
(407, 41, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(408, 41, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(409, 41, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(410, 41, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(411, 41, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(412, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(413, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(414, 42, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/192.168.1.101\\/xep\\/?page=xMarketingCampaign_page_owner_main"}}}'),
(415, 42, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(416, 42, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(417, 42, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(418, 42, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(419, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(420, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(421, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(422, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(423, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(424, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(425, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(426, 43, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(427, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/whois.domaintools.com\\/theroundtable.in"}}}'),
(428, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(429, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(430, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(431, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(432, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(433, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(434, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(435, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(436, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(437, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(438, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(439, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(440, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(441, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(442, 44, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=xMarketingCampaign\\/page\\/owner\\/campaigns\\/subscriptionDate_based_schedule&xmarketingcampaign_campaigns_id=2"}}}'),
(443, 44, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(444, 44, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(445, 44, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(446, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner\\/users"}}}'),
(447, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_users"}}}'),
(448, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_users"}}}'),
(449, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_users"}}}'),
(450, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_users"}}}'),
(451, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_users"}}}'),
(452, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_users"}}}'),
(453, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_users"}}}'),
(454, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_users"}}}'),
(455, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=xMarketingCampaign_page_owner_campaigns_subscriptionDate_based_schedule&xmarketingcampaign_campaigns_id=2"}}}'),
(456, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner\\/users"}}}'),
(457, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner\\/epantemplates"}}}'),
(458, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(459, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(460, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(461, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(462, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(463, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(464, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(465, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(466, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(467, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(468, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(469, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(470, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(471, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(472, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(473, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(474, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(475, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(476, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(477, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(478, 45, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(479, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/localhost\\/atk4.3\\/?page=owner_dashboard"}}}'),
(480, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(481, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(482, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(483, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(484, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(485, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(486, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(487, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(488, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(489, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(490, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(491, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(492, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(493, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(494, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(495, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(496, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(497, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(498, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(499, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(500, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(501, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(502, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(503, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(504, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(505, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(506, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(507, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(508, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(509, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(510, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(511, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(512, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(513, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(514, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(515, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(516, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(517, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(518, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(519, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(520, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(521, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(522, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(523, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(524, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(525, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(526, 47, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}},"SERVER":{"HTTP_REFERER":{"meta_data_id":"37","value":"http:\\/\\/192.168.1.101\\/atk4.3\\/?page=owner_dashboard"}}}'),
(527, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(528, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(529, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(530, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(531, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(532, 46, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(533, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(534, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(535, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}'),
(536, 1, '{"ALWAYS":{"ALWAYS":{"meta_data_id":"1","value":"RUN"}}}');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xai_dimension`
--

INSERT INTO `xai_dimension` (`id`, `epan_id`, `name`) VALUES
(1, 1, 'Default');

-- --------------------------------------------------------

--
-- Table structure for table `xai_Human`
--

CREATE TABLE IF NOT EXISTS `xai_Human` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=349 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `xai_informationextractor`
--

INSERT INTO `xai_informationextractor` (`id`, `meta_data_id`, `name`, `code`, `order`, `repetation_handler`, `mark_triggering_information`, `is_active`) VALUES
(1, 1, 'Country', '$loc_info = @file_get_contents(''http://ipinfo.io/''.$_SERVER[''REMOTE_ADDR''].''/json'');\r\n$loc_info = json_decode($loc_info,true);\r\n$result=$loc_info[''country''];', 0, 'discard_if_repeated_key', 1, 0),
(2, 1, 'City', '$result=$loc_info[''city''];', 1, 'discard_if_repeated_key', 1, NULL),
(3, 1, 'Browser', '$browser = $this->add(''xAi/Controller_Utility'')->getBrowserOS();\r\n$result=$browser[''browser''];', 2, 'discard_if_repeated_key', 1, 1),
(4, 1, 'OS', '$result=$browser[''platform''];', 3, 'discard_if_repeated_key', 1, 1),
(5, 1, 'Landing Page', '$result=$this->api->page_requested;', 7, 'discard_if_repeated_key', 1, 1),
(6, 1, 'Exit Page', '$result = $this->api->page_requested;', 8, 'update_last_value', 0, 1),
(7, 1, 'Total Visit', '$result = $isBot?0:1;', 5, 'discard_if_repeated_key', 0, 1),
(8, 1, 'Returning Visit', '$result = isset( $_COOKIE[''web''] ) ? 1 : 0 ;', 6, 'discard_if_repeated_key', 1, 1),
(9, 43, 'iblock', '$temp = $this->add(''xAi/Model_IBlockContent'');\r\n$temp->addCondition(''iblock_id'',$current_data_value);\r\n$temp->tryLoadAny();\r\n$result = $temp->id;', 0, 'always_add', 0, 1),
(10, 1, 'isBot', '$isBot=isset($_SERVER[''HTTP_USER_AGENT'']) && preg_match(''/bot|crawl|slurp|spider/i'', $_SERVER[''HTTP_USER_AGENT''])?1:0;\r\n$result=$isBot;', 4, 'discard_if_repeated_key', 0, 1),
(11, 37, 'Referrer', '$result = $current_data_value;', 0, 'discard_if_repeated_key', 0, 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=117 ;

-- --------------------------------------------------------

--
-- Table structure for table `xai_meta_information`
--

CREATE TABLE IF NOT EXISTS `xai_meta_information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `is_triggering` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `xai_meta_information`
--

INSERT INTO `xai_meta_information` (`id`, `name`, `is_triggering`) VALUES
(1, 'Country', 1),
(2, 'City', 1),
(3, 'Browser', 1),
(4, 'OS', 1),
(5, 'Landing Page', 1),
(6, 'Exit Page', 0),
(7, 'Total Visit', 0),
(8, 'Returning Visit', 1),
(9, 'iblock', 0),
(10, 'isBot', 0),
(11, 'Referrer', 0);

-- --------------------------------------------------------

--
-- Table structure for table `xai_sales_executive`
--

CREATE TABLE IF NOT EXISTS `xai_sales_executive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `xai_visual_analytic`
--

INSERT INTO `xai_visual_analytic` (`id`, `name`, `push_to_main_dashboard`, `push_to_analytic_dashboard`, `group_by`, `visual_style`, `use_gloabl_timespan`, `limit_top`, `chart_title`, `chart_sub_title`, `grid_group_by_meta_information_id`, `grid_value`, `main_dashboard_order`, `span_on_main_dashboard`, `analytic_dashboard_order`, `span_on_analytic_dashboard`, `push_to_live_dashboard`, `live_dashboard_order`, `span_on_live_dashboard`) VALUES
(1, 'Total Visitors', 1, 1, 'Date', 'line', 1, '20', 'Total Visitors', '', NULL, NULL, 1, 6, 1, 6, 0, 0, 0),
(2, 'Top Landing Pages', 1, 1, NULL, 'grid', 1, '10', 'Landing Pages', '', 5, 'WEIGHTSUM', 2, 3, 2, 2, 1, 2, 2),
(3, 'Top Browsers', 0, 1, NULL, 'grid', 1, '10', 'Browsers', '', 3, 'COUNT', 0, 0, 3, 2, 0, 0, 0),
(4, 'Top Exit Page', 1, 1, NULL, 'grid', 1, '10', 'Exit Pages', '', 6, 'COUNT', 4, 3, 4, 3, 0, 0, 0),
(5, 'Top Referrer Sites', 0, 1, NULL, 'grid', 1, '10', 'Referres', '', 11, 'WEIGHTSUM', 0, 0, 3, 2, 0, 0, 0),
(6, 'Users Live On Site', 0, 0, NULL, 'grid', 1, '20', 'Visitors', '', 7, 'COUNT', 0, 0, 0, 0, 1, 1, 2);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `xai_visual_analytic_series`
--

INSERT INTO `xai_visual_analytic_series` (`id`, `meta_information_id`, `visual_analytic_id`, `name`) VALUES
(1, 7, 1, 'SUM');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `xEnquiryNSubscription_custome_customFields`
--

INSERT INTO `xEnquiryNSubscription_custome_customFields` (`id`, `forms_id`, `name`, `type`, `set_value`, `mandatory`) VALUES
(12, 2, 'Email', 'email', '', 1);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xEnquiryNSubscription_customForm_forms`
--

INSERT INTO `xEnquiryNSubscription_customForm_forms` (`id`, `epan_id`, `name`, `receipent_email_id`, `receive_mail`, `button_name`) VALUES
(2, 1, 'test', 'support@xepan.org', 1, 'Submit');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `is_active` tinyint(1) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`),
  KEY `fk_category_id` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `xEnquiryNSubscription_NewsLetterCategory`
--

INSERT INTO `xEnquiryNSubscription_NewsLetterCategory` (`id`, `epan_id`, `name`) VALUES
(2, 1, 'test');

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `xMarketingCampaign_data_grabber`
--

INSERT INTO `xMarketingCampaign_data_grabber` (`id`, `epan_id`, `name`, `site_url`, `query_parameter`, `paginator_parameter`, `paginator_initial_value`, `records_per_page`, `paginator_based_on`, `extra_url_parameters`, `required_pause_between_hits`, `result_selector`, `result_format`, `json_url_key`, `reg_ex_on_href`, `created_at`, `last_run_at`, `is_active`) VALUES
(1, 1, 'http://www.bing.com', 'http://www.bing.com', 'q', 'first', '1', '10', 'records', '', '30', 'li.b_algo', 'HTML', '', '', '2014-10-25 09:55:21', '2014-10-25 09:55:21', 1),
(2, 1, 'Google Ajax (Limited to max 64 records)', 'http://ajax.googleapis.com/ajax/services/search/web', 'q', 'start', '0', '8', 'records', 'v=1.0&rsz=8', '10', '', 'JSON', 'unescapedUrl', '', '2014-10-25 09:56:51', '2014-10-25 09:56:51', 1),
(3, 1, 'Google.com', 'http://www.google.co.in/search', 'q', 'start', '0', '10', 'records', '', '10', '#ires li.g h3', 'HTML', '', '^\\/url\\?q=(.*)&sa=(.*)$', '2014-10-25 09:57:58', '2014-12-08 13:48:43', 1);

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_FacebookConfig`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_FacebookConfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `secret` varchar(255) DEFAULT NULL,
  `appId` varchar(255) DEFAULT NULL,
  `post_in_groups` tinyint(1) DEFAULT NULL,
  `filter_repeated_posts` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_FacebookUsers`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_FacebookUsers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fb_config_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `userid_returned` varchar(255) DEFAULT NULL,
  `access_token` text,
  `is_access_token_valid` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_fb_config_id` (`fb_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_LinkedinUsers`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_LinkedinUsers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `linkedin_config_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `userid` varchar(255) DEFAULT NULL,
  `userid_returned` varchar(255) DEFAULT NULL,
  `access_token` text,
  `is_access_token_valid` tinyint(1) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `access_token_secret` text,
  `access_token_expiry` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_linkedin_config_id` (`linkedin_config_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  `likes` varchar(255) DEFAULT NULL,
  `share` varchar(255) DEFAULT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `is_monitoring` tinyint(1) DEFAULT NULL,
  `force_monitor` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_post_id` (`post_id`),
  KEY `fk_campaign_id` (`campaign_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xMarketingCampaign_SocialPostings_Activities`
--

CREATE TABLE IF NOT EXISTS `xMarketingCampaign_SocialPostings_Activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `posting_id` int(11) DEFAULT NULL,
  `activity_type` varchar(255) DEFAULT NULL,
  `activity_on` datetime DEFAULT NULL,
  `activity_by` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `activityid_returned` varchar(255) DEFAULT NULL,
  `action_allowed` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_posting_id` (`posting_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_application`
--

CREATE TABLE IF NOT EXISTS `xshop_application` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_attachments`
--

CREATE TABLE IF NOT EXISTS `xshop_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `attachment_url` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_id` (`product_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_categories`
--

CREATE TABLE IF NOT EXISTS `xshop_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `parent_id` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  `categorygroup_id` int(11) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  `description` text,
  `image_url` varchar(255) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_category_product`
--

CREATE TABLE IF NOT EXISTS `xshop_category_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `is_associate` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category_id` (`category_id`),
  KEY `fk_product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_custom_fields`
--

CREATE TABLE IF NOT EXISTS `xshop_custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product_id` (`product_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_custom_fields_value`
--

CREATE TABLE IF NOT EXISTS `xshop_custom_fields_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customefield_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_customefield_id` (`customefield_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_group`
--

CREATE TABLE IF NOT EXISTS `xshop_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
  PRIMARY KEY (`id`),
  KEY `fk_users_id` (`users_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_orderDetails`
--

CREATE TABLE IF NOT EXISTS `xshop_orderDetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `unit` decimal(10,2) DEFAULT NULL,
  `rate` decimal(10,2) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_order_id` (`order_id`),
  KEY `fk_product_id` (`product_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `xshop_orders`
--

CREATE TABLE IF NOT EXISTS `xshop_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `order_status` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `discount_voucher` varchar(255) DEFAULT NULL,
  `discount_voucher_amount` varchar(255) DEFAULT NULL,
  `net_amount` varchar(255) DEFAULT NULL,
  `order_summary` text,
  `billing_address` varchar(255) DEFAULT NULL,
  `shipping_address` varchar(255) DEFAULT NULL,
  `order_date` date DEFAULT NULL,
  `epan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_member_id` (`member_id`),
  KEY `fk_epan_id` (`epan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
