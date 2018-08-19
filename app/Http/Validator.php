<?php

namespace App\Http;

class Validator
{
	private static $_errors = [];
	private static $_errorMessages;
	private static $_fieldCaption;

	public static function check ($fields, $rules)
	{

		self::$_errorMessages = Language::get('validator');
		self::$_fieldCaption  = Language::get('fields');
		self::$_errors = [];
		foreach ($fields as $field => $value) {
			$rule = $rules[$field];
			if (!($rule == '')) {
				$check = self::_checkValid($value, $rules[$field], $field);
				dump($check);
				if (strlen($check) !==0) {
					self::$_errors[$field] = $check;
				}
			}
		}
		return self::$_errors;
	}

	public static function error ()
	{
		return self::$_errors;
	}

	private static function _checkValid ($value, $rules, $field)
	{
		$rules     = explode('|', $rules);
		$className = get_class();
		foreach ($rules as $rule) {
			$ruleParts = explode(':', $rule);
			$ruleName  = array_shift($ruleParts);
			if ($ruleName === '') {
				return TRUE;
			}
			$ruleFunc = '_is' . ucfirst($ruleName);
			array_unshift($ruleParts, $value);
			array_unshift($ruleParts, $field);
			d($ruleFunc);
			$error = call_user_func_array([$className, $ruleFunc], $ruleParts);
			if ($error !== TRUE) {
				return $error;
			}
		}

		return TRUE;
	}

	private static function _getError ($funcName, $props)
	{
		array_unshift($props, self::$_errorMessages[$funcName]);

		return call_user_func_array('sprintf', $props);
	}

	private static function _isRequired ($field, $value)
	{

		$field = self::$_fieldCaption[$field];
		$error = self::_getError('required', [$field]);
		return ($value == '' || $value === NULL || strlen($value) <= 0) ? $error : '';
	}

	private static function _isNumber ($field, $value)
	{
		$field = self::$_fieldCaption[$field];
		$error = $error = self::_getError('number', [$field]);

		return (!is_numeric($value)) ? $error : TRUE;
	}

	private static function _isString ($field, $value)
	{
		$field = self::$_fieldCaption[$field];
		$error = self::_getError('string', [$field]);

		return (!is_string($value)) ? $error : TRUE;
	}

	private static function _isMax ($field, $value, $max)
	{
		$field = self::$_fieldCaption[$field];
		$error = self::_getError('max', [$field, $max]);;
		return (strlen($value) > $max) ? $error : TRUE;
	}

	private static function _isMin ($field, $value, $min)
	{
		$field = self::$_fieldCaption[$field];
		$error = self::_getError('min', [$field,$min]);
		return (strlen($value) < $min) ? $error : TRUE;
	}

	private static function _isEmail ($field, $value)
	{
		$field = self::$_fieldCaption[$field];
		$error = self::_getError('email', [$field]);
		$error = self::_getError('required', [$field]);

		return (!filter_var($value, FILTER_VALIDATE_EMAIL)) ? $error : TRUE;

	}

	private static function _isUrl ($field, $value)
	{
		$field = self::$_fieldCaption[$field];
		$error = self::_getError('url', [$field]);
		return (!filter_var($value, FILTER_VALIDATE_URL)) ? $error : TRUE;
	}

	private static function _isImage($field,$value)
	{
		echo 'image func';
		d([$field,$value]);
	}

	private static function _isMimes($field,$value,$format)
	{
		d($format);
	}

}