<form method="post" action="{{ $action }}">
		<label>Do You Authorize {{ $client_id }}?</label><br />
		<input type="submit" name="authorized" value="yes">
		<input type="submit" name="authorized" value="no">
</form>

<?php // echo $clientdata['client_id']; ?>