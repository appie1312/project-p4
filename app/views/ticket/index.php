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
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .user-info { font-size: 0.9em; color: #666; }
        .filters { margin-bottom: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 4px; }
        .filters select, .filters input { padding: 6px; margin-right: 10px; border: 1px solid #ddd; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f5f5f5; }
        .btn { display: inline-block; padding: 6px 12px; text-decoration: none; border-radius: 4px; color: white; }
        .btn-primary { background-color: #007bff; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Tickets Overzicht</h1>
            <div class="user-info">
                <p>Ingelogd als: <?php echo htmlspecialchars($currentUser ?? ''); ?></p>
                <p>Datum: <?php echo htmlspecialchars($currentDateTime ?? ''); ?></p>
            </div>
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
                
                <button type="submit" class="btn btn-primary">Filter</button>
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
                            <td><?php echo htmlspecialchars($ticket['Nummer'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($ticket['Barcode'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($ticket['VoorstellingNaam'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($ticket['Datum'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($ticket['Tijd'] ?? ''); ?></td>
                            <td>
                                <span class="status-badge status-<?php echo strtolower($ticket['Status'] ?? 'onbekend'); ?>">
                                    <?php echo htmlspecialchars($ticket['Status'] ?? ''); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($ticket['BezoekerNaam'] ?? ''); ?></td>
                            <td>€ <?php echo htmlspecialchars(number_format($ticket['Tarief'] ?? 0, 2, ',', '.')); ?></td>
                            <td>
                                <a href="index.php?controller=ticket&action=view&id=<?php echo htmlspecialchars($ticket['Id'] ?? ''); ?>" 
                                   class="btn btn-primary">Details</a>
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