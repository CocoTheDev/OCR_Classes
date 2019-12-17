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
  $this->_db = $db;
}


public function add(Personnage $perso) 
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
}

public function get($info) 
{
  // Si le paramètre est un entier, on veut récupérer le personnage avec son identifiant.
  // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
  // Sinon, on veut récupérer le personnage avec son nom.
  // Exécute une requête de type SELECT avec une clause WHERE, et retourne un objet Personnage.
  
  if(is_int($info))
  {
    $req = $this->_db->prepare('SELECT * FROM Personnages WHERE id= :id');
    $req->bindValue(':id', $info);
    $req->execute();

    $donnees = $req->fetch(PDO::FETCH_ASSOC);
    return new Personnage($donnees);
  }
  elseif (is_string($info))
  {
    $req = $this->_db->prepare('SELECT * FROM Personnages WHERE nom = :nom');
    $req->bindValue(':nom', $info);
    $req->execute();

    $donnees = $req->fetch(PDO::FETCH_ASSOC);
    return new Personnage($donnees);
  }
  else 
  {
    return "Données non recevable";
  }

}

public function update(Personnage $perso) 
{
  // update d'un personnage - SQL Update
  $req = $this->_db->prepare('
    UPDATE Personnages
    SET nom = :nom, degats = :degats
    WHERE id = :id
  ');
  $req->bindValue(':nom', $perso->nom());
  $req->bindValue(':degats', $perso->degats());
  $req->bindValue(':id', $perso->id());
  $req->execute();

}

public function delete(Personnage $perso) 
{
  // suppression d'un personnage - SQL Delete
  $req = $this->_db->prepare('
  DELETE FROM Personnages
  WHERE id = :id
  ');
  $req->bindValue(':id', $perso->id(), PDO::PARAM_INT);
  $req->execute();
}

public function getList($nom) 
{
  // Retourne la liste des personnages dont le nom n'est pas $nom.
  // Le résultat sera un tableau d'instances de Personnage.
  $req = $this->_db->prepare('SELECT * FROM Personnages');
  $req->execute();
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
    $req = $this->_db->prepare('SELECT COUNT(*) FROM Personnages WHERE id = :id');
    $req->execute(array(':id' => $info));
    return (bool) $req;
  }
  elseif (is_string($info))
  {
    $req = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = ?');
    $req->execute(array($info));
    return (bool) $req->fetchColumn();
  }
  else 
  {
    return "Vous devez retourner un id ou un nom";
  }
}

public function count() 
{
  // Exécute une requête COUNT() et retourne le nombre de résultats retourné.
  return $this->_db->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
}

}

