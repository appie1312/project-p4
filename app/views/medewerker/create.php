<?php require_once APPROOT . '/views/includes/navbar.php'; ?>
<link rel="stylesheet" href="<?= URLROOT; ?>/css/cud.css">


<div class="container mt-3">
    
    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-danger">        
            <h3><?= $data['title']; ?></h3>
        </div>
        <div class="col-3"></div>
    </div>

    <div class="row mb-3" style="display:<?= $data['message']; ?>">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-danger">        
            <div class="alert alert-success" role="alert">
                medewerker succesvol is toegevoegd.
            </div>
        </div>
        <div class="col-3"></div>
    </div>
    
    <!-- begin tabel -->
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form action="<?= URLROOT; ?>/medewerker/create" method="post">
                <div class="mb-3">
                    <label for="gebruikerid" class="form-label">Gebruiker ID</label>
                    <input name="gebruikerid" type="number" class="form-control" id="gebruikerid" required>
                </div>
                <div class="mb-3">
                    <label for="nummer" class="form-label">Nummer</label>
                    <input name="nummer" type="number" class="form-control" id="nummer" required>
                </div>
                <div class="mb-3">
                    <label for="medewerkersoort" class="form-label">Medewerkersoort</label>
                    <input name="medewerkersoort" type="text" class="form-control" id="medewerkersoort" required>
                </div>
                <div class="mb-3">
                    <label for="isactief" class="form-label">Is actief</label>
                    <select name="isactief" id="isactief" class="form-control">
                        <option value="1">Ja</option>
                        <option value="0">Nee</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="opmerking" class="form-label">Opmerking</label>
                    <input name="opmerking" type="text" class="form-control" id="opmerking">
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-primary" type="submit">Verstuur</button>
                </div>
            </form>
            
            <a href="<?= URLROOT; ?>/homepages/index"><i class="bi bi-arrow-left"></i></a>
        </div>
        <div class="col-3"></div>
    </div>
    <!-- eind tabel -->

</div>