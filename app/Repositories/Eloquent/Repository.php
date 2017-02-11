<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\CriteriaInterface;
use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Criteria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

abstract class Repository implements RepositoryInterface {

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
		return $this->model->select($columns)->get();
	}

	public function paginate($perPage = 15, $columns = ['*'])
	{
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
		return $this->model->select($columns)->find($id);
	}

	public function findBy($field, $value, $columns = ['*'])
	{

	}

	public function first($columns = ['*'])
	{
		return $this->model->select($columns)->first();
	}
}
