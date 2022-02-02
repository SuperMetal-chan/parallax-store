<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> ParallaxStore </title>
    <link rel="stylesheet" href="../../../../../../../../../../../../templates/games/list/styles.css">
</head>
<?php include ROOT . '../views/default/headerList.php' ?>

<body>

<div class="sort">
    <p id="sortBy">Сортировать игры по:</p>
    <span style="margin-left:45px;"><a href="http://localhost:8080/games/<?php
    if ($sort == "Cost" && $howTo == "ASC")
        echo "1/sort/Cost/by/DESC/genres/$genres/search/$search";
    else
        echo "1/sort/Cost/by/ASC/genres/$genres/search/$search";
    ?>">
        <button type="button" id="buttonSort">
        <span>Цене
          <img src="../../../../../../../../../../../../images/!!!Sort!!!.png"
               id="sortIcon"></button>
        </a></span>
    </span>
    <span style="margin-left:45px;"><a href="http://localhost:8080/games/<?php
    if ($sort == "Date" && $howTo == "ASC")
        echo "1/sort/Date/by/DESC/genres/$genres/search/$search";
    else
        echo "1/sort/Date/by/ASC/genres/$genres/search/$search";
    ?>">
        <button type="button" id="buttonSort">
        <span>Дате выхода
          <img src="../../../../../../../../../../../../images/!!!Sort!!!.png"
               id="sortIcon"></button>
        </a></span>
    </span>
    <span style="margin-left:45px;"><a href="http://localhost:8080/games/<?php
    if ($sort == "Rating" && $howTo == "ASC")
        echo "1/sort/Rating/by/DESC/genres/$genres/search/$search";
    else
        echo "1/sort/Rating/by/ASC/genres/$genres/search/$search";
    ?>">
        <button type="button" id="buttonSort">
        <span>Рейтингу
          <img src="../../../../../../../../../../../../images/!!!Sort!!!.png"
               id="sortIcon"></button>
        </a></span>
    </span>
    <span style="margin-left:45px;"><a href="http://localhost:8080/games/<?php
    if ($sort == "Number_of_votings" && $howTo == "ASC")
        echo "1/sort/Number_of_votings/by/DESC/genres/$genres/search/$search";
    else
        echo "1/sort/Number_of_votings/by/ASC/genres/$genres/search/$search";
    ?>">
        <button type="button" id="buttonSort">
        <span>Популярности
          <img src="../../../../../../../../../../../../images/!!!Sort!!!.png"
               id="sortIcon"></button>
    </a></span>
    </span></span>
</div>
<div class="genres">
    <p style="background-color: #748484; padding-left:5px; margin-right: 5px; border-radius: 8px;
        margin-left: -10px;">Известные разработчики: </p><?php foreach ($developersList

                                                                        as $developer): ?>
        <label id="container" style="<?php
        echo " ";
        ?>" class="<?php echo $developer; ?>"><?php echo $developer; ?>
            <input>
            <a href="http://localhost:8080/games/<?php
            $developer = str_replace(" ", "_", $developer);
            $developerTemp = $developer;
            $developersTemp = $developers;
            if (strpos($developersTemp, $developerTemp) === false && $developersTemp !== $developerTemp)
            {
                if ($developersTemp == "all")
                    echo "1/sort/$sort/by/$howTo/genres/$genres/search/$search/developers/$developerTemp";
                else
                    echo "1/sort/$sort/by/$howTo/genres/$genres/search/$search/developers/$developersTemp|$developerTemp";
            }
            else
            {
                if (strpos($developersTemp, "|" . $developerTemp) !== false)
                    $developersTemp = str_replace("|" . $developerTemp, "", $developersTemp);
                else if (strpos($developersTemp, $developerTemp . "|") !== false)
                    $developersTemp = str_replace($developerTemp . "|", "", $developersTemp);
                else if ($developersTemp == $developerTemp)
                    $developersTemp = str_replace($developerTemp, "all", $developersTemp);
                echo "1/sort/$sort/by/$howTo/genres/$genres/search/$search/developers/$developersTemp";
            }
            ?>"><span id="checkmark" style="<?php
                if (strpos($developers, $developer) !== false || $developers == $developer)
                    echo "background-color:#FC4D2F;";
                ?>"><?php
                    if (strpos($developers, $developer) !== false || $developers == $developer)
                        echo "<img id=\"genreIcon\" 
                                    src=\"../../../../../../../../../../../../images/!!!Checked!!!.svg\">";
                    ?></span></a>
        </label>
    <?php endforeach; ?>
    <p style="background-color: #748484; padding-left:5px; margin-right: 5px; border-radius: 8px;
        margin-left: -10px;">Жанры: </p>
    <?php foreach ($genresList

                   as $genre): ?>
        <label id="container" style="<?php
        echo " ";
        ?>" class="<?php echo $genre; ?>"><?php echo $genre; ?>
            <input>
            <a href="http://localhost:8080/games/<?php
            $genre = str_replace(" ", "_", $genre);
            $genreTemp = $genre;
            $genresTemp = $genres;
            if (strpos($genresTemp, $genreTemp) === false && $genresTemp !== $genreTemp)
            {
                if ($genresTemp == "all")
                    echo "1/sort/$sort/by/$howTo/genres/$genreTemp/search/$search";
                else
                    echo "1/sort/$sort/by/$howTo/genres/$genresTemp|$genreTemp/search/$search";
            }
            else
            {
                if (strpos($genresTemp, "|" . $genreTemp) !== false)
                    $genresTemp = str_replace("|" . $genreTemp, "", $genresTemp);
                else if (strpos($genresTemp, $genreTemp . "|") !== false)
                    $genresTemp = str_replace($genreTemp . "|", "", $genresTemp);
                else if ($genresTemp == $genreTemp)
                    $genresTemp = str_replace($genreTemp, "all", $genresTemp);
                echo "1/sort/$sort/by/$howTo/genres/$genresTemp/search/$search";
            }
            ?>"><span id="checkmark" style="<?php
                if (strpos($genres, $genre) !== false || $genres == $genre)
                    echo "background-color:#FC4D2F;";
                ?>"><?php
                    if (strpos($genres, $genre) !== false || $genres == $genre)
                        echo "<img id=\"genreIcon\" src=\"../../../../../../../../../../../../images/!!!Checked!!!.svg\">";
                    ?></span></a>
        </label>
    <?php endforeach; ?>
    <a href="http://localhost:8080/games/<?php
    echo "1/sort/$sort/by/$howTo/search/$search";
    ?>">
        <button type="button" id="buttonGenres">
            <span>Сбросить всё</button>
    </a>
