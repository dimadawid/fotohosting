<?php
error_reporting(-1);
session_start();

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/function.php';


if (isset($_POST['register'])) {
    registration();
    header(header: "Location: index.php");
    die;
}


if (isset($_POST['auth'])) {
    login();
    header(header: "Location: index.php");
    die;
}

if (isset($_GET['do']) && $_GET['do'] == 'exit') {
    if (!empty($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
    header(header: "Location: index.php");
    die;
}

if (isset($_POST['add'])) {
    save_message();
    header(header: "Location: index.php");
    die;
}

$messages = get_messages();



if (isset($_POST['addimg'])) {
    save_img();
    header(header: "Location: index.php");
    die;
}

if (isset($_GET['del'])) {
    global $pdo;
    $id = $_GET['del'];
    $sql = "DELETE FROM `messages` WHERE id = ?";
    $q = $pdo->prepare($sql);
    $response = $q->execute(array($id));
    header(header: "Location: index.php");
    $_SESSION['errors'] = 'Сообщение удалено';
    die;
}
if (isset($_GET['delimg'])) {
    global $pdo;
    $id = $_GET['delimg'];
    $sql = "DELETE FROM `images` WHERE id = ?";
    $q = $pdo->prepare($sql);
    $response = $q->execute(array($id));
    unlink('test.html');
    header(header: "Location: index.php");
    $_SESSION['errors'] = 'Картинка удалена';
    die;
}
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
                        <img src="./img/logofoto.png" alt="">
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

    <div class="container my-5">
        <div class="row text-center">
            <h1>Публикуйте фотографии здесь</h1>
            <div class="additional">Получите постоянные ссылки для Facebook, Twitter, форумов и блогов</div>
        </div>


        <div class="row my-5">
            <?php if (!empty($_SESSION['errors'])) : ?>
                <div class="col">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION['errors'];
                        unset($_SESSION['errors']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (!empty($_SESSION['success'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                </div>

            <?php endif; ?>


            <?php if (empty($_SESSION['user']['name'])) : ?>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <h3>Регистрация</h3>
                    </div>
                </div>

                <form action="index.php" method="post" class="row g-3">
                    <div class="col-md-6 offset-md-3">
                        <div class="form-floating mb-3">
                            <input type="text" name="login" class="form-control" id="floatingInput" placeholder="Имя">
                            <label for="floatingInput">Имя</label>
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-3">
                        <div class="form-floating">
                            <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Пароль</label>
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-3">
                        <button type="submit" name="register" class="btn btn-primary">Зарегистрироваться</button>
                    </div>
                </form>

                <div class="row mt-3">
                    <div class="col-md-6 offset-md-3">
                        <h3>Авторизация</h3>
                    </div>
                </div>




                <form action="index.php" method="post" class="row g-3">
                    <div class="col-md-6 offset-md-3">
                        <div class="form-floating mb-3">
                            <input type="text" name="login" class="form-control" id="floatingInput" placeholder="Имя">
                            <label for="floatingInput">Имя</label>
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-3">
                        <div class="form-floating">
                            <input type="password" name="pass" class="form-control" id="floatingPassword" placeholder="Password">
                            <label for="floatingPassword">Пароль</label>
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-3">
                        <button type="submit" name="auth" class="btn btn-primary">Войти</button>
                    </div>
                </form>


            <?php else : ?>


                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['user']['name']) ?>! <a class="delbutton" href="?do=exit">Выйти</a></p>
                    </div>
                </div>
                <form action="index.php" method="post" class="row g-3 mb-5">
                    <div class="col-md-6 offset-md-3">
                        <div class="form-floating">
                            <textarea class="form-control" name="message" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px;"></textarea>
                            <label for="floatingTextarea">Сообщение</label>
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-3">
                        <button type="submit" name="add" class="btn btn-primary">Отправить</button>
                    </div>
                </form>



                <form method="POST" action="index.php" class="row g-3 mb-5" enctype="multipart/form-data">
                    <div class="col-md-6 offset-md-3">
                        <input class="form-control" type="file" name="files[]" value="" />
                    </div>

                    <div class="col-md-6 offset-md-3">
                        <button class="btn btn-primary" type="submit" name="addimg">Загрузить</button>
                    </div>

                </form>





                <?php if (!empty($messages)) : ?>

                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <?php foreach ($messages as $message) : ?>

                                <div class="card my-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Автор: <?= htmlspecialchars($message['name']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($message['message']) ?></p>
                                        <p>Дата: <?= $message['created_at'] ?></p>
                                        <a class="delbutton" href="?del=<?= $message['id'] ?>">Удалить</a>
                                        <!-- <a href="?red=<?= $message['id'] ?>">Редактировать</a> -->
                                    </div>
                                </div>


                            <?php endforeach; ?>



                        </div>


                    </div>
                <?php endif; ?>
                <?php
                $stmt = $pdo->prepare("select * from images");
                $stmt->execute();
                $imagelist = $stmt->fetchAll();
                ?>

                <?php foreach ($imagelist as $image) : ?>
                    <div class="col-md-4 text-center my-4">
                        <img src="<?= $image["image"] ?>" title="<?= $image["name"] ?>" width="350" height="350">
                        <a class="delbutton" href="?delimg=<?= $image['id'] ?>">Удалить</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            </br>
            <!-- <div class="row">
                <div class="col-md-12 text-center my-4">
                    <a href="comment.php"><button class="btn btn-primary">Смотреть все фото</button></a>
                </div>



            </div> -->


        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>