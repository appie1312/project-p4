

<?php require APPROOT . '/views/includes/header.php'; ?>

<div class="container mt-3">
    
    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-warning">        
            <h3><?= $data['title']; ?></h3>
        </div>
        <div class="col-3"></div>
    </div>

    <div class="row mb-3" style="display:<?= $data['message']; ?>">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-warning">        
            <div class="alert alert-success" role="alert">
                melding is verzonden
            </div>
        </div>
        <div class="col-3"></div>
    </div>
    
    <!-- begin formulier -->
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form action="<?= URLROOT; ?>/meldingen/create" method="post">
                <div class="mb-3">
                    <label for="bezoekerId" class="form-label">Bezoeker ID</label>
                    <input name="bezoekerId" type="number" class="form-control" id="bezoekerId" value="<?= $_POST['bezoekerId'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="medewerkerId" class="form-label">Medewerker ID</label>
                    <input name="medewerkerId" type="number" class="form-control" id="medewerkerId" value="<?= $_POST['medewerkerId'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nummer" class="form-label">Nummer</label>
                    <input name="nummer" type="number" class="form-control" id="nummer" value="<?= $_POST['nummer'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type</label>
                    <input name="type" type="text" class="form-control" id="type" value="<?= $_POST['type'] ?? ''; ?>" required>
                </div>
                <div class="mb-3">
                    <label for="bericht" class="form-label">Bericht</label>
                    <textarea name="bericht" class="form-control" id="bericht" rows="3" required><?= $_POST['bericht'] ?? ''; ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Verstuur</button>
            </form>
        </div>
        <div class="col-3"></div>
    </div>
  
    <!-- eind formulier -->

<?php require APPROOT . '/views/includes/footer.php'; ?>
