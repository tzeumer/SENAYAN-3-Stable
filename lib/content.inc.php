<?php
##
#  Copyright (C) 2007,2008  Arie Nugraha (dicarve@yahoo.com), Hendro Wicaksono (hendrowicaksono@yahoo.com)
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
 * Class for showing content from database
 * 
 * @namespace Senayan.lib
 * @author Arie Nugraha (dicarve@yahoo.com), Hendro Wicaksono (hendrowicaksono@yahoo.com)
 * @copyright 2007,2008
 * @version $Id$
 * @access public
 */
class content
{
    public $strip_html = false;
    public $allowed_tags = null;

    public function get($obj_db, $str_path = '')
    {
        $_path = strtolower(trim($str_path));
        if (!$_path) {
            return;
        }

        if (preg_match('@^admin.+@i', $_path)) {
            $_unauthorized = !isset($_SESSION['uid']) AND !isset($_SESSION['uname']) AND !isset($_SESSION['realname']);
            if ($_unauthorized) {
                return;
            }
        }
        // query content
        $_content_q = $obj_db->query('SELECT * FROM content WHERE content_path=\''.($obj_db->escape_string($_path)).'\'');
        // get content data
        $_content_d = $_content_q->fetch_assoc();
        if (!$_content_d['content_title'] OR !$_content_d['content_path']) {
            return false;
        } else {
            $_content['Title'] = $_content_d['content_title'];
            $_content['Path'] = $_content_d['content_path'];
            $_content['Content'] = $_content_d['content_desc'];
            // strip html
            if ($this->strip_html) {
                $_content['Content'] = strip_tags($_content['Content'], $this->allowed_tags);
            }

            return $_content;
        }
    }
}

?>
