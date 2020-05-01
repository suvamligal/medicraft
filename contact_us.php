<?php

$to = "mr.aashiz@gmail.com" ;
if (isset($_POST)) {
    $name = $_POST['UName'];
    $email = $_POST['Email'];
    $subject = "No Subject";
    if (isset($_POST['Subject'])) {
        $subject = $_POST['Subject'];
    }
    $message = $_POST['msg'];

    $headers = "From: $email" . "\r\n" .
        "Reply-To: $email" . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

  // if( mail($to, $subject, $message, $headers)){
    //   $_SESSION['message'] = "Your queries has been submitted";
  // }else{
   //    $_SESSION['message']= "We can't submit your queries right now.";
   //}
          $_SESSION['message'] = "Your queries has been submitted";

}

include('includes/header.php'); ?>


<div class="container padding">
    <div class=" jumbotron row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-title">
                    <h2 class="text-center py-2"> Contact Us</h2>
                    <hr>
                </div>
                <div class="card-body">
                    <form action="contact_us.php" method="post">
                        <input required type="text" name="UName" placeholder="Name" class="form-control mb-2">
                        <input required type="text" name="Email" placeholder="Email Address" class="form-control mb-2">
                        <input type="text" name="Subject" placeholder="Subject" class="form-control mb-2">
                        <textarea required name="msg" class="form-control" placeholder="write the message"></textarea>
                        <button class="btn btn-success" name="btn-send"> Send </button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>