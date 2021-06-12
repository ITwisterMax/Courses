<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Create a new post</title>
</head>
<body>
    <h1>Create a new post:</h1>
    <form name="edit" method="POST">
        <a href="index.php">Return</a><br><br>
        <label>Title:</label><br>
        <input type="text" name="title" required><br>
        <label>Description:</label><br>
        <textarea name="description" required></textarea><br>
        <label>Author:</label><br>
        <input type="text" name="author" required><br>
        <label>Category:</label><br>
        <select name="category">{OPTIONS}</select><br>  
        <input type="submit" name="newPost" value="Create post">
    </form>
</body>
</html>
