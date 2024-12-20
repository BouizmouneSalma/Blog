<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $slug = mysqli_real_escape_string($conn, $_POST['slug']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $author_id = intval($_POST['author_id']);
    $image = mysqli_real_escape_string($conn, $_POST['image']); // Nouveau champ

    $query = "INSERT INTO articles (image,title, slug, content, author_id) 
              VALUES ('$image','$title', '$slug', '$content', $author_id, '$image')";
    if (mysqli_query($conn, $query)) {
        header('Location: dashboard.php?section=articles');
        exit();
    } else {
        echo "Erreur SQL : " . mysqli_error($conn);
    }
}
?>
