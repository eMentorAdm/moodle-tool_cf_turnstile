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
 * Plugin version and other meta-data are defined here.
 *
 * @package     tool_cf_turnstile
 * @copyright   2024 e-Mentor s.r.l. - service@e-mentor.it
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Cloudflare Turnstile URLs
 */

define ("CF_TURNSTILE_API_URL", "https://challenges.cloudflare.com/turnstile/v0/api.js");

define ("CF_TURNSTILE_SITE_VERIFY_URL", "https://challenges.cloudflare.com/turnstile/v0/siteverify");

/**
 * Adds the js and the HTML widget for renders the div block.
 * This is called from the browser, and the resulting reCAPTCHA HTML widget
 * is embedded within the HTML form it was called from.
 *
 * @param string $mform URL for reCAPTCHA API
 * @return void
 */
function tool_cf_turnstile_extend_signup_form($mform) {
    global $PAGE;

    $configuration = get_config("tool_cf_turnstile");

    if ($configuration->enabled) {

        $turnstilesitekey = $configuration->site_key;
        $turnstiletheme = $configuration->theme;

        if (!cf_turnstile_check_status_configuration()) {
            $mform->addElement('html', get_string("misconfiguration_msg", "tool_cf_turnstile"));
            return;
        }

        // Adding challenge js to the page.
        $PAGE->requires->js(new moodle_url(CF_TURNSTILE_API_URL));

        // Adding turnstile cf to the form.
        $mform->addElement('html', "<div class='cf-turnstile' data-theme='$turnstiletheme' data-sitekey='$turnstilesitekey'></div>");

        // Used just for error messages.
        $mform->addElement('static', 'cf_turnstile', '', '');
        $mform->hideIf('cf_turnstile', 'cf_turnstile', 'eq', '');

    }
}

/**
 * Checks the cf response from server side.
 * If the check is succed the request could proceed, otherwise it will back to form page with an error.
 *
 * @param stdClass $data Object containing all the information sent from the previous request
 * @return array $errors List of errors refered to the form elements
 */
function tool_cf_turnstile_validate_extend_signup_form($data) {

    $configuration = get_config("tool_cf_turnstile");
    $errors = array();

    if ($configuration->enabled) {
        if (!cf_turnstile_check_status_configuration()) {
            $errors['cf_turnstile'] = get_string("misconfiguration_msg", "tool_cf_turnstile");
            return;
        }

        // Optional because we use moodle error handling.
        $cfturnstileresponse = optional_param("cf-turnstile-response", "", PARAM_RAW);
        $connectingip = $_SERVER["REMOTE_ADDR"];
        // Check if it's empty.
        if (empty($cfturnstileresponse)) {
            $errors['cf_turnstile'] = get_string("missing_info", "tool_cf_turnstile");
            return $errors;
        }

        $verificationcaptcha = cf_turnstile_verify_captcha($cfturnstileresponse, $connectingip);

        if (!$verificationcaptcha) {
            $errors['cf_turnstile'] = get_string("bad_request", "tool_cf_turnstile");
        }

    }

    return $errors;

}

/**
 * Gets the challenge HTML
 * This is called from the browser, and the resulting reCAPTCHA HTML widget
 * is embedded within the HTML form it was called from.
 *
 * @param string $cfturnstileresponse Token generated from the client side
 * @param string $cfconnectingip The IP of the requester
 * @return bool - Response from Cloudflare API
 */
function cf_turnstile_verify_captcha($cfturnstileresponse, $cfconnectingip) {
    $configuration = get_config("tool_cf_turnstile");
    $cfturnstilesecretkey = $configuration->secret_key;

    $params = [
        'response' => $cfturnstileresponse,
        'secret' => $cfturnstilesecretkey,
        'remoteip' => $cfconnectingip
    ];

    $curl = new curl();
    $response = $curl->post(CF_TURNSTILE_SITE_VERIFY_URL, $params);
    if (empty($response)) {
        return false;
    }

    $result = json_decode($response, true);

    return $result["success"];

}

/**
 * Checks if configuration params are setted correctly
 *
 * @return bool - returns the status of the configuration
 */
function cf_turnstile_check_status_configuration() {

    $configuration = get_config("tool_cf_turnstile");

    if (empty($configuration->secret_key) || empty($configuration->site_key)) {
        return false;
    }
    return true;
}
