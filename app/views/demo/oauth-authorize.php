<html>
<body>

<h1>Demo - Oauth2 - Authorize</h1>

<form action="/demo/signin" method="GET">
User: <input id="username" name="username" value="user" /><br />
Pass: <input id="password" name="password" value="pass" /><br />

<br /><br /><br />

client_id: <input id="client_id" name="client_id" value="I6Lh72kTItE6y29Ig607N74M7i21oyTo" /><br />
client_details: <input id="client_details" name="client_details" value="" /><br />
redirect_uri: <input id="redirect_uri" name="redirect_uri" value="" /><br />
response_type: <input id="response_type" name="response_type" value="" /><br />
scopes: <input id="scopes" name="scopes" value="user" /><br />

<input id="signin" name="signin" type="submit" value="Signing" />

<?php
/*			'body' => [
			'grant_type' => 'client_credentials',
			'client_id' => 'I6Lh72kTItE6y29Ig607N74M7i21oyTo',
			'client_secret' => 'dswREHV2YJjF7iL5Zr5ETEFBwGwDQYjQ',
			'state' => 0,
			'scope' => 'user'
*/
?>
</form>

</body>
</html>