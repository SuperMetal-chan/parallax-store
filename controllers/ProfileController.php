<?php

include_once ROOT . '/models/ProfileModel.php';

class ProfileController
{
    public function actionView($ID)
    {
        if (!empty($ID))
        {
            $userID = ProfileModel::checkLoggedID("profile");
            $admin = ProfileModel::checkIfAdmin($userID);
            $username = ProfileModel::checkLoggedName("profile");
            if (isset($_POST['delete']))
            {
                ProfileModel::deleteFromBasket($userID, $_POST['delete']);
                unset($_POST['delete']);
            }
            if (isset($_POST['confirm']))
            {
                date_default_timezone_set("Europe/Kiev");
                $currentTime = date("Y-m-d H:i:s");
                ProfileModel::startOrder($userID, $currentTime);
                $orderID = ProfileModel::getOrder($userID, $currentTime);
                $gamesBasketList = ProfileModel::getGamesFromBasketByIDUser($userID);
                foreach ($gamesBasketList as $game)
                    ProfileModel::addGameToOrder($orderID, $game);
                //$this->actionOrder($orderID);
                header("Location: /order/$orderID");
                unset($_POST['confirm']);
            }
            $infoList = ProfileModel::getUserByID($ID);
            $basketList = ProfileModel::getBasket($ID);
            if ($ID != $userID)
            {
                $this->actionLog_in();
                return null;
            }
            $ordersList = ProfileModel::getAllUserOrders($userID);
            require_once(ROOT . '/views/profile/index.php');
            die;
        }
    }

    public function actionExit()
    {
        ProfileModel::unLogUser();
        header("Location: /log_in");
    }

    public function actionViewAfter($ID)
    {
        if (!empty($ID))
        {
            $infoList = ProfileModel::getUserByID($ID);
            header("Location: /profile/$ID");
            //$this->actionView($ID);
        }
    }

    public function actionSign_up()
    {
        $nickname = null;
        $email = null;
        $phone = null;
        $password = null;
        $repeatedPassword = null;
        if (isset($_POST['nickname']))
            $nickname = $_POST['nickname'];
        if (isset($_POST['email']))
            $email = $_POST['email'];
        if (isset($_POST['phone']))
            $phone = $_POST['phone'];
        if (isset($_POST['password']))
            $password = $_POST['password'];
        if (isset($_POST['repeatedPassword']))
            $repeatedPassword = $_POST['repeatedPassword'];
        $errorArr = ProfileModel::addUser($nickname, $email, $phone, $password, $repeatedPassword);
        $admin = "0";
        if (empty($errorArr) === true)
        {
            $ID = ProfileModel::getIDByName($nickname);
            ProfileModel::authID($ID);
            ProfileModel::authName($nickname);
            $userID = ProfileModel::checkLoggedID("profile");
            $admin = ProfileModel::checkIfAdmin($userID);
            $username = ProfileModel::checkLoggedName("profile");
            $this->actionViewAfter($ID);
        }
        else
        {
            require_once(ROOT . '/views/profile/sign_up.php');
            die;
        }
    }

    public function actionLog_in()
    {
        $email_or_phone = null;
        $password = null;
        if (isset($_POST['email_or_phone']))
            $email_or_phone = $_POST['email_or_phone'];
        if (isset($_POST['password']))
            $password = $_POST['password'];
        $errorArr = ProfileModel::checkUser($email_or_phone, $password);
        $admin = "0";
        if (empty($errorArr) === true)
        {
            $userID = ProfileModel::checkLoggedID("profile");
            $admin = ProfileModel::checkIfAdmin($userID);
            $username = ProfileModel::checkLoggedName("profile");
            $nickname = ProfileModel::getNameByPassword($password);
            $ID = ProfileModel::getIDByName($nickname);
            ProfileModel::authID($ID);
            ProfileModel::authName($nickname);
            $this->actionViewAfter($ID);
        }
        else
        {
            require_once(ROOT . '/views/profile/log_in.php');
            die;
        }
    }

