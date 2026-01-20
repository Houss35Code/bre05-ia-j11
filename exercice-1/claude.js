// Fonction qui crée une grille de cases dans la page web
// Paramètres : rows = nombre de lignes, cols = nombre de colonnes
export default function initMap(rows, cols){ 
    
    // Déclaration des variables
    let $main = null;  // Contiendra l'élément <main> de la page
    let $box = null;   // Contiendra chaque case créée
    let $id = 0;       // Compteur pour donner un identifiant unique à chaque case
 
    // Boucle externe : parcourt chaque ligne (de 0 à rows-1)
    for(var i = 0; i < rows; ++i) 
    { 
        // Boucle interne : parcourt chaque colonne (de 0 à cols-1)
        for(var j = 0; j < cols; ++j) 
        { 
            // Étape 1 : Sélectionne l'élément <main> dans le HTML
            $main = document.querySelector("main"); 
            
            // Étape 2 : Crée un nouvel élément <section> (une case de la grille)
            $box = document.createElement("section"); 
            
            // Étape 3 : Positionne la case sur la grille avec des classes CSS
            
            // Définit la colonne de départ (j+1 car CSS Grid commence à 1, pas 0)
            $box.classList.add("col-start-" + (j + 1)); 
            
            // Définit la colonne de fin (même valeur = case d'1 colonne de large)
            $box.classList.add("col-end-" + (j + 1)); 
            
            // Définit la ligne de départ (i+1 car CSS Grid commence à 1, pas 0)
            $box.classList.add("row-start-" + (i + 1)); 
            
            // Définit la ligne de fin (même valeur = case d'1 ligne de haut)
            $box.classList.add("row-end-" + (i + 1)); 
            
            // Étape 4 : Donne un identifiant unique à la case (0, 1, 2, 3...)
            $box.setAttribute("id", $id); 
            
            // Étape 5 : Ajoute la case créée dans l'élément <main>
            $main.appendChild($box); 
            
            // Étape 6 : Incrémente le compteur pour la prochaine case
            $id++; 
        } 
    } 
}

// Exemple d'utilisation : initMap(3, 4) créera une grille de 3 lignes × 4 colonnes = 12 cases