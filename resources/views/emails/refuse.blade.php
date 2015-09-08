<?php $message->subject('Réservation Montesquieu'); ?>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <h2>Réservation pour Montesquieu</h2>
    <br />
    <p>
        Bonjour {{ $name }} {{ $forename }},
        <br />
        <br />
        Votre réservation du {{ $arrive_at }} au {{ $leave_at }} a été refusé.
    </p>
</body>