<?php

class Database {
    private static $instance = null;  // Garantit qui n'existe qu'une seule instance de la classe et fournit un point d'accès global à cette instance
    private $pdo;  // permet l'accès à la base de données

    private function __construct() {  // Méthode ordinaire appelée lors de l'instanciation de l'objet
        $host = "localhost";  // Nom du serveur
        $db   = "motus"; // Nom de la basede données
        $user = "root";  // Nom de l'utilisateur
        $pass = "";  // Mot de passe

        $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass); // Connexion à la base de données
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Définit un attribut qui gère les erreurs
    }

      public static function getInstance() {  // Méthode utilisée pour retourner l'unique instance d'une classe
        if (self::$instance === null) { // Utilisé à l'intérieur d'une classe pour accéder à une propriété statique
            self::$instance = new Database(); // Crée une instance de la classe Database
        }
        return self::$instance->pdo; // Retourne cette instance en PDO
        
    }
}