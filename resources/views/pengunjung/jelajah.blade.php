<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajah Virtual | Museum Wasaka</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        body, html { height: 100%; margin: 0; overflow: hidden; background-color: #1a1a1a; }
        .navbar-custom { background-color: #1a1a1a; z-index: 10; position: relative; }
        .tour-container { height: calc(100vh - 65px); width: 100%; } 
        iframe { border: none; width: 100%; height: 100%; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" style="letter-spacing: 3px;" href="/">MUSEUM WASAKA</a>
            <div class="d-flex">
                <a href="/" class="btn btn-outline-light btn-sm rounded-pill px-3 me-2">Kembali ke Beranda</a>
            </div>
        </div>
    </nav>

    <div class="tour-container">
        <iframe src="{{ asset('virtual-tour/index.html') }}" allowfullscreen></iframe>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('musik')
</body>
</html>