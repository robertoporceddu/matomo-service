<?php

require 'vendor/autoload.php';

use App\Models\Matomo\Site as MatomoSite;
use App\Models\Matomo\User as MatomoUser;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$matomoSite = new MatomoSite();
$matomoUser = new MatomoUser();

// *** Creazione di un sito con nome e url "prova.media-agency.test" ***
$response = $matomoSite->create([
    'siteName' => 'prova.media-agency.test',
    'urls' => 'prova.media-agency.test'
]);
$siteId = $response->value;

if($site = $matomoSite->find($response->value))
{
    echo "Sito $site->main_url con id $siteId creato!\n";
}
// -----------------------------------------

// *** Creazione di un utente associato al sito appena creato ***
if(!$matomoUser->exists('roberto.porceddu'))
{
    // Creazione di un utente
    $matomoUser->create([
        'userLogin' => 'roberto.porceddu',
        'email' => 'robertoporceddu@gmail.com',
        'password' => 'Ercole66!',
        'initialIdSite' => $siteId
    ]);

    echo "Creato l'utente roberto.porceddu che non esisteva\n";
}

// Associo il sito appena creato all'utente
$matomoUser->find('roberto.porceddu')->setAccess($siteId, 'admin');

echo "Associato il sito con id $siteId con diritti di admin!\n";
// -----------------------------------------

// *** Controllo esistenza utente creato precedentemente ***
$userToCheck = 'roberto.porceddu';
if($matomoUser->exists($userToCheck))
{
    echo "L'utente $userToCheck esiste!\n";
}
else
{
    echo "L'utente $userToCheck NON esiste!\n";
}
// -----------------------------------------

// *** Reperimento siti collegati ad un utente. ***
$response = $matomoUser->find('roberto.porceddu')->getSites();

echo "Siti collegati all'utente:\n";
var_dump($response);
// -----------------------------------------


// Pulizia degli elementi creati per il test
// $response = $matomoSite->find($siteId = 19)->delete();
// $response = $matomoUser->find('roberto.porceddu')->delete();
