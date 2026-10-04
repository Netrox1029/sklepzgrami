<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    die("brak dostępu");
}
$conn = mysqli_connect("localhost", "root", "", "sklepzgrami");

if (isset(($_POST['btn']))) {
    $Wyd = $_POST['Wyd'];
    $SQL = "INSERT INTO wydawca(Nazwa) values('$Wyd')";
    $result = mysqli_query($conn, $SQL);
} else if (isset($_POST["btn4"])) {
    $Wyd = $_POST["Wyd"];
    $SQL4 = "DELETE FROM wydawca where Nazwa = '$Wyd'";
    $result = mysqli_query($conn, $SQL4);
}


if (isset(($_POST['btn1']))) {
    $Pro = $_POST['Pro'];
    $SQL1 = "INSERT INTO producent(Nazwa) values('$Pro')";
    $result = mysqli_query($conn, $SQL1);
} else if (isset($_POST["btn5"])) {
    $Pro = $_POST['Pro'];
    $SQL5 = "DELETE FROM producent where Nazwa = '$Pro'";
    $result = mysqli_query($conn, $SQL5);
}


if (isset(($_POST['btn2']))) {
    $Ser = $_POST['Ser'];
    $SQL2 = "INSERT INTO serie(title) values('$Ser')";
    $result = mysqli_query($conn, $SQL2);
} else if (isset(($_POST['btn6']))) {
    $Ser = $_POST['Ser'];
    $SQL6 = "DELETE FROM serie where title = '$Ser'";
    $result = mysqli_query($conn, $SQL6);
}


if (isset(($_POST['btn3']))) {
    $Gat = $_POST['Gat'];
    $SQL3 = "INSERT INTO gatunek_name(Nazwa) values('$Gat')";
    $result = mysqli_query($conn, $SQL3);
} else if (isset(($_POST['btn7']))) {
    $Gat = $_POST['Gat'];
    $sqlDelete = "DELETE gg  FROM game_gatunek gg JOIN gatunek_name gn ON gg.Gatunek_ID = gn.Gatunek_ID WHERE gn.Nazwa = '$Gat';";
    $sqlDelete .= "DELETE FROM gatunek_name WHERE Nazwa = '$Gat';";
    mysqli_multi_query($conn, $sqlDelete);
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
            <h1>Dodawanie</h1>
        </div>
        <div>
            <p><a href="index1.php">Powrót</a></p>
        </div>
    </header>
    <main>
        <form action="" method="POST" class="DodawanieForm">
            <label>
                <input type="text" name="Wyd" placeholder="Dodaj Wydawca"><br>
                <button type="submit" name="btn">Dodaj Wydawce</button>
                <button type="submit" name="btn4">Usuń Wydawca</button>
            </label>
            <label>
                <input type="text" name="Pro" placeholder="Dodaj Producenta"><Br>
                <button type="submit" name="btn1">Dodaj Producenta</button>
                <button type="submit" name="btn5">Usuń Producenta</button>
            </label>
            <label>
                <input type="text" name="Ser" placeholder="Dodaj Serie"><Br>
                <button type="submit" name="btn2">Dodaj Serie</button>
                <button type="submit" name="btn6">Usuń Serie</button>
            </label>
            <label>
                <input type="text" name="Gat" placeholder="Dodaj Gatunek"><Br>
                <button type="submit" name="btn3">Dodaj Gatunek</button>
                <button type="submit" name="btn7">Usuń Gatunek</button>
            </label>
        </form>
    </main>
</body>

</html>