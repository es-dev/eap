


CREATE TABLE IF NOT EXISTS `soraldo_access` (
  `access_id` int(10) NOT NULL,
  `access_title` varchar(20) default NULL,
  PRIMARY KEY  (`access_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;


INSERT INTO `soraldo_access` (`access_id`, `access_title`) VALUES 
(1, 'Sospeso'),
(16, 'Operatore'),
(32, 'Amministratore'),
(64, 'Amministratore Unico'),
(256, 'Superuser');



CREATE TABLE IF NOT EXISTS `soraldo_ele_fasce` (
  `id_fascia` int(2) NOT NULL,
  `abitanti` int(11) NOT NULL,
  `data_inizio` date NOT NULL,
  `data_fine` date NOT NULL,
  `seggi` int(4) NOT NULL,
  PRIMARY KEY  (`id_fascia`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `soraldo_ele_fasce` VALUES (1,3000,'2000-01-01','0000-00-00',12),(2,10000,'2000-01-01','0000-00-00',16),(3,15000,'2000-01-01','0000-00-00',20),(4,30000,'2000-01-01','0000-00-00',20),(5,100000,'2000-01-01','0000-00-00',30),(6,250000,'2000-01-01','0000-00-00',40),(7,500000,'2000-01-01','0000-00-00',46),(8,1000000,'2000-01-01','0000-00-00',50),(9,100000000,'2000-01-01','0000-00-00',60);


CREATE TABLE IF NOT EXISTS `soraldo_authors` (
  `aid` varchar(25) NOT NULL default '',
  `name` varchar(50) default NULL,
  `id_comune` int(11) NOT NULL default '0',
  `email` varchar(255) default NULL,
  `pwd` varchar(40) default NULL,
  `counter` int(11) NOT NULL default '0',
  `adminop` tinyint(2) NOT NULL default '0',
  `admincomune` tinyint(2) NOT NULL default '0',
  `adminsuper` tinyint(2) NOT NULL default '1',
  `admlanguage` varchar(30) NOT NULL default '',
  PRIMARY KEY  (`aid`,`id_comune`),
  KEY `aid` (`aid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `soraldo_authors` (`aid`, `name`, `id_comune`, `email`, `pwd`, `counter`, `adminop`, `admincomune`, `adminsuper`, `admlanguage`) VALUES 
('suser', 'suser', 0, 'test@', '098f6bcd4621d373cade4e832627b4f6', 1, 0, 0, 1, 'it');



CREATE TABLE IF NOT EXISTS `soraldo_config` (
  `sitename` varchar(255) NOT NULL default '',
  `siteurl` varchar(255) NOT NULL default '',
  `site_logo` varchar(255) NOT NULL default '',
  `slogan` varchar(255) NOT NULL default '',
  `startdate` varchar(50) NOT NULL default '',
  `adminmail` varchar(255) NOT NULL default '',
  `Default_Theme` varchar(255) NOT NULL default '',
  `foot` text NOT NULL,
  `language` varchar(100) NOT NULL default '',
  `blocco` tinyint(1) NOT NULL,
  `testata` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `fileout` varchar(255) NOT NULL,
  `copyright` text NOT NULL,
  `Version_Num` varchar(10) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `soraldo_config` (`sitename`, `siteurl`, `site_logo`, `slogan`, `startdate`, `adminmail`, `Default_Theme`, `foot`, `language`, `blocco`, `testata`, `logo`, `fileout`, `copyright`, `Version_Num`) VALUES 
('Comune di Guidonia Montecelio', 'http://www.guidonia.org', 'logo.gif', 'Sito istituzionale', 'September 2002', 'luciano@guidonia.org', 'guidonia2', '<b>Comune di Guidonia Montecelio</b><br>\r\nPiazza Matteotti 1 , 00012 Guidonia Montecelio (Roma)\r\nTel: 07743011 Fax: 0774342629 \r\n<hr>', 'italian', 1, '', '', '', '', '0.5');



CREATE TABLE IF NOT EXISTS `soraldo_ele_candidati` (
  `id_cand` int(11) NOT NULL auto_increment,
  `id_cons` int(11) NOT NULL default '0',
  `id_lista` int(11) NOT NULL default '0',
  `cognome` varchar(30) default NULL,
  `nome` varchar(30) default NULL,
  `note` tinytext NOT NULL,
  `simbolo` varchar(30) NOT NULL default '',
  `num_cand` int(7) NOT NULL default '0',
  UNIQUE KEY `id_cand` (`id_cand`),
  KEY `id_cons` (`id_cons`),
  KEY `id_lista` (`id_lista`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_circoscrizione` (
  `id_cons` int(11) NOT NULL default '0',
  `id_circ` int(11) NOT NULL auto_increment,
  `num_circ` int(7) NOT NULL default '0',
  `descrizione` text,
  UNIQUE KEY `id_circ` (`id_circ`),
  UNIQUE KEY `id_cons` (`id_cons`,`num_circ`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_collegi` (
  `id_collegio` int(11) NOT NULL auto_increment,
  `id_cons_gen` int(11) NOT NULL default '0',
  `descrizione` text,
  PRIMARY KEY  (`id_collegio`),
  KEY `id_cons_gen` (`id_cons_gen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_come` (
  `id_cons` int(11) NOT NULL default '0',
  `mid` int(7) NOT NULL auto_increment,
  `title` varchar(150) NOT NULL default '',
  `preamble` text NOT NULL,
  `content` text NOT NULL,
  `editimage` varchar(100) NOT NULL default '',
  UNIQUE KEY `mid` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_comu_collegi` (
  `id_collegio` int(11) NOT NULL default '0',
  `id_cons` int(11) NOT NULL default '0',
  `id_comune` int(11) NOT NULL default '0',
  `id_cons_gen` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_cons_gen`,`id_comune`),
  KEY `id_cons` (`id_cons`),
  KEY `id_collegio` (`id_collegio`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_comuni` (
  `id_comune` int(11) NOT NULL default '0',
  `descrizione` varchar(50) default NULL,
  `indirizzo` varchar(50) default NULL,
  `centralino` varchar(15) default NULL,
  `fax` varchar(15) default NULL,
  `email` varchar(50) default NULL,
  `fascia` tinyint(4) NOT NULL default '0',
  `capoluogo` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id_comune`),
  KEY `access_id` (`descrizione`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_conf` (
  `id_conf` int(10) default NULL,
  `id_com` int(10) default NULL,
  `stemma` blob NOT NULL,
  `descrizione` varchar(255) NOT NULL default ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `soraldo_ele_conf` (`id_conf`, `id_com`, `stemma`, `descrizione`) VALUES 
(0, 0, 0x4749463839610a000a00800000ffffffffffff21fe15437265617465642077697468205468652047494d500021f904010a0001002c000000000a000a000002088c8fa9cbed0f632b003b, 'nulla');



CREATE TABLE IF NOT EXISTS `soraldo_ele_cons_comune` (
  `id_cons` int(11) NOT NULL auto_increment,
  `chiusa` set('0','1','2') NOT NULL default '0',
  `id_comune` int(11) NOT NULL default '0',
  `id_cons_gen` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_cons`),
  UNIQUE KEY `comune` (`id_comune`,`id_cons_gen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_consultazione` (
  `id_cons_gen` int(11) NOT NULL auto_increment,
  `descrizione` text,
  `data_inizio` date default NULL,
  `data_fine` date default NULL,
  `tipo_cons` int(7) NOT NULL default '0',
  PRIMARY KEY  (`id_cons_gen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_gruppo` (
  `id_cons` int(11) NOT NULL default '0',
  `id_gruppo` int(11) NOT NULL auto_increment,
  `num_gruppo` int(7) NOT NULL default '0',
  `descrizione` text,
  `simbolo` text,
  `stemma` blob,
  `id_circ` int(11) NOT NULL default '0',
  UNIQUE KEY `id_gruppo` (`id_gruppo`),
  UNIQUE KEY `id_cons` (`id_cons`,`num_gruppo`,`id_circ`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_link` (
  `id_cons` int(11) NOT NULL default '0',
  `mid` int(7) NOT NULL auto_increment,
  `title` varchar(150) NOT NULL default '',
  `preamble` text NOT NULL,
  `content` text NOT NULL,
  `editimage` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_lista` (
  `id_cons` int(11) NOT NULL default '0',
  `id_lista` int(11) NOT NULL auto_increment,
  `num_lista` int(7) NOT NULL default '0',
  `id_gruppo` int(11) NOT NULL default '0',
  `id_circ` int(11) NOT NULL default '0',
  `descrizione` text,
  `simbolo` text,
  `stemma` blob,
  PRIMARY KEY  (`id_cons`,`num_lista`,`id_circ`),
  UNIQUE KEY `id_lista` (`id_lista`),
  KEY `id_gruppo` (`id_gruppo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_log` (
  `id_cons` int(11) default NULL,
  `id_sez` int(11) default NULL,
  `utente` varchar(20) default NULL,
  `data` date default NULL,
  `ora` time default NULL,
  `log_da` text,
  `log_a` text,
  `tabella` varchar(30) default NULL,
  KEY `id_cons` (`id_cons`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_modelli` (
  `id_cons` int(11) NOT NULL default '0',
  `categoria` varchar(20) NOT NULL default '',
  `modello` blob NOT NULL,
  KEY `access_id` (`id_cons`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_numeri` (
  `id_cons` int(11) NOT NULL default '0',
  `mid` int(7) NOT NULL auto_increment,
  `title` varchar(150) NOT NULL default '',
  `preamble` text NOT NULL,
  `content` text NOT NULL,
  `editimage` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`mid`),
  KEY `id_cons` (`id_cons`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_operatori` (
  `id_cons` int(11) NOT NULL default '0',
  `id_sede` int(11) NOT NULL default '0',
  `id_comune` int(11) NOT NULL default '0',
  `permessi` int(3) default NULL,
  `aid` varchar(25) NOT NULL default '',
  UNIQUE KEY `id_cons_aid` (`id_cons`,`aid`,`id_comune`),
  KEY `id_circ` (`id_comune`),
  KEY `id_sede` (`id_sede`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_province` (
  `id` tinyint(11) NOT NULL,
  `descrizione` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_regioni` (
  `id` int(11) NOT NULL,
  `descrizione` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `descrizione` (`descrizione`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_rilaff` (
  `id_cons_gen` int(11) NOT NULL default '0',
  `orario` time NOT NULL default '00:00:00',
  `data` date NOT NULL default '0000-00-00',
  KEY `id_cons_gen` (`id_cons_gen`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_sede` (
  `id_cons` int(11) NOT NULL default '0',
  `id_sede` int(11) NOT NULL auto_increment,
  `id_circ` int(11) NOT NULL default '0',
  `indirizzo` varchar(50) default NULL,
  `telefono1` varchar(12) default NULL,
  `telefono2` varchar(12) default NULL,
  `fax` varchar(12) default NULL,
  `responsabile` varchar(60) default NULL,
  `mappa` blob NOT NULL,
  `filemappa` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id_sede`),
  KEY `id_cons` (`id_cons`),
  KEY `id_circ` (`id_circ`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_servizi` (
  `id_cons` int(11) NOT NULL default '0',
  `mid` int(7) NOT NULL auto_increment,
  `title` varchar(150) NOT NULL default '',
  `preamble` text NOT NULL,
  `content` text NOT NULL,
  `editimage` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`mid`),
  KEY `id_cons` (`id_cons`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE `soraldo_ele_sezioni` (
  `id_cons` int(11) NOT NULL default '0',
  `id_sez` int(11) NOT NULL auto_increment,
  `id_sede` int(11) NOT NULL default '0',
  `num_sez` int(7) NOT NULL default '0',
  `maschi` int(4) default NULL,
  `femmine` int(4) default NULL,
  `validi` int(7) NOT NULL default '0',
  `nulli` int(7) NOT NULL default '0',
  `bianchi` int(7) NOT NULL default '0',
  `contestati` int(7) NOT NULL default '0',
  `solo_gruppo` int(7) NOT NULL default '0',
  `autorizzati_m` int(4) NOT NULL default '0',
  `autorizzati_f` int(4) NOT NULL default '0',
  `voti_nulli` int(7) NOT NULL default '0',
  `validi_lista` int(7) NOT NULL default '0',
  `contestati_lista` int(7) NOT NULL default '0',
  `voti_nulli_lista` int(7) NOT NULL default '0',
  UNIQUE KEY `id_sezi` (`id_sez`),
  KEY `id_cons` (`id_cons`),
  KEY `id_sede` (`id_sede`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_tipo` (
  `tipo_cons` int(11) NOT NULL default '0',
  `descrizione` varchar(20) default NULL,
  `lingua` varchar(2) NOT NULL default '0',
  `genere` tinyint(4) NOT NULL default '0',
  `voto_g` enum('0','1') NOT NULL default '0',
  `voto_l` enum('0','1') NOT NULL default '0',
  `voto_c` enum('0','1') NOT NULL default '0',
  `circo` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`tipo_cons`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


INSERT INTO `soraldo_ele_tipo` (`tipo_cons`, `descrizione`, `lingua`, `genere`, `voto_g`, `voto_l`, `voto_c`, `circo`) VALUES 
(1, 'PROVINCIALI', 'it', 3, '0', '0', '0', '0'),
(2, 'REFERENDUM', 'it', 0, '0', '0', '0', '0'),
(3, 'COMUNALI', 'it', 5, '0', '0', '0', '0'),
(4, 'CIRCOSCRIZIONALI', 'it', 5, '0', '0', '0', '1'),
(5, 'BALLOTTAGGIO', 'it', 1, '0', '1', '0', '0'),
(6, 'CAMERA', 'it', 4, '0', '0', '1', '0'),
(7, 'SENATO', 'it', 4, '0', '0', '1', '0'),
(8, 'EUROPEE', 'it', 4, '0', '0', '0', '0'),
(9, 'REGIONALI', 'it', 5, '0', '0', '0', '0'),
(10, 'SENATO CON GRUPPI', 'it', 5, '1', '0', '1', '0'),
(11, 'CAMERA CON GRUPPI', 'it', 5, '1', '0', '1', '0');



CREATE TABLE IF NOT EXISTS `soraldo_ele_voti_candidati` (
  `id_cons` int(11) NOT NULL default '0',
  `id_cand` int(11) NOT NULL default '0',
  `id_sez` int(11) NOT NULL default '0',
  `voti` int(7) NOT NULL default '0',
  KEY `id_sez` (`id_sez`),
  KEY `id_cand` (`id_cand`),
  KEY `id_cons` (`id_cons`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_voti_gruppo` (
  `id_cons` int(11) NOT NULL default '0',
  `id_gruppo` int(11) NOT NULL default '0',
  `id_sez` int(11) NOT NULL default '0',
  `voti` int(7) NOT NULL default '0',
  KEY `id_cons` (`id_cons`),
  KEY `id_gruppo` (`id_gruppo`),
  KEY `id_sez` (`id_sez`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_voti_lista` (
  `id_cons` int(11) NOT NULL default '0',
  `id_lista` int(11) NOT NULL default '0',
  `id_sez` int(11) NOT NULL default '0',
  `voti` int(7) NOT NULL default '0',
  KEY `cons` (`id_cons`),
  KEY `id_lista` (`id_lista`),
  KEY `id_sez` (`id_sez`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;





CREATE TABLE IF NOT EXISTS `soraldo_ele_voti_parziale` (
  `id_cons` int(11) NOT NULL default '0',
  `id_sez` int(11) NOT NULL default '0',
  `id_parz` int(11) NOT NULL auto_increment,
  `orario` time NOT NULL default '00:00:00',
  `data` date NOT NULL default '0000-00-00',
  `voti_uomini` int(7) NOT NULL default '0',
  `voti_donne` int(7) NOT NULL default '0',
  `voti_complessivi` int(7) NOT NULL default '0',
  `id_gruppo` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id_parz`),
  KEY `id_cons` (`id_cons`),
  KEY `id_sez` (`id_sez`),
  KEY `id_gruppo` (`id_gruppo`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;





CREATE TABLE IF NOT EXISTS `soraldo_ele_voti_ref` (
  `id_cons` int(11) NOT NULL default '0',
  `id_gruppo` int(11) NOT NULL default '0',
  `id_sez` int(11) NOT NULL default '0',
  `si` int(7) default '0',
  `no` int(7) default '0',
  `validi` int(7) default '0',
  `nulli` int(7) default '0',
  `bianchi` int(7) default '0',
  `contestati` int(7) default '0',
  KEY `id_cons` (`id_cons`),
  KEY `id_gruppo` (`id_gruppo`),
  KEY `id_sez` (`id_sez`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


