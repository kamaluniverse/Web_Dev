<?php
$signup = false;
if (isset($_POST['username']) and isset($_POST['password']) and isset($_POST['email_address']) and $_POST['phone']) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $email = $_POST['email_address'];
    $phone = $_POST['phone'];
    $result = User::signup($user, $pass, $email, $phone);
    $signup = true;
}
?>
<?php
if ($signup) {
    if ($result) {
        ?>
<div class="alert alert-success" role="alert">
	Login success !
	<p>Now you can login <a href="/app/login.php">Here</a></p>
</div>
<?} else {?>
<div class="alert alert-success" role="alert">
	Login Fail !
</div>
<?}
} else {
    ?>
<main class="form-signup">
	<form action="signup.php" method="post">
		<img class="mb-4" src="/app/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
		<h1 class="h3 mb-3 fw-normal">Sign Up Now</h1>

		<div class="form-floating">
			<input name="username" type="text" class="form-control" id="floatingInput" placeholder="Username">
			<label for="floatingInput">Username</label>
		</div>
		<div class="form-floating">
			<input name="phone" type="text" class="form-control" id="floatingInput" placeholder="Password">
			<label for="floatingInput">Phone</label>
		</div>
		<div class="form-floating">
			<input name="email_address" type="email" class="form-control" id="floatingInput"
				placeholder="name@example.com">
			<label for="floatingInput">Email address</label>
		</div>
		<div class="form-floating">
			<input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
			<label for="floatingPassword">Password</label>
		</div>
		<!-- 
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div> -->
		<button class="w-100 btn btn-lg btn-primary" type="submit">Sign Up</button>
		<p class="mt-5 mb-3 text-muted">© 2024</p>
	</form>
</main>
<?}?>