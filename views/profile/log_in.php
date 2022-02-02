<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Вход</title>
    <link rel="stylesheet" href="../../templates/profile/sign_up/style.css">
</head>
<?php include ROOT.'../views/default/headerItem.php' ?>

<body>
<div class="allInfo" style="min-height: 560px;">
    <p id="registration">Вход</p>
    <form class="registrationInfo" method="POST"  action="">
        <table id="registrationTable">
            <tr>
                <td id="top"><p id="info">Введите e-mail или телефон
                    <p id="info">:</p></p></td>
                <td id="middle"><input name="email_or_phone" type="text" id="infoInput"
                                       placeholder="" value="<?php
                    if(isset($_POST['email_or_phone']))
                        echo $_POST['email_or_phone'];
                    ?>">
                </td>
                <td id="bottom"><p id="mistake" style="<?php
                    if($errorArr['email_or_phone']=="☑ Верно")
                        echo " text-shadow: 0 0 0.2em green;
                        color: #31e245;
                        font-size: 27px;"
                    ?>"><?php
                        if (!empty($errorArr['email_or_phone']))
                            echo  $errorArr['email_or_phone']; ?></p></td>
            </tr>
            <tr>
                <td id="top"><p id="info">Введите пароль
                    <p id="info">:</p></p></td>
                <td id="middle"><input name="password" type="password" id="infoInput"
                                       placeholder="" value="<?php
                    if(isset($_POST['password']))
                        echo $_POST['password'];
                    ?>"></td>
                <td id="bottom"><p id="mistake" style="<?php
                    if($errorArr['password']=="☑ Верно")
                        echo " text-shadow: 0 0 0.2em green;
                        color: #31e245;
                        font-size: 27px;"
                    ?>"
                    ><?php
                        if (!empty($errorArr['password']))
                            echo  $errorArr['password']; ?></p></td>
            </tr>
            <tr>
                <td id="top"></td>
                <td id="middleButton">
                    <button type="submit" id="buttonNext">
                        <span> Продолжить </span>
                    </button>
                </td>
                <td id="bottom"></td>
            </tr>
            <tr>
                <td id="top"></td>
                <td id="middle">
                    <br>
                    <p id="stillNotRegisterLabel">Ещё не зарегистрированы? <a href="http://localhost:8080/sign_up"
                        style="text-decoration: dotted underline #f8fff9;
                                color: red;">
                            Пройдите регистрацию</a></p>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
<?php include ROOT . '../views/default/footer.php' ?>
</html>