<?php

$config = array(
  "db" => array(
    "host" => "mysql.cefns.nau.edu",
    "table" => "eq_data",
    "dbname" => "earthquake",
    "username" => "eq-read",
    "password" => "b5JqeLvRHDeREhJG",
    "shown_fields" => "*",
    #"shown_fields" => array(
    #  "year",
    #  "month",  
    #  "day",
    #  "latitude",
    #  "longitude",
    #  "depth",
    #  "hours",
    #  "minutes",
    #  "seconds",
    #  "magnitude",
    #  "location"
    #),
    "max_results" => 100
  ),
  "form" => array(
    "fields" => array(
      "year",
      "latitude",
      "longitude",
      "depth",
      "magnitude",
      "location"
    )
  ),
  "paths" => array(
    "res" => "/res",
    "img" => array(
      "content" => "/img/content",
      "layout" => "/img/layout"
    )
  )
);

?>
