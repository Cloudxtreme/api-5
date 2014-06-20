-- Create field oauth_clients.auto_approve

-- Insert info
REPLACE INTO oauth_clients (id, secret, name, auto_approve) VALUE ('1', 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ', 'Hello World App', 1);
REPLACE INTO oauth_client_endpoints (client_id, redirect_uri) VALUE ('1', 'http://cloudwalkers-api.local/demo/backhome');
REPLACE INTO oauth_scopes (scope, NAME, description) VALUES ('user', 'User details', 'Retrieves a user\'s details');



ALTER TABLE `oauth_sessions`
	CHANGE COLUMN `owner_id` `owner_id` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci' AFTER `owner_type`;

	
	