<?php 
session_start(); //il permet d'enregistrer les informations dans un serveur.
//suivi toute opération faite par le visiteur.

session_unset(); //Il supprime uniquement les variables 
//de la session et la session existe toujours. 
//Seules les données sont tronquées

session_destroy(); //Il détruit toutes les données associées 
//à la session en cours. Il ne désactive aucune des variables 
//globales associées à la session, ni ne désactive le cookie de session.

header("Location: index.php");