</div>
<div class="list">
    <div class="currentSearch" <?php
    if ($search == "all" || $search == "")
        echo 'style = "display:none;"';
    ?>>
        <p id="currentSearchString">
            Отображены игры по запросу "<?php
            echo $search;
            ?>"
            <a href="http://localhost:8080/games/<?php
            echo "1/sort/$sort/by/$howTo/genres/$genres/search/all";
            ?>">
                <button type="button" id="buttonDropSearch">
                    <span>Сбросить поиск</button>
            </a>
            </span>
        </p>
    </div>
    <table id="table">
        <?php for ($i = 0 + ($page - 1) * 5;
        $i < 5 + ($page - 1) * 5;
        $i++):
        if (empty($gamesList[$i * 3]['ID'])) break;
        ?>
        <tr id="row1">
            <?php for ($j = 0;
                       $j < 3;
                       $j++):
            if (empty($gamesList[$i * 3 + $j]['ID'])) break 2;
            ?>
            <td id="col1">
                <a href="http://localhost:8080/games/<?php echo $gamesList[$i * 3 + $j]['ID'] . '-' .
                    str_replace(":", "_",
                        str_replace(" ", "-", $gamesList[$i * 3 + $j]['Name'])); ?>">
                    <img class="innercontent" src="../../../../../../../../../../../../images/<?php
                    echo str_replace(":", "", $gamesList[$i * 3 + $j]['Name']); ?>.jpg" id="gamePhoto">
                </a>
                <p class="innercontent" id="gameName"><?php echo $gamesList[$i * 3 + $j]['Name']; ?> </p>
                <span class="innercontent" id="rating1">⍟</span>
                <p class="innercontent" id="rating"><?php echo $gamesList[$i * 3 + $j]['Rating']; ?></p>
                <span class="innercontent" id="cost1">грн.</span>
                <p class="innercontent" id="cost"><?php echo $gamesList[$i * 3 + $j]['Cost']; ?></p>
                <?php endfor; ?>
            </td>
            <?php endfor; ?>
        </tr>
    </table>
    <div class="pages" <?php
    if (sizeof($gamesList) == 0)
        echo 'style = "display:none;"';
    ?>>
            <span>
                <div id=#anotherPage class="previousPage" style="<?php if ($page == 1) echo "opacity: 0.25;
                 cursor: inherit"; ?>">
                    <a <?php if ($page > 1)
                        echo "href=http://localhost:8080/games/" . strval($page - 1) . "/sort/$sort/by/$howTo" .
                            "/genres/$genres/search/$search"; ?>>
                        <img src="../../../../../../../../../../../../images/!!!Previous!!!.svg"></a>
                </div>
                <div id=#anotherPage class="nextPage" style="<?php if ($page >= (sizeof($gamesList) / 15))
                    echo "opacity: 0.25; cursor: inherit"; ?>">
                    <a <?php if ($page < (sizeof($gamesList) / 15))
                        echo "href=http://localhost:8080/games/" . strval($page + 1) . "/sort/$sort/by/$howTo" .
                            "/genres/$genres/search/$search"; ?>>
                        <img src="../../../../../../../../../../../../images/!!!Next!!!.svg"></a>
                </div>
            </span>
    </div>
</div>
</body>
<?php include ROOT . '../views/default/footer.php' ?>
</html>
