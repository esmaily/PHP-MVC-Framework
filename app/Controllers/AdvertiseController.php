<?php

namespace App\Controllers;
use App\{
	Advertise, Core\Controller, Core\Model, Core\Request, Core\Session, Core\Validator
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
		$advertise = Model::table('advertise')->find($id);
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
			'title' =>'required|string|min:3',
			'type' =>'required|string',
			'poster'=>'required|image|max:2048|mimes:jpg,png,gif',
			'email'=>'email',
		]);
		$errors=Validator::error();
		if ($validate) {
			$advertise->save();
			$this->redirect('/');

		}else{
			$this->render('advertise/create',['errors'=>$errors]);
		}
	}
}