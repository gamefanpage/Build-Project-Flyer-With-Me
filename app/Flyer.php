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
	 * @return Flyer
	 */
	public static function locatedAt($zip, $street)
	{
		$street = str_replace('-', ' ', $street);

		return static::where(compact('zip', 'street'))->firstOrFail();
	}

	/**
	 * @param Photo $photo
	 * @return Photo
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

	public function getPriceAttribute($price)
	{
		return '$' . number_format($price);
	}

	/**
	 * A flyer is owned by a user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function owner()
	{
		return $this->belongsTo('App\User', 'user_id');
	}

	/**
	 * Determine if the given user created the flyer.
	 *
	 * @param User $user
	 * @return boolean
	 */
	public function ownedBy(User $user)
	{
		return $this->user_id == $user->id;
	}
}
