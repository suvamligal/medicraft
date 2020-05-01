<?php 
include('includes/auth.php');
require_once('includes/utils.php');






if(!$login){
	redirectBackWithMessage("You have to login first!");
}

if($user['role_id']==0){
	redirectBackWithMessage("Restricted access");
}

$orders=array();


$user_id = $user['id'];
$query = "select * from orders";



$result = $dbconnection->query($query);
if($result){
	while(($row=$result->fetch_assoc())){
		array_push($orders,$row);
	}
}

include('includes/header.php');?>

<div class='container padding'>
	<div class='jumbotron'>
		<h3 class='text-center pt-4'>All orders</h3>
		<hr>
		<?php if(count($orders)>0) : ?>
		 <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Name</th>
                                <th>Adddress</th>
                                <th>Phone Number</th>
                                <th>Order Details</th>
                                <th>Total</th>
                                 <th>Order date</th>

                            </tr>
                        </thead>
                        <tbody>
                            

                            <?php $total = 0;
                            ?>

                            <?php foreach ($orders as $index => $item) : ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td> <?php echo $item['name']; ?> </td>
                                    <td> <?php echo $item['address']; ?> </td>
                                    <td> <?php echo $item['phone']; ?> </td>

                                    <td><a href="/single_order.php?id=<?php echo $item['id']; ?>">Order Number <?php echo $item['id']; ?></a></td>
                                    <td>$<?php echo $item['amount']; ?></td>
                                                                 	<td><?php echo $item['created_at'] ;?></td>

                                    <td>
                                        <a class='btn del btn-sm btn-danger' data-id='<?php echo $item['id']; ?>' href="all_orders.php?action=del&id=<?php echo $item['id'];?>">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                        
                    </table>
                    
                   
             
		<?php else: ?>
		<p>No cart items added yet!!</p>
		<?php endif; ?>
	</div>
</div>

</script>

<?php include('includes/footer.php');