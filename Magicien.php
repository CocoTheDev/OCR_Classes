<?php
class Magicien extends Personnage
{

  public function __construct()
  {
    
  }

  public function endormir(Personnage $perso)
  {
    $timeNow = strtotime('now');
    if ($timeNow >= $perso->sleep())
    {
      if ($this->atout() > 0)
      {
        $timeWakeUp = $timeNow + 60*$this->atout();
        $perso->setSleep($timeWakeUp);
        $this->setAtout(0);
      }
      else 
      {
        echo "Vous n'avez pas assez de magie";
      }
    }
    else
    {
      echo "Ce personnage dort déjà";
    }
  }
}