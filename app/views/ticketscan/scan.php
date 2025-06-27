<?php require_once APPROOT . '/views/includes/navbar.php'; ?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Scan je ticket</title>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #6a82fb 0%, #fc5c7d 100%);
            margin: 0;
        }
        .ticket{
            margin-top: 20vh;
            font-family: 'Segoe UI', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ticket-container {
            background: rgba(255,255,255,0.95);
            padding: 2.5em 2em 2em 2em;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(44,62,80,0.15);
            text-align: center;
            max-width: 350px;
            width: 100%;
        }
        h1 {
            color: #374151;
            margin-bottom: 1.5em;
            font-size: 2em;
            font-weight: 700;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 1em;
        }
        input[type="text"] {
            padding: 0.8em 1em;
            border: 1px solid #b0b8c1;
            border-radius: 8px;
            font-size: 1.1em;
            outline: none;
            transition: border 0.2s;
        }
        input[type="text"]:focus {
            border: 1.5px solid #6a82fb;
        }
        button {
            background: linear-gradient(90deg, #6a82fb 0%, #fc5c7d 100%);
            color: #fff;
            padding: 0.8em 0;
            border: none;
            border-radius: 8px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }
        button:hover, button:focus {
            background: linear-gradient(90deg, #fc5c7d 0%, #6a82fb 100%);
            transform: translateY(-2px) scale(1.03);
        }
    </style>
</head>
<body>
    <div class="ticket">
    <div class="ticket-container">
        <h1>Scan je ticket!</h1>
        <form method="post" action="index.php?controller=ticketscan&action=validate">
            <input type="text" name="code" placeholder="Voer ticketcode in" required autofocus>
            <button type="submit">Check ticket</button>
        </form>
    </div>
    </div>
</body>
</html>