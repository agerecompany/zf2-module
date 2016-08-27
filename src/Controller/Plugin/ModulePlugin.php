<?php
namespace Agere\Module\Controller\Plugin;

use Zend\Stdlib\Exception;
use Zend\Filter\Word\DashToCamelCase;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Agere\Module\Service\ModuleService as ModuleService;
use Agere\Current\Plugin\Current;

class ModulePlugin extends AbstractPlugin
{
    /** @var ModuleService */
    protected $moduleService;

    /** @var EntityPlugin */
    protected $entityPlugin;

    /** @var Current */
    protected $currentPlugin;

    protected $translator;

    /** @var mixed */
    protected $context;

    /**
     * @param ModuleService $moduleService
     */
    public function __construct(ModuleService $moduleService)
    {
        $this->moduleService = $moduleService;
    }

    public function injectTranslator($translator)
    {
        $this->translator = $translator;

        return $this;
    }

    public function injectCurrentPlugin(Current $current)
    {
        $this->currentPlugin = $current;

        return $this;
    }

    public function getCurrentPlugin()
    {
        if (!$this->currentPlugin) {
            $this->currentPlugin = $this->getController()->plugin('current');
            //$this->setContext($this->getCurrent()->currentModule());
            $this->setContext($this->currentPlugin->currentModule());
        }
        return $this->currentPlugin;
    }

    public function injectEntityPlugin(EntityPlugin $entityPlugin)
    {
        $this->entityPlugin = $entityPlugin;

        return $this;
    }

    public function getEntityPlugin()
    {
        if (!$this->entityPlugin) {
            $this->entityPlugin = $this->getController()->plugin('entity');
        }
        return $this->entityPlugin;
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

        $this->setContext($this->getCurrentPlugin()->currentModule());
        if ($current) {
            return $current;
        }
        //$current = $this->setContext($this->getCurrent()->currentModule())->getModule();
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
        $module = $this->moduleService->getRepository()->findOneBy(['namespace' => $context]);

        return $cache[$context] = $module;
    }

    public function setRealContext($item)
    {
        $entityPlugin = $this->getEntityPlugin();

        $className = is_object($item) ? get_class($item) : $item;

        if ($entityPlugin->isDoctrineObject($item)) {
            $className = $entityPlugin->getRealDoctrineClass($item);
        }

        $moduleName = $this->getCurrentPlugin()->currentModule($className);

        return $this->setContext($moduleName);
    }

    public function setContext($context)
    {
        $this->context = $this->getCurrentPlugin()->currentModule($context);

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

    /**
     * @param string|object $mnemo
     * @return string
     */
    public function toAlias($mnemo = null)
    {
        if (null === $mnemo) {
            $mnemo = $this->getModule()->getMnemo();
        } elseif (is_object($mnemo)) {
            $mnemo = $mnemo->getMnemo();
        }
        $alias = (new DashToCamelCase())->filter($mnemo);

        return $alias;
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