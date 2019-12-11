<?php


class Test {

  public $_lol = 1;

  private static $_compteur = 0;

  public function __construct () {
    echo "une classe de plus a été créé :) \n";
    self::$_compteur++;
    echo "Voici la valeur du compteur: " .self::$_compteur."\n\n\n";
  }

  public static function getCount() {
    return self::$_compteur;
  }

}

$perso = new Test;
$perso = new Test;
$perso = new Test;

// Print les vars et méthodes de la classe
print_r(get_class_vars(Test));
print_r(get_class_methods(Test));