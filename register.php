<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "sklepzgrami");

if (isset($_POST["btn"])) {
    $Name = $_POST["userName"];
    $Password = $_POST["userPassword"];
    $PasswordAgain = $_POST["userPasswordAgain"];
    $Gmail = $_POST["userGmail"];
    $Year = $_POST["userYear"];
    $Country = $_POST["userCountry"];
    $Created_At = getdate();
    if ($Name && $Gmail & $Country & $Year && ($Password === $PasswordAgain)) {
        $PasswordHashed = password_hash($Password, PASSWORD_DEFAULT);
        $Date = array($Created_At['year'], $Created_At['mon'],$Created_At['mday']);
        $Date = implode("-",$Date);
        $SQL_Register = "INSERT INTO users (username,password,email,year_of_birth,country_Name,created_at,role) values('$Name','$PasswordHashed','$Gmail','$Year','$Country','$Date','User')";
        $result = mysqli_query($conn, $SQL_Register);
        header("Location: ./logIn.php");
        exit;
    } else if ($Password !== $PasswordAgain) {
        $msg = "Hasła sie nie sa takie same";
    } else {
        $msg = "Prosze poprawnie wypisać dane";
    }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylLogin.css">
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
            <h1>Rejestracja</h1>
            <form action="" method="post">
                <input type="text" placeholder="Wpisz nazwe użytkownika" name="userName">
                <input type="password" placeholder="Wpisz hasło" name="userPassword" minlength="10">
                <input type="password" placeholder="Powtórz hasło" name="userPasswordAgain" minlength="10">
                <input type="email" placeholder="Wpisz mail" name="userGmail">
                <input type="text" name="userYear" pattern="\d{4}" placeholder="Wpisz rok swojego urodzenia">
                <input type="text" name="userCountry" placeholder="Wpisz nazwe państwa w którym żyjesz"><br>
                <button name="btn">Stwórz</button>
                <?php if (isset($msg)): ?>
                    <p><?php echo $msg; ?></p>
                <?php endif; ?>
                <p>Masz już konto?<a href="logIn.php" class="registerLogin">Zaloguj sie</a></p>

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