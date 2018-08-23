<?php


namespace App\Http\Exceptions;


class FoundException extends \Exception
{
	private static $_typeExceptions;
	private $_exceptions;

	public function run ($title=NULL, $message=NULL,$file=NULL,$line=NULL)
	{
		print_r($this->templateException($title, $message,$file,$line));
	}

	public static function init ()
	{
		self::$_typeExceptions = [
			1 => 'Fatal Exception',
			2 => 'Warning',
			4 => 'Parse Exception ',
			8 => 'Notice',
		];
//		ini_set('display_errors', 0);
		error_reporting(E_ALL);
		register_shutdown_function('handler');
	}

	public function handler ()
	{
		if (is_null($exceptionDetail = error_get_last()) === FALSE) {
			foreach ($exceptionDetail as $key => $value) {
				$this->_exceptions[$key] = $value;
			}
			print_r(self::templateException());
		}
	}

	private function templateException ($title = NULL, $exception = NULL,$file=NULL,$line=NULL)
	{

		$title     = $title == NULL ? self::$_typeExceptions[$this->_exceptions['type']] : $title;
		$file     = $file == NULL ? $this->_exceptions['file']: $file;
		$line     = $line == NULL ? $this->_exceptions['line'] : $line;
		$exception = $exception == NULL ? $this->_exceptions['message'] : $exception;
		$type      = $this->customColor($this->_exceptions['type']);
		$message   = "<body style='margin: 0;padding: 0'><div style='text-align: center;margin: 0 auto;background: #eee;padding:5% 10%;height: 100%;'>";
		$message   .= "<div style='border:1px solid {$type};border-radius:15px;background: #eee;text-align: left;'>";
		$message   .= "<div class='header' style='padding: 10px 4%;font-weight: bold;background: #ddd;border-top-left-radius: 15px;border-top-right-radius: 15px'>";
		$message   .= "<h3 style='font-size: 22px;font-family: Tahoma;color: #333'>Exception:  ";
		$message   .= "<span style='font-size: 20px;color:{$type};text-transform: capitalize;'>{$title}";
		$message   .= "</span></h3></div>";
		$message   .= "<div class='body' style='padding:10px 4%;background: #fff;border-bottom-left-radius: 15px;border-bottom-right-radius: 15px'>";
		$message   .= "<p style='font-size: 18px;color: #333;'><span style='text-transform: capitalize;font-weight: bolder'>File : </span>{$file}</p>";
		$message   .= "<p style='font-size: 18px;color: #333;'><span style='text-transform: capitalize;font-weight: bolder'>In Line : </span>{$line}</p>";
		$message   .= "<p style='text-transform: capitalize;font-size: 18px;color: #333;'><span style='text-transform: capitalize;font-weight: bolder'>Message : </span>{$exception}</p>";
		$message   .= "</div>";
		$message   .= "</div></div></body>";

		return $message;
	}

	private function customColor ($type)
	{
		switch ($type) {
			case 1:
				return '#c33';
				break;
			case 2:
				return '#e90';
				break;
			case 8:
				return 'ecd474';
				break;
			default:
				return '#6d6d6d';
		}
	}
}