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
                    <h2>Sales Variance Report</h2>
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
                        <!-- Dropdown Menu: Filter Options -->
                        <div class="col-12">
                            <div class="form-group">
                                <label for="teiStore">Stores:</label>
                                <select name="teiStore" class="form-control">
                                    <option value="" disabled selected>Select store</option>
                                    <option value="22020882">TEI - SM MOA Skating</option>
                                    <option value="23101383">TEI-SM MOA Gamepark</option>
                                    <option value="16031882">Winuvia Inc. - Evia</option>
                                    <option value="22112282">TEI – Town Center Acacia.</option>
                                    <option value="18110584">TEI – Taters Market</option>
                                    <option value="24041882">TEI – SM Sta Rosa Gamepark</option>
                                    <option value="22020883">TEI – SM Southmall Gamepark</option>
                                    <option value="22020885">TEI – SM Megamall Skating</option>
                                    <option value="19072682">TEI - Taters BGC</option>
                                    <option value="22061382">TEI - SM North EDSA Bowling</option>
                                    <option value="22020882">TEI - SM MOA Skating</option>
                                    <option value="22020884">TEI - SM Megamall Bowling</option>
                                    <option value="22020886">TEI - SM Fairview Bowling</option>
                                    <option value="17071283">TEI - Robinsons Iligan</option>
                                    <option value="24040882">TEI - Robinsons Calasiao</option>
                                    <option value="22071282">TEI - Glorietta 4</option>
                                    <option value="15091184">Taters Snack Hauz - Mall of Alnor Branch</option>
                                    <option value="23111482">Table Black Kitchen Corp.-Greenhills</option>
                                    <option value="19061383">Southern Eats Group Inc. – Galleria South Laguna</option>
                                    <option value="18020785">Snack Champs Inc. – Commerce Center</option>
                                    <option value="18020782">Snack Champs  Inc. - Alabang Town Center</option>
                                    <option value="17112283">Querico Snacks Inc -Magnolia</option>
                                    <option value="18110583">Potatomonster, Inc. – Capitol Bacolod</option>
                                    <option value="22112283">Pop and Chips Specialist Inc. - South Tacloban</option>
                                    <option value="17120582">Pop and Chips Specialist - North Tacloban</option>
                                    <option value="18072382">Madayaw South Foods, Inc. – NCCC Buhangin</option>
                                    <option value="17080883">Madayaw South Foods, Inc. – Abreeza Davao</option>
                                    <option value="23050382">Madayaw South Foods Inc. – SM Lanang Bowling</option>
                                    <option value="18110582">Madayaw South Foods Inc. – Gaisano Davao</option>
                                    <option value="23102382">Madayaw South Foods Inc. –  SM CDO Bowling</option>
                                    <option value="16022982">Madayaw South Foods Inc. - Gaisano Digos</option>
                                    <option value="22022182">Krazy Girls Club OPC – Montevista Bacolod</option>
                                    <option value="18112982">Jalktan, Inc. - Robinsons Valencia</option>
                                    <option value="23013083">Golden Pops CDO Food Corp. - Centrio Mall</option>
                                    <option value="22062482">Freedom Munchers Food Corp. - Ayala Harbor Subic</option>
                                    <option value="18071682">Emiliodc General Merchandise Tuguegarao</option>
                                    <option value="18092582">Cinesuerte Snacks, Inc. - Trinoma</option>
                                    <option value="17112282">Chipmunch company inc. -Antipolo</option>
                                    <option value="22061385">Charlottedc Food Stop – SM Megamall Kiosk</option>
                                    <option value="23032882">Charlottedc Food Stop - SM North EDSA Kiosk</option>
                                    <option value="23013082">Cebu Cinesnacks, Inc. - SM Seaside Cebu Skating</option>
                                    <option value="22061383">Cebu Cinesnacks, Inc. - SM Seaside Bowling</option>
                                    <option value="22061384">Cebu Cinesnacks, Inc. - SM Cebu Bowling</option>
                                    <option value="24050682">Cebu Cinesnacks, Inc. - Island Central Mactan</option>
                                    <option value="18020786">Cebu Cinesnacks, Inc. - Cebu Ayala</option>
                                    <option value="17071282">Cebu Cinesnacks Inc. - SM seaside Cebu</option>
                                    <option value="19102882">Cebu Cinesnacks , Inc. - Central Bloc</option>
                                    <option value="20120882">Brother’s Snack House – BF Homes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-custom mt-3 w-100">Generate</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap 4 JS, Popper.js, and jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
