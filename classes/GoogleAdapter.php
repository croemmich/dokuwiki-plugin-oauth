<?php

namespace OAuth\Plugin;

use OAuth\OAuth2\Service\Google;

class GoogleAdapter extends AbstractAdapter {

    /**
     * Retrieve the user's data
     *
     * The array needs to contain at least 'user', 'email', 'name' and optional 'grps'
     *
     * @return array
     */
    public function getUser() {
        $JSON = new \JSON(JSON_LOOSE_TYPE);
        $data = array();

        $result = $JSON->decode($this->oAuth->request('https://www.googleapis.com/oauth2/v2/userinfo'));

        $data['user'] = $result['name'];
        $data['name'] = $result['name'];
        $data['mail'] = $result['email'];
        $data['grps'] = array_key_exists('hd', $result) ? array($result['hd']) : array(); # add domain as group

        return $data;
    }

    /**
     * Access to user and his email addresses
     *
     * @return array
     */
    public function getScope() {
        return array(Google::SCOPE_USERINFO_EMAIL, Google::SCOPE_USERINFO_PROFILE);
    }

}