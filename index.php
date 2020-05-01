<!-- Navigation -->
<?php include('includes/header.php');
include('includes/utils.php');
?>

<!--- Image Slider -->

<div id="slides" class="carousel slide" data-ride="carousel">
	<ul class="carousel-indicators">
		<li data-target="#slides" data-slide-to="0" class="active"> </li>
		<li data-target="#slides" data-slide-to="1"> </li>
		<li data-target="#slides" data-slide-to="2"> </li>
	</ul>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img src="assets/img/md.jpg" width="100%" alt="">
			<div class="carousel-caption">
				<h1 class="display-3"> Herbs</h1>
				<h4> We find you the right product.</h4>
				<a href='herbs.php' class="btn btn-outline-light btn-lg"> View Herbs
				</a>
				<a href="contact_us.php" type="button" class="btn btn-primary btn-lg"> Contact
				</a>
			</div>
		</div>

		<div class="carousel-item">
			<img src="assets/img/hd.jpg" width="100%" alt="">
			<div class="carousel-caption">
				<h1 class="display-3"> Handicrafts</h1>
				<h4> We find you the right product.</h4>
				<a href="handicrafts.php" class="btn btn-outline-light btn-lg"> View Handicrafts.
				</a>
				<a href="contact_us.php" type="button" class="btn btn-primary btn-lg"> Contact
				</a>
			</div>
		</div>

		<div class="carousel-item">
			<img src="assets/img/tm.jpg" width="100%" alt="">
			<div class="carousel-caption">
				<h1 class="display-3"> TeamWork</h1>
				<h4> We promote our community. </h4>
				<button type="button" class="btn btn-outline-light btn-lg"> Promote
				</button>
	<a href="contact_us.php" type="button" class="btn btn-primary btn-lg"> Contact
				</a>
			</div>
		</div>


	</div>
</div>


<!--- Jumbotron -->
<div class="container padding">
	<div class="row jumbotron">
		<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10">
			<p class="lead">
				Alternative Medicine Throughout the centuries alternative medicine has been
				effective in curing many diseases and to also aid the healing process of the
				body. This form of medicine was used by many societies and cultures and has
				been advertised as one of the most effective medicine groups. This continued
				until the early 1900’s when doctors started to use other forms of medicine such
				as antibiotics and vaccinations.
			</p>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
			<a href="#"> <button type="button" class="btn btn-outline-secondary btn-lg">
					Web Hosting</button></a>
		</div>
	</div>
</div>

<!--- Welcome Section -->

<div class="container padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4"> We Provide Your Needs </h1>
			<hr>
		</div>
		<div class="col-12">
			<p class="lead">
				A short welcome message for customers can make their shopping experience a
				little bit nicer. However, it is one of the key factors when it comes to
				increasing your sales.
			</p>
		</div>

	</div>
</div>


<!--- Three Column Section -->

<div class="container padding">
	<div class="row text-center padding">
		<div class=" col-xs-12 col-sm-6 col-md-4">
			<i class="fas fa-code"></i>
			<h3> Works </h3>
			<p> We connect the people. </p>
		</div>
		<div class=" col-xs-12 col-sm-6 col-md-4">
			<i class="fas fa-bold"></i>
			<h3> Experience</h3>
			<p> We connect the people. </p>
		</div>
		<div class=" col-sm-12 col-md-4">
			<i class="fab fa-css3"></i>
			<h3> Teams </h3>
			<p> We connect the people. </p>
		</div>
	</div>
</div>

<!--- Two Column Section -->

<div class="container padding">
	<div class="row padding">
		<div class="col-lg-6">
			<h2> What can you find.</h2>
			<p> Everything from herbs to handicrfats, we make sure you receive it. </p>
			<a href="/products.php" class="btn btn-primary"> See More.. </a>
		</div>
		<div class="col-lg-6">
			<img src="assets/img/log1.jpg" class="img-fluid">
		</div>

	</div>
	<hr class="my-4">
