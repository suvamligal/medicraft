<?php
//check if log in and logged in user can add food or not
require('includes/auth.php');
if ($user['role_id'] < 1 || $user['role_id'] > 2) {
    header('location: index.php');
}


include('includes/header.php');
if (isset($_POST['submit'])) {
    $error = false;
    $sale_price;
    $messages = array();
    $name = $dbconnection->escape_string($_POST['name']);
    $type=$dbconnection->escape_string($_POST['type']);
    $description = $dbconnection->escape_string($_POST['description']);
    $price = $_POST['price'];
    if(isset($_POST['sale_price']))
        $sale_price = $_POST['sale_price'];

    //check if price is numeric
    if (!is_numeric($price)) {
        array_push($messages, 'Please enter numeric value for price.');
        $error = true;
    }

    if (isset($sale_price) && $sale_price !=null && !is_numeric($sale_price)) {
        array_push($messages, 'Please enter numeric value for sale price.');
        $error = true;
    }

    if (isset($sale_price) && ($sale_price > $price)) {
        array_push($messages, 'Sale price can not be more than price.');
        $error = true;
    }
    



    //validation for file uploads
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check == false) {
        array_push($messages, 'Uploaded file is not an image');
        $error = true;
    }

    //move uploaded image
    $arr =explode(".", $_FILES["image"]["name"]);
    $image = 'product_image' . rand(1, 5000) . end(($arr));
    $target_file = "uploads/$image";
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
    } else {
        array_push($messages, "Sorry, there was an error uploading your file.");
        $error = true;
    }


    if (!$error) {

        $query = "insert into products(name,description,price,sale_price,image,type) values('$name','$description','$price','$sale_price','$image','$type')";
        $r = $dbconnection->query($query);
        if ($r) {
            $success = "Successfully added a product";
        } else {
            array_push($messages, 'Failed to add product. Error: '.$dbconnection->error);
            $error = true;
        }
    }
}
?>


<div class="container padding">
    <div class="jumbotron row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h3 class="text-center pt-4">Add new product</h3>
                <hr>
                <div class="card-body">
                    <?php if ($error = true && isset($messages)) : ?>
                        <?php foreach ($messages as $message) : ?>
                            <div class="alert alert-danger">
                                <?php echo $message; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <?php if (isset($success)) : ?>
                        <div class="alert alert-primary">
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="Name">Name of product</label>
                            <input type="text" required value='' name='name' class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Name">Description of product</label>
                            <textarea name='description' required class="form-control"></textarea>
                        </div>
                        
                        
						<div class="form-group">
                            <label for="Name">Type of product</label>
                            <select name='type'>
                            	<option value='handicrafts'>Handicrafts</option>
                            	<option value='herbs'>Herbs</option>
                            </select>
                        </div>


                        <div class="form-group">
                            <label for="Name">Price of product</label>
                            <input type="text" value='' required name='price' class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="Name">Sale price of product</label>
                            <input type="text" value='' name='sale_price' class="form-control">
                        </div>
					

                        <div class="form-group">
                            <label for="Name">Image of product</label>
                            <input type="file" name='image' required class="form-control-file">
                        </div>

                        <button type='submit' name='submit' class='btn btn-primary'>Submit</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<?php include('includes/footer.php'); ?>