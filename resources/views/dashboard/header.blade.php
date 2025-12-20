<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

</head>
<body>

<!-- TOP MENU BAR -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm px-4 py-2">
    <a class="navbar-brand fw-bold text-primary" href="#">
        SmartBill
    </a>

    <div class="ms-auto d-flex align-items-center gap-3">
        <a href="/dashboard" class="text-decoration-none text-dark fw-medium">Home</a>
        <a href="/profile" class="text-decoration-none text-dark fw-medium">Profile</a>
        @if(auth()->user()->is_admin)
            <a href="{{ route('admin.settings') }}" class="nav-link">
                ⚙️ Settings
            </a>
        @endif

        <a href="/logout" class="btn btn-outline-danger btn-sm">Logout</a>
    </div>
</nav>
