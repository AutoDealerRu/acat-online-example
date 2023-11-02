<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>AcatOnline</title>
    <link href="/styles.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-1.7.2.min.js"></script>
</head>
<body>
    <div style="text-align: center">
        <h1 style="color: #000; margin-bottom: 2em;">
            Для использования сайта-примера пожалуйста:
            <br>
            <br>
            1. введите ваш API token в поле ниже
            <br>
            <br>
            2. нажмите "Отправить"
        </h1>
        <?php if (isset($error) && $error) { ?>
            <h1 style="color: #cd3d3d; margin-bottom: 2em;"><?php echo $error ?></h1>
        <?php } ?>
    </div>
    <form class="catalog_search" method='POST' action='/' style="width: 440px; margin: 0 auto;">
        <input required class="search_vin" id="search_vin" type='text' name='token' placeholder=' ' style="padding-left: 4px;">
        <label class="form__label" for='search_vin'>ваш API token</label>
        <input class="button button--green" type='submit' value="Отправить" style="padding: 0 7px; margin-left: 8px;">
    </form>
</body>
</html>
