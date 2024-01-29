<?php
require_once "../config/loader.php";

if(!isset($_GET['user_id']) || !isset($_GET['post_id'])) header("Location: ../index.php");

$user_id = $_GET['user_id'];
$post_id = $_GET['post_id'];

$sql = "DELETE FROM like_post WHERE user_id=? AND post_id=?";

$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $user_id);
$stmt->bindValue(2, $post_id);
$result = $stmt->execute();

if($result) header("Location: ../index.php?like-post=true");