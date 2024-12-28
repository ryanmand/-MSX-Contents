<?php
require 'db_config.php';

$search = trim($_GET['search'] ?? '');

$query = "SELECT * FROM news WHERE title LIKE :search ORDER BY published_at DESC";
$stmt = $pdo->prepare($query);
$stmt->execute(['search' => "%$search%"]);

$news = $stmt->fetchAll();

echo "<link rel='stylesheet' href='styles.css'>";
echo "<h1>Notícias</h1>";
echo "<form method='get'>
        <input type='text' name='search' placeholder='Pesquisar...' value='" . htmlspecialchars($search) . "'>
        <button type='submit'>Buscar</button>
      </form>";

if (empty($news)) {
    echo "<p>Nenhuma notícia encontrada.</p>";
} else {
    foreach ($news as $article) {
        echo "<h2><a href='details.php?id={$article['id']}'>{$article['title']}</a></h2>";
        echo "<p>{$article['description']}</p><hr>";
    }
}
?>
