<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "sklepzgrami");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    die("brak dostępu");
} else {

    $gameId = $_POST['game_id'];

    $sql = "SELECT * FROM game WHERE game_id = $gameId";
    $result = mysqli_query($conn, $sql);
    $game = mysqli_fetch_assoc($result);

    $SQLp = "SELECT * FROM producent";
    $producenci = mysqli_query($conn, $SQLp);

    $SQLw="SELECT * FROM wydawca";
    $wydawcy = mysqli_query($conn, $SQLw);

    $SQLs = "SELECT * FROM serie";
    $serie = mysqli_query($conn, $SQLs);

    if (isset($_POST['btn'])) {

        $name = $_POST['gameName'];
        $producent = $_POST['gameProducent'];
        $wydawca = $_POST['gameWydawca'];
        $seria = $_POST['gameSerie'];
        $cena = $_POST['gameCena'];
        $rok = $_POST['gameDate'];

        $sql = "
    UPDATE game SET
        title = '$name',
        Producent_ID = $producent,
        Wydawca_ID = $wydawca,
        Serie_ID = $seria,
        Cena = $cena,
        Rok_Wydania = $rok
    WHERE game_id = $gameId
    ";

        mysqli_query($conn, $sql);

        header("Location: index1.php");
        exit();
    }
}
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
            <h1>Edycja gier</h1>
        </div>
        <div>
            <p><a href="index1.php">Powrót</a></p>
        </div>
    </header>
    <main>
        <form method="POST" class="DodawanieForm">

            <input type="hidden" name="game_id" value="<?= $gameId ?>">

            <input type="text" name="gameName" value="<?= $game['title'] ?>">

            <select name="gameProducent">
                <?php while ($p = mysqli_fetch_assoc($producenci)): ?>
                    <option value="<?= $p['Producent_ID'] ?>" <?= ($p['Producent_ID'] == $game['Producent_ID']) ? 'selected' : '' ?>>
                        <?= $p['Nazwa'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <select name="gameWydawca">
                <?php while ($w = mysqli_fetch_assoc($wydawcy)): ?>
                    <option value="<?= $w['Wydawca_ID'] ?>" <?= ($w['Wydawca_ID'] == $game['Wydawca_ID']) ? 'selected' : '' ?>>
                        <?= $w['Nazwa'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <select name="gameSerie">
                <?php while ($s = mysqli_fetch_assoc($serie)): ?>
                    <option value="<?= $s['Serie_ID'] ?>" <?= ($s['Serie_ID'] == $game['Serie_ID']) ? 'selected' : '' ?>>
                        <?= $s['title'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <input type="number" step="any" name="gameCena" value="<?= $game['Cena'] ?>">
            <input type="number" name="gameDate" value="<?= $game['Rok_Wydania'] ?>">

            <button name="btn">Zapisz</button>

        </form>
    </main>
</body>

</html>