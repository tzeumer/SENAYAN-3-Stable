<?php
##
#  Copyright (C) 2009  Tobias Zeumer (github@verweisungsform.de)
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
 * File: lib/lang/localisation.php - Common Variables
 * @namespace Senayan.lib.lang
 * 
 * Purpose of   this file
 * 1.   Add support for gettext, even   if the php extension is not
 *      available   (with   php-gettext)
 * 2.   Supply an   array   that lists all available translations   (main
 *      purpose is to   use it for creating html selects to change language)
 *
 * @todo    Maybe   change $available_languages to just list the native
 *              language name   (well, useres   should be   able to find their own
 *              language,   shouldn't   they?) :)
 * @note    The gettext library might be used, if   it is   available.
 *              The problem is that mo files are cached by the extension,   so a
 *              server restart is   necessary   if these files are updated (e.g. by
 *              a   senayan update). I replaced all _('') with  __(''), so
 *              php-gettext is always used, thus circumventing  this problem.
 *              Obviously   there   is no   real speed disadvantage, since this is the
 *              way wordpress   does it.
 *              Developers should use __('') and _ngettext in code! 
 */

// set php-gettext library
require LANGUAGES_BASE_DIR.'php-gettext'.DIRECTORY_SEPARATOR.'gettext.inc';

// gettext setup
$locale = $sysconf['default_lang'];
$domain = 'messages';
$encoding = 'UTF-8';

// set language to use
T_setlocale(LC_ALL, $locale);
// set locales dictionary location
_bindtextdomain($domain, LANGUAGES_BASE_DIR.'locale');
// codeset
_bind_textdomain_codeset($domain, $encoding);
// set .mo filename to use
_textdomain($domain);

// Array with available translations
// $available_languages[] = array('CODE', __('ENGLISH NAME'), 'NATIVE NAME');
$available_languages[] = array('de_DE', __('German'), 'Deutsch');
$available_languages[] = array('en_US', __('English'), 'English');
$available_languages[] = array('id_ID', __('Indonesian'), 'Indonesia');
?>
