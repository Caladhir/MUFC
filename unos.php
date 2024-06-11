<?php
include 'connect.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naslov = $_POST['naslov'];
    $sadrzaj = $_POST['sadrzaj'];
    $tekst = $_POST['tekst'];
    $kategorija = $_POST['kategorija'];
    $arhiva = isset($_POST['arhiva']) ? 1 : 0;

    $slika = $_FILES['slika']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($slika);

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES['slika']['tmp_name'], $target_file)) {
        $sql = "INSERT INTO vijesti (naslov, kratki_sadrzaj, tekst, slika, kategorija, arhiva) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssssi", $naslov, $sadrzaj, $tekst, $target_file, $kategorija, $arhiva);
            if ($stmt->execute()) {
                $last_id = $stmt->insert_id;
                $message = "Vijest je uspješno unesena.";
                echo "<script>alert('$message'); window.location.href='skripta.php?id=$last_id';</script>";
            } else {
                $message = "Došlo je do pogreške: " . $stmt->error;
                echo "<script>alert('$message');</script>";
            }
            $stmt->close();
        } else {
            $message = "Došlo je do greške u pripremi SQL upita: " . $conn->error;
            echo "<script>alert('$message');</script>";
        }
    } else {
        $message = "Došlo je do greške prilikom prijenosa slike.";
        echo "<script>alert('$message');</script>";
    }
}

$conn->close();
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
    <link rel="stylesheet" href="css/style.css">
    <title>Unos Vijesti - Manchester United FC</title>
</head>
<body>
    <header>
        <div class="header-logo">
            <a href="index.php"><img src="images/mufc_logo.png" alt="Manchester United Logo"></a>
        </div>
        <h1>Manchester United FC</h1>
        <h2>Unos Vijesti</h2>
        <nav>
            <ul>
                <li><a href="index.php">HOME</a></li>
                <li><a href="unos.php">UNOS VIJESTI</a></li>
                <li><a href="prijava.php">PRIJAVA</a></li>
                <li><a href="registracija.php">REGISTRACIJA</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form enctype="multipart/form-data" action="unos.php" method="POST" id="newsForm">
            <div class="form-item">
                
                <label for="naslov">Naslov vijesti</label>
                <div class="form-field">
                    <input type="text" name="naslov" id="naslov" class="form-field-textual">
                </div>
                <span id="porukaTitle" class="bojaPoruke"></span>
            </div>
            <div class="form-item">
                
                <label for="sadrzaj">Kratki sadržaj vijesti</label>
                <div class="form-field">
                    <textarea name="sadrzaj" id="sadrzaj" cols="30" rows="10" class="form-field-textual"></textarea>
                </div>
                <span id="porukaAbout" class="bojaPoruke"></span>
            </div>
            <div class="form-item">
                <label for="tekst">Sadržaj vijesti</label>
                <div class="form-field">
                    <textarea name="tekst" id="tekst" cols="30" rows="10" class="form-field-textual"></textarea>
                </div>                
                <span id="porukaContent" class="bojaPoruke"></span>

            </div>
            <div class="form-item">
                
                <label for="slika">Slika</label>
                <div class="form-field">
                    <input type="file" class="input-text" id="slika" name="slika">
                </div>
                <span id="porukaSlika" class="bojaPoruke"></span>
            </div>
            <div class="form-item">
                
                <label for="kategorija">Kategorija vijesti</label>
                <div class="form-field">
                    <select name="kategorija" id="kategorija" class="form-field-textual">
                        <option value="" disabled selected>Odabir kategorije</option>
                        <option value="Vijesti">Vijesti</option>
                        <option value="Utakmice">Utakmice</option>
                        <option value="Transferi">Transferi</option>
                    </select>
                </div>
                <span id="porukaKategorija" class="bojaPoruke"></span>
            </div>
            <div class="form-item">
                <label>Spremiti u arhivu</label>
                <div class="form-field">
                    <input type="checkbox" name="arhiva" id="arhiva">
                </div>
            </div>
            <div class="form-item">
                <button type="reset" value="Poništi">Poništi</button>
                <button type="submit" value="Prihvati" id="slanje">Prihvati</button>
            </div>
        </form>
    </main>
    <footer>
        <p>@MANCHESTER UNITED</p>
        <p>2024</p>
        <p>AUTOR: KARLO ŠILJEVINAC</p>
        <p>KONTAKT: ksiljevin@tvz.hr</p>
    </footer>
    <script type="text/javascript">
        document.getElementById("slanje").onclick = function(event) {
            var slanjeForme = true;

            var poljeTitle = document.getElementById("naslov");
            var title = poljeTitle.value;
            if (title.length < 5 || title.length > 30) {
                slanjeForme = false;
                poljeTitle.style.border = "1px dashed red";
                document.getElementById("porukaTitle").innerHTML = "Naslov vijesti mora imati između 5 i 30 znakova!<br>";
            } else {
                poljeTitle.style.border = "1px solid green";
                document.getElementById("porukaTitle").innerHTML = "";
            }

            var poljeAbout = document.getElementById("sadrzaj");
            var about = poljeAbout.value;
            if (about.length < 10 || about.length > 100) {
                slanjeForme = false;
                poljeAbout.style.border = "1px dashed red";
                document.getElementById("porukaAbout").innerHTML = "Kratki sadržaj mora imati između 10 i 100 znakova!<br>";
            } else {
                poljeAbout.style.border = "1px solid green";
                document.getElementById("porukaAbout").innerHTML = "";
            }

            var poljeContent = document.getElementById("tekst");
            var content = poljeContent.value;
            if (content.length == 0) {
                slanjeForme = false;
                poljeContent.style.border = "1px dashed red";
                document.getElementById("porukaContent").innerHTML = "Sadržaj mora biti unesen!<br>";
            } else {
                poljeContent.style.border = "1px solid green";
                document.getElementById("porukaContent").innerHTML = "";
            }

            var poljeSlika = document.getElementById("slika");
            var pphoto = poljeSlika.value;
            if (pphoto.length == 0) {
                slanjeForme = false;
                poljeSlika.style.border = "1px dashed red";
                document.getElementById("porukaSlika").innerHTML = "Slika mora biti unesena!<br>";
            } else {
                poljeSlika.style.border = "1px solid green";
                document.getElementById("porukaSlika").innerHTML = "";
            }

            var poljeCategory = document.getElementById("kategorija");
            if (poljeCategory.selectedIndex == 0) {
                slanjeForme = false;
                poljeCategory.style.border = "1px dashed red";
                document.getElementById("porukaKategorija").innerHTML = "Kategorija mora biti odabrana!<br>";
            } else {
                poljeCategory.style.border = "1px solid green";
                document.getElementById("porukaKategorija").innerHTML = "";
            }

            if (!slanjeForme) {
                event.preventDefault();
            }
        };
    </script>
</body>
</html>
