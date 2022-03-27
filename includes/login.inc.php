<?php
    if(isset($_POST['login-submit'])){
        session_start();
        require 'dbh.inc.php';

        $username = $_POST['username'];
        $password = $_POST['password'];

        $_SESSION['user'] = $username;
        $_SESSION['loggedIn'] = false;

        if(empty($username) || empty($password)){
            header("Location: ../html/login.php?error=emptyfields");
            exit();
  
        } 
        else{
            $sql = "SELECT * FROM users where username=?;";
            $stmt = mysqli_stmt_init($conn);

            if(!mysqli_stmt_prepare($stmt, $sql)){
                header("Location: ../html/login.php?error=sqlerror");
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt, "s", $username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                //Checking for a match in the database
                if($row = mysqli_fetch_assoc($result)){
                    $pwdCheck = $password == $row['password'];

                    if($pwdCheck == false){
                        header("Location: ../html/login.php?error=incorrectpassword");
                        exit();
                    }
                    else if($pwdCheck == true){
                        $_SESSION['loggedIn'] = true;
                        header("Location: ../html/admin.php?login=success");
                        exit();
                    }
                    else{
                        header("Location: ../html/login.php?error=wrongpwd");
                        exit();
                    }
                }
                else{
                    header("Location: ../html/login.php?error=nouser");
                    exit();
                }
            }
        }
    }
    else{
        header("Location: ../html/login.php");
        exit();
    }
?>