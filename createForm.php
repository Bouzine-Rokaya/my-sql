<?php
$dsn = 'mysql:host=localhost;dbname=products';
$user = 'root';
$pass = '';

$name = $email = $username = $password = $repeatPass = $checkbox = "";
$nameErr = $emailErr = $usernameErr = $passwordErr = $repeatPassErr = $checkboxErr = "";
if($_SERVER['REQUEST_METHOD']=="POST"){
    // Cleaning function
    function test_input($data) {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
     }

   //validation name
   if(empty($_POST["name"])){
       $nameErr = "Name is required";
   }else{
       $name = test_input($_POST["name"]);

       if(!preg_match("/^[a-zA-Z-' ]*$/",$name)){
           $nameErr = "Only letters and white space allowed";
       }
   }

   //validation email
   if(empty($_POST["email"])){
       $emailErr = "Email is required";
   }else{
       $email = test_input($_POST["email"]);

       if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
           $emailErr = "Invalid email format";
       }
   }

   //validation userName
   if(empty($_POST["username"])){
       $usernameErr = "Name is required";
   }else{
       $username = test_input($_POST["username"]);

       if(!preg_match("/^[a-zA-Z-' ]*$/",$username)){
           $usernameErr = "Only letters and white space allowed";
       }
   }

   //validation password
   if(empty($_POST["password"])){
       $passwordErr = "Password is required";
   }else{
       $password = test_input($_POST["password"]);

       if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/" ,$password)){
           $passwordErr = "A <b>lowercase</b> letter</p>, A <b>capital (uppercase)</b> letter</p>, A <b>number</b></p>";
       }
   }
   
   //validation Repeat password
   if(empty($_POST["repeatPass"])){
       $repeatPassErr = "Password is required";
   }else{
       $repeatPass = test_input($_POST["repeatPass"]);

       if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $repeatPass)){
           $passwordErr = "Password must contain: a lowercase letter, an uppercase letter, and a number";
       }elseif($repeatPass !== $password) {
           $repeatPassErr = "Passwords do not match";
       }
   }
   
   // validation checkbox
   if(empty($_POST["checkbox"])){
       $checkboxErr = "You must accept the terms";
   } else {
       $checkbox = test_input($_POST["checkbox"]);
   }
   


    if ($nameErr === "" && $emailErr === "" && $usernameErr === "" &&
        $passwordErr === "" && $repeatPassErr === "" && $checkboxErr === "") {
        
        try {
            $conn = new PDO($dsn, $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $st = $conn->prepare("SELECT * FROM inscription WHERE email = :email OR username = :username");
            $st->bindParam(':email', $email);
            $st->bindParam(':username', $username);
            $st->execute();

            if ($st->rowCount() > 0) {
                $existUser = $st->fetch(PDO::FETCH_ASSOC);
                if ($existUser['email'] === $email) {
                    $emailErr = "This email is already registered.";
                }
                if ($existUser['username'] === $username) {
                    $usernameErr = "This username is already taken.";
                }
            } else {
                $passwordhash = password_hash($password, PASSWORD_DEFAULT);
                $repeatPasshash = password_hash($repeatPass, PASSWORD_ARGON2I);

                $st = $conn->prepare('INSERT INTO inscription(fullname, email, username, password, repeatpassword)
                                    VALUES (:fullname, :email, :username, :password, :repeatpassword)');
                $st->bindParam(':fullname', $name);
                $st->bindParam(':email', $email);
                $st->bindParam(':username', $username);
                $st->bindParam(':password', $passwordhash);
                $st->bindParam(':repeatpassword', $repeatPasshash);

                $st->execute();
                $successMessage = "Registration successful!";
            }
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
        }
    }
}
?>



      

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Sign Up</h1>
    <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <p>Full Name :</p>
        <input type="text" name="name" value="<?= $name;?>">
        <span style="color:red"><?php echo $nameErr ?></span>
        <p>Email :</p>
        <input type="text" name="email" value="<?= $email;?>">
        <span style="color:red"><?php echo $emailErr ?></span>
        <p>User Name :</p>
        <input type="text" name="username" value="<?= $username;?>">
        <span style="color:red"><?php echo $usernameErr ?></span>
        <p>Password :</p>
        <input type="password" name="password" value="<?= $password;?>">
        <span style="color:red"><?php echo $passwordErr ?></span>
        <p>Repeat Password :</p>
        <input type="password" name="repeatPass" value="<?= $repeatPass;?>"><br>
        <span style="color:red"><?php echo $repeatPassErr ?></span>
        <br>

        <input type="checkbox" name="checkbox" value="accepted" <?= ($checkbox == 'accepted') ? 'checked' : ''; ?>>
        I agree to the Terms of User <br>
        <span style="color:red"><?php echo $checkboxErr ?></span>
        <br>

        <button name="button">Sign Up</button>
    </form>

    <?php
    // if ($_SERVER["REQUEST_METHOD"] == "POST" &&
    //     $nameErr == "" && $emailErr == "" && $usernameErr == "" &&
    //     $passwordErr == "" && $repeatPassErr == "" && $checkboxErr == "") {

    //     echo "<h3>Your Input:</h3>";
    //     echo "Full Name: $name <br>";
    //     echo "Email: $email <br>";
    //     echo "Username: $username <br>";
    //     echo "Password: $password <br>"; 
    //     echo "Accepted Terms: $checkbox <br>";
    // }
    ?>
</body>
</html>



