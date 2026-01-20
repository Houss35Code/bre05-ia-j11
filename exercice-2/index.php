<?php

// ========================================
// TRAIT DEBUG
// ========================================
// Un trait est un mécanisme de réutilisation de code en PHP
// Il permet d'ajouter des méthodes à plusieurs classes sans héritage
trait Debug {
    
    // Méthode qui affiche automatiquement toutes les valeurs des getters
    public function print() : void
    {
        // ÉTAPE 1 : Récupération de toutes les méthodes de la classe
        // get_class_methods() est une fonction PHP de réflexion
        // $this fait référence à l'objet qui utilise ce trait
        // Résultat : un tableau contenant les noms de toutes les méthodes
        // Exemple : ['print', 'getFirstName', 'setFirstName', 'getLastName', 'setLastName']
        $methods = get_class_methods($this);

        // ÉTAPE 2 : Parcourir toutes les méthodes une par une
        // $method contiendra successivement : 'print', 'getFirstName', 'setFirstName', etc.
        foreach($methods as $method)
        {
            // ÉTAPE 3 : Filtrer uniquement les méthodes qui sont des getters
            // str_contains() vérifie si le nom de la méthode contient le mot "get"
            // Les getters commencent généralement par "get" (ex: getFirstName, getLastName)
            // Les setters commencent par "set" donc ils seront ignorés
            if(str_contains($method, "get"))
            {
                // ÉTAPE 4 : Appeler dynamiquement la méthode et afficher son résultat
                // $this->$method() appelle la méthode dont le nom est stocké dans $method
                // Exemple : si $method = "getFirstName", alors on appelle $this->getFirstName()
                // Le résultat est affiché suivi d'un saut de ligne HTML <br>
                echo $this->$method() . "<br>";
            }
        }
    }
}

// ========================================
// CLASSE TEST
// ========================================
class Test {

    // IMPORTATION DU TRAIT
    // Le mot-clé "use" importe toutes les méthodes du trait Debug dans cette classe
    // Maintenant, la classe Test a accès à la méthode print()
    use Debug;

    // CONSTRUCTEUR AVEC PROMOTED PROPERTIES (PHP 8+)
    // Cette syntaxe courte permet de :
    // 1. Déclarer les propriétés privées $firstName et $lastName
    // 2. Les initialiser automatiquement avec les valeurs passées au constructeur
    // Équivalent à :
    //   private string $firstName;
    //   private string $lastName;
    //   public function __construct(string $firstName, string $lastName) {
    //       $this->firstName = $firstName;
    //       $this->lastName = $lastName;
    //   }
    public function __construct(private string $firstName, private string $lastName)
    {
        // Le corps du constructeur est vide car tout est fait automatiquement
    }

    // GETTER pour la propriété firstName
    // Permet de récupérer la valeur de $firstName (qui est privée)
    // Retourne une chaîne de caractères (string)
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    // SETTER pour la propriété firstName
    // Permet de modifier la valeur de $firstName
    // Ne retourne rien (void)
    public function setFirstName(string $firstName) : void
    {
        // On assigne la nouvelle valeur à la propriété
        $this->firstName = $firstName;
    }

    // GETTER pour la propriété lastName
    // Permet de récupérer la valeur de $lastName (qui est privée)
    // Retourne une chaîne de caractères (string)
    public function getLastName() : string
    {
        return $this->lastName;
    }

    // SETTER pour la propriété lastName
    // Permet de modifier la valeur de $lastName
    // Ne retourne rien (void)
    public function setLastName(string $lastName) : void
    {
        // On assigne la nouvelle valeur à la propriété
        $this->lastName = $lastName;
    }
}

// ========================================
// EXEMPLE D'UTILISATION
// ========================================

// Création d'un nouvel objet Test avec le prénom "Jean" et le nom "Dupont"
$test = new Test("Jean", "Dupont");

// Affichage de toutes les valeurs des getters
// Grâce au trait Debug, l'objet $test possède la méthode print()
// Cette méthode va :
// 1. Récupérer toutes les méthodes : ['print', 'getFirstName', 'setFirstName', 'getLastName', 'setLastName']
// 2. Filtrer celles qui contiennent "get" : ['getFirstName', 'getLastName']
// 3. Appeler getFirstName() → affiche "Jean<br>"
// 4. Appeler getLastName() → affiche "Dupont<br>"
$test->print();

// Résultat affiché dans le navigateur :
// Jean
// Dupont

// ========================================
// EXEMPLE AVANCÉ : Modification et réaffichage
// ========================================

echo "<hr>"; // Ligne de séparation

// On modifie le prénom avec le setter
$test->setFirstName("Marie");

// On modifie le nom avec le setter
$test->setLastName("Martin");

// On réaffiche toutes les valeurs
$test->print();

// Résultat affiché :
// Marie
// Martin

?>