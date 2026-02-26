<?php

class dictionnaire
{
	public function get_mot()  // Méthode pour obtenir un mot
	{
		$fichier=file('liste_motus.txt'); // Lit un fichier et l'enregistre dans un tableau
		//var_dump($fichier);
		//$count=substr_count($fichier,'\n');
		$count=count($fichier); // Compte tous les éléments d'un tableau ou contenue dans un objet
		$rand=rand(0,$count-1); // Génère une valeur aléatoire
		$mot=$fichier[$rand]; // Contient la valeur obtenue aléatoirement dans le fichier

		return $mot; // Retourne le mot obtenu aléatoirement
	}
}
?>