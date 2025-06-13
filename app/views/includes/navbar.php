<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="navbar.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <img src="/public/images/logo.png" alt="Icon" class="me-2 mt-2" width="auto" height="40">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/index">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?url=ticket/index">ticket</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?url=medewerker/index">medewerker</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="index.php?url=ticketscan/scan">ticketscan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/meldingen">meldingen</a>
          </li>
          <ul class="navbar-nav ms-auto">
          <li class="nav-item dropdown dropdown-menu-end">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              account
            </a>
            <ul class="dropdown-menu">
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
  </nav>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous">
  </script>

</body>

</html>