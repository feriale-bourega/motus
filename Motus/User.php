<?php

require_once __DIR__ . "/Database.php";   // Charge le fichier depuis le même répertoire que le script actuel

class User {
    
    public static function register($username, $password) {  // Enregistre l'utilisateur
        $pdo = Database::getInstance();  // Connexion à la base de données
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");  // Requête qui permet d'insérer les données de l'utilisateur dans la base de données
        return $stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT)]);  // Exécute la requête
    }

      public static function login($username, $password) {   // Sélectionne les données de l'utilisateur
        $pdo = Database::getInstance();  // Connexion à la base de données
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username=? LIMIT 1"); // Sélectionne l'ensemble des informations de l'utilisateur en limitant l'accès à un utilisateur
        $stmt->execute([$username]); // Exécute la requête
        $user = $stmt->fetch(PDO::FETCH_ASSOC);  // Renvoie le résultat sous forme de tableau associatif

        if ($user && password_verify($password, $user['password'])) { // Si le nom d'utilisateur et le mot de passe sont vérifiés
            $_SESSION['user_id'] = $user['id'];  // On stocke l'id
            $_SESSION['username'] = $user['username']; // On stocke le nom d'utilisateur
            return true;
        }
        return false;
      }

    public static function getMaxLevel($user_id) {  // Méthode pour obtenir le niveau maximum
        $pdo = Database::getInstance();   // Connexion à la base de données
        $stmt = $pdo->prepare("SELECT max_level FROM users WHERE id=?"); // Requête qui sélectionne le niveau maximum d'un utilisateur selon son id
        $stmt->execute([$user_id]);  // Exécute la requête
        return (int)($stmt->fetchColumn() ?: 1); // Retourne une colonne depuis la ligne suivante d'un jeu de résultats
    }    

     public static function updateMaxLevel($user_id, $new_level) { // Méthode qui modifie le niveau maximum
        $pdo = Database::getInstance(); // Connexion à la base de données
        $stmt = $pdo->prepare("UPDATE users SET max_level=? WHERE id=? AND ? > max_level"); // Requête qui modifie le niveau maximum
        $stmt->execute([$new_level, $user_id, $new_level]); // Exécute la requête
    }

     public static function unlockNextLevel($user_id) {  // Méthode pour déverouiller le niveau suivant
        $pdo = Database::getInstance(); // Connexion à la base de données
        $st = $pdo->prepare("UPDATE users SET max_level = max_level + 1 WHERE id=?"); // Ajoute un niveau
        $st->execute([$user_id]); // Exécute la requête
    }
}