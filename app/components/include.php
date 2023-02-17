<?php
$components = [
  'Input/Text',
  'Input/Time',
  'Input/Group',
  'Input/File',
  'Input/Other'
];
foreach($components as $component){
  require_once "app/components/$component.php";
}