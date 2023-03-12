<?php

function get_max_results( $config )
{
  return $config['db']['max_results'];
}

function array_to_string( $arr, $delim=',' )
{
  if (!is_array($arr)) return $arr;
  return implode($delim, $arr);
}

function wrap_array_values( $arr, $wrapper='\'' )
{
  if (!is_array($arr)) return $wrapper.$arr.$wrapper;
  foreach ($arr as $key => $value) $arr[$key] = $wrapper.$value.$wrapper;
  return $arr;
}

function parse_date( $input, $format )
{
  preg_match(
      "/(?P<year>\d\d\d\d)?(?:[ ]*[-\/\.]?[ ]*(?P<month>1[012]|0?[1-9])?)?(?:[ ]*[-\/\.]?[ ]*(?P<day>[12][0-9]|3[01]|0?[1-9])?)?/",
       $input,
       $matches);

  #print_r($matches); print("<br />\n");

  if ($format == "Y" && $matches['year']) return $matches['year'];
  else if ($format == "m" && $matches['month']) return $matches['month'];
  else if ($format == "d") return $matches['day'];
  else return false;
}

function fix_input( $input, $operation='=' )
{
  $op = '';
  $value = $input;
  $op_string = array();
  if ($i = strspn($value, '<'))
  {
    $op .= '<';
    $value = substr($value, $i);
  }
  else if ($i = strspn($value, '>'))
  {
    $op .= '>';
    $value = substr($value, $i);
  }
  if ($i = strspn($value, '='))
  {
    $op .= '=';
    $value = substr($value, $i);
  }
  if ($op) $op_string['op'] = $op;
  else $op_string['op'] = $operation;
  if ($operation === ' LIKE ') $op_string['value'] = '%'.$value.'%';
  else $op_string['value'] = $value;
  return $op_string;
}

function read_get( $get, $config )
{
  $return = array();
  $where = array();
  $order = array();
  $limit = array();
  if (is_array($get))
  {
    if ($get['date'])
    {
      $date = fix_input($get['date']);
      if (($year = parse_date($date['value'], "Y")))
      {
        $where['year']['op'] = $date['op'];
        $where['year']['value'] = $year;
      }
      if (($month = parse_date($date['value'], "m")))
      {
        $where['month']['op'] = $date['op'];
        $where['month']['value'] = $month;
      }
      if (($day = parse_date($date['value'], "d")))
      {
        $where['day']['op'] = $date['op'];
        $where['day']['value'] = $day;
      }
    }
    if ($get['longitude']) $where['longitude'] = fix_input($get['longitude']);
    if ($get['latitude']) $where['latitude'] = fix_input($get['latitude']);
    if ($get['mag']) $where['magnitude'] = fix_input($get['mag']);
    if ($get['depth']) $where['depth'] = fix_input($get['depth']);
    if ($get['location']) $where['location'] = fix_input($get['location'], ' LIKE ');
    if ($get['start']) $limit['low'] = max(intval($get['start']), 0);
    else $limit['low'] = 0;
    if ($get['end']) $limit['high'] = $get['end'];
    else $limit['high'] = get_max_results($config);

    $return['where'] = $where;
    $return['order'] = $order;
    $return['limit'] = $limit;
    
  }
  return $return;
}

?>
