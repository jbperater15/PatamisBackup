-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2020 at 04:00 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patamis`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `form_del` (IN `p_form_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    DELETE FROM forms where form_id = p_form_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `form_ins` (IN `p_form_code` VARCHAR(20), IN `p_form_name` VARCHAR(50), IN `p_description` VARCHAR(100), IN `p_user_id` INT, OUT `p_form_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN
    DECLARE EXIT HANDLER FOR 1062, 1586
    BEGIN
        SET p_form_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('[',p_form_code,'] already exists');
    END;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_form_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    INSERT INTO forms
        ( form_code
        , form_name
        , form_description
        , created_by
        , creation_date)
     VALUES ( p_form_code
            , p_form_name
            , p_description
            , p_user_id
            , NOW());

    SET p_form_id = LAST_INSERT_ID();
    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `form_upd` (IN `p_form_id` INT, IN `p_form_code` VARCHAR(20), IN `p_form_name` VARCHAR(50), IN `p_description` VARCHAR(100), IN `p_user_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN
    DECLARE EXIT HANDLER FOR 1062, 1586
    BEGIN
        SET p_form_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('[',p_form_code,'] already exists');
    END;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_form_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;


    UPDATE
        forms
    SET 
        form_code = p_form_code
       ,form_name = p_form_name
       ,form_description = p_description
       ,updated_by = p_user_id
       ,update_date = NOW()
    WHERE form_id = p_form_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prjReq_del` (IN `p_chklst_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    DELETE FROM requirements_checklist where checklist_id  = p_chklst_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prjReq_ins` (IN `p_prjtype_id` INT, IN `p_req_chklst` VARCHAR(75), IN `p_user_id` INT, OUT `p_chklst_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_chklst_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    INSERT INTO requirements_checklist
        ( project_type_id
        , requirement_item
        , created_by
        , creation_date)
     VALUES ( p_prjtype_id
            , p_req_chklst
            , p_user_id
            , NOW());

    SET p_chklst_id = LAST_INSERT_ID();
    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prjReq_upd` (IN `p_chklst_id` INT, IN `p_req_items` VARCHAR(50), IN `p_user_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;


    UPDATE 
        requirements_checklist
    SET 
         requirement_item =   p_req_items
        ,updated_by       =   p_user_id
        ,update_date      =  NOW()
    WHERE
        checklist_id  =  p_chklst_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prjType_del` (IN `p_project_type_id` INT(11), OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    DELETE FROM project_types where project_type_id = p_project_type_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prjType_ins` (IN `p_prj_type` VARCHAR(20), IN `p_prj_name` VARCHAR(50), IN `p_user_id` INT(11), OUT `p_prj_id` INT(11), OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN
    DECLARE EXIT HANDLER FOR 1062, 1586
    BEGIN
        SET p_prj_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('[',p_prj_type,'] already exists');
    END;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_prj_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    INSERT INTO project_types
        ( project_type
        , type_name
        , created_by
        , creation_date)
     VALUES ( p_prj_type
            , p_prj_name
            , p_user_id
            , NOW());

    SET p_prj_id = LAST_INSERT_ID();
    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `prjType_upd` (IN `p_prjtype_id` INT, IN `p_prjtype` VARCHAR(50), IN `p_type_name` VARCHAR(50), IN `p_user_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;


    UPDATE 
        project_types
    SET 
         project_type   =   p_prjtype
        ,type_name      =   p_type_name
        ,updated_by     =   p_user_id
        ,update_date    =  NOW()
    WHERE
        project_type_id  =  p_prjtype_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `role_access_del` (IN `p_role_acc_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    DELETE FROM role_access where role_acc_id = p_role_acc_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `role_access_ins` (IN `p_role_id` INT, IN `p_form_id` INT, IN `p_create_flag` VARCHAR(5), IN `p_read_flag` VARCHAR(5), IN `p_update_flag` VARCHAR(5), IN `p_delete_flag` VARCHAR(5), IN `p_user_id` INT, OUT `p_role_acc_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_role_acc_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    INSERT INTO role_access
        ( role_id
        , form_id
        , create_flag
        , read_flag
        , update_flag
        , delete_flag
        , created_by
        , creation_date)
     VALUES ( p_role_id
            , p_form_id
            , p_create_flag
            , p_read_flag
            , p_update_flag
            , p_delete_flag
            , p_user_id
            , NOW());

    SET p_role_acc_id = LAST_INSERT_ID();
    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `role_access_upd` (IN `p_role_acc_id` INT, IN `p_create_flag` VARCHAR(5), IN `p_read_flag` VARCHAR(5), IN `p_update_flag` VARCHAR(5), IN `p_delete_flag` VARCHAR(5), IN `p_user_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_role_acc_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    UPDATE
         role_access 
    SET 
         create_flag = p_create_flag
        ,read_flag   = p_read_flag
        ,update_flag = p_update_flag
        ,delete_flag = p_delete_flag
        ,updated_by  = p_user_id
        ,update_date = NOW()
    WHERE 
        role_acc_id = p_role_acc_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `role_del` (IN `p_role_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    DELETE FROM roles where role_id = p_role_id;
    DELETE FROM role_access where role_id = p_role_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `role_ins` (IN `p_role_code` VARCHAR(20), IN `p_role_name` VARCHAR(50), IN `p_description` VARCHAR(100), IN `p_user_id` INT(11), OUT `p_role_id` INT(11), OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN
    DECLARE EXIT HANDLER FOR 1062, 1586
    BEGIN
        SET p_role_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('[',p_role_code,'] already exists');
    END;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_role_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    INSERT INTO roles
        ( role_code
        , role_name
        , role_description
        , created_by
        , creation_date)
     VALUES ( p_role_code
            , p_role_name
            , p_description
            , p_user_id
            , NOW());

    SET p_role_id = LAST_INSERT_ID();
    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `role_upd` (IN `p_role_id` INT, IN `p_role_code` VARCHAR(20), IN `p_role_name` VARCHAR(50), IN `p_description` VARCHAR(100), IN `p_user_id` INT, OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;


    UPDATE 
        roles
    SET 
         role_code  =   p_role_code
        ,role_name  =   p_role_name
        ,role_description   =   p_description
        ,updated_by =   p_user_id
        ,update_date =  NOW()
    WHERE
        role_id  =  p_role_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `user_del` (IN `p_user_id` INT(11), OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    DELETE FROM users where user_id = p_user_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `user_ins` (IN `p_username` VARCHAR(50), IN `p_password` VARCHAR(60), IN `p_fname` VARCHAR(50), IN `p_lname` VARCHAR(50), IN `p_email` VARCHAR(50), IN `p_role_id` INT(11), IN `p_session_id` INT(11), OUT `p_user_id` INT(11), OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN
    DECLARE EXIT HANDLER FOR 1062, 1586
    BEGIN
        SET p_user_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('[',p_username,'] already exists');
    END;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_user_id = NULL;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;

    INSERT INTO users
        ( username
        , password
        , fname
        , lname
        , email
        , role_id
        , created_by
        , creation_date)
     VALUES ( p_username
            , p_password
            , p_fname
            , p_lname
            , p_email
            , p_role_id
            , p_session_id
            , NOW());

    SET p_user_id = LAST_INSERT_ID();
    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `user_upd` (IN `p_user_id` INT(11), IN `p_username` VARCHAR(50), IN `p_password` VARCHAR(60), IN `p_fname` VARCHAR(50), IN `p_lname` VARCHAR(50), IN `p_email` VARCHAR(50), IN `p_role_id` INT(11), IN `p_session_id` INT(11), OUT `p_err_code` VARCHAR(10), OUT `p_err_msg` VARCHAR(250))  BEGIN

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        GET DIAGNOSTICS CONDITION 1
            @errno = MYSQL_ERRNO, @text = MESSAGE_TEXT;
        SET p_err_code  = '1';
        SET p_err_msg = CONCAT('ERR:',@errno,' - ',@text);
    END;


    UPDATE 
        users
    SET 
         username  =   p_username
        ,password  =   p_password
        ,fname   =   p_fname
        ,lname	=	p_lname
        ,email	=	p_email
        ,role_id	=	p_role_id
        ,updated_by =   p_session_id
        ,update_date =  NOW()
    WHERE
        user_id  =  p_user_id;

    SET p_err_code = '0';
    SET p_err_msg = NULL;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `client_id` int(11) NOT NULL,
  `client_no` int(11) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `client_contact_no` int(11) NOT NULL,
  `client_address` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `evaluation_schedule`
--

CREATE TABLE `evaluation_schedule` (
  `eval_sched_id` int(11) NOT NULL,
  `evaluation_title` varchar(50) NOT NULL,
  `project_id` int(11) NOT NULL,
  `evaluators_id` int(11) NOT NULL,
  `date` varchar(20) NOT NULL,
  `time_start` varchar(20) NOT NULL,
  `time_end` varchar(20) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `evaluation_schedule`
--

INSERT INTO `evaluation_schedule` (`eval_sched_id`, `evaluation_title`, `project_id`, `evaluators_id`, `date`, `time_start`, `time_end`, `created_by`, `creation_date`, `updated_by`, `update_date`) VALUES
(1, 'test', 0, 0, '2020-07-01', '16:05', '17:05', 0, '2020-06-30 07:05:29', 0, '0000-00-00 00:00:00'),
(2, 'Site Visit', 0, 0, '2020-07-02', '10:49', '11:49', 0, '2020-07-01 09:49:35', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `evaluators`
--

CREATE TABLE `evaluators` (
  `evaluator_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `evaluator_panels`
--

CREATE TABLE `evaluator_panels` (
  `eval_panel_id` int(11) NOT NULL,
  `evaluators_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `form_id` int(11) NOT NULL,
  `form_code` varchar(20) NOT NULL,
  `form_name` varchar(50) NOT NULL,
  `form_description` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `forms`
--

INSERT INTO `forms` (`form_id`, `form_code`, `form_name`, `form_description`, `created_by`, `creation_date`, `updated_by`, `update_date`) VALUES
(1, 'ROLES', 'Role Forms', 'Role Forms', 1, '2020-03-10 13:45:07', 1, '2020-06-26 09:25:57'),
(6, 'PRJ_TYPES', 'Projecttypes', 'Project Types', 1, '2020-06-26 09:26:52', NULL, NULL),
(8, 'FORMS', 'Forms', 'Forms', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lookup`
--

CREATE TABLE `lookup` (
  `lookup_type` varchar(50) NOT NULL,
  `description` varchar(50) NOT NULL,
  `meaning` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lookup_values`
--

CREATE TABLE `lookup_values` (
  `lookup_type` varchar(50) NOT NULL,
  `lookup_code` varchar(50) NOT NULL,
  `lookup_value` varchar(50) NOT NULL,
  `lookup_meaning` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_number` int(11) NOT NULL,
  `project_title` varchar(50) NOT NULL,
  `client_id` int(11) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `contact_no` varchar(11) NOT NULL,
  `office_address` varchar(50) NOT NULL,
  `email_address` varchar(50) NOT NULL,
  `business_permit` varchar(50) NOT NULL,
  `present_cap` double NOT NULL,
  `cap_class` varchar(20) NOT NULL,
  `year_established` varchar(20) NOT NULL,
  `dost_cost` double NOT NULL,
  `proponent_cost` double NOT NULL,
  `project_status` varchar(20) NOT NULL,
  `day_count` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project_evaluation`
--

CREATE TABLE `project_evaluation` (
  `pro_eval_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `evaluation` varchar(50) NOT NULL,
  `eval_sched_id` int(11) NOT NULL,
  `date_approved` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project_progress_flag`
--

CREATE TABLE `project_progress_flag` (
  `prog_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `progress_type` varchar(50) NOT NULL,
  `date_accomplished` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `project_types`
--

CREATE TABLE `project_types` (
  `project_type_id` int(11) NOT NULL,
  `project_type` varchar(50) NOT NULL,
  `type_name` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `project_types`
--

INSERT INTO `project_types` (`project_type_id`, `project_type`, `type_name`, `created_by`, `creation_date`, `updated_by`, `update_date`) VALUES
(1, 'LGIA-CEST', 'LGIA-CEST', 1, '2020-06-26 10:56:12', 1, '2020-06-30 15:27:23'),
(2, 'SETUP', 'SETUP', 1, '2020-06-26 11:41:11', 1, '2020-06-30 15:27:18'),
(3, 'R&D Project', 'R&D Project', 1, '2020-06-26 11:42:30', 1, '2020-06-30 15:27:12');

-- --------------------------------------------------------

--
-- Table structure for table `requirements_checklist`
--

CREATE TABLE `requirements_checklist` (
  `checklist_id` int(11) NOT NULL,
  `project_type_id` int(11) NOT NULL,
  `requirement_item` varchar(75) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `requirements_checklist`
--

INSERT INTO `requirements_checklist` (`checklist_id`, `project_type_id`, `requirement_item`, `created_by`, `creation_date`, `updated_by`, `update_date`) VALUES
(1, 5, 'Me', 1, '2020-06-26 11:43:55', 0, '0000-00-00 00:00:00'),
(2, 6, 'Mes', 1, '2020-06-26 11:44:55', 1, '2020-06-26 14:04:09'),
(5, 1, 'doc1', 1, '2020-07-01 15:59:01', 0, '0000-00-00 00:00:00'),
(6, 1, 'doc2', 1, '2020-07-01 15:59:04', 0, '0000-00-00 00:00:00'),
(7, 1, 'doc3', 1, '2020-07-01 16:09:02', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `requirement_flag`
--

CREATE TABLE `requirement_flag` (
  `req_flag_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `requirement_item` varchar(50) NOT NULL,
  `requirement_status` varchar(50) NOT NULL,
  `upload_file` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_code` varchar(20) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  `role_description` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_code`, `role_name`, `role_description`, `created_by`, `creation_date`, `updated_by`, `update_date`) VALUES
(3, 'ADMIN', 'System Administrator', 'System Administrator', 1, '2020-03-17 10:20:25', 1, '2020-06-26 09:30:25'),
(15, 'RPMO', 'RPMO', 'RPMO', 1, '2020-03-18 15:43:22', 1, '2020-07-01 15:47:23'),
(16, 'PSTC', 'PSTC', 'PSTC', 1, '2020-06-26 09:43:22', 0, '0000-00-00 00:00:00'),
(20, 'ERTEC', 'External RTEC', 'External RTEC', 1, '2020-06-30 15:42:24', 0, '0000-00-00 00:00:00'),
(21, 'IRTEC', 'Internal RTEC', 'Internal RTEC', 1, '2020-06-30 15:42:43', 0, '0000-00-00 00:00:00'),
(22, 'Proponent', 'Proponent', 'Proponent', 1, '2020-06-30 15:42:55', 0, '0000-00-00 00:00:00'),
(23, 'RD', 'Regional Director', 'Regional Director', 1, '2020-06-30 15:43:10', 0, '0000-00-00 00:00:00'),
(24, 'SC', 'SETUP Coordinator', 'SETUP Coordinator', 1, '2020-06-30 15:43:59', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `role_access`
--

CREATE TABLE `role_access` (
  `role_acc_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `create_flag` varchar(5) NOT NULL,
  `read_flag` varchar(5) NOT NULL,
  `update_flag` varchar(5) NOT NULL,
  `delete_flag` varchar(5) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_access`
--

INSERT INTO `role_access` (`role_acc_id`, `role_id`, `form_id`, `create_flag`, `read_flag`, `update_flag`, `delete_flag`, `created_by`, `creation_date`, `updated_by`, `update_date`) VALUES
(5, 3, 1, 'Y', 'Y', 'Y', 'Y', 1, '2020-03-17 10:53:10', 1, '2020-07-01 15:48:01'),
(8, 3, 4, 'Y', 'Y', 'Y', 'N', 1, '2020-03-17 15:52:12', 1, '2020-03-17 15:55:44'),
(13, 15, 4, 'Y', 'Y', 'N', 'Y', 1, '2020-03-18 17:01:09', 0, '0000-00-00 00:00:00'),
(14, 3, 6, 'Y', 'Y', 'Y', 'Y', 1, '2020-06-26 09:29:46', 1, '2020-06-30 08:19:41'),
(15, 16, 6, 'Y', 'Y', 'Y', 'N', 1, '2020-06-26 09:44:00', 0, '0000-00-00 00:00:00'),
(17, 3, 8, 'Y', 'Y', 'Y', 'Y', 1, '2020-06-30 06:42:42', 0, '0000-00-00 00:00:00'),
(19, 15, 1, 'Y', 'Y', 'Y', 'N', 1, '2020-06-30 08:18:37', 0, '0000-00-00 00:00:00'),
(20, 15, 6, 'Y', 'Y', 'Y', 'N', 1, '2020-06-30 08:18:53', 0, '0000-00-00 00:00:00'),
(21, 15, 8, 'Y', 'Y', 'Y', 'N', 1, '2020-06-30 08:19:07', 0, '0000-00-00 00:00:00'),
(23, 16, 1, 'Y', 'Y', 'Y', 'Y', 1, '2020-06-30 15:23:17', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `role_access_v`
-- (See below for the actual view)
--
CREATE TABLE `role_access_v` (
`role_acc_id` int(11)
,`role_id` int(11)
,`form_id` int(11)
,`create_flag` varchar(5)
,`read_flag` varchar(5)
,`update_flag` varchar(5)
,`delete_flag` varchar(5)
,`form_code` varchar(20)
,`form_name` varchar(50)
,`form_description` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `sys_sequence`
--

CREATE TABLE `sys_sequence` (
  `seq_id` int(11) NOT NULL,
  `seq_code` varchar(20) NOT NULL,
  `seq_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `fname`, `lname`, `email`, `role_id`, `created_by`, `creation_date`, `updated_by`, `update_date`) VALUES
(1, 'admin', '$2y$12$vDKYj5FcSRw4jq..GyLP7eJELOBHDEb6r37GJf/9B1xkc8hFII85e', 'admin', 'admin', 'admin@gmail.com', 3, 1, '0000-00-00 00:00:00', 1, '2020-06-30 09:56:18'),
(2, 'admin2', '$2y$12$yarhEx.O0krujWVa.U/ETewWhs/N/002YhO99.y.Q2/a/PXitYDRO', 'test', 'test', 'admin2@gmail.com', 3, 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(4, 'wkhu', '$2y$12$I61kw7MgDfFwEg18EccvQOPLsgXa6WUsK7DRPlKs9l6bEOfJddOvS', 'Windyl', 'Khu', 'mis@region10.dost.gov.ph', 3, 3, '2020-06-30 10:03:48', 3, '2020-06-30 15:13:04'),
(5, 'mis', 'test', 'Windyl', 'Khu', 'mis@region10.dost.gov.ph', 3, 1, '2020-07-01 15:46:09', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_access_v`
-- (See below for the actual view)
--
CREATE TABLE `user_access_v` (
`user_id` int(11)
,`username` varchar(50)
,`email` varchar(50)
,`role_acc_id` int(11)
,`role_id` int(11)
,`form_id` int(11)
,`create_flag` varchar(5)
,`read_flag` varchar(5)
,`update_flag` varchar(5)
,`delete_flag` varchar(5)
,`form_code` varchar(20)
,`form_name` varchar(50)
,`form_description` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure for view `role_access_v`
--
DROP TABLE IF EXISTS `role_access_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `role_access_v`  AS  select `ra`.`role_acc_id` AS `role_acc_id`,`ra`.`role_id` AS `role_id`,`ra`.`form_id` AS `form_id`,`ra`.`create_flag` AS `create_flag`,`ra`.`read_flag` AS `read_flag`,`ra`.`update_flag` AS `update_flag`,`ra`.`delete_flag` AS `delete_flag`,`frm`.`form_code` AS `form_code`,`frm`.`form_name` AS `form_name`,`frm`.`form_description` AS `form_description` from (`role_access` `ra` join `forms` `frm` on(`frm`.`form_id` = `ra`.`form_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `user_access_v`
--
DROP TABLE IF EXISTS `user_access_v`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_access_v`  AS  select `usr`.`user_id` AS `user_id`,`usr`.`username` AS `username`,`usr`.`email` AS `email`,`rav`.`role_acc_id` AS `role_acc_id`,`rav`.`role_id` AS `role_id`,`rav`.`form_id` AS `form_id`,`rav`.`create_flag` AS `create_flag`,`rav`.`read_flag` AS `read_flag`,`rav`.`update_flag` AS `update_flag`,`rav`.`delete_flag` AS `delete_flag`,`rav`.`form_code` AS `form_code`,`rav`.`form_name` AS `form_name`,`rav`.`form_description` AS `form_description` from (`users` `usr` join `role_access_v` `rav` on(`rav`.`role_id` = `usr`.`role_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`client_id`),
  ADD UNIQUE KEY `client_no` (`client_no`);

--
-- Indexes for table `evaluation_schedule`
--
ALTER TABLE `evaluation_schedule`
  ADD PRIMARY KEY (`eval_sched_id`);

--
-- Indexes for table `evaluators`
--
ALTER TABLE `evaluators`
  ADD PRIMARY KEY (`evaluator_id`);

--
-- Indexes for table `evaluator_panels`
--
ALTER TABLE `evaluator_panels`
  ADD PRIMARY KEY (`eval_panel_id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD UNIQUE KEY `project_number` (`project_number`);

--
-- Indexes for table `project_evaluation`
--
ALTER TABLE `project_evaluation`
  ADD PRIMARY KEY (`pro_eval_id`);

--
-- Indexes for table `project_progress_flag`
--
ALTER TABLE `project_progress_flag`
  ADD PRIMARY KEY (`prog_id`);

--
-- Indexes for table `project_types`
--
ALTER TABLE `project_types`
  ADD PRIMARY KEY (`project_type_id`),
  ADD UNIQUE KEY `project_type` (`project_type`);

--
-- Indexes for table `requirements_checklist`
--
ALTER TABLE `requirements_checklist`
  ADD PRIMARY KEY (`checklist_id`);

--
-- Indexes for table `requirement_flag`
--
ALTER TABLE `requirement_flag`
  ADD PRIMARY KEY (`req_flag_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_access`
--
ALTER TABLE `role_access`
  ADD PRIMARY KEY (`role_acc_id`);

--
-- Indexes for table `sys_sequence`
--
ALTER TABLE `sys_sequence`
  ADD PRIMARY KEY (`seq_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evaluation_schedule`
--
ALTER TABLE `evaluation_schedule`
  MODIFY `eval_sched_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `evaluators`
--
ALTER TABLE `evaluators`
  MODIFY `evaluator_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `evaluator_panels`
--
ALTER TABLE `evaluator_panels`
  MODIFY `eval_panel_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_evaluation`
--
ALTER TABLE `project_evaluation`
  MODIFY `pro_eval_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_progress_flag`
--
ALTER TABLE `project_progress_flag`
  MODIFY `prog_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `project_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `requirements_checklist`
--
ALTER TABLE `requirements_checklist`
  MODIFY `checklist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `requirement_flag`
--
ALTER TABLE `requirement_flag`
  MODIFY `req_flag_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `role_access`
--
ALTER TABLE `role_access`
  MODIFY `role_acc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `sys_sequence`
--
ALTER TABLE `sys_sequence`
  MODIFY `seq_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
