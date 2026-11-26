<h1><?= $editing ? 'Werkzeug bearbeiten' : 'Werkzeug hinzufügen' ?></h1>
<?php if (isset($errormsg)): ?>
    <p><?= htmlspecialchars($errormsg) ?></p>
<?php endif; ?>
<?php if (!$editing || $tool): ?>
<form action="<?= $editing ? '?site=edittool&amp;id=' . $id : '?site=newtool' ?>" method="post">
    <?php if ($editing): ?>
        <input type="hidden" name="token" value="<?= htmlspecialchars($toolToken) ?>">
    <?php endif; ?>
    <label for="inventoryid">Inventarnummer</label>
    <input type="text" id="inventoryid" name="inventoryid" maxlength="255" value="<?= htmlspecialchars($inventoryid) ?>" required><br><br>
    <label for="name">Bezeichnung</label>
    <input type="text" id="name" name="name" maxlength="255" value="<?= htmlspecialchars($name) ?>" required><br><br>
    <label for="category">Kategorie</label>
    <input type="text" id="category" name="category" maxlength="255" value="<?= htmlspecialchars($category) ?>" required><br><br>
    <label for="description">Beschreibung</label>
    <input type="text" id="description" name="description" value="<?= htmlspecialchars($description) ?>"><br><br>
    <label for="price">Tagespreis</label>
    <input type="text" id="price" name="price" value="<?= htmlspecialchars($price) ?>" required><br><br>

    <button type="submit" name="add"><?= $editing ? 'Speichern' : 'Hinzufügen' ?></button>
</form>
<?php endif; ?>
