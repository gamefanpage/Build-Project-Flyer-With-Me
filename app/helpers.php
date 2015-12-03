<?php
use App\Flyer;

/**
 * Display a flash message.
 *
 * @param string $title
 * @param string $message
 * @return void
 */
function flash($title = null, $message = null)
{
	$flash = app ('App\Http\Flash');

	if (func_num_args () == 0)
	{
		return $flash;
	}

	return $flash->info ($title, $message);
}

/**
 * The path to a given flyer.
 *
 * @param Flyer $flyer
 * @return string
 */
function flyer_path(Flyer $flyer)
{
	return $flyer->zip. '/'. str_replace(' ', '-', $flyer->street);
}