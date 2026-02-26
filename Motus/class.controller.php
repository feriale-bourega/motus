<?php

session_start();
require_once 'vue.class.php';
require_once 'verif.class.php';
require_once 'class_dictionnaire.php';

class controller {   // Gère la logique entre l'interface utilisateur et les données

  var $vue;   // Déclaration de variable

  public function controller () {   // Constructeur
  
    $this->vue = new vue();  // Instanciation de la vue

 if(isset($_SESSION['mot'])){  // Condition qui vérifie si la variable qui est stockée existe     
      if (isset($_POST['mot'])){  // Condition qui vérifie si la variable envoyée par le formulaire existe
        $this->jouer(); // Instanciation du jeu
      }

      
 } else {                             // Si pas de session alors on en crée une            
      $_SESSION['tab_mot'] = array();    // Initialisation à vide du tableau
      $dico = new dictionnaire();
      $_SESSION['mot'] = $dico->get_mot();      // On demande un mot au dico 
    }

     $this->vue->tab_mot = $_SESSION['tab_mot']; // On stocke le mot choisi

    $this->perdu();  // on verifie si on a perdu 
    
    $this->vue->affiche(); // On affiche le résultat

    
  }

    private function jouer(){    // Fonction qui permet de jouer

    $verif = new Verificateur();  // Instanciation du vérificateur de jeu

     if ($verif->motvalide($_POST["mot"])) {           // ON vérifie si le mot envoyé par le formulaire est valide
      if (strtoupper($_POST["mot"])==strtoupper($_SESSION['mot'])) {   // Convertit une chaine de caractères en majuscules
        unset($_SESSION['mot']);                     // On detruit le mot en "memoire"
        $this->vue->run=1;

         } else {
        $indice = $verif->indices($_POST["mot"],$_SESSION['mot']); // Fonction qui compare les deux mots et retourne des indices
        $tab = $_SESSION['tab_mot'];  // Récupère la valeur stockée en session et la met dans la variable
        $tab[] = $indice;  // Ajoute une nouvelle valeur à la fin du tableau $tab
        $_SESSION['tab_mot'] = $tab;   // On enlève les accents et on affiche uniquement les indices
      }    

       }else {                                       
      echo "<font color=red>Mot invalide !! Le mot doit contenir 7 lettres.</font>"; // Affiche une affirmation
    }  
  }

  private function perdu(){
    if (!$this->vue->run && sizeof($this->vue->tab_mot)>=5) {  // Si le jeu n'est pas en cours et que le tableau contient au moins 5 éléments
      $this->vue->run = 1;// Attribue à une variable appelée run à l'intérieur de la vue objet la valeur 1
      echo "<p>Le mot &eacute;tait : ".$_SESSION['mot']."</p>";      // faudrais le passer a la vue ...
      unset($_SESSION['mot']); // Détruit la valeur stockée
    }


  }