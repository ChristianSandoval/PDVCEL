<?php
session_start();
$conn = mysqli_connect(
  'localhost',
  //'67.23.237.158',
  'programa_lenceria',
  'r!7A.d01',
  'programa_farmaciagenemax'
) or die(mysqli_erro($mysqli));
?>