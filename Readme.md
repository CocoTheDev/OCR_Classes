WIP
----------------------------------------
Présentation:
----------------------------------------
Ce projet est un tp proposé sur OpenClassRoom concernant l'apprentissage de la Programmation Orienté Objet sous php.
J'ai ensuite poursuivit ce projet afin d'y ajouter d'autres fonctions et mécaniques afin de bien assimiler ce qui nous a été enseigné.

Source: https://openclassrooms.com/fr/courses/1665806-programmez-en-oriente-objet-en-php/1666490-tp-mini-jeu-de-combat



----------------------------------------
Ce que j'ai mis en application lors de ce projet POO php:
----------------------------------------
- Créer/utiliser une classe
- Créer/utiliser un manager de classe
- Créer une interface visuelle connectant le backend au frontend
- Gérer/organiser/préparer/construire une base de donnée 
- Commenter au maximum mon code pour pouvoir le ré-utiliser
- La programmation fonctionnelle
- La résolution de problèmes
- L'indentation de mon code
- Les SETTERS et GETTERS
- 




----------------------------------------
Caractéristiques des personnages:
----------------------------------------

---------------
Attributs de base:
---------------

- Nom: Le nom de votre personnage.

- Niveau: Le personnage débute au niveau 1. Pour monter de niveau vous devez atteindre 100x le niveau de votre personnage en expérience. 
    Exemple: vous êtes niveau 2, il faudra 2x100 = 200 d'expériences pour passer au niveau 3

- Expérience: L'expérience gagnée est proportionnelle (x3) au niveau du personnage que l'on frappe.

- Dégats: Les dégâts représente le nombre de dégâts subit. Passé la limite, vous mourrez. La limite est de 250x votre niveau.

- Force: La force représente le nombre de dégâts que vous allez infliger à vos ennemis. Elle équivaut à 2x votre niveau.



---------------
Fonctions de base:
---------------

- Frapper: Permet de frapper un ennemi.
- RecevoirDegats: Permet de recevoir des dégats suite à une frappe.
- GagnerExperience: Permet de gagner de l'expérience suite à une frappe.
- GagnerNiveau: Permet de gagner un niveau suite à une frappe mortelle, ou en ayant atteint l'expérience requise.
- GagnerStrength: Permet de gagner de la force suite à un passage à un niveau supérieur.



----------------------------------------
Fonctions Base de données (boutons):
----------------------------------------
- "Creer ce personnage": créer un personnage avec le nom que vous avez stipulé.
- "Utiliser ce personnage": utilise le personnage propre au nom stipulé.
- "Remplir la BDD": Rempli la base de donnée de 10 personnages.
- "Supprimer la BDD": Vide la table Personnages


----------------------------------------
Ajouts futurs:
----------------------------------------
- Intégration de la création de la table Personnages directement via le fichier Manager
- Listing des personnages de la base de donnée sur l'écran d'accueil
- Possibilité de switcher de personnage de la bdd lorsque nous sommes connecté
- Ajout des personnages en bdd avec des attributs aléatoires.
- Limiter le nombre de frappes avec un système d'énergie et de recharge d'énergie
- La possibilité de soigner son héro de tous les dégâts subit 1 fois toutes les 24h.
- Possibilité de créer et rejoindre un clan
- Amélioration du front
- Hébergement + post sur reddit afin d'avoir un feedback
- Possibilité de combattre des boss ayant des caractéristiques spéciales
- Créations d'équipements



----------------------------------------
Présentation de chaque fichier ainsi que leurs fonctions:
----------------------------------------

---------------
Personnage.php:
---------------
Type: Classe
Fonctionnement: 


