<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\Photo;
use App\Http\Requests;
use App\AddPhotoToFlyer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPhotoRequest;

class PhotosController extends Controller
{
	/**
	 * Apply a photo to the referenced flyer.
	 *
	 * @param string $zip
	 * @param string $street
	 * @param AddPhotoRequest $request
	 */
	public function store($zip, $street, AddPhotoRequest $request)
	{
		$flyer = Flyer::locatedAt($zip, $street);
		$photo = $request->file('photo');

		(new AddPhotoToFlyer($flyer, $photo))->save();
	}

	public function destroy($id)
	{
		Photo::findOrFail($id)->delete();

		return back();
	}
}
