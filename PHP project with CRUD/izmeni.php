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
        <input type="submit" value="Izmeni" name="Izmeni">
    </form>

    <?php 
    try {
        $pdo=new PDO("mysql:host=localhost; dbname=projekat_it44/20", "root", "");
        $pdo->SetAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Konekcija uspesna.";

        $sql="UPDATE prodavnicagarderobe SET sifra=:sifra, velicina=:velicina, cena=:cena WHERE proizvod=:proizvod";            
        
        $stmt=$pdo->prepare($sql);
            
        $stmt->bindParam(":proizvod", $proizvod);
        $stmt->bindParam(":sifra", $sifra);
        $stmt->bindParam(":velicina", $velicina);
        $stmt->bindParam(":cena", $cena);

        if (isset($_POST['Izmeni'])) {
            $proizvod = $_POST['proizvod'];
            $sifra = $_POST['sifra'];
            $velicina = $_POST['velicina'];
            $cena = $_POST['cena'];

            if ($proizvod != "" && $sifra != "" && $velicina != "" && $cena != "") {
                if (strlen($proizvod) < 4 ) {
                    echo "<br>Ime proizvoda mora sadrzati minimum 4 kraktera";
                }
                else if(($sifra) < 1 ){
                    echo "<br>Sifra mora sadrzati minimum jedan karakter.";
                }
                else if(($velicina) < 1 ){
                    echo "<br>Velicina mora sadrzati 1 ili vise karaktera.";
                }
                else if(($cena) < 500 ){
                    echo "<br>Minimalna cena proizvoda je 500.";
                }
                else {
                    $stmt->execute();
                    echo "<br>Proizvod izmenjen."
                }
            }
            else {
                echo "<br>Sva polja moraju biti popunjena!";
            }

            $pdo->beginTransaction();

            $sql1="SELECT proizvod, sifra, velicina, cena FROM prodavnicagarderobe WHERE proizvod=:proizvodi";
            $stmt=$pdo->prepare($sql1);
            $stmt->bindParam(":proizvodi", $proizvodi);
            $proizvodi=$proizvod;
            $stmt->execute();
            $result=$stmt->fetchAll();

            foreach ($result as $row) {
                $proizvodi=$row['proizvod'];
                $sifra=$row['sifra'];
                $velicina=$row['velicina'];
                $cena=$row['cena'];
            }

            $sql1="UPDATE prodavnicagarderobe SET proizvod=:proizvod WHERE cena=:cena";
            $stmt=$pdo->prepare($sql1);
            $stmt->bindParam(":cena", $cena);
            $velicina= "M";
            $stmt->bindParam(":proizvod", $proizvodi);
            $stmt->execute();
            echo "Za artika; $proizvodi cena je promenjena na $cena. <br>";

            $pdo->commit();
        }
    }
    catch(PDOException $e){
        echo $e->getMessage();
    } 
    ?>
</body>
</html>