<?php

include_once ROOT . '/components/DBConn.php';

class ProfileModel
{
    public static function checkUniquenessPassword($password)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("SET NAMES utf8;");
            $result = $conn->query("SELECT * FROM user WHERE password = '{$password}'");

            if ($result->rowCount() == 0)
                return true;
            return false;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function checkUniquenessEmail($email)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("SET NAMES utf8;");
            $result = $conn->query("SELECT * FROM user WHERE `e-mail`   = '{$email}'");

            if ($result->rowCount() == 0)
                return true;
            return false;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function checkUniquenessPhone($phone)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("SET NAMES utf8;");
            $result = $conn->query("SELECT * FROM user WHERE phone = '{$phone}'");

            if ($result->rowCount() == 0)
                return true;
            return false;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function checkUniquenessName($nickname)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("SET NAMES utf8;");
            $result = $conn->query("SELECT * FROM user WHERE nickname = '{$nickname}'");

            if ($result->rowCount() == 0)
                return true;
            return false;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function checkRightnessPassword($password, $repeatedPassword)
    {
        if (empty($password))
            return "Пароль не введён";
        else if (strlen($password) < 5)
            return "Пароль слишком короткий";
        else if (strlen($password) > 60)
            return "Пароль слишком длинный";
        else if (!preg_match('/.*\d.*/', $password))
            return "Пароль должен содержать цифры";
        else if (preg_match('/\d*/', $password) === true)
            return "Пароль должен содержать буквы";
        else if ($password == strtoupper($password))
            return "Пароль должен также содержать буквы нижнего регистра";
        else if ($password == strtolower($password))
            return "Пароль должен также содержать буквы верхнего регистра";
        else if ($password != $repeatedPassword)
            return "Пароли не совпадают";
        else if (!self::checkUniquenessPassword($password))
            return "Этот пароль уже занят";
        return "Норм";
    }

    public static function checkRightnessName($name)
    {
        if (empty($name))
            return "Ник не введён";
        else if (strlen($name) < 5)
            return "Ник слишком короткий";
        else if (strlen($name) > 60)
            return "Ник слишком длинный";
        else if (!preg_match('/.*[a-zA-Z].*/', $name))
            return "Ник должен содержать буквы";
        else if (!self::checkUniquenessName($name))
            return "Этот ник уже занят";
        return "Норм";
    }

    public static function checkRightnessEmail($email)
    {
        if (empty($email))
            return "E-mail не введён";
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            return "Введён неверный e-mail";
        else if (!self::checkUniquenessEmail($email))
            return "Этот e-mail уже занят";
        return "Норм";
    }

    public static function checkRightnessPhone($phone)
    {
        if ((strlen($phone) != 10 || !preg_match('/^\d+$/', $phone)) && !empty($phone))
            return "Введён неверный номер";
        else if (!self::checkUniquenessPhone($phone))
            return "Этот телефон уже занят";
        return "Норм";
    }

    public static function checkRightnessRepeatedPassword($repeatedPassword, $password)
    {
        if (empty($password))
            return "Вы не ввели пароль повторно";
        else if ($password != $repeatedPassword)
            return "Пароли не совпадают";
        else
            return "Норм";
    }

