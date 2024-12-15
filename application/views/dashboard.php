<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taters Enterprises, Inc.</title>
    <!-- Bootstrap 4 CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom styles to center the date pickers and button */
        .centered {
            height: 100vh; /* Full viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .custom-card {
            background-color: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom {
            background-color: #a21013;
        }

        /* Modify brand and text color */
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            color: #fff;
        }

        /* Custom button style */
        .btn-custom {
            background-color: #dc3545;
            color: white;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #910e11;
        }

        /* Typography adjustments */
        h2 {
            font-size: 2rem;
            color: #333;
        }

        label {
            font-weight: 600;
        }

        /* Logout Icon */
        .logout-icon {
            color: #fff;
            font-size: 1.5rem;
        }

        .logout-text {
            color: #fff;
            font-size: 1rem;
            margin-left: 5px;
        }

        .logout-link {
            display: flex;
            align-items: center;
            text-decoration: none; /* Remove the default underline */
            color: inherit; /* Inherit the text color */
        }

        .logout-link:hover {
            text-decoration: none; /* Ensure no underline on hover */
            color: inherit; /* Prevent blue color on hover */
        }

        .logout-link:hover .logout-text,
        .logout-link:hover .logout-icon {
            color: #f0f0f0; /* Lighter color on hover */
        }

        .list-group-item a {
            color: black;
            text-decoration: none;
        }

        .collapse p {
            text-align: left;
            margin: 0;
        }
    </style>
</head>
<body style="background-color: #f7f9fc">
    <div class="fixed-top">
        <nav class="navbar navbar-expand-sm navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="<?php echo base_url(); ?>assets/images/logos/taters-logo.png" alt="Avatar" style="height: 40px;">
                </a>
                <div class="ml-auto">
                    <a class="logout-link" href="<?php echo base_url('logout'); ?>" title="Logout">
                        <i class="fas fa-sign-out-alt logout-icon"></i>
                        <span class="logout-text">Logout</span>
                    </a>
                </div>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="centered">
            <div class="custom-card">
                <div class="text-center mb-4">
                    <h2>Sales Variance Reports</h2>
                    <ul class="list-group mt-4">
                    <?php
                    $counter = 0;
                    foreach ($svr_files as $svr_file) {
                        ?>
                        <li class="list-group-item">
                            <a href="#svrContent<?php echo $counter; ?>" class="d-flex justify-content-between align-items-center" data-toggle="collapse">
                                <span><i class="fas fa-file-excel mr-2"></i>SVR File</span>
                                <span class="badge badge-info badge-pill">View File</span>
                            </a>
                            <div id="svrContent<?php echo $counter; ?>" class="collapse mt-4">
                                <p><span class="font-weight-bold">Name of store:</span> <?php echo $svr_file->store_name; ?></p>
                                <p><span class="font-weight-bold">From:</span> <?php echo date("F j, Y", strtotime($svr_file->from_date)); ?></p>
                                <p><span class="font-weight-bold">To:</span> <?php echo date("F j, Y", strtotime($svr_file->to_date)); ?></p>
                                <a href="<?php echo $svr_file->folder_path . $svr_file->name_of_file; ?>">
                                    <span class="badge badge-danger badge-pill mt-4">Download SVR</span>
                                </a>
                            </div>
                        </li>
                        <?php
                        $counter += 1;
                    }
                    ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 4 JS, Popper.js, and jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
