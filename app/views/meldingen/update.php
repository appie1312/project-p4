
<?php if (!$data['melding']): ?>
    <div class="alert alert-danger">Melding niet gevonden.</div>
    <?php exit; ?>
<?php endif; ?>

<?php require_once APPROOT . '/views/includes/navbar.php'; ?>
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
  <title>Melding bewerken</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
  
<div class="container py-5">
  <h1 class="mb-4">Melding bewerken</h1>
  <form method="post" action="<?= URLROOT ?>/meldingen/update">
    <input type="hidden" name="id" value="<?= htmlspecialchars($data['melding']->Id) ?>">
    <div class="mb-3">
      <label for="nummer" class="form-label">Nummer</label>
      <input type="text" class="form-control" id="nummer" name="nummer" value="<?= htmlspecialchars($data['melding']->Nummer) ?>" required>
    </div>
    <div class="mb-3">
      <label for="type" class="form-label">Type</label>
      <input type="text" class="form-control" id="type" name="type" value="<?= htmlspecialchars($data['melding']->Type) ?>" required>
    </div>
    <div class="mb-3">
      <label for="bericht" class="form-label">Bericht</label>
      <textarea class="form-control" id="bericht" name="bericht" rows="3" required><?= htmlspecialchars($data['melding']->Bericht) ?></textarea>
    </div>
    <div class="mb-3">
      <label for="opmerking" class="form-label">Opmerking</label>
      <input type="text" class="form-control" id="opmerking" name="opmerking" value="<?= htmlspecialchars($data['melding']->Opmerking ?? '') ?>">
    </div>
    <div class="mb-3">
      <label for="isactief" class="form-label">Actief?</label>
      <select class="form-select" id="isactief" name="isactief">
        <option value="1" <?= ($data['melding']->Isactief ?? 1) == 1 ? 'selected' : '' ?>>Ja</option>
        <option value="0" <?= ($data['melding']->Isactief ?? 1) == 0 ? 'selected' : '' ?>>Nee</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Opslaan</button>
    <a href="<?= URLROOT ?>/meldingen/index" class="btn btn-secondary">Annuleren</a>
  </form>
</div>
</body>
</html>