<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Example Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        p {
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Hello, World!</h1>
    <p>This is an example template.</p>
    <p><?= $meta['content'] ?? '' ?></p>
    <?= \basetemplate\ThemeWizard::Qr()->generate_code("https://www.marketport.de") ?>
</div>
</body>
</html>