-- phpMyAdmin SQL Dump
-- version 2.6.1
-- http://www.phpmyadmin.net
-- 
-- Хост: localhost
-- Время создания: Мар 03 2007 г., 16:47
-- Версия сервера: 4.1.16
-- Версия PHP: 4.4.2
-- 
-- БД: `SERVICE`
-- 

-- --------------------------------------------------------

-- 
-- Структура таблицы `COMPANY`
-- 

CREATE TABLE `COMPANY` (
  `ID` int(4) NOT NULL auto_increment,
  `NAME` varchar(250) NOT NULL default '',
  `ADDRESS` varchar(250) NOT NULL default '',
  `MEMO` varchar(250) default NULL,
  `PHONE` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

-- 
-- Дамп данных таблицы `COMPANY`
-- 

INSERT INTO `COMPANY` VALUES (1, 'Azex', 'Izmir street', 'azex', '12233');
INSERT INTO `COMPANY` VALUES (2, 'ISETECH', 'vvfv', 'vcv', '5453534');
INSERT INTO `COMPANY` VALUES (3, 'Nurgun', 'ahmedli', 'eff', '5345345');
INSERT INTO `COMPANY` VALUES (4, 'test', 'tt', 'tt', 'tt');
INSERT INTO `COMPANY` VALUES (5, 'NEW', 'jcdcndjcn', 'kdkcm', '489748923');

-- --------------------------------------------------------

-- 
-- Структура таблицы `EQUIPMENT`
-- 

CREATE TABLE `EQUIPMENT` (
  `ID` int(4) NOT NULL auto_increment,
  `ID_COMPANY` int(4) NOT NULL default '0',
  `ID_TYPE` int(4) NOT NULL default '0',
  `ID_USER` int(4) NOT NULL default '0',
  `ID_NET` int(4) NOT NULL default '0',
  `PART_NO` varchar(250) NOT NULL default '',
  `SERIAL_NO` varchar(250) NOT NULL default '',
  `MODEL` varchar(250) NOT NULL default '',
  `ID_STATUS` int(4) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `EQUIPMENT`
-- 

INSERT INTO `EQUIPMENT` VALUES (1, 1, 5, 1, 1, '2322423', '3424345', 'HP 6120', 0);
INSERT INTO `EQUIPMENT` VALUES (2, 2, 1, 1, 2, '4234', '342343', 'fujitsu', 0);
INSERT INTO `EQUIPMENT` VALUES (3, 2, 2, 1, 4, '3423423', '3423423', 'HP 3030', 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `EQUIPMENT_TYPE`
-- 

CREATE TABLE `EQUIPMENT_TYPE` (
  `ID` int(4) NOT NULL auto_increment,
  `NAME` varchar(250) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=7 ;

-- 
-- Дамп данных таблицы `EQUIPMENT_TYPE`
-- 

INSERT INTO `EQUIPMENT_TYPE` VALUES (1, 'PC');
INSERT INTO `EQUIPMENT_TYPE` VALUES (2, 'Printer');
INSERT INTO `EQUIPMENT_TYPE` VALUES (3, 'WiFi AP');
INSERT INTO `EQUIPMENT_TYPE` VALUES (4, 'Cisco firewall');
INSERT INTO `EQUIPMENT_TYPE` VALUES (5, 'Notebook');
INSERT INTO `EQUIPMENT_TYPE` VALUES (6, 'Router');

-- --------------------------------------------------------

-- 
-- Структура таблицы `JOB_STATUS`
-- 

CREATE TABLE `JOB_STATUS` (
  `ID` int(4) NOT NULL auto_increment,
  `STATUS` varchar(250) default NULL,
  `ID_STATUS` int(4) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=5 ;

-- 
-- Дамп данных таблицы `JOB_STATUS`
-- 

INSERT INTO `JOB_STATUS` VALUES (1, 'ready', 2);
INSERT INTO `JOB_STATUS` VALUES (2, 'waiting for a part', 1);
INSERT INTO `JOB_STATUS` VALUES (3, 'unready', 2);
INSERT INTO `JOB_STATUS` VALUES (4, 'wait', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `LOGS`
-- 

CREATE TABLE `LOGS` (
  `ID` int(4) NOT NULL auto_increment,
  `ID_PERSONAL` int(4) default NULL,
  `ID_COMPANY` int(4) default NULL,
  `ID_EQUIPMENT` int(4) default NULL,
  `ID_JOB` int(4) default NULL,
  `ID_PROBLEM` int(4) default NULL,
  `ID_SOLUTION` int(4) default NULL,
  `INFO` text,
  `ID_STATUS` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=12 ;

-- 
-- Дамп данных таблицы `LOGS`
-- 

INSERT INTO `LOGS` VALUES (6, 1, 1, 1, 1, 1, 1, 'wfedfvdv', '1');
INSERT INTO `LOGS` VALUES (7, 1, 1, 1, 1, 1, 1, 'gbbdbd', '2');
INSERT INTO `LOGS` VALUES (9, 2, 2, 3, 3, 3, 3, '', '2');
INSERT INTO `LOGS` VALUES (10, 2, 2, 2, 1, 2, 2, '', '1');
INSERT INTO `LOGS` VALUES (11, 2, 3, 3, 1, 2, 2, '', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `NETWORK`
-- 

CREATE TABLE `NETWORK` (
  `ID` int(4) NOT NULL auto_increment,
  `IP` varchar(250) NOT NULL default '',
  `MAC` varchar(250) NOT NULL default '',
  `GATEWAY` varchar(250) NOT NULL default '',
  `DNS` varchar(250) NOT NULL default '',
  `ID_STATUS` varchar(4) NOT NULL default '',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;

-- 
-- Дамп данных таблицы `NETWORK`
-- 

INSERT INTO `NETWORK` VALUES (1, '192.168.0.100', '00-15-00-3B-B0-39', '192.168.0.1', '217.64.16.1', '');
INSERT INTO `NETWORK` VALUES (2, '192.168.0.250', '00-14-C2-DC-59-9E', '192.168.0.1', '192.168.0.1', '');
INSERT INTO `NETWORK` VALUES (3, '192.168.0.65', '534556456', '5656456565', '656565656', '1');
INSERT INTO `NETWORK` VALUES (4, '192.168.0.66', '56464565', '456756756', '5564646456', '2');
INSERT INTO `NETWORK` VALUES (5, '439434', '4udfjsdknvskl', 'kdnvd', 'DKCVND', '1');

-- --------------------------------------------------------

-- 
-- Структура таблицы `PERSONAL`
-- 

CREATE TABLE `PERSONAL` (
  `ID` int(4) NOT NULL auto_increment,
  `FIO` varchar(250) NOT NULL default '',
  `MOBILE` varchar(250) default NULL,
  `PASSWORD` varchar(250) NOT NULL default '',
  `LOGIN` varchar(250) NOT NULL default '',
  `ID_STATUS` int(4) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `PERSONAL`
-- 

INSERT INTO `PERSONAL` VALUES (1, 'Nazirov Ayaz Raufovich', '213143234', '123', 'ayaz', 0);
INSERT INTO `PERSONAL` VALUES (2, 'Garaev Eldar Yasharovich', '6770425', '1', 'admin', 0);
INSERT INTO `PERSONAL` VALUES (3, 'dcdc', 'vdcd', 'dfv', 'cdc', 1);

-- --------------------------------------------------------

-- 
-- Структура таблицы `PROBLEM`
-- 

CREATE TABLE `PROBLEM` (
  `ID` int(4) NOT NULL auto_increment,
  `INFO` text,
  `ID_STATUS` int(4) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `PROBLEM`
-- 

INSERT INTO `PROBLEM` VALUES (1, '1.Virus problems', 1);
INSERT INTO `PROBLEM` VALUES (2, '2. CD-ROM problem', 2);
INSERT INTO `PROBLEM` VALUES (3, 'jopa', 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `SOLUTION`
-- 

CREATE TABLE `SOLUTION` (
  `ID` int(4) NOT NULL auto_increment,
  `INFO` text,
  `ID_STATUS` int(4) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `SOLUTION`
-- 

INSERT INTO `SOLUTION` VALUES (1, 'Antivirus ', 2);
INSERT INTO `SOLUTION` VALUES (2, 'CD-ROM repairing', 1);
INSERT INTO `SOLUTION` VALUES (3, 'klizma', 2);

-- --------------------------------------------------------

-- 
-- Структура таблицы `STATUS`
-- 

CREATE TABLE `STATUS` (
  `ID` int(4) NOT NULL auto_increment,
  `NAME` varchar(250) default NULL,
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

-- 
-- Дамп данных таблицы `STATUS`
-- 

INSERT INTO `STATUS` VALUES (1, 'admin');
INSERT INTO `STATUS` VALUES (2, 'user');
INSERT INTO `STATUS` VALUES (3, 'wwww');

-- --------------------------------------------------------

-- 
-- Структура таблицы `USERS`
-- 

CREATE TABLE `USERS` (
  `ID` int(4) NOT NULL auto_increment,
  `NAME` varchar(250) NOT NULL default '',
  `LOGIN` varchar(250) NOT NULL default '',
  `PASSWORD` varchar(250) default NULL,
  `ID_STATUS` int(4) NOT NULL default '0',
  PRIMARY KEY  (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=3 ;

-- 
-- Дамп данных таблицы `USERS`
-- 

INSERT INTO `USERS` VALUES (1, 'Djeyxun', 'user', '123', 0);
INSERT INTO `USERS` VALUES (2, 'Ruslan', 'baxi', '123', 1);
