
<?php require_once APPROOT . '/views/includes/navbar.php';
?>
<?php
if(session_status() == PHP_SESSION_NONE){
  session_start();
}
?>

<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $data['title']; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success'] ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error'] ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="container py-5">
  <h1 class="mb-4"><?= $data['title']; ?></h1>

  <?php if (empty($data['meldingen'])) : ?>
    <div class="alert alert-info">Er zijn nog geen meldingen</div>
  <?php else : ?>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Nummer</th>
          <th>Type</th>
          <th>Bericht</th>
          <th>Datum</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data['meldingen'] as $melding) : ?>
          <tr>
            <td><?= htmlspecialchars($melding->Id) ?></td>
            <td><?= htmlspecialchars($melding->Nummer) ?></td>
            <td><?= htmlspecialchars($melding->Type) ?></td>
            <td><?= htmlspecialchars($melding->Bericht) ?></td>
            <td><?= htmlspecialchars($melding->Datumaangemaakt) ?></td>
            <td>
            <a href="<?= URLROOT; ?>/meldingen/edit/<?= $melding->Id; ?>">
    <i class="bi bi-pencil-square text-success">pls werk</i>
</a>         
            <td>
              <form method="get" action="index.php" style="display:inline;" onsubmit="return confirm('Weet je zeker dat je deze melding wilt verwijderen?');">
                  <input type="hidden" name="url" value="meldingen/delete/<?= $melding->Id ?>">
                  <button type="submit" class="btn btn-danger btn-sm">Verwijder</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

</body>
</html>
