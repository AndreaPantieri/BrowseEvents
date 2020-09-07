# BrowseEvents

ATTENZIONE: PHP 7.4 richiesto per visualizzare correttamente il sito Web. 
Inoltre, per il corretto invio delle mail di posta elettronica bisogna richiedere le credenziali di accesso all'account gmail: infobrowseevents@gmail.com
e configurare i file php.ini e sendmail.ini presenti in Xampp in maniera appropriata. (numero porta 465 e utilizzo di SSL) (contattare i creatori in caso di problemi di configurazione di tali file)

ISTRUZIONI: 
  1) Installare Xampp e clonare il repository di BrowseEvents in htdocs.  
  2) In PHPMyAdmin installare il database tramite codice SQL (reperibile in "BrowseEvents\doc\BrowseEventsDB_Generator.sql") oppure tramite Mysql WorkBench (aprendo il file "BrowseEvents\doc\DatabaseModel.mwb")
  3) In PHPMyAdmin cambiare la password di accesso in "root" (quindi admin: root password: root). In alternativa, se non si vuole cambiare password a PHPMyAdmin, è sufficiente modificare il file ini che si trova in "BrowseEvents\php\db\configDB.ini" e lasciare il campo password vuoto.
  4) Accedere al sito web tramite browser (digitando "localhost/BrowseEvents")
  
