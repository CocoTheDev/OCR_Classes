<?php
class Personnage
{
  private $_id,
          $_degats,
          $_nom,
          $_niveau,
          $_experience,
          $_strength;
  
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

  public function experience() 
  {
    return $this->_experience;
  }

  public function niveau() 
  {
    return $this->_niveau;
  }

  public function strength() 
  {
    return $this->_strength;
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
      if ($degats >= 0)
      {
          $this->_degats = $degats;
      }
      else 
      {
          return "Dégats non valide (0<x>100)";
      }
  }

  public function setExperience($experience)
  {
      $experience = (int) $experience;
      if ($experience >= 0)
      {
          $this->_experience = $experience;
      }
      else 
      {
          return "Expérience reçue non valide";
      }
  }

  public function setNiveau($niveau)
  {
      $niveau = (int) $niveau;
      if ($niveau > 0)
      {
          $this->_niveau = $niveau;
      }
      else 
      {
          return "Niveau non valide";
      }
  }

  public function setStrength($strength)
  {
      $strength = (int) $strength;
      if ($strength > 0)
      {
          // Ici on set la force par rapport au niveau du perso
          $this->_strength = $this->_niveau*5;
      }
      else 
      {
          return "Force non valide";
      }
  }

  // DO METHODS
  public function frapper(Personnage $persoAFrapper)
  {
    // Avant tout : vérifier qu'on ne se frappe pas soi-même.
    // Si c'est le cas, on stoppe tout en renvoyant une valeur signifiant que le personnage ciblé est le personnage qui attaque.  
    // On indique au personnage frappé qu'il doit recevoir des dégâts.

    if ($persoAFrapper->id() == $this->_id) 
    {
        return self::CEST_MOI;
    }
    else 
    {
        $store = $persoAFrapper->_niveau;
        $this->gagnerExperience($store);
        $store2 = $this->_strength;
        return $persoAFrapper->recevoirDegats($store2);
    }
    
  }
  
  public function recevoirDegats($forceFrappeur)
  {
    // On augmente les dégâts proportionnellement à la force.
    // Si on a 100 de dégâts ou plus, la méthode renverra une valeur signifiant que le personnage a été tué.
    // Sinon, elle renverra une valeur signifiant que le personnage a bien été frappé.

    // Ici on incrémente les dégâts par rapport à la force du frappeur
    $this->_degats = $this->_degats+$forceFrappeur;

    // ici on peut set la vie de nos perso avant qu'ils meurent
    if ($this->_degats >= 250*$this->_niveau) 
    {
        return self::PERSONNAGE_TUE;
    }
    else 
    {
        return self::PERSONNAGE_FRAPPE;
    }
  }

  public function gagnerExperience($adversaireNiveau)
  {
    // Ici on set l'expérience gagnée après chaque frappe
    $this->_experience = $this->_experience + $adversaireNiveau*3;
    // Ici on set l'expérience requise pour passer de niveau
    if ($this->_experience >= 100*$this->_niveau) 
    {
        $this->gagnerNiveau();
        $this->setStrength($this->_strength);
        $this->_experience = 0;
    }
  }

  public function gagnerNiveau()
  {
    $this->_niveau += 1;
    $this->gagnerStrength();
  }

  public function gagnerStrength()
  {
    $this->_strength += 1;
  }

  public function nomValide()
  {
    return !empty($this->_nom);
  }

}

