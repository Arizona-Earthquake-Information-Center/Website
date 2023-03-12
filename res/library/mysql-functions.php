<?php

function mysql_real_escape_array( $conn, $arr )
{
  $escaped_arr = array();
  if (!is_array($arr)) { return mysqli_real_escape_string($conn, $arr); }
  foreach ($arr as $key => $str)
  {
    $escaped_arr[$key] = mysql_real_escape_array($conn, $str);
  }
  return $escaped_arr;

}

function query_mysql( $conn, $query )
{
  $return = mysqli_query($conn, $query);
  if (!$return)
  {
    die("Could not query: ".mysqli_error($conn));
  }
  return $return;
}

function get_mysql_columns( $conn, $table )
{
  $query = 'SHOW COLUMNS FROM '.mysql_real_escape_array($conn, $table);
  return query_mysql($conn, $query);
}

function generate_mysql_query( $conn,
							   $table,
                               $columns='*',
                               $where=null,
                               $order=null,
                               $limit=array( 'low' => 0,  'high' => 100) )
{
  $table = array_to_string(mysql_real_escape_array($conn, $table));
  $columns = array_to_string(mysql_real_escape_array($conn, $columns));
  if (empty($where)) $where = '';
  else
  {
    $tmp = mysql_real_escape_array($conn, $where);
    $where = ' WHERE ';
    $and = ' AND';
    foreach ($tmp as $key => $elem)
    {
      if (!intval($elem['value'])) $where .= 'LOWER('.$key.')'.$elem['op'].'LOWER(\''.$elem['value'].'\')'.$and.' ';
      else $where .= $key.$elem['op'].$elem['value'].$and.' ';
    }
    $where = substr($where, 0, strlen($where)-strlen($and));
  }
  if (empty($order)) $order = '';
  else
  {
    #echo "ORDER:"; print_r($order);
    $order = ' ORDER BY '.array_to_string(mysql_real_escape_array($conn, $order));
  }
  if (empty($limit)) $limit = '';
  else $limit = ' LIMIT '.array_to_string(mysql_real_escape_array($conn, $limit));
  return sprintf("SELECT %s FROM %s%s%s%s;",
              $columns,
              $table,
              $where,
              $order,
              $limit
  );
}

function get_mysql_rows( $conn,
						 $table,
                         $columns='*',
                         $where=null,
                         $order=null,
                         $limit=array( 'low' => 0,  'high' => 100) )
{
  $query = generate_mysql_query($conn, $table, $columns, $where, $order, $limit);
  #print_r($query."<br />\n");
  return query_mysql($conn, $query);
}

function get_mysql_row_count( $conn,
							  $table,
                              $columns='*',
                              $where=null,
                              $order=null,
                              $limit=null )
{
  #$query = generate_mysql_query($table, 'COUNT('.array_to_string($columns).')', $where, null, null);
  $query = generate_mysql_query($conn, $table, 'COUNT(*)', $where, null, null);
  #print_r($query."<br />\n");
  return query_mysql($conn, $query);
}

?>
