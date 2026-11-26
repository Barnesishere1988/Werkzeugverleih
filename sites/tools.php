<h1>Werkzeuge</h1>
<a href="?site=newtool">Werkzeug hinzufügen</a>

<?php if (isset($errormsg)): ?>
    <p><?= htmlspecialchars($errormsg) ?></p>
<?php elseif (isset($successmsg)): ?>
    <p><?= htmlspecialchars($successmsg) ?></p>
<?php endif; ?>

<?php if ($tools === [] && !isset($errormsg)): ?>
    <p>Es wurden noch keine Werkzeuge angelegt.</p>
<?php elseif ($tools !== []): ?>
    <table>
        <thead>
            <tr>
                <th>Inventarnummer</th>
                <th>Bezeichnung</th>
                <th>Kategorie</th>
                <th>Beschreibung</th>
                <th>Tagespreis</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tools as $tool): ?>
                <tr>
                    <td><?= htmlspecialchars($tool['inventoryid']) ?></td>
                    <td><?= htmlspecialchars($tool['name']) ?></td>
                    <td><?= htmlspecialchars($tool['category']) ?></td>
                    <td><?= htmlspecialchars($tool['description']) ?></td>
                    <td><?= number_format((float) $tool['price'], 2, ',', '.') ?> €</td>
                    <td>
                        <a href="?site=edittool&amp;id=<?= (int) $tool['id'] ?>">Bearbeiten</a>
                        <form action="?site=tools" method="post" onsubmit="return confirm('Dieses Werkzeug löschen?');">
                            <input type="hidden" name="id" value="<?= (int) $tool['id'] ?>">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($toolToken) ?>">
                            <button type="submit" name="delete">Löschen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
