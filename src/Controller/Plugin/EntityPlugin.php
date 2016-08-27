<?php
namespace Agere\Module\Controller\Plugin;

use Zend\Stdlib\Exception;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Filter\Word\DashToCamelCase;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Persistence\Proxy;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\UnitOfWork;
use Agere\Core\Service\ServiceManagerAwareTrait;
use Agere\Current\Plugin\Current;

class EntityPlugin extends AbstractPlugin/* implements ObjectManagerAwareInterface*/
{
    use ProvidesObjectManager;
    use ServiceManagerAwareTrait;

    /** @var Current */
    protected $currentPlugin;

    public function __construct()
    {
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
            //$this->setContext($this->currentPlugin->currentModule());
        }
        return $this->currentPlugin;
    }

    /**
     * @param object $item
     * @return string
     */
    public function getRealDoctrineClass($item)
    {
        $className = is_object($item) ? get_class($item) : $item;

        /** @var ObjectManager $om */
        $om = $this->getObjectManager();
        /** @var \Doctrine\ORM\Mapping\ClassMetadata $class */
        $class = $om->getMetadataFactory()->getMetadataFor($className);

        if ($class->isInheritanceTypeSingleTable()) {
            $className = get_parent_class($className);
        } elseif ($item instanceof Proxy) {
            $className = ClassUtils::getClass($item);
        } else {
            $className = ClassUtils::getRealClass($className);
        }

        return $className;
    }

    /**
     * @param string|object $class
     *
     * @return boolean
     */
    public function isDoctrineObject($class)
    {
        if (is_object($class)) {
            $class = ClassUtils::getClass($class);
        }
        $om = $this->getObjectManager();

        return !$om->getMetadataFactory()->isTransient($class);
    }

    public function isManaged($item)
    {
        return (UnitOfWork::STATE_MANAGED === $this->getObjectManager()->getUnitOfWork()->getEntityState($item));
    }

    public function isRemoved($item)
    {
        return (UnitOfWork::STATE_REMOVED === $this->getObjectManager()->getUnitOfWork()->getEntityState($item));
    }

    public function isDetached($item)
    {
        return (UnitOfWork::STATE_DETACHED === $this->getObjectManager()->getUnitOfWork()->getEntityState($item));
    }

    public function isNew($item)
    {
        return (UnitOfWork::STATE_NEW === $this->getObjectManager()->getUnitOfWork()->getEntityState($item));
    }

    /**
     * Does item contain status object? If not then status is saved in related object.
     *
     * @param string|object $item
     * @param string $property
     * @return bool
     * @link https://github.com/borisguery/bgylibrary/blob/master/library/Bgy/Doctrine/EntitySerializer.php#L87
     */
    public function getMainObjectClassOld($item, $property) {
        static $depth = 0, $maxDepth = 1;

        $className = is_object($item) ? get_class($item) : $item;

        if (property_exists($item, $property)) {
            return $className;
        } elseif ($depth < $maxDepth) {
            /** @var ClassMetadata $metadata */
            $om = $this->getObjectManager();

            $metadata = $om->getClassMetadata($className);

            foreach ($metadata->associationMappings as $field => $mapping) {
                //if ($mapping['type'] === ClassMetadata::ONE_TO_ONE || ) {
                if (in_array($mapping['type'], [ClassMetadata::ONE_TO_ONE, ClassMetadata::MANY_TO_ONE])) {
                    $itemClass = $mapping['targetEntity'];
                    //$getter = 'get' . ucfirst($field);
                    //$itemWithStatus = $item->{$getter}() ?: new $targetEntity();

                    $depth++;
                    $assigned = $this->getMainObjectClass($itemClass, $property);
                    $depth--;

                    if ($assigned) {
                        //$setter = 'set' . ucfirst($field);
                        //$itemWithStatus->getId() ? : $item->{$setter}($itemWithStatus);

                        return $assigned;
                    }
                }
            }

            throw new Exception\RuntimeException(sprintf(
                'Cannot find main object in "%s" with property "%s" and related objects with relation OneToOne or ManyToOne',
                $className,
                $property
            ));
        }

        return false;
    }

    public function getMainObjectClass($item, $property)
    {
        $className = is_object($item) ? get_class($item) : $item;

        if (property_exists($item, $property)) {
            return $className;
        } elseif ($assigned = $this->getMainObjectClassProperty($className, $property)) {
            //$assigned = $this->getMainObjectClassProperty($className, $property);
            return $assigned['class'];
        } else {
            return false;
        }
    }

    public function getMainObjectClassProperty($item, $property)
    {
        static $depth = 0, $maxDepth = 1;

        $className = is_object($item) ? get_class($item) : $item;

        if ($depth < $maxDepth) {
            /** @var ClassMetadata $metadata */
            $om = $this->getObjectManager();

            $metadata = $om->getClassMetadata($className);

            foreach ($metadata->associationMappings as $field => $mapping) {
                //if ($mapping['type'] === ClassMetadata::ONE_TO_ONE || ) {
                if (in_array($mapping['type'], [ClassMetadata::ONE_TO_ONE, ClassMetadata::MANY_TO_ONE])) {
                    $itemClass = $mapping['targetEntity'];
                    //$getter = 'get' . ucfirst($field);
                    //$itemWithStatus = $item->{$getter}() ?: new $targetEntity();

                    $depth++;
                    $assigned = $this->getMainObjectClass($itemClass, $property);
                    $depth--;

                    if ($assigned) {
                        //$setter = 'set' . ucfirst($field);
                        //$itemWithStatus->getId() ? : $item->{$setter}($itemWithStatus);

                        return ['class' => $assigned, 'property' => $field];
                    }
                }
            }

            throw new Exception\RuntimeException(sprintf(
                'Cannot find main object in "%s" with related objects with relation OneToOne or ManyToOne',
                $className
            ));
        } else {
            return false;
        }
    }

    public function find($id, $module)
    {
        $sm = $this->getServiceManager();
        $moduleName = $alias = (new DashToCamelCase())->filter($module->getMnemo());
        $service = $sm->get($moduleName . 'Service');
        $item = $service->find($id);

        return $item;
    }

    public function __invoke()
    {
        return $this;

        /*$context = null;
        if ($args = func_get_args()) {
            $context = $args[0];
        }

        return $this->setContext($context);*/
    }
}
