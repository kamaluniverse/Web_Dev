<?php
$username = $_POST['email_address'];
$password = $_POST['password'];

$result = validate_credentials($username, $password);
if($result){
  ?>
  <div class="alert alert-success" role="alert">
  Login success !
</div>
<?
}else{

    ?>
<main class="form-signin">    
  <form action="login.php" method="post">
    <img class="mb-4" src="/app/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Log in</h1>

    <div class="form-floating">
      <input name="email_address" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Log in</button>
    <p class="mt-5 mb-3 text-muted">© 2024</p>
  </form>
</main>

<?php
}
?>