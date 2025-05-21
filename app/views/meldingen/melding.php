<?php require_once APPROOT . '/views/includes/navbar.php'; ?>

<?php
$pdo = new PDO("mysql:host=localhost;dbname=aurora", "root", "");
$stmt = $pdo->query("SELECT Id, Nummer, Type, Bericht, Datumaangemaakt FROM Melding WHERE Isactief = 1 ORDER BY Datumaangemaakt DESC");
$meldingen = $stmt->fetchAll();
?>


<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Meldingen</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">

  <div class="container py-5">
    <h1 class="mb-4">Meldingen</h1>

    <?php if (empty($meldingen)) : ?>
      <div class="alert alert-info">Er zijn nog geen meldingen</div>
    <?php else : ?>
      <table class="table table-bordered table-striped ">
        <thead class="table">
          <tr>
            <th>#</th>
            <th>Nummer</th>
            <th>Type</th>
            <th>Bericht</th>
            <th>Datum</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($meldingen as $melding) : ?>
            <tr>
              <td><?= $melding['Id'] ?></td>
              <td><?= $melding['Nummer'] ?></td>
              <td><?= $melding['Type'] ?></td>
              <td><?= $melding['Bericht'] ?></td>
              <td><?= $melding['Datumaangemaakt'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

</body>
</html>
