<!DOCTYPE html>
<html xmlns:color="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>Подтверждение заявок ParallaxStore</title>
    <link rel="stylesheet" href="../../templates/profile/sign_up/style.css">
</head>
<?php include ROOT . '../views/default/headerItem.php' ?>

<body>
<div class="allInfo">
    <p id="registration" style="color: #4448ff;">Подтверждение заявок</p>
    <span style="margin-left: 8%;"><a href="http://localhost:8080/accepting/new"><button type="button" id="buttonType"
                                                                                         style="color: #5dff66;">
        <span>
            Новые
        </span>
    </button></a></span>
    <span style="margin-left: 8%;"><a href="http://localhost:8080/accepting/processing"><button type="button"
                                                                                                id="buttonType"
                                                                                                style="color:
                                                                                                #eef931;">
        <span>
            В исполнении
        </span>
    </button></a></span>
        <span style="margin-left: 8%;"><a href="http://localhost:8080/accepting/archive"><button type="button"
                                                                                                 id="buttonType"
                                                                                                 style="color:
                                                                                                 #e94a37;">
        <span>
            Завершённые
        </span>
        </button></a></span>
    <?php
    for($i=0;$i<sizeof($allOrdersList);$i++):
    ?>
    <div class="orderDiv">
        <div class="topOrder">
            <label id="orderNumber">Заказ </label> <label id="orderNumber" style="color: #1c48d0; font-size: 28px;">
                <?php
                echo "№".$allOrdersList[$i]["ID Order"];
                ?></label>
            <label id="orderNumber"> от пользователя</label> <label id="orderNumber" style="color: #dc0007;
                font-size: 26px;">
                <?php
                echo $allOrdersList[$i]["User Nickname"];
                ?> </label> <label id="orderNumber"> на сумму</label>
            <label id="orderNumber" style="color: #8bd600; font-size: 28px;"> <?php
                $temp = $allOrdersList[$i]["ID Order"];
                $gamesList=ProfileModel::getGamesByIDOrder($temp);
                $cost = 0;
                for($j=0;$j<sizeof($gamesList);$j++)
                    $cost+=$gamesList[$j]["Cost"];
                echo $cost." грн.";
                ?></label>
        </div>
        <div class="middleOrderLeft">
            <label id="gameOrdered">Заказано игр (<?php
                echo sizeof($gamesList);
                ?>): </label>
            <ul><?php
                for($j=0;$j<sizeof($gamesList);$j++):
                ?>
                <li>
                    <label id="gameOrderedLabel">
                        <?php
                        echo $gamesList[$j]["Name"];
                        ?>
                    </label>
                    <span id="gameCostLabel">
                        <?php
                        echo "(".$gamesList[$j]["Cost"]." грн.)";
                        ?>
                    </span>
                </li>
                <?php
                endfor;
                ?>
            </ul>
        </div>
        <form class="middleOrderRight" action="" method="post">
            <label id="timingOrderLabel">Заказ был подтверждён пользователем: </label>
            <label id="timingOrderLabelTime"><?php
                    echo $allOrdersList[$i]["Confirm by User Date"];
                ?></label>
            <br>
            <br>
            <label id="timingOrderLabel">Способ оплаты: <label id="timingOrderLabelTime"><?php
                    echo $allOrdersList[$i]["Way to Pay"];
                    ?></label></label>
            <br>
            <br>
            <label id="timingOrderLabel">Номер карты: <label id="timingOrderLabelTime"><?php
                    $tempBankCardNumber=$allOrdersList[$i]["Bank Card Number"];
                    echo substr_replace(substr_replace(substr_replace($tempBankCardNumber,
                        "-",4,0),"-",9,0),"-",
                        14,0);
                    ?></label>
                </label>
            <br>
            <br>
            <label id="timingOrderLabel">Срок действия карты: <label id="timingOrderLabelTime"><?php
                    echo $allOrdersList[$i]["Time"];
                    ?></label></label>
            <br>
            <br>
            <label id="timingOrderLabel">Код безопасности (CVV/CVC): <label id="timingOrderLabelTime"><?php
                    echo $allOrdersList[$i]["Security Code"];
                    ?></label>
                </label>
            <br>
            <button type="submit" name="start" value="<?php
            echo $allOrdersList[$i]["ID Order"];
            ?>" id="buttonStart" style="<?php
            if($type!="new")
                echo "display: none;"
            ?>">
                <span>
                    Перевести заказ в исполнение
                </span>
            </button>
            <button type="submit" name="accept" value="<?php
            echo $allOrdersList[$i]["ID Order"];
            ?>" id="buttonAccept" style="<?php
            if($type!="processing")
                echo "display: none;"
            ?>">
                <span>
                    Подтвердить заказ
                </span>
            </button>
            <button type="submit" name="notAccept" value="<?php
            echo $allOrdersList[$i]["ID Order"];
            ?>" id="buttonNotAccept" style="<?php
            if($type!="processing")
                echo "display: none;"
            ?>">
                <span>
                    Отклонить заказ
                </span>
            </button>
            <br>
            <label id="stillNotRegisterLabel" style="<?php
            if($allOrdersList[$i]["Confirm by Admin Date"])
                echo "color: #0dd515;";
            else if($allOrdersList[$i]["Decline by Admin Date"])
                echo "color: #e60d00;";
            if($type!="archive")
                echo "display: none;";
            ?> margin: 0;">
                Этот заказ был <?php
                if($allOrdersList[$i]["Confirm by Admin Date"])
                    echo " подтверждён администратором: ".$allOrdersList[$i]["Confirm by Admin Date"];
                else if($allOrdersList[$i]["Decline by Admin Date"])
                    echo " отклонён администратором: ".$allOrdersList[$i]["Decline by Admin Date"];
                ?>
            </label>
        </form>
    </div>
    <?php
    endfor;
    ?>
</div>
</body>
<?php include ROOT . '../views/default/footer.php' ?>
</html>

