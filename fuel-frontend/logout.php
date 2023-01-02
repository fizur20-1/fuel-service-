<?php
//session_start();
if (isset($_COOKIE['JSESSIONID'])) {
  setcookie('JSESSIONID', '', 0, "/");
}

try {
  header("location: index.php");
} catch (Exception $e) {
  //header("location: ../../../View/home.php");
}
// if (session_destroy()) {
//   if (isset($_COOKIE['JSESSIONID'])) {
//     setcookie('JSESSIONID', '', 0, "/");
//   }

//   try {
//     header("location: index.php");
//   } catch (Exception $e) {
//     //header("location: ../../../View/home.php");
//   }
// }
