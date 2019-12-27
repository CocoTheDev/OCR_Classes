<?php
class Magicien extends Personnage
{

  public function endormir(Personnage $perso)
  {
    if ($this->id() !== $perso->id())
    {
      if (time() >= $perso->sleep())
      {
        if ($this->atout() > 0)
        {
          $timeWakeUp = time() + 60*$this->atout();
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
    else
    {
      echo "Vous ne pouvez pas vous endormir vous-même.";
    }
  }
}