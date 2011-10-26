<?php

/* @var $installer WebTricks_Core_Module_Setup */
$installer = $this;
$installer->startSetup();
$installer->run("
CREATE TABLE `core_modules` (
  `module` varchar(50) NOT NULL default '',
  `version` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Resource version registry';
");

$installer->endSetup();