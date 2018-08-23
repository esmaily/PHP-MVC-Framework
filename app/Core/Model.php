<?php

namespace App\Core;


use App\Core\Exceptions\FoundException;

class Model

{
	private $_database;
	protected $_table = NULL;
	protected $_fields = [];
	protected $_primaryKey = 'id';
	private static $_fetchMode = \PDO::FETCH_ASSOC;

	public function __construct ()
	{
		$this->_setFields();
		if ($this->_table === NULL) {
			$this->_table = Enviroment::get('database')['table_prefix'] . $this->tableOfModel();
		}
		$this->_initDatabase();
	}

	# try connect to database
	private function _initDatabase ()
	{
		$database = Enviroment::get('database');
		$Dsn      = "{$database['driver']}:host={$database['host']};dbname={$database['dbname']};charset={$database['charset']}";
		try {
			$this->_database = new Database($Dsn, $database['username'], $database['password']);
		} catch (\PDOException $Error) {
			echo "Database Error " . $Error->getMessage();
		}
	}

	private function _setFields ()
	{
		foreach ($this->_fields as $key => $field) {
			unset($this->_fields[$key]);
			$this->_fields[$field] = NULL;
		}

	}

	# Get Table name as Class
	public static function table ($tableName)
	{
		$_class = '\\App\\' . ucfirst($tableName);

		return new $_class;
	}

	# Run Raw Query Database
	public static function query ($sql, $params = [])
	{
		$own    = new self;
		$handel = $own->getDatabase()->prepare($sql);
		$handel->execute($params);

		return $handel->fetchAll(self::$_fetchMode);
	}

	# Select as Database width differ Arguments
	public function select ($arguments)
	{
		$fields = [];
		foreach ($arguments as $prop => $conf) {
			if (is_array($conf)) {
				$comb             = ' ' . (isset($conf[2]) ? strtoupper($conf[2]) : 'AND') . ' ';
				$op               = isset($conf[1]) ? $conf[1] : '=';
				$fields[]         = $comb . wrapValue($prop) . $op . ':' . $prop;
				$arguments[$prop] = $conf[0];
			} else {

				$fields[] = wrapValue($prop) . '=:' . $prop;
			}

		}
		$fields = ltrim(implode(' ', $fields), 'AND');
		$query  = "SELECT *  FROM  {$this->_table} WHERE {$fields}";
		$stmt   = $this->getDatabase()->prepare($query);
		$stmt->execute($arguments);
		$result = $stmt->fetchAll();
		d($query);
		return $this->_convertRowToObject($result);
	}

	# Get First Column
	public static function first ($key)
	{
		$class  = get_called_class();
		$object = new $class;
		$table  = $object->getTable();
		$pk     = $object->_primaryKey;
		$query  = "SELECT * FROM  `{$table}` WHERE `{$pk}` = :{$pk}";
		$stmt   = $object->getDatabase()->prepare($query);
		$stmt->execute([$pk => $key]);
		$result = $stmt->fetch(self::$_fetchMode);

		return $object->_convertRowToObject($result);
	}

	public static function find ($key)
	{
		$class  = get_called_class();
		$object = new $class;
		$table  = $object->getTable();
		$pk     = $object->_primaryKey;
		$query  = "SELECT * FROM  `{$table}` WHERE `{$pk}` = :{$pk}";
		$stmt   = $object->getDatabase()->prepare($query);
		$stmt->execute([$pk => $key]);
		$result = $stmt->fetch(self::$_fetchMode);

		return $result;

	}

	# Select as Database width differ Arguments
	public function lists ($key = 'id', $val = 'name')
	{
		$query = "SELECT {$key} `key`,{$val} `value` FROM {$this->_table} WHERE 1=1 ";
		d($query);
		$handel = $this->getDatabase()->prepare($query);
		$handel->execute();
		$result  = $handel->fetchAll(self::$_fetchMode);
		$returns = [];
		foreach ($result as $item => $value) {
			$returns[$value['key']] = $value;
		}

		return $returns;
	}

	# Select as Database By Param
	public function findBy ($value, $params)
	{

		$query = "SELECT *  FROM  `{$this->_table}` WHERE `{$params}` = :{$params}";

		$stmt = $this->getDatabase()->prepare($query);
		$stmt->execute([$params => $value]);
		$result = $stmt->fetchAll(self::$_fetchMode);

		return $this->_convertRowToObject($result);
	}

