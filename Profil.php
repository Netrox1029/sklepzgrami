<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "sklepzgrami");

if (!isset($_SESSION['user_id'])) {
    header("Location: logIn.php");
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT username, country_Name, created_at,role FROM users WHERE user_id = $userId";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$sqlGames = "SELECT g.title, g.Cena, g.appid FROM biblioteka b JOIN game g ON b.game_ID = g.game_id WHERE b.user_ID = $userId";

$resultGames = mysqli_query($conn, $sqlGames);
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylProfil.css">
    <title>Register</title>
</head>
<header>
    <div>
        <H1>Twój profil, Witaj <?php echo $user['username']; ?>! </H1>
    </div>
    <div>
        <a href="index1.php">Powrót</a>
    
        <a href="ZakupHis.php">Zobacz historie</a>
    </div>
</header>
<main>
    <div class="wholeProfil">
        <div class="info">
            <p>Nazwa: <?php echo $user['username']; ?></p>
            <p>Kraj: <?php echo $user['country_Name']; ?></p>
            <p>Konto utworzone: <?php echo $user['created_at']; ?></p>
            <p>Rola: <?php echo $user['role']; ?></p>
        </div>
        <div class="gamesOwned">
            <h2>Twoje gry</h2>
            <div>
                <?php if (mysqli_num_rows($resultGames) > 0): ?>

                    <?php while ($game = mysqli_fetch_assoc($resultGames)): ?>

                        <?php $img = "https://cdn.cloudflare.steamstatic.com/steam/apps/{$game['appid']}/header.jpg"; ?>

                        <img src="<?php echo $img; ?>" width="200"><br>
                        <strong><?php echo $game['title']; ?></strong><br>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>Nie masz gier</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
</body>

</html>