    public function actionOrder($orderID)
    {
        $userID = ProfileModel::checkLoggedID("profile");
        $admin = ProfileModel::checkIfAdmin($userID);
        $username = ProfileModel::checkLoggedName("profile");
        if (!ProfileModel::checkIfUserHasThisOrder($orderID, $userID))
        {
            header("Location: /log_in");
            return null;
        }
        $gamesInfo = ProfileModel::getGamesByIDOrder($orderID);
        if (isset($_POST['orderConfirm']))
        {
            $wayToPay = null;
            $cardNumber = null;
            $month = null;
            $year = null;
            $securityCode = null;
            if (isset($_POST['way']))
            {
                $wayToPay = $_POST['way'];
                unset($_POST['way']);
            }
            if (isset($_POST['cardNumber']))
            {
                $cardNumber = str_replace("-", "", $_POST['cardNumber']);
                unset($_POST['cardNumber']);
            }
            if (isset($_POST['month']))
            {
                $month = $_POST['month'];
                unset($_POST['month']);
            }
            if (isset($_POST['year']))
            {
                $year = $_POST['year'];
                unset($_POST['year']);
            }
            if (isset($_POST['securityCode']))
            {
                $securityCode = $_POST['securityCode'];
                unset($_POST['securityCode']);
            }
            $errorArr = ProfileModel::checkOrder($cardNumber, $securityCode);
            if (empty($errorArr) === true)
            {
                date_default_timezone_set("Europe/Kiev");
                $currentTime = date("Y-m-d H:i:s");
                ProfileModel::fillOrder($orderID, $wayToPay, $currentTime, $cardNumber, $month, $year,
                    $securityCode);
                ProfileModel::clearBasketByUser($userID);
                header("Location: /profile/$userID");
                die;
            }
            else
            {
                require_once(ROOT . '/views/profile/order.php');
                die;
            }
        }
        else if (isset($_POST['decline']))
        {
            ProfileModel::deleteOrder($orderID);
            header("Location: /profile/$userID");
            echo "lol";
        }
        require_once(ROOT . '/views/profile/order.php');
        die;
    }

    public function actionAccepting($type)
    {
        $userID = ProfileModel::checkLoggedID("profile");
        $admin = ProfileModel::checkIfAdmin($userID);
        $username = ProfileModel::checkLoggedName("profile");
        if ($admin == "1")
        {
            if (isset($_POST['start']))
                ProfileModel::orderToProcessing($_POST['start']);
            else if (isset($_POST['accept']) || isset($_POST['notAccept']))
            {
                date_default_timezone_set("Europe/Kiev");
                $currentTime = date("Y-m-d H:i:s");
                if (isset($_POST['accept']))
                    ProfileModel::orderFinalDecision($_POST['accept'], $currentTime, "Confirm");
                else if (isset($_POST['notAccept']))
                    ProfileModel::orderFinalDecision($_POST['notAccept'], $currentTime, "Decline");
            }
            if ($type == "new")
                $allOrdersList = ProfileModel::getOrdersBySQLString("WHERE `Confirm by User Date` IS NOT NULL
                    AND `Confirm by Admin Date` IS NULL AND `Decline by Admin Date` IS NULL AND `Is Executing Now` 
                    IS NULL ORDER BY `ID Order` ASC LIMIT 10");
            if ($type == "processing")
                $allOrdersList = ProfileModel::getOrdersBySQLString("WHERE `Is Executing Now` IS NOT NULL ORDER BY 
                    `ID Order` ASC");
            if ($type == "archive")
                $allOrdersList = ProfileModel::getOrdersBySQLString("WHERE `Confirm by Admin Date` IS NOT NULL OR 
                    `Decline by Admin Date` IS NOT NULL ORDER BY `ID Order` DESC");
            require_once(ROOT . '/views/profile/accepting.php');
            die;
        }
        else
        {
            require_once(ROOT . '/views/profile/log_in.php');
            die;
        }
    }
}