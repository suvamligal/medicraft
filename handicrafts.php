<?php 
include('includes/auth.php');
require_once('includes/utils.php');

$products = array();
$query = "select * from products where type='handicrafts'";
$result = $dbconnection->query($query);
if($result){
	while(($row=$result->fetch_assoc())){
		array_push($products,$row);
	}
}

include('includes/header.php');?>

<div class='container padding'>
	<div class='jumbotron'>
		<h3 class='text-center pt-4'>All handicrafts</h3>
		<hr>
		<?php if(count($products)>0) : ?>
		<div class='row'>
			<?php foreach($products as $row) : ?>
				<div class="col-md-3 col-sm-6 my-3 my-md-O">
					<form action="product.php" method="post">

						<div class="card shadow">
							<div><img src="uploads/<?php echo $row['image'] ?>" alt="<?php echo $row['name']; ?>" class="img-fluid card-img-top"></div>
						</div>
						<div class="card-body">
							<a target="_blank" href="single.php?id=<?php echo $row['id']; ?>">
							<h5 class="card-title"><?php echo $row['name']; ?></h5>
							</a>
							<p class="card-text">
								<?php echo truncate($row['description']); ?>
							</p>
							<h5>
								<?php if ($row['sale_price'] != null) : ?>
									<small> <s class="text-secondary"> $<?php echo $row['price']; ?></s></small>
								<span class="price">$<?php echo $row['sale_price']; ?> </span>
								<?php else: ?>
								<span class="price">$<?php echo $row['price']; ?> </span>

								<?php endif; ?>
							</h5>
								<a href='cart.php?action=add&id=<?php echo $row['id'];?>' class="btn btn-success my-1" name="add"><i class="fas fa-shopping-cart"> </i> Add to cart</a>
							<?php if($user['role_id']>0):?>
							<a class='btn btn-danger' href='delete_product.php?id=<?php echo $row['id'];?>'>Delete Product</a>
							<?php endif;?>
						</div>
					</form>
				</div>
			
			<?php endforeach ; ?>
		</div>
		<?php else: ?>
		<p>No handicrafts added yet!!</p>
		<?php endif; ?>
	</div>
</div>

<?php include('includes/footer.php');