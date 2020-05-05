<?php
$hostname = 'localhost';
$username = 'medicraft_medicraft';
$password = 'kathmandu123$';
$dbname = 'medicraft_medicraft';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//one of the important file. without this, our system wont work.. handles connection with db
$dbconnection = mysqli_connect($hostname, $username, $password, $dbname) or die('failed to connect to db');

//given the id, returns food fetched from database,,
function getItemById($id)
{
    global $dbconnection;
    $query = "select * from items where id='$id'";
    $result = $dbconnection->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

function addToCart($user, $product)
{


    global $dbconnection;

    if ($user && $product) {
        $uid = $user['id'];
        $pid = $product['id'];


        $get = "select id,rate,quantity from cart_items where product_id='$pid' and user_id='$uid'";
        $qty = 1;
        $result = $dbconnection->query($get);
        
        
        if ($result && $result->num_rows > 0) {
        	//if already...
            $curr = $result->fetch_assoc();
            $qty = $curr['quantity'];
            $cid = $curr['id'];
            $qty += 1;
            $total = ($curr['rate'] * $qty);
            $query = "update cart_items set total=$total, quantity='$qty' where id=$cid; ";
        } else {
            $rate= $product['price'];
            $total= $product['price'];
            $query = "insert into cart_items(user_id,quantity,rate,total,product_id) values($uid,$qty,$rate,$total,$pid);";
        }

        if ($dbconnection->query($query)) {
            return true;
        }
       
    }
    return false;
}



function getProductById($id)
{
    global $dbconnection;
    $query = "select * from products where id='$id'";
    $result = $dbconnection->query($query);
    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }
    return null;
}

