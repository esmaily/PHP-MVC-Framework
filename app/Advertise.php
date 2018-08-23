<?php


namespace App;

use App\Core\Model;

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