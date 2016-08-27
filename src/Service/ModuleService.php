<?php
namespace Agere\Module\Service;

use Doctrine\ORM\EntityRepository;
use	Agere\Module\Service\AbstractModuleService;
use Agere\Core\Service\DomainServiceAbstract;
use Agere\Module\Model\Module;

class ModuleService extends DomainServiceAbstract
{
	protected $entity = Module::class;

	//protected $_repositoryName = 'module';


	/**
	 * @param string hidden
	 * @return mixed
	 */
	public function getItemsCollection($hidden = '')
	{
		/** @var \Doctrine\Common\Persistence\Mapping\Driver\FileDriver */

		/** @var \Magere\Module\Model\Repository\ModuleRepository $repository */
		$repository = $this->getRepository($this->_repositoryName);

		return $repository->findAllItems($hidden);
	}

	/**
	 * @param int $id
	 * @param string $field
	 * @return mixed
	 */
	public function getOneItem($id, $field = 'id')
	{
		/** @var \Magere\Module\Model\Repository\ModuleRepository $repository */
		$repository = $this->getRepository($this->_repositoryName);

		return $repository->findOneItem($id, $field);
	}

}