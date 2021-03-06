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
 * File: admin/modules/system/index.php - Global application configuration 
 * @namespace Senayan.admin.modules.system
 */

if (!defined('SENAYAN_BASE_DIR')) {
    // main system configuration
    require '../../../sysconfig.inc.php';
    // start the session
    require SENAYAN_BASE_DIR.'admin/default/session.inc.php';
}

// only administrator have privileges to change global settings
if ($_SESSION['uid'] != 1) {
    header('Location: '.MODULES_WEB_ROOT_DIR.'system/content.php');
    die();
}

require SENAYAN_BASE_DIR.'admin/default/session_check.inc.php';
require SIMBIO_BASE_DIR.'simbio_FILE/simbio_directory.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO_BASE_DIR.'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO_BASE_DIR.'simbio_DB/simbio_dbop.inc.php';

?>
<fieldset class="menuBox">
    <div class="menuBoxInner systemIcon">
        <?php echo strtoupper(__('System Configuration')).'<hr />'.__('Modify global application preferences'); ?>
    </div>
</fieldset>
<?php
/* main content */
/* Config Vars EDIT FORM */
/* Config Vars update process */

if (isset($_POST['updateData'])) {
    // reset/truncate setting table content
    // library name
    $library_name = $dbs->escape_string(strip_tags(trim($_POST['library_name'])));
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($library_name)).'\' WHERE setting_name=\'library_name\'');

    // library subname
    $library_subname = $dbs->escape_string(strip_tags(trim($_POST['library_subname'])));
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($library_subname)).'\' WHERE setting_name=\'library_subname\'');

    // initialize template arrays
    $template = array('theme' => $sysconf['template']['theme'], 'css' => $sysconf['template']['css']);
    $admin_template = array('theme' => $sysconf['admin_template']['theme'], 'css' => $sysconf['admin_template']['css']);

    // template
    $template['theme'] = $_POST['template'];
    $template['css'] = str_replace($sysconf['template']['theme'], $template['theme'], $sysconf['template']['css']);
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($template)).'\' WHERE setting_name=\'template\'');

    // admin template
    $admin_template['theme'] = $_POST['admin_template'];
    $admin_template['css'] = str_replace($sysconf['admin_template']['theme'], $admin_template['theme'], $sysconf['admin_template']['css']);
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($admin_template)).'\' WHERE setting_name=\'admin_template\'');

    // language
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($_POST['default_lang'])).'\' WHERE setting_name=\'default_lang\'');

    // opac num result
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($_POST['opac_result_num'])).'\' WHERE setting_name=\'opac_result_num\'');

    // promoted titles in homepage
    if (isset($_POST['enable_promote_titles'])) {
        $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($_POST['enable_promote_titles'])).'\' WHERE setting_name=\'enable_promote_titles\'');
    } else {
        $dbs->query('UPDATE setting SET setting_value=\'N;\' WHERE setting_name=\'enable_promote_titles\'');
    }

    // quick return
    $quick_return = $_POST['quick_return'] == '1'?true:false;
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($quick_return)).'\' WHERE setting_name=\'quick_return\'');

    // loan and due date manual change
    $allow_loan_date_change = $_POST['allow_loan_date_change'] == '1'?true:false;
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($allow_loan_date_change)).'\' WHERE setting_name=\'allow_loan_date_change\'');

    // loan limit override
    $loan_limit_override = $_POST['loan_limit_override'] == '1'?true:false;
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($loan_limit_override)).'\' WHERE setting_name=\'loan_limit_override\'');

    // xml detail
    $xml_detail = $_POST['enable_xml_detail'] == '1'?true:false;
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($xml_detail)).'\' WHERE setting_name=\'enable_xml_detail\'');

    // xml result
    $xml_result = $_POST['enable_xml_result'] == '1'?true:false;
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($xml_result)).'\' WHERE setting_name=\'enable_xml_result\'');

    // file download
    $file_download = $_POST['allow_file_download'] == '1'?true:false;
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($file_download)).'\' WHERE setting_name=\'allow_file_download\'');

    // session timeout
    $session_timeout = intval($_POST['session_timeout']) >= 1800?$_POST['session_timeout']:1800;
    $dbs->query('UPDATE setting SET setting_value=\''.$dbs->escape_string(serialize($session_timeout)).'\' WHERE setting_name=\'session_timeout\'');

    // write log
    utility::writeLogs($dbs, 'staff', $_SESSION['uid'], 'system', $_SESSION['realname'].' change application global configuration');
    utility::jsAlert(__('Settings saved. Refreshing page'));
    echo '<script type="text/javascript">parent.location.href = \'../../index.php?mod=system\';</script>';
}
/* Config Vars update process end */

