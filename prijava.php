<?php
include 'connect.php';

$message = '';
$messageClass = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $korisnicko_ime = $_POST['korisnicko_ime'];
    $lozinka = $_POST['lozinka'];

    $query = "SELECT id, lozinka, ime, razina_dozvole FROM korisnici WHERE korisnicko_ime = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $korisnicko_ime);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $id, $hashed_password, $ime, $razina_dozvole);
    mysqli_stmt_fetch($stmt);

    if (password_verify($lozinka, $hashed_password)) {
        $_SESSION['korisnicko_ime'] = $korisnicko_ime;
        $_SESSION['ime'] = $ime;
        $_SESSION['razina_dozvole'] = $razina_dozvole;
        if ($razina_dozvole == 'administrator') {
            header("Location: admin.php");
        } elseif ($razina_dozvole == 'korisnik') {
            $message = "Dobrodošli, $ime. Nemate prava za pristup administracijskoj stranici. <a href='index.php'>POČETNA</a>" ;

            $messageClass = 'message-warning';
        
        }
    } else {
        $message = "Neispravno korisničko ime ili lozinka. <a href='registracija.php'>Registrirajte se</a>";
        $messageClass = 'message-error';
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
    <title>Prijava</title>
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
                <li><a href="registracija.php">REGISTRACIJA</a></li>
                <?php if (isset($_SESSION['korisnicko_ime'])): ?>
                    <li><a href="?logout=true">LOGOUT</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <form action="prijava.php" method="post">
            <h2>PRIJAVITE SE</h2>
            <div id="message" class="<?php echo isset($messageClass) ? $messageClass : ''; ?>">
            <?php echo isset($message) ? $message : ''; ?>
            <label for="korisnicko_ime">Korisničko ime:</label>
            <input type="text" id="korisnicko_ime" name="korisnicko_ime" required>
            
            <label for="lozinka">Lozinka:</label>
            <input type="password" id="lozinka" name="lozinka" required>
            
            <button type="submit">PRIJAVI SE</button>
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
