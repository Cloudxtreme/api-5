<?php namespace lib\JobServer;

use Illuminate\Support\ServiceProvider;

class JobServiceProvider extends ServiceProvider {

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app['jobserver'] = $this->app->share(function($app)
        {
            return $this->app->environment('local')?
            	
            	new JobLocalServer():
            	new JobServer();
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('jobserver');
	}

}
