<?php

use ProfileModel;

include_once ROOT . '/models/GamesModel.php';
include_once ROOT . '/models/ProfileModel.php';


class GamesController
{
    /**
     * @param $index
     * @param $name
     * @return bool
     */
    public function actionView($index, $name)
    {
        if ($index && $name)
        {
            $userID = ProfileModel::checkLoggedID("");
            $admin = ProfileModel::checkIfAdmin($userID);
            $username = ProfileModel::checkLoggedName("");
            if(isset($_POST['basket']))
                ProfileModel::addToBasket($userID,$index);
            $display = true;
            if(ProfileModel::checkIfInBasket($userID,$index))
                $display = false;
            $name = str_replace("-", " ", $name);
            $name = str_replace("_", ":", $name);
            $name = str_replace("'", "\'", $name);
            $gameList = GamesModel::getGameByIndex($index, $name);
        }
        require_once(ROOT . '/views/games/item.php');

        return true;
    }

    /**
     * @param $page
     * @param $SORT
     * @param $sort
     * @param $BY
     * @param $howTo
     * @param $GENRES
     * @param $genres
     * @param $SEARCH
     * @param $search
     * @return string
     */
    public function actionList($page, $SORT, $sort, $BY, $howTo, $GENRES, $genres, $SEARCH, $search,$DEVELOPERS,
        $developers)
    {
        $userID = ProfileModel::checkLoggedID("");
        $admin = ProfileModel::checkIfAdmin($userID);
        $username = ProfileModel::checkLoggedName("");
        if (isset($_POST['query']))
            $search = $_POST['query'];

        $gamesList = GamesModel::getGameList($sort, $howTo, $genres, $search,$developers);
        $genresList = GamesModel::getUniqueGenres();
        $developersList = GamesModel::getFamousDevelopers();
        require_once(ROOT . '/views/games/index.php');
        return true;
    }
}