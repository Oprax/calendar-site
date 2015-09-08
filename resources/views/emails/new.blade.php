<?php $message->subject('Réservation Montesquieu'); ?>
<html lang="fr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
    <h2>Nouvelle réservation pour Montesquieu</h2>
    <br />
    <p>
        Une réservation vient d'être effectuée par {{ $name }} {{ $forename }} 
        <a href="{{ route('reservation.edit', compact('id')) }}">ici</a>.
    </p>
</body>