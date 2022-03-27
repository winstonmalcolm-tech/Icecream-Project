<?php
    /**
     * This php file is in charge of validating the promotion's form in admin.php
     */

     //Checking if the upload button was clicked
    if(isset($_POST['promotion-upload'])){
        include_once 'dbh.inc.php';

        //initializing the folder path
        $folderName = "../gameicons/";
        
        //Getting the data passed from the form and store them into local variables
        $title = $_POST['title'];
        $message = $_POST['message'];
        $date = $_POST['date'];

        //handling the uploaded image
        $file = $_FILES['file']; //associative array containing data on the image uploaded
        $fileName = $file['name']; //getting the name of the file
        $fileTmpName = $file['tmp_name']; //temporary filename of the file in which the uploaded file was stored on the server
        $fileSize = $file['size']; // Size of the image
        $fileError = $file['error']; // errors associated with the uploaded image
        $fileType = $file['type']; //The extension type

        $fileExt = explode('.', $fileName);//convert into an array
        $fileActualExt = strtolower(end($fileExt));

        $allowed = array('jpg', 'jpeg', 'png');

        if(in_array($fileActualExt, $allowed))
        {
            if($fileError === 0)
            {
                if($fileSize < 50000000)
                {
                    $fileNameNew = $title.".".$fileActualExt;
                    $fileDestination = $folderName.$fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    $sql = "INSERT INTO promotions (title, message, date, filepath) VALUES ('$title', '$message', '$date', '$fileDestination');";
                    mysqli_query($conn, $sql);
                    mysqli_close($conn);
                    header("Location: ../html/admin.php?Upload=sucess");
                }
                else 
                {
                    header("Location: ../html/admin.php?file=excess");
                    exit();
                }
            }
            else{
                header("Location: ../html/admin.php?Upload=error");
                exit();
            }

        }
        else{
            header("Location: ../html/admin.php?file=incorrectfiletype");
            exit();
        }
    }
    else if(isset($_POST['promotion-remove'])){ //Checking if the delete button was clicked
        include_once 'dbh.inc.php';

        //getting the title that was passed from the form and store it into a local variable for searching 
        $title = $_POST['title'];

        //Initializing the folder path
        $folderName = "../gameicons/";

        $fileName = $folderName.$title."*"; //completing the path for the image
        $fileinfo = glob($fileName); //Find the path name with matching pattern and assign it to a variable
        $file = end($fileinfo); //choosing the last element found from the glob search

        //delete image from folder
        if(!unlink($file)){
            header("Location: ../html/admin.php?delete=fail");
            exit();
        }
        else{
            //delete corresponding data for the image from the database
            $sql = "DELETE FROM promotions where title='$title'";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
            header("Location: ../html/admin.php?delete=success");
            exit();
        }
    }

?>