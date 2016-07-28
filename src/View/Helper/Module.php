<?php
namespace Agere\Module\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Stdlib\Exception;

use Agere\Module\Controller\Plugin\Module as ModulePlugin;

class Module extends AbstractHelper {

	/**
	 * @var ModulePlugin
	 */
	protected $modulePlugin;

	/**
	 * @param ModulePlugin $modulePlugin
	 */
	public function __construct(ModulePlugin $modulePlugin) {
		$this->modulePlugin = $modulePlugin;
	}

	public function __invoke() {
		$params = func_get_args();
		return call_user_func_array($this->modulePlugin, $params);
	}
	
	/**
	 * @param int $valSelected
	 * @param string $title
	 * @return string
	 * @deprecated
	 */
	public function entityList($valSelected, $title) {
		die(__METHOD__);
		$translate = $this->translator;
		$strOptions = '<option value="">' . $title . '</option>';
		$collections = $this->moduleService->getItemsCollection('0');
		foreach ($collections as $collection) {
			$selected = ($collection->getId() == $valSelected) ? ' selected=""' : '';
			$strOptions .= '<option value="' . $collection->getId() . '"' . $selected . '>' . $translate($collection->getMnemo()) . '</option>';
		}

		return $strOptions;
	}

}