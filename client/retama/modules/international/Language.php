<?php
namespace Modules\International;

class Language extends \CoreModel {

	protected static $instance = null;
	protected static $language_segment = null;
	protected static $prefix = null;

	public $enabled = null;
	public $active = null;
	public $default = null;
	public $current = null;

	public static $translation_enabled;
	public static function translate($flag = true)
	{
		static::$translation_enabled = $flag;
	}

	public static function translation_language()
	{
		if(!static::$translation_enabled) return null;

		return static::current();
	}


	public static function instance()
	{
		if(static::$instance) return static::$instance;

		static::$instance = new Language;
		static::$language_segment = \Request::segment(1);

		static::$instance->enabled = Language::where('is_enabled','=',1)->get();
		static::$instance->active = array();

		foreach(static::$instance->enabled as $language)
		{
			if($language->is_default) static::$instance->default = $language;
			if($language->is_active) static::$instance->active[] = $language;
			if(static::$language_segment == $language->laravel_prefix) static::$instance->current = $language;
		}

		if(!static::$instance->current) static::$instance->current = static::$instance->default;

		return static::$instance;
	}

	public static function enabled($as = 'i18n')
	{

		if($as)
		{
			$function = 'as_'.$as;
			return static::$function(static::$instance->enabled);
		}

		return static::$instance->enabled;
	}

	public static function active($as = 'i18n')
	{

		if($as)
		{
			$function = 'as_'.$as;
			return static::$function(static::$instance->active);
		}

		return static::$instance->active;
	}

	public static function getDefault()
	{
		return static::instance()->default;
	}

	public static function current()
	{
		return static::instance()->current;
	}

	public static function url_prefix()
	{
		if(static::$prefix === null) {
			static::$prefix = static::instance()->current->laravel_prefix == static::instance()->default->laravel_prefix ? '' : static::instance()->current->laravel_prefix;
		}
		return static::$prefix;
	}

	protected static function as_i18n($languages)
	{
		$i18n = array();
		foreach($languages as $language)
		{
			$i18n[] = $language->i18n;
		}

		return $i18n;
	}

	public function is_current()
	{
		return (bool) ( $this == static::instance()->current );
	}


	public static function language_selection($view = 'international::language-selection', $display_name='display_name')
	{
		$languages = static::instance()->active;
		$prefix = static::url_prefix();
		$path = \Request::path();
		if($path == $prefix)
		{
			$path = '';
		} else {
			$prefix .= '/';
			if (substr($path, 0, strlen($prefix)) == $prefix) {
			    $path = substr($path, strlen($prefix));
			}
		}

		$arr_languages = [];
		$current_language = null;
		foreach($languages as $language)
		{
			if($language->is_current()) {
				$current_language = $language;
				continue;
			}
			$href = $language->is_default ? $path : $language->laravel_prefix .'/'. $path;
			$label = $language->{$display_name};
			$arr_languages[$label] = (object)['href'=>$href,'language'=>$language];
		}

		if(count($arr_languages) <= 0) return '';

		return \View::make($view, get_defined_vars());
	}
}
