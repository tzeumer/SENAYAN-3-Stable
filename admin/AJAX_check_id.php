<?php
##
#  Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com)
# 
#  This program is free software; you can redistribute it and/or modify
#  it under the terms of the GNU General Public License as published by
#  the Free Software Foundation; either version 2 of the License, or
#  (at your option) any later version.
# 
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
# 
#  You should have received a copy of the GNU General Public License
#  along with this program; if not, write to the Free Software
#  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
##

/**
 * File: admin/AJAX_check_id.php - A Handler script for AJAX ID checking
 * @namespace Senayan.admin.ajax
 */

require_once '../sysconfig.inc.php';
// session checking
require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';

$table_name = $dbs->escape_string(trim($_POST['tableName']));
$table_fields = $dbs->escape_string(trim($_POST['tableFields']));
if (isset($_POST['id']) AND !empty($_POST['id'])) {
    $id = $dbs->escape_string(trim($_POST['id']));
} else {
    die('<strong style="color: #FF0000;">No ID Supplied!</strong>');
}

// sql string
$sql_string = "SELECT $table_fields FROM $table_name WHERE $table_fields='$id' LIMIT 1";

// send query to database
$query = $dbs->query($sql_string);
$error = $dbs->error;
if ($error) {
    die('SQL ERROR : '.$error);
}

if ($query->num_rows > 0) {
    echo '<strong style="color: #FF0000;">ID Already exists! Please use another ID</strong>';
} else {
    // output the SQL string
    echo '<strong>ID Available</strong>';
}
?>
