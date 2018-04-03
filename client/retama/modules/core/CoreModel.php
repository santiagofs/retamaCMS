<?php
namespace Modules\Core;

class CoreModel extends \Eloquent {



	protected $table_columns = null;
	protected function get_columns()
	{
		if(! $this->table_columns )
		{
			$this->table_columns = Schema::getColumnListing($this->getTable());
		}
		return $this->table_columns;
	}

	protected function has_column($key)
	{
		return in_array($key, $this->get_columns());
	}

	public static $rules = array();
	public function get_rules()
	{
		return static::$rules;
	}



	public function input_hydrate()
	{
		$this->fill(\Input::all());
	}

	public function get_value($field_name)
	{

		$arr = explode('.', $field_name);
		if(count($arr)>1)
		{

			$related = array_shift($arr);

			$field_name = implode('.', $arr);

			if(!$this->$related) return null;

			return $this->$related->get_value($field_name);
		}


		$default_func = $field_name.'_default';
		$format_func = $field_name.'_format';

		$value = $this->$field_name;
		// var_dump($field_name); var_dump($value);
		$value = (!$value && method_exists($this,$default_func)) ? $this->$default_func() : $value;
		$value = method_exists($this,$format_func) ? $this->$format_func($value) : $value;

		return $value;


	}

	public function fill(array $attributes)
	{
		//$columns = Schema::getColumnListing($this->getTable());
		$fill = array();

		foreach($attributes as $key => $value)
		{
			if($this->has_column($key)) $fill[$key] = $value;
		}
		parent::fill($fill);
	}

	protected function input_preprocess()
	{
		return \Input::all();
	}

	public function input_validate()
	{
		if ( ! Request::isMethod('post')) return false;

		$input = $this->input_preprocess();

		$validator = Validator::make($input, $this->get_rules());
		return $validator;
	}

	public function by_id($id)
	{
		$model = $this->find($id);
		$model OR $model = $this;
		return $model;
	}


	/* check if class inherits from traits */

	public static function is_mediable($class_name = null)
	{
		$class_name || $class_name = get_called_class();
		return in_array('Modules\Media\Models\MediableTrait',class_uses($class_name) );

	}


	public static function fields_config()
	{
		return [];
	}



}