// create new instance
$form = new simbio_form_table_AJAX('mainForm', $_SERVER['PHP_SELF'], 'post');
$form->submit_button_attr = 'name="updateData" value="'.__('Save Settings').'" class="button"';

// form table attributes
$form->table_attr = 'align="center" id="dataList" cellpadding="5" cellspacing="0"';
$form->table_header_attr = 'class="alterCell" style="font-weight: bold;"';
$form->table_content_attr = 'class="alterCell2"';

// load settings from database
utility::loadSettings($dbs);

// version status
$form->addAnything('Senayan Version', '<strong>'.SENAYAN_VERSION.'</strong>');

// library name
$form->addTextField('text', 'library_name', __('Library Name'), $sysconf['library_name'], 'style="width: 100%;"');

// library subname
$form->addTextField('text', 'library_subname', __('Library Subname'), $sysconf['library_subname'], 'style="width: 100%;"');

/* Form Element(s) */
// public template
// scan template directory
$template_dir = SENAYAN_BASE_DIR.$sysconf['template']['dir'];
$dir = new simbio_directory($template_dir);
$dir_tree = $dir->getDirectoryTree(1);
// sort array by index
ksort($dir_tree);
// loop array
foreach ($dir_tree as $dir) {
    $tpl_options[] = array($dir, $dir);
}
$form->addSelectList('template', __('Public Template'), $tpl_options, $sysconf['template']['theme']);

// admin template
// scan admin template directory
$admin_template_dir = SENAYAN_BASE_DIR.'admin'.DIRECTORY_SEPARATOR.$sysconf['admin_template']['dir'];
$dir = new simbio_directory($admin_template_dir);
$dir_tree = $dir->getDirectoryTree(1);
// sort array by index
ksort($dir_tree);
// loop array
foreach ($dir_tree as $dir) {
    $admin_tpl_options[] = array($dir, $dir);
}
$form->addSelectList('admin_template', __('Admin Template'), $admin_tpl_options, $sysconf['admin_template']['theme']);

// application language
require_once(LANGUAGES_BASE_DIR.'localisation.php');
$form->addSelectList('default_lang', __('Default App. Language'), $available_languages, $sysconf['default_lang']);

// opac result list number
$result_num_options[] = array('10', '10');
$result_num_options[] = array('20', '20');
$result_num_options[] = array('30', '30');
$result_num_options[] = array('40', '40');
$result_num_options[] = array('50', '50');
$form->addSelectList('opac_result_num', __('Number Of Collections To Show In OPAC Result List'), $result_num_options, $sysconf['opac_result_num'] );

// homepage setting
$promote_options[] = array('1', 'Yes');
$form->addCheckBox('enable_promote_titles', __('Show Promoted Titles at Homepage'), $promote_options, $sysconf['enable_promote_titles']?'1':'0');

// enable quick return
$options = null;
$options[] = array('0', __('Disable'));
$options[] = array('1', __('Enable'));
$form->addSelectList('quick_return', __('Quick Return'), $options, $sysconf['quick_return']?'1':'0');

// enable manual changes of loan and due date in circulation transaction
$options = null;
$options[] = array('0', __('Disable'));
$options[] = array('1', __('Enable'));
$form->addSelectList('allow_loan_date_change', __('Loan and Due Date Manual Change'), $options, $sysconf['allow_loan_date_change']?'1':'0');

// enable loan limit overriden
$options = null;
$options[] = array('0', __('Disable'));
$options[] = array('1', __('Enable'));
$form->addSelectList('loan_limit_override', __('Loan Limit Override'), $options, $sysconf['loan_limit_override']?'1':'0');

// enable bibliography xml detail
$options = null;
$options[] = array('0', __('Disable'));
$options[] = array('1', __('Enable'));
$form->addSelectList('enable_xml_detail', __('OPAC XML Detail'), $options, $sysconf['enable_xml_detail']?'1':'0');

// enable bibliography xml result set
$options = null;
$options[] = array('0', __('Disable'));
$options[] = array('1', __('Enable'));
$form->addSelectList('enable_xml_result', __('OPAC XML Result'), $options, $sysconf['enable_xml_result']?'1':'0');

// allow file attachment download
$options = null;
$options[] = array('0', __('Forbid'));
$options[] = array('1', __('Allow'));
$form->addSelectList('allow_file_download', __('Allow OPAC File Download'), $options, $sysconf['allow_file_download']?'1':'0');

// session timeout
$form->addTextField('text', 'session_timeout', __('Session Login Timeout'), $sysconf['session_timeout'], 'style="width: 10%;"');

// print out the object
echo $form->printOut();
/* main content end */
?>
