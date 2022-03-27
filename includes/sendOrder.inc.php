<?php

    if(isset($_GET['placeOrder']))
    {
        session_start();

        $productNames = array();
        $message = array();
        $productPricesRaw = $_GET['productprice'];
        $quantitiesRaw = $_GET['productquantity'];

        $quantities = explode(",", $quantitiesRaw);
        $prices = explode(",", $productPricesRaw);

        foreach($_SESSION['cart'] as $key => $value)
        {
            $productNames[$key] = $value['name']." (".$value['category'].")";
        }
        
        for($i=0; $i<count($productNames); $i++)
        {
            $messageRaw[$i] = $quantities[$i]." $".$prices[$i]." ".$productNames[$i]." <br>";
        }

        $to = 'winstonmalcolm77@gmail.com';
        $subject = "New Order";
        $message = "ORDER NUMBER: ".$_SESSION['orderNumber']."<br>".implode(" ", $messageRaw);

        $headers = "From: Icecream website <icecreamwebapp@mail.com>\r\n";
        $headers .= "Content-type: text/html\r\n";

        if(mail($to, $subject, $message, $headers))
        {
            session_unset();
            header("Location: ../html/preorder.php?status=sent");
        }
        else
        {
            header("Location: ../html/preorder.php?status=notsent");
        } 
    }

?>
