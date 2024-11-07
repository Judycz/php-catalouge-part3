<?php

function is_blank($value)
{
  return !isset($value) || trim($value) === '';
}

function is_letters($value)
{
  return preg_match("/^[a-zA-Z\s]*$/", $value);
}

function no_spaces($value)
{
  return strpos($value, " ") == FALSE;
}

function has_length_less_than($value, $max)
{
  $length = strlen($value);
  return $length <= $max;
}

?>