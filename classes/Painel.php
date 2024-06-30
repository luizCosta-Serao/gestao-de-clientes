<?php

  class Painel {
    public static function isLogin() {
      return isset($_SESSION['login']) ? true : false;
    }

    public static function reloadPage($url) {
      echo '<script>location.reload();</script>';
    }
  }

?>