    public static function addUser($nickname, $email, $phone, $password, $repeatedPassword)
    {
        $errorArr = array();
        $boolean = true;
        if (self::checkRightnessName($nickname) != "Норм")
        {
            $errorArr['nickname'] = self::checkRightnessName($nickname);
            $boolean = false;
        }
        else
            $errorArr['nickname'] = "☑ Верно";
        if (self::checkRightnessEmail($email) != "Норм")
        {
            $errorArr['email'] = self::checkRightnessEmail($email);
            $boolean = false;
        }
        else
            $errorArr['email'] = "☑ Верно";
        if (self::checkRightnessPhone($phone) != "Норм")
        {
            $errorArr['phone'] = self::checkRightnessPhone($phone);
            $boolean = false;
        }
        else if (!empty($phone))
            $errorArr['phone'] = "☑ Верно";
        else
            $errorArr['phone'] = "";
        if (self::checkRightnessPassword($password, $repeatedPassword) != "Норм")
        {
            $errorArr['password'] = self::checkRightnessPassword($password, $repeatedPassword);
            $boolean = false;
        }
        else
            $errorArr['password'] = "☑ Верно";
        if (self::checkRightnessRepeatedPassword($repeatedPassword, $password) != "Норм")
        {
            $errorArr['repeatedPassword'] = self::checkRightnessRepeatedPassword($repeatedPassword, $password);
            $boolean = false;
        }
        else if (self::checkRightnessPassword($password, $repeatedPassword) != "Норм")
        {
            $errorArr['repeatedPassword'] = null;
            $boolean = false;
        }
        else
            $errorArr['repeatedPassword'] = "☑ Верно";
        if ($boolean == true)
        {
            try
            {
                $conn = DBConn::getConnection();

                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                if (!empty($phone))
                {
                    // Запрос к базе данных
                    $conn->query("INSERT INTO `messengerschema`.`user` 
                        (`nickname`, `e-mail`, `phone`, `password`) VALUES ('{$nickname}', '{$email}', 
                        '{$phone}', '{$password}');");
                }
                else
                {
                    $conn->query("INSERT INTO `messengerschema`.`user` 
                        (`nickname`, `e-mail`, `password`) VALUES ('{$nickname}', '{$email}', '{$password}');");
                }
                $conn = null;
                return null;
            }
            catch (PDOException $e)
            {
                echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
            }
        }
        else
        {
            return $errorArr;
        }
    }

    public static function checkUser($email_or_phone, $password)
    {
        $errorArr = array();
        $boolean = true;
        if (self::checkUniquenessEmail($email_or_phone) === true &&
            self::checkUniquenessPhone($email_or_phone) === true)
        {
            $errorArr['email_or_phone'] = "Неверный e-mail или номер";
            $boolean = false;
        }
        else
            $errorArr['email_or_phone'] = "☑ Верно";
        if (self::checkUniquenessPassword($password) === true)
        {
            $errorArr['password'] = "Неверный пароль";
            $boolean = false;
        }
        else
            $errorArr['password'] = "☑ Верно";
        if ($boolean === true)
        {
            try
            {
                $conn = DBConn::getConnection();

                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Запрос к базе данных
                $conn->query("SET NAMES utf8;");
                $result = $conn->query("SELECT * FROM messengerschema.user WHERE `password`='{$password}' AND 
                    (`phone`='{$email_or_phone}' OR `e-mail`='{$email_or_phone}');");

                if ($result->rowCount() == 0)
                {
                    $errorArr['email_or_phone'] = "Попробуйте другой номер/e-mail";
                    $errorArr['password'] = "или пароль";
                    return $errorArr;
                }
                else
                    return null;
            }
            catch (PDOException $e)
            {
                echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
            }
        }
        else
            return $errorArr;
    }

    public static function getUserByID($ID)
    {
        if (!empty($ID))
        {
            try
            {
                $conn = DBConn::getConnection();

                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $userInfo = array();

                // Запрос к базе данных
                $result = $conn->query("SELECT * FROM user WHERE `ID`='{$ID}'");
                $row = $result->fetch();
                $userInfo["ID"] = $row["ID"];
                $userInfo["nickname"] = $row["nickname"];
                $userInfo["e-mail"] = $row["e-mail"];
                $userInfo["phone"] = $row["phone"];
                $userInfo["password"] = $row["password"];
                $conn = null;
                return $userInfo;
            }
            catch (PDOException $e)
            {
                echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
            }
        }
    }

    public static function getIDByName($name)
    {
        if (!empty($name))
        {
            try
            {
                $conn = DBConn::getConnection();

                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                // Запрос к базе данных
                $result = $conn->query("SELECT * FROM user WHERE `nickname`='{$name}'");
                $row = $result->fetch();
                $ID = $row["ID"];
                $conn = null;
                return $ID;
            }
            catch (PDOException $e)
            {
                echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
            }
        }
    }

    public static function getNameByPassword($password)
    {
        if (!empty($password))
        {
            try
            {
                $conn = DBConn::getConnection();

                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                // Запрос к базе данных
                $result = $conn->query("SELECT * FROM user WHERE `password`='{$password}'");
                $row = $result->fetch();
                $nickname = $row['nickname'];
                $conn = null;
                return $nickname;
            }
            catch (PDOException $e)
            {
                echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
            }
        }
    }

    public static function authID($ID)
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
        $_SESSION['ID'] = $ID;
    }

    public static function authName($name)
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }
        $_SESSION['nickname'] = $name;
    }

