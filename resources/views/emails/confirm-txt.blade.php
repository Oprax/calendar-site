<?php $message->subject('Réservation Montesquieu'); ?>
Bonjour {{ $name }} {{ $forename }},

Votre réservation du {{ $arrive_at }} au {{ $leave_at }} a été validé.


Résumé de votra réservation : {{ route('reservations.show', compact('id')) }}.

