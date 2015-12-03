<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model {

	/**
	 * Fillable fields for a flyer
	 *
	 * @var array
	 */
	protected $fillable = [
		'street',
		'city',
		'state',
		'country',
		'zip',
		'price',
		'description'
	];

	/**
	 * Find the flyer at a given address.
	 *
	 * @param string $zip
	 * @param string $street
	 * @return Builder
	 */
	public static function locatedAt($zip, $street)
	{
		$street = str_replace('-', ' ', $street);

		return static::where(compact('zip', 'street'))->first();
	}

	public function getPriceAttribute($price)
	{
		return '$' . number_format($price);
	}

	/**
	 * @param Photo $photo
	 * @return Model
	 */
	public function addPhoto(Photo $photo)
	{
		return $this->photos()->save($photo);
	}


	/**
	 * A flyer is composed of many photos.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\Hasmany
	 */
	public function photos()
	{
		return $this->hasMany ('App\Photo');
	}
}
