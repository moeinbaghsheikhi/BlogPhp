<?php
require_once "../config/loader.php";

if(!isset($_GET['user_id']) || !isset($_GET['post_id'])) header("Location: ../index.php");

$user_id = $_GET['user_id'];
$post_id = $_GET['post_id'];

$sql = "INSERT INTO save_post SET user_id=?, post_id=?";

$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $user_id);
$stmt->bindValue(2, $post_id);
$result = $stmt->execute();

if($result) header("Location: ../index.php?save-post=true");