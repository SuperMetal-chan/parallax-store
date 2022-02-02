<?php

return array
(
    "games/([0-9]+)-([a-zA-Z-]+)" => "games/view/$1/$2", // actionView from GamesController

    "games/([0-9]+)/sort/([a-zA-Z_]+)/by/([a-zA-Z]+)/genres/([0-9a-zA-Z-_|]+)/search/([0-9a-zA-Z]+)/developers/([0-9a-zA-Z]+)"
        => "games/list/$1/sort/$2/by/$3/genres/$4/search/$5/developers/$6",

    "games/([0-9]+)/sort/([a-zA-Z_]+)/by/([a-zA-Z]+)/genres/([0-9a-zA-Z-_|]+)/search/([0-9a-zA-Z]+)" =>
        "games/list/$1/sort/$2/by/$3/genres/$4/search/$5/developers/all",

    "games/([0-9]+)/sort/([a-zA-Z_]+)/by/([a-zA-Z]+)/genres/([0-9a-zA-Z-_|]+)" =>
        "games/list/$1/sort/$2/by/$3/genres/$4/search/all/developers/all",

    "games/([0-9]+)/sort/([a-zA-Z_]+)/by/([a-zA-Z]+)/search/([0-9a-zA-Z]+)" =>
        "games/list/$1/sort/$2/by/$3/genres/all/search/$4/developers/all",

    "games/([0-9]+)/genres/([0-9a-zA-Z-_|]+)/search/([0-9a-zA-Z]+)" =>
        "games/list/$1/sort/ID/by/DESC/genres/$2/search/$3/developers/all",

    "games/([0-9]+)/search/([0-9a-zA-Z]+)" => "games/list/$1/sort/ID/by/DESC/genres/all/search/$2/developers/all",

    "games/([0-9]+)/genres/([0-9a-zA-Z-_|]+)" => "games/list/$1/sort/ID/by/DESC/genres/$2/search/all/developers/all",

    "games/([0-9]+)/sort/([a-zA-Z_]+)/by/([a-zA-Z]+)" =>
        "games/list/$1/sort/$2/by/$3/genres/all/search/all/developers/all",

    "games/([0-9]+)" => "games/list/1/sort/ID/by/DESC/genres/all/search/all/developers/all",

    "games" => "games/list/1/sort/ID/by/DESC/genres/all/search/all/developers/all",

    "profile/([0-9]+)" => "profile/view/$1",

    "profile" => "profile/view/1",

    "order/([0-9]+)" => "profile/order/$1",

    "log_in" => "profile/log_in",

    "sign_up" => "profile/sign_up",

    "exit" => "profile/exit",

    "accepting/([a-zA-Z]+)" => "profile/accepting/$1",

    "accepting" => "profile/accepting/new",

    "" => "games/list/1/sort/ID/by/DESC/genres/all/search/all/developers/all",
);