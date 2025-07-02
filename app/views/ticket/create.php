<?php require_once APPROOT . '/views/includes/navbar.php'; ?>
<link rel="stylesheet" href="<?= URLROOT; ?>/css/cud.css">

<div class="container mt-3">
    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-danger">        
            <h3><?= $title; ?></h3>
        </div>
        <div class="col-3"></div>
    </div>

    <?php if (!empty($message)): ?>
    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-danger">        
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($message); ?>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
    <?php endif; ?>
    
    <!-- begin tabel -->
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form action="<?= URLROOT; ?>/ticket/create" method="post">
                <div class="mb-3">
                    <label for="Nummer" class="form-label">Ticket Nr.</label>
                    <input name="Nummer" type="number" class="form-control" id="Nummer" required>
                </div>
                <div class="mb-3">
                    <label for="Barcode" class="form-label">Barcode</label>
                    <input name="Barcode" type="text" class="form-control" id="Barcode" required>
                </div>
                <div class="mb-3">
                    <label for="VoorstellingId" class="form-label">Voorstelling ID</label>
                    <input name="VoorstellingId" type="number" class="form-control" id="VoorstellingId" required>
                </div>
                <div class="mb-3">
                    <label for="Datum" class="form-label">Datum</label>
                    <input name="Datum" type="date" class="form-control" id="Datum" required>
                </div>
                <div class="mb-3">
                    <label for="Tijd" class="form-label">Tijd</label>
                    <input name="Tijd" type="time" class="form-control" id="Tijd" required>
                </div>
                <div class="mb-3">
                    <label for="Status" class="form-label">Status</label>
                    <select name="Status" id="Status" class="form-control">
                        <option value="Vrij">Vrij</option>
                         <option value="Bezet">Bezet</option>
                        <option value="Gereserveerd">Gereserveerd</option>
                        <option value="Geannuleerd">Geannuleerd</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="BezoekerId" class="form-label">Bezoeker ID</label>
                    <input name="BezoekerId" type="number" class="form-control" id="BezoekerId">
                </div>
                <div class="mb-3">
                    <label for="PrijsId" class="form-label">Prijs ID</label>
                    <input name="PrijsId" type="number" class="form-control" id="PrijsId" required>
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
