<?php
include 'includes/db.php'; // Connexion à la base de données

$query = "SELECT * FROM articles ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des Articles</title>
  <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
</head>

<body>
  <div class="container mx-auto p-6">
    <h1 class="text-xl font-bold mb-4">Liste des Articles</h1>

    <a href="ajouter-article.php" class="bg-blue-500 hover:bg-blue-700 text-white font-medium rounded-lg text-sm px-5 py-2.5 mb-4 inline-block">Ajouter un nouvel article</a>

    <div class="space-y-4">
      <?php while ($article = mysqli_fetch_assoc($result)): ?>
        <div class="p-4 border border-gray-300 rounded-lg">
          <h2 class="text-lg font-bold"><?= htmlspecialchars($article['title']) ?></h2>
          <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
          <p class="text-sm text-gray-500">Publié le <?= $article['created_at'] ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>

</html>
