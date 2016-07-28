<?php
namespace Agere\Module\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class AbstractService implements ServiceLocatorAwareInterface {

	use ServiceLocatorAwareTrait;

	/** @var \Zend\ServiceManager\ServiceLocatorInterface $_serviceLocator */
	//protected $_serviceLocator;

	protected static $_services = [];


	// New
	/**
	 * @param ServiceLocatorInterface $serviceLocator
	 */
	//public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	//{
	//	$this->_serviceLocator = $serviceLocator;
	//}

	/**
	 * @return ServiceLocatorInterface
	 */
	//public function getServiceLocator()
	//{
	//	return $this->_serviceLocator;
	//}



	/**
	 * @param string $key
	 * @param obj $service
	 */
	public static function addService($key, $service)
	{
		if (! isset(self::$_services[$key]))
		{
			self::$_services[$key] = $service;
		}
	}

	/**
	 * @param string $key
	 * @return mixed
	 * @deprecated
	 */
	public function getService($key)
	{
		return self::$_services[$key];
	}

	/**
	 * @param string $field
	 * @param array $items
	 * @param string $template
	 * @return array
	 */
	public function getValuesArray($field, array $items, $template = '')
	{
		$itemsArray = [];

		foreach ($items as $item)
		{
			$val = ($template != '') ? sprintf($template, $item[$field]) : $item[$field];
			$itemsArray[] = $val;
		}

		return $itemsArray;
	}

	/**
	 * @param string $field
	 * @param object[] $items
	 * @param bool $addKeyInt
	 * @return array
	 */
	public function toArrayKeyField($field, $items, $addKeyInt = false) {
		$result = [];
		$method = 'get' . ucfirst($field);
		foreach ($items as $item) {
			if (!is_object($item)) {
				$key = (isset($item[$field])) ? $item[$field] : $item[0]->$method();
			} else {
				$key = $item->$method();
			}
			if ($addKeyInt) {
				$result[$key][] = $item;
			} else {
				$result[$key] = $item;
			}
		}

		return $result;
	}

	/**
	 * @param string $valField
	 * @param object $items
	 * @param string $keyField
	 * @return array
	 */
	public function toArrayKeyVal($valField, $items, $keyField = '')
	{
		$result = [];
		$method = 'get'.ucfirst($valField);
		$methodKey = ($keyField != '') ? 'get'.ucfirst($keyField) : '';

		foreach ($items as $item)
		{
			if (! is_object($item))
			{
				$val = (isset($item[$valField])) ? $item[$valField] : $item[0]->$method();

				if ($keyField != '')
				{
					$key = (isset($item[$keyField])) ? $item[$keyField] : $item[0]->$methodKey();
				}
			}
			else
			{
				$val = $item->$method();

				if ($keyField != '')
				{
					$key = $item->$methodKey();
				}
			}

			if ($keyField != '')
			{
				$result[$key] = $val;
			}
			else
			{
				$result[] = $val;
			}
		}

		return $result;
	}

	/**
	 * @param string $field
	 * @param object[] $items
	 * @return array
	 */
	public function getIds($field, $items)
	{
		$ids = array();
		$method = 'get'.ucfirst($field);

		foreach ($items as $item)
		{
			$ids[] = $item->$method();
		}

		return array_unique($ids);
	}

	/**
	 * Filters
	 *
	 * @param array $filters
	 * @param array $data
	 * @param string $type, impossible values array or string
	 * @param bool $empty
	 * @return array
	 */
	public function filters(array $filters, $data, $type = 'string', $empty = true)
	{
		$tmpFilters = [];

		foreach ($filters as $field => $val)
		{
			if ((isset($data[$field]) && ((is_array($data[$field]) && $data[$field]) || $data[$field] = (int) $data[$field]) > 0) || $empty)
			{
				switch ($type)
				{
					case 'array':
						if (isset($data[$field]))
						{
							$tmpFilters[$field] = (! is_array($data[$field])) ? [$data[$field]] : $data[$field];

							if (is_array($data[$field]))
							{
								foreach ($tmpFilters[$field] as $key => $val2)
								{
									$tmpFilters[$field][$key] = (int) $val2;
								}
							}
						}
						else
						{
							$tmpFilters[$field] = $val;
						}
						break;
					case 'int':
						$tmpFilters[$field] = (isset($data[$field]) ? (int) $data[$field] : 0);
						break;
					case 'string':
					default:
						$tmpFilters[$field] = (isset($data[$field]) ? $data[$field] : 0);
						break;
				}
			}
		}

		return $tmpFilters;
	}

	/**
	 * @param array $filters, example ['keyTable' => [...], 'keyTable2' => [...]]
	 * @param array $post
	 * @return string
	 */
	public function getTableRequest(array $filters, array $post)
	{
		$table = '';
		$keys = array_keys($filters);

		foreach ($keys as $key)
		{
			if (array_key_exists($key, $post))
			{
				$postKeys = array_keys($post);
				$postKey = array_search($key, $postKeys);
				$table = $postKeys[$postKey];

				break;
			}
		}

		return $table;
	}

	/**
	 * @param array $items
	 * @param array $fieldsVal
	 * @param string $glue
	 * @param string $key
	 * @return array
	 */
	public function toOptions($items, array $fieldsVal = [], $glue = ', ', $key = 'id')
	{
		$options = [];
		$methodKey = 'get'.ucfirst($key);

		foreach ($items as $item)
		{
			$args = [];

			foreach ($fieldsVal as $field)
			{
				if (is_object($item))
				{
					$method = 'get'.ucfirst($field);

					if (method_exists($item, $method))
					{
						$args[] = $item->$method();
					}
					else
					{
						$method2 = $method.'s';
						$args[] = $item->$method2()->$method();
					}
				}
				else
				{
					$args[] = $item[$field];
				}
			}

			$optionKey = is_object($item) ? $item->$methodKey() : $item[$key];
			$options[$optionKey] = (count($args) == 1) ? $args[0] : implode($glue, $args);
		}

		return $options;
	}

	/**
	 * Current user
	 *
	 * @return mixed
	 */
	public function getCurrentUser()
	{
		static $currentUser;

		if (is_null($currentUser))
		{
			$viewHelper = $this->getServiceLocator()->get('viewhelpermanager');
			/** @var \Magere\User\View\Helper\User $helperUser */
			$helperUser = $viewHelper->get('user');

			$currentUser = $helperUser->current();
		}

		return $currentUser;
	}

    /**
     * @param string $mnemo, example: 'order-sale'
     * @return string, example: 'OrderSale'
     */
    public function getModuleName($mnemo)
    {
        $explode = explode('-', $mnemo);
        $moduleName = '';

        foreach ($explode as $piece)
        {
            $moduleName .= ucfirst($piece);
        }

        return $moduleName;
    }

}