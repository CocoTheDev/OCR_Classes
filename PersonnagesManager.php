<?php
class PersonnagesManager 
{

private $_db;

public function __construct($db) 
{
  $this->setDb($db);
}


public function setDb($db) 
{
  // connexion à la bd en PDO
/*   $dsn = 'mysql:dbname=OCR_Classes;host=127.0.0.1';
  $user = 'root';
  // Password: MAC = "" ; Linux = "root"
  $password = '';
  
  try 
  {
      $db = new PDO($dsn, $user, $password);
  } 
  catch (PDOException $e) 
  {
      echo 'Connexion échouée : ' . $e->getMessage();
  } */

  $this->_db = $db;

}


public function createPersonnage(Personnage $perso) 
{
  // Préparation de la requête d'insertion.
  // Assignation des valeurs pour le nom du personnage.
  // Exécution de la requête.
  // Hydratation du personnage passé en paramètre avec assignation de son identifiant et des dégâts initiaux (= 0).

  $req = $this->_db->prepare('INSERT INTO Personnages(nom) VALUES (:nom)');
  $req->bindValue(':nom', $perso->nom());
  $req->execute();

  $perso->hydrate([
    'id' => $this->_db->lastInsertId(),
    'degats' => 0,
  ]);
)

}

public function get($info) 
{
  // Si le paramètre est un entier, on veut récupérer le personnage avec son identifiant.
  // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
  // Sinon, on veut récupérer le personnage avec son nom.
  // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
  
  if(is_int($info))
  {
    $req = $this->_db->prepare('SELECT * FROM Personnages WHERE id= ?');
    $req->bindValue(':id', $info);
    $req->execute();

    $donnees = fetch($req);
    return new Personnage($donnees);
  }
  elseif (is_string($info))
  {
    $req = $this->_db->prepare('SELECT * FROM Personnages WHERE nom= ?');
    $req->bindValue(':nom', $info);
    $req->execute();

    $donnees = fetch($req);
    return new Personnage($donnees);
  }
  else 
  {
    return "Données non recevable";
  }

}

public function updatePersonnage(Personnage $perso) 
{
  // update d'un personnage - SQL Update
  $req = $this->_db->prepare('
    UPDATE Personnages
    SET nom = ?
    WHERE id = ?
  ');
  $req->bindValue(':nom', $perso->nom(), PDO::PARAM_STR, 24);
  $req->bindValue(':degats', $perso->degats(), PDO::PARAM_INT, 2);
  $req->bindValue(':id', $perso->id(), PDO::PARAM_INT);
  $req->execute();

}

public function deletePersonnage(Personnage $perso) 
{
  // suppression d'un personnage - SQL Delete
  $req = $this->_db->prepare('
  DELETE FROM Personnages
  WHERE id = ?
  ');
  $req->bindValue(':id', $perso->id(), PDO::PARAM_INT);
  $req->execute();
}

public function getList($nom) 
{
  // Retourne la liste des personnages dont le nom n'est pas $nom.
  // Le résultat sera un tableau d'instances de Personnage.
  $req = $db->prepare('SELECT * FROM Personnages');
  $req = $db->exec();
  $persos = [];
  while ($donnees = $req->fetch(PDO::FETCH_ASSOC))
  {
    if ($donnees['nom'] !== $nom)
    {
      $persos[] = new Personnage($donnees);
    }
  }
  return $persos;
}

public function exists($info) 
{
  // Si le paramètre est un entier, c'est qu'on a fourni un identifiant.
  // On exécute alors une requête COUNT() avec une clause WHERE, et on retourne un boolean.
  
  // Sinon c'est qu'on a passé un nom.
  // Exécution d'une requête COUNT() avec une clause WHERE, et retourne un boolean.

  if (is_int($info))
  {
    $req = $db->prepare('SELECT COUNT(*) FROM Personnages WHERE id =?');
    $req = $db->execute(':id' => $info);
    return (bool) $req;
  }
  elseif (is_string($info))
  {
    $req = $db->prepare('SELECT COUNT(*) FROM Personnages WHERE nom =?');
    $req = $db->execute(':nom' => $info);
    return (bool) $req;
  }
  else 
  {
    return "Vous devez retourner un id ou un nom";
  }
}

public function countPersonnage() 
{
  // Exécute une requête COUNT() et retourne le nombre de résultats retourné.
  $req = $db->prepare('SELECT COUNT(id) FROM Personnages');
  $req = $db->execute();
  return $req;
}

}