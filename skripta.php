<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT naslov, kratki_sadrzaj, tekst, slika, kategorija, arhiva FROM vijesti WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $row = null;
    }
    $stmt->close();
    $conn->close();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manchester United News">
    <meta name="keywords" content="Manchester United, Football, Soccer">
    <meta name="author" content="Karlo Šiljevinac">
    <link rel="shortcut icon" href="images/favicon2.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/skripta.css">
    <title>Rezultat Unosa Vijesti</title>
</head>
<body>
    <header>
        <div class="header-logo">
            <a href="index.php"><img src="images/mufc_logo.png" alt="Manchester United Logo"></a>
        </div>
        <h1>Manchester United FC</h1>
        <h2>Rezultat Unosa Vijesti</h2>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="unos.php">UNOS VIJESTI</a></li>
                <?php if (isset($_SESSION['razina_dozvole']) && $_SESSION['razina_dozvole'] === 'administrator'): ?>
                    <li><a href="admin.php">ADMIN</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['korisnicko_ime'])): ?>
                    <li><a href="?logout=true">LOGOUT</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <section class="result">
            <h3>REZULTAT UNOSA</h3>
            <?php if ($row): ?>
                <p class="uspjeh">Vijest je uspješno unesena.</p>
                <h4>Naslov: <?php echo htmlspecialchars($row['naslov']); ?></h4>
                <p>Kratki Sadržaj: <?php echo nl2br(htmlspecialchars($row['kratki_sadrzaj'])); ?></p>
                <p>Tekst Vijesti: <?php echo nl2br(htmlspecialchars($row['tekst'])); ?></p>
                <p>Kategorija: <?php echo htmlspecialchars($row['kategorija']); ?></p>
                <p>Arhiva: <?php echo $row['arhiva'] ? 'Da' : 'Ne'; ?></p>
                <?php if ($row['slika']): ?>
                    <img src="<?php echo htmlspecialchars($row['slika']); ?>" alt="Slika">
                <?php endif; ?>
            <?php else: ?>
                <p>Nije pronađena nijedna vijest.</p>
            <?php endif; ?>
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
