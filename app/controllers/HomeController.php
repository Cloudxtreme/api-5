<?php

class HomeController extends BaseController {

	/**
	 *	Example controller
	 */
	 
	 /**
	  *	Schedule dispatch
	  *	Call the schedule controller from API.
	  */
	 public function schedule()
	 {
		 // The job
		 $payload = array('controller'=> 'ScheduleController', 'action'=> 'run', 'open'=> round(microtime(true), 3), 'payload'=> null, 'user'=> null);

		 return self::dispatch('controllerDispatch', $payload);
	 }
}
