<?php
/**
 * Module helper factory
 *
 * @category Agere
 * @package Agere_Module
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 04.02.15 10:30
 */

namespace Agere\Module\Controller\Plugin\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;

use Agere\Module\Controller\Plugin\ModulePlugin;

class ModulePluginFactory {

	public function __invoke(ServiceLocatorInterface $cpm) {
		$sm = $cpm->getServiceLocator();

		//$om = $sm->get('Doctrine\ORM\EntityManager');
		//$cpm = $sm->get('ControllerPluginManager');
		$vhm = $sm->get('ViewHelperManager');

		//$config = $sm->get('Config');
		$current = $cpm->get('current');
		$entity = $cpm->get('entity');
		//$formElement = $vhm->get('formElement');
		$translator = $vhm->get('translate');

		//$changer = $sm->get('StatusChanger');
		$moduleService = $sm->get('ModuleService');

		return (new ModulePlugin($moduleService/*, $current*/))
			->injectCurrentPlugin($current)
			->injectEntityPlugin($entity)
			->injectTranslator($translator)
			;
	}

}