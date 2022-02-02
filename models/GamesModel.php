<?php

include_once ROOT . '/components/DBConn.php';

class GamesModel
{


    // Возвращает игру по ID, $index - integer, $name - string
    /**
     * @param $index
     * @param $name
     * @return array
     */
    public static function getGameByIndex($index, $name)
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $gamesList = array();

            // Запрос к базе данных
            try
            {
                $conn->query("SET NAMES utf8;");
                $result = $conn->query("SELECT * FROM games WHERE ID = $index AND Name = '{$name}'");
            }
            catch (Exception $e)
            {
                echo "</br>Такая игра не найдена. Код ошибки: " . $e->getMessage() . "</br>";
                die;
            }

            // Создать массив для жанров, получить жанры по индексу игры и с помощью implode создать из массива
            // полученных данных string
            for ($i = 0; $row = $result->fetch(); $i++)
            {
                $gamesList["Name"] = $row["Name"];
                $gamesList["Date"] = $row["Date"];
                $resultTemp = $conn->query("SELECT Name FROM games_have_genres WHERE
                    ID_Game = $index ORDER BY Name ASC ");
                $genresList = array();
                for ($j = 0; $rowTemp = $resultTemp->fetch(); $j++)
                {
                    $genresList[$j] = $rowTemp["Name"];
                }
                $gamesList["Genres"] = implode(", ", $genresList);

                // Для разработчиков
                $developersList = array();
                $resultTemp = $conn->query("SELECT Name FROM games_have_developers WHERE
                    ID_Game = $index ORDER BY Name ASC ");
                for ($j = 0; $rowTemp = $resultTemp->fetch(); $j++)
                {
                    $developersList[$j] = $rowTemp["Name"];
                }
                $gamesList["Developers"] = implode(", ", $developersList);

                // Для издателей
                $publishersList = array();
                $resultTemp = $conn->query("SELECT Name FROM games_have_publishers WHERE
                    ID_Game = $index ORDER BY Name ASC ");
                for ($j = 0; $rowTemp = $resultTemp->fetch(); $j++)
                {
                    $publishersList[$j] = $rowTemp["Name"];
                }
                $gamesList["Publishers"] = implode(", ", $publishersList);
                if ($row["Series"] != null)
                    $gamesList["Series"] = $row["Series"];
                if ($row["Engine"] != null)
                    $gamesList["Engine"] = $row["Engine"];
                $gamesList["Rating"] = $row["Rating"];
                $gamesList["Number of votings"] = $row["Number_of_votings"];
                $gamesList["Cost"] = $row["Cost"];
                $gamesList["Description"] = $row["Description"];
            }
            $conn = null;
            return $gamesList;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    // Возвращает массив игр

    /**
     * @param $sortBy
     * @param $howTo
     * @param $genres
     * @param $search
     * @param $developers
     * @return array
     */
    public static function getGameList($sortBy, $howTo, $genres, $search,$developers)
    {
        try
        {
            if ($search == "all")
                $search = '';
            if ($genres == "all")
                $genres = '"%"';
            else
            {
                $genres = str_replace("_"," ",$genres);
                $genres = explode("|", $genres);
                for ($i = 0; $i < sizeof($genres); $i++)
                {
                    if ($i == 0)
                        $genres[$i] = '"%'.$genres[$i].'%"';
                    else
                        $genres[$i] = ' OR gage.Name LIKE "%'.$genres[$i].'%"';
                }
                $genres = implode("",$genres);
            }
            if($developers == "all")
                $developers = '"%"';
            else
            {
                $developers = str_replace("_"," ",$developers);
                $developers = explode("|", $developers);
                for ($i = 0; $i < sizeof($developers); $i++)
                {
                    if ($i == 0)
                        $developers[$i] = '"%'.$developers[$i].'%"';
                    else
                        $developers[$i] = ' OR gad.Name LIKE "%'.$developers[$i].'%"';
                }
                $developers = implode("",$developers);
            }
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $gamesList = array();
            // Запрос к базе данных
//            echo "SELECT DISTINCT ga.* FROM messengerschema.games ga
//                JOIN messengerschema.games_have_developers gad ON ga.ID = gad.ID_Game
//                JOIN messengerschema.games_have_genres gage
//                ON ga.ID = gage.ID_Game WHERE (gage.Name LIKE {$genres}) AND (gad.Name LIKE {$developers})
//                AND ga.Name LIKE \"%{$search}%\" ORDER BY ga.{$sortBy} {$howTo};";
            $result = $conn->query("SELECT DISTINCT ga.* FROM messengerschema.games ga 
                JOIN messengerschema.games_have_developers gad ON ga.ID = gad.ID_Game
                JOIN messengerschema.games_have_genres gage 
                ON ga.ID = gage.ID_Game WHERE (gage.Name LIKE {$genres}) AND (gad.Name LIKE {$developers})
                AND ga.Name LIKE \"%{$search}%\" ORDER BY ga.{$sortBy} {$howTo};");
            for ($i = 0; $row = $result->fetch(); $i++)
            {
                $gamesList[$i]["ID"] = $row["ID"];
                $gamesList[$i]["Name"] = $row["Name"];
                $gamesList[$i]["Rating"] = $row["Rating"];
                $gamesList[$i]["Cost"] = $row["Cost"];
            }
            $conn = null;
            return $gamesList;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }


    public static function getUniqueGenres()
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $genresList = array();

            // Запрос к базе данных
            $result = $conn->query("SELECT Name FROM genres ORDER BY Name ASC");
            for ($i = 0; $row = $result->fetch(); $i++)
            {
                $genresList[$i] = $row["Name"];
            }
            $conn = null;
            return $genresList;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }

    public static function getFamousDevelopers()
    {
        try
        {
            $conn = DBConn::getConnection();

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $developersList = array();

            // Запрос к базе данных
            $result = $conn->query("SELECT DISTINCT Name FROM games_have_developers WHERE Name in 
                (SELECT Name FROM games_have_developers GROUP BY Name HAVING COUNT(*)>1) ORDER BY Name ASC;");
            for ($i = 0; $row = $result->fetch(); $i++)
            {
                $developersList[$i] = $row["Name"];
            }
            $conn = null;
            return $developersList;
        }
        catch (PDOException $e)
        {
            echo "Не удалось подключиться к базе данных. Причина :" . $e->getMessage();
        }
    }
}