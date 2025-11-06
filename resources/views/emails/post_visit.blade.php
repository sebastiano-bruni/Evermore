<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ricordo della visita</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { width: 90%; margin: auto; padding: 20px; }
        .button { background-color: #4f46e5; color: #ffffff; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Ciao {{ $visitor->name }},</h1>
    <p>Grazie per aver visitato il profilo di <strong>{{ $profile->first_name }} {{ $profile->last_name }}</strong>.</p>
    <p>Speriamo che questa esperienza ti abbia portato conforto e ti abbia aiutato a mantenere vivo il ricordo.</p>
    <p>Le connessioni che creiamo sono importanti. Torna a trovarci quando vuoi.</p>
    <br>

    <a href="{{ route('scan') }}" class="button">Esegui un'altra visita</a>

    <br><br>
    <p>Un caro saluto,<br>Il team di Evermore</p>
</div>
</body>
</html>
