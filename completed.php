<?php 
include('includes/auth.php');
require_once('includes/utils.php');




if(!$login){
	redirectBackWithMessage("You have to login first!");
}


if(isset($_GET['action']) && $_GET['action']=='add'){
	$id = $_GET['id'];
	$product = getProductById($id);
	if(addToCart($user,$product)){
		redirectBackWithMessage("Successfully added product to cart");

	};
}

if(isset($_GET['action']) && $_GET['action']=='update'){
	$id = $_GET['id'];
	$qty = $_POST['qty'];
	// print_r($_POST);
	// exit;
	updateCart($qty,$user['id'],$id);
}

if(isset($_GET['action']) && $_GET['action']=='delete'){
	$id = $_GET['id'];


	updateCart(0,$user['id'],$id);
}


$cartitems = array();
$user_id = $user['id'];
$query = "select * from cart_items,products where cart_items.user_id='$user_id' and products.id=cart_items.product_id;";
$result = $dbconnection->query($query);
if($result){
	while(($row=$result->fetch_assoc())){
		array_push($cartitems,$row);
	}
}

include('includes/header.php');?>

<div class='container padding'>
	<div class='jumbotron'>
		<h3 class=' text-center pt-4'>Success</h3>
		<hr class='mb-4'>
		
		<h1 class='mt-4 text-center text-success'>Your order has been successfully placed.</h1>
		<p class='text-center'>We will contact you as soon as the product is shipped.</p>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
<script>
    $('.qty').on('change', function() {
        var id = $(this).data('id');
        $("#cartitem-" + id).val($(this).val());
        $("#cartsubmit-" + id).click();
    });

    $('.del').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $("#cartitem-" + id).val(0);
        $("#cartsubmit-" + id).click();
    })
</script>

<?php include('includes/footer.php');