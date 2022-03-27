<?php
  session_start();
  if(!$_SESSION['loggedIn']){
    header('Location: login.php?notloggedin');
    exit();
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
              <a class="nav-link" href="login.php">Login</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="login.php">Admin</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pre-order.php">Pre-order</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="admin-container">
      <?php
        $username = $_SESSION['user'];
        if(empty($username)){
          echo "Empty";
        }
        else{
          echo '<h5 class="welcome-text"> Welcome '.$username.'</h5>';
        }
       
      ?>

      <div class="admin-form-container">
          <div class="form-box">
            <h3>Data Entry</h3>
            <form action="../includes/admin.inc.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="flavor_name" placeholder="Flavor name">
                <select name="category">
                  <option value="Icecream">Icecream</option>
                  <option value="Icicle">Icicle</option>
                  <option value="Icecream Cake">Icecream Cake</option>
                  <option value="Fudge">Fudge</option>
                </select>
                <input type="text" name="flavor_color" placeholder="Color of the flavor">
                <input type="file" name="flavor_img">
                <input type="text" name="cost" placeholder="Cost/Cost Range" value="$100.00 - $200.00">
                <div class="buttons">
                  <button type="submit" class="btn-primary" name="upload">Upload</button>
                  <button type="submit" class="btn-success" name="update">Update</button>
                  <button type="submit" class="btn-danger" name="delete">Delete</button>
                  <button type="submit" class="btn-danger" name="logout">Logout</button>
                </div>
            </form>
          </div>
      </div>

      <div class="promotion-form-container">
        <div class="promotion-form-box">
          <h3>Promotion Entry</h3>
          <form action="../includes/promotion.inc.php" method="post" enctype="multipart/form-data">
            <input type="text" name="title" placeholder="Enter Title">
            <input type="file" name="file">
            <textarea name="message" cols="30" rows="10" placeholder="Enter Message"></textarea>
            <input type="text" name="date" placeholder="Enter Time Period">
            <div class="promotionbuttons">
                <button type="submit" class="btn-primary" name="promotion-upload">Upload</button>
                <button type="submit" class="btn-danger" name="promotion-remove">Delete</button>
              </div>
          </form>
        </div>

      </div>

    </div>

    <footer class="footer">
        <div class="footer-content">
          <p>Nicky's Icecream 2021&copy;</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.13/dist/vue.js"></script>
    <script src="./app.js"></script>
  </body>
</html>
