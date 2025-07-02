<?php require_once APPROOT . '/views/includes/navbar.php'; ?>

<div class="container mt-3">

    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-warning">        
            <h3><?= htmlspecialchars($data['title']); ?></h3>
        </div>
        <div class="col-3"></div>
    </div>

    <?php if (!empty($data['error'])): ?>
    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-danger">        
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($data['error']); ?>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
    <?php endif; ?>

    <!-- begin formulier -->
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">

            <form action="<?= URLROOT; ?>/ticket/update" method="post">
                <div class="mb-3">
                    <label for="Nummer" class="form-label">Ticket Nr.</label>
                    <input name="Nummer" type="number" class="form-control" id="Nummer" required value="<?= htmlspecialchars($data['ticket']->Nummer); ?>">
                </div>
                <div class="mb-3">
                    <label for="Barcode" class="form-label">Barcode</label>
                    <input name="Barcode" type="text" class="form-control" id="Barcode" required value="<?= htmlspecialchars($data['ticket']->Barcode); ?>">
                </div>
                <div class="mb-3">
                    <label for="VoorstellingId" class="form-label">Voorstelling ID</label>
                    <input name="VoorstellingId" type="number" class="form-control" id="VoorstellingId" required value="<?= htmlspecialchars($data['ticket']->VoorstellingId); ?>">
                </div>
                <div class="mb-3">
                    <label for="Datum" class="form-label">Datum</label>
                    <input name="Datum" type="date" class="form-control" id="Datum" required value="<?= htmlspecialchars($data['ticket']->Datum); ?>">
                </div>
                <div class="mb-3">
                    <label for="Tijd" class="form-label">Tijd</label>
                    <input name="Tijd" type="time" class="form-control" id="Tijd" required value="<?= htmlspecialchars($data['ticket']->Tijd); ?>">
                </div>
                <div class="mb-3">
                    <label for="Status" class="form-label">Status</label>
                    <select name="Status" id="Status" class="form-control">
                        <option value="Vrij" <?= ($data['ticket']->Status == 'Vrij' ? 'selected' : '') ?>>Vrij</option>
                        <option value="Bezet" <?= ($data['ticket']->Status == 'Bezet' ? 'selected' : '') ?>>Bezet</option>
                        <option value="Gereserveerd" <?= ($data['ticket']->Status == 'Gereserveerd' ? 'selected' : '') ?>>Gereserveerd</option>
                        <option value="Geannuleerd" <?= ($data['ticket']->Status == 'Geannuleerd' ? 'selected' : '') ?>>Geannuleerd</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="BezoekerId" class="form-label">Bezoeker ID</label>
                    <input name="BezoekerId" type="number" class="form-control" id="BezoekerId" value="<?= htmlspecialchars($data['ticket']->BezoekerId); ?>">
                </div>
                <div class="mb-3">
                    <label for="PrijsId" class="form-label">Prijs ID</label>
                    <input name="PrijsId" type="number" class="form-control" id="PrijsId" required value="<?= htmlspecialchars($data['ticket']->PrijsId); ?>">
                </div>
                <div class="mb-3">
                    <label for="Opmerking" class="form-label">Opmerking</label>
                    <input name="Opmerking" type="text" class="form-control" id="Opmerking" value="<?= htmlspecialchars($data['ticket']->Opmerking ?? '') ?>">
                </div>
                <input type="hidden" name="Id" value="<?= htmlspecialchars($data['ticket']->Id); ?>">
                <div class="d-grid gap-2">
                    <button class="btn btn-danger" type="submit">Wijzigen</button>
                </div>
            </form>
            <a href="<?= URLROOT; ?>/ticket/index"><i class="bi bi-arrow-left"></i></a>
        </div>
        <div class="col-3"></div>
    </div>
    <!-- eind formulier -->

</div>