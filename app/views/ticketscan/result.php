<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Ticket Resultaat</title>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .result-container {
            background: rgba(255,255,255,0.96);
            padding: 2.5em 2em 2em 2em;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(44,62,80,0.12);
            text-align: center;
            max-width: 350px;
            width: 100%;
        }
        h1 {
            color: #185a9d;
            margin-bottom: 1.5em;
            font-size: 2em;
        }
        .alert {
            padding: 1.1em;
            border-radius: 8px;
            font-size: 1.18em;
            margin-bottom: 1.6em;
            font-weight: 500;
            border: 1.5px solid #eee;
        }
        .alert.success {
            background: #e9faf1;
            color: #157347;
            border-color: #b0e6ca;
        }
        .alert.error {
            background: #fff0f0;
            color: #c0392b;
            border-color: #f5b7b1;
        }
        a.button {
            display: inline-block;
            background: linear-gradient(90deg, #43cea2 0%, #185a9d 100%);
            color: #fff;
            text-decoration: none;
            padding: 0.7em 2em;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(44,62,80,0.10);
            transition: background 0.2s, transform 0.16s;
        }
        a.button:hover, a.button:focus {
            background: linear-gradient(90deg, #185a9d 0%, #43cea2 100%);
            transform: scale(1.03);
        }
    </style>
</head>
<body>
    <div class="result-container">
        <h1>Resultaat</h1>
        <div class="alert <?= htmlspecialchars($status) ?>">
            <?= htmlspecialchars($message) ?>
        </div>
        <a href="index.php" class="button">Nog een ticket scannen</a>
    </div>
</body>
</html>