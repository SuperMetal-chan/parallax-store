<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../../templates/profile/sign_up/style.css">
</head>
<?php include ROOT . '../views/default/headerItem.php' ?>

<body>
<div class="allInfo">
    <p id="registration">Регистрация</p>
    <form class="registrationInfo" method="POST"  action="">
        <table id="registrationTable">

            <tr>
                <td id="top"><p id="info">Введите никнейм
                    <p id="important">*</p>
                    <p id="info">:</p></p></td>
                <td id="middle"><input name="nickname" type="text" id="infoInput"
                                       placeholder="Например, artemi" value="<?php
                                       if(isset($_POST['nickname']))
                                           echo $_POST['nickname'];
                                       ?>"></td>
                <td id="bottom"><p id="mistake" style="<?php
                    if($errorArr['nickname']=="☑ Верно")
                        echo " text-shadow: 0 0 0.2em green;
                        color: #31e245;
                        font-size: 27px;"
                    ?>"><?php
                        if (!empty($errorArr['nickname']))
                        echo  $errorArr['nickname']; ?></p></td>
            </tr>

            <tr>
                <td id="top"><p id="info">Введите e-mail
                    <p id="important">*</p>
                    <p id="info">:</p></p></td>
                <td id="middle"><input name="email" type="text" id="infoInput"
                                       placeholder="Например, artemi@gmail.com" value="<?php
                    if(isset($_POST['email']))
                        echo $_POST['email'];
                    ?>">
                </td>
                <td id="bottom"><p id="mistake" style="<?php
                    if($errorArr['email']=="☑ Верно")
                        echo " text-shadow: 0 0 0.2em green;
                        color: #31e245;
                        font-size: 27px;"
                    ?>"><?php
                        if (!empty($errorArr['email']))
                            echo  $errorArr['email']; ?></p></td>
            </tr>

            <tr>
                <td id="top"><p id="info">Введите номер
                    <p id="important"> </p>
                    <p id="info">:</p></p></td>
                <td id="middle"><input name="phone" type="text" id="infoInput"
                                       placeholder="Например, 0987654321" value="<?php
                    if(isset($_POST['phone']))
                        echo $_POST['phone'];
                    ?>"></td>
                <td id="bottom"><p id="mistake" style="<?php
                    if($errorArr['phone']=="☑ Верно")
                        echo " text-shadow: 0 0 0.2em green;
                        color: #31e245;
                        font-size: 27px;"
                    ?>"><?php
                        if (!empty($errorArr['phone']))
                            echo  $errorArr['phone']; ?></p></td>
            </tr>

            <tr>
                <td id="top"><p id="info">Введите пароль
                    <p id="important">*</p>
                    <p id="info">:</p></p></td>
                <td id="middle"><input name="password" type="password" id="infoInput"
                                       placeholder="Например, Artemi123" value="<?php
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
                <td id="top"><p id="info">Повторите пароль
                    <p id="important">*</p>
                    <p id="info">:</p></p></td>
                <td id="middle"><input name="repeatedPassword" type="password" id="infoInput"
                                       placeholder="Введите пароль ещё раз" value="<?php
                    if(isset($_POST['repeatedPassword']))
                        echo $_POST['repeatedPassword'];
                    ?>"></td>
                <td id="bottom"><p id="mistake" style="<?php
                    if($errorArr['repeatedPassword']=="☑ Верно")
                        echo " text-shadow: 0 0 0.2em green;
                        color: #31e245;
                        font-size: 27px;"
                    ?>"><?php
                        if (!empty($errorArr['repeatedPassword']))
                            echo  $errorArr['repeatedPassword']; ?></p><br></td>
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
                    <p id="stillNotRegisterLabel">Уже зарегистрированы? <a href="http://localhost:8080/log_in"
                                                                           style="text-decoration: dotted underline #f8fff9;
                                color: red;">
                            Войдите</a></p>
                </td>
            </tr>

        </table>
    </form>
</div>
</body>
<?php include ROOT . '../views/default/footer.php' ?>
</html>

