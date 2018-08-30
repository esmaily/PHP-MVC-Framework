<?php


namespace App;

use App\Http\Model;

class Advertise extends Model
{

//	protected $_table='classadvertise';
	protected $_fields = [
		'id',
		'title',
		'type',
		'poster',
		'code',
	];
}