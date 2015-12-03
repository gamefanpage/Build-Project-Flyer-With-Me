<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\Http\Requests\ChangeFlyerRequest;
use App\Photo;
use Illuminate\Http\Request;
use App\Http\Requests\FlyerRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FlyersController extends Controller {

	public function __construct()
	{
		$this->middleware ('auth', ['except' => ['show']]);

		parent::__construct ();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view ('flyers.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  FlyerRequest $request
	 * @return Response
	 */
	public function store(FlyerRequest $request)
	{
		Flyer::create ($request->all ());

		flash ()->success ('Success!', 'Your flyer has been created.');

		return redirect ()->back (); // temporary
	}


	/**
	 * Display the specified resource.
	 *
	 * @param $zip
	 * @param $street
	 * @return Response
	 */
	public function show($zip, $street)
	{
		$flyer = Flyer::locatedAt ($zip, $street);

		return view ('flyers.show', compact ('flyer'));
	}

	/**
	 * Apply a photo to the referenced flyer.
	 *
	 * @param string $zip
	 * @param string $street
	 * @param ChangeFlyerRequest $request
	 */
	public function addPhoto($zip, $street, ChangeFlyerRequest $request)
	{
		$photo = $this->makePhoto ($request->file ('photo'));

		Flyer::locatedAt ($zip, $street)->addPhoto ($photo);
	}

	/**
	 * Setup a new photo.
	 *
	 * @param UploadedFile $file
	 * @return mixed
	 */
	public function makePhoto(UploadedFile $file)
	{
		return Photo::named ($file->getClientOriginalName ())->move ($file);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request $request
	 * @param  int $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
}
