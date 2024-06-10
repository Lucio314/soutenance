<!DOCTYPE html>
<html>
<head>
    <title>Nouveau Ticket</title>
</head>
<body>
    <p>Un nouveau ticket a été créé.</p>
    <p>ID du ticket: {{ $ticket->id }}</p>
    <p>Objet: {{ $ticket->object }}</p>
    <p>Catégorie de problème: {{ $ticket->problemCategory->name }}</p>
    <p>Application: {{ $ticket->application->app_name }}</p>
    <p>Merci de prendre en charge ce ticket dès que possible.</p>
    <p><a href="{{ url('/tickets/' . $ticket->id) }}">Voir le ticket</a></p>
</body>
</html>
