<?php
abstract class Personnage
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
  }

  public function hydrate(array $donnees) 
  {
    if (!empty($donnees)) 
    {
        foreach ($donnees as $key => $value) 
        {
          $method = 'set'.ucfirst($key);
          if (method_exists($this, $method))
          {
              $this->$method($value);
          }
        }
    }
    else
    {
      return "Pas de données à hydrater";
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
    $this->id = $id;
  }

  public function setNom($nom) 
  {
    $nom = (string) $nom;
    $this->nom = $nom;
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
      return "Les dégats doivent être positifs";
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
      return "L'expérience ne peut pas être négative";
    }
  }

  public function setNiveau($niveau)
  {
    $niveau = (int) $niveau;
    if ($niveau > 0)
    {
      $this->niveau = $niveau;
    }
    else 
    {
      return "Le niveau doit être positif";
    }
  }

  public function setStrength($niveau)
  {
    $niveau = (int) $niveau;
    if ($niveau > 0)
    {
      // Ici on set la force par rapport au niveau du perso
      $this->strength = $this->niveau * 5;
    }
    else 
    {
      return "Votre niveau est suspect";
    }
  }

  public function setAtout($atout)
  {
    if ($atout >= 0 && $atout <= 100)
    {
      $this->atout = $atout;
    }
    else 
    {
      return "Atout non valide";
    }
  }

  public function setSleep($time)
  {
    $time = (int) $time;
    $this->sleep = $time;
  }


  // DO METHODS
  public function frapper(Personnage $persoAFrapper)
  {
    // Avant tout : vérifier qu'on ne se frappe pas soi-même.
    // Si c'est le cas, on stoppe tout en renvoyant une valeur signifiant que le personnage ciblé est le personnage qui attaque.  
    // On indique au personnage frappé qu'il doit recevoir des dégâts.
    // checker si le personnage frappé n'est pas endormi

    if ($persoAFrapper->sleep() <= time())
    {
      if ($persoAFrapper->id() === $this->id()) 
      {
          return self::CEST_MOI;
      }
      else 
      {
        $this->gagnerExperience($persoAFrapper->niveau);
        return $persoAFrapper->recevoirDegats($this->strength);
      }
    }
    else 
    {
      return "Votre personnage dort, il ne peut pas agir.";
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
      // Probleme avec cette section, l'exp gagnée n'est pas correcte ainsi que les passages de niveau@
      for ($x = $this->experience; $x>=100; $x = $x -100)
      {
      $this->gagnerNiveau();
      $this->experience = $x;
      }
    }
  }

  public function gagnerNiveau()
  {
    $this->niveau += 1;
    $this->setStrength($this->niveau);
    $this->setAtout(100);
  }

  public function nomValide()
  {
    return !empty($this->nom);
  }

  public function statut()
  {
    if ($this->sleep < time())
    {
      return 'Réveillé';
    }
    else
    {
      return 'Endormi';
    }
  }

  public function seReveiller()
  {
    $secondes = $this->sleep;
    $secondes -= time();
    
    $heures = floor($secondes / 3600);
    $secondes -= $heures * 3600;
    $minutes = floor($secondes / 60);
    $secondes -= $minutes * 60;
    
    $heures .= $heures <= 1 ? ' heure' : ' heures';
    $minutes .= $minutes <= 1 ? ' minute' : ' minutes';
    $secondes .= $secondes <= 1 ? ' seconde' : ' secondes';
    
    return $heures . ', ' . $minutes . ' et ' . $secondes;
  }











}
