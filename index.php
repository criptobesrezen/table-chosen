<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Библиотека</title>

    <!-- Подключение Chosen -->
    <link href="css/chosen.css" type="text/css" rel="stylesheet">
    <link href="chosen/docsupport/style.css" rel="stylesheet">
    <link href="chosen/docsupport/prism.css" rel="stylesheet">
    <!-- <script src="js/chosen.jquery.js" type="text/javascript"></script> -->
    <script src="js/chosen.proto.js" type="text/javascript"></script>
    <script type="text/javascript">$(".chosen-select").chosen();</script>

    <style type="text/css" media="all">
        /* fix rtl for demo */
        .chosen-rtl .chosen-drop {
            left: -9000px;
        }
    </style>

    <!-- Подключение Bootstrap -->
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.js" type="text/javascript"></script>

    <!-- Файл стилей -->
    <link href="css/style.css" type="text/css" rel="stylesheet">

    <!-- JQuery -->
    <script src="js/jquery-3.1.1.js" type="text/javascript"></script>

    <!-- Подключение шрифтов -->
    <link href="https://fonts.googleapis.com/css?family=Marck+Script" rel="stylesheet">

    <!-- Favicon -->
    <link href="/images/favicon.png" type="image/png" rel="shortcut icon">

</head>
<body>

<!-- Меню навигации на сайте -->

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Библиотека</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Главная<span class="sr-only">(current)</span></a></li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>


</form>
<?php
include 'api/controllers/LibraryController.php';
new Library();
?>


<script src="/chosen/chosen.jquery.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
</body>
</html>