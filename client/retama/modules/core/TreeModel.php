<?php

class TreeModel extends CoreModel {

	// ABSTRACT
	// requires	child classes to have this fields:
	// parent_id, tree_left, tree_right

	public function save(array $options = array())
	{
		$model = get_class($this);
		if(isset($options['parent']))
		{
			$parent = $options['parent'];
			unset($options['parent']);
		}
		else
		{
			$parent = $model::by_id($this->parent_id);
		}

		//var_dump($parent->id); die();
		//$this->path = $parent->get_full_path().$this->perma;

		if(!$this->id)
		{
			// make room;
			$pleft = $parent->tree_left;
			$pright = $parent->tree_right;

			$this->tree_left = $pright;
			$this->tree_right = $pright + 1;

			//$q = "UPDATE {$this->table} SET tree_left = tree_left + 2 where tree_left > $pright";
			DB::update('UPDATE '.$this->table.' SET tree_left = tree_left + 2 where tree_left > ?', array($pright));
			//$q = "UPDATE {$this->table} SET tree_right = tree_right + 2 where tree_right >= $pright";
			DB::update('UPDATE '.$this->table.' SET tree_right = tree_right + 2 where tree_right >= ?', array($pright));

		} else {
			// check parent !
		}

		$this->check_slug($parent->path);

		if($this->has_column('indent'))
		{
			$this->indent = $parent->indent + 1;
		}

		return parent::save($options);
	}

	public function check_parent($parent_id)
	{
		if(!$this->parent_id) return; // no need, is new

		if($this->parent_id == $parent_id) return; // no need, same parent



		/* calculamos el gap */
		$gap = $this->calc_gap();
		$left = $this->tree_left;

		/* nos salimos */
		$this->move_out();
		/* cerramos el gap en el viejo parent */
		$this->close_gap($gap, $left);

		/* abrimos gap en el nuevo parent */
		$new_parent = static::find($parent_id);
		$new_left = $new_parent->tree_right;
		$this->open_gap($gap, $new_left);

		/* volvemos */
		$this->move_in($new_left);


		$this->check_slug($new_parent->path);

		DB::update('UPDATE '.$this->table.' SET parent_id = ? WHERE id = ?', array($parent_id, $this->id));

		$this->parent_id = $parent_id;

	}

	public function move($new_parent_id, $previous_id = null)
	{

		/* calculamos el gap */
		$gap = $this->calc_gap();
		$left = $this->tree_left;

		/* nos salimos */
		$this->move_out();

		/* cerramos el gap  */
		$this->close_gap($gap, $left);

		/* abrimos el nuevo gap */
		if($previous_id)
		{
			$node = static::find($previous_id);
			$new_left = $node->tree_right + 1;
		} else {
			$node = static::find($new_parent_id);
			$new_left = $node->tree_left + 1;
		}

		$this->open_gap($gap, $new_left);

		/* volvemos */
		$this->move_in($new_left);

		if($this->parent_id != $new_parent_id )
		{
			if($node->id != $new_parent_id)  $node = static::find($new_parent_id);
			$this->check_slug($node->path);

			DB::update('UPDATE '.$this->table.' SET parent_id = ?, path = ?, slug = ?  WHERE id = ?', array($new_parent_id, $this->path, $this->slug, $this->id));

			$this->parent_id = $new_parent_id;
		}
	}

	public function calc_gap()
	{
		return (abs($this->tree_right) - abs($this->tree_left)) + 1;
	}

	public function  open_gap($gap = 2, $position) // position es el punto de insesión
	{
		DB::update('UPDATE '.$this->table.' SET tree_left = tree_left+? WHERE tree_left >= ?', array($gap, $position));
		DB::update('UPDATE '.$this->table.' SET tree_right = tree_right+? WHERE tree_right >= ?', array($gap, $position));
	}

	public function close_gap($gap, $position) // position es el tree_left del node que se quita!
	{
		DB::update('UPDATE '.$this->table.' SET tree_left = tree_left-? WHERE tree_left > ?', array($gap, $position));
		DB::update('UPDATE '.$this->table.' SET tree_right = tree_right-? WHERE tree_right >= ?', array($gap, $position));
	}

	public function move_out()
	{
		$left = $this->tree_left;
		$right = $this->tree_right;

		DB::update('UPDATE '.$this->table.' SET tree_left = tree_left * -1, tree_right = tree_right * -1 WHERE tree_left >= ? AND tree_right <= ?', array($left, $right));

	}

	public function move_in($new_left)
	{
		$diff = $new_left - abs($this->tree_left);

		DB::update('UPDATE '.$this->table.' SET tree_left = (tree_left * -1) + ?, tree_right = (tree_right * -1) + ? WHERE tree_left < 0', array($diff, $diff));

	}

	public static function destroy($ids = null)
	{
		$count = 0;

		$ids = is_array($ids) ? $ids : func_get_args();


		$instance = new static;

		// We will actually pull the models from the database table and call delete on
		// each of them individually so that their events get fired properly with a
		// correct set of attributes in case the developers wants to check these.
		$key = $instance->getKeyName();

		foreach ($instance->whereIn($key, $ids)->get() as $model)
		{
			foreach($instance->whereRaw('tree_left >'.$model->tree_left.' AND tree_right < '.$model->tree_right)->get() as $submodel)
			{
				if($submodel->delete()) $count++;
			}
			if ($model->delete())
			{
				$count++;

				$left = $model->tree_left;
				$right = $model->tree_right;

				// close the gap
				$diff = ($right-$left)+1;

				//$q = "UPDATE {$this->table} SET tree_left = tree_left-$diff WHERE tree_left > $left;";
				DB::update('UPDATE '.$model->table.' SET tree_left = tree_left-? WHERE tree_left > ?', array($diff, $left));
				//$q = "UPDATE  {$this->table} SET tree_right = tree_right-$diff WHERE tree_right >= $left;";
				DB::update('UPDATE '.$model->table.' SET tree_right = tree_right-? WHERE tree_right >= ?', array($diff, $left));
			}

		}

		return $count;
	}

