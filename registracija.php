<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = password_hash($_POST['lozinka'], PASSWORD_DEFAULT);
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $razina_dozvole = 'korisnik';

    $query = "INSERT INTO korisnici (korisnicko_ime, lozinka, ime, prezime, razina_dozvole) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssss', $korisnicko_ime, $lozinka, $ime, $prezime, $razina_dozvole);

    if (mysqli_stmt_execute($stmt)) {
        echo "Registracija uspješna!";
    } else {
        echo "Greška: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: prijava.php");
    exit();}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manchester United News">
    <meta name="keywords" content="Manchester United, Football, Soccer">
    <meta name="author" content="Karlo Šiljevinac">
    <link rel="shortcut icon" href="images/favicon2.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title>Registracija</title>
</head>
<body>
    <header>
        <div class="header-logo">
            <a href="index.php"><img src="images/mufc_logo.png" alt="Manchester United Logo"></a>
        </div>
        <h1>Manchester United FC</h1>
        <h2>Dobrodošli na službenu stranicu Manchester Uniteda</h2>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="prijava.php">PRIJAVA</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="registracija.php" method="post">
            <h2>KREIRAJTE VAŠ NOVI RAČUN</h2>
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime" required>
            
            <label for="prezime">Prezime:</label>
            <input type="text" id="prezime" name="prezime" required>
            
            <label for="korisnicko_ime">Korisničko ime:</label>
            <input type="text" id="korisnicko_ime" name="korisnicko_ime" required>
            
            <label for="lozinka">Lozinka:</label>
            <input type="password" id="lozinka" name="lozinka" required>
            
            <label for="ponovljena_lozinka">Ponovite lozinku:</label>
            <input type="password" id="ponovljena_lozinka" name="ponovljena_lozinka" required>
            
            <button type="submit">REGISTRIRAJ</button>
        </form>
    </main>
    <footer>
        <p>@MANCHESTER UNITED</p>
        <p>2024</p>
        <p>AUTOR: KARLO ŠILJEVINAC</p>
        <p>KONTAKT: ksiljevin@tvz.hr</p>
    </footer>
</body>
</html>
