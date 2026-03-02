

document.addEventListener('DOMContentLoaded', () => {  // Ecouteur d'évènements  qui éxécute le code une fois que le HTML a été entièrement chargé et analysé
    const mots = ["risque", "actuel", "cheval", "paquet", "examen", "buveur", "cabine"];    // Tableau qui contient les mots
    const motMotus = mots[Math.floor(Math.random() * mots.length)]; // Génère un index aléatoire
    const longueurMot = motMotus.length; // Donne la longueur de la chaîne de caractères
    let chancesRestantes = 6;  // Variable numérique

    // Afficher les indices
    document.getElementById('indice').textContent = `Devinez le mot Motus. La première lettre du mot est : ${motMotus[0]}`;
    // Contenu textuel modifié avec la valeur de la variable

     // Créer les cases pour le mot
    const grille = document.getElementById('grille'); // Méthode qui renvoie un élément avec une valeur spécifiée
    for (let i = 0; i < longueurMot; i++) {
        const caseGrille = document.createElement('div'); // Crée un élément HTML DOM
        caseGrille.classList.add('case'); // Propriété qui renvoie les nom de classes CSS d'un élément
        grille.appendChild(caseGrille); // Ajoute l'élément crée dans la grille
    }

     // Gérer la soumission du formulaire
    document.getElementById('form').addEventListener('submit', function(e) {   // Récupère le formulaire et l'éxécute
        e.preventDefault(); // Si l'évènement n'est pas explicitement géré, l'action par défaut ne devrait pas être exécutée

         const proposition = document.getElementById('proposition').value.toLowerCase(); // Retourne la chaîne de caractères en miniscules

         if (proposition.length !== longueurMot) { // Si la longueur de mots de la proposition est différente de la longueur de la chaîne de caractères
            document.getElementById('message').textContent = `La proposition doit avoir ${longueurMot} lettres.`;
            return;    // Afficher un message précisant le nombre de lettres nécessaires
        }

         if (proposition === motMotus) {  // Si la proposition correspond au mot motus afficher un message
            document.getElementById('message').textContent = "Félicitations, vous avez trouvé le mot secret !";
            saveScore(motMotus); // Enregistre le score dans la base de données
            return;
        }

        chancesRestantes--;
        if (chancesRestantes <= 0) {
            document.getElementById('message').textContent = `Dommage, vous avez perdu. Le mot était : ${motMotus}`;
            document.getElementById('proposition').value = '';
            return;
        }

         // Mise à jour de la grille
        let reponse = "";
        for (let i = 0; i < longueurMot; i++) {
            if (proposition[i] === motMotus[i]) {
                grille.children[i].textContent = proposition[i];
                grille.children[i].style.backgroundColor = 'green';
                reponse += proposition[i];
            } else if (motMotus.includes(proposition[i])) {
                grille.children[i].textContent = proposition[i];
                grille.children[i].style.backgroundColor = 'yellow';
                reponse += '_';
            } else {
                grille.children[i].textContent = proposition[i];
                grille.children[i].style.backgroundColor = 'red';
                reponse += '_';
            }
        }

        document.getElementById('chances').textContent = `Chances restantes : ${chancesRestantes}`;
        document.getElementById('proposition').value = '';
    });

 