	# Get All Records Table
	public static function all ($fields = NULL)
	{
		$class  = get_called_class();
		$object = new $class;
		$table  = $object->getTable();
		if ($fields == NULL) {
			$sql = "SELECT * FROM `{$table}` ORDER BY `id` DESC ";
		} elseif (is_string($fields)) {
			$sql = "SELECT `$fields` FROM `{$table}` ORDER BY `id` DESC ";
		} elseif (is_array($fields)) {
			$fields = implode(',', wrapValue($fields));
			$sql    = "SELECT {$fields} FROM `{$table}` ORDER BY `id` DESC ";
		}

		return Model::query($sql);

	}

	# Save Or Update Record
	public function save ()
	{
		$this->getFields();
		$keys       = array_keys($this->_fields);
		$fields     = implode(',', wrapValue($keys));
		$keysParams = wrapValue($keys, ':', '');
		$countMarks = implode(',', $keysParams);
		$query      = "INSERT INTO `{$this->_table}`  ({$fields}) VALUES ({$countMarks})";
		$result     = $this->getDatabase()->prepare($query)->execute($this->_fields);

		return $result;
	}

	public function update ()
	{

		$fields = $this->_fields;
		$pkKey  = $this->_primaryKey;
		unset($fields[$pkKey]);
		$fields = implode(',', wrapValue(array_keys($fields), '`', 'var'));
		$query  = "UPDATE `{$this->_table}` SET  {$fields} WHERE `{$pkKey}` =:{$pkKey}";

		return $this->getDatabase()->prepare($query)->execute($this->_fields);
	}

	# Get Id From Last Record Insert
	public function lastId ()
	{
		return $this->getDatabase()->lastInsertId();
	}

	# Delete Record as Object Class
	public function delete ()
	{
		$pk    = $this->_primaryKey;
		$query = "DELETE FROM  `{$this->_table}` WHERE `{$pk}` = :{$pk}";

		return $this->getDatabase()->prepare($query)->execute([$pk => $this->_fields[$pk]]);
	}

	# Check Valid Fields
	public function validate ($request, $rules)
	{
		Validator::check($request, $rules);
		$errors = Validator::error();

		return count($errors) === 0 ? TRUE : FALSE;
	}

	# Row Change Into Object
	private function _convertRowToObject ($resource)
	{
		$objects = [];
		$check   = count($resource) == count($this->_fields) ? TRUE : FALSE;
		if (count($resource) > 0):
			foreach ($resource as $in => $row) {
				$className = get_class($this);
				$object    = new $className;
				$fields    = array_keys($object->_fields);
				foreach ($fields as $fieldName) {
					$check ? $object->$fieldName = $resource[$fieldName] : $object->$fieldName = $row[$fieldName];
				}

				$objects[] = $object;
			}

			return $check ? $objects[0] : $objects;
		endif;

		return $resource;

	}

	private function tableOfModel ()
	{
		$class = get_called_class();
		$class = str_replace('App\\', '', $class);
		$class = strtolower($class) . 's';

		return $class;
	}

	# Setter
	public function __set ($name, $value)
	{
		$class = get_class($this);
		if (in_array($name, array_keys($this->_fields))) {
			return $this->_fields[$name] = $value;
		}
		(new FoundException)->run('Property Error ', "The Property (<b >{$name}</b>) dose not exists in  <b>{$class}</b> class s ");
	}

	# Getter
	public function __get ($name)
	{

		if (in_array($name, $this->_fields)) {
			return $this->_fields[$name];
		}
		(new FoundException)->run('Property Error', "The Property({$name}) dose not exists  ");
	}

	# Register Optional func For Work Width Database
	public function __call ($func, $args)
	{
		$funcName = $func;
		if (substr($funcName, 0, strlen('findBy')) === 'findBy') {
			$prop = strtolower(ltrim($funcName, 'findBy'));
			if (in_array($prop, array_keys($this->_fields))) {
				$args[] = $prop;

				return call_user_func_array([$this, 'findBy'], $args);
			}
		} elseif (substr($funcName, 0, strlen('find')) === 'find') {
			if (!is_int($args[0])) {
				if (isset($args[0])) {
					foreach ($args[0] as $prop => $value) {
						if (!in_array($prop, array_keys($this->getFields()))) {
							(new FoundException())->run("Property Error", "Property {$prop} No Is This class");
						}

						return call_user_func_array([$this, 'select'], $args);
					}
				}
			} elseif (is_int($args[0])) {
				//				echo 'is int';
				return call_user_func_array([$this, 'first'], $args);
			}


		}

	}

	# Return Fields
	public function getFields ()
	{
		return $this->_fields;
	}

	# Return Database
	public function getDatabase ()
	{
		return $this->_database;
	}

	# Return Table name
	public function getTable ()
	{
		return $this->_table;
	}

}