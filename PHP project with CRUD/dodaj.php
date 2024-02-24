<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="main-nav">
        <ul class="main-nav__items">
            <li class="main-nav__item"><a href="dodaj.php">Dodaj proizvod u tabelu</a></li>
            <li class="main-nav__item"><a href="izmeni.php">Izmeni proizvod u tabeli</a></li>
            <li class="main-nav__item"><a href="obrisi.php">Obrisi proizvod u tabeli</a></li>
            <li class="main-nav__item"><a href="provera.php">Proveri proizvod u tabeli</a></li>
        </ul>
    </div>

    
    <form action="" method="POST">

        <label for="proizvod">
            <span>Proizvod:</span>
            <input type="text" name="proizvod">
        </label>
        <label for="sifra">
            <span>Sifra:</span>
            <input type="text" name="sifra">
        </label>
        <label for="velicina">
            <span>Velicina:</span>
            <input type="text" name="velicina">
        </label>
        <label for="cena">
            <span>Cena:</span>
            <input type="text" name="cena">
        </label>
        <input type="submit" value="Dodaj" name="Dodaj">
    </form>

    <?php 
        try {
            $pdo=new PDO("mysql:host=localhost; dbname=projekat_it44/20", "root", "");
            $pdo->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Konekcija uspesna.";

            $sql="INSERT INTO prodavnicagarderobe (proizvod, sifra, velicina, cena) VALUES(:proizvod, :sifra, :velicina, :cena)";            
            $stmt=$pdo->prepare($sql);
                
            $stmt->bindParam(":proizvod", $proizvod);
            $stmt->bindParam(":sifra", $sifra);
            $stmt->bindParam(":velicina", $velicina);
            $stmt->bindParam(":cena", $cena);

            if(isset($_POST['Dodaj'])) {
                $proizvod = $_POST['proizvod'];
                $sifra = $_POST['sifra'];
                $velicina = $_POST['velicina'];
                $cena = $_POST['cena'];

                if($proizvod != "" && $sifra != "" && $velicina != "" && $cena != "") {
                    if (strlen($proizvod) < 4 ) {
                        echo "<br>Ime proizvoda mora sadrzati minimum 4 kraktera";
                    }
                    else if(($velicina) < 4 ){
                        echo "<br>Velicina ne moze sadrzati vise od 3 karaktera.";
                    }
                    else if(($cena) < 500 ){
                        echo "<br>Minimalna cena proizvoda je 500.";
                    }
                    else {
                        $stmt->execute();
                        echo "<br>Proizvod uspesno dodat u bazu.";
                    }
                }
                else {
                    echo "<br>Sva polja moraju biti popunjena!";
                }
            }

            $sql1 = "DROP PROCEDURE IF EXISTS spisak_garderobe";
            $sql2 = "CREATE PROCEDURE spisak_garderobe()
            BEGIN
                SELECT * FROM prodavnicagarderobe;
            END;";

            $pdo->execute($sql1);
            $pdo->execute($sql2);
            echo "Procedura uspesno kreirana! <br>";

            $sql = "CALL spisak_garderobe()";
            $pdo->query("$sql");
            $result = $pdo->query($sql);
            foreach ($result as $row) {
                echo $row['proizvod'] . " " . $row['sifra'] . " " . 
                    $row['velicina'] . " " . $row['cena']. "<br>";
            }

            $pdo = null;
        } 
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    ?>
</body>
</html>