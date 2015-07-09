<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class GearsTable extends Table
{

	public function validationDefault(Validator $validator)
	{
		return $validator
		->notEmpty('name', 'A username is required')
		->notEmpty('type', 'A type is required');
	}

	public function isOwnedBy($gearId, $userId)
	{
		return $this->exists(['id' => $gearId, 'user_id' => $userId]);
	}
}