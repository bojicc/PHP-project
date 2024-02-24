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
            <span>Vrsta proizvoda:</span>
            <input type="text" name="proizvod">
        </label>
        <input type="submit" value="Obrisi proizvod" name="Obrisi_proizvod">
    </form>

    <?php 
    try {
        $pdo = new PDO("mysql:host=localhost; dbname=projekat_it44/20", "root", "");
        echo "Konekcija uspesna";

        $sql="DELETE FROM prodavnicagarderobe WHERE proizvod=:proizvod";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(":proizvod", $proizvod)

        if (isset($_POST['Obrisi_proizvod'])) {
            $proizvod=$_POST['proizvod'];
            if ($proizvod !== "") {
                if (strlen($proizvod) <= 1) {
                    echo "<br>Ime proizvoda  mora sadrzati bar jedan karakter";
                }
                else {
                    $stmt->execute();
                    echo "<br>Proizvod uspesno obrisan";
                }
            }
            else {
                echo "<br>Proizvod ne postoji u bazi";
            }

            if (ctype_alpha(ctype_space($_POST['proizvod']))) {
                echo "Ovo je ispravan unos <br>";
            }

            class ispisIzPolja
            {
                public $ime;

                function set_name($ime){
                    $this->name = $ime;
                }
                function get_name(){
                    return $this->ime;
                }
            }
            
            $unos = new ispisIzPolja();

            $unos->set_name{($_POST['proizvod'])};

            echo '<h3>' .$unos->get_name(). ' ' .'Uspesno obrisan iz baze!' . '</h3>';
            echo '<br>';
        }



        $sql1="DROP PROCEDURE IF EXISTS get_proiz";
        $sql2="CREATE PROCEDURE get_proiz(
        in proizvodProd VARCHAR(50),
        out sifraProiz INT(10)
        )
        BEGIN
        SELECT cena into sifraProiz FROM prodavnicagarerobe WHERE proizvod = proizvodProd;
        END;";

        $pdo->exec($sql1);
        $pdo->exec($sql2);
        echo "Procedura uspesno kreirana. <br>";

        $sql="CALL get_proiz(:proizvodProd. @sifraProiz)";
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(":proizvodProd", $proizvodSifra);
        $proizvodSifra="Jakna";
        $stmt->execute();

        $result=$pdo->query("SELECT @sifraProiz as sifraProiz");
        foreach ($result as $row) {
            echo $row['sifraProiz'];
        }

    } 
    catch (PDOException $e) {
        echo $e->getMessage();
    } 
    ?>
</body>
</html>