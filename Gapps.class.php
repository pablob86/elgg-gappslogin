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

// Init class loader
require_once('zend/Loader.php');
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_Gapps');
Zend_Loader::loadClass('Zend_Gdata_Calendar');

// domain for google apps

class Gapps {

    protected $domain;

    /**
     * set domain
     * Set the Gapps domain.
     * @param string $domain Gapps domain
     */
    public function set_domain($domain_name) {
        $this->domain = $domain_name;
    }

    /**
     * authenticate user
     *
     * Tries to authenticate the user in given domain with passed credentials.
     * @param string $username User email on Gapps
     * @param string $password User password for Gapps
     * @return boolean true if user can authenticate in Google Apps. Fail if given user cant authenticate. String url if captcha validation is needed.
     */
    public function authenticate_user($username, $password) {

        if (!isset($this->domain)) {

            throw new Exception('No domain has been set. Unable to authenticate');
        }

        try {
            if (strpos($username, "@") == false) {

                $username = $username . "@" . $this->domain;
            }

            $client = Zend_Gdata_ClientLogin::getHttpClient($username, $password);
            return true;
        } catch (Zend_Gdata_App_CaptchaRequiredException $cre) {

            return $cre->getCaptchaUrl();
        } catch (Zend_Gdata_App_AuthException $ae) {

            return false;
        } catch (Exception $e) {

            return false;
        }
    }

}