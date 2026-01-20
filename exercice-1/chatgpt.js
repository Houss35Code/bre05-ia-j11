// On exporte la fonction pour pouvoir l'utiliser dans un autre fichier JavaScript
export default function initMap(rows, cols) {

    // Variable qui va contenir l'élément HTML <main>
    let $main = null;

    // Variable qui représentera chaque case (section) de la grille
    let $box = null;

    // Compteur servant à donner un identifiant unique à chaque case
    let $id = 0;

    // Boucle sur les lignes de la grille
    for (var i = 0; i < rows; ++i) {

        // Boucle sur les colonnes de la grille
        for (var j = 0; j < cols; ++j) {

            // On récupère l'élément <main> du document HTML
            $main = document.querySelector("main");

            // On crée un nouvel élément HTML <section>
            $box = document.createElement("section");

            // Ajout de classes CSS pour positionner la case en colonne
            // j + 1 car les index CSS commencent à 1 et non à 0
            $box.classList.add("col-start-" + (j + 1));
            $box.classList.add("col-end-" + (j + 1));

            // Ajout de classes CSS pour positionner la case en ligne
            // i + 1 car les index CSS commencent à 1 et non à 0
            $box.classList.add("row-start-" + (i + 1));
            $box.classList.add("row-end-" + (i + 1));

            // Attribution d'un identifiant unique à la case
            $box.setAttribute("id", $id);

            // Ajout de la case dans l'élément <main>
            $main.appendChild($box);

            // Incrémentation de l'identifiant pour la prochaine case
            $id++;
        }
    }
}
