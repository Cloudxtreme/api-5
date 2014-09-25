<?php

class SchemaValidator extends Validator
{
	
	/**
	 *	$intersect holds the actually validated input.
	 */
	public $intersect;
	
	/**
	 *	Validate schema
	 *
	 *	extracts rules from model schema json file.
	 *	if no json is found, 0 rules will be validated.
	 *
	 *	@return Validator
	 */
	public static function validate($input, $model)
	{

		$schema = Config::get('api.schemapath') . $model . '.json';
		
		$rules = file_exists ($schema)?
		
			json_decode (file_get_contents ($schema), true):
			array();
		
		// Check input type
		if (is_object ($input))
		
			$input = (array) $input;
			
		else if (is_string ($input))
			
			$input = json_decode ($input);
		
		// Validate
		$validator = Validator::make ($input, $rules);
		
		$validator->intersect = array_intersect_key ($input, $rules);
		
		return $validator;
	}
	
	/**
	 *	Get validated input
	 *	This function is extended to Validator in bootstrap
	 *
	 *	@return array
	 */
	 public function getValidated()
	 {
		return array_intersect_key ($this->getData(), $this->getRules());
	 }
	 
}