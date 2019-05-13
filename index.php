<?php
	include_once 'header.php';
?>


<section class="main-container">
	<div class="main-wrapper">
		<h2>Welcome to my Thesis</h2>	
		<p>Click on the 'signup' button to make a new account, and use the top two bars to log-in if you already have one! </p>
		<?php
			if(isset($_SESSION['u_id'])){
				echo "Hello!! you're logged in :))))";
				echo $_SESSION['u_uid'];
			}
		?>
	</div>
</section>

<?php
	include_once 'footer.php';
?>
