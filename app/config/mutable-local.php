<?php

define('ENV_DEVELOPMENT','DEV');
define('BASE_PATH',str_replace("\\", "/", dirname(__FILE__) ."/../config"));
define('LANGUAGE_NL', 'nl');

	define('ENV', ENV_DEVELOPMENT);

	define('DIR_UPLOAD', BASE_PATH . 'public/');
	define('DIR_LOGS', BASE_PATH . 'logs/');
	define('DIR_TMP', 'C:/dev_tmp/');
	
	define('ERROR_REPORTING', E_ALL);
	define('DEBUG', true);
	define('DEBUG_LOG', true);
	
	define('TIMEZONE', 'Europe/Brussels');
	
	define('BASE_URL', 'http://cloudwalkers-engine.local/');
	define('BASE_URL_SSL', 'https://cloudwalkers-engine.local/');
	
	define('GEARMAN_SERVER', false);
	define('GEARMAN_PORT', 4730);

	define ('MEMCACHE_IP', false); // 'db.cloudwalkers.be'
	define ('MEMCACHE_PORT', 11211);
	define ('MEMCACHE_PREFIX', 'cwdev');
	
	//define('DB_HOST', '127.0.0.1');
	define('DB_HOST', '127.0.0.1:13306');
	define('DB_USERNAME', 'myuser');
	define('DB_PASSWORD', 'myuser');
	define('DB_NAME', 'cloudwalkers');
	define('DB_PORT', '3307');
	define('DB_CHARSET', 'utf8');
	
	define('DB_OAUTH2_ENGINE', 'sqlite3');
	define('DB_OAUTH2_NAME', 'cloudwalkers.db');
	define('DB_OAUTH2_HOST', '127.0.0.1');
	define('DB_OAUTH2_DATABASE', 'C:\\dev_data\\SQLite\\Cloudwalkers\\cloudwalkers.db');
	define('DB_OAUTH2_USERNAME', 'myuser');
	define('DB_OAUTH2_PASSWORD', 'myuser');
	define('DB_OAUTH2_PORT', '');
	define('DB_OAUTH2_DSN', 'sqlite:C:/dev_data/SQLite/Cloudwalkers/'. DB_OAUTH2_NAME);
	define('DB_OAUTH2_CHARSET', 'utf8');

	//define('DB_OAUTH2_DSN', 'sqlite:dbname='.DB_OAUTH2_DATABASE.';host='.DB_OAUTH2_HOST);

	define('DB_CUSTOM_LOG_MYSQL', true);
	define('DB_CUSTOM_LOG_SQLITE', true);
	
	define('TRACKER_APPNAME', 'Cloudwalkers Development API');
	define('PLATFORM_NAME', 'DEVELOPMENT');
	define('PLATFORM_URL', 'http://cloudwalkers-website.local/');
	
	define('LANGUAGE_DEFAULT', LANGUAGE_NL);
	
	define('GETTEXT_DEBUG_OUTPUT', false);
	
	// Facebook
	define('SOCIAL_DEFAULT_FACEBOOK_APPID', '289284477889484');
	define('SOCIAL_DEFAULT_FACEBOOK_SECRET', '0723d4869ee678785cb023b0376f9a72');
	
	// Twitter
	define('SOCIAL_DEFAULT_TWITTER_KEY', '1RuHg3J8qNR2Mf3Sy6A');
	define('SOCIAL_DEFAULT_TWITTER_SECRET', 'oJUP51MQB4CnpQwovFzEsEaaDVJ3uSsk5pECOK6cc');
	
	// LinkedIn
	define('SOCIAL_DEFAULT_LINKEDIN_APPID', '77yll9307vysr3');
	define('SOCIAL_DEFAULT_LINKEDIN_SECRET', '6vd3idIa0zQcjKjh');
	
	// Google
	define('SOCIAL_DEFAULT_GOOGLE_CLIENTID', '349051508634.apps.googleusercontent.com');
	define('SOCIAL_DEFAULT_GOOGLE_CLIENTSECRET', 'EDj_YtAiJOrj6iPE0UCtLsHf');
	define('SOCIAL_DEFAULT_GOOGLE_DEVELOPERKEY', 'AIzaSyAlFxnTvx43w9JwBvLMN-MawjmtoJSxmQ0');
	
	// SMTP settings (ignore what you don't need)
	define('SMTP_SERVER', 'mail.serverpark.be');
	//define('SMTP_PORT', 25);
	//define('SMTP_USERNAME', null);
	//define('SMTP_PASSWORD', null);
	//define('SMTP_SECURE', 'ssl');

	define('MAIL_FROM_EMAIL', 'info@cloudwalkers.be');
	define('MAIL_FROM_NAME', 'Cloudwalkers');
	define('MAIL_ADMIN', 'thijs@bmgroup.be');
	define('MAIL_TEMPLATES', str_replace('\\','/',dirname(__FILE__)) . '/../../../php/bmgroup/Cloudwalkers/templates/mailtemplates');
	define('MAIL_SERVICE_ID', 1); // 1 = Mandrill, 2 = Sendgrid
	define('MAIL_IS_HTML', false); // Text emails
	
	
	