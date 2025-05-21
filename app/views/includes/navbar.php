<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
<link rel="stylesheet" href="navbar.css">
</head>
<body>
<div class=" container-fluid mt-2 navbar navbar-expand-lg bg-white rounded-4 shadow px-4 py-3 position-fixed"> <!-- Extra marge bovenaan -->


            <img src="/public/images/logo.png" alt="Icon" class="me-2 mt-2" width="auto" height="40">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/index">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/lessen/Lessen.php">Lessen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="/meldingen">meldingen</a>
                </li>
            </ul>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item d-flex align-items-center">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="/public/images/pngegg.png" alt="Icon" class="me-2" width="30" height="30">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/navbar/logout.php">Log uit</a>
                    </li>
                <?php else: ?>
                            <li><a class="dropdown-item" href="/login/login.php">Inloggen</a></li>
                            <li><a class="dropdown-item" href="/signup/signup.php">Registreren</a></li>
                        
                <?php endif; ?>
                </ul>
                  </li>
            </ul>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    
</body>
</html>