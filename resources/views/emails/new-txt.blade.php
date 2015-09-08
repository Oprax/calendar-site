<?php $message->subject('Réservation Montesquieu'); ?>
Nouvelle réservation pour Montesquieu

Une réservation vient d'être effectuée par {{ $name }} {{ $forename }} ici : {{ route('reservation.edit', compact('id')) }}.
