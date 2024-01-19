<?php
include_once "db_con.php";
$msg = '';
$create_record = "";
if(!empty($_POST)) {
    if(
        !empty($_POST['name']) && 
        !empty($_POST['email']) &&
        !empty($_POST['pass']) &&
        !empty($_POST['re_pass']) 
    ) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $re_pass = $_POST['re_pass'];

        $created = $modified = date("Y-m-d H:i:s");

        $query = "SELECT id from users where email = :email and password = :pass LIMIT 1";

        $stmt = $db->prepare($query);
        $stmt->bindParam(":email",$email);
        $stmt->bindParam(":pass",$pass);
        try{
            $stmt->execute();
        }
        catch (PDOException $e) {
            echo "Query failed: " . $e->getMessage();
        }
       
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(empty($result)) {            
            $create_record = "yes";
        }
        else {
            $create_record = "no";
        }

        if($create_record == "yes") {

            $sql = 'INSERT INTO users(name,email,password,created,modfied) '
                    . 'VALUES(:name,:email,:pass,:created,:modified)';
    
            $stmt = $db->prepare($sql);

            try{
                $stmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':pass' => $pass,
                    ':created' => $created,
                    ':modified' => $modified,
                ]);
            }
            catch (PDOException $e) {
                echo "Query failed: " . $e->getMessage();
            }            
    
            $insertId = $db->lastInsertId();

            $msg = "Sign Up Completed";
        }
        else {
            $msg = "User with submitted credentials already exists";
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
    <title>Sign Up Form</title>

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
                        <h2 class="form-title">Sign up</h2>
                        <form method="POST" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="name" id="name" placeholder="Your Name" required/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email" required/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="pass" id="pass" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_pass" id="re_pass" placeholder="Repeat your password" required/>
                            </div>
                            
                            <div class="form-group form-button">
                                <?php echo $msg; ?>
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="index.php" class="signup-image-link">I am already member</a>
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