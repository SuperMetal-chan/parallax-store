<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> Game List </title>
    <link rel="icon" href="../../../../../../../../../../../../images/!!!Icon1!!!.png">
    <link rel="stylesheet" href="../../../../../../../../../../../../templates/default/header_and_footer.css">
</head>
<header>
    <div class="top">
        <a href="http://localhost:8080/games/1" style="text-decoration:none">
            <div class="topname">
                <h1 id="parallax" style="<?php
                if($admin=="1")
                    echo "color: #565dff;"?>">ParallaxStore</h1>
            </div>
        </a>
        <div class="search">
            <form class="searchString" method="POST"
                  action="">
                <img src="../../../../../../../../../../../../images/!!!Search!!!.png"
                     id="searchIcon">
                <input type="search" name="query" id="typeSearch" placeholder="Поиск игр...">
                <button type="submit" id="buttonSearch" style="<?php
                if($admin=="1")
                    echo "background-color: #3d3fff;"?>">
                    <span> Найти </span>
                </button>
            </form>

        </div>
        <div class="profile">
            <img src="
            <?php
            if($admin=="1")
                echo "../../../../../../../../../../../../images/!!!Profile1!!!.svg";
            else
                echo "../../../../../../../../../../../../images/!!!Profile!!!.png";?>"
                 id="profileIcon">
            <a href="http://localhost:8080/<?php
            if(!empty($_SESSION['ID']))
                echo "profile/".$_SESSION['ID'];
            else
                echo "log_in";
            ?>"><button type="button" id="buttonProfile" style="<?php
                if($admin=="1")
                    echo "color: #6865fc;"?>">
                <span><?php
                    if(!empty($username))
                        echo $username;
                    else
                        echo "Войти";
                    ?></span>
            </button></a>
        </div>
    </div>
</header>
