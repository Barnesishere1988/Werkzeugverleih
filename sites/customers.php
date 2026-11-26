<h1>Kunden</h1>
<a href="?site=newcustomer">Kunde anlegen</a>

<?php if (isset($errormsg)): ?>
    <p><?= htmlspecialchars($errormsg) ?></p>
<?php elseif (isset($successmsg)): ?>
    <p><?= htmlspecialchars($successmsg) ?></p>
<?php endif; ?>

<?php if ($customers !== []): ?>
    <table>
        <thead>
            <tr>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>E-Mail-Adresse</th>
                <th>Telefonnummer</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= htmlspecialchars($customer['firstname']) ?></td>
                    <td><?= htmlspecialchars($customer['lastname']) ?></td>
                    <td><?= htmlspecialchars($customer['email']) ?></td>
                    <td><?= htmlspecialchars($customer['phone']) ?></td>
                    <td>
                        <a href="?site=newloan&amp;id=<?= (int) $customer['id'] ?>">Werkzeug ausleihen</a>
                        <a href="?site=editcustomer&amp;id=<?= (int) $customer['id'] ?>">Bearbeiten</a>
                        <form action="?site=customers" method="post" onsubmit="return confirm('Diesen Kunden löschen?');">
                            <input type="hidden" name="id" value="<?= (int) $customer['id'] ?>">
                            <input type="hidden" name="token" value="<?= htmlspecialchars($customerToken) ?>">
                            <button type="submit" name="delete">Löschen</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (!isset($errormsg)): ?>
    <p>Es sind keine Kunden vorhanden.</p>
<?php endif; ?>
