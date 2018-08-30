<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Phone : 09145985243
 *
 * */

namespace App\Core;

class Validator
{
	private static $_errors = [];
	private static $_errorMessages;
	private static $_isError;
	private static $_fieldCaption;

	public static function check ($fields, $rules)
	{

		self::$_errorMessages = Language::get('validator');
		self::$_fieldCaption  = Language::get('fields');
		self::$_errors        = [];
		self::$_isError       = [];
		foreach ($fields as $field => $value) {
			$rule = in_array($field,array_keys($rules)) ? $rules[$field] : FALSE;
			$rulePart = explode('|',$rule);
			if (strlen($rule) > 0 && (in_array('required',$rulePart) || strlen($value) >0)) {
				$check = self::_checkValid($value, $rules[$field], $field);
				if (strlen($check) !== 0) {
					self::$_errors[$field] = $check;
				}
			}
		}
		return self::$_errors;
	}

	public static function error ()
	{
		$errorMessage=[];
		foreach(self::$_errors as $key=>$value)
		{
			if(strlen($value) !==1)
			{
				$errorMessage[$key]=$value;
			}
		}
		return $errorMessage;
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
			$error = call_user_func_array([$className, $ruleFunc], $ruleParts);

			if ($error !== TRUE && !in_array($field, self::$_isError)) {
				self::$_isError[] = $field;
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

		return ($value == '' || $value === NULL || strlen($value) <= 0) ? $error : TRUE;
	}

	private static function _isInteger ($field, $value)
	{
		$field = self::$_fieldCaption[$field];
		$error = $error = self::_getError('integer', [$field]);

		return (!is_numeric($value) || gettype($value) !== 'integer') ? $error : TRUE;
	}

	private static function _isString ($field, $value)
	{
		$field = self::$_fieldCaption[$field];
		$error = self::_getError('string', [$field]);

		return (!is_string($value) || gettype($value) !== 'string') ? $error : TRUE;
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
		$error = self::_getError('min', [$field, $min]);

		return (strlen($value) < $min) ? $error : TRUE;
	}

	private static function _isEmail ($field, $value)
	{
		$field = self::$_fieldCaption[$field];
		$error = self::_getError('email', [$field]);

		return (!filter_var($value, FILTER_VALIDATE_EMAIL)) ? $error : TRUE;

	}

	private static function _isUrl ($field, $value)
	{
		$field = self::$_fieldCaption[$field];
		$error = self::_getError('url', [$field]);

		return (!filter_var($value, FILTER_VALIDATE_URL)) ? $error : TRUE;
	}

	private static function _isImage ($field, $value)
	{
		$field      = self::$_fieldCaption[$field];
		$error      = self::_getError('image', [$field]);
		$extensions = ['png', 'jpg', 'jpeg', 'gif', 'svg', 'bmp', 'tiff'];
		$value      = explode('.', $value);
		$value      = end($value);

		return !in_array($value, $extensions) ? $error : TRUE;
	}

	private static function _isMimes ($field, $value, $format)
	{

		$field  = self::$_fieldCaption[$field];
		$error  = self::_getError('mimes', [$field, $format]);
		$format = explode(',', $format);
		$value  = explode('.', $value);
		$value  = end($value);

		return !in_array($value, $format) ? $error : TRUE;

	}

}