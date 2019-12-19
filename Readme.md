# Projet Php - Programmation Orientée Objet
# Origines:

Ce projet est un tp proposé sur OpenClassRoom concernant l'apprentissage de la Programmation Orientée Objet sous Php.
J'ai ensuite poursuivit ce projet afin d'y ajouter d'autres fonctions et mécaniques afin de bien assimiler ce qui nous a été enseigné.

Source du tp: https://openclassrooms.com/fr/courses/1665806-programmez-en-oriente-objet-en-php/1666490-tp-mini-jeu-de-combat

# Présentation du projet:
Ce projet représente un jeu vidéo, comprenant des personnages qui peuvent se frapper l'un l'autre.
Chaque personnage frappé subit des "dégâts", une fois le seuil de dégât dépassé, il meurt et est supprimé du jeu.

## Comment lancer le jeu: 
1) Clonez ce repository sur votre machine via la commande 'git clone [https://github.com/CocoThePimp/OCR_Classes](https://github.com/CocoThePimp/OCR_Classes)' depuis un terminal.
2) Lancez votre serveur local afin de faire tourner le jeu (cf. MAMP, WAMP ou XAMPP). 
3) Paramétrez le serveur afin qu'il utilise le dossier de ce repository.
4) Ensuite rendez-vous sur sur la page [http://localhost/OCR_Classes/index.php](http://localhost/OCR_Classes/index.php) .

## Déroulement du jeu:
1) Si l'installation s'est bien passée vous devriez avoir 2 messages de confirmation en haut de l'écran ('Connected successfully' et 'Database created successfully')
2) Cliquez sur le bouton "Remplir la BDD".
3) Dans le champ 'Nom' renseignez le nom de votre personnage.
4) Cliquez sur "Créer ce personnage".
5) Cliquez sur le nom des personnages de la liste pour leur infliger des dégâts.

# Ce que j'ai mis en application lors de ce projet:

- Créer/utiliser une classe

- Créer/utiliser un manager de classe

- Créer les Setters & Getters

- Créer une interface visuelle connectant le backend au frontend

- Gérer/organiser/préparer/construire une base de donnée

- Commenter au maximum mon code pour pouvoir le ré-utiliser

- La programmation fonctionnelle

- La résolution de problèmes

- L'indentation de mon code

- Créer une base de donnée ainsi qu'une table en utilisant du code dur plutôt que PhpMyAdmin

- Soigner la présentation d'un readme _(lol)_ 

# Documentation Personnage
## Attributs de la Classe:
### Nom:
Correspond au nom du personnage.

### Dégâts: 
Représente les dégâts que le personnage a subit.
Une fois le seuil dépassé le personnage meurt.
Le seuil est de 250 fois le niveau du personnage.

### Niveau*:
Les personnages sont par défaut de niveau 1. 
Il existe 2 moyens de monter de niveau.
1) Tuer un personnage.
2) Avoir assez d'expérience.

### Expérience*:
Vous gagnez de l'expérience après avoir frappé un personnage.
L'expérience que vous gagnez est proportionnelle à 3 fois le niveau du personnage que vous frappez.

L'expérience vous sert à monter en niveau. Le seuil requis pour un passage de niveau est de 100x votre niveau.

### Force*:
La force représente les dégâts que vous allez infliger après chaque frappes.
La force est proportionnelle à 5 fois votre niveau.

_*Attributs non présents dans le cours_

## Fonctions de la Classe:
### - Frapper un personnage
### - Recevoir des dégâts
### - Gagner de l'expérience*
### - Gagner un niveau*
### - Gagner de la force*
_*Fonctions non présentes dans le cours_

Retrouvez tout le code: [Ici](https://github.com/CocoThePimp/OCR_Classes/blob/master/Personnage.php)

# Documentation Personnages Manager
## Attributs de la Classe:
### $_db:
Correspond à la variable reliant la base de données.


## Fonctions de la Classe:
### - Ajout d'un personnage à la base de données
### - Suppression d'un personnage à la base de données
### - Mise à jour d'un personnage à la base de données
### - Récupérer les infos d'un personnage
### - Dresser la liste de tous les personnages
### - Savoir si un personnage existe
### - Compte le nombre de personnage en base de données
### - Remplissage auto de la base de données*
### - Suppression de toutes les données en base*
_*Fonctions non présentes dans le cours_

Retrouvez tout le code: [Ici](https://github.com/CocoThePimp/OCR_Classes/blob/master/PersonnagesManager.php)

# Futurs Release:

Il y a peu de chance que ces release sortent un jour, étant donné que je vais poursuivre mon apprentissage du POO sur d'autre projet, et ensuite passerait à Laravel.
- Possibilité de switcher de personnage de la bdd lorsque nous sommes connecté _(fait à 100%)_

- Intégration de la création de la table Personnages directement via le fichier Manager _(fait à 100%)_

- Ajout des personnages en bdd avec des attributs aléatoires _(fait à 80%, un bug persiste)_.

- Limiter le nombre de frappes avec un système d'énergie et de recharge d'énergie

- La possibilité de soigner son héro de tous les dégâts subit, 1 fois toutes les 24h.

  # Created by CocoThePimp
