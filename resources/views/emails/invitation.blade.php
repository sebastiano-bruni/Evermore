<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invito Contatto Fidato</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { width: 90%; margin: auto; padding: 20px; }
        .button { background-color: #4f46e5; color: #ffffff; padding: 10px 15px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container">
    <h1>Ciao!</h1>
    <p>L'utente <strong>{{ $inviter->name }}</strong> ({{ $inviter->email }}) ti ha invitato a diventare un suo Contatto Fidato sull'applicazione Evermore.</p>
    <p>In qualità di Contatto Fidato, avrai la responsabilità di attivare il suo profilo commemorativo digitale in caso di sua scomparsa.</p>
    <p>Per accettare questo invito, devi essere registrato su Evermore con questa stessa email ({{ $contact->email }}) e cliccare sul link qui sotto:</p>
    <br>

    <a href="{{ URL::temporarySignedRoute('contacts.accept', now()->addDays(7), ['contact' => $contact->id]) }}" class="button">Accetta l'invito</a>

    <br><br>
    <p>Se non hai richiesto questo invito, puoi ignorare questa email.</p>
    <p>Grazie,<br>Il team di Evermore</p>
</div>
</body>
</html>
