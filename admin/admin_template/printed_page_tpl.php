<?php
##
#  SENAYAN application printable data configuration
# 
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
 * File: admin/admin_template/printed_page_tpl.php - printed_page_tpl - Undocumented
 * @namespace Senayan.admin.template
 */
 ?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head><title><?php echo $page_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo SENAYAN_WEB_ROOT_DIR.'template/printed.style.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo SENAYAN_WEB_ROOT_DIR.'admin/'.$sysconf['admin_template']['css']; ?>" />
<?php if (isset($css)) { echo $css; } ?>
<style type="text/css">
body { background: #FFFFFF; }
</style>
<?php if (isset($js)) { echo $js; } ?>
</head>
<body>
<div id="pageContent">
<?php echo $content; ?>
</div>
</body>
</html>
