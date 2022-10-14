<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main</title>
    <?php require_once 'views/css.php'; ?>
</head>
<body>
    <?php require_once 'views/header.php'; ?>
    <div class="container-fluid">
        <div id="main">
            <h1> Main section </h1>
            <div class="center icon-animated-div my-4">
                <i class="bi bi-emoji-smile" style="font-size: 8rem;"></i>
            </div>
            <div class="center my-4">
                <img src="<?= constant('URL') ?>public/img/pokemon.svg" class="pokeball-animated" alt="Ícono de Poke-Ball">
            </div>
        </div>
    </div>
    <?php require_once 'views/footer.php'; ?>
    <?php require_once 'views/js.php'; ?>
</body>
</html>
