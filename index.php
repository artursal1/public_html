<?php $rand = rand(1, 100000);
include_once "includes/class-autoload.inc.php";
if(!isset($_GET['pageNum'])) {
    $_GET['pageNum'] = 0;
}
$obj = new View();
// $model = new Model();
// $model->findBlanks();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/96e181b2c4.js" crossorigin="anonymous"></script>
    <title>MAGA</title>
    <link rel="stylesheet" type="text/css" href="css/main.css?<?php echo $rand; ?>">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>
<body>

    <header>
        <h2>MAGA <span>by Artur Salmanov</span></h2>
        <div class="subjects">
            <a style="background:#e8f1fe;color:#116eee;">
                <i class="fas fa-calculator"></i> 
                Ict & Maths
            </a>
            <a onclick="alert('Work in progress')">
                <i class="fas fa-flag-usa"></i> 
                English
            </a>
            <a onclick="alert('Work in progress')">
                <i class="fas fa-search-dollar"></i> 
                Economics
            </a>
        </div>
        <div><?php echo $_SESSION['uid']; ?></div>
    </header>

    <div id="percentage"><?php echo $obj->showPercentage(); ?></div>
    <div id="pages">
        <?php $o = 0; while($o < 13) { ?>
            <a onclick="changePage(<?php echo $o; ?>)" class="pageNum" id="pageNum<?php echo $o; ?>"><?php echo $o; ?></a>
        <?php $o += 1; } ?>
    </div>
    <div id="qsContainer"></div>
</body>
<div class="modal">
    <span class="activity-circle__spin activity-circle__spin--default">
        <span class="icon">
            <svg>
                <circle cy="50%" cx="50%" r="45%" class=""></circle>
            </svg>
        </span>
    </span>
</div>
<script type="text/javascript" src="js/main.js?<?php echo $rand; ?>"></script>
<script>

    changePage(<?php echo $_GET['pageNum']; ?>)

</script>
</html>