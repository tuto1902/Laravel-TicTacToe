<?php

namespace App\Model\Traits;

trait HasCompositePrimaryKey
{

	protected function setKeysForSaveQuery(Builder $query)
	{
		foreach ($this->getKeyName() as $key) {
			if (isset($this->$key))
				$query->where($key, '=', $this->$key);
			else
				throw new Exception(__METHOD__ . 'Missing part of the primary key: ' . $key);
		}

		return $query;
	}

	protected function getKeyForSaveQuery($keyName = null)
	{
		if(is_null($keyName)){
			$keyName = $this->getKeyName();
		}

		if (isset($this->original[$keyName])) {
			return $this->original[$keyName];
		}

		return $this->getAttribute($keyName);
	}

	public function find($ids, $columns = ['*'])
	{
		$me = new self;
		$query = $me->newQuery();
		foreach ($me->getKeyName() as $key) {
			$query->where($key, '=', $ids[$key]);
		}
		return $query->first($columns);
	}

}