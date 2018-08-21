<?php


namespace App;

use App\Http\Model;

class Advertise extends Model
{

	protected $_fields =[
		'id',
		'title',
		'type',
		'poster',
		'code'
	];

//		parent::__construct();

//		$this->setInitialFields([
//			'id'=>['default'=>NULL],
//			'title'=>['rules'=>'required|string|min:3'],
//			'type'=>['rules'=>'required|string'],
//			'poster'=>['rules'=>'required|image|max:2048|mimes:jpg,,png,gif'],
//			'code'=>['rules'=>'required'],
//		]);

}