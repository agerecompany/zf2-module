<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 16.08.2016
 * Time: 16:45
 */
namespace Agere\Module\Service\Factory;

use Agere\Module\Service\ModuleService;

class ModuleServiceFactory 
{
    public function __invoke($sm)
    {
        $service = new ModuleService();

        return $service;
    }
}