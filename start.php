<?php

/**
 * Gapps Login
 *
 * @package GAppsLogin
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Pablo Borbón @ Consultora Nivel7 Ltda.
 * @copyright Consultora Nivel7 Ltda.
 * @link http://www.nivel7.net
 */
require_once 'Gapps.class.php';

function gappslogin_init() {


    global $CONFIG;

    // Register the authentication handler
    register_pam_handler('gappslogin_auth_handler');
}

function gappslogin_auth_handler($credentials) {

    $username = null;
    $password = null;
    $domain = get_plugin_setting("domain", "gappslogin");


    if (is_array($credentials) && ($credentials['username']) && ($credentials['password'])) {

        $username = $credentials['username'];
        $password = $credentials['password'];

        //Handle the "@" character

        if (strpos($username, "@") != false) {

            $email = $username;
            $pieces = explode("@", $username);
            $username = $pieces [0];
        } else {

            $email = $username . "@" . $domain;
        }

        //Let's create the authentication object and try to stablish a connection

        if (is_null($domain) || $domain == "") {

            // No domain has been set yet to authenticate
            return false;
        } else {

            $auth = new Gapps();
            $auth->set_domain($domain);
            if ($auth->authenticate_user($username, $password) == true) {



                if ($user = get_user_by_username($username)) {
                    system_message(elgg_echo('gappslogin:OK'));
                    return login($user);
                } else {
                    //Create user, if the user has never logged in
                    $name = $username;
                    $userentity = register_user($username, $password, $name, $email, false);
                    $new_user = get_entity($userentity);
                    $new_user->enable();
              

                    $user = get_user_by_username($username);
                    system_message(elgg_echo('gappslogin:nologinbefore'));
                    return login($user);
                }
            } else {
                //Username/passwrod combination incorrect.
                return false;
            }
        }
    }
}

// ******************** REGISTER EVENT HANDLERS ******************


register_elgg_event_handler('init', 'system', 'gappslogin_init');