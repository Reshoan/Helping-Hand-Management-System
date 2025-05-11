<?php
$sql = "SELECT 1 FROM DUAL";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo "Connection test successful!";
} else {
    echo "Connection test failed!";
}
