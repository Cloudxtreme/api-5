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

        public function getMessages() { return $this->_errors; }

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
    $message = $exception->getMessage();

    if (get_class($exception)=='InvalidParameterException') {

        $code = $exception->getCode();

        $messages = $exception->getMessages();

        if (!empty($messages))

            $message .= ';' . implode(';', $exception->getMessages());

    }


    // Laravel exceptions (ex: App::abort(404, 'Service not found');)
    switch ($code) {
        // 1xx: Information
        // 2xx: Successful
        // 3xx: Redirection
        case 303:
            return Redirect::to ($message);

        // 4xx: Client Error
        case 403:
            exit (json_encode (array('error'=> $message)));

        case 404:
            return Response::view('404', array(), 404);

        // 5xx: Server Error

    }


    if ( $fromConsole )
    {
        return 'Error '.$code.': '.$message."\n";
    }

    return json_encode (array ('message'=> $message));


});
