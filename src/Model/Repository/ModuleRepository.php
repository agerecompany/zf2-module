<?php
namespace Agere\Module\Model\Repository;

use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityRepository as EntityRepositoryORM;

class ModuleRepository extends EntityRepositoryORM {

	protected $_table = 'module';
	protected $_alias = 'm';


	/**
	 * @param string hidden
	 * @return array
	 */
	public function findAllItems($hidden = '')
	{
		$rsm = new ResultSetMapping;

		$rsm->addEntityResult($this->getEntityName(), $this->_alias);
		$rsm->addFieldResult($this->_alias, 'id', 'id');
		$rsm->addFieldResult($this->_alias, 'mnemo', 'mnemo');

		$where = ($hidden != '') ? "WHERE {$this->_alias}.`hidden` = ?" : '';

		$query = $this->_em->createNativeQuery(
			"SELECT {$this->_alias}.`id`, {$this->_alias}.`mnemo`
			FROM {$this->_table} {$this->_alias}
			{$where}",
			$rsm
		);

		if ($hidden != '')
		{
			$query = $this->setParametersByArray($query, [$hidden]);
		}

		return $query->getResult();
	}

	/**
	 * @param int $id
	 * @param string $field
	 * @return mixed
	 */
	public function findOneItem($id, $field = 'id')
	{
		$rsm = new ResultSetMapping;

		$rsm->addEntityResult($this->getEntityName(), $this->_alias);
		$rsm->addFieldResult($this->_alias, 'id', 'id');
		$rsm->addFieldResult($this->_alias, 'namespace', 'namespace');
		$rsm->addFieldResult($this->_alias, 'mnemo', 'mnemo');

		$query = $this->_em->createNativeQuery(
			"SELECT {$this->_alias}.`id`, {$this->_alias}.`namespace`, {$this->_alias}.`mnemo`
			FROM {$this->_table} {$this->_alias}
			WHERE {$this->_alias}.`{$field}` = ?
			LIMIT 1",
			$rsm
		);

		$query = $this->setParametersByArray($query, [$id]);

		$result = $query->getResult();

		if (count($result) == 0)
		{
			$result = $this->createOneItem();
		}
		else
		{
			$result = $result[0];
		}

		return $result;
	}

}