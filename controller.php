<?php       

namespace Concrete\Package\SimpleAccordion;
use Package;
use BlockType;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{

	protected $pkgHandle = 'simple_accordion';
	protected $appVersionRequired = '5.7.1';
	protected $pkgVersion = '1.0.1';
	
	
	
	public function getPackageDescription()
	{
		return t("Add Collapsible Content to your Site");
	}

	public function getPackageName()
	{
		return t("Vivid Simple Accordion");
	}
	
	public function install()
	{
		$pkg = parent::install();
        BlockType::installBlockTypeFromPackage('vivid_simple_accordion', $pkg); 
        
	}
}
?>