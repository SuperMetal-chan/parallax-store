<?php
if(isset($_POST['submit']))
{
    echo "1111";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $gameList["Name"] ?></title>
    <link rel="stylesheet" href="../../templates/games/view/styles.css">
</head>
<?php include ROOT.'../views/default/headerItem.php' ?>
<body>
<div class="gameblock">
    <a href=""> <div class="gamecover" style="background-image:url('../../../images/<?php echo
    str_replace("'", "\'", str_replace(":", "", $gameList["Name"])); ?>.jpg');">
    </div></a>
    <div class="gameinfo">
        <span>
            <a href=""><p id="gameName"><?php echo $gameList["Name"] ?></p></a>
            <p id="infoPart">Дата релиза: <?php echo $gameList["Date"] ?></p>
            <p id="infoPart">Жанры: <?php echo $gameList["Genres"] ?></p>
            <p id="infoPart">Разработчик: <?php echo $gameList["Developers"] ?></p>
            <p id="infoPart">Издатель: <?php echo $gameList["Publishers"] ?></p>
            <p <?php if (empty($gameList["Series"])) echo "style = 'display: none'"; ?>id="infoPart">Серия игр:
                <?php if (!empty($gameList["Series"])) echo $gameList["Series"] ?></p>
            <p <?php if (empty($gameList["Engine"])) echo "style = 'display: none'"; ?>id="infoPart">Движок:
                <?php if (!empty($gameList["Engine"])) echo $gameList["Engine"] ?></p>

        <div class="descr">
            <form action="" method="POST">
                    <input type="submit" id="basketButton" name="basket" value=" <?php
                    if($display == false)
                        echo "Этот товар уже в корзине";
                    else
                        echo "Добавить в корзину";;
                        //echo "style='display: none'";
                    ?>"
                        <?php
                        if($display==false)
                            echo "disabled style='cursor: inherit;'";
                        ?>>
                </form>
            <p id="description"><?php echo $gameList["Description"]; ?></p>
        </div>
        </span>
    </div>
    <div class="gameScore">
        <span>
            <p id="scorePart">Оценка:</p>
            <p id="score"> ⍟<?php echo $gameList["Rating"] ?></p>
            <p id="scorePart">Проголосовало:</p>
            <p id="vote"> <?php echo $gameList["Number of votings"] ?></p>
        </span>
    </div>
</div>
</body>
<?php include ROOT.'../views/default/footer.php' ?>
</html>
