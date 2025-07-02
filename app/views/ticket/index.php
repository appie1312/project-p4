<?php require_once APPROOT . '/views/includes/navbar.php'; ?>
<?php
// Geen initialisatie van $tickets, $voorstellingen, $filters, $currentUser, $currentDateTime!
// Alles komt uit de controller via extract($viewData);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets Overzicht - AURORA Theater</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/ticket.css">
</head>
<body>
    <?php $filters = $filters ?? ['status' => '', 'voorstelling' => '', 'datum' => '']; ?>
    <div class="container">
        <div class="page-header">
            <h1>Tickets Overzicht</h1>
        </div>

        <div class="filters">
            <form action="" method="GET">
                <input type="hidden" name="controller" value="ticket">
                <input type="hidden" name="action" value="index">
                
                
                <select name="status" id="status">
                    <option value="">Alle Statussen</option>
                    <option value="Vrij" <?php echo ($filters['status'] === 'Vrij') ? 'selected' : ''; ?>>Vrij</option>
                    <option value="Bezet" <?php echo ($filters['status'] === 'Bezet') ? 'selected' : ''; ?>>Bezet</option>
                    <option value="Gereserveerd" <?php echo ($filters['status'] === 'Gereserveerd') ? 'selected' : ''; ?>>Gereserveerd</option>
                    <option value="Geannuleerd" <?php echo ($filters['status'] === 'Geannuleerd') ? 'selected' : ''; ?>>Geannuleerd</option>
                </select>

                <select name="voorstelling" id="voorstelling">
                    <option value="">Alle Voorstellingen</option>
                    <?php if (isset($voorstellingen) && is_array($voorstellingen)): ?>
                        <?php foreach ($voorstellingen as $voorstelling): ?>
                            <option value="<?php echo htmlspecialchars($voorstelling['Id']); ?>"
                                    <?php echo ($filters['voorstelling'] == $voorstelling['Id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($voorstelling['Naam']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <input type="date" name="datum" id="datum" 
                       value="<?php echo htmlspecialchars($filters['datum'] ?? ''); ?>">
                
                 <div class="mb-3">
                    <a href="<?php echo URLROOT; ?>/ticket/create" class="btn-toevoegen">Nieuwe Ticket Toevoegen</a>
                </div>

            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Ticket Nr.</th>
                    <th>Barcode</th>
                    <th>Voorstelling</th>
                    <th>Datum</th>
                    <th>Tijd</th>
                    <th>Status</th>
                    <th>Bezoeker</th>
                    <th>Prijs</th>
                    <th>Acties</th>
                </tr>
            </thead>
           <tbody>
    <?php if (isset($tickets) && is_array($tickets) && !empty($tickets)): ?>
        <?php foreach ($tickets as $ticket): ?>
            <tr>
                <td><?= htmlspecialchars($ticket['Nummer'] ?? '') ?></td>
                <td><?= htmlspecialchars($ticket['Barcode'] ?? '') ?></td>
                <td><?= htmlspecialchars($ticket['VoorstellingNaam'] ?? '') ?></td>
                <td><?= htmlspecialchars($ticket['Datum'] ?? '') ?></td>
                <td><?= htmlspecialchars($ticket['Tijd'] ?? '') ?></td>
                <td><?= htmlspecialchars($ticket['Status'] ?? '') ?></td>
                <td><?= htmlspecialchars($ticket['BezoekerNaam'] ?? 'Onbekend') ?></td>
                <td>€ <?= htmlspecialchars(number_format($ticket['Tarief'] ?? 0, 2, ',', '.')) ?></td>
                <td>
                    <a href="<?php echo URLROOT; ?>/ticket/edit/<?php echo htmlspecialchars($ticket['Id'] ?? ''); ?>" class="btn-bewerken">Bewerken</a>
                    <a href="<?= URLROOT; ?>/ticket/annuleer/<?= htmlspecialchars($ticket['Id']); ?>" class="btn btn-warning" onclick="return confirm('Weet je zeker dat je dit ticket wilt annuleren?');">Annuleren</a>
                    <a href="<?php echo URLROOT; ?>/ticket/delete/<?php echo htmlspecialchars($ticket['Id'] ?? ''); ?>" class="btn-verwijderen">Verwijderen</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="9" class="text-center">Geen tickets gevonden</td>
        </tr>
    <?php endif; ?>
</tbody>
        </table>
    </div>
</body>
</html>