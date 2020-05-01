<?php 
include('includes/auth.php');
require_once('includes/utils.php');



function updateCart($qty,$uid,$pid){
	
   global $dbconnection;
   
    //if $qty is 0 delete cart item
    if ($qty == 0) {
        //delete

        $quer = "DELETE from cart_items where product_id='$pid' and user_id='$uid'";
        
    } else {
        $r = $dbconnection->query("select * from cart_items where product_id='$pid' and user_id='$uid'");
        if ($r && $r->num_rows > 0) {
          
            $total = $qty * $r->fetch_assoc()['rate'];
            $quer = "UPDATE cart_items set quantity='$qty', total='$total' where product_id='$pid' and user_id='$uid'";
        }
    }
		
    if (isset($quer)) {
	
        if ($dbconnection->query($quer)) {
            
            redirectBackWithMessage("Successfully updated cart items");
        }else{
        redirectBackWithMessage("Failed to update cart items");

        }
    }else{
    	        redirectBackWithMessage("Failed to update cart items ");

    }
}





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
		<h3 class='text-center pt-4'>My Cart</h3>
		<hr>
		<?php if(count($cartitems)>0) : ?>
		 <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Product</th>
                                <th>Rate</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($cartitems) == 0) : ?>
                                <tr>
                                    <td colspan="5">
                                        <p class="alert alert-info">Cart is empty. Please go to <a href="/">shop</a> to add to cart.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>

                            <?php $total = 0;
                            ?>

                            <?php foreach ($cartitems as $index => $item) : ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td> <a href="/single.php?id=<?php echo $item['product_id']; ?>"><?php echo $item['name']; ?></a> </td>
                                    <td><?php echo $item['rate']; ?></td>
                                    <td><input type="number" placeholder="qty" class='qty form-control w-50' data-id='<?php echo $item['id']; ?>' value="<?php echo $item['quantity']; ?>"></td>
                                    <td>$<?php echo $item['total']; ?></td>
                                    <?php
                                    $total += $item['total'];
                                    ?>
                                    <td class="d-none">
                                        <form method="POST" action="/cart.php/?action=update&id=<?php echo $item['id']; ?>" style="display:none">
                                            <input type="text" class="" name='qty' id='cartitem-<?php echo $item['id']; ?>'>
                                            <input type="submit" id='cartsubmit-<?php echo $item['id']; ?>'>
                                        </form>
                                    </td>
                                    <td>
                                        <a class='btn del btn-sm btn-danger' data-id='<?php echo $item['id']; ?>' href="#">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <th>$<?php echo $total; ?></th>
                        </tfoot>
                    </table>
                    
                    <p class='text-center'><a href='create_order.php' class='btn btn-danger'>Place an order now</a></p>
             
		<?php else: ?>
		<p>No cart items added yet!!</p>
		<?php endif; ?>
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