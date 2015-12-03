<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController {

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $user;

	/**
	 * Controller constructor.
	 */
	public function __construct()
	{
		$this->user = Auth::user ();

		view ()->share ('signedIn', Auth::check ());
		view ()->share ('user', $this->user);
	}
}