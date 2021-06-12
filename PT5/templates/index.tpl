<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Posts list</title>
</head>
<body>
    <h1>Posts list:</h1>
    <ol class="post">
        {ELEMENTS}
    </ol>
    <form method="POST" action="create.php">
        <input type="submit" name="newPost" value="Create a new post">
    </form>
</body>
</html>
