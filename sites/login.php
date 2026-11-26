<div>
    <?php if(isset($errormsg)): ?>
    <span><?= $errormsg ?></span>
    <?php endif; ?>
    <form action="?site=login" method="post">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Passwort</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit" name="login">Login</button>
    </form>
</div>