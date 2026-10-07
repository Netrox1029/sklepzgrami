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
    <title>Profil - Zteam</title>
</head>

<body>
<header>
    <div class="headerContent">
        <h1>Twój profil, Witaj <?php echo $user['username']; ?>!</h1>
        <div class="headerLinks">
            <a href="index1.php">Powrót</a>
            <a href="ZakupHis.php">Zobacz historie</a>
        </div>
    </div>
</header>
<main>
    <div class="wholeProfil">
        <div class="info">
            <p>
                <span>Nazwa:</span>
                <?php echo $user['username']; ?>
            </p>
            <p>
                <span>Kraj:</span>
                <?php echo $user['country_Name']; ?>
            </p>
            <p>
                <span>Konto utworzone:</span>
                <?php echo $user['created_at']; ?>
            </p>
            <p>
                <span>Rola:</span>
                <?php echo $user['role']; ?>
            </p>
        </div>
        <div class="gamesOwned">
            <h2>Twoje gry</h2>
            <div class="gamesList">
                <?php if (mysqli_num_rows($resultGames) > 0): ?>
                    <?php while ($game = mysqli_fetch_assoc($resultGames)): ?>
                        <?php
                        $img = "https://cdn.cloudflare.steamstatic.com/steam/apps/{$game['appid']}/header.jpg";
                        ?>
                        <div class="ownedGame">
                            <img src="<?php echo $img; ?>">
                            <strong>
                                <?php echo $game['title']; ?>
                            </strong>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="noGames">
                        Nie masz gier
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
</body>
</html>