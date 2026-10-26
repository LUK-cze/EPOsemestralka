<?php
class AuthController{
    private $pdo;

    public function __construct($pdo) {
        // Pomocí $this ukladáme předané spojení $pdo do vlastnosti TÉTO instance
        $this->pdo = $pdo;
    }

    public function zobrazFormular() {
        require_once '../view/login.php';
    }



    // Zpracuje odeslaný formulář
    public function login() {
        $login_zcu = trim($_POST['login_zcu'] ?? ''); // ?? -> kdyz uzivatel prijde na stranku tak aby tam nebyla chyba ukaz jenom prazdny string
        $heslo = trim($_POST['heslo'] ?? '');

        // Najdeme uživatele v databázi podle loginu
        $stmt = $this->pdo->prepare("SELECT * FROM uzivatel WHERE login_zcu = ?"); //Šipka -> v PHP znamená: „Sáhni do objektu a zavolej jeho funkci (nebo vytáhni jeho proměnnou).“
        $stmt->execute([$login_zcu]);
        $uzivatel = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch vezme z databáze jeden konkrétní řádek s výsledkem a přemění ho na PHP pole, se kterým můžeš pracovat v kódu.

        // V našich testovacích datech kontrolujeme přímo heslo (v reálu se používá password_verify)
        // Muzeme napsat i if ($uzivatel !== false .....
        if ($uzivatel && $heslo === $uzivatel['heslo']) { //Rozdíl mezi == a === je v přísnosti kontroly: | Obyčejné == (porovnává jen hodnotu): PHP se snaží typy přizpůsobit. Takže text '10' a číslo 10 vyhodnotí jako stejné. | Striktní === (porovnává hodnotu I DATOVÝ TYP): Vyžaduje, aby to byla úplně stejná hodnota a zároveň stejný datový typ.
            // Přihlášení úspěšné -> uložíme si ho do Session
            $_SESSION['uzivatel'] = [
                'id' => $uzivatel['id'], // pod klíč 'id' ulož číslo uživatele
                'jmeno' => $uzivatel['jmeno'] . ' ' . $uzivatel['prijmeni'], // pod klíč 'jmeno' ulož text jména
                'role' => $uzivatel['role']
            ];
            echo "Přihlášení úspěšné! Vítej, " . $_SESSION['uzivatel']['jmeno'] . " (" . $_SESSION['uzivatel']['role'] . ").";
            echo '<br><a href="index.php">Pokračovat</a>';
        } else {
            $chyba = "Špatný login nebo heslo!";
            require_once '../view/login.php';
        }
    }
    

}

?>