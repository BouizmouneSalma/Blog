<?php
include 'includes/db.php'; // Connexion à la base de données

// Récupération de la section dynamique
$section = $_GET['section'] ?? 'users'; // Section par défaut : users

$data = [];
if ($section === 'users') {
    $query = "SELECT users.id, users.name, users.email, roles.name AS role 
              FROM users 
              LEFT JOIN roles ON users.role_id = roles.id";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
} elseif ($section === 'articles') {
    $query = "SELECT articles.id, articles.title, articles.slug, users.name AS author, articles.comments_count 
              FROM articles 
              LEFT JOIN users ON articles.author_id = users.id";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
<header class="p-4 bg-white shadow">
    <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
</header>
<div class="flex">
    <!-- Sidebar -->
    <aside class="w-64 bg-green-800 text-gray-200 min-h-screen">
        <nav class="mt-6">
            <a href="?section=users" class="block w-full px-4 py-2 text-sm hover:bg-blue-600">Users</a>
            <a href="?section=articles" class="block w-full px-4 py-2 text-sm hover:bg-green-600">Articles</a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <header class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Manage <?= ucfirst($section) ?></h2>
            <?php if ($section === 'articles'): ?>
                <button onclick="openModal()" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Ajouter un article
                </button>
            <?php endif; ?>
        </header>
        <div class="bg-white rounded shadow-md p-4">
            <?php if (!empty($data)): ?>
                <table class="min-w-full table-auto border border-gray-300">
                    <thead>
                        <tr>
                            <?php foreach (array_keys($data[0]) as $key): ?>
                                <th class="px-4 py-2 border"><?= ucfirst($key) ?></th>
                            <?php endforeach; ?>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <?php foreach ($row as $cell): ?>
                                    <td class="px-4 py-2 border"><?= htmlspecialchars($cell) ?></td>
                                <?php endforeach; ?>
                                <td class="px-4 py-2 border">
                                    <button class="text-blue-500">Edit</button>
                                    <button class="text-red-500">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-gray-500">No data available.</p>
            <?php endif; ?>
        </div>
    </main>
</div>

<!-- Modal -->
<div id="addArticleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-2xl font-semibold mb-4">Ajouter un article</h2>
        <form method="POST" action="add_article.php">
            <div class="mb-4">
                <label for="title" class="block">Titre</label>
                <input type="text" id="title" name="title" class="block w-full border rounded" required>
            </div>
            <div class="mb-4">
                <label for="slug" class="block">Slug</label>
                <input type="text" id="slug" name="slug" class="block w-full border rounded" required>
            </div>
            <div class="mb-4">
                <label for="content" class="block">Contenu</label>
                <textarea id="content" name="content" class="block w-full border rounded" required></textarea>
            </div>
            <div class="mb-4">
                <label for="author" class="block">Auteur</label>
                <select id="author" name="author_id" class="block w-full border rounded" required>
                    <?php
                    $users = mysqli_query($conn, "SELECT id, name FROM users");
                    while ($user = mysqli_fetch_assoc($users)) {
                        echo "<option value='{$user['id']}'>{$user['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
    <label for="image" class="block text-sm font-medium text-gray-700">Image (URL)</label>
    <input type="text" id="image" name="image" class="mt-1 block w-full rounded border-gray-300" required>
</div>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Ajouter</button>
            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-500 text-white rounded">Annuler</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('addArticleModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('addArticleModal').classList.add('hidden');
    }
</script>
</body>
</html>
