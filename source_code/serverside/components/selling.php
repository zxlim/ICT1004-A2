<?php

$urlsErr = $product_nameErr = $product_descErr = $priceErr = $conditionErr = $ageErr = $categoryErr = $locationErr = "";
$urls = $product_name = $product_desc = $price = $condition = $age = $category = $location = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["imgur_link[]"])) {
        echo "URL list is empty";
    } else {
        echo "URL list is not empty";
    }

    if (empty($_POST["product_name"])) {
        $product_nameErr = "Product Name is required";
    } else {
        $product_name = test_input($_POST["product_name"]);
    }

    if (empty($_POST["product_desc"])) {
        $product_descErr = "Product Description is required";
    } else {
        $product_desc = test_input($_POST["product_desc"]);
    }

    if (empty($_POST["price"])) {
        $priceErr = "Product Price is required";
    } else {
        $price = test_input($_POST["price"]);
    }

    if (empty($_POST["condition"])) {
        $conditionErr = "Product Condition is required";
    } else {
        $condition = test_input($_POST["condition"]);
    }

    if (empty($_POST["age"])) {
        $ageErr = "Product Age is required";
    } else {
        $age = test_input($_POST["age"]);
    }

    if (empty($_POST["category"])) {
        $categoryErr = "Product Category is required";
    } else {
        $category = test_input($_POST["category"]);
    }

    if (empty($_POST["location"])) {
        $locationErr = "Meetup Location is required";
    } else {
        $location = test_input($_POST["location"]);
    }

}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>