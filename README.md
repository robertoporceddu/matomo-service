Pre requisiti:
- php (testato su php^8.1.3)
- composer (https://getcomposer.org/)

Per eseguire il test:
- eseguire il `git clone` del progetto
- creare una copia del file `.env.example` con nome `.env`
- completare il file `.env` inserendo i valori opportuni per potersi collegare al server Matomo
    - `MATOMO_API_URL`
    - `MATOMO_API_TOKEN`
- da terminare eseguire il comando `composer update`
- da terminale eseguire il comando `php test-matomo.php`

Per eseguire la pulizia di quanto creato durante il test sul server commentare la parte relativa al test e decommentare le due ultime righe in fondo inserento i `siteId` creati.

Documentazione API Matomo Analytics:
- https://developer.matomo.org/api-reference/reporting-api