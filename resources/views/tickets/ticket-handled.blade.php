<!-- resources/views/emails/ticket-handled.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Ticket Assigné</title>
</head>

<body>
    <h1>Ticket Assigné</h1>
    <p>Bonjour,</p>
    <p>Votre ticket "Ticket #{{ $ticket->id }} a été prise en charge par le technicien {{ $technician->user->name }}.</p>
    <p>Merci de votre patience.</p>
</body>

</html>
