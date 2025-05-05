<?php
require_once "./controls/db_connect.php";

// Function to execute INSERT, UPDATE, DELETE queries
function executeQuery($query, $params = [], $types = "")
{
    global $conn;
    $stmt = $conn->prepare($query);

    if ($params) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt;
}

// Function to fetch a single row (SELECT)
function fetchRow($query, $params = [], $types = "")
{
    global $conn;
    $stmt = executeQuery($query, $params, $types);
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Function to fetch multiple rows (SELECT)
function fetchAll($query, $params = [], $types = "")
{
    global $conn;
    $stmt = executeQuery($query, $params, $types);
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>