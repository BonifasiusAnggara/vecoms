<!DOCTYPE html>
<html lang="id">
<head>
	<title>VeCoMS | Login</title>
	<meta name="viewport" content="width:device-width, initial-scale=1.0">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css" media="screen">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" media="screen">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap-responsive.min.css">
	<link rel="shortcut icon" href="assets/logo/Logo Enseval Crop.jpg">
</head>
<body>
	<section>
		<div class="container">
			<div class="row">
				<div class="span4 offset4 content">
					<div class="kop"></div>
					<form method="post" action="cek_log.php">
						<fieldset>
							<label>Username</label>
							<input type="text" class="span4" name="username" autofocus>

							<label>Password</label>
							<input type="password" class="span4" name="password">

							<div class="clear"></div>
							<hr>
							<div class="clear"></div>

							<button class="btn btn-info" type="submit"> Login</button>
						</fieldset>
					</form>
					<h5>&copy; Copyright <?php echo date('Y');?> Brogrammer</h5>
				</div>
			</div>
		</div>
	</section>
	<script src="assets/js/jquery.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>