<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Phone : 09145985243
 *
 * */

namespace App;

use App\Core\Model;

class Advertise extends Model
{

//	protected $_table='tableName'
//	protected $_primaryKey='tablePrimaryKey'

	protected $_fields = [
		'id',
		'title',
		'type',
		'poster',
		'code',
	];
}