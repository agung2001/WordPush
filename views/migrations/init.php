	<div class="container">
		<h1 class="text-center">Wordpress Migrator</h1>
		<form class="form" method="post">
		<!-- Database Info -->
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<h3 class="text-center">Database Info</h3>
					<input type="text" class="form-control" name="dbname" placeholder="name" value="<?php if(isset($dbname))echo $dbname; ?>" required> <br>
					<input type="text" class="form-control" name="tblprefix" placeholder="prefix" value="<?php if(isset($tblprefix))echo $tblprefix; ?>" required>
					<br><br>
					<input type="text" class="form-control" name="dbusername" placeholder="username" value="<?php if(isset($dbusername))echo $dbusername; ?>" required> <br>
					<input type="password" class="form-control" name="dbpassword" placeholder="password" value="<?php if(isset($dbpassword))echo $dbpassword; ?>"> <br>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<input type="submit" class="btn pull-right" value="Find">
				</div>
			</div>
		<!-- Migrator -->
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<h3 class="text-center">Migration Address</h3>
					<input type="text" class="form-control" name="url_from" placeholder="From" value="<?php if(isset($url_from))echo $url_from; ?>"> <br>
					<input type="text" class="form-control" name="url_to" placeholder="To" value="<?php if(isset($url_to))echo $url_to; ?>"> <br>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					<input type="submit" class="btn pull-right" value="Migrate">
				</div>
			</div>
		</form>

		<?php if(isset($data['result'])): ?>
			<h1 class="text-center">Result</h1>
			<p>
				<?= $result ?>
			</p>
		<?php endif; ?>
	</div>
