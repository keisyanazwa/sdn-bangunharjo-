<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - SDN Bangunharjo</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/loading-screen.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/front_logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: #f5f6fa;
            min-height: 100vh;
        }

        .navbar {
            background: #fff !important;
            border-bottom: 1px solid #eaeaea;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: bold;
            color: #2a5298 !important;
            font-size: 1.2rem;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .dashboard-title {
            color: #2a5298;
            font-weight: bold;
            margin-top: 2rem;
            letter-spacing: 1px;
        }

        .dashboard-cards {
            display: flex;
            gap: 2rem;
            justify-content: center;
            margin-top: 2.5rem;
            flex-wrap: wrap;
        }

        .dashboard-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 16px rgba(44, 62, 80, 0.09);
            padding: 2rem 2.5rem;
            text-align: center;
            width: 260px;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid #eaeaea;
        }

        .dashboard-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.13);
        }

        .dashboard-card i {
            font-size: 2.5rem;
            color: #2a5298;
            margin-bottom: 1rem;
        }

        .dashboard-card h3 {
            margin-top: 1rem;
            font-weight: bold;
            color: #2a5298;
            font-size: 1.2rem;
        }

        .dashboard-card button {
            background: none;
            border: none;
            color: #2a5298;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
        }

        .dashboard-card button:hover {
            text-decoration: underline;
        }

        .dashboard-card p {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .modal-header {
            background: #2a5298;
            color: white;
        }

        .btn-primary {
            background: #2a5298;
            border-color: #2a5298;
        }

        .btn-primary:hover {
            background: #1e3c72;
            border-color: #1e3c72;
        }
        
        .logout-btn { 
            border-radius: 20px; 
            font-weight: bold; 
            color: #2a5298 !important; 
            border: 1px solid #2a5298 !important; 
            background: #fff !important; 
        }
        
        .logout-btn:hover { 
            background: #2a5298 !important; 
            color: #fff !important; 
        }

        .table-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        @media (max-width: 900px) { 
            .dashboard-cards { 
                flex-direction: column; 
                align-items: center; 
            } 
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner"></div>
            <div class="loading-text">Memuat...</div>
        </div>
    </div>
    
    @include('layouts.partials.admin.navbar')

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('js/gallery.js') }}"></script>
    <script>
        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Loading screen functions
        function showLoading(message = 'Memproses...') {
            console.log('Showing loading overlay with message:', message);
            $('#loadingOverlay .loading-text').text(message);
            $('#loadingOverlay').addClass('show');
            
            // Force browser to recognize the change
            setTimeout(function() {
                $('#loadingOverlay').css('opacity', '1');
            }, 10);
        }
        
        function hideLoading() {
            console.log('Hiding loading overlay');
            $('#loadingOverlay').removeClass('show');
            $('#loadingOverlay').css('opacity', '0');
        }
    </script>
    @yield('scripts')
</body>

</html>