<?php

namespace App;


use App\Core\Model;

class User extends Model
{
	public function __construct ()
	{
		parent::__construct();
		$this->_fields = ['id' => NULL, 'username' => NULL, 'password' => NULL, 'email' => NULL];
		$this->setInitialFields([
			'id'=>['default'=>true,'readable'=>TRUE,'editable'=>TRUE,'rules'=>'required|number'],
			'username'=>['rules'=>'required|string|min:3'],
			'email'=>['editable'=>TRUE,'readable'=>TRUE,'rules'=>'required|email'],
			'password'=>['rules'=>'required|min:5'],
		]);
	}
}