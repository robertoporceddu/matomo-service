<?php

namespace App\Models\Matomo;

use Exception;

class Site extends Matomo {

    /**
     * Set Site properties to get from Matomo
     */
    public $fillable = [
        'idsite',
        'name',
        'main_url',
        'ts_created'
    ];

    public function getAll()
    {
        return $this->matomo->call('SitesManager.getAllSites');
    }

    /**
     * Get Site if Exists
     * 
     * @param int $siteId
     */
    public function find($siteId)
    {
        $response = $this->matomo->call('SitesManager.getSiteFromId', [
            'idSite' => $siteId
        ]);

        if(isset($response->idsite)) {
            return $this->returnObjectFromResponse($this, $response);
        }

        throw new Exception('Matomo site does not exists');
    }

    /**
     * Create Site from $data
     * 
     * @param array $data at least siteName, urls
     */
    public function create($data)
    {
        return $this->matomo->call('SitesManager.addSite', $data);
    }

    public function delete()
    {
        return $this->matomo->call('SitesManager.deleteSite', [
            'idSite' => $this->idsite
        ]);
    }
}