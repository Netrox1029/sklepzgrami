<?php

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    die("brak dostępu");
} else {
    $pdo = new PDO("mysql:host=localhost;dbname=sklepzgrami", "root", "");
    $stmt = $pdo->query("SELECT * FROM gatunek_name");
    $genres = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT * FROM serie");
    $serie = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT * FROM wydawca");
    $wydawcy = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->query("SELECT * FROM producent");
    $producenci = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (isset($_POST['btn'])) {

        $gameName = $_POST['gameName'];
        $gameProducent = $_POST['gameProducent'];
        $gameWydawca = $_POST['gameWydawca'];
        $gameCena = $_POST['gameCena'];
        $gameDate = $_POST['gameDate'];
        $gameSerie = $_POST['gameSerie'];
        $msg = "";

        function findGame($gameName)
        {
            $url = "https://store.steampowered.com/api/storesearch/?term=" . urlencode($gameName) . "&l=english&cc=US";
            $response = file_get_contents($url);
            $data = json_decode($response, true);
            return $data['items'][0];
        }

        if ($gameName && is_numeric($gameCena) && $gameDate && $gameProducent && $gameWydawca && $gameSerie) {
            $gamePic = findGame($gameName);
            $appid = $gamePic["id"];
            $stmt = $pdo->prepare("INSERT INTO game (title,Wydawca_ID,Producent_ID,Serie_ID,Cena,Rok_Wydania,appid) VALUES (?,?,?,?,?,?,?)");

            $stmt->execute([$gameName, $gameWydawca, $gameProducent, $gameSerie, $gameCena, $gameDate, $appid]);
            $gameId = $pdo->lastInsertId();
            foreach ($_POST['genres'] as $genreId) {
                $stmt = $pdo->prepare("INSERT INTO game_gatunek (game_id, Gatunek_ID) VALUES (?, ?)");
                $stmt->execute([$gameId, $genreId]);
            }
        } else {
            $msg = "Prosze wypisać wszystkie informacje ";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Document</title>
</head>

<body>
    <header>
        <div>
            <h1>Dodawanie gier</h1>
        </div>
        <div>
            <p><a href="index1.php">Powrót</a></p>
        </div>
    </header>

    <main class="DodawanieM">
        <form action="" method="POST" class="DodawanieForm">
            <h2>Dodaj grę</h2>
            <input type="text" name="gameName" placeholder="Nazwa gry">

            <label>Producent:</label>
            <select name="gameProducent">
                <option value="">wybierz producent</option>
                <?php foreach ($producenci as $producent): ?>
                    <option value="<?= $producent['Producent_ID'] ?>">
                        <?= $producent['Nazwa'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Wydawca:</label>
            <select name="gameWydawca">
                <option value="">wybierz wydawca</option>
                <?php foreach ($wydawcy as $wydawca): ?>
                    <option value="<?= $wydawca['Wydawca_ID'] ?>">
                        <?= $wydawca['Nazwa'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label>Seria:</label>
            <select name="gameSerie">
                <option value="">wybierz serie</option>
                <?php foreach ($serie as $seria): ?>
                    <option value="<?= $seria['Serie_ID'] ?>">
                        <?= $seria['title'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="gameCena" placeholder="Cena">
            <input type="number" name="gameDate" placeholder="Rok wydania">

            <p>Gatunki:</p>
            <span class="checkBoxes">
                <?php foreach ($genres as $genre): ?>
                    <label>
                        <input type="checkbox" name="genres[]" value="<?= $genre['Gatunek_ID'] ?>">
                        <?= $genre['Nazwa'] ?>
                    </label>
                <?php endforeach; ?>
            </span>
            <button type="submit" name="btn">Dodaj grę</button>
        </form>
    </main>
    <footer>
        <div>
            <p>Twórca strony:Kacper Pietrzyk</p>
        </div>
    </footer>
</body>

</html>