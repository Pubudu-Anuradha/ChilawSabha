<?php
$components = [
  'Input/Text',
  'Input/Time',
  'Input/Group',
  'Input/File',
  'Input/Other',
  'Pagination/Top and Bottom',
  'Table/Table'
];
foreach($components as $component){
  require_once "app/components/$component.php";
}