<?php 
$msg = '';
if (!empty($_FILES['user_file']['name']) && ($_FILES['user_file']['name']!="")) {
    $file_type = $_FILES['user_file']['type']; 

    $allowed = array("image/jpeg", "image/gif", "image/webp", "image/png" , "application/pdf" , "text/csv");

    if(!in_array($file_type, $allowed)) {
        $msg = 'Only jpg, gif, png, csv, and pdf files are allowed.';
    }
    
    $target_dir = "uploads/";
    $file = $_FILES['user_file']['name'];
    $path = pathinfo($file);
    $filename = $path['filename'];
    $ext = $path['extension'];
    $temp_name = $_FILES['user_file']['tmp_name'];
    $path_filename_ext = $target_dir.$filename.".".$ext;
     
    
    if (file_exists($path_filename_ext)) {
        $msg = "Sorry, file already exists.";
    } else {
        if(move_uploaded_file($temp_name,$path_filename_ext)) {
            $msg = "Congratulations! File Uploaded Successfully.";
        }
        else {
            $msg = 'File Upload Failed.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>File Upload</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

        <!-- Sign up form -->
        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">File Upload</h2>
                        <form method="POST" class="register-form" id="register-form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-cloud-upload material-icons-name"></i></label>
                                <input type="file" name="user_file" id="user_file" placeholder="Upload File" accept = 'image/*,.csv,.pdf'/>
                            </div>
                           
                            <div class="form-group form-button">
                                <input type="submit" name="" id="" class="form-submit" value="Upload"/>
                                <p><?php echo $msg ?></p>
                            </div>
                        </form>
                    </div>
                    
                </div>
            </div>
        </section>
    </div>

    
</body>
</html>