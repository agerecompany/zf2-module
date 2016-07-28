<?php
/**
 * Module helper factory
 *
 * @category Agere
 * @package Agere_Module
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 04.02.15 10:30
 */

namespace Agere\Module\View\Helper\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;

use Agere\Module\View\Helper\Module as ModuleHelper;

class ModuleFactory {

	public function __invoke(ServiceLocatorInterface $vhm) {
		$sm = $vhm->getServiceLocator();

		//$om = $sm->get('Doctrine\ORM\ModuleManager');
		$cpm = $sm->get('ControllerPluginManager');
		//$vhm = $sm->get('ViewHelperManager');

		//$config = $sm->get('Config');
		//$current = $cpm->get('current');
		//$formElement = $vhm->get('formElement');
		//$translator = $vhm->get('translate');

		//$changer = $sm->get('StatusChanger');
		//$moduleService = $sm->get('ModuleService');

		$modulePlugin = $cpm->get('module');

		return new ModuleHelper($modulePlugin);
	}

}