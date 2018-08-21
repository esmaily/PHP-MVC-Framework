<?php

namespace App\Controllers;
use App\{
	Advertise, Http\Controller, Http\Model, Http\Request, Http\Session, Http\Validator
};

class AdvertiseController extends Controller
{
	# show create form advertise
	public function createAction ()
	{
		$this->render('advertise.create');
	}

	# Show Advertise by identifier
	public function showAction ($id)
	{
		$advertise = Model::table('advertise')->first($id);
		$details   = getData([$advertise['type'], $advertise['code']]);

		$this->render('advertise.show', compact('advertise', 'details'));
	}

	# store new Advertise
	public function storeAction (Request $request)
	{
		$code              = shuffleKey();
		$poster            = $request->file('poster');
		$advertise         = new Advertise();
		$advertise->title  = $request->post('title');
		$advertise->type   = $request->post('type');
		$advertise->poster = $poster;
		$advertise->code   = $code;
		$validate          = $advertise->validate($request->all(),[
			'title' =>'required|string|in:3',
			'type' =>'required|string',
			'poster'=>'required|image|max:2048|mimes:jpg,png,gif',
			'code'=>'required'
		]);
		$errors=Validator::error();
		if ($validate) {
			if($poster) $request->store('advertises', $poster);
			$video             = $request->file('video');
			if($video) $request->store('advertises', $video);
			sleep(1);
			$pod              = $request->file('pod');
			if($pod) $request->store('advertises', $pod);
			$advertise->save();
			if ($request->post('type') == 'business'):
				$advertise = [
					"description" => $request->post('description'),
					"category"=>$request->post('category'),
					"media"       => [
						"images" => $request->post('images'),
						"videos" => $video,
						"pods"   => $pod,
					],
					"contact_us"  => [
						"website"  => $request->post('website'),
						"address"  => $request->post('address'),
						"email"    => $request->post('email'),
						"phone"    => $request->post('phone'),
						"home"     => $request->post('home'),
						"telegram" => $request->post('telegram'),
					],
				];
			elseif ($request->post('type') == 'needed'):
				$advertise = [
					"description" => $request->post('description'),
					"price"       => $request->post('price'),
					"category"=>$request->post('category'),
					"land"=>$request->post('land'),
					"media"       => [
						"images" => $request->post('images'),
					],
					"contact_us"  => [
						"address" => $request->post('address'),
					],
				];
			endif;
			storeData([$request->post('type'), $code], $advertise);
			$this->redirect('/');

		}else{

			$this->render('advertise/create',['errors'=>$errors]);
		}
	}
}