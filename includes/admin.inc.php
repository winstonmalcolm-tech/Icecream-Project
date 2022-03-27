<?php
    /**
     * This php file is responsible for the validation of the admin page (url: http://localhost:port#/Icecream%20Project/html/admin.php)
     */

    if(isset($_POST['upload'])) { //Checking for upload button click
        include_once 'dbh.inc.php';

        //Getting data pass from the url and store them in local variables
        $flavor = $_POST['flavor_name'];
        $color = $_POST['flavor_color'];
        $cost = $_POST['cost'];
        $category = $_POST['category'];

        //SQL query to insert collected information into the database
        $sql = "INSERT INTO icecreamtbl (flavor, color, price, category) VALUES ('$flavor', '$color', '$cost', '$category');";
        mysqli_query($conn, $sql); //Execute sql query   
        
        //handling up loaded image
        $file = $_FILES['flavor_img']; //associative array containing data on the image uploaded
        $fileName = $file['name']; //original name of the file uploaded.
        $fileTmpName = $file['tmp_name']; //temporary filename of the file in which the uploaded file was stored on the server.
        $fileSize = $file['size']; // get the size in bytes of the uploaded file.
        $fileError = $file['error']; // get error code if there is any associated with this file upload.
        $fileType = $file['type']; //get the the file type (eg png jpg)

        $fileExt = explode('.', $fileName);//convert into an array
        $fileActualExt = strtolower(end($fileExt)); //transform the extension of the image to lowercase

        $allowed = array('jpg', 'jpeg', 'png'); //Setting a an array of allowed extensions

        if(in_array($fileActualExt, $allowed)) //Check if the uploaded image as the correct extension
        {

            if($fileError === 0) //Check if there is any error
            {
                if($fileSize < 50000000) //ensuring that the image size is not too large
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
    elseif(isset($_POST['delete'])) // Check if the delete button is clicked 
    {
        include_once 'dbh.inc.php'; // Include the database connection 

        $flavor = $_POST['flavor_name']; //Getting and storing the search key in a local variable

        //Removing image from server
        $filename = "../uploads/".$flavor."*";
        $fileinfo = glob($filename);//Return an array of filenames that matches the specified pattern
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
    elseif(isset($_POST['update'])) //Checking if the update button is clicked
    {
        include_once 'dbh.inc.php';

        //Getting the new information
        $flavor = $_POST['flavor_name'];
        $price = $_POST['cost'];

        //Scripts to handle file
        $file = $_FILES['flavor_img'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        
        if(empty($fileName) && empty($price)) //Checking if both fields
        {
            header("Location: ../html/admin.php?update=emptyfields");
        }
        elseif(!empty($fileName) && !empty($price)) //if not empty, update information in the database
        {
            $fileExt = explode('.', $fileName);//Split the string at the . and convert it into array
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('jpg', 'jpeg', 'png', 'pdf');

            if(in_array($fileActualExt, $allowed)){
                if($fileError === 0)
                {
                    if($fileSize < 50000000) //If file size less than 50MBs, commence update
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