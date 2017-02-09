<?php


namespace App\Repositories;


abstract class Criteria
{
	public abstract function apply($model);
}