<?php
  session_start();
  $_SESSION['orderNumber'] = mt_rand(1000,9999);
  require '../includes/dbh.inc.php';
  require '../includes/flavorsdisplay.php';

  if(isset($_POST['addbtn'])){
    if(isset($_SESSION['cart']))
    {
      $item_array_id = array_column($_SESSION['cart'], "product_id");
      if(!in_array($_GET['id'], $item_array_id))
      {
        $count = count($_SESSION['cart']);
        $item_array = array(
          'product_id' => $_GET['id'],
          'name' => $_POST['flavor'],
          'category' => $_POST['category']
        );

        $_SESSION['cart'][$count] = $item_array;
        echo '<script>window.location="../index.php"</script>';
      }
      else
      {
        echo '<script>alert("Product is already Added to Cart")</script>';
        echo '<script>window.location = "../index.php"</script>';
      }
    }
    else 
    {
      $item_array = array(
        'product_id' => $_GET['id'],
        'name' => $_POST['flavor'],
        'category' => $_POST['category']
      );
      $_SESSION['cart'][0] = $item_array;
    }
  }

  if(isset($_POST['remove']))
  {
    $id = $_POST['id'];

    foreach($_SESSION['cart'] as $key => $value)
    {
      if($id == $value['product_id'])
      {
        unset($_SESSION['cart'][$key]);
      }
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="description"
      content="Icecream website - This website aims to display all products that the website has in stock"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../style.css?v=<?php echo time(); ?>" />
    <link rel="icon" type="image/png" href="../img/icecream.png" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <title>Nicky's Icecream</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#"
          ><img
            class="logo"
            src="../img/icecream.png"
            alt="icecream logo"
          />Nicky's Icecream</a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNavDropdown"
          aria-controls="navbarNavDropdown"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="promotions.php">Promotions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#">Cart</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="cart-container">
        <?php
          if(isset($_GET['status']))
          {
            if($_GET['status'] == "sent")
            {
              echo '
              <div class="alert alert-success d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              <div>
                Order Sent Successfully
              </div>
            </div>
              ';
            }
            else
            {
              echo '
              <div class="alert alert-danger d-flex align-items-center" role="alert">
              <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
              <div>
                Order Did not sent
              </div>
            </div>
              ';
            }
          }
        ?>
        <div class="cart-box">
          <h3>CART</h3>
          <hr>
          <div class="display-orders">
            
            <?php
              if(!empty($_SESSION['cart']))
              {
                staticModal($_SESSION['orderNumber']);
                foreach($_SESSION['cart'] as $key => $value)
                {
                  cartCard($value['name'], $value['category'], $value['product_id']);
                }
              }
              else{
                echo "<h4>Cart is Empty</h4>";
              }
            ?>
          </div>
        </div> 
    </div>

    <footer class="footer">
        <div class="footer-content">
          <p>Nicky's Icecream 2021&copy;</p>
        </div>
    </footer>

    <script>

      function calculateCost()
      {
        let price = document.querySelectorAll("#price");
        let quantity = document.querySelectorAll("#quantity");
        let sum = 0;

        for(let i=0; i<price.length; i++)
        {
          sum += price[i].value*quantity[i].value;
          console.log(price[i].value);
        }

        document.getElementById("total_cost").innerHTML = sum;
        document.getElementById("total_cost_input").value = sum;
        getPrice();
        getQuantity();
      }

      function getQuantity()
      {

        let flavorquantities = document.querySelectorAll("#quantity");

        if(document.getElementById("product_quantity"))
        {
          document.getElementById("product_quantity").remove();

          let textfield = document.createElement("input");
          textfield.type = "hidden";
          textfield.id = "product_quantity";
          textfield.name = "productquantity";
          let arr = [];


          for(let i=0; i<flavorquantities.length; i++)
          {
              arr[i] = flavorquantities[i].value;
          }

          textfield.value = arr;
          document.getElementById("form").appendChild(textfield);
        }
        else
        {
          let textfield = document.createElement("input");
          textfield.type = "hidden";
          textfield.id = "product_quantity";
          textfield.name = "productquantity";
          let arr = [];


          for(let i=0; i<flavorquantities.length; i++)
          {
              arr[i] = flavorquantities[i].value;
          }

          textfield.value = arr;
          document.getElementById("form").appendChild(textfield);
        }
      }

      function getPrice()
      {
        let flavorprices = document.querySelectorAll("#price");

        if(document.getElementById("product_price"))
        {
          document.getElementById("product_price").remove();

          let textfield = document.createElement("input");
          textfield.type = "hidden";
          textfield.id = "product_price";
          textfield.name = "productprice";
          let arr = [];


          for(let i=0; i<flavorprices.length; i++)
          {
              arr[i] = flavorprices[i].value;
          }

          textfield.value = arr;
          document.getElementById("form").appendChild(textfield);
        }
        else
        {
          let textfield = document.createElement("input");
          textfield.type = "hidden";
          textfield.id = "product_price";
          textfield.name = "productprice";
          let arr = [];


          for(let i=0; i<flavorprices.length; i++)
          {
              arr[i] = flavorprices[i].value;
          }

          textfield.value = arr;
          document.getElementById("form").appendChild(textfield);
        }
      }

    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js"></script>
  </body>
</html>
