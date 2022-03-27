<?php
    include_once 'dbh.inc.php';

    function cartCard($name, $category, $id)
    {
        if(strcmp($category,"Icecream") === 0)
        {
            echo '
            <form action="../html/preorder.php" method="POST" class="order-form">
                <div class="card-header">'.$name.' ('.$category.')</div>
                  <div class="card-body card-holder">
                    <label for="price">Price:</label>
                    <input type="hidden" name="id" value='.$id.'>
                    <input type="number" name="price" id="price" min="100" max="200" step="50" value="100">
                    <label for="quantity">Quantity:</label>
                    <input type="number" name="quantity" min="1" value="1" id="quantity">
                    <button type="submit" name="remove" class="btn-danger mt-1">Remove</button>
                  </div>
                </div>
        
            </form>
          ';
        }
        else if(strcmp($category,"Icecream Cake") === 0)
        {
            echo '
            <form action="../html/preorder.php" method="POST" class="order-form">
              <div class="card-header">'.$name.' ('.$category.')</div>
              <div class="card-body card-holder">
                <label for="price">Price:</label>
                <input type="hidden" name="id" value='.$id.'>
                <input type="number" name="price" id="price" value="350" readonly="readonly">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" min="1" value="1" id="quantity">
                <button type="submit" name="remove" class="btn-danger mt-1">Remove</button>
              </div>
            </form>
          ';
        }
        else if(strcmp($category,"Icicle") === 0)
        {
            echo '
            <form action="../html/preorder.php" method="POST" class="order-form">
              <div class="card-header">'.$name.' ('.$category.')</div>
              <div class="card-body card-holder">
                <label for="price">Price:</label>
                <input type="hidden" name="id" value='.$id.'>
                <input type="number" name="price" id="price" value="200" readonly="readonly">
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity" min="1" value="1" id="quantity">
                <button type="submit" name="remove" class="btn-danger mt-1">Remove</button>
              </div>
            </form>
          ';
        }
    }

    function card($fileext, $flavorDb, $idDb, $colorDb, $categoryDb, $priceDb)
    {
        echo ' 
            <form action="./html/preorder.php?id='.$idDb.'" method="POST">
            <div class="card individual-cards">
                <img src="uploads/'.$flavorDb.'.'.$fileext.'?'.mt_rand().' class="card-img-top">
                <div class="card-body text-white bg-dark mb-3">
                    <p class="card-text">Flavor: '.$flavorDb.' <br> Color: '.$colorDb.' <br> Price: '.$priceDb.'</p>
                    <input type="hidden" name="id" value="'.$idDb.'">
                    <input type="hidden" name="flavor" value="'.$flavorDb.'">
                    <input type="hidden" name="category" value="'.$categoryDb.'">
                    <div class="card-button">   
                    <button type="submit" name="addbtn" class="btn-primary">Cart it</button>
                    </div>
                </div>
            </div>
            </form>
            ';
    }

    function icecream($id)
    {
        $sql = "SELECT * FROM icecreamtbl WHERE category='$id';";
        $result = mysqli_query(connection(), $sql);

        if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
            $flavor = $row['flavor'];
          
            $filename = "uploads/".$flavor."*";//path to file
            $fileinfo = glob($filename); //Returns an array instance
            $fileext = explode(".", $fileinfo[0]);
            $fileactualext = $fileext[1];

            card($fileactualext, $row['flavor'], $row['id'], $row['color'], $row['category'], $row['price']);
          }
        }
        else
        {
            echo "<h3 class='no-icecream'>There are no Icecreams Available</h3>";
        }
    }

    function icecreamCake()
    {
        $sql = "SELECT * FROM icecreamtbl WHERE category='Icecream Cake';";
        $result = mysqli_query(connection(), $sql);
  
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result))
            {
                $flavor = $row['flavor'];
            
                $filename = "uploads/".$flavor."*";//path to file
                $fileinfo = glob($filename); //Returns an array instance
                $fileext = explode(".", $fileinfo[0]);
                $fileactualext = $fileext[1];

                card($fileactualext, $row['flavor'], $row['id'], $row['color'], $row['category'], $row['price']);
            }
        }
        else
        {
            echo "<h3 class='no-icecream'>There are no IceCream Cakes Available</h3>";
        }
    }

    function icicle($id)
    {
        $sql = "SELECT * FROM icecreamtbl WHERE category='$id';";
        $result = mysqli_query(connection(), $sql);

        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $flavor = $row['flavor'];
            
                $filename = "uploads/".$flavor."*";//path to file
                $fileinfo = glob($filename); //Returns an array instance
                $fileext = explode(".", $fileinfo[0]);
                $fileactualext = $fileext[1];

                card($fileactualext, $row['flavor'], $row['id'], $row['color'], $row['category'], $row['price']);
            }
        }
        else
        {
            echo "<h3 class='no-icecream'>There are no Icicles Available</h3>";
        }
    }

    function fudge($id)
    {
      $sql = "SELECT * FROM icecreamtbl WHERE category='$id';";
      $result = mysqli_query(connection(), $sql);

      if(mysqli_num_rows($result) > 0)
      {
          while($row = mysqli_fetch_assoc($result))
          {
              $flavor = $row['flavor'];
          
              $filename = "uploads/".$flavor."*";//path to file
              $fileinfo = glob($filename); //Returns an array instance
              $fileext = explode(".", $fileinfo[0]);
              $fileactualext = $fileext[1];

              card($fileactualext, $row['flavor'], $row['id'], $row['color'], $row['category'], $row['price']);
          }
      }
      else
      {
          echo "<h3 class='no-icecream'>There are no Fudges Available</h3>";
      }
    }


    function viewAll()
    {
        $sql = "SELECT * FROM icecreamtbl;";
        $result = mysqli_query(connection(), $sql);

        if(mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_assoc($result)){
              $flavor = $row['flavor'];
          
              $filename = "uploads/".$flavor."*";//path to file
              $fileinfo = glob($filename); //Returns an array instance
              $fileext = explode(".", $fileinfo[0]);
              $fileactualext = $fileext[1];

              card($fileactualext, $row['flavor'], $row['id'], $row['color'], $row['category'], $row['price']);
          }
        }
        else
        {
           echo "<h3 class='no-icecream'>There are no Icecreams Available</h3>";
        }
    }

    function defaultDisplay()
    {
        $sql = "SELECT * FROM icecreamtbl;";
        $result = mysqli_query(connection(), $sql);

        if(mysqli_num_rows($result) > 0)
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $flavor = $row['flavor'];
            
                $filename = "uploads/".$flavor."*";//path to file
                $fileinfo = glob($filename); //Returns an array instance
                $fileext = explode(".", $fileinfo[0]);
                $fileactualext = $fileext[1];

                card($fileactualext, $row['flavor'], $row['id'], $row['color'], $row['category'], $row['price']);
            }
        }
        else
        {
            echo "<h3 class='no-icecream'>There are no Icecreams Available</h3>";
        }
    }

    function staticModal($orderNumber)
    {
      echo '
      <form method="get">        
        <!-- Button trigger modal -->
        <button type="button" id="finish"class="btn btn-success place_order_btn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" onclick="calculateCost()">
          Finish
        </button>
      </form>

      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="../includes/sendOrder.inc.php" method="GET" id="form">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Purchase Conformation</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5>Order#: '.$orderNumber.'</h5>
                <h5>TOTAL: $<span id="total_cost"></span></h5>
                <input type="hidden" name="totalCost" id="total_cost_input">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
              <button type="submit" name="placeOrder" class="btn btn-success">Place Order</button>
            </div>
          </form>
        </div>
      </div>
    </div>
      ';
    }
?>