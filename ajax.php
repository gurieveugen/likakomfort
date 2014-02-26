<?php

require($_SERVER["DOCUMENT_ROOT"].'/wp-blog-header.php');
_session_start();

// ========================================================
// BUY
// ========================================================
if(isset($_POST["buy"]))
{		
	$id = $_POST["id"];

	echo buy_product($id);
}	

// ========================================================
// Cancel Buy
// ========================================================		
if(isset($_POST["BUY_CANCEL"]))
{		
	$id = $_POST["id"];

	echo remove_product($id);
}

// ========================================================
// Cancel All Buys
// ========================================================		
if(isset($_POST["CANCEL_ALL_BUYS"]))
{
	echo remove_all_products();
}

// ========================================================
// Send the order
// ========================================================
if(isset($_POST["send_order"]))
{
	$fullname = $_POST["fullname"];
	$email    = $_POST["email"];
	$contacts = $_POST["contacts"];

	if(send_order($fullname, $email, $contacts))
	{	
		remove_all_products();
		$res["msg"] = "Письмо отправлено. Спасибо за покупки!";
	}
	else
	{
		$res["msg"] = "Письмо не может быть отправлено. Свяжитесь с администратором ".get_bloginfo("admin_email")."!";
	}
	echo json_encode($res);
}

// ========================================================
// Set numeric sort
// ========================================================
if(isset($_POST["numeric_sort"]))
{
	$_SESSION["numeric"] = true;
}

// ========================================================
// Unset numeric sort
// ========================================================
if(isset($_POST["unset_numeric_sort"]))
{
	unset($_SESSION["numeric"]);
}

// ========================================================
// Search by price
// ========================================================
if(isset($_POST["search_by_price"]))
{
	$_SESSION["start_price"] = $_POST["start_price"];
	$_SESSION["end_price"] = $_POST["end_price"];
}

