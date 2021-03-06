<?php ob_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/simple-sidebar.css" rel="stylesheet">
</head>

<body>
    <div class="container p-3 my-3 border">
        <img class="rounded mx-auto d-block pb-3" src="./img/logo.png" alt="logo image" width="20%">

        <!-- thanh tiêu đề tab -->
        <ul class="nav nav-tabs justify-content-center" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#login">Log-in</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#signup">Sign-up</a>
            </li>
        </ul><br>

        <!-- nội dung tab -->
        <div class="tab-content">
            <!-- tab đăng nhập -->
            <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="">Username:</label>
                        <input type="text" class="form-control" placeholder="Enter Username" name="login-username">
                    </div>
                    <div class="form-group">
                        <label for="">Password:</label>
                        <input type="password" class="form-control" placeholder="Enter Password" name="login-password">
                    </div>
                    <div class="form-group form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember"> Remember me
                        </label> | <a href="">Forgot password?</a>
                    </div>
                    <div class="row justify-content-center">
                        <button type="submit" class="btn btn-primary" name="login-submit">Log-in</button>
                    </div>
                </form>
            </div>
            <!-- tab đăng ký -->
            <div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="">Username:</label>
                        <input type="text" class="form-control" placeholder="Enter Username" name="signup-username" required>
                    </div>
                    <div class="form-group">
                        <label for="">Password:</label>
                        <input type="password" class="form-control" placeholder="Enter Password" name="signup-password" required>
                    </div>
                    <div class="form-group">
                        <label for="">Full Name:</label>
                        <input type="text" class="form-control" placeholder="Enter Name" name="signup-fullname" required>
                    </div>
                    <div class="form-group">
                        <label for="">Birthday:</label>
                        <input type="date" class="form-control" placeholder="Enter date" name="signup-birthday" required>
                    </div>
                    <div class="form-group">
                        <label for="">Email:</label>
                        <input type="email" class="form-control" placeholder="Enter Email" name="signup-email" required>
                    </div>
                    <div class="form-group">
                        <label for="">Phone Number:</label>
                        <input type="text" class="form-control" placeholder="Enter Phone Number" name="signup-phone" required>
                    </div>
                    <div class="form-group form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" type="checkbox" name="remember" required> 
                            I have read it carefully and accept <a href="">the terms</a>
                        </label>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" name="signup-submit">Sign-up</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
            session_start();
            require 'connect.php';

            // Thực hiện đăng nhập
            if (isset($_POST['login-submit'])) {
                $username = $_POST['login-username'];
                $password = $_POST['login-password'];
                if ($username == '' || $password == ''){
                    echo "<p>You should fill full information!</p>";
                } else {
                    $password = md5($password); // mã hóa password
                    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
                    $query = $conn->query($sql);
                    if ($query->num_rows != 0) {
                        $rows = mysqli_fetch_assoc($query); // $query->fetch_assoc
                        echo "<p>Login successful! <b>". $rows['fullname'] ."</b></p>";
                        $_SESSION['take_id_user'] = $rows['id_user'];              
                        header("Location: index.php");
                    } else {
                        echo "<p>Enter wrong name or password! Please re-enter!</p>"; 
                    }
                }
            }
            
            // Thực hiện tạo TK
            if (isset($_POST['signup-submit'])) {
                $username = $_POST['signup-username'];
                $password = $_POST['signup-password'];
                $fullname = $_POST['signup-fullname'];
                $birthday = $_POST['signup-birthday'];
                $email = $_POST['signup-email'];
                $phone = $_POST['signup-phone'];
                if ($username=='' || $password=='' || $fullname=='' || $email=='' || $phone=='') {
                    echo "<p>You should fill full information!</p>";
                } else {
                    $password = md5($password);
                    $sql = "INSERT INTO `users`(`username`, `password`, `name`, `birth`, `email`, `phone`) VALUES ('$username','$password','$fullname', '$birthday', '$email', '$phone')";
                    $query = mysqli_query($conn, $sql);
                    if ($query != 0) {
                        echo "<p>Signup Successful</p>";
                    } else {
                        echo "<p>Signup Fail</p>";
                    }
                }
            }
        ?>
    </div>
</body>

</html>