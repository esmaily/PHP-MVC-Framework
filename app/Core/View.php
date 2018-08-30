<?php
/*
 * 18th National Skills Competition  trade of Web Design And Development
 * Competitor : Seyed Jaffar Esmaili
 * GitHub : esmaily
 * Email : jaffar9898@gmail.com
 *
 * */

namespace App\Core;

use App\User;

class View {

	
	public static function render($viewPath,$data=[])
	{
		$data['app'] = [
			'user' => Session::get('user'),
			'baseUrl' =>BASE,
			'publicUrl' =>URL['PUBLIC'],
			'storage'=>ENV['STORAGE'],
		];
		extract($data);
		$path=  str_replace('.',DS, $viewPath) . VIEW['EXTENSION'];
		# Register And Call Twig Class
		$loader = new \Twig_Loader_Filesystem( VIEW['PATH']);
		$twig = new \Twig_Environment($loader /*['cache' => '/path/to/compilation_cache']*/);

		# Add custom func for use view
		$twig->addFunction(new \Twig_SimpleFunction('app',function() use ($data){
			return $data['app'];
		}));;
		$twig->addFunction(new \Twig_SimpleFunction('storage',function ($path,$name){
			return URL['PUBLIC'] ."storage/{$path}/{$name}";
		}));
		$twig->addFunction(new \Twig_SimpleFunction('errors',function ($key){
			return Session::get($key);
		}));
		$twig->addFunction(new \Twig_SimpleFunction('category',function ($type){
			 switch ($type)
			{
				 case 'electronic':
				 		return 'الکترونیکی';
				 	break;
				 case 'landed':
					 return 'املاک';
					 break;
				 case 'service':
					 return 'خدماتی';
					 break;
				 case 'shoping':
					 return 'فروشگاهی';
					 break;
				 case 'buy-center':
					 return 'مرکز خرید';
					 break;
			}
		}));
		echo $twig->render($path, $data);
	}
}