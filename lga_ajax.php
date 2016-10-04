<?php
require 'inc/Database.php';
$database = new Database();
if(isset($_GET['query']) && $_GET['query'] == "load_lga" && intval($_GET['state']) != 0){
    $state = intval($_GET['state']);
    $query = $database->query("SELECT * FROM lga WHERE state_id={$state}");
    $options = "";
    while ($lga = mysqli_fetch_array($query)) {
        $options .= "<option value=\"{$lga['id']}\">{$lga['name']}</option>";
    }
    echo $options;
}