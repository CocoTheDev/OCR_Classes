<?php
class Personnage
{
  protected $id,
            $degats,
            $nom,
            $niveau,
            $experience,
            $strength,
            $atout,
            $sleep,
            $gang;
  
  const CEST_MOI = 1;
  const PERSONNAGE_TUE = 2;
  const PERSONNAGE_FRAPPE = 3;
  
  public function __construct(array $donnees)
  {
    $this->hydrate($donnees);
    $this->gang = strtolower(static::class);
    $this->setSleep(strtotime('now'));
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
    return $this->id;
  }

  public function nom() 
  {
    return $this->nom;
  }

  public function degats() 
  {
    return $this->degats;
  }

  public function experience() 
  {
    return $this->experience;
  }

  public function niveau() 
  {
    return $this->niveau;
  }

  public function strength() 
  {
    return $this->strength;
  }

  public function atout() 
  {
    return $this->atout;
  }

  public function gang() 
  {
    return $this->gang;
  }

  public function sleep() 
  {
    return $this->sleep;
  }


  // SETTERS //
  public function setId($id) 
  {
    $id = (int) $id;
    if ($id >0) 
    {
        $this->id = $id;
    }
  }

  public function setNom($nom) 
  {
      if (is_string($nom))
      {
          $this->nom = $nom;
      }
  }

  public function setDegats($degats)
  {
      $degats = (int) $degats;
      if ($degats >= 0)
      {
          $this->degats = $degats;
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
          $this->experience = $experience;
      }
      else 
      {
          return "Expérience reçue non valide";
      }
  }

  public function setNiveau($niveau)
  {
    if ($niveau == TRUE)
    {
      $this->niveau = $niveau;
    }
    else 
    {
      $this->niveau = 1;
    }
  }

  public function setStrength($niveau)
  {
      $niveau = (int) $niveau;
      if ($niveau > 0)
      {
          // Ici on set la force par rapport au niveau du perso
          $this->strength = $this->niveau*5;
      }
      else 
      {
          return "Votre niveau est suspect";
      }
  }

  public function setAtout($atout)
  {
    
    ($atout >= 0 && $atout <= 100)? $this->atout = $atout : "Atout non valide";
  }

  public function setSleep($time)
  {
    $this->time = (int) $time;
  }

  // DO METHODS
  public function frapper(Personnage $persoAFrapper)
  {
    // Avant tout : vérifier qu'on ne se frappe pas soi-même.
    // Si c'est le cas, on stoppe tout en renvoyant une valeur signifiant que le personnage ciblé est le personnage qui attaque.  
    // On indique au personnage frappé qu'il doit recevoir des dégâts.
    // checker si le personnage frappé n'est pas endormi

    if ($persoAFrapper->sleep() == 0)
    {
      if ($persoAFrapper->id() == $this->id) 
      {
          return self::CEST_MOI;
      }
      else 
      {
          $store = $persoAFrapper->niveau;
          $this->gagnerExperience($store);
          $store2 = $this->strength;
          return $persoAFrapper->recevoirDegats($store2);
      }
    }
    
  }
  
  public function recevoirDegats($forceFrappeur)
  {
    // On augmente les dégâts proportionnellement à la force.
    // Si on a 100 de dégâts ou plus, la méthode renverra une valeur signifiant que le personnage a été tué.
    // Sinon, elle renverra une valeur signifiant que le personnage a bien été frappé.

    // Ici on incrémente les dégâts par rapport à la force du frappeur
    $this->degats = $this->degats+$forceFrappeur;

    // ici on peut set la vie de nos perso avant qu'ils meurent
    if ($this->degats >= 250*$this->niveau) 
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
    $this->experience = $this->experience + $adversaireNiveau*3;
    // Ici on set l'expérience requise pour passer de niveau
    if ($this->experience >= 100*$this->niveau) 
    {
        $this->gagnerNiveau();
        $this->setStrength($this->strength);
        $this->experience = 0;
    }
  }

  public function gagnerNiveau()
  {
    $this->niveau += 1;
    $this->gagnerStrength();
  }

  public function gagnerStrength()
  {
    $this->strength += 1;
  }

  public function nomValide()
  {
    return !empty($this->nom);
  }

  public function statut()
  {
    if ($this->sleep < strtotime('now'))
    {
      return "Réveillé";
    }
    else
    {
      return "Endormi";
    }
  }

}
