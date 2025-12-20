
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Dashboard | CrickTeam' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</head>
<body>

<div class="navbar">
    <div class="logo">SmartBill</div>

    <!-- Hamburger -->
    <div class="hamburger" onclick="toggleMenu()">☰</div>

    <!-- Menu -->
    <div class="menu" id="menu">
        <a href="{{ route('dashboard.home') }}" class="menu-link">Home</a>
        <a class="nav-link">
        👤 Profile
        </a>
        @if(auth()->user()->is_admin)
                <a class="nav-link" href="{{ route('admin.settings') }}">
                    ⚙️ Settings
                </a>
            
        @endif
        <a href="{{ route('logout') }}" class="menu-link">Logout</a>
    </div>
</div>


<div class="content">
<script>

function toggleMenu() {
    document.getElementById('menu').classList.toggle('show');
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.menu-link').forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('menu').classList.remove('show');
        });
    });
});

function goBack() {
    if (document.referrer !== "") {
        window.history.back();
    } else {
        window.location.href = "{{ route('dashboard.home') }}";
    }
}


</script>


