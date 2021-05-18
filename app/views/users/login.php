<?php 
    
   

    /*session_start();
	if(isset($_SESSION['owner'])){
		if($_SESSION['owner']=="bb"){
			header("Location: /covidVaccine/app/views/users/patient/dashboard.php");
		}
		else{
			header("Location: /covidVaccine/app/views/users/hospital/dashboard.php");
		}
	}

	include('../../config/config.php');


	if (isset($_POST['login-button'])) {
	$username = $_POST['username'];
	$password = $_POST['passwd'];

	$sql = $connection->prepare('SELECT * from account natural join role where username = ?');
	$sql ->bind_param('s', $username);
	$sql->execute();
	$run = $sql->get_result();
	confirm_query($run);
	$count = mysqli_num_rows($run);
	$row = mysqli_fetch_array($run);


	if (password_verify($password,$row["password"])) {

			session_start();
			$_SESSION["user_id"] = $row["username"];
			$_SESSION["patientId"] = $row["patientId"];
			$_SESSION["providerId"] = $row['providerId'];
	


			if($_SESSION['patientId']!= NULL){
	
				header("Location: /covidVaccine/app/views/users/patient/dashboard.php");

			}
		else{
		
			header("Location: /covidVaccine/app/views/users/provider/dashboard.php");
		}




	}
	else {

		header("Location:login.php?error=1");

	} 
	

} */

	
	
?>

<?php
    require APPROOT . '/views/includes/header2.php';
?>
<div class="wrapper">
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
