<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$prefix = Mage::getConfig()->getTablePrefix();
$installer->startSetup();
$installer->run("DROP TABLE IF EXISTS ".$prefix."foo_bar_baz;
CREATE TABLE IF NOT EXISTS ".$prefix."foo_bar_baz (
  id int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  name text NOT NULL COMMENT 'Name',
  regiao text,
  cepini int(11) NOT NULL COMMENT 'cepini',
  cepfim int(11) NOT NULL COMMENT 'cepfim',
  prazo text NOT NULL COMMENT 'prazo',
  preco decimal(10,4) NOT NULL,
  fator decimal(10,4) NOT NULL DEFAULT '1',
  PRIMARY KEY (id) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='".$prefix."foo_bar_baz' AUTO_INCREMENT=1 ;");
$installer->endSetup();
