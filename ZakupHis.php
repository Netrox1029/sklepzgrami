<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "sklepzgrami");

if (!isset($_SESSION['user_id'])) {
    header("Location: logIn.php");
    exit();
}

$userId = $_SESSION['user_id'];
$SQL = "SELECT g.appid,g.title, u.user_id, z.Cena, z.Data_Zakupu from zakup z join users u on z.user_ID = u.user_id join game g on z.game_ID = g.game_id where z.user_ID = $userId;";
$result = mysqli_query($conn, $SQL);
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylCart.css">
    <title>Document</title>
</head>
<body>
    <header>
        <div>
            <h1>Historia Zakupów</h1>
        </div>
        <div>
            <p><a href="Profil.php">Powrót na Profil</a></p>
        </div>
    </header>
    <main>
        <div class="zakupMain">
        <?php while ($game = mysqli_fetch_assoc($result)): ?>
            <div class="zakupHis">
                <?php $img = "https://cdn.cloudflare.steamstatic.com/steam/apps/{$game['appid']}/header.jpg"; ?>
                <img src="<?php echo $img ?>" width="200px">
                <p><?php echo $game['title']; ?></p>
                <p><?php echo $game['Cena']; ?>zł</p>
                <p><?php echo $game['Data_Zakupu']; ?></p>
            </div>
        <?php endwhile; ?>
        </div>
    </main>
</body>

</html>