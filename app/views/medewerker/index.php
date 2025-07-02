<?php require_once APPROOT . '/views/includes/navbar.php'; ?>
<?php
// Initialiseer variabelen om "undefined" notices te voorkomen
$medewerkers = $medewerkers ?? [];
$error = $error ?? null;
$success = $success ?? null;
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

if ($controller == 'medewerker') {
    $medewerkerController = new Medewerker();
    if ($action == 'create') {
        $medewerkerController->create();
        exit;
    }
    // ...andere actions...
}
?>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerkers Overzicht - AURORA Theater</title>
    <link rel ="stylesheet" href="/public/css/medewerker.css">
</head>
<body>
    <div class="container">
        <div class="page-header">
            <h1>Medewerkers Overzicht</h1>
            <div class="user-info">
                <p>Ingelogd als: <?php echo htmlspecialchars($currentUser ?? 'jahir2004'); ?></p>
                <p>Datum: <?php echo date('Y-m-d H:i:s'); ?></p>
            </div>
        </div>
        <div class="mb-3">
            <a href="medewerker/create" class="btn-toevoegen">Nieuwe Medewerker Toevoegen</a>
        </div>

        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success) && $success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

       <table>
    <thead>
        <tr>
            <th>Id</th>
            <th>GebruikerId</th>
            <th>Nummer</th>
            <th>Medewerkersoort</th>
            <th>Isactief</th>
            <th>Opmerking</th>
            <th>Datumaangemaakt</th>
            <th>Datumgewijzigd</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php if (is_array($medewerkers) && !empty($medewerkers)): ?>
            <?php foreach ($medewerkers as $medewerker): ?>
                <tr>
                    <td><?= htmlspecialchars($medewerker['Id'] ?? '') ?></td>
                    <td><?= htmlspecialchars($medewerker['GebruikerId'] ?? '') ?></td>
                    <td><?= htmlspecialchars($medewerker['Nummer'] ?? '') ?></td>
                    <td><?= htmlspecialchars($medewerker['Medewerkersoort'] ?? '') ?></td>
                    <td><?= htmlspecialchars($medewerker['Isactief'] ? 'Ja' : 'Nee') ?></td>
                    <td><?= htmlspecialchars($medewerker['Opmerking'] ?? '') ?></td>
                    <td><?= htmlspecialchars(isset($medewerker['Datumaangemaakt']) ? date('Y-m-d H:i:s', strtotime($medewerker['Datumaangemaakt'])) : '') ?></td>
                    <td><?= htmlspecialchars(isset($medewerker['Datumgewijzigd']) ? date('Y-m-d H:i:s', strtotime($medewerker['Datumgewijzigd'])) : '') ?></td>
                            <td>
                                <a href="<?= URLROOT; ?>/medewerker/edit/<?= htmlspecialchars($medewerker['Id']); ?>" class="btn-bewerken">Bewerken</a>
                                <a href="<?= URLROOT; ?>/medewerker/delete/<?= htmlspecialchars($medewerker['Id']); ?>" class="btn-verwijderen">Verwijderen</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">Geen medewerkers gevonden</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Voeg eventuele JavaScript functionaliteit toe
        console.log('Medewerkers pagina geladen');
    });
    </script>
</body>
</html>