</div>

<!--- Fixed background -->

<!--- Emoji Section -->

<!--- Meet the team -->

<!-------------------------Handicrafts products --------------------------------->

<?php
$query = "select * from products limit 4";
$result = $dbconnection->query($query);

?>
<div class="container padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4"> Our recent picks </h1>
			<hr>
		</div>
	</div>

	<?php if (!$result || $result->num_rows == 0) : ?>
		<p class='display-5 text-center'>No product has been added yet.</p>
	<?php else : ?>
		<div class="row text-center py-5">

			<?php while (($row = $result->fetch_assoc())) : ?>
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
			<?php endwhile; ?>

		</div>
	<?php endif; ?>

</div>

<div class="container-fluid padding">
	<div class="row welcome text-center">
		<div class="col-12">
			<h1 class="display-4"> Meet Our Teams. </h1>
			<hr>
		</div>
	</div>
</div>



<div class="container padding">
	<div class="row padding">
		<div class="col-lg-3">
			<div class="card shadow-sm" style='border-radius:0px'>
				<img class="card-img-top " src="assets/img/suvam.jpg">
				<div class="card-body text-center">
					<h5 class="card-title"> Suvam Ligal</h5>
					<p class="card-text">
						Computer Science degree from Texas A&M University, Commerce.
					</p>
					<a href="https://www.facebook.com/junk.ligal" target="_blank" class="btn btn-outline-secondary btn-full-profile"> See full profile</a>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="card shadow-sm" style='border-radius:0px'>
				<img class="card-img-top " src="assets/img/manish.jpg">
				<div class="card-body text-center">
					<h5 class="card-title"> Manish Poudel Chhetri</h5>
					<p class="card-text">
						Computer Science degree from Texas A&M University, Commerce.
					</p>
					<a href="https://www.facebook.com/manis.paudel" target="_blank" class="btn btn-outline-secondary btn-full-profile"> See full profile</a>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="card shadow-sm" style='border-radius:0px'>
				<img class="card-img-top " src="assets/img/safal.jpg">
				<div class="card-body text-center">
					<h5 class="card-title"> Safal Koirala</h5>
					<p class="card-text">
						Computer Science degree from Texas A&M University, Commerce.
					</p>
					<a href="https://www.facebook.com/safal.koirala" target="_blank" class="btn btn-outline-secondary btn-full-profile"> See full profile</a>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="card shadow-sm" style='border-radius:0px'>
				<img class="card-img-top " src="assets/img/kishor.jpg">
				<div class="card-body text-center">
					<h5 class="card-title"> Kishor Subedi</h5>
					<p class="card-text">
						Computer Science degree from Texas A&M University, Commerce.
					</p>
					<a href="https://www.facebook.com/kishorsubedi" target="_blank" class="btn btn-outline-secondary btn-full-profile"> See full profile</a>
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="card shadow-sm" style='border-radius:0px'>
				<img class="card-img-top " src="assets/img/anish.jpg">
				<div class="card-body text-center">
					<h5 class="card-title"> Anish Sharma</h5>
					<p class="card-text">
						Computer Science degree from Texas A&M University, Commerce.
					</p>
					<a href="https://www.facebook.com/anish.sharma.7902" target="_blank" class="btn btn-outline-secondary btn-full-profile"> See full profile</a>
				</div>
			</div>
		</div>

	</div>
	<hr class="my-4">
</div>


<!--- Two Column Section -->

<div class="container padding">
	<div class="row padding">
		<div class="col-lg-6">
			<h2> Our Goal </h2>
			<p> Everything from herbs to handicrfats, we make sure you find your needs. </p>
		</div>
		<div class="col-lg-6">
			<img src="assets/img/hm.jpg" class="img-fluid">
		</div>

	</div>
	<hr class="my-4">
</div>


</div>
<!--- Footer -->

<?php include('includes/footer.php'); ?>