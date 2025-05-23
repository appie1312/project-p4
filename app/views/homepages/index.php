<?php require_once APPROOT . '/views/includes/navbar.php'; ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Aurora Theater</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style.css">  
  </head>
  <body>

  <div class="hero">
  <img src="/public/images/1379469-3840x2160-desktop-4k-movie-theater-background-image.jpg" alt="" class="banner-foto">

  <div class="intro-tekst text-center">
    <h1>AURORA</h1>
    <p>Laat je verrassen. Elke avond opnieuw.</p>
  </div>
</div>

<section>
  <div class="container my-5 py-5 ">
    <h2>Beschrijving</h2>
    <p>Welkom bij Aurora, het theater waar verhalen tot leven komen en elke avond begint met een sprankje magie. Of je
      nu houdt van meeslepende toneelstukken, indrukwekkende dansvoorstellingen of verrassende cabaretshows – Aurora
      biedt een podium voor zowel opkomend talent als gevestigde namen. Met een stijlvol interieur, warme sfeer en een
      intuïtieve online ticketservice zorgen wij ervoor dat jouw theaterbezoek soepel en onvergetelijk verloopt.</p>
  </div>
</section>

<div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active hoogte-carousel">
      <img src="/public/images/carousel 1.webp" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item hoogte-carousel">
      <img src="/public/images/carousel2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item hoogte-carousel">
      <img src="/public/images/carousel3.webp" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
<?php require_once APPROOT . '/views/includes/footer.php'; ?>
