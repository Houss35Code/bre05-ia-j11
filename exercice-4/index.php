<?php
class User
{
    public function __construct(private string $username)
    {
    }
    
    // Méthode pour accéder au username
    public function getUsername(): string
    {
        return $this->username;
    }
}
$user = new User("Gaston");
echo $user->getUsername(); // ✅ Fonctionne