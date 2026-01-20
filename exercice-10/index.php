<?php

/* 
   Exercice 10 : générer des classes.
   Demander à une IA de vous créer une solution en PHP qui permet de générer des utilisateurs aléatoires pour peupler une application.
*/

// Classe représentant un utilisateur
class User
{
    private string $id;
    private string $firstName;
    private string $lastName;
    private string $email;
    private string $username;
    private string $password;
    private \DateTime $createdAt;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $username,
        string $password
    ) {
        $this->id = uniqid('user_', true);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->username = $username;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->createdAt = new \DateTime();
    }

    // Getters
    public function getId(): string { return $this->id; }
    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getEmail(): string { return $this->email; }
    public function getUsername(): string { return $this->username; }
    public function getPassword(): string { return $this->password; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }

    // Méthode pour afficher l'utilisateur
    public function __toString(): string
    {
        return sprintf(
            "ID: %s | Nom: %s %s | Email: %s | Username: %s | Créé le: %s",
            $this->id,
            $this->firstName,
            $this->lastName,
            $this->email,
            $this->username,
            $this->createdAt->format('Y-m-d H:i:s')
        );
    }
}

// Classe pour générer des utilisateurs aléatoires
class UserGenerator
{
    private array $firstNames = [
        'Jean', 'Marie', 'Pierre', 'Sophie', 'Luc', 'Emma', 'Paul', 
        'Julie', 'Thomas', 'Sarah', 'Antoine', 'Camille', 'Nicolas', 
        'Laura', 'Alexandre', 'Chloé', 'Maxime', 'Léa'
    ];

    private array $lastNames = [
        'Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard',
        'Petit', 'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent',
        'Lefebvre', 'Michel', 'Garcia', 'David', 'Bertrand', 'Roux'
    ];

    private array $domains = [
        'gmail.com', 'yahoo.fr', 'outlook.com', 'hotmail.fr', 
        'orange.fr', 'free.fr', 'laposte.net'
    ];

    // Génère un utilisateur aléatoire
    public function generateOne(): User
    {
        $firstName = $this->getRandomElement($this->firstNames);
        $lastName = $this->getRandomElement($this->lastNames);
        $email = $this->generateEmail($firstName, $lastName);
        $username = $this->generateUsername($firstName, $lastName);
        $password = $this->generatePassword();

        return new User($firstName, $lastName, $email, $username, $password);
    }

    // Génère plusieurs utilisateurs aléatoires
    public function generateMany(int $count): array
    {
        $users = [];
        for ($i = 0; $i < $count; $i++) {
            $users[] = $this->generateOne();
        }
        return $users;
    }

    // Génère un email aléatoire
    private function generateEmail(string $firstName, string $lastName): string
    {
        $domain = $this->getRandomElement($this->domains);
        $random = rand(1, 999);
        return strtolower($firstName . '.' . $lastName . $random . '@' . $domain);
    }

    // Génère un nom d'utilisateur aléatoire
    private function generateUsername(string $firstName, string $lastName): string
    {
        $random = rand(100, 9999);
        return strtolower(substr($firstName, 0, 1) . $lastName . $random);
    }

    // Génère un mot de passe aléatoire
    private function generatePassword(int $length = 12): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        $max = strlen($characters) - 1;
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, $max)];
        }
        
        return $password;
    }

    // Récupère un élément aléatoire d'un tableau
    private function getRandomElement(array $array): string
    {
        return $array[array_rand($array)];
    }
}

// Exemple d'utilisation
echo "=== GÉNÉRATION D'UTILISATEURS ALÉATOIRES ===\n\n";

$generator = new UserGenerator();

// Générer un seul utilisateur
echo "--- Un utilisateur ---\n";
$user = $generator->generateOne();
echo $user . "\n\n";

// Générer plusieurs utilisateurs
echo "--- 5 utilisateurs ---\n";
$users = $generator->generateMany(5);

foreach ($users as $user) {
    echo $user . "\n";
}

?>
```

## Résultat exemple :
```
=== GÉNÉRATION D'UTILISATEURS ALÉATOIRES ===

--- Un utilisateur ---
ID: user_679e5a1b2c3d4 | Nom: Sophie Dubois | Email: sophie.dubois247@gmail.com | Username: sdubois4521 | Créé le: 2026-01-20 14:30:15

--- 5 utilisateurs ---
ID: user_679e5a1b2c3d5 | Nom: Jean Martin | Email: jean.martin512@yahoo.fr | Username: jmartin2347 | Créé le: 2026-01-20 14:30:15
ID: user_679e5a1b2c3d6 | Nom: Emma Robert | Email: emma.robert89@outlook.com | Username: erobert7823 | Créé le: 2026-01-20 14:30:15
ID: user_679e5a1b2c3d7 | Nom: Thomas Leroy | Email: thomas.leroy334@free.fr | Username: tleroy1092 | Créé le: 2026-01-20 14:30:15
ID: user_679e5a1b2c3d8 | Nom: Sarah Michel | Email: sarah.michel776@orange.fr | Username: smichel5641 | Créé le: 2026-01-20 14:30:15
ID: user_679e5a1b2c3d9 | Nom: Paul Moreau | Email: paul.moreau223@laposte.net | Username: pmoreau3389 | Créé le: 2026-01-20 14:30:15