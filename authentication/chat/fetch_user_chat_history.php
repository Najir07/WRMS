<?php 

include "chat_functions.php";

session_start();

$user = get_user_data($_SESSION['user_login']);

echo fetch_user_chat_history($user["id"], $_POST["to_user_id"]);

 ?>