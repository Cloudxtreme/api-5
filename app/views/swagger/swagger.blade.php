<!DOCTYPE html>
<html>
<head>
	<title>Cloudwalkers API tester</title>
	<link href='//fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'/>
	{{ HTML::style('docs/css/reset.css', array('media' => 'screen')) }}
	{{ HTML::style('docs/css/screen.css', array('media' => 'screen')) }}
	{{ HTML::style('docs/css/reset.css', array('media' => 'print')) }}
	{{ HTML::style('docs/css/screen.css', array('media' => 'print')) }}

	{{ HTML::script('docs/lib/shred.bundle.js') }}
	{{ HTML::script('docs/lib/jquery-1.8.0.min.js') }}
	{{ HTML::script('docs/lib/jquery.slideto.min.js') }}
	{{ HTML::script('docs/lib/jquery.wiggle.min.js') }}
	{{ HTML::script('docs/lib/jquery.ba-bbq.min.js') }}
	{{ HTML::script('docs/lib/handlebars-1.0.0.js') }}
	{{ HTML::script('docs/lib/underscore-min.js') }}
	{{ HTML::script('docs/lib/backbone-min.js') }}
	{{ HTML::script('docs/lib/swagger.js') }}
	{{ HTML::script('docs/lib/highlight.7.3.pack.js') }}
	{{ HTML::script('docs/swagger-ui.js') }}


	<!-- enabling this will enable oauth2 implicit scope support -->
	<script src='lib/swagger-oauth.js' type='text/javascript'></script>

	<script type="text/javascript">
		$(function () {
			window.swaggerUi = new SwaggerUi({
				url: "{{$url}}",
				dom_id: "swagger-ui-container",
				supportedSubmitMethods: ['get', 'post', 'put', 'patch', 'delete'],
				onComplete: function(swaggerApi, swaggerUi){
					log("Loaded SwaggerUI");

					if(typeof initOAuth == "function") {
						/*
						 initOAuth({
						 clientId: "your-client-id",
						 realm: "your-realms",
						 appName: "your-app-name"
						 });
						 */
					}
					$('pre code').each(function(i, e) {
						hljs.highlightBlock(e)
					});
				},
				onFailure: function(data) {
					log("Unable to Load SwaggerUI");
				},
				docExpansion: "none",
				sorter : "alpha"
			});

			$('#input_apiKey').change(function() {
				var key = $('#input_apiKey')[0].value;
				log("key: " + key);
				if(key && key.trim() != "") {
					log("added key " + key);
					window.authorizations.add("key", new ApiKeyAuthorization("api_key", key, "query"));
				}
			})

			$('#bearer').val(window.localStorage.getItem('access_token'));
			$('#bearer').change(function() {
				var bearer = $('#bearer').val();
				window.authorizations.add("key", new ApiKeyAuthorization("Authorization", "Bearer "+bearer, "header"));
			})

			window.swaggerUi.load();
		});
	</script>
</head>

<body class="swagger-section">
<div id='header'>
	<div class="swagger-ui-wrap">
		<a id="logo" href="#" style="padding-right: 210px;"></a>
		<form id='api_selector'>
			{{--<div class='input icon-btn'>--}}
				{{--<img id="show-pet-store-icon" src="images/pet_store_api.png" title="Show Swagger Petstore Example Apis">--}}
			{{--</div>--}}
			{{--<div class='input icon-btn'>--}}
				{{--<img id="show-wordnik-dev-icon" src="images/wordnik_api.png" title="Show Wordnik Developer Apis">--}}
			{{--</div>--}}
			{{--<div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text" value="{{$url}}"/></div>--}}
			{{--<div class='input' style="display: none;"><input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/></div>--}}
			<div class='input'><input placeholder="bearer token" id="bearer" name="bearer" type="text" value=""/></div>
			<div class='input button'><a id="popup" href="../login-e">Login</a></div>
			{{--<div class='input'><a id="explore" href="#">Login</a></div>--}}
		</form>
	</div>
</div>

<div id="message-bar" class="swagger-ui-wrap">&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>
</body>
</html>
