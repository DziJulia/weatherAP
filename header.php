            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
                <title>Weather API</title>
                <style>
            <?php include 'css/header.css'; ?>
            </style>
            </head>
            <body>
            <header>
            <img src="img/logo.png" alt="logo" id="logo">
            <nav class="navbar navbar-expand-md  sticky-top">
                <!-- Collapse button -->
                <button class="navbar-toggler  ml-auto second-button" type="button" data-toggle="collapse" data-target="#navb"
                        aria-controls="navbarSupportedContent20" aria-expanded="false" aria-label="Toggle navigation">
                        <div class="animated-icon2"><span></span><span></span><span></span><span></span></div>
                </button>
            <div id="navb" class="navbar-collapse ml-auto collapse hide ">
                <ul class="navbar-nav ml-auto ">
                <li class="nav-item">
                     <!--   WITH OPTION TO SAVE INFORMATION TO DATABASE -->
                    <a class="nav-link" href="index.php"><span class="fas fa-search-plus"></span> Search New</a>
                </li>
                <li class="nav-item">
                   <!--   ALL INFORMATION STORED IN DATABASE -->
                    <a class="nav-link" href="previous.php"><span class="fas fa-search"></span> Previous data</a>
                </li>
                <li class="nav-item">
                  <!--  Specific Row-->
                    <a class="nav-link " href="stored.php"><span class="fas fa-archive"></span> Search Stored</a>
                </li>
                <li class="nav-item">
                <!--   REMOVE DATA -->
                    <a class="nav-link" href="export.php"><span class="far fa-trash-alt"></span> Export</a>
                </li>
                </ul>
            </div>
            </header>
            </body>
            </html>