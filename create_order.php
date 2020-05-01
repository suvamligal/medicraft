<?php
include('includes/auth.php');
require_once('includes/utils.php');




$cartitems = array();
$user_id = $user['id'];
$query = "select * from cart_items,products where cart_items.user_id='$user_id' and products.id=cart_items.product_id;";
$result = $dbconnection->query($query);
$carttotal = 0;
if ($result) {
    while (($row = $result->fetch_assoc())) {
        array_push($cartitems, $row);
        $carttotal += $row['total'];
    }
}

function cartToOrders($id){
	global $dbconnection,$cartitems,$user_id;
	$uid=$user_id;
	$ototal = 0;
	foreach($cartitems as $item){
		$cid=$item['id'];
		$product_id = $item['product_id'];
		$order_id=$id;
		$rate=$item['rate'];
		$quantity=$item['quantity'];
        $price= $item['price'];
        

		$total = $item['total'];
		$ototal += $total;
		$query = "Insert into order_items(product_id,order_id,rate,quantity,price,total) values($product_id,$order_id,'$rate','$quantity','$price','$total')";
		$result=$dbconnection->query($query);
		
		if($result){
			
			$dquery="delete from cart_items where product_id='$cid' and user_id='$uid'";
		
			$dbconnection->query($dquery);
		}
		
	}
}


if (!$login) {
    redirectBackWithMessage("You have to login first!");
}


if (isset($_POST['submit'])) {
    
    $payloads = array();
    
    
    if (count($cartitems) == 0) {
        $error = true;
        redirectBackWithMessage("The cart is empty");
    }




    if (!isset($_POST['name']) || strlen($_POST['name']) < 3) {
        $error = true;
        redirectBackWithMessage("Invalid name");
    } else {
        $payloads['name'] = $_POST['name'];
    }

    if (!$error) {
        $name = $payloads['name'];
        $user_id = $user['id'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $query = "insert into orders(name,user_id,phone,address,status,amount) values('$name',$user_id,'$phone','$address','processing','$carttotal')";

        $result = $dbconnection->query($query);

        if ($result) {
            $order_id = $dbconnection->insert_id;
            cartToOrders($order_id);

            $_SESSION['order_id'] = $order_id;
            header('location: completed.php');
            exit;
        } else {
            redirectBackWithMessage($dbconnection->error);
        }
    }

}




include('includes/header.php'); ?>

<div class='container padding'>
    <div class='jumbotron'>
        <h3 class='text-center pt-4'>Placing an order</h3>
        <hr>
        <?php if (count($cartitems) > 0) : ?>
            <div class='row'>
                <div class='col-md-6'>
                    <h5 class='mb-4'>Your Cart</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Food</th>
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
                                    <td> <a href="/food.php?id=<?php echo $item['food_id']; ?>"><?php echo $item['name']; ?></a> </td>
                                    <td><?php echo $item['rate']; ?></td>
                                    <td><input type="number" placeholder="qty" disabled class='qty form-control w-50' data-id='<?php echo $item['id']; ?>' value="<?php echo $item['quantity']; ?>"></td>
                                    <td>$<?php echo $item['total']; ?></td>
                                    <?php
                                    $total += $item['total'];
                                    ?>

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

                </div>
                <div class='col-md-6'>
                    <h5 class='mb-4'>Order details</h5>
                    <form method='POST'>
                        <div class='form-group'>
                            <label>
                                Name
                            </label>
                            <input required class='form-control' name='name' value='<?php echo $user['name']; ?>' />
                            <p class='text-small text-primary'>We need your name to recognize you.</p>
                        </div>
                        <div class='form-group'>
                            <label>
                                Shipping Address
                            </label>
                            <input required class='form-control' name='address' value='' />
                            <p class='text-small text-primary'>We will deliver your items to this address</p>

                        </div>
                        <div class='form-group'>
                            <label>
                                Phone number
                            </label>
                            <input required class='form-control' name='phone' value='' />
                            <p class='text-small text-primary'>We will call you when the order is shipped.</p>

                        </div>
                        <p class='text-center'><button type='submit' name='submit' class='btn btn-danger'>Create your order</a></p>

                    </form>
                </div>
            </div>


        <?php else : ?>
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
