<?php
include_once "db_con.php";

if(!empty($_POST)) {
    $msg = '';
    $login_success = 0;
    if(!empty($_POST['name']) && !empty($_POST['pass'])) {

        $name = $_POST['name'];
        $pass = $_POST['pass'];
        
        $query = "SELECT id from users where email = :email and password = :pass LIMIT 1";

        $stmt = $db->prepare($query);
        $stmt->bindParam(":email",$name);
        $stmt->bindParam(":pass",$pass);
        try{
            $stmt->execute();
        }
        catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        foreach ($result as $row) {
            
            if(empty($row['id'])) {
                $msg = 'Username/Password details are incorrect';
            }
            else {
                $login_success = 1;
            }
        }
    }

    if($login_success == 1) {
        header('Location: fileupload.php');
        exit;
    }

}
echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login In Form</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="main">

        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="signup.php" class="signup-image-link">Create an account</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign In</h2>
                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="email" name="name" id="name" placeholder="Your Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password" required/>
                            </div>
                            
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                                <?php echo $msg; ?>
                            </div>
                        </form>
        
                    </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->
</html>