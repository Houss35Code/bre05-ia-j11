<?php

/*
    Exercice 9 : générer une fonction simple.
    Demander à une IA de générer une fonction PHP qui prend un nombre inconnu et illimité d'arguments et les affiche.
*/

function afficherArguments(...$arguments)
{
    // Vérifie s'il y a des arguments
    if (empty($arguments)) {
        echo "Aucun argument fourni.\n";
        return;
    }
    
    // Affiche chaque argument
    foreach ($arguments as $index => $argument) {
        echo "Argument " . ($index + 1) . " : " . $argument . "\n";
    }
}

// Exemples d'utilisation :
afficherArguments("Bonjour", "le", "monde");
echo "\n";

afficherArguments(1, 2, 3, 4, 5);
echo "\n";

afficherArguments("PHP", 2024, true, 3.14);
echo "\n";

afficherArguments();  // Aucun argument

?>
```

## Résultat attendu :
```
Argument 1 : Bonjour
Argument 2 : le
Argument 3 : monde

Argument 1 : 1
Argument 2 : 2
Argument 3 : 3
Argument 4 : 4
Argument 5 : 5

Argument 1 : PHP
Argument 2 : 2024
Argument 3 : 1
Argument 4 : 3.14

Aucun argument fourni.