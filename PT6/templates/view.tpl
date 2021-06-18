<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/postsStyle.css">
    <title>Posts list</title>
</head>
<body>
    <div class="left-block">
        <h1>Posts list:</h1>
        {NAVIGATION}
        <ol class="post">
            {ELEMENTS}
        </ol>
        {NAVIGATION}
    </div>
    <div class="right-block">
        <div class="left-container">
            <img src="images/{IMAGE}">
        </div>        
        <div class="right-container">
            <label>Welcome back, {NAME}!</label>
            <form method="POST" action="view.php" name="logoutForm">
                <input type="submit" name="logout" value="Logout">
            </form>
        </div>
    </div>
</body>
</html>
