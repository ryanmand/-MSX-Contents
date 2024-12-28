<?php
require 'db_config.php';

$id = $_GET['id'] ?? 0;

$query = "SELECT * FROM news WHERE id = :id";
$stmt = $pdo->prepare($query);
$stmt->execute(['id' => $id]);

$article = $stmt->fetch();

if ($article) {
    echo "<link rel='stylesheet' href='styles.css'>";
    echo "<h1>{$article['title']}</h1>";
    echo "<p><strong>Publicado em:</strong> {$article['published_at']}</p>";
    echo "<p>{$article['description']}</p>";
    echo "<a href='{$article['url']}' target='_blank'>Leia mais</a>";
} else {
    echo "<p>Notícia não encontrada.</p>";
}
?>
