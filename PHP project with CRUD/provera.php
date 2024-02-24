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
        <input type="submit" value="Izaberi" name="Izaberi">
    </form>

    
    <?php 
        $mysqli = new mysqli("localhost", "root", "", "projekat_it44/20");
        if ($mysqli->connect_errno) {
            echo "Greska!";
            exit();
        }
        echo "Konekcija uspesna! <br><br>";

        $sql = "SELECT * FROM prodavnicagarderobe WHERE proizvod = ?";

        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $vrsta);

        if (isset($_POST['Izaberi'])) {
            $vrsta = $_POST['proizvod'];

            if ($vrsta !== "") {
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($mysqli->affected_rows > 0 ) {
                    echo "<br>" . "Ime proizvoda: " . $row['proizvod']. "<br>" . "Sifra proizvoda: " . $row['sifra'] . "<br>" . "Velicina proizvoda: " . $row['velicina'] . "<br>" . 
                    "Cena proizvoda: " . $row['cena'];
                }
                else {
                    echo "Nema proizvoda sa tim imenom!";
                }


                if (filter_var($vrsta, FILTER_VALIDATE_INT) === FALSE) {
                    echo "Uneli ste dobre podatke u polje";
                }
                else {
                    echo "Unsite samo slova u polje za pretragu";
                }

                class ispisIzPolja {
                    //svojstva
                    public $ime;

                    //metode
                    function set_name($ime){
                        $this->ime = $ime;
                    }
                    function get_name(){
                        return $this->ime;
                    }
                }

                $unos = new ispisIzPolja();

                $unos->set_name(($_POST['proizvod']));

                echo 'Pretraga za' . ' ' .$unos->get_name(). ' ' .'uspesno izvrsena!';
                echo "<br>";
            }
        }
    ?>
</body>
</html>