-- Exportiere Struktur von Tabelle mitec-2019.dolibarr_xframework_bigdata
CREATE TABLE IF NOT EXISTS `dolibarr_xframework_bigdata` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(128) NOT NULL DEFAULT '0',
  `refid` int(12) NOT NULL DEFAULT 0,
  `string` text NOT NULL,
  `entriedate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle mitec-2019.dolibarr_xframework_jserrors
CREATE TABLE IF NOT EXISTS `dolibarr_xframework_jserrors` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT 0,
  `createdate` datetime DEFAULT current_timestamp(),
  `errormsg` longtext DEFAULT NULL,
  `urlstring` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle mitec-2019.dolibarr_xframework_logging
CREATE TABLE IF NOT EXISTS `dolibarr_xframework_logging` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(128) NOT NULL DEFAULT '0',
  `refid` int(12) NOT NULL DEFAULT 0,
  `createdate` datetime DEFAULT current_timestamp(),
  `username` varchar(122) NOT NULL,
  `changesstring` text NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle mitec-2019.dolibarr_xframework_messages
CREATE TABLE IF NOT EXISTS `dolibarr_xframework_messages` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(122) NOT NULL,
  `createdate` datetime DEFAULT current_timestamp(),
  `username` varchar(122) DEFAULT NULL,
  `notification` longtext NOT NULL,
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;

-- Daten Export vom Benutzer nicht ausgewählt

-- Exportiere Struktur von Tabelle mitec-2019.dolibarr_xframework_triggers
CREATE TABLE IF NOT EXISTS `dolibarr_xframework_triggers` (
  `rowid` int(11) NOT NULL AUTO_INCREMENT,
  `triggername` text NOT NULL DEFAULT '0',
  `username` varchar(512) NOT NULL DEFAULT '0',
  `createdate` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`rowid`)
) ENGINE=InnoDB AUTO_INCREMENT=175 DEFAULT CHARSET=utf8mb4;

