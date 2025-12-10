<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ Вход</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        h1 { margin: 0 0 10px 0; color: #1e293b; }
        p { color: #64748b; margin-bottom: 30px; }
        
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input[type="password"]:focus {
            border-color: #2563eb;
            outline: none;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover { background-color: #1d4ed8; }
        
        .error {
            background-color: #fee2e2;
            color: #b91c1c;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }
        .home-link {
            display: block;
            margin-top: 20px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9em;
        }
        .home-link:hover { color: #2563eb; }
    </style>
</head>
<body>
    <div class="login-card">
        <h1>Добре дошли</h1>
        <p>Моля, въведете парола за достъп</p>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="index.php?url=admin/login" method="POST">
            <input type="password" name="password" placeholder="Парола" required autofocus>
            <button type="submit">Влез в системата</button>
        </form>
        
        <a href="index.php" class="home-link">← Обратно към сайта</a>
    </div>
</body>
</html>