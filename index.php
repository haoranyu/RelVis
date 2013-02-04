<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Sign in &middot; RelVis</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link href="css/login.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Sarina' rel='stylesheet' type='text/css'>
    </head>

    <body>
		<div class="header">
		<font color="#DA4A38">Rel</font><font color="#3077EF">Vis</font>
		</div>
        <div class="signin-box">
			<h2>Sign in with Gmail account</h2>
            <form id="gaia_loginform" action="main.php" method="post">
				<div class="email-div">
					<label for="Email"><strong class="email-label">Username</strong></label>
					<input type="email" spellcheck="false" name="username" id="Email" value="">
				</div>
				<div class="passwd-div">
					<label for="Passwd"><strong class="passwd-label">Password</strong></label>
					<input type="password" name="password" id="Passwd">
				</div>
				<div class="year-div">
					<label for="Year"><strong class="year-label">Process the emails from year</strong></label>
					<input type="text" name="year" id="Year" value="2012">
				</div>
				<input type="submit" class="g-button g-button-submit" name="signIn" id="signIn" value="Sign in">
			</form>

        </div>

    </body>
</html>
