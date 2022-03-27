<?php
    /**
     *  This php file is responsible for sending the customers order number and choosen flavors
     *  to the business through the form of email. However, when this file executes, the webpage ends up timing
     *  out and the email doesn't send.
     */

    //Checking if the place order button was clicked
    if(isset($_GET['placeOrder']))
    {
        session_start(); // start the session


        $productNames = array(); //Creating array to store product names
        $message = array(); //Creating an array to store the full information on one specific flavor(quantity, price, product name)
        
        //Getting data passed from form and store them into local variables
        $productPricesRaw = $_GET['productprice'];
        $quantitiesRaw = $_GET['productquantity'];

        //convert retrieved form information into array
        $quantities = explode(",", $quantitiesRaw);
        $prices = explode(",", $productPricesRaw);

        //
        foreach($_SESSION['cart'] as $key => $value)
        {
            $productNames[$key] = $value['name']." (".$value['category'].")";
        }
        
        for($i=0; $i<count($productNames); $i++)
        {
            $messageRaw[$i] = $quantities[$i]." $".$prices[$i]." ".$productNames[$i]." <br>";
        }

        //Configuring the email components 
        $to = '';
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
