<h1>Kunde anlegen</h1>
<?php if (isset($errormsg)): ?>
    <p><?= htmlspecialchars($errormsg) ?></p>
<?php elseif (isset($successmsg)): ?>
    <p><?= htmlspecialchars($successmsg) ?></p>
<?php endif; ?>
<form action="?site=newcustomer" method="post">
    <label for="firstname">Vorname</label>
    <input type="text" id="firstname" name="firstname" maxlength="255" value="<?= htmlspecialchars($firstname) ?>" required><br><br>
    <label for="lastname">Nachname</label>
    <input type="text" id="lastname" name="lastname" maxlength="255" value="<?= htmlspecialchars($lastname) ?>" required><br><br>
    <label for="email">E-Mail-Adresse</label>
    <input type="email" id="email" name="email" maxlength="255" value="<?= htmlspecialchars($email) ?>" required><br><br>
    <label for="phone">Telefonnummer</label>
    <input type="tel" id="phone" name="phone" maxlength="50" value="<?= htmlspecialchars($phone) ?>" required><br><br>

    <button type="submit" name="add">Anlegen</button>
</form>
