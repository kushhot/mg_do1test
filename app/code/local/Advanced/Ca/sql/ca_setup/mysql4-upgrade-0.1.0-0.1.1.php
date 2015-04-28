<?php

$installer = $this;

$installer->startSetup();

$this->addAttribute('customer_address', 'resaletrue', array(
	'type' => 'varchar',
	'input' => 'text',
	'label' => 'Resale New#',
	'global' => 1,
	'visible' => 1,
	'required' => 0,
	'user_defined' => 1,
	'visible_on_front' => 1
));


if (version_compare(Mage::getVersion(), '1.6.0', '<='))
{
	$customer = Mage::getModel('customer/address');
	$attrSetId = $customer->getResource()->getEntityType()->getDefaultAttributeSetId();
	$this->addAttributeToSet('customer_address', $attrSetId, 'General', 'resaletrue');
}

if (version_compare(Mage::getVersion(), '1.4.2', '>='))
{
	Mage::getSingleton('eav/config')
	->getAttribute('customer_address', 'resaletrue')
	->setData('used_in_forms', array('customer_register_address','customer_address_edit','adminhtml_customer_address'))
	->save();
}

$tablequote = $this->getTable('sales/quote_address');
$installer->run("
ALTER TABLE  $tablequote ADD  `resaletrue` varchar(255) NOT NULL
");

$tablequote = $this->getTable('sales/order_address');
$installer->run("
ALTER TABLE  $tablequote ADD  `resaletrue` varchar(255) NOT NULL
");

$installer->endSetup(); 