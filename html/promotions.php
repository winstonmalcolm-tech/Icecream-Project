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
              <a class="nav-link active" href="#">Promotions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="preorder.php">Cart</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="promotion-container">
      <div class="promotion-listing">
        <?php
          require '../includes/dbh.inc.php';
          $sql = "SELECT * FROM promotions";
          $result = mysqli_query($conn, $sql);

          if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
              echo '
              <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                  <div class="col-md-4">
                    <img src="'.$row['filepath'].'" class="img-fluid rounded-start" alt="...">
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h5 class="card-title">'.$row['title'].'</h5>
                      <p class="card-text">'.$row['message'].'.</p>
                      <p class="card-text"><small class="text-muted">Date: '.$row['date'].'</small></p>
                    </div>
                  </div>
                </div>
              </div>
              ';
            }
          }
          else{
            echo '
            <div class="no-promotion">
              <h3>No promotions available yet</h3>
            </div>
            ';
          }

        ?>
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
