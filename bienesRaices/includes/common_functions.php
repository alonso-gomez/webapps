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
?>