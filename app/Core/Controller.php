<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Email : jaffar9898@gmail.com
 *
 * */

namespace App\Core;

use App\Core\View;

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

	# Redirect Custom Url
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