<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application;

/*
|--------------------------------------------------------------------------
| Detect The Application Environment
|--------------------------------------------------------------------------
|
| Laravel takes a dead simple approach to your application environments
| so you can just specify a machine name for the host that matches a
| given environment, then we will automatically detect it for you.
|
*/

/*
$env = $app->detectEnvironment(array(

	// "hostname" of the machine/server

	'local' => array(
		'thijs-home-i7',
		'daedeloth-N550LF'
	),
	
	'local-koen' => array(
		'tickee-MBP-15.local'
	),

    'local-gaby' => array(
        'Gabriela'
    ),

    'local-pedro' => array(
        'psilva',
	    'ubuntu'
    ),
	
	'development' => array(
		'vps601.serverpark.be'
	)
));
*/

$env = $app->detectEnvironment(function () {

	// The environment name is a combination of your hostname
	// and the location where this app is installed.

	// Please add your environemtn in the switch case.
	$hostname = gethostname ();
	$path = dirname (__DIR__);

	$environmentname = $hostname . '@' . $path;

	switch ($environmentname)
	{
		case 'thijs-home-i7@/home/daedeloth/Workbench/cloudwalkers-engine':
		case 'daedeloth-N550LF@/home/daedeloth/Workbench/cloudwalkers-engine':
		case 'thijs-home-i7@/home/daedeloth/Workbench/cloudwalkers-api':
		case 'FRM_BEE_11.bee-eng.CORP@C:\xampp\htdocs\cloudwalkers-engine.local':
		case 'FRM_BEE_11@C:\xampp\htdocs\cloudwalkers-engine.local':
		case 'Gabriela@/var/www/cloudwalkers-engine.local/public_html':
		case 'Gabriela@/var/www/cloudwalkers-engine.local/public_html':
			return 'local';
			break;
			
		case 'tickee-MBP-15.local@/webroot/cloudwalkers/api':
			return 'local-koen';
			break;

		case 'newstorage.serverpark.be@/var/www/workers/development':
		case 'db.cloudwalkers.be@/home/cloudwalkers-development/cloudwalkers':
		case 'newstorage.serverpark.be@/var/www/html/workers002.cloudwalkers.be':
		case 'vps601.serverpark.be@/var/www/html/devapi.cloudwalkers.be':
			return 'development';
			break;

		case 'vps601.serverpark.be@/var/www/html/stagingapi.cloudwalkers.be':
		case 'newstorage.serverpark.be@/var/www/workers/staging':
			return 'staging';
			break;

		case 'newstorage.serverpark.be@/var/www/html/superadmin.cloudwalkers.be':
			return 'superadmin';
			break;

		case 'tickee-MBP-15.local@/webroot/cloudwalkers/engine':
			return 'dummy';
			break;

		case 'api.cloudwalkers.be@/var/www/html/api.cloudwalkers.be':
		case 'vps602.serverpark.be@/var/www/processes/production':
		case 'workers.serverpark.be@/var/www/html/workers.serverpark.be':
		case 'newstorage.serverpark.be@/var/www/workers/stable':
			return 'stable';
			break;

		default:

			echo "Please set your environment in boostrap/start.php\n";
			echo $environmentname . "\n\n";
			header ('Content-type: text/text');
			exit;
			break;
	}

});

/*
|--------------------------------------------------------------------------
| Bind Paths
|--------------------------------------------------------------------------
|
| Here we are binding the paths configured in paths.php to the app. You
| should not be changing these here. If you need to change these you
| may do so within the paths.php file and they will be bound here.
|
*/

$app->bindInstallPaths(require __DIR__.'/paths.php');

/*
|--------------------------------------------------------------------------
| Load The Application
|--------------------------------------------------------------------------
|
| Here we will load this Illuminate application. We will keep this in a
| separate location so we can isolate the creation of an application
| from the actual running of the application with a given request.
|
*/

$framework = $app['path.base'].
                 '/vendor/laravel/framework/src';

require $framework.'/Illuminate/Foundation/start.php';

require 'tools.php';

/*
|--------------------------------------------------------------------------
| Extend Classes
|--------------------------------------------------------------------------
|
| Some classes need personal tweaking. That happens here.
|
*/

// Set NewRelic options
Newrelic::setAppName (Config::get('newrelic.appname'));

// Validator extends
Validator::extend('getValidated', 'SchemaValidator@getValidated');

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

require 'ioc.php';

return $app;
