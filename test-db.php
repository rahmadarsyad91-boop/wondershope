<?php
$host = "db.aymswijpiftffrenbqar.supabase.co";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "Rahmadvincill";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    echo "SUCCESS: Rahmadvincill\n";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

$password = "[Rahmadvincill]";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
    echo "SUCCESS: [Rahmadvincill]\n";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
