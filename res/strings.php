<?php

$messages = array(
  "db" => array(
    "could-not-connect" => "Could not connect to the database: ",#.mysqli_error(), # Needs to be `mysqli_error($msqli), but $msqli is not defined in context.
    "could-not-query" => "Could not fetch database query: "#.mysqli_error()
  )
);

$mysql = array(
  "show-columns" => "SHOW COLUMNS FROM ",
  "select-all" => "SELECT * FROM "
);

$aliases = array(
  "year" => "Year",
  "month" => "Month",
  "day" => "Day",
  "latitude" => "Latitude (N)",
  "longitude" => "Longitude (W)",
  "depth" => "Depth (km)",
  "hours" => "Hours",
  "minutes" => "Minutes",
  "seconds" => "Seconds",
  "magnitude" => "Mag/Int",
  "location" => "Location",
  "source_cat" => "Source Catalog"
);

?>
