# MoneyConverter

MoneyConverter est un projet de conversion de devises qui se compose d'un back-end en Laravel 10 avec Breeze Auth et d'un front-end en Vue.js avec Vuetify 3 et vueQuery.

## Installation

1. Clonez le projet depuis GitHub :

```bash
git clone https://github.com/Corentin-kzk/currency_converter
```

2. Accédez au répertoire du projet :

```bash
cd currency_converter
```

### Backend (API)

3. Assurez-vous d'avoir un serveur web (comme XAMPP, WAMP ou MAMP) installé sur votre machine. Ces serveurs vous permettront d'exécuter le serveur mysql requis pour Laravel.

4. Démarrez votre serveur web et assurez-vous que PHP est configuré correctement.

5. Accédez au répertoire du backend :

```bash
cd API
```

6. Installez les dépendances via Composer :

```bash
composer install
```

7. Créez un fichier d'environnement `.env` en copiant le fichier `.env.example` :

```bash
cp .env.example .env
```

8. Générez la clé d'application Laravel :

```bash
php artisan key:generate
```

9. Configurez votre base de données dans le fichier `.env`.

10. Migrez la base de données avec les seeders :

```bash
php artisan migrate --seed
```

11. Démarrez le serveur de développement :

```bash
php artisan serve
```



### Frontend (Admin)

12. Accédez au répertoire du frontend :

```bash
cd ../admin
```

13. Installez les dépendances via npm ou yarn :

```bash
npm install
# ou
yarn install
```
14. Créez un fichier d'environnement `.env` en copiant le fichier `.env.example` :

```bash
cp .env.example .env
```

15. Lancez l'application en mode de développement :

```bash
npm run serve
# ou
yarn serve
```

L'application frontend sera accessible à l'adresse http://localhost:3000.

## Fonctionnalités

Liste des fonctionnalités clés de MoneyConverter :

- Conversion de devises en temps réel.
- Authentification des utilisateurs via Laravel Breeze.
- Interface utilisateur moderne basée sur Vuetify 3.
- Intégration de vueQuery pour une gestion efficace des requêtes.

## Contribution

Les corrections sont les bienvenues ! Si vous souhaitez apporter des améliorations à MoneyConverter, nous vous encourageons vivement à ouvrir une "issue" afin de discuter des nouvelles fonctionnalités, des problèmes éventuels ou des suggestions pour le projet. De plus, vous avez la possibilité de soumettre des "pull requests" contenant vos modifications pour contribuer activement au développement de l'application. Votre participation est très appréciée et nous avons hâte de collaborer avec vous pour rendre MoneyConverter encore meilleur !

# Documentation 

N'oubliez pas de consulter la documentation de MoneyConverter ! Elle contient des instructions essentielles pour utiliser l'application de manière efficace et contribuer au projet de manière pertinente. Vous pouvez la retrouver à l'emplacement suivant pour une version au format Markdown : currency_converter/documentation.md. Vous pouvez également y accéder depuis l'interface administrateur sur la page d'index.


---
Auteur : Kozka Corentin



