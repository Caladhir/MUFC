<?php
include 'connect.php';

$is_logged_in = false;
$is_admin = false;
$username = 'Dobrodošli';

if (isset($_SESSION['korisnicko_ime']) && isset($_SESSION['razina_dozvole'])) {
    $is_logged_in = true;
    $username = $_SESSION['korisnicko_ime'];
    $is_admin = $_SESSION['razina_dozvole'] === 'administrator';
    $username = $is_admin ? 'Dobrodošao nazad admine' : "Dobrodošli, $username";
}

function format_time($datetime) {
    $date = new DateTime($datetime);
    return $date->format('H:i');
}

function format_date($datetime) {
    $date = new DateTime($datetime);
    return $date->format('Y-m-d');
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: prijava.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="hr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manchester United News">
    <meta name="keywords" content="Manchester United, Football, Soccer">
    <meta name="author" content="Karlo Šiljevinac">
    <link rel="shortcut icon" href="images/favicon2.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <title>Manchester United FC</title>
</head>
<body>
    <header>
        <div class="header-logo">
            <a href="index.php"><img src="images/mufc_logo.png" alt="Manchester United Logo"></a>
        </div>
        <h1>Manchester United FC</h1>
        <h2><?php echo $username; ?></h2>
        <nav>
            <ul>
            <li><a href="index.php">HOME</a></li>
        <li><a href="kategorija.php?id=Vijesti">VIJESTI</a></li>
        <li><a href="kategorija.php?id=Utakmice">UTAKMICE</a></li>
        <li><a href="kategorija.php?id=Transferi">TRANSFERI</a></li>
                <?php if ($is_logged_in && $is_admin): ?>
                    <li><a href="unos.php">UNOS VIJESTI</a></li>
                <?php elseif ($is_logged_in): ?>
                    <li><a href="javascript:void(0);" onclick="alert('Nemate prava za unos vijesti!')">UNOS VIJESTI</a></li>
                <?php endif; ?>
                <?php if ($is_logged_in && $is_admin) : ?>
                    <li><a href="admin.php">ADMIN</a></li>
                <?php endif; ?>
                <li><a href="prijava.php">PRIJAVA</a></li>
                <li><a href="registracija.php">REGISTRACIJA</a></li>
                <?php if ($is_logged_in) : ?>
                    <li><a href="?logout=true">LOGOUT</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <section class="vijesti">
            <div class="section-line"></div>
            <h3><span class="section-icon1">■</span>Vijesti</h3>
            <div class="news-container">
                <?php
                $query = "SELECT id, naslov, slika, datum, tekst FROM vijesti WHERE kategorija='Vijesti' AND arhiva=0 ORDER BY datum DESC LIMIT 3";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="news-item">';
                        echo '<a href="clanak.php?id=' . $row['id'] . '"></a>';
                        echo '<img src="' . $row['slika'] . '" alt="' . $row['naslov'] . '">';
                        echo '<h4>' . $row['naslov'] . '</h4>';
                        echo '<p>' . format_time($row['datum']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Greška pri izvođenju upita: ' . mysqli_error($conn) . '</p>';
                }
                ?>
            </div>
        </section>
        <section class="utakmice">
            <div class="section-line"></div>
            <h3><span class="section-icon2">■</span>Utakmice</h3>
            <div class="news-container">
                <?php
                $query = "SELECT id, naslov, slika, datum, tekst FROM vijesti WHERE kategorija='Utakmice' AND arhiva=0 ORDER BY datum DESC LIMIT 3";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="news-item">';
                        echo '<a href="clanak.php?id=' . $row['id'] . '"></a>';
                        echo '<img src="' . $row['slika'] . '" alt="' . $row['naslov'] . '">';
                        echo '<h4>' . $row['naslov'] . '</h4>';
                        echo '<p>' . format_time($row['datum']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Greška pri izvođenju upita: ' . mysqli_error($conn) . '</p>';
                }
                ?>
            </div>
        </section>
        <section class="transferi">
            <div class="section-line"></div>
            <h3><span class="section-icon3">■</span>Transferi</h3>
            <div class="news-container">
                <?php
                $query = "SELECT id, naslov, slika, datum, tekst FROM vijesti WHERE kategorija='Transferi' AND arhiva=0 ORDER BY datum DESC LIMIT 3";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="news-item">';
                        echo '<a href="clanak.php?id=' . $row['id'] . '"></a>';
                        echo '<img src="' . $row['slika'] . '" alt="' . $row['naslov'] . '">';
                        echo '<h4>' . $row['naslov'] . '</h4>';
                        echo '<p>' . format_time($row['datum']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Greška pri izvođenju upita: ' . mysqli_error($conn) . '</p>';
                }
                ?>
            </div>
        </section>
    </main>
    <footer>
        <p>@MANCHESTER UNITED</p>
        <p>2024</p>
        <p>AUTOR: KARLO ŠILJEVINAC</p>
        <p>KONTAKT: ksiljevin@tvz.hr</p>
    </footer>
</body>
</html>
