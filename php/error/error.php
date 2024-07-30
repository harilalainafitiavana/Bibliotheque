<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon site web</title>
    <style>
        body {
            display: flex;
            text-align: center;
            justify-content: center;
            margin-top: 40px;
        }
        .p {
            background: #fff;
            padding: 16px;
            height: 150px; 
            color: #000;
            border-radius: 8px;
            font-size: 20px;
            text-align: center;
            width: 50%;
        }
        .alerte {
            margin-right: 700px;
            font-size: 30px;
            color: red;
            margin-top: 0px;
        }
        a {
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body style="background-image: url(../images/Silent\ Forest\ 2.gif)">
    <div class="p">
        <p class="alerte">Alerte</p>
        <p><?php echo $message; ?></p>
        <p><a href=<?php echo $link; ?>>Réessayer</a></p>
    </div>
    
</body>
</html>