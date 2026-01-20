#!/bin/bash

# Exercice 8 : Générer un script simple
# Objectif : Afficher la liste des paramètres par ordre alphabétique.

# On vérifie d'abord si des paramètres ont été passés au script
if [ $# -eq 0 ]; then
    echo "Aucun paramètre n'a été fourni."
    exit 1
fi

echo "Liste des paramètres triés par ordre alphabétique :"

# Explication de la commande ci-dessous :
# 1. printf "%s\n" "$@" : Affiche chaque paramètre ($@) sur une nouvelle ligne.
# 2. | : Utilise un "pipe" pour envoyer cette liste à la commande suivante.
# 3. sort : Trie les lignes reçues par ordre alphabétique.
printf "%s\n" "$@" | sort