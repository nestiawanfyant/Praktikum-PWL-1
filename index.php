<?php 
    include("./config.php");

    if(isset($_GET['code'])){
        $token = $client->FetchAccessTokenWithAuthCode($_GET['code']);
        if(!isset($token['error'])){
            $client->setAccessToken($token['access_token']);
            $_SESSION['access_token'] = $token['access_token'];
            $googleService= new Google_Service_Oauth2($client);

            $data = $googleService->userinfo->get();

            if(!empty($data['given_name'])){ $_SESSION['user_first_name'] = $data['given_name']; }
            if(!empty($data['family_name'])){ $_SESSION['user_last_name'] = $data['family_name']; }
            if(!empty($data['email'])){ $_SESSION['user_email'] = $data['email']; }
            $_SESSION['login'] = true;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem And OAuth With Google</title>

    <style>
        input {
            margin:5px 10px;
            width:400px;
            padding: 10px;
            font-size: 15px;
            border-radius: 5px
        }

        .button {
            width: 425px;
            background-color: #1bb66a;
            border: none;
            color: white;
            font-weight: 700;
        }

        .loginWithGoogle {
            margin: 0 auto;
            width:300px;
            display: block;
        }
    </style>
</head>
<body>
    <?php if(isset($_SESSION['login'])){ ?>
        <p>Selamat Datang <b><?php echo $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'] ?></b></p>
        <p>Alamat E-mail Milik Anda : <?php echo $_SESSION['user_email'] ?></p>
        <p>Status Login anda : <?php echo ($_SESSION['login'] == true) ? "Anda Sedang Aktif" : "Anda Tidak Aktif"; ?></p>
        <p>Jika ingin logout : <a href="./logout.php">Logout</a></p>
    <?php } else { ?>
        <form method="post" style="width:50%;margin:0 auto;text-align:center;">
            <p>Login Akun</p>
            <input type="text" name="email" placeholder="Masukan Email"><br>
            <input type="password" name="password" placeholder="Masukan Password"><br>
            <input type="submit" class="button" value="Login">
        </form>

        <br> <hr>

        <?php
            if(!isset($_SESSION['access_token'])) {
                echo '<a class="loginWithGoogle" href="'. $client->createAuthUrl() .'"> <img src="https://res.cloudinary.com/practicaldev/image/fetch/s--YVSXRIP0--/c_limit%2Cf_auto%2Cfl_progressive%2Cq_auto%2Cw_880/https://thepracticaldev.s3.amazonaws.com/i/c74ljgt1t4o1ko28ycm8.png" width="300px" /> </a>';
            } 
        ?>
    <?php } ?>
</body>
</html>

<?php 

    $dataEmail = "nestiawan.118140190@student.itera.ac.id";
    $dataPass = "nestiawan";

    if(isset($_POST['email']) && isset($_POST['password'])){

        $email = $_POST['email'];
        $password = $_POST['password'];

        if($email == $dataEmail && $password == $dataPass){
            $_SESSION['user_first_name'] = "Nestiawan";
            $_SESSION['user_last_name'] = "Ferdiyanto";
            $_SESSION['user_email'] = "nestiawan.118140190@student.itera.ac.id";
            $_SESSION['login'] = true;

            header("location:index.php"); 
        } else {
            echo " <p style='text-align:center;font-size:30px;color:red;'>Gagal Login</p> ";
            // echo '<a href="index.php" style="text-align:center;display:block;font-size:30px;"> Kembali </a>';
        }
    }