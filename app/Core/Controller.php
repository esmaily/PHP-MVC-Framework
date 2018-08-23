<?php

namespace App\Http;

use App\Http\View;

class Controller
{
	protected $viewBag;

	public function __construct ()
	{
		// echo 'this new system<br>';
		$this->viewBag = [];
	}
	#  Render View as resource/views/$path
	protected function render ($viewPath, $data = [])
	{
		 View::render($viewPath, $data);
	}

	protected function redirect ($route, $params = NULL)
	{
		$this->viewBag = $params ??  $this->viewBag;
		$r             = Route::getRouteAction($route, ['method' => 'GET']);
		$route         = $route === '/' ? '' : $route;
		if ($r) {
			Session::set('viewBag', $this->viewBag);
			header("location: " . BASE. '/' . $route);
			exit();
		} else {
			throw new \Exception("redirect \error {{$route}} URL !", 1);
		}
	}
}