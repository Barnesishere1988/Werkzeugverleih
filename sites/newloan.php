<h1>Werkzeug ausleihen</h1>
<a href="?site=customers">Zurück zu den Kunden</a>

<?php if (isset($errormsg)): ?>
    <p><?= htmlspecialchars($errormsg) ?></p>
<?php endif; ?>

<?php if ($customer): ?>
    <p>Kunde: <?= htmlspecialchars($customer['firstname'] . ' ' . $customer['lastname']) ?></p>

    <?php if ($tools !== []): ?>
        <form action="?site=newloan&amp;id=<?= $customerId ?>" method="post">
            <input type="hidden" name="token" value="<?= htmlspecialchars($loanToken) ?>">

            <label for="tool_id">Werkzeug</label>
            <select id="tool_id" name="tool_id" required>
                <option value="">Bitte auswählen</option>
                <?php foreach ($tools as $tool): ?>
                    <option value="<?= (int) $tool['id'] ?>" <?= (int) $tool['id'] === $toolId ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tool['inventoryid'] . ' – ' . $tool['name']) ?>
                        (<?= number_format((float) $tool['price'], 2, ',', '.') ?> € pro Tag)
                    </option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="start_date">Ausleihdatum</label>
            <input type="date" id="start_date" name="start_date" max="<?= $today->format('Y-m-d') ?>" value="<?= htmlspecialchars($startDate) ?>" required><br><br>

            <label for="planned_return_date">Geplantes Rückgabedatum</label>
            <input type="date" id="planned_return_date" name="planned_return_date" value="<?= htmlspecialchars($plannedReturnDate) ?>" required><br><br>

            <button type="submit" name="add">Ausleihe speichern</button>
        </form>
    <?php elseif (!isset($errormsg)): ?>
        <p>Es sind keine Werkzeuge verfügbar.</p>
    <?php endif; ?>
<?php endif; ?>
