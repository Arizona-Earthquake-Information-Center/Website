<?php

function generate_form( $config, $get )
{
  echo '      <form name="query" action="db.php" method="get">';echo "\n";
  echo '        <table class="form">';echo "\n";
  echo '          <tr id="row1">';echo "\n";
  echo '            <td>Date<sup>(1)</sup>: <input type="text" name="date" ' .
       'value="'.htmlspecialchars($_GET['date']).'" /></td>';echo "\n";
  echo '            <td>Latitude (N): <input type="text" name="latitude" ' .
       'value="'.htmlspecialchars($_GET['latitude']).'"  /></td>';echo "\n";
  echo '          </tr>';echo "\n";
  echo '          <tr id="row2">';echo "\n";
  echo '            <td>Longitude (W): <input type="text" name="longitude" ' .
       'value="'.htmlspecialchars($_GET['longitude']).'" /></td>';echo "\n";
  echo '            <td>Depth (km): <input type="text" name="depth" ' .
       'value="'.htmlspecialchars($_GET['depth']).'" /></td>';echo "\n";
  echo '          </tr>';echo "\n";
  echo '          <tr id="row3">';echo "\n";
  echo '            <td>Mag/Int: <input type="text" name="mag" ' .
       'value="'.htmlspecialchars($_GET['mag']).'" /></td>';echo "\n";
  echo '            <td>Location: <input type="text" name="location" ' .
       'value="'.htmlspecialchars($_GET['location']).'" /></td>';echo "\n";
  echo '          </tr>';echo "\n";
  echo '        </table>';echo "\n";
  echo '        <small>1) Date may accept any time in the general form YYYY-MM-DD or a 4-digit number for a year or a 2-digit number for a month.</small><br />';echo "\n";
  echo '        <small>All numerical values (including dates) may accept <, <=, >, and >=.</small><br />';echo "\n";
  echo '        <input id="apply" type="submit" value="Apply Filters" />';echo "\n";
  echo '      </form>';echo "\n";
}

function generate_navigation( $get, $count, $max_results, $form )
{
  $first = 0;
  $overflow = $count;
  while ($overflow > $max_results)
  {
    $overflow -= $max_results;
  }
  $last = $count - $overflow;

  $prev = max(intval($get['start']) - $max_results, $first);
  $next = min(intval($get['start']) + $max_results, $last);

  $disp_low = intval($get['start']) + 1;
  $disp_high = min(intval($get['start']) + $max_results, $count);

  $high = $max_results+$prev;

  $query = '?';
  foreach ($get as $key => $value)
  {
    if ($value && in_array($key, $form))
    {
      $query .= htmlspecialchars($key).'='.htmlspecialchars($value).'&';
    }
  }

  echo '        <a href="'.$query.'start='.$first.'" class="left">First</a>';
  echo '&nbsp;&nbsp;';echo "\n";
  echo '        <a href="'.$query.'start='.$prev.'" class="left">Prev</a>';
  echo '&nbsp;&nbsp;';echo "\n";
  echo '        <div id="count" class="left">'.$disp_low.' to ' .$disp_high.' (of ' .$count.')</div>';echo "\n";
  echo '        <a href="'.$query.'start='.$next.'" class="left">Next</a>';
  echo '&nbsp;&nbsp;';echo "\n";
  echo '        <a href="'.$query.'start='.$last.'" class="left">Last</a>';echo "\n";
}

?>
