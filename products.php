<?php
require_once('includes/auth.php');
require_once('includes/utils.php');
$products = array();
$query = 'select * from products';
$search = '';
$isSearch = false;
if (isset($_GET['q'])) {
	$search = $_GET['q'];
	$query = "select * from products where name like '%$search%'";
	$isSearch = true;
}
$result = $dbconnection->query($query);
if ($result) {
	while (($row = $result->fetch_assoc())) {
		array_push($products, $row);
	}
}

include('includes/header.php'); ?>

<div class='container padding'>
	<div class='jumbotron'>
		<div class='d-flex justify-content-between'>
			<h3 class='pt-4 px-4'>All products</h3>

			<form class='form-inline'>
				<input class='form-control' name='q' value="<?php echo $search ?>" placeholder='Search'>
				<button type='submit' class='btn btn-primary'>Search</button>
			</form>
		</div>
		<hr>

		<?php if (count($products) > 0) : ?>
			<?php if ($isSearch) : ?>

				<p>Search results for : <strong><?php echo $search; ?></strong></p>
			<?php endif; ?>
			<div class='row'>
				<?php foreach ($products as $row) : ?>
					<div class="col-md-3 col-sm-6 my-3 my-md-O">

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
								<?php else : ?>
									<span class="price">$<?php echo $row['price']; ?> </span>

								<?php endif; ?>
							</h5>
							<a href='cart.php?action=add&id=<?php echo $row['id']; ?>' class="btn btn-success my-1" name="add"><i class="fas fa-shopping-cart"> </i> Add to cart</a>
							<?php if ($user['role_id'] > 0) : ?>
								<a class='btn btn-danger' href='delete_product.php?id=<?php echo $row['id']; ?>'>Delete Product</a>
							<?php endif; ?>
						</div>
					</div>

				<?php endforeach; ?>
			</div>
		<?php elseif ($isSearch) : ?>
			<p>No products found for search query: <strong><?php echo $search; ?></strong></p>
		<?php else : ?>
			<p>No products added yet!!</p>
		<?php endif; ?>
	</div>
</div>

<?php include('includes/footer.php');
