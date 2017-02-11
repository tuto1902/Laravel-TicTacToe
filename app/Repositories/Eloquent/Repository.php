<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\CriteriaInterface;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Criteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

abstract class Repository implements RepositoryInterface, CriteriaInterface {

	private $app;
	protected $model;
	protected $criteria;


	public function __construct(App $app) {
		$this->app = $app;
		$this->criteria = new Collection();
		$this->makeModel();
	}

	abstract function model();

	public function makeModel() {
		$model = $this->app->make($this->model());

		if (!$model instanceof Model)
			throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");

		return $this->model = $model;
	}

	public function all($columns = ['*'])
	{
		$this->applyCriteria();
		return $this->model->select($columns)->get();
	}

	public function paginate($perPage = 15, $columns = ['*'])
	{
		$this->applyCriteria();
		return $this->model->select($columns)->paginate($perPage);
	}

	public function create(array $data)
	{

	}

	public function update(array $data, $id)
	{

	}

	public function delete($id)
	{

	}

	public function find($id, $columns = ['*'])
	{
		$this->applyCriteria();
		return $this->model->select($columns)->find($id);
	}

	public function findBy($field, $value, $columns = ['*'])
	{

	}

	public function first($columns = ['*'])
	{
		$this->applyCriteria();
		return $this->model->select($columns)->first();
	}

	public function pushCriteria(Criteria $criteria)
	{
		$this->criteria->push($criteria);
		return $this;
	}

	public function getCriteria()
	{
		return $this->criteria;
	}

	public function applyCriteria()
	{

		foreach($this->getCriteria() as $criteria){
			if($criteria instanceof Criteria){
				$this->model = $criteria->apply($this->model);
			}


		}

		return $this;
	}

	public function resetCriteria()
	{
		$this->criteria = null;
		$this->criteria = new Collection();
		$this->makeModel();

		return $this;
	}
}
