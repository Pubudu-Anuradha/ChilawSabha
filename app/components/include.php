<?php
$components = [
  'Input/Text',
  'Input/Time',
  'Input/Group',
  'Input/File',
  'Input/Other',
  'Pagination/Top and Bottom',
  'Table/Table',
  'Slideshow/Slideshow',
  'Modal/Modal',
  'Errors/Errors',
  'viewCounter',
];
foreach($components as $component){
  require_once "app/components/$component.php";
}