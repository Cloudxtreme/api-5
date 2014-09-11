<?php

class SchemaValidator
{

	public static function validate($input, $model)
	{
		$schema = Config::get('api.schemapath') . $model . '.json';
		
		$rules = file_exists ($schema)?
		
			json_decode( file_get_contents ($schema), true):
			array();
		
		$return = Validator::make($input, $rules);
		
		$return->intersect = array_intersect_key($input, $rules);
		
		return $return;
	}

}