<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Museum Wasaka - Waja Sampai Kaputing</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            /* Menggunakan warna background krem hangat khas museum mewah */
            background-color: #FDFBF9; 
            background-image: radial-gradient(#F3EDE4 1px, transparent 1px);
            background-size: 24px 24px;
            color: #333333;
        }

        /* Menyelaraskan kelas card-museum agar sama dengan komponen dashboard */
        .card-museum {
            background: #ffffff;
            border: 0;
            border-radius: 16px;
            /* Aksen garis atas menggunakan warna Maroon Utama Dashboard kamu */
            border-top: 5px solid #7A1C1C; 
            box-shadow: 0 10px 30px rgba(122, 28, 28, 0.06) !important;
        }

        /* Tombol Khusus Tema Museum */
        .btn-museum {
            background-color: #7A1C1C;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-museum:hover {
            background-color: #5A1414;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(122, 28, 28, 0.3);
        }

        .btn-museum:disabled {
            background-color: #A67B5B;
            opacity: 0.7;
        }

        /* custom form style agar lebih estetik */
        .form-control:focus, .form-select:focus {
            border-color: #A67B5B;
            box-shadow: 0 0 0 0.25rem rgba(166, 123, 91, 0.25);
        }
        
        .text-museum-gold {
            color: #A67B5B;
        }
        
        .text-museum-red {
            color: #7A1C1C;
        }
    </style>
</head>
<body>

    <div class="position-absolute top-0 start-0 m-4 z-3">
        <a href="/" class="btn btn-outline-dark rounded-pill fw-bold shadow-sm" style="letter-spacing: 1px;">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="container">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>