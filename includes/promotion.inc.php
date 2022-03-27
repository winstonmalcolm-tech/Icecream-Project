<?php
    if(isset($_POST['promotion-upload'])){
        include_once 'dbh.inc.php';

        $folderName = "../gameicons/";

        $title = $_POST['title'];
        $message = $_POST['message'];
        $date = $_POST['date'];

        $file = $_FILES['file'];
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
    else if(isset($_POST['promotion-remove'])){
        include_once 'dbh.inc.php';

        $title = $_POST['title'];
        $folderName = "../gameicons/";

        $fileName = $folderName.$title."*";
        $fileinfo = glob($fileName);
        $file = end($fileinfo);

        if(!unlink($file)){
            header("Location: ../html/admin.php?delete=fail");
            exit();
        }
        else{
            $sql = "DELETE FROM promotions where title='$title'";
            mysqli_query($conn, $sql);
            mysqli_close($conn);
            header("Location: ../html/admin.php?delete=success");
            exit();
        }

    }

?>