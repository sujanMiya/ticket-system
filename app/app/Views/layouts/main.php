<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Micro Framework</title>
    <link rel="stylesheet" href="/assets/frontend/css/style.css">
</head>
<body>
    <header>
        <nav>
            <a href="/">Home</a>
            <a href="/about">About</a>
            <a href="/users">Users</a>
        </nav>
    </header>
    
    <main>

@content
    </main>

    <footer>
        &copy; <?= date('Y') ?> Micro Framework
    </footer>
</body>
</html>