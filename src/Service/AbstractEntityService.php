<?php
/**
 * Abstract Module Service contain Doctrine related methods
 *
 * @category Agere
 * @package Agere_Agere
 * @author Popov Sergiy <popov@agere.com.ua>
 * @datetime: 29.01.2016 19:48
 */
namespace Agere\Module\Service;

abstract class AbstractModuleService extends AbstractService {

	protected $_entityAlias = '';

	protected $_repository = [];

	protected static $_repositories = [];


	/**
	 * @return \Doctrine\ORM\ModuleManager
	 */
	public function getEntityManager() {
		return $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
	}

	/**
	 * @param string $entityAlias
	 * @return \Agere\Model\Repository\ModuleRepository|null
	 * @todo Rename to getRepositoryByAlias
	 */
	public function getRepositoryAlias($entityAlias) {
		if (!isset($this->_repository[$entityAlias])) {
			$aliases = $this->getServiceLocator()->get('config')['service_manager']['aliases'];
			$this->_repository[$entityAlias] = (isset($aliases[$entityAlias]))
				? $this->getEntityManager()->getRepository($aliases[$entityAlias])
				: null;
		}

		return $this->_repository[$entityAlias];
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	public function getRepository($key = null) {
		if (null === $key) {
			return $this->getEntityManager()->getRepository($this->entity);
		}
		return self::$_repositories[$key];
	}

	public function setRepository($key) {
		if (!isset(self::$_repositories[$key])) {
			self::$_repositories[$key];
		}
	}

	/**
	 * @param array $criteria, example ['field' => 'val', 'field2' => array values]
	 * @return array
	 */
	public function getCollections(array $criteria = []) {
		$repository = $this->getRepositoryAlias($this->_entityAlias);

		return $repository->findCollections($criteria);
	}

	/**
	 * @param array $criteria , example ['field' => 'val', 'field2' => array values]
	 * @return \Magere\Cart\Model\Cart
	 */
	public function getOneCollectionBy(array $criteria = []) {
		$item = $this->getCollections($criteria);

		return $item ? current($item) : $this->getRepositoryAlias($this->_entityAlias)->createOneItem();
	}

}