<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo "Профиль " . $infoList["nickname"]; ?></title>
    <link rel="stylesheet" href="../../templates/profile/view/style.css">
</head>
<?php include ROOT . '../views/default/headerProfile.php' ?>

<body>
<div class="allInfo">
    <div class="userInfo">
        <span>
            <p id="personal">Личные данные</p>
            <p id="personalInfo">Ваш никнейм: </p>
            <p id="personalInfoSpecial" style="font-size: 40px;"><?php echo $infoList["nickname"]; ?></p>
            <p id="personalInfo">Ваша почта:</p>
            <p id="personalInfoSpecial" style="font-size: 30px;"><?php echo $infoList["e-mail"]; ?></p>
            <p id="personalInfo">Ваш мобильный телефон:</p>
            <p id="personalInfoSpecial" style="font-size: 30px;"><?php
                if (empty($infoList["phone"]))
                    echo "Не указан";
                else
                    echo $infoList["phone"]; ?></p>
            <a href="http://localhost:8080/accepting"><button type="button" id="acceptingButton" style="<?php
            if($admin!="1")
                echo "display: none";
            ?>">
                <span> Перейти к подтверждению заявок</span>
            </button></a>
            <br>
            <a href="http://localhost:8080/exit"><button type="button" id="exitButton">
                <span">Выйти</span>
        </button></a>
        </span>
    </div>
    <div class="basketList" <?php
    if (sizeof($basketList) <= 0)
        echo 'style="display: none"';
    ?>>
        <p id="basketName">Корзина</p>
        <?php for ($i = 0; $i < sizeof($basketList); $i++): ?>
            <div class="game">
                <a href="http://localhost:8080/games/<?php
                echo $basketList[$i]['ID'] . "-" . str_replace(":", "_",
                        str_replace(" ", "-", $basketList[$i]['Name'])); ?>">
                    <div class="gameImage">
                        <img id="gameImagePhoto" src="../../../../../../../../../../images/<?php
                        echo str_replace(":", "", $basketList[$i]['Name']);
                        ?>.jpg">
                    </div>
                </a>
                <div class="gameInfo">
                    <a href="http://localhost:8080/games/<?php
                    echo $basketList[$i]['ID'] . "-" . str_replace(":", "_",
                            str_replace(" ", "-", $basketList[$i]['Name'])); ?>">
                        <p id="gameInfoValues" style="font-size: 21px;"><?php echo $basketList[$i]['Name']; ?></p></a>
                    <p id="gameInfoValues" style="color: #51ff20;"> <?php echo $basketList[$i]['Cost'] . " "; ?>грн</p>
                </div>
                <form class="crossPlace" action="" method="post">
                    <input type="submit" id="deleteButton" name="delete" value="<?php echo $basketList[$i]['ID']; ?>">
                </form>
            </div>
            <br>
        <?php endfor; ?>
        <form action="" method="post">
            <input type="submit" id="confirmButton" name="confirm" value="Оформить заказ">
        </form>
    </div>
    <div class="basketList" <?php
    if (sizeof($basketList) > 0)
        echo 'style="display: none"';
    ?>>
        <p id="basketName" style="font-size: 29px; padding: 10px 10px 2px 10px; color: #f58c94;">
            Ваша корзина пуста</p>
    </div>
    <div class="buyHistory" style="<?php
    if($admin=="1")
        echo "margin-top: 60%;"
    ?>">
        <p id="buyName">Ваши заказы</p>
        <table id="orderTable">
            <?php
            for ($i = 0; $i < sizeof($ordersList); $i++):
                ?>
                <tr id="orderDivGame">
                    <td id="buyLabel" style="width: 7%; text-align: right;">Заказ</td>
                    <td id="buyLabel" style="width: 7%; text-align: left;">№<?php
                        echo $ordersList[$i]["ID Order"];
                        ?></td>
                    <td id="buyLabel" style="width: 25%;">Стоимость: <?php
                        $games = ProfileModel::getGamesByIDOrder($ordersList[$i]["ID Order"]);
                        $counter = 0;
                        foreach ($games as $game)
                            $counter += $game["Cost"];
                        echo $counter . " ";
                        ?>грн
                    </td>
                    <td id="buyLabel" style="width: 31%;">Состояние:
                        <?php
                        if (!empty($ordersList[$i]["Confirm by Admin Date"]))
                            echo "Подтверждён " . $ordersList[$i]["Confirm by Admin Date"];
                        else if (!empty($ordersList[$i]["Decline by Admin Date"]))
                            echo "Отклонён " . $ordersList[$i]["Decline by Admin Date"];
                        else if (!empty($ordersList[$i]["Confirm by User Date"]))
                            echo "В исполнении...";
                        else if (!empty($ordersList[$i]["Start Date"]))
                        {
                            $idOrder = $ordersList[$i]["ID Order"];
                            echo "<a href='http://localhost:8080/order/$idOrder' 
                                style=\"border-bottom: 2px solid #BC0000; color: #BC0000;\">
                                Ожидает вашего подтверждения...</a>";
                        }
                        ?></td>
                </tr>
                <?php
                foreach ($games as $game):
                ?>
                    <tr id="emptyDiv" style="height: 1px; background-color: #656565;">
                        <td id="buyLabel" style="width: 14%;" colspan="2"></td>
                        <td id="buyLabel" style="width: 31%;" colspan="2"></td>
                    </tr>
                <tr id="orderDiv">
                    <td id="buyLabel" style="width: 14%;" colspan="<?php
                    if (empty($ordersList[$i]["Confirm by Admin Date"]))
                        echo "4";
                    else
                        echo "2";
                    ?>"><?php echo $game["Name"];?></td><?php
                    if (!empty($ordersList[$i]["Confirm by Admin Date"]))
                        echo "<td id=\"buyLabel\" style=\"width: 31%;\" colspan=\"2\" style=\"\">Ссылка: <a 
                            href=\"http://localhost:8080/profile/15\"
                                                                                 style=\"border-bottom: 2px solid 
                                                                                 #ff3021;
                                                                             color: #3225ff;\">
                            https://parallaxstore/download/ </a></td>"
                    ?>

                </tr>
                <?php
                endforeach;
                ?>
                <tr id="emptyDiv" style="<?php
                if($i==sizeof($ordersList)-1)
                    echo "display: none;";
                ?>">
                    <td id="buyLabel" style="width: 14%; height: 50px;" colspan="2"></td>
                    <td id="buyLabel" style="width: 31%;" colspan="2"></td>
                </tr>
            <?php
            endfor;
            ?>
        </table>
    </div>
</div>
</body>
<?php include ROOT . '../views/default/footer.php' ?>
</html>

