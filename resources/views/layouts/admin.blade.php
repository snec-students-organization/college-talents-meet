<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fest Admin</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="bg-dark text-white p-3" style="width: 250px; height:100vh;">
        <h3 class="mb-4">Fest Admin</h3>

        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a href="/" class="nav-link text-white">Dashboard</a>
            </li>
            <li class="nav-item mb-2">
                <a href="/events" class="nav-link text-white">Events</a>
            </li>
            <li class="nav-item mb-2">
                <a href="/participants" class="nav-link text-white">Participants</a>
            </li>
            <li class="nav-item mb-2">
                <a href="/scores" class="nav-link text-white">Mark Entry</a>
            </li>
            <li class="nav-item mb-2">
                <a href="/results" class="nav-link text-white">Event Results</a>
            </li>
            <li class="nav-item mb-2">
                <a href="/matrix-results" class="nav-link text-white"> Results In Table</a>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="flex-grow-1 p-4">
        @yield('content')
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
