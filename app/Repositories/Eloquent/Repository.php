<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as App;

abstract class Repository implements RepositoryInterface {

	private $app;
	protected $model;


	public function __construct(App $app) {
		$this->app = $app;
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

	}

	public function paginate($perPage = 15, $columns = ['*'])
	{

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

	}

	public function findBy($field, $value, $columns = ['*'])
	{

	}
}
