<?php
session_start();
if (isset($_POST["btn"])) {
    $conn = mysqli_connect("localhost", "root", "", "sklepzgrami");

    $Name = $_POST["userName"];
    $Password = $_POST["userPassword"];
    $SQL = "SELECT user_id, username, password,role FROM users WHERE username = '$Name'";
    $result = mysqli_query($conn, $SQL);
    $rows = mysqli_fetch_assoc($result);
    if($rows){
        if ($Name === $rows["username"] && password_verify($Password, $rows['password'])) {
        $_SESSION['user_id'] = $rows['user_id'];
        $_SESSION['username'] = $rows['username'];
        $_SESSION['role'] = $rows['role'];
        
        header("Location: ./index1.php");
        exit;
    }
    } else {
        $msg = "Nie ma takiego konta";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Register</title>
</head>

<body>
    <header>
        <div>
            <h1>Zteam</h1>
        </div>
        <div>
            <p><a href="">O firmie</a></p>
            <p><a href="">Prawa autorskie</a></p>
        </div>
    </header>
    <main class="ImgGracz">
        <div>
            <h1>Zaloguj się</h1>
            <form action="" method="post">
                <input type="text" placeholder="Wpisz nazwe użytkownika" name="userName">
                <input type="password" placeholder="Wpisz hasło" name="userPassword" minlength="10">
                <button name="btn">Zaloguj</button>
                <?php if (isset($msg)): ?>
                    <p><?php echo $msg; ?></p>
                <?php endif; ?><br>
                <a href="register.php" class="registerLogin">Rejestracja</a>
            </form>
        </div>
    </main>
    <footer>
        <div>
            <h3>Kontakty:</h3>
            <p>Autor:Kacper Pietrzyk</p>
            <p>telefon:978538964</p>
            <p>Gmail:kacperpietrzyk10293847@gmail.com</p>
        </div>
    </footer>
</body>

</html>