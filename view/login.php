<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přihlášení - Evidence prací</title>
</head>
<body>
    <h2>Přihlášení do systému</h2>

    <!-- Pokud Controller nastavil proměnnou $chyba, vypíšeme ji červeně -->
    <?php if (isset($chyba)): ?>
        <p style="color: red;"><?= htmlspecialchars($chyba) ?></p>
    <?php endif; ?>

    <!-- Formulář posílá data metodou POST do hlavního index.php -->
    <form action="index.php" method="POST">
        <!-- Skryté pole, podle kterého index.php pozná, že chceme přihlašovat -->
        <input type="hidden" name="akce_login" value="1">
        
        <label for="login_zcu">Orion Login:</label><br>
        <input type="text" id="login_zcu" name="login_zcu" required><br><br>

        <label for="heslo">Heslo:</label><br>
        <input type="password" id="heslo" name="heslo" required><br><br>

        <button type="submit">Přihlásit se</button>
    </form>
</body>
</html>
