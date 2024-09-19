<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taters Enterprises, Inc.</title>
    <!-- Bootstrap 4 CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles to center the date pickers and button */
        .centered {
            height: 100vh; /* Full viewport height */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .navbar-custom {
            background-color: #a21013;
        }

        /* Modify brand and text color */
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="fixed-top">
        <nav class="navbar navbar-expand-sm navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="<?php echo base_url(); ?>assets/images/logos/taters-logo.png" alt="Avatar" style="height: 40px;">
                </a>
                <div class="d-flex">
                    <a class="navbar-brand" href="#">Taters Enterprises, Inc.</a>
                </div>
            </div>
        </nav>
    </div>
    <div class="container">
        <div class="centered">
            <div class="text-center mb-4">
                <h2>Sales Variance Data</h2>
            </div>
            <form method="post" action="<?php echo base_url('svr/generate'); ?>">
            	<div class="row">
            		<!-- First Date Picker: From -->
            		<div class="col-6">
            			<div class="form-group">
            				<label for="fromDate">From:</label>
            				<input type="date" name="fromDate" class="form-control">
            			</div>
            		</div>
            		<!-- Second Date Picker: To -->
            		<div class="col-6">
            			<div class="form-group">
            				<label for="toDate">To:</label>
            				<input type="date" name="toDate" class="form-control">
            			</div>
            		</div>
            	</div>
            	<button type="submit" class="btn btn-danger mt-3 w-100">Generate</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap 4 JS, Popper.js, and jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>