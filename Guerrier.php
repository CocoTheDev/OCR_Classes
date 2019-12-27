<?php
class Guerrier extends Personnage
{

  public function recevoirDegats($forceFrappeur)
  {
    // On augmente les dégâts proportionnellement à la force.
    // Si on a 100 de dégâts ou plus, la méthode renverra une valeur signifiant que le personnage a été tué.
    // Sinon, elle renverra une valeur signifiant que le personnage a bien été frappé.

    // Ici on incrémente les dégâts par rapport à la force du frappeur, et on diminue les degats par rapport à l'atout du guerrier
    if ($this->atout() > 0)
    {
      $this->degats = $this->degats+$forceFrappeur*0.20;
      $this->setAtout($this->atout()-20);
    }
    else
    {
      $this->degats = $this->degats+$forceFrappeur;
    }


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






}