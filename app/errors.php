<?php

/*
 *	Exception Classes
 */


if (!class_exists ('InvalidParameterException'))
{
	class InvalidParameterException extends Exception
    {

        private $_errors;

        public function __construct ($message="", $errors = array(), $code = 0, Exception $previous = null)
        {
            parent::__construct($message, $code, $previous);

            $this->_errors = $errors;
        }

        public function getErrors() { return $this->_errors; }

    }
}


/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code, $fromConsole)
{

	Log::error($exception);


    return json_encode (array ('message'=> $exception->getMessage ()));


});