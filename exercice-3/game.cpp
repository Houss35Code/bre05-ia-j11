/*
    Exercice 3 : comprendre du code dans un langage que vous ne maitrisez pas forcément.
    Transmettez le code suivant à une IA grand public et tentez de lui faire analyser ce que fait le code :
*/

// ========================================
// CONSTRUCTEUR DE LA CLASSE GAME
// ========================================
// Ce constructeur est appelé automatiquement quand on crée un objet Game
// Exemple : Game* myGame = new Game();
// Il initialise tous les éléments nécessaires pour faire fonctionner le jeu

Game::Game()
{
    // ========================================
    // ÉTAPE 1 : INITIALISATION DES DONNÉES DU JEU
    // ========================================
    
    // Création d'une liste vide pour stocker tous les niveaux du jeu
    // std::list : structure de données en C++ (liste chaînée)
    // Level* : chaque élément de la liste est un pointeur vers un objet Level
    // Cette liste contiendra par exemple : Niveau 1, Niveau 2, Niveau 3, etc.
    this->levels = std::list<Level *>();
    
    // Création du joueur avec allocation dynamique en mémoire
    // new Player(...) : crée un nouvel objet Player dans la mémoire (heap)
    // Paramètres du constructeur Player :
    //   - 2 : position X initiale du joueur (colonne 2)
    //   - 2 : position Y initiale du joueur (ligne 2)
    //   - UP : direction initiale (le joueur regarde vers le haut)
    // this->player : stocke le pointeur vers ce joueur dans l'objet Game
    this->player = new Player(2, 2, UP);
    
    // Appel d'une méthode qui charge tous les niveaux du jeu
    // Cette méthode (définie ailleurs dans la classe) va probablement :
    //   - Lire des fichiers de configuration
    //   - Créer des objets Level
    //   - Les ajouter à la liste this->levels
    this->loadLevels();

    // ========================================
    // ÉTAPE 2 : INITIALISATION DE SDL
    // ========================================
    // SDL (Simple DirectMedia Layer) est une bibliothèque pour créer des jeux
    // Elle gère la fenêtre, le son, les événements clavier/souris, etc.
    
    // SDL_Init() : fonction qui initialise tous les sous-systèmes de SDL
    // SDL_INIT_EVERYTHING : constante qui active TOUS les modules SDL :
    //   - SDL_INIT_VIDEO : pour la vidéo/graphismes
    //   - SDL_INIT_AUDIO : pour le son
    //   - SDL_INIT_EVENTS : pour gérer clavier/souris
    //   - SDL_INIT_TIMER : pour les timers
    //   - etc.
    // Retourne < 0 en cas d'erreur
    if ( SDL_Init( SDL_INIT_EVERYTHING ) < 0 ) {
        
        // Si l'initialisation échoue, on affiche un message d'erreur
        // std::cout : flux de sortie standard (affichage console)
        // SDL_GetError() : fonction qui retourne une description de la dernière erreur SDL
        // std::endl : saut de ligne et flush du buffer
        std::cout << "Error initializing SDL: " << SDL_GetError() << std::endl;
        
        // system("pause") : met le programme en pause (attend que l'utilisateur appuie sur une touche)
        // Utile pour voir le message d'erreur avant que la console ne se ferme
        // Note : spécifique à Windows
        system("pause");
        
        // return : quitte le constructeur immédiatement
        // Le jeu ne peut pas continuer sans SDL
        return;
    }

    // ========================================
    // ÉTAPE 3 : CRÉATION DE LA FENÊTRE DE JEU
    // ========================================
    
    // SDL_CreateWindow() : crée une fenêtre graphique pour afficher le jeu
    // Paramètres détaillés :
    //   1. "Example" : le titre de la fenêtre (affiché dans la barre de titre)
    //   2. SDL_WINDOWPOS_UNDEFINED : position X automatique (le système choisit)
    //   3. SDL_WINDOWPOS_UNDEFINED : position Y automatique (le système choisit)
    //      Alternatives : SDL_WINDOWPOS_CENTERED pour centrer la fenêtre
    //   4. 320 : largeur de la fenêtre en pixels
    //   5. 320 : hauteur de la fenêtre en pixels (fenêtre carrée)
    //   6. SDL_WINDOW_SHOWN : flag qui indique que la fenêtre est visible dès sa création
    //      Autres flags possibles : SDL_WINDOW_FULLSCREEN, SDL_WINDOW_RESIZABLE, etc.
    // Retourne un pointeur vers la fenêtre créée, ou NULL en cas d'erreur
    this->window = SDL_CreateWindow( "Example", SDL_WINDOWPOS_UNDEFINED, SDL_WINDOWPOS_UNDEFINED, 320, 320, SDL_WINDOW_SHOWN );

    // Vérification : est-ce que la fenêtre a bien été créée ?
    // !this->window : true si window est NULL (création échouée)
    if ( !this->window ) {
        
        // Affichage du message d'erreur spécifique à la création de fenêtre
        std::cout << "Error creating window: " << SDL_GetError()  << std::endl;
        
        // Quitte le constructeur car on ne peut pas continuer sans fenêtre
        return;
    }

    // ========================================
    // ÉTAPE 4 : RÉCUPÉRATION DE LA SURFACE DE DESSIN
    // ========================================
    
    // SDL_GetWindowSurface() : récupère la surface associée à la fenêtre
    // Une "surface" (SDL_Surface) est une zone mémoire qui représente des pixels
    // C'est comme un canvas/tableau 2D où on peut dessiner
    // Structure d'une surface :
    //   - width, height : dimensions
    //   - format : format des pixels (RGB, RGBA, etc.)
    //   - pixels : tableau contenant les données de chaque pixel
    // On dessine sur cette surface, puis on l'affiche dans la fenêtre
    this->winSurface = SDL_GetWindowSurface( this->window );

    // Vérification : est-ce que la surface a bien été récupérée ?
    // !this->winSurface : true si winSurface est NULL (échec)
    if ( !this->winSurface ) {
        
        // Affichage du message d'erreur
        std::cout << "Error getting surface: " << SDL_GetError() << std::endl;
        
        // Quitte le constructeur car on ne peut pas dessiner sans surface
        return;
    }

    // ========================================
    // ÉTAPE 5 : REMPLISSAGE DE LA FENÊTRE AVEC UNE COULEUR
    // ========================================
    
    // SDL_FillRect() : remplit un rectangle (ou toute la surface) avec une couleur
    // Paramètres :
    //   1. this->winSurface : la surface à remplir
    //   2. NULL : indique de remplir TOUTE la surface (pas juste un rectangle)
    //      Si on voulait remplir seulement une partie, on passerait un SDL_Rect
    //      Exemple : SDL_Rect rect = {10, 10, 50, 50}; // x, y, largeur, hauteur
    //   3. SDL_MapRGB(...) : convertit une couleur RGB en format pixel de la surface
    //
    // SDL_MapRGB() : convertit RGB (Red Green Blue) en format natif de la surface
    // Paramètres de SDL_MapRGB :
    //   - this->winSurface->format : le format de pixels de notre surface
    //   - 255 : composante ROUGE (max = 255, min = 0)
    //   - 255 : composante VERTE (max = 255, min = 0)
    //   - 255 : composante BLEUE (max = 255, min = 0)
    // Résultat : 255, 255, 255 = BLANC (toutes les couleurs au maximum)
    //
    // Autres exemples de couleurs :
    //   - Noir : 0, 0, 0
    //   - Rouge : 255, 0, 0
    //   - Vert : 0, 255, 0
    //   - Bleu : 0, 0, 255
    //   - Jaune : 255, 255, 0
    SDL_FillRect( this->winSurface, NULL, SDL_MapRGB( this->winSurface->format, 255, 255, 255 ) );

    // ========================================
    // ÉTAPE 6 : AFFICHAGE DE LA SURFACE DANS LA FENÊTRE
    // ========================================
    
    // SDL_UpdateWindowSurface() : copie le contenu de la surface dans la fenêtre visible
    // Processus :
    //   1. On a dessiné sur winSurface (en mémoire)
    //   2. Cette fonction copie winSurface vers le buffer d'affichage de la fenêtre
    //   3. L'utilisateur voit maintenant la fenêtre blanche à l'écran
    //
    // Sans cette fonction, les modifications de la surface ne seraient pas visibles
    // C'est comme un "refresh" ou "flip" de buffer graphique
    SDL_UpdateWindowSurface( this->window );
    
    // ========================================
    // FIN DU CONSTRUCTEUR
    // ========================================
    // À ce stade, le jeu est initialisé avec :
    //   ✓ Une liste de niveaux chargée
    //   ✓ Un joueur créé à la position (2, 2)
    //   ✓ SDL initialisé
    //   ✓ Une fenêtre de 320x320 pixels affichée
    //   ✓ La fenêtre remplie en blanc
    //
    // Le jeu est prêt à fonctionner !
    // Les prochaines étapes seraient probablement :
    //   - Boucle de jeu principale (game loop)
    //   - Gestion des événements (clavier/souris)
    //   - Affichage du niveau actuel
    //   - Déplacement du joueur
    //   - Détection de collisions
    //   - etc.
}
```

## Résumé visuel du processus
```
┌─────────────────────────────────────────┐
│  1. Initialisation des données          │
│     - Liste de niveaux vide             │
│     - Joueur créé en (2,2) vers UP      │
│     - Chargement des niveaux            │
└─────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────┐
│  2. Initialisation de SDL               │
│     - Active tous les sous-systèmes     │
│     - Gère erreurs si échec             │
└─────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────┐
│  3. Création de la fenêtre              │
│     - Titre: "Example"                  │
│     - Taille: 320x320 pixels            │
│     - Position: automatique             │
└─────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────┐
│  4. Récupération de la surface          │
│     - Zone mémoire pour dessiner        │
└─────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────┐
│  5. Remplissage en blanc                │
│     - Couleur: RGB(255, 255, 255)       │
└─────────────────────────────────────────┘
                  ↓
┌─────────────────────────────────────────┐
│  6. Affichage à l'écran                 │
│     - L'utilisateur voit la fenêtre     │
└─────────────────────────────────────────┘