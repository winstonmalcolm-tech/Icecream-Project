<?php
    if(isset($_POST['upload'])){
        include_once 'dbh.inc.php';

        $flavor = $_POST['flavor_name'];
        $color = $_POST['flavor_color'];
        $cost = $_POST['cost'];
        $category = $_POST['category'];

        $sql = "INSERT INTO icecreamtbl (flavor, color, price, category) VALUES ('$flavor', '$color', '$cost', '$category');";
        mysqli_query($conn, $sql);
        
        $file = $_FILES['flavor_img'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = explode('.', $fileName);//convert into an array
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if(in_array($fileActualExt, $allowed))
        {
            if($fileError === 0)
            {
                if($fileSize < 50000000)
                {
                    $fileNameNew = $flavor.".".$fileActualExt;
                    $fileDestination = '../uploads/'.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    header("Location: ../html/admin.php?Upload=sucess");
                }
                else 
                {
                    echo "Your file is too big!";
                    exit();
                }
            }
            else
            {
                echo "There was an error uploading your file";
                exit();
            }
        }
        else
        {
            echo "You cannot upload file of this type!";
        }
        mysqli_close($conn);
    }
    elseif(isset($_POST['delete']))
    {
        include_once 'dbh.inc.php';

        $flavor = $_POST['flavor_name'];

        //Removing image from server
        $filename = "../uploads/".$flavor."*";
        $fileinfo = glob($filename);//Returns an array
        $file = end($fileinfo);

        //unlink is the function used to delete files
        if(!unlink($file)){
            
            header("Location: ../html/admin.php?delete=fail");
        }
        else{
            header("Location: ../html/admin.php?delete=success");
            $sql = "DELETE FROM icecreamtbl WHERE flavor = '$flavor';";
            mysqli_query($conn, $sql);
            exit();
        }

        mysqli_close($conn);
    }
    elseif(isset($_POST['update']))
    {
        include_once 'dbh.inc.php';

        $flavor = $_POST['flavor_name'];
        $price = $_POST['cost'];

        //Scripts to handle file
        $file = $_FILES['flavor_img'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        if(empty($fileName) && empty($price))
        {
            header("Location: ../html/admin.php?update=emptyfields");
        }
        elseif(!empty($fileName) && !empty($price))
        {
            $fileExt = explode('.', $fileName);//Split the string at the . and convert it into array
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png', 'pdf');

            if(in_array($fileActualExt, $allowed)){
                if($fileError === 0)
                {
                    if($fileSize < 50000000)
                    {
                        $fileNameNew = $flavor.".".$fileActualExt;
                        $fileDestination = '../uploads/'.$fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        $sql = "UPDATE icecreamtbl SET price='$price' WHERE flavor='$flavor';";
                        mysqli_query($conn, $sql);
                        header("Location: ../html/admin.php?Update=sucess");
                        exit();
                        
                    }
                    else
                    {
                        header("Location: ../html/admin.php?File=excess");
                        exit();
                    }
                }
                else
                {
                    header("Location: ../html/admin.php?Update=error");
                    exit();
                }
            }
            else
            {
                header("Location: ../html/admin.php?Update=filetypeerror");
                exit();
            }
        }
        elseif(!empty($fileName))
        {
            $fileExt = explode('.', $fileName);//Split the string at the . and convert it into array
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png', 'pdf');

            if(in_array($fileActualExt, $allowed)){
                if($fileError === 0)
                {
                    if($fileSize < 50000000)
                    {
                        $fileNameNew = $flavor.".".$fileActualExt;
                        $fileDestination = '../uploads/'.$fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        header("Location: ../html/admin.php?Update=sucess");
                        exit();
                        
                    }
                    else
                    {
                        header("Location: ../html/admin.php?File=excess");
                        exit();
                    }
                }
                else
                {
                    header("Location: ../html/admin.php?Update=error");
                    exit();
                }
            }
            else
            {
                header("Location: ../html/admin.php?Update=filetypeerror");
                exit();
            }
        }
        elseif(!empty($price))
        {
            $sql = "UPDATE icecreamtbl SET price='$price' WHERE flavor='$flavor';";
            mysqli_query($conn, $sql);

            header("Location: ../html/admin.php?Update=success");
            exit();
        }
    }
    elseif(isset($_POST['logout']))
    {
        session_start();
        session_unset();
        session_destroy();

        header("Location: ../index.php");
        exit();

    }

?>