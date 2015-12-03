<?php

namespace App;

use Image;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @property mixed path
 */
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
	 * The base directory, where photos are stored
	 *
	 * @var string
	 */
	protected $baseDir = 'images/photos';

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
	 * Build a new photo instance from a file upload.
	 *
	 * @param string $name
	 * @return self
	 */
	public static function named($name)
	{

		return (new static)->saveAs ($name);
	}

	public function saveAs($name)
	{
		$this->name = sprintf ("%s-%s", time (), $name);
		$this->path = sprintf ("%s/%s", $this->baseDir, $this->name);
		$this->thumbnail_path = sprintf ("%s/tn-%s", $this->baseDir, $this->name);

		return $this;

	}

	public function move(UploadedFile $file)
	{
		$file->move ($this->baseDir, $this->name);

		$this->makeThumbnail();

		return $this;

	}

	public function makeThumbnail()
	{
		Image::make ($this->path)
			->fit (200)
			->save ($this->thumbnail_path);
	}
}