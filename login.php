<?php require_once('includes/auth.php');
require_once('includes/db.php');
if ($login) {
    header("location: index.php");
}
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // $md5 = hash('bcrypt', $password);
    $query = "Select * from users where email='$email';";
    $result = $dbconnection->query($query);
    if ($result && $result->num_rows > 0) {
        $first = $result->fetch_assoc();
        if (md5($password) == $first['password']) {
            $_SESSION['login'] = true;
            $_SESSION['user'] = $first['id'];
            header('location: home.php');
        } else {
            $message = 'Password is incorrect!!' . strlen(password_hash($password, PASSWORD_DEFAULT));
        }
    } else {
        $message = 'Error logging in. Email is incorrect.';
    }
}
include('includes/header.php');
?>

<div class="container padding">
    <div class="jumbotron row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h3 class=" text-center pt-4">Login to Medicraft</h3>
                <hr>
                <div class="card-body">
                    <?php if (isset($message)) : ?>
                        <div class="alert alert-danger">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="/login.php">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember">

                                    <label class="form-check-label" for="remember">
                                        Remember Me </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" name='submit' class="btn btn-primary">
                                    Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>