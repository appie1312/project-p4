<?php
// Initialiseer variabelen om "undefined" notices te voorkomen
$medewerkers = $medewerkers ?? [];
$error = $error ?? null;
$success = $success ?? null;
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medewerkers Overzicht - AURORA Theater</title>
    <style>
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
            background-color: #007bff;
            color: white;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .user-info {
            font-size: 0.9em;
            color: #666;
        }
    </style>
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
                    <th>Nummer</th>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Mobiel</th>
                    <th>Rol</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php if (is_array($medewerkers) && !empty($medewerkers)): ?>
                    <?php foreach ($medewerkers as $medewerker): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($medewerker['Nummer'] ?? ''); ?></td>
                            <td>
                                <?php
                                $naam = htmlspecialchars($medewerker['Voornaam'] ?? '');
                                if (!empty($medewerker['Tussenvoegsel'])) {
                                    $naam .= ' ' . htmlspecialchars($medewerker['Tussenvoegsel']);
                                }
                                $naam .= ' ' . htmlspecialchars($medewerker['Achternaam'] ?? '');
                                echo $naam;
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($medewerker['Email'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($medewerker['Mobiel'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($medewerker['RolNaam'] ?? ''); ?></td>
                            <td>
                                <a href="index.php?controller=medewerker&action=view&id=<?php echo htmlspecialchars($medewerker['Id'] ?? ''); ?>" 
                                   class="btn">Details</a>
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