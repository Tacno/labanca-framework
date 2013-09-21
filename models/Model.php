<?php

namespace La
{
	abstract class Model extends \ActiveRecord\Model
	{
		public static $prefix = DB_PREFIX;

		public $scenario = '';
		
		public function get_labels(){}
		public function get_rules(){}

		/**
		 * Method to get only a label
		 * If $field is undefined, return all of them
		 * @param string $field
		 * @return array || string
		 */
		public function get_label($field = false)
		{
			$labels = $this->get_label();

			if($field)
				return (isset($labels[$field])) ? $labels[$field] : $field;
			else
				return $labels;
		}

		public function validateModel()
		{
			$rules = $this->get_rules();

			foreach($rules as $r):

				// Get Rule
				$method = 'val_' . $r[1];
				if(method_exists($this, $method))
				{
					$this->$method($r);
				}

			endforeach;
		}

		protected function val_required($rule)
		{
			$fields = explode(',',$rule[0]);

			foreach($fields as $f)
			{
				if($this->$f == "") {
					$this->errors->add($f,"The field '$f' cannot be blank.");
				}
			}
		}

		protected function val_email($rule)
		{
			$fields = explode(',',$rule[0]);

			foreach($fields as $f)
			{
				if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$this->$f)){
					$this->errors->add($f,"The field '$f' must be an email.");
				}
			}
		}

		protected function val_max($rule)
		{
			$fields = explode(',',$rule[0]);

			foreach($fields as $f)
			{
				if(strlen($this->$f) > $rule[2])
					$this->errors->add($f,"The field '$f' must be {$rule[2]} chars on max.");
			}
		}

		protected function val_min($rule)
		{
			$fields = explode(',',$rule[0]);
		
			foreach($fields as $f)
			{
				if(strlen($this->$f) < $rule[2])
					$this->errors->add($f,"The field '$f' must be {$rule[2]} chars on min.");
			}
		}

		protected function val_integer($rule)
		{
			$fields = explode(',',$rule[0]);

			foreach($fields as $f)
			{
				if(!is_numeric($this->$f))
					$this->errors->add($f,"The field '$f', must be numeric.");
			}
		}

		protected function val_url($rule)
		{
			$fields = explode(',',$rule[0]);

			foreach($fields as $f)
			{
				if(preg_match('@^(?:http://)?([^/]+)@i',$this->$f))
					$this->errors->add($f, "The field '$f' must be an URL. (Begin with http:// or https://).");
			}
		}

		protected function val_unique($rule)
		{
			$fields = explode(',',$rule[0]);
			$class = get_class($this);

			foreach($fields as $f)
			{
				$temp = $class::find('firts',array('conditions' => array($f . ' = "'.$this->$f.'"','id != ' . $this->id)));
				if($temp != null)
					$this->errors->add($f,"There is a " . $f . " in our database, please try again.");
			}
		}
	}
}
?>