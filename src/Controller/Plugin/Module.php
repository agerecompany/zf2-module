<?php
namespace Agere\Module\Controller\Plugin;

use Zend\Stdlib\Exception;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Agere\Module\Service\ModuleService as ModuleService;
use Agere\Current\Plugin\Current;

class Module extends AbstractPlugin
{
    /** @var ModuleService */
    protected $moduleService;

    /** @var Current */
    protected $current;

    protected $translator;

    /** @var mixed */
    protected $context;

    /**
     * @param ModuleService $moduleService
     * @param Current $current
     */
    public function __construct(ModuleService $moduleService, Current $current)
    {
        $this->moduleService = $moduleService;
        $this->current = $current;
        $this->setContext($this->current->currentModule());
    }

    public function injectTranslator($translator)
    {
        $this->translator = $translator;

        return $this;
    }

    public function get($name = null)
    {
        $module = $this->getModule();
        if ($name === null) {
            return $module;
        }
        $method = 'get' . ucfirst($name);
        if (method_exists($module, $method)) {
            return $module->{$method}();
        }

        return false;
    }

    public function current()
    {
        static $current;
        $this->setContext($this->current->currentModule());
        if ($current) {
            return $current;
        }
        //$current = $this->setContext($this->current->currentModule())->getModule();
        $current = $this->getModule();

        return $current;
    }

    public function getModule()
    {
        static $cache = [];
        $context = $this->getContext();
        if (isset($cache[$context])) {
            return $cache[$context];
        }
        $module = $this->moduleService->getOneItem($context, 'namespace');

        return $cache[$context] = $module;
    }

    public function setRealContext($item)
    {
        $className = is_object($item) ? get_class($item) : $item;
        /** @var \Doctrine\ORM\Mapping\ClassMetadata $class */
        $om = $this->moduleService->getModuleManager();
        $class = $om->getMetadataFactory()->getMetadataFor($className);
        $moduleName = $class->isInheritanceTypeSingleTable()
            ? $this->current->currentModule(get_parent_class($className))
            : $this->current->currentModule($className);

        return $this->setContext($moduleName);
    }

    public function setContext($context)
    {
        $this->context = $this->current->currentModule($context);

        return $this;
    }

    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param $id
     * @param string $field
     * @return mixed
     * @deprecated
     */
    public function getBy($id, $field = 'id')
    {
        return $this->moduleService->getOneItem($id, $field);
    }

    public function __invoke()
    {
        $context = null;
        if ($args = func_get_args()) {
            $context = $args[0];
        }

        return $this->setContext($context);
    }
}
