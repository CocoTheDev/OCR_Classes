<?php

// Create Connection
$host="localhost"; 
$root="root"; 
$root_password="root"; // Password: MAC = "root" ; Linux = ""
$dbname = "GameCocoThePimp";
$conn = mysqli_connect($host, $root, $root_password);

// Check connection
if(! $conn )
{
   echo 'Connected failure<br>';
}
else
{
  echo 'Connected successfully<br>';
}


// Create Database
$sql = "CREATE DATABASE IF NOT EXISTS GameCocoThePimp";

// Check Database
if (mysqli_query($conn, $sql)) {
   echo "Database created successfully\n";
} else {
   echo "Error creating database: " . mysqli_error($conn);
}
mysqli_close($conn);

// Create new PDO
try 
{
  $db = new PDO("mysql:host=$host;dbname=$dbname", $root, $root_password);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} 
catch (PDOException $e) 
{
  die("DB ERROR: ". $e->getMessage());
}

// Create Table Personnages
try 
{
  $db->exec("CREATE TABLE IF NOT EXISTS Personnages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(30) NOT NULL ,
    degats INT NOT NULL DEFAULT '0',
    niveau INT NOT NULL DEFAULT '1',
    experience INT NOT NULL DEFAULT '0',
    strength INT NOT NULL DEFAULT '1',
    gang enum('magicien','guerrier') NOT NULL,
    atout INT NOT NULL DEFAULT '100',
    sleep INT NOT NULL DEFAULT '0'
    )");
} 
catch (PDOException $e) 
{
  die("DB ERROR: ". $e->getMessage());
}


// On enregistre notre autoload.
function chargerClasse($classname)
{
  require $classname.'.php';
}

spl_autoload_register('chargerClasse');

session_start(); // On appelle session_start() APRÈS avoir enregistré l'autoload.

if (isset($_GET['deconnexion']))
{
  session_destroy();
  header('Location: .');
  exit();
}

$manager = new PersonnagesManager($db);

if (isset($_SESSION['perso'])) // Si la session perso existe, on restaure l'objet.
{
  $perso = $_SESSION['perso'];
}

if (isset($_POST['creer']) && isset($_POST['nom'])) // Si on a voulu créer un personnage.
{
  if ($_POST['classeSelected'] == 'magicien')
  {
    $perso = new Magicien (['nom' => $_POST['nom'], 'niveau' => 1, 'gang' => 'magicien']);
  }
  else 
  {
    $perso = new Guerrier (['nom' => $_POST['nom'], 'niveau' => 1, 'gang' => 'guerrier']);
  }

  if (isset($perso))
  {
    if (!$perso->nomValide())
    {
      $message = 'Le nom choisi est invalide.';
      unset($perso);
    }
    elseif ($manager->exists($perso->nom()))
    {
      $message = 'Le nom du personnage est déjà pris.';
      unset($perso);
    }
    else
    {
      $manager->add($perso);
    }
  }
}

elseif (isset($_POST['utiliser']) && isset($_POST['nom'])) // Si on a voulu utiliser un personnage.
{
  if ($manager->exists($_POST['nom'])) // Si celui-ci existe.
  {
    $perso = $manager->get($_POST['nom']);
  }
  else
  {
    $message = 'Ce personnage n\'existe pas !'; // S'il n'existe pas, on affichera ce message.
  }
}

elseif (isset($_POST['fillbdd']))
{
  $manager->fillBdd();
}

elseif (isset($_POST['deletebdd']))
{
  $manager->deleteBdd();
}

elseif (isset($_GET['switcherPerso']))
{
  $perso = $manager->get($_GET['switcherPerso']);
}

elseif (isset($_GET['seFaitEndormir']))
{ 
  $persoAEndormir = $manager->get($_GET['seFaitEndormir']);
  $perso->endormir($persoAEndormir);  
  $manager->update($persoAEndormir);
  $manager->update($perso);
  echo "\nVous venez d'endormir ".$persoAEndormir->nom()."\n";
}




elseif (isset($_GET['frapper'])) // Si on a cliqué sur un personnage pour le frapper.
{
  if (!isset($perso))
  {
    $message = 'Merci de créer un personnage ou de vous identifier.';
  }
  
  else
  {
    if (!$manager->exists( $_GET['frapper']))
    {
      $message = 'Le personnage que vous voulez frapper n\'existe pas !';
    }
    
    else
    {
      $persoAFrapper = $manager->get($_GET['frapper']);
      
      $retour = $perso->frapper($persoAFrapper); // On stocke dans $retour les éventuelles erreurs ou messages que renvoie la méthode frapper.
      
      switch ($retour)
      {
        case Personnage::CEST_MOI :
          $message = 'Mais... pourquoi voulez-vous vous frapper ???';
          break;
        
        case Personnage::PERSONNAGE_FRAPPE :
          $message = 'Le personnage a bien été frappé !';
          
          $manager->update($persoAFrapper);
          $manager->update($perso);
          
          break;
        
        case Personnage::PERSONNAGE_TUE :
          $message = 'Vous avez tué ce personnage !';
          
          $perso->gagnerNiveau();
          $manager->update($perso);
          $manager->delete($persoAFrapper);
          
          break;
      }
    }
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>TP : Mini jeu de combat</title>
    <meta charset="utf-8" />
  </head>
  <body>
    <p>Nombre de personnages créés : <?= $manager->count() ?></p>
<?php
if (isset($message)) // On a un message à afficher ?
{
  echo '<p>', $message, '</p>'; // Si oui, on l'affiche.
}

if (isset($perso)) // Si on utilise un personnage (nouveau ou pas).
{
?>
    <p><a href="?deconnexion=1">Déconnexion</a></p>
    
    <fieldset>
      <legend>Mes informations</legend>
      <p>
        Id : <?= $perso->id() ?><br />
        Nom : <?= htmlspecialchars($perso->nom()) ?><br />
        Classe : <?= $perso->gang() ?><br />
        Dégâts : <?= $perso->degats() ?><br />
        Niveau : <?= $perso->niveau() ?><br />
        Force : <?= $perso->strength() ?><br />
        Expérience : <?= $perso->experience() ?><br />
        Atout : <?= $perso->atout() ?>%<br />
        Satut : <?= $perso->statut() ?><br />
      </p>
      <?php
      if ($perso->statut() == 'Endormi'){
          echo "<p>Ce personnage se réveillera dans: ". $perso->seReveiller()."</p>";
        }
        ?>
    </fieldset>

    <fieldset>
      <legend>Gestion BDD</legend>
      <form action="" method="post">
      <p>
        <input type="submit" value="Remplir la BDD" name="fillbdd" />
        <input type="submit" value="Supprimer la BDD" name="deletebdd" />
      </p>
    </form>
    </fieldset>
    
    <fieldset>
      <legend>Qui frapper ?</legend>
      <p>
    <?php
    $persos = $manager->getList($perso->nom());

    if (empty($persos))
    {
      echo 'Personne à frapper !';
    }

    else
    {
      foreach ($persos as $unPerso)
      {
        echo 
        '<h3>'.
        htmlspecialchars($unPerso->nom()).
        '</h3><p>'.
        ' (id: '.$unPerso->id().
        ' | Dégâts : '. $unPerso->degats(). 
        ' | Niveau : '. $unPerso->niveau(). 
        ' | Force : '. $unPerso->strength(). 
        ' | Classe : '. $unPerso->gang(). 
        ' | Statut : '. $unPerso->statut(). 
        ')</p><br />';
        
        if ($unPerso->statut() == 'Endormi'){
          echo "<p>Ce personnage se réveillera dans: ". $unPerso->seReveiller()."</p>";
        }
        ?>
        <p>
        <!-- Frapper un personnage -->
        <form action="" method="get">
          <input type="hidden" value="<?= $unPerso->nom() ?>" name="frapper" />
          <?php
          if ($perso->statut() == 'Réveillé')
            {
              echo "<input type='submit' value='Frapper ce personnage'/>";
            }
          else
            {
              $messageStatut = 'Vous dormez';
            }

          ?>
        </form>
        <?php
        // Endormir le personnage
        if ($perso->gang() == 'magicien' && $unPerso->statut() == 'Réveillé')
        { echo "
        <form action='' method='get'>
          <input type='hidden' value='".$unPerso->nom()."' name='seFaitEndormir' />
          <input type='submit' value='Lancer un sort sur ce personnage'/>
        </form>
        ";
        }
        ?>
        <!-- Changer de personnage -->
        <form action="" method="get">
          <input type="hidden" value="<?= $unPerso->nom() ?>" name="switcherPerso" />
          <input type="submit" value="Échanger avec ce personnage"/>
        </form>
        </p>
        <hr>
        <br>
        <?php
      }
    }
    ?>
          </p>
        </fieldset>
    <?php
}
else
{
?>
    <form action="" method="post">
      <p>
        Nom : <input type="text" name="nom" maxlength="50" />

        <select name = "classeSelected">   
            <option value = "magicien">Magicien</option> 
            <option value = "guerrier">Guerrier</option>  
        </select> <br><br>

        <input type="submit" value="Créer ce personnage" name="creer" />
        <input type="submit" value="Utiliser ce personnage" name="utiliser" /><br><br>
      </p>
    </form>

    <fieldset>
      <legend>Gestion BDD</legend>
      <form action="" method="post">
      <p>
        <input type="submit" value="Remplir la BDD" name="fillbdd" />
        <input type="submit" value="Supprimer la BDD" name="deletebdd" />
      </p>
    </form>
    </fieldset>
    <?php
}
?>
  </body>
</html>
<?php
if (isset($perso)) // Si on a créé un personnage, on le stocke dans une variable session afin d'économiser une requête SQL.
    {
      $_SESSION['perso'] = $perso;
    }

?>

