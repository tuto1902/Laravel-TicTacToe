<?php


namespace App\Repositories\Contracts;


use App\Repositories\Criteria;

interface CriteriaInterface
{
	public function pushCriteria(Criteria $criteria);
	public function getCriteria();
	public function applyCriteria();
	public function resetCriteria();
}