<?php $rand = rand(1, 100000);
include_once "includes/class-autoload.inc.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css?<?php echo $rand; ?>">
</head>
<body>

    <div id='wrapper'>
		<div id='login'>
			<form action='includes/login.inc.php' method='post'>
				<h1>LOGIN</h1>
				<label>Username</label>
				<input name='uid' type='text' autocomplete='off'>
                <label>Password</label>
				<input name='pwd' type='text' autocomplete='off'>
				<button type='submit' name='submit'>SUBMIT</button>
			</form>
		</div>
	</div>

</body>
</html> 