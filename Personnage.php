<?php
class Personnage
{
  private $_id,
          $_degats,
          $_nom;
  
  const CEST_MOI = 1;
  const PERSONNAGE_TUE = 2;
  const PERSONNAGE_FRAPPE = 3;
  
  public function __construct(array $donnees)
  {
    $this->hydrate($donnees);
  }

  public function hydrate(array $donnees) 
  {
    if (!empty($donnees)) 
    {
        foreach ($donnees as $key => $value) 
        {
            if(isset($value))
            {
                $method = 'set'.ucfirst($key);
                if (method_exists($this, $method))
                {
                    $this->$method($value);
                }
            }
            else 
            {
                return "Il n'y a pas de valeur dans ce champ: ".$key;
            }
        }
    }

  }

  // GETTERS //
  public function id() 
  {
    return $this->_id;
  }

  public function nom() 
  {
    return $this->_nom;
  }

  public function degats() 
  {
    return $this->_degats;
  }


  // SETTERS //
  public function setId($id) 
  {
    $id = (int) $id;
    if ($id >0) 
    {
        $this->_id = $id;
    }
  }

  public function setNom($nom) 
  {
      if (is_string($nom))
      {
          $this->_nom = $nom;
      }
  }

  public function setDegats($degats)
  {
      $degats = (int) $degats;
      if ($degats >= 0 && $degats <= 100)
      {
          $this->_degats = $degats;
      }
      else 
      {
          return "Dégats non valide (0<x>100)";
      }
  }

  // DO METHODS
  public function frapper(Personnage $perso)
  {
    // Avant tout : vérifier qu'on ne se frappe pas soi-même.
    // Si c'est le cas, on stoppe tout en renvoyant une valeur signifiant que le personnage ciblé est le personnage qui attaque.  
    // On indique au personnage frappé qu'il doit recevoir des dégâts.

    if ($perso->id() == $this->_id) 
    {
        return self::CEST_MOI;
    }
    else 
    {
        return $perso->recevoirDegats();
    }
    
  }
  
  public function recevoirDegats()
  {
    // On augmente de 5 les dégâts.
    // Si on a 100 de dégâts ou plus, la méthode renverra une valeur signifiant que le personnage a été tué.
    // Sinon, elle renverra une valeur signifiant que le personnage a bien été frappé.
    $this->_degats += 5;
    if ($this->_degats >= 100) 
    {
        return self::PERSONNAGE_TUE;
    }
    else 
    {
        return self::PERSONNAGE_FRAPPE;
    }
  }

  public function nomValide()
  {
    return !empty($this->_nom);
  }

}

