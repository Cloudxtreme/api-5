<html>
<body>

<h1>Demo - Oauth2</h1>

<?php 

$error_message = isset($params['error_message']) ? $params['error_message'] : '';

if ("$error_message" != '') echo "<p style=\"background-color:#BA0707;color:#ffffff;text-align:center;\">$error_message</p><br />\n";

?>
<form action="/demo/signin" method="POST">
User: <input id="email" name="email" value="robertos@agap2.pt" /><br />
Pass: <input id="password" name="password" type="password" value="pass" /><br />

<?php
/*
<br /><br /><br />

client_id: <input id="client_id" name="client_id" value="I6Lh72kTItE6y29Ig607N74M7i21oyTo" /><br />
client_details: <input id="client_details" name="client_details" value="" /><br />
redirect_uri: <input id="redirect_uri" name="redirect_uri" value="" /><br />
response_type: <input id="response_type" name="response_type" value="" /><br />
scopes: <input id="scopes" name="scopes" value="user" /><br />
*/
?>

<input id="signin" name="signin" type="submit" value="Sign in" />

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