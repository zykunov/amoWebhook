<?php

require_once(__DIR__ . "/makeRequest.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $subdomain = 'izykunov'; //Поддомен моего аккаунта

    /* 1 - авторизация */
    /* Долгосрочный токен */
    $filename = __DIR__ . '/token.txt';
    $accessToken = file_get_contents($filename);

    /* 2 Добавление текстового примечания */
    $entityId = $_POST["leads"]["add"][0]["id"];
    $dealName = $_POST["leads"]["add"][0]["name"];
    $createdUserId = $_POST["leads"]["add"][0]["created_user_id"];
    $timeCreated = date("d/m/y H:i", $_POST["leads"]["add"][0]["date_create"]);
    $createdUserName = getUser($accessToken, $createdUserId);

    $link = "https://" . $subdomain . ".amocrm.ru/api/v4/leads/$entityId/notes";

    $data = [[
        "note_type" => "common",
        "params" => [
            "text" => "Создана сделка: $dealName, ответственный $createdUserName, время - $timeCreated" //то текстовое примечание должно содержать название сделки/контакта, ответственного и время добавления карточки
        ]]
    ];

    addNote($accessToken, $link, $data);

}



