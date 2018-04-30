<?php
namespace Modules\Content\Models;

class Page extends \BaseModel {

	use \Modules\Media\Models\MediableTrait;
	use \Modules\Content\Models\SitemapableTrait;
	use \Modules\International\Models\TranslatableTrait;

	protected  $table = 'pages';

	protected $hidden = array();
	protected $guarded = array('id');

	public static $rules = array();
	public function get_rules()
	{
		return static::$rules;
	}


	public function save(array $options = array())
    {
	    parent::save($options);

		$this->save_sitemap('page');

		$this->save_file_from_post('main_image');
		$this->save_gallery_from_post('gallery');
    }



}
