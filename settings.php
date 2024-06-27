<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin administration pages are defined here.
 *
 * @package     tool_cf_turnstile
 * @category    admin
 * @copyright   2024 e-Mentor s.r.l. - service@e-mentor.it
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$settings = new admin_settingpage('tool_cf_turnstile', get_string('pluginname', 'tool_cf_turnstile'));
$ADMIN->add('server', $settings);

if($ADMIN->fulltree){

    $theme_options = array("light"=>"Light","dark"=>"Dark");

    $settings->add(new admin_setting_configcheckbox(
        'tool_cf_turnstile/enabled',
        get_string('enable', 'tool_cf_turnstile'), 
        get_string('enable_desc', 'tool_cf_turnstile'), 
        0
    ));

    $settings->add(new admin_setting_configpasswordunmask(
        'tool_cf_turnstile/site_key',
        get_string('sitekey', 'tool_cf_turnstile'),
        get_string('sitekey_desc', 'tool_cf_turnstile'),
        ''
    ));

    $settings->add(new admin_setting_configpasswordunmask(
        'tool_cf_turnstile/secret_key',
        get_string('secretkey', 'tool_cf_turnstile'),
        get_string('secretkey_desc', 'tool_cf_turnstile'),
        ''
    ));

    $settings->add(new admin_setting_configselect(
        'tool_cf_turnstile/theme',
        get_string('theme', 'tool_cf_turnstile'),
        get_string('theme_desc', 'tool_cf_turnstile'),
        'light',
        $theme_options
    ));

}