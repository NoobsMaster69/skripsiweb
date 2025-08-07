<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Luaran | {{ $title }}</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="{{ asset('sb-admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">

    <style>
        /* Heading section di sidebar */
.sidebar .sidebar-heading {
    font-size: 0.75rem;
    color: #ced4da;
    padding: 0.75rem 1.25rem 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.05rem;
}

/* Jarak antar item menu */
.sidebar .nav-item {
    margin-bottom: 0.35rem;
}

/* Hover dan active menu */
.sidebar .nav-link {
    padding: 0.5rem 1rem;
    font-size: 0.88rem;
    color: #fff;
    transition: all 0.2s ease-in-out;
}

.sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-left: 4px solid #fff;
}

.sidebar .nav-link.active {
    background-color: #4e73df;
    color: #fff;
    font-weight: 600;
}

/* Inner submenu */
.collapse-inner {
    padding: 0.5rem 1rem;
}

.collapse-inner .collapse-item {
    padding: 0.4rem 1rem;
    font-size: 0.85rem;
    border-radius: 0.35rem;
}

.collapse-inner .collapse-item:hover {
    background-color: #f8f9fc;
    color: #3c4b64;
}

/* Padding bawah agar tidak mepet scroll */
.sidebar {
    padding-bottom: 2rem;
}

    </style>
</head>
