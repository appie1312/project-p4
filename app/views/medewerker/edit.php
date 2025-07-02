<?php require_once APPROOT . '/views/includes/navbar.php'; ?>

<div class="container mt-3">

    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-warning">        
            <h3><?= htmlspecialchars($data['title']); ?></h3>
        </div>
        <div class="col-3"></div>
    </div>

    <div class="row mb-3" style="display:<?= $data['message']; ?>">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-warning">        
            <div class="alert alert-success" role="alert">
                Record is gewijzigd
            </div>
        </div>
        <div class="col-3"></div>
    </div>
    
    <!-- begin formulier -->
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">

            <form action="<?= URLROOT; ?>/medewerker/update" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">GebruikerId</label>
                    <input value="<?= htmlspecialchars($data['medewerker']->GebruikerId); ?>" name="GebruikerId" type="text" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="nummer" class="form-label">Nummer</label>
                    <input value="<?= htmlspecialchars($data['medewerker']->Nummer); ?>" name="nummer" type="number" min="0" max="10000" class="form-control" id="nummer" required>
                </div>
                <div class="mb-3">
                    <label for="medewerkersoort" class="form-label">Medewerkersoort</label>
                    <input value="<?= htmlspecialchars($data['medewerker']->Medewerkersoort); ?>" name="medewerkersoort" type="text" class="form-control" id="medewerkersoort" required>
                </div>
                <div class="mb-3">
                    <label for="isactief" class="form-label">Is actief</label>
                    <select name="isactief" id="isactief" class="form-control">
                        <option value="1" <?= ($data['medewerker']->Isactief == 1 ? 'selected' : '') ?>>Ja</option>
                        <option value="0" <?= ($data['medewerker']->Isactief == 0 ? 'selected' : '') ?>>Nee</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="opmerking" class="form-label">Opmerking</label>
                    <input name="opmerking" type="text" class="form-control" id="opmerking" value="<?= htmlspecialchars($data['medewerker']->Opmerking ?? '') ?>">
                </div>

                <input type="hidden" name="Id" value="<?= htmlspecialchars($data['medewerker']->Id); ?>">

                <div class="d-grid gap-2">
                    <button class="btn btn-danger" type="submit">wijzigen</button>
                </div>
            </form>
            
            <a href="<?= URLROOT; ?>/homepages/index"><i class="bi bi-arrow-left"></i></a>
        </div>
        <div class="col-3"></div>
    </div>
    <!-- eind formulier -->

</div>