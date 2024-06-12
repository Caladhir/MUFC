<?php
include 'connect.php';

$admin = false;

if (isset($_SESSION['razina_dozvole']) && $_SESSION['razina_dozvole'] === 'administrator') {
    $admin = true;
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM vijesti WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['update'])) {
    $naslov = $_POST['naslov'];
    $kratki_sadrzaj = $_POST['kratki_sadrzaj'];
    $tekst = $_POST['tekst'];
    $kategorija = $_POST['kategorija'];
    $arhiva = isset($_POST['arhiva']) ? 1 : 0;
    $id = $_POST['id'];

    if (!empty($_FILES['slika']['name'])) {
        $slika = $_FILES['slika']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($slika);

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        move_uploaded_file($_FILES['slika']['tmp_name'], $target_file);

        $query = "UPDATE vijesti SET naslov=?, kratki_sadrzaj=?, tekst=?, slika=?, kategorija=?, arhiva=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssssi', $naslov, $kratki_sadrzaj, $tekst, $target_file, $kategorija, $arhiva, $id);
    } else {
        $query = "UPDATE vijesti SET naslov=?, kratki_sadrzaj=?, tekst=?, kategorija=?, arhiva=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssssi', $naslov, $kratki_sadrzaj, $tekst, $kategorija, $arhiva, $id);
    }

    $stmt->execute();
    $stmt->close();
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
    <link rel="stylesheet" href="css/admin.css">
    <title>Administracija - Manchester United</title>
</head>
<body>
    <header>
        <img src="images/mufc_logo.png" alt="Manchester United Logo" >
        <h1>Dobrodošao nazad <?php echo isset($_SESSION['korisnicko_ime']) ? $_SESSION['korisnicko_ime'] : 'Gost'; ?></h1>
        <div><?php echo date('d/m/Y'); ?></div>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="unos.php">UNOS VIJESTI</a></li>
                <?php if (isset($_SESSION['razina_dozvole']) && $_SESSION['razina_dozvole'] === 'administrator') : ?>
                    <li><a href="admin.php">ADMIN</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['korisnicko_ime'])) : ?>
                    <li><a href="?logout=true">LOGOUT</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <main>
        <div class="form-search">
            <form action="" method="POST">
                <label for="kategorija">Kategorija: </label>
                <select class="kategorija" name="kategorija">
                    <option value="" disabled selected>Odabir kategorije</option>
                    <option value="vijesti">Vijesti</option>
                    <option value="utakmice">Utakmice</option>
                    <option value="transferi">Transferi</option>
                </select>
                <input type="submit" id="search" value="Search" />
            </form>
        </div>
        <div class="container">
            <?php 
            $query = "SELECT * FROM vijesti";
            if (isset($_POST['kategorija'])) {
                $kat = $_POST['kategorija'];
                $query .= " WHERE kategorija = '$kat'";
            }
            $query .= " ORDER BY datum DESC";
            $rezultat = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_array($rezultat)) : ?>
                <div class="sub-container">
                    <form enctype="multipart/form-data" action="" method="POST">
                        <div class="form-item">
                            <label for="naslov">Naslov vijesti:</label>
                            <div class="form-field">
                                <input type="text" name="naslov" class="form-field-textual" value="<?= htmlspecialchars($row['naslov']); ?>">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="kratki_sadrzaj">Kratki sadržaj vijesti (do 50 znakova):</label>
                            <div class="form-field">
                                <textarea name="kratki_sadrzaj" cols="60" rows="5" class="form-field-textual"><?= htmlspecialchars($row['kratki_sadrzaj']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="tekst">Sadržaj vijesti:</label>
                            <div class="form-field">
                                <textarea name="tekst" cols="60" rows="10" class="form-field-textual"><?= htmlspecialchars($row['tekst']); ?></textarea>
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="slika">Slika:</label>
                            <div class="form-field">
                                <input type="file" id="slika" name="slika" />
                                <br>
                                <img class="img_form" src="<?= htmlspecialchars($row['slika']); ?>" width="200">
                            </div>
                        </div>
                        <div class="form-item">
                            <label for="kategorija">Kategorija vijesti:</label>
                            <div class="form-field">
                                <select name="kategorija" class="form-field-textual kategorija">
                                    <option value="<?= htmlspecialchars($row['kategorija']); ?>"><?= ucfirst($row['kategorija']); ?></option>
                                    <option value="vijesti">Vijesti</option>
                                    <option value="utakmice">Utakmice</option>
                                    <option value="transferi">Transferi</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-item" id="last_label">
                            <label>Spremiti u arhivu:
                                <div class="form-field">
                                    <input type="checkbox" name="arhiva" <?= $row['arhiva'] ? 'checked' : ''; ?>> Arhiviraj?
                                </div>
                            </label>
                        </div>
                        <div class="form-item">
                            <input type="hidden" name="id" value="<?= $row['id']; ?>">
                            <button class="btn" type="reset" value="Poništi">Reset</button>
                            <button class="btn" type="submit" name="update" value="Prihvati">Izmjeni</button>
                            <button class="btn" type="submit" name="delete" value="Izbriši">Izbriši</button>
                        </div>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </main>
    <footer>
        <p>@MANCHESTER UNITED</p>
        <p>2024</p>
        <p>AUTOR: KARLO ŠILJEVINAC</p>
        <p>KONTAKT: ksiljevin@tvz.hr</p>
      </footer>
</body>
</html>
