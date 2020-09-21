<?php 
/** 
 * Returns values from config assoc array
 * @param string $key name of key in config array
 * @return string|array the string value or array of values
**/
function config($key=''){
    $config = [
        "site_url" => dirname($_SERVER['PHP_SELF']),
        "page_name" => "Słówka",
        "version" => "1.0 (stable)",
        "author" => "Kajetan Nowak 4C ZSK",
        "comp_path" => "components",
        "utils_path" => "utils",
        "css_path" => "css",
        "menu" => [
            //url => title
            "categories" => "Lista Słówek",
            "word" => "Losowe Słowo",
            "fill" => "Uzupełnianie",
            "memo" => "Memo"
            //"setlangs" => "Domyślne języki"

        ],
        "admin_menu" => [
            "admin/add_word" => "Dodaj Słowo",
            "admin/add_translation" => "Dodaj Tłumaczenie",
            "admin/add_photo" => "Dodaj Zdjęcie",
            "admin/users" => "Użytkownicy",
            "admin/groups" => "Grupy",
        ],
        "permissions" => [
            0 => ['','index','home','login', 'logout','register', '404'],
            'admin' => ['admin', 'admin/add_word', 'add_word']
        ]
    ];
    return isset($config[$key]) ? $config[$key] : null;
}

?>