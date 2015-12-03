<?php

namespace App;

use Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class Photo extends Model {

	/**
	 * The associated table
	 *
	 * @var string
	 */
	protected $table = 'flyer_photos';

	/**
	 * Fillable fields for a photo
	 *
	 * @var array
	 */
	protected $fillable = ['path', 'name', 'thumbnail_path'];

	/**
	 * The UploadedFile instance
	 *
	 * @var UploadedFile
	 */
	protected $file;

	/**
	 * When a photo is created, prepare a thumbnail, too.
	 *
	 * @return void
	 */
	protected static function boot()
	{
		static::creating (function ($photo)
		{
			return $photo->upload ();
		});
	}

	/**
	 * A photo belongs to a flyer.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function flyer()
	{
		return $this->belongsTo ('App\Flyer');
	}

	/**
	 * Make a new photo instance from an uploaded file.
	 *
	 * @param UploadedFile $file
	 * @return self
	 */
	public static function fromFile(UploadedFile $file)
	{
		$photo = new static;

		$photo->file = $file;

		return $photo->fill ([
			'name'           => $photo->fileName (),
			'path'           => $photo->filePath (),
			'thumbnail_path' => $photo->thumbnailPath ()
		]);
	}

	public function fileName()
	{
		$name = sha1 (
			time () . $this->file->getClientOriginalName ()
		);

		$extension = $this->file->getClientOriginalExtension ();

		return "{$name}.{$extension}";
	}

	public function filePath()
	{
		return $this->baseDir () . '/' . $this->fileName ();
	}

	public function thumbnailPath()
	{
		return $this->baseDir () . '/tn-' . $this->fileName ();
	}

	/**
	 * The base directory, where photos are stored
	 *
	 * @return string
	 */
	public function baseDir()
	{
		return 'images/photos';
	}

	/**
	 * Move the photo to the proper folder.
	 *
	 * @return self
	 */
	public function upload()
	{
		$this->file->move ($this->baseDir (), $this->fileName ());

		$this->makeThumbnail ();

		return $this;

	}

	/**
	 * Create a thumbnail for the photo.
	 *
	 * @return void
	 */
	public function makeThumbnail()
	{
		Image::make ($this->filePath ())
			->fit (200)
			->save ($this->thumbnailPath ());
	}
}