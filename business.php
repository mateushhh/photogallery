<?php

function get_db()
{
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);

    $db = $mongo->wai;

    return $db;
}

function showTable()
{
    $db = get_db();
    $collection = $db->photos;
    $cursor = $collection->find();

    echo '<table border="1">';
    echo '<tr><th>Author</th><th>Title</th><th>Filename</th></tr>';

    foreach ($cursor as $document) {
        echo '<tr>';
        echo '<td>' . $document['title'] . '</td>';
        echo '<td>' . $document['author'] . '</td>';
        echo '<td>' . $document['file_name'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

function showUsers()
{
    $db = get_db();
    $collection = $db->users;
    $cursor = $collection->find();

    echo '<table border="1">';
    echo '<tr><th>Login</th><th>Password</th></tr>';

    foreach ($cursor as $document) {
        echo '<tr>';
        echo '<td>' . $document['login'] . '</td>';
        echo '<td>' . $document['password'] . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}

function save_photo_data($author, $title, $file_name)
{
    $db = get_db();

    $photoData = [
        'author' => $author,
        'title' => $title,
        'file_name' => $file_name,
    ];

    $collection = $db->photos;
    $collection->insertOne($photoData);
}

function get_photo_info($file_name)
{
    $db = get_db();

    $collection = $db->photos;
    $photoData = $collection->findOne(['file_name' => $file_name]);

    return $photoData;
}

function register_user($login, $password)
{
    if (user_exists($login)) {
        return false;
    }

    $db = get_db();

    $userData = [
        'login' => $login,
        'password' => password_hash($password, PASSWORD_DEFAULT),
    ];

    $collection = $db->users;
    $collection->insertOne($userData);

    return true;
}

function user_exists($login)
{
    $db = get_db();
    $collection = $db->users;

    $existingUser = $collection->findOne(['login' => $login]);

    if (!empty($existingUser)) {
        return true;
    }
    return false;
}

function validate_login($login, $password)
{
    $db = get_db();
    $collection = $db->users;

    $user = $collection->findOne(['login' => $login]);

    if (!empty($user) && password_verify($password, $user['password'])) {
        return true;
    }

    return false;
}

