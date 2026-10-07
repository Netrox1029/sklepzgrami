<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "sklepzgrami");

if (!isset($_SESSION['user_id'])) {
    header("Location: logIn.php");
    exit();
}
if (isset($_POST['addToCart'])) {
    $id = $_POST['game_id'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = 1;
    } else {
        $_SESSION['cart'][$id]++;
    }
    header("Location: index1.php");
    exit();
}

if (isset($_POST['remove_id'])) {
    $id = $_POST['remove_id'];
    unset($_SESSION['cart'][$id]);
}

if (isset($_POST['btnPay'])) {

    foreach ($_SESSION['cart'] as $gameId => $ilosc) {

        $sql = "SELECT Cena FROM game WHERE game_id = $gameId";
        $result = mysqli_query($conn, $sql);
        $game = mysqli_fetch_assoc($result);

        for ($i = 0; $i < $ilosc; $i++) {

            $userId = $_SESSION['user_id'];
            $cena = $game['Cena'];

            $sql = "INSERT INTO zakup (user_ID, game_ID, Cena, Data_Zakupu) VALUES ($userId, $gameId, $cena, NOW())";
            $sql2 = "INSERT INTO biblioteka (user_ID, game_ID) VALUES ($userId, $gameId)";
            mysqli_query($conn, $sql2);
            mysqli_query($conn, $sql);
        }
    }

    unset($_SESSION['cart']);
    $finalMsg = "Zakup zakończony";
}
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
            <h1>Twój koszyk</h1>
        </div>
        <div>
            <p><a href="index1.php">Powrót</a></p>
        </div>
    </header>
    <main>
        <div class="cartLook">
            <?php if (!empty($_SESSION['cart'])): ?>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['cart'] as $gameId => $ilosc): ?>
                    <?php
                    $sql = "SELECT title, Cena ,appid FROM game WHERE game_id = $gameId";
                    $result = mysqli_query($conn, $sql);
                    $game = mysqli_fetch_assoc($result);
                    $num = $game['appid'];
                    $appid = "https://cdn.cloudflare.steamstatic.com/steam/apps/$num/header.jpg";

                    $price = $game['Cena'] * $ilosc;
                    $total += $price;
                    ?>
                    <div class="cartGame">

                        <img class="gameImage" src="<?php echo $appid; ?>">

                        <div class="gameInfo">
                            <h2><?php echo $game['title']; ?></h2>

                            <p>Ilość: <?php echo $ilosc; ?></p>

                            <p class="gamePrice">
                                <?php echo $price; ?> zł
                            </p>
                        </div>

                        <form method="POST" class="removeForm">
                            <input type="hidden" name="remove_id" value="<?php echo $gameId; ?>">
                            <button class="gamesBtn">Usuń</button>
                        </form>

                    </div>
                <?php endforeach; ?>
                <div class="paymentLook">
                    <h2>Razem: <?php echo $total; ?> zł</h2>

                    <form method="POST">
                        <button name="btnPay">Zapłać</button>
                    </form>
                </div>
            <?php else: ?>

                <p class="emptyCart">Koszyk pusty</p>

            <?php endif; ?>
        </div>
    </main>
</body>

</html>