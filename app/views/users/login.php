<?php
    require APPROOT . '/views/includes/header2.php';
?>
<div class="wrapper">
<a href="<?php echo URLROOT; ?>/pages/index" style="text-decoration: none; font-weight:200; color:white;
	padding: 20px; font-size:20px;"> > Back</a>
	<div class="container">
		<h1>Welcome</h1>


		
		<form class="form" action="<?php echo URLROOT; ?>/users/login" method="post">

			<input type="text" placeholder="Username" name="username">
			<input type="password" placeholder="Password" name="passwd">



		
			<button type="submit" name="login-button">Login</button>
		

			<p>Don't have an account? <a href="<?php echo URLROOT; ?>/users/register">Sign up now</a>.</p>

		</form>


		<label type=text style="color: black">
				<?php
				if(isset($_GET["error"])){
					echo "wrong username or password";

				}
				?>

			</label>

	</div>
</div>

</body>
</html>
