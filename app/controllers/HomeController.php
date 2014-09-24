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
		 $jobload = (object) array('controller'=> 'ScheduleController', 'action'=> 'run', 'payload'=> null);

		 return self::jobdispatch('controllerDispatch', $jobload);
	 }
}