    public static function checkLoggedID($string)
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }

        // Если сессия есть, вернём идентификатор пользователя
        if (isset($_SESSION['ID']))
            return $_SESSION['ID'];

        if ($string == "profile")
            header("Location: /log_in");
    }

    public static function checkLoggedName($string)
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }

        // Если сессия есть, вернём ник пользователя
        if (isset($_SESSION['nickname']))
            return $_SESSION['nickname'];

        if ($string == "profile")
            header("Location: /log_in");
    }

    public static function unLogUser()
    {
        if (session_status() == PHP_SESSION_NONE)
        {
            session_start();
        }

        if (isset($_SESSION['ID']))
            unset($_SESSION['ID']);

        if (isset($_SESSION['nickname']))
            unset($_SESSION['nickname']);
    }

    public static function addToBasket($ID_User, $ID_Game)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Запрос к базе данных
            $conn->query("INSERT INTO `messengerschema`.`basket` (`ID User`, `ID Game`) VALUES ('{$ID_User}', 
                            '{$ID_Game}');");
            $conn = null;
            return null;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function deleteFromBasket($ID_User, $ID_Game)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $basketList = array();

            // Запрос к базе данных
            $result = $conn->query("DELETE FROM messengerschema.basket WHERE `ID User` = '{$ID_User}' AND 
                `ID Game` = '{$ID_Game}';");
            for ($i = 0; $row = $result->fetch(); $i++)
            {
                $basketList[$i]["Name"] = $row["Name"];
                $basketList[$i]["Cost"] = $row["Cost"];
            }
            $conn = null;
            return $basketList;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function clearBasketByUser($ID_User)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("DELETE FROM messengerschema.basket WHERE `ID User` = '{$ID_User}'");
            $conn = null;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function getBasket($ID_User)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $basketList = array();

            // Запрос к базе данных
            $result = $conn->query("SELECT g.* FROM messengerschema.games g JOIN messengerschema.basket b
                ON g.ID = b.`ID Game` WHERE b.`ID User`='{$ID_User}';");
            for ($i = 0; $row = $result->fetch(); $i++)
            {
                $basketList[$i]["ID"] = $row["ID"];
                $basketList[$i]["Name"] = $row["Name"];
                $basketList[$i]["Cost"] = $row["Cost"];
            }
            $conn = null;
            return $basketList;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function checkIfInBasket($ID_User, $ID_Game)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $basketList = array();

            // Запрос к базе данных
            $result = $conn->query("SELECT * FROM messengerschema.basket WHERE `ID User` = '{$ID_User}' AND 
                `ID Game` = '{$ID_Game}';");
            $conn = null;
            if ($result->rowCount() == 0)
                return false;
            return true;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function startOrder($ID_User, $Date)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("INSERT INTO `messengerschema`.`orders` (`ID User`, `Start Date`) 
                VALUES ('{$ID_User}', '{$Date}');");
            $conn = null;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function getOrder($ID_User, $Date)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $result = $conn->query("SELECT * FROM messengerschema.orders WHERE `ID User` = '{$ID_User}' AND 
                    `Start Date`='{$Date}';");
            $conn = null;
            $row = $result->fetch();
            return $row['ID Order'];
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function getGamesFromBasketByIDUser($ID_User)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $gamesBasketList = array();

            // Запрос к базе данных
            $result = $conn->query("SELECT * FROM messengerschema.basket WHERE `ID User` = '{$ID_User}'");
            for ($i = 0; $row = $result->fetch(); $i++)
                $gamesBasketList[$i] = $row["ID Game"];
            $conn = null;
            return $gamesBasketList;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function addGameToOrder($ID_Order, $ID_Game)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("INSERT INTO `messengerschema`.`orders_have_games` (`ID_Order`, `ID_Game`) 
                VALUES ('{$ID_Order}', '{$ID_Game}');");
            $conn = null;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function checkIfUserHasThisOrder($ID_Order, $ID_User)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $result = $conn->query("SELECT * FROM messengerschema.orders WHERE `ID User` = '{$ID_User}' AND 
                    `ID Order`='{$ID_Order}';");
            $conn = null;
            if ($result->rowCount() == 0)
                return false;
            return true;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function confirmOrder($ID_Order)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("UPDATE `messengerschema`.`orders` SET `Confirmed` = '1' WHERE 
                (`ID Order` = '{$ID_Order}');");
            $conn = null;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function getGamesByIDOrder($ID_Order)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $gamesOrderList = array();

            // Запрос к базе данных
            $result = $conn->query("SELECT g.* FROM messengerschema.games g JOIN 
                messengerschema.orders_have_games og ON g.`ID`=og.`ID_Game` WHERE og.ID_Order = '{$ID_Order}';");
            for ($i = 0; $row = $result->fetch(); $i++)
            {
                $gamesOrderList[$i]["Name"] = $row["Name"];
                $gamesOrderList[$i]["Cost"] = $row["Cost"];
            }
            $conn = null;
            return $gamesOrderList;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function fillOrder($orderID, $wayToPay, $currentDate, $bankCardNumber, $timeMonth,$timeYear,
                                        $securityCode)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("UPDATE `messengerschema`.`orders` SET `Way to Pay` = '{$wayToPay}',
                `Bank Card Number` = '{$bankCardNumber}', 
                `Time Month` = '{$timeMonth}', `Time Year` = '{$timeYear}', `Security Code` = '{$securityCode}', 
                `Confirm by User Date` = '{$currentDate}' 
                WHERE (`ID Order` = '{$orderID}');");
            $conn = null;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function deleteOrder($orderID)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("DELETE FROM messengerschema.orders WHERE `ID Order` = '{$orderID}';");
            //$conn->query("DELETE FROM messengerschema.orders_have_games WHERE `ID_Order` = '{$orderID}';");
            $conn = null;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function checkRightnessCardNumber($cardNumber)
    {
        if (empty($cardNumber))
            return "Вы не ввели номер карты";
        else if (strlen($cardNumber)!=16 || !preg_match('/^\d+$/', $cardNumber))
            return "Введён неверный номер карты";
        else
            return "Норм";
    }

    public static function checkRightnessSecurityCode($securityCode)
    {
        if (empty($securityCode))
            return "Вы не ввели код безопасности";
        else if (strlen($securityCode)!=3 || !preg_match('/^\d+$/', $securityCode))
            return "Введён неверный код безопасности";
        else
            return "Норм";
    }

    public static function checkOrder($cardNumber, $securityCode)
    {
        $errorArr = array();
        if (self::checkRightnessCardNumber($cardNumber) != "Норм")
            $errorArr['cardNumber'] = self::checkRightnessCardNumber($cardNumber);
        if (self::checkRightnessSecurityCode($securityCode) != "Норм")
            $errorArr['securityCode'] = self::checkRightnessSecurityCode($securityCode);
        return $errorArr;
    }

    public static function getAllUserOrders($ID_User)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $ordersList = array();

            // Запрос к базе данных
            $result = $conn->query("SELECT * FROM messengerschema.orders WHERE `ID User` = '{$ID_User}' 
                ORDER BY `ID Order` DESC;");
            $conn = null;
            for($i=0;$row = $result->fetch();$i++)
            {
                $ordersList[$i]["ID Order"] = $row["ID Order"];
                $ordersList[$i]["Start Date"] = $row["Start Date"];
                $ordersList[$i]["Confirm by User Date"] = $row["Confirm by User Date"];
                $ordersList[$i]["Confirm by Admin Date"] = $row["Confirm by Admin Date"];
                $ordersList[$i]["Decline by Admin Date"] = $row["Decline by Admin Date"];
            }
            return $ordersList;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function checkIfAdmin($ID_User)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("SET NAMES utf8;");
            $result = $conn->query("SELECT `isAdmin` FROM user WHERE ID = '{$ID_User}'");
            $row = $result->fetch();
            return $row["isAdmin"];
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function getOrdersBySQLString($string)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $allOrdersList = array();

            // Запрос к базе данных
            $result = $conn->query("SELECT * FROM messengerschema.orders ".$string);
            for($i=0;$row = $result->fetch();$i++)
            {
                $allOrdersList[$i]["ID Order"] = $row["ID Order"];
                $tempIDUser = $row["ID User"];
                $resultTemp = $conn->query("SELECT * FROM user WHERE `ID`='{$tempIDUser}';");
                $rowTemp=$resultTemp->fetch();
                $allOrdersList[$i]["User Nickname"] = $rowTemp["nickname"];
                $allOrdersList[$i]["Start Date"] = $row["Start Date"];
                $allOrdersList[$i]["Way to Pay"] = $row["Way to Pay"];
                $allOrdersList[$i]["Bank Card Number"] = $row["Bank Card Number"];
                if(strlen($row["Time Month"])==1)
                {
                    $tempMonth = "0".$row["Time Month"];
                }
                else
                    $tempMonth = $row["Time Month"];
                $tempYear=substr($row["Time Year"],2);
                $allOrdersList[$i]["Time"]=$tempMonth."/".$tempYear;
                $allOrdersList[$i]["Security Code"]=$row["Security Code"];
                $allOrdersList[$i]["Confirm by User Date"] = $row["Confirm by User Date"];
                $allOrdersList[$i]["Confirm by Admin Date"] = $row["Confirm by Admin Date"];
                $allOrdersList[$i]["Decline by Admin Date"] = $row["Decline by Admin Date"];
            }
            $conn = null;
            return $allOrdersList;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function orderToProcessing($ID_Order)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("UPDATE `messengerschema`.`orders` SET `Is Executing Now` = '1'
                WHERE (`ID Order` = '{$ID_Order}');");
            $conn = null;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function orderFinalDecision($ID_Order,$date,$decision)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Запрос к базе данных
            $conn->query("UPDATE `messengerschema`.`orders` SET `{$decision} by Admin Date` = '{$date}' WHERE 
                (`ID Order` = '{$ID_Order}');");
            $conn->query("UPDATE `messengerschema`.`orders` SET `Is Executing Now` = NULL
                WHERE (`ID Order` = '{$ID_Order}');");
            $conn = null;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }
}