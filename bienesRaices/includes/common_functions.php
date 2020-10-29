<?
  function printMsg($msg,$msg_type){
    echo '<div class="'.$msg_type.'">';
    if(is_array($msg)){
      echo "<ul>";
      foreach($msg as $caca) {
        echo "<li>$caca</li>";
      }
      echo "</ul>";
    }
    else {
      echo $msg;
    }
    echo '</div>';
  }

  // Lógica de cierre de sesión
  if(isset($_GET['logOff']) && $_GET['logOff'] == "true") {
    //When in doubt, ask Metallica
    session_destroy();
    header('Location: login.php?loggedOff=true');
  }
?>