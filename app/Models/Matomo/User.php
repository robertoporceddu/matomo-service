<?php

namespace App\Models\Matomo;

use Exception;

class User extends Matomo {

    /**
     * Set User properties to get from Matomo
     */
    public $fillable = [
        'login',
        'email',
        'superuser_access',
        'date_registered',
        'uses_2fa'
    ];

    public function getAll()
    {
        return $this->matomo->call('UsersManager.getUsers');
    }

    protected function get($userLogin)
    {
        $response = $this->matomo->call('UsersManager.getUser', [
            'userLogin' => $userLogin
        ]);

        return $this->returnObjectFromResponse($this, $response);
    }

    /**
     * Check if a User exists
     * 
     * @param string $userLogin
     */
    public function exists($userLogin = null)
    {
        return $this->matomo->call('UsersManager.userExists', [
            'userLogin' => $userLogin ?? $this->login
        ])->value === true;
    }

    /**
     * Get User if Exists
     * 
     * @param string $userLogin
     */
    public function find($userLogin)
    {
        if($this->exists($userLogin) === true) {
            return $this->get($userLogin);
        }

        throw new Exception('Matomo user does not exists');
    }

    /**
     * Create User from $data
     * 
     * @param array $data at least userLogin, email, password
     */
    public function create($data)
    {
        return $this->matomo->call('UsersManager.addUser', $data);
    }

    public function delete()
    {
        return $this->matomo->call('UsersManager.deleteUser', [
            'userLogin' => $this->login
        ]);
    }

    public function getSites()
    {
        return $this->matomo->call('UsersManager.getSitesAccessFromUser', [
            'userLogin' => $this->login
        ]);
    }

    /**
     * Set Site Access to User
     * 
     * @param int idSites
     * @param string $access view, write, admin
     */
    public function setAccess($idSites, $access)
    {
        return $this->matomo->call('UsersManager.setUserAccess', [
            'userLogin' => $this->login,
            'access' => $access,
            'idSites' => $idSites,
        ]);
    }

}