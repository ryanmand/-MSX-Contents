<?php
require 'db_config.php';

echo "<link rel='stylesheet' href='styles.css'>";

// Configuração da API
$apiKey = "0f98665aa62145b7a0c6a9c1af085cdc";
$baseUrl = "https://newsapi.org/v2/top-headlines";
$country = "br";

$url = "$baseUrl?country=$country&apiKey=$apiKey";

$response = file_get_contents($url);
$newsData = json_decode($response, true);

if ($newsData['status'] === 'ok') {
    $articles = $newsData['articles'];
    $count = 0;

    foreach ($articles as $article) {
        $title = $article['title'];
        $description = $article['description'] ?? "Sem descrição";
        $url = $article['url'];
        $publishedAt = date('Y-m-d H:i:s', strtotime($article['publishedAt']));

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM news WHERE title = :title");
        $stmt->execute(['title' => $title]);

        if ($stmt->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO news (title, description, url, published_at) VALUES (:title, :description, :url, :published_at)");
            $stmt->execute([
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'published_at' => $publishedAt
            ]);
            $count++;
        }
    }

    echo "<p>Foram salvas <strong>$count</strong> novas notícias!</p>";
} else {
    echo "<p>Erro ao buscar notícias: " . htmlspecialchars($newsData['message']) . "</p>";
}
?>