	public function parent()
    {
        return $this->belongsTo(get_class(new static), 'parent_id');
    }
    public function children()
    {
		return $this->hasMany(get_class(new static),'parent_id')->orderBy('tree_left');
    }

    public function parent_path()
    {
	    return $this->parent()->with('parent_path');
    }

	public function children_path()
    {
	    return $this->children()->with('children_path');
    }

	function has_children($item_id = NULL)
	{
		if($item_id)
		{
			//$class = new static;
			$item = static::by_id($item_id);
		}
		else
		{
			$item = $this;
		}

		return (($item->tree_right - $item->tree_left) > 1);
	}

	public function children_count()
	{
		return (($this->tree_right - $this->tree_left) - 1) / 2;
	}
	public function is_child_of($node)
	{
		$flag = (($this->tree_left > $node->tree_left) && ($this->tree_right < $node->tree_right));
		return $flag;
	}
	public function is_parent_of($node)
	{
		return (($node->tree_left > $this->tree_left) && ($node->tree_right < $this->tree_right));
	}

	public function check_slug($parent_slug)
	{

		$columns = \Schema::getColumnListing($this->table);
		if(!in_array('slug', $columns)) return;

		$parent_slug = rtrim($parent_slug,'/');
		$parent_slug AND $parent_slug .= '/';
		$this->path = $parent_slug.$this->slug;


	    //$slug = Str::slug($title);
		$slug_count = count( $this::whereRaw("path REGEXP '^{$this->path}(-[0-9]*)?$'")->where('id','!=',$this->id?:0)->get() );

		if($slug_count > 0)
		{
			$this->slug =  "{$this->slug}-{$slug_count}";
			$this->path = $parent_slug.$this->slug;
		}
	}



	public function dosort($ids = array())
	{
		$model = get_class($this);

		is_array($ids) || $ids = array($ids);
		if(count($ids) < 2 ) return false;

		$first = new $model();
		$first->by_id($ids[0]);

		$parent = new $model();
		$parent->by_id($first->parent_id);

		//$start = $parent->tree_left;
		$start = -10000;
		$new_diff_to_parent = 1;
		foreach($ids as $id)
		{
			$node = new $model();
			$node->by_id($id);

			$left = $node->tree_left;
			$right = $node->tree_right;

			$current_diff_to_parent = ($node->tree_left - $start);
			$diff = $current_diff_to_parent - $new_diff_to_parent;


			$q = "UPDATE {$this->table} set tree_left = tree_left - ($diff), tree_right = tree_right - ($diff) WHERE tree_left >= $left and tree_right <= $right";
			$this->query($q);
			$new_diff_to_parent += (($right-$left)+1);
		}

		$diff = 10000+$parent->tree_left;
		$q = "UPDATE {$this->table} set tree_left = tree_left + ($diff), tree_right = tree_right + ($diff) WHERE tree_left < 0";
			$this->query($q);
	}











	public function as_tree()
	{
		$ret = array();
		$main_node = new \Node();
		$class = get_class($this);
		foreach($this->query_records as $record)
		{
			$object = new $class;
			$object->hydrate($record);
			new \Node($record->id, $record->parent_id, $object);
		}

		return $main_node;
	}

	public function render_tree($envelope,$child_envelope)
	{
		$by_parent = array();

		foreach($this->query_records as $record)
		{
			if(!isset($by_parent[$record->parent_id])) $by_parent[$record->parent_id] = array();
			$by_parent[$record->parent_id][] = $record;
		}
		$this->by_parent = $by_parent;

		return $this->parse_tree($this->by_parent[0]);
	}

	public function parse_tree($items)
	{
		$html = '<ul>';
		foreach($items as $item)
		{
			$arr_data = array();
			foreach($item as $key => $value)
			{
				$value = htmlentities($value);
				//$arr_data[] = "'$key':'$value'";
				$attrs = 'data-'.$key.'="'.$value.'"';
				$arr_data[] = $attrs;
			}

			$html .= '<li>';
			if($item->parent_id != 0)
			{
				//$html .= '<a href="#" data="{'.addslashes(implode(',',$arr_data)).'}">'.$item->title.'</a>';
				//$html .= '<a href="#" data="'.htmlentities(json_encode($arr_data)).'">'.$item->title.'</a>';

				$html .= '<a href="#" '.implode(' ',$arr_data).'>'.$item->title.'</a>';
			}

			if(isset($this->by_parent[$item->id]) && count($this->by_parent[$item->id]) )
			{
				$html .= $this->parse_tree($this->by_parent[$item->id]);
			}
			$html .= '</li>';
		}

		$html .= '</ul>';
		return $html;
	}


	public function path_to($dir='ASC', $language = null)
	{
		$class = get_class($this);

		$model = new $class();

		if($language) $model->translate($language);

		$model->where('tree_left <=', $this->row_data->tree_left)
			->where('tree_right >=', $this->row_data->tree_right)
			->where('id !=',1)
			->order_by('tree_left')
			->get_records();

		return $model;
	}

	public function update_children($fields = array())
	{
		$class = get_class($this);
		$model = new $class();

		$model->where('tree_left >', $this->tree_left)
			->where('tree_right <', $this->tree_right)
			->update($fields);
		//echo($model->last_query()); die();
	}

}