# TOUCHE PAS AU KLAXON

**Auteur :** Bachini Mario  
**Projet réalisé dans le cadre d’une formation (2025)**

---

## Présentation

TOUCHE PAS AU KLAXON est une application web de covoiturage réalisée en PHP, utilisant le pattern MVC, MySQL/MariaDB et Bootstrap (Sass).
Elle permet de proposer, consulter et gérer des trajets entre différentes agences pour les utilisateurs et administrateurs.

---

## Fonctionnalités principales

- Authentification utilisateur et administrateur
- Création/suppression/modification de trajets (utilisateur/admin)
- Gestion des agences (admin)
- Dashboard administrateur (liste utilisateurs, agences, trajets)
- Responsive mobile grâce à Bootstrap 5
- Tests unitaires pour la couche Modèle (PHPUnit)
- Messages flash (succès, erreurs)

---

## Installation

### 1. **Cloner le projet**

```bash
git clone https://github.com/MB-DEV13/TOUCHE_PAS_AU_KLAXON.git
cd TOUCHE_PAS_AU_KLAXON
```

### 2. **Configurer la base de données**

- Importer les deux fichiers SQL fournis dans le fichier `scripts` :
  - `create_db.sql` (création db + structure)
  - `seed_db.sql` (données initiales)

### 3. **Configurer la connexion**

- Vérifie/modifie les accès BDD dans `config/config.php` si besoin :

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'covoiturage');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');
```

### 4. **Installer les dépendances PHP**

```bash
composer install
```

### 5. **Lancer le serveur local (XAMPP/WAMP/CLI)**

- Place le projet dans le dossier `htdocs` (XAMPP) ou configure ton virtualhost.
- Accède à l’application via [http://localhost/TOUCHE_PAS_AU_KLAXON/public](http://localhost/TOUCHE_PAS_AU_KLAXON/public)

---

## Connexion administrateur et users

- Un compte admin et deux comptes utilisateurs sont fournis dans le dossier PDF remis avec ce projet (email/mot de passe par défaut).

---

## Tests unitaires

- Les tests sont situés dans le dossier `/tests`.
- Pour lancer les tests (modèle Agence et Trajet) :

```bash
composer require --dev phpunit/phpunit
$env:PHPUNIT_TEST=1; ./vendor/bin/phpunit
```

- Les tests n’impactent pas la base principale (utilisent une transaction qui est annulée).

---

## Structure du projet

- `app/Controllers` : Contrôleurs
- `app/Models` : Accès aux données
- `app/Views` : Vues (pages HTML/PHP)
- `app/Core` : Classes cœur (BDD, helpers)
- `config/` : Config BDD
- `public/` : Point d’entrée du site (index.php, assets...)
- `tests/` : Tests unitaires

---

## Bonus techniques

- Code commenté au format DocBlock
- Couleurs via variables Bootstrap (palette imposée)
- Responsive mobile (Bootstrap)
- Sécurité basique sur les formulaires et accès
- Vérifié avec PHPStan

---

## Auteur

Bachini Mario  
[https://github.com/MB-DEV13/TOUCHE_PAS_AU_KLAXON](https://github.com/MB-DEV13/TOUCHE_PAS_AU_KLAXON)

---

## Licence

Projet réalisé dans un cadre pédagogique.
