<?php 
include('includes/auth.php');

require_once('includes/utils.php');



if(!$login){
	redirectWithMessage("You have to login first!");
}

$id = 0;

$order_items = array();

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$oquery = "select * from orders where id='$id'";

	$result = $dbconnection->query($oquery);
	if($result->num_rows == 0){
		redirectWithMessage("No order available");
	}
	$order = $result->fetch_assoc();
	$oiquery = "select * from order_items,products where order_items.order_id='$id' and products.id=order_items.product_id";
	$result = $dbconnection->query($oiquery);
if($result){
	while(($row=$result->fetch_assoc())){
		array_push($order_items,$row);
	}
}


}


include('includes/header.php');?>

<div class='container padding'>
	<div class='jumbotron'>
		<h3 class='text-center pt-4'>Order detail for order number <?php echo $order['id']; ?></h3>
		<hr>
		<p>Name : <code><?php echo $order['name'];?></code> </p>
		<p>Address : <code><?php echo $order['address'];?></code> </p>
				<p>Phone Number : <code><?php echo $order['phone'];?></code> </p>


		<?php if(count($order_items)>0) : ?>
		<h4>Ordered Items</h4>
		<hr>
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
                           

                            <?php $total = 0;
                            ?>

                            <?php foreach ($order_items as $index => $item) : ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td> <a href="/food.php?id=<?php echo $item['food_id']; ?>"><?php echo $item['name']; ?></a> </td>
                                    <td><?php echo $item['rate']; ?></td>
                                    <td><input type="number" disabled placeholder="qty" class='qty form-control w-50' data-id='<?php echo $item['id']; ?>' value="<?php echo $item['quantity']; ?>"></td>
                                    <td>$<?php echo $item['total']; ?></td>
                                    <?php
                                    $total += $item['total'];
                                    ?>
                    
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

?>