<?php
require_once('includes/auth.php');
require_once('includes/db.php');
require_once('includes/utils.php');

if ($login) {
    header("location: index.php");
}



if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirmation = $_POST['password_confirmation'];
    if ($password != $password_confirmation) {
        $message = 'Passwords do not match';
    } else if (strlen($email)==0 || strlen($password)==0 || strlen($password_confirmation)==0 || strlen($name)==0) {
        $message = "One or more field is empty. Please check again";
    } else {
        if (email_exists($email)) {
            $message = 'Email already exists';
        } else {
            $md5 = md5($password);
            $query = "insert into users(name,email,password) values('$name','$email','$md5');";
            $result = $dbconnection->query($query);
            if ($result) {
                $message = "Successfully registered. Please <a href='/login.php'>login</a> to your new account.";
            } else {
                $message = "Failed to register. Try again";
            }
        }
    }
}


include('includes/header.php');
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h3 class=" text-center pt-4">Register on Medicraft</h3>
                <hr>
                <div class="card-body">
                    <?php if (isset($message)) : ?>
                        <div class="alert alert-danger">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                    <form method="POST" action="/register.php">

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email">

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" name='submit' class="btn btn-primary">
                                    Register
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