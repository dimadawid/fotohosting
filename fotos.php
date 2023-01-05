<?php
error_reporting(-1);
session_start();

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/function.php';


// if (isset($_POST['add'])) {
//     save_message();
//     header(header: "Location: fotos.php");
//     die;
// }

$messages = get_messages();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Фотохостинг</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container-fluid color-blue">
    <div class="header">
        <div class="row">

            <div class="col-md-6">
                <div class="logo d-flex align-items-center">
                <a href="index.php"><img src="./img/logofoto.png" alt=""></a>
                    <div class="text_logo">Фотохостинг</div>

                </div>
            </div>
            <div class="col-md-6 align-self-center">
                <div class="nav">
                    <ul>
                        <li><a href="index.php">главная</a></li>
                        <li><a href="about.php">о нас</a></li>
                        <li><a href="fotos.php">все фото</a></li>

                    </ul>
                </div>
            </div>

        </div>
    </div>

        </div>
    </div>
    </div>
    <div class="container my-4">
        <h1>фото</h1>
        <!-- <div class="row">
            <div class="col-md-12 text-center my-4">
                <a href="index.php"><button class="btn btn-primary">На Главную</button></a>
            </div>



        </div> -->


        <div class="row my-4">

                <?php

                $stmt = $pdo->prepare("select * from images");
                $stmt->execute();
                $imagelist = $stmt->fetchAll();

                foreach ($imagelist as $image) {
                ?>
<div class="col-md-4">
                    <img src="<?= $image["image"] ?>" title="<?= $image["name"] ?>" width="350" height="350">
                    </div>
                <?php
                }
                ?>
            
        



    </div>

</body>

</html>