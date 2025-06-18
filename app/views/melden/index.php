<?php require APPROOT . '/views/includes/navbar.php'; ?>

<div class="container mt-3">
    
    <div class="row mb-3">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-warning">        
            <h3><?= $data['title']; ?></h3>
        </div>
        <div class="col-3"></div>
    </div>

    <?php if (!empty($data['error'])): ?>
        <div class="row mb-3">
            <div class="col-3"></div>
            <div class="col-6 text-begin">
                <div class="alert alert-danger" role="alert">
                    <?= $data['error']; ?>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    <?php endif; ?>

    <div class="row mb-3" style="display:<?= $data['message']; ?>">
        <div class="col-3"></div>
        <div class="col-6 text-begin text-warning">        
            <div class="alert alert-success" role="alert">
                Record is toegevoegd
            </div>
        </div>
        <div class="col-3"></div>
    </div>
    
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form action="<?= URLROOT; ?>/melden/create" method="post">
                <div class="mb-3">
                    <label for="nummer" class="form-label">Klantennummer</label>
                    <input name="nummer" type="number" min="1" class="form-control" id="nummer" value="<?= htmlspecialchars($_POST['nummer'] ?? '', ENT_QUOTES); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type melding</label>
                    <input name="type" type="text" maxlength="20" class="form-control" id="type" value="<?= htmlspecialchars($_POST['type'] ?? '', ENT_QUOTES); ?>" required>
                    <!-- Of je kunt hier een select dropdown maken als je vaste types wilt -->
                </div>
                <div class="mb-3">
                    <label for="bericht" class="form-label">Bericht</label>
                    <input name="bericht" type="text" class="form-control" id="bericht" value="<?= htmlspecialchars($_POST['bericht'] ?? '', ENT_QUOTES); ?>" required>
                </div>                
                <button type="submit" class="btn btn-primary">Verstuur</button>
            </form>
            
            <a href="<?= URLROOT; ?>/homepages/index"><i class="bi bi-arrow-left"></i></a>
        </div>
        <div class="col-3"></div>
    </div>
</div>

<?php require APPROOT . '/views/includes/footer.php'; ?>
