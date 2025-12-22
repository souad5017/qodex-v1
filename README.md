# qodex-v1
# Mini Plateforme de Quiz – Version Sécurisée

## Description
Cette application est une mini plateforme de quiz développée en PHP, destinée à un usage pédagogique.  
Elle permet uniquement aux **enseignants** de créer et gérer des quiz organisés par catégories.

Le projet met l’accent sur la **sécurité**, la **bonne structuration du code**, et le **respect des bonnes pratiques en PHP**.

---

## Objectifs du Projet
- Mettre en place une authentification sécurisée
- Implémenter un CRUD complet pour les catégories, quiz et questions
- Sécuriser toutes les actions sensibles
- Protéger l’application contre les failles web courantes
- Gérer les accès selon le rôle utilisateur (enseignant uniquement)

---

## Technologies Utilisées
- PHP
- MySQL / MariaDB
- HTML5
- CSS / Tailwind CSS
- JavaScript (validation basique)
- Sessions PHP
- Requêtes préparées (MySQLi ou PDO)

---

## Fonctionnalités Implémentées

### Authentification
- Inscription sécurisée des enseignants
- Connexion avec vérification des identifiants
- Hashage sécurisé des mots de passe
- Gestion des sessions
- Déconnexion sécurisée
- Protection CSRF
- Redirection vers le dashboard enseignant

### Enseignant
- Création de catégories
- Modification et suppression des catégories
- Création de quiz
- Ajout de questions à un quiz
- Modification et suppression des quiz
- Gestion des questions (CRUD)
- Consultation des résultats des quiz

---

## Sécurité Implémentée
- Hashage sécurisé des mots de passe (bcrypt / Argon2)
- Protection contre SQL Injection via requêtes préparées
- Protection CSRF sur les formulaires
- Protection XSS avec `htmlspecialchars`
- Vérification de la session active
- Vérification du rôle utilisateur avant chaque action
- Régénération de l’ID de session après connexion
- Accès restreint aux ressources de l’enseignant connecté

---

## Structure du Projet
qodex/
├── config/
│ └── database.php
├── includes/
│ ├── header.php
│ └── footer.php
├── auth/
│ ├── login.php
│ └── register.php
├── enseignant/
│ ├── dashboard.php
│ ├── add_quiz.php
│ ├── manage_quizzes.php
│ ├── add_question.php
│ ├── view_results.php
│ └── statistics.php
└── logout.php
