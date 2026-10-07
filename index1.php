<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "sklepzgrami");
$SQL = "SELECT 
    g.game_id,
    g.title AS gra,
    p.Nazwa AS producent,
    w.Nazwa AS wydawca,
    s.title AS seria,
    appid,
    cena,
    GROUP_CONCAT(gn.Nazwa SEPARATOR ', ') AS gatunki,
    g.Rok_Wydania AS rok
FROM game g
LEFT JOIN producent p ON g.Producent_ID = p.Producent_ID
LEFT JOIN wydawca w ON g.Wydawca_ID = w.Wydawca_ID
LEFT JOIN serie s ON g.Serie_ID = s.Serie_ID
LEFT JOIN game_gatunek gg ON g.game_id = gg.game_id
LEFT JOIN gatunek_name gn ON gg.Gatunek_ID = gn.Gatunek_ID
GROUP BY g.game_id";
$results = mysqli_query($conn, $SQL);

$row = mysqli_fetch_all($results);

?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div>
            <h1>Zteam</h1>
        </div>
        <div>
            <p><a href="Profil.php">Profil</a></p>
            <p><a href="logIn.php">Użyj innego konta</a></p>
            <p><a href="Cart.php">Mój koszyk</a></p>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>
                <p><a href="Dodawanie.php">Dodaj gre</a></p>
                <p><a href="DodBazyDanych.php">Dodaj Pro/Wyd/Serie</a></p>
            <?php endif; ?>
        </div>
    </header>
    <main class="StronaG">
        <div class="MainContener">
            <div class="tableMain">
                <?php foreach ($row as $record): ?>
                    <?php
                    $num = $record[5];
                    $appid = "https://cdn.cloudflare.steamstatic.com/steam/apps/$num/header.jpg";
                    ?>
                    <div class="gameTab">
                        <img src="<?= $appid ?>">
                        <div class="gameInfo">
                            <div class="gameTitle"><?php echo $record[1]; ?></div>
                            <div class="gameItemsTag">
                                <!-- <span><?php echo $record[2]; ?></span> -->
                                <!-- <span><?php echo $record[3]; ?></span> -->
                                <!-- <span><?php echo $record[4]; ?></span> -->
                                <!-- <span><?php echo $record[6]; ?> zł</span> -->
                                <span><?php echo $record[7]; ?></span><br><Br>
                                <span>Rok wydania: <?php echo $record[8]; ?></span>
                                <span class="gamePrice">
                                    <?php echo $record[6]; ?> zł
                                </span>
                            </div>
                        </div>

                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin'): ?>

                            <div class="gameButtonAdmin">

                                <form method="POST" action="./Cart.php">
                                    <input type="hidden" name="game_id" value="<?= $record[0] ?>">
                                    <button type="submit" name="addToCart" class="btnBuy">Dodaj do koszyka</button>
                                </form>

                                <form method="POST">
                                    <input type="hidden" name="gameToDelete" value="<?= $record[0] ?>">
                                    <button name="btnDelete" class="btnDelete">Usuń</button>
                                </form>
                                <?php
                                if (isset($_POST['btnDelete'])) {
                                    $gameToDelete = $_POST['gameToDelete'];
                                    $sqlDelete .= "DELETE FROM game_gatunek where game_id = $gameToDelete;";
                                    $sqlDelete .= "DELETE FROM biblioteka where game_ID = $gameToDelete;";
                                    $sqlDelete .= "DELETE FROM zakup where game_ID = $gameToDelete;";
                                    $sqlDelete .= "DELETE FROM game where game_id = $gameToDelete;";
                                    mysqli_multi_query($conn, $sqlDelete);
                                    header("Location: ./index1.php");
                                    exit();
                                }
                                ?>

                                <form method="post" action="Edytowanie.php">
                                    <input type="hidden" name="game_id" value="<?= $record[0] ?>">
                                    <button class="btnEdit">Edytuj</button>
                                </form>
                            </div>

                        <?php else: ?>
                            <div class="gameButtonUser">
                                <form method="POST" action="./Cart.php">
                                    <input type="hidden" name="game_id" value="<?= $record[0] ?>">
                                    <button type="submit" name="addToCart" class="btnBuy">Dodaj do koszyka</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <footer>
        <div>
            <p>Autor:Kacper Pietrzyk</p>
            <p>Kontakt:978538964</p>
            <p>Gmail:kacperpietrzyk10293847@gmail.com</p>
        </div>
    </footer>

</body>

</html>