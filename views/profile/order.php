<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Оформление заказа</title>
    <link rel="stylesheet" href="../../templates/profile/sign_up/style.css">
</head>
<?php include ROOT . '../views/default/headerItem.php' ?>

<body>
<div class="allInfo">
    <p id="registration">Оформления заказа</p>
    <form class="registrationInfo" style="margin-bottom: 44px;" method="POST" action="">
        <p id="infoOrder">Вы собираетесь приобрести такие игры: </p>
        <ul>
            <?php for($i=0;$i<sizeof($gamesInfo);$i++):?>
            <li id="infoOrderList">
                <span style="color: #fffdf8; text-shadow: 0 0 1em black;"><?php echo $gamesInfo[$i]["Name"]; ?></span>
                <span style="color: #fffa4b">(<?php echo $gamesInfo[$i]["Cost"]; ?> грн)</span>
            </li>
            <?php endfor; ?>
        </ul>
        <div>
            <p id="infoOrder" style="display: inline-block;">Общая стоимость игр</p>
            <p id="number" style="display: inline-block;">(<?php echo sizeof($gamesInfo); ?>)</p>
            <p id="infoOrder" style="display: inline-block;">для покупки:</p>
            <p id="costAll" style="display: inline-block;"><?php
                $cost = 0;
                for($i=0;$i<sizeof($gamesInfo);$i++)
                    $cost+=$gamesInfo[$i]["Cost"];
                echo $cost." ";
                ?>грн</p>
        </div>
        <hr><br><br>
        <label id="wayToPayLabel"> Выберите способ оплаты: </label>
        <select name="way" id="wayToPaySelect" required>
            <option value="Visa" id="wayToPayOptions">Visa</option>
            <option value="MasterCard" id="wayToPayOptions">MasterCard</option>
            <option value="American Express" id="wayToPayOptions">American Express</option>
        </select>
        <div class="numberCardDiv">
            <br><br>
        <label id="numberCardLabel" required>Номер карты: </label>
        <input type="text" name="cardNumber" maxlength="19" id="inputNumber"
               placeholder="Например, 1111-2222-3333-4444" value="<?php
        if(!empty($cardNumber))
            echo $cardNumber;
        ?>">
            <label id="mistakeConfirming"><?php
                if(!empty($errorArr["cardNumber"]))
                    echo $errorArr["cardNumber"];
                ?></label>
        </div>
        <br><br><br>
        <label id="timeLabel" required>Срок действия карты: </label>
        <select name="month" id="wayToPaySelect" style="float: left;">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
        </select>
        <select name="year" id="wayToPaySelect">
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            <option value="2024">2024</option>
            <option value="2025">2025</option>
            <option value="2026">2026</option>
            <option value="2027">2027</option>
            <option value="2028">2028</option>
            <option value="2029">2029</option>
            <option value="2030">2030</option>
            <option value="2031">2031</option>
            <option value="2032">2032</option>
            <option value="2033">2033</option>
            <option value="2034">2034</option>
            <option value="2035">2035</option>
            <option value="2036">2036</option>
            <option value="2037">2037</option>
            <option value="2038">2038</option>
            <option value="2039">2039</option>
            <option value="2040">2040</option>
            <option value="2041">2041</option>
            <option value="2042">2042</option>
            <option value="2043">2043</option>
            <option value="2044">2044</option>
        </select>
        <br><br><br>
        <label id="timeLabel" required>Код безопасности (CVV/CVC): </label>
        <input type="text" name="securityCode" id="inputNumber" maxlength="3" style="width: 160px; margin-top: -3px;"
               placeholder="Например, 123" value="<?php
        if(!empty($securityCode))
            echo $securityCode;
        ?>">
        <label id="mistakeConfirming"><?php
            if(!empty($errorArr["securityCode"]))
                echo $errorArr["securityCode"];
            ?></label>
        <br><br><br><button type="submit" name="orderConfirm" id="buttonConfirm">
            <span> Подтвердить заказ </span>
        </button>
        <button type="submit" name="decline" id="buttonDecline">
            <span> Отменить заказ </span>
        </button>
</div>


    </form>

</div>
</body>
<?php include ROOT . '../views/default/footer.php' ?>
</html>

