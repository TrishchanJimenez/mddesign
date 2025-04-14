<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : "Metro District Designs"; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
    .navbar {
        background-color: #1E1E1E;
        padding: 10px 0;
    }

    .navbar-brand {
        display: flex;
        align-items: center;
        color: white !important;
        font-weight: bold;
    }

    .navbar-brand img {
        height: 30px;
        margin-right: 10px;
    }

    .navbar-nav {
        flex-grow: 1;
        justify-content: center;
    }

    .navbar-nav .nav-link {
        color: white !important;
        text-transform: uppercase;
        font-family: Helvetica, sans-serif;
        font-weight: bold;
        margin: 0 10px;
    }

    .navbar-nav.ms-auto {
        margin-right: 0 !important;
        align-items: center;
    }

    .nav-icons {
        display: flex;
        align-items: center;
        color: white;
    }

    .nav-icons i {
        cursor: pointer;
        margin-left: 15px;
    }

    .search-container {
        position: relative;
        margin-left: 15px;
    }

    .search-icon, .cart-icon {
        transition: color 0.3s ease;
    }

    .search-icon:hover, .cart-icon:hover {
        color: #aaa;
    }

    .search-popup {
        display: none;
        position: absolute;
        top: 100%;
        right: 0;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 10px;
        width: 300px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        z-index: 1000;
        margin-top: 10px;
    }

    .search-popup.show {
        display: block;
    }

    .search-popup input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    </style>

</head>