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
 * File: admin/modules/circulation/ajax_action.php - Circulation AJAX Process 
 * @namespace Senayan.admin.modules.circulation
 */

require '../../../sysconfig.inc.php';

// quick return
if (isset($_POST['quickReturnID'])) {
    echo '<script type="text/javascript">'."\n";
    echo 'parent.setContent(\'circulationLayer\', \''.MODULES_WEB_ROOT_DIR.'circulation/circulation_action.php\', \'post\', \'quickReturnID='.trim($_POST['quickReturnID']).'\');'."\n";
    echo 'parent.$(\'quickReturnID\').value = \'\';'."\n";
    echo 'parent.$(\'quickReturnID\').focus();'."\n";
    echo '</script>';
    exit();
}
?>
