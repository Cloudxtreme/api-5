<?php

/*
 *	Exception Classes
 */


if (!class_exists ('InvalidParameterException'))
{
	class InvalidParameterException extends Exception
    {

        private $_errors;

        public function __construct ($message="", $errors = array(), $code = 600, Exception $previous = null)
        {
            parent::__construct($message, $code, $previous);

            $this->_errors = $errors;
        }

        public function getErrors() { return $this->_errors; }

        public function __toString()
        {
            return isset ($this->_errors)? json_encode ($this->_errors) : $this->getMessage ();
        }

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

    // Custom exceptions
    switch ($exception->getCode()) {

        // 6xx: Custom Exception Error
        case 600:
            // class InvalidParameterException - default status code 600
            return json_encode (array ('message' => $exception->getMessage (), 'messages' => $exception->getErrors()));

    }


    // Laravel exceptions (ex: App::abort(404, 'Service not found');)
    switch ($code) {
        // 1xx: Information
        // 2xx: Successful
        // 3xx: Redirection
        case 303:
            exit (json_encode (array('redirect'=> $exception->getMessage())));

        // 4xx: Client Error
        case 403:
            exit (json_encode (array('error'=> $exception->getMessage())));

        case 404:
            return Response::view('404', array(), 404);

        // 5xx: Server Error

    }


    if ( $fromConsole )
    {
        return 'Error '.$code.': '.$exception->getMessage()."\n";
    }

    return json_encode (array ('message'=> $exception->getMessage ()));


});