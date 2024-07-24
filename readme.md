<div align="center">
  <img src="https://github.com/Emans1496/Orizon/blob/main/public/ORIZON.png" alt="Logo Orizon" />
</div>

# Orizon Travel API

Il progetto è stato sviluppato per simulare il supporto ad un'agenzia di viaggi chiamata Orizon, specializzata in viaggi sostenibili. Fa parte del corso MySQL e PHP di Start2impact

## Scopo del Progetto
L'obiettivo principale è fornire API RESTful che permettano di gestire e sponsorizzare offerte di viaggi last-minute. Le API consentono operazioni CRUD (Create, Read, Update, Delete) su paesi e viaggi, e includono funzionalità di filtraggio per i viaggi in base ai paesi coinvolti e al numero di posti disponibili.

## Tecnologie Utilizzate

- **Linguaggi**: PHP, SQL, JavaScript, HTML, CSS
- **Database**: MySQL
- **Server**: Apache (XAMPP)
- **Strumenti di Sviluppo**: XAMPP, phpMyAdmin, Visual Studio Code

## Struttura del Progetto
/project_root
    /api
        countries.php
        trips.php
    /config
        database.php
    /public
        index.html
        script.js
migrations.sql
.htaccess
index.php


## Configurazione dell'Ambiente

### 1. Creazione del Database
Utilizza il file `migrations.sql` per creare il database e le tabelle necessarie. Il file include le istruzioni SQL per creare il database `orizon_travel` e le tabelle `countries` e `trips`.

### 2. Configurazione del Database in PHP
Il file `database.php` gestisce la connessione al database MySQL. Configura i dettagli del database come host, nome del database, username e password.

### 3. Implementazione delle API
Le API sono implementate nei file `countries.php` e `trips.php` all'interno della cartella `api`.

- **countries.php**:
    - **GET**: Recupera tutti i paesi o un singolo paese per ID.
    - **POST**: Aggiunge un nuovo paese, verificando che non esista già.
    - **PUT**: Aggiorna il nome di un paese esistente.
    - **DELETE**: Elimina un paese per ID.

- **trips.php**:
    - **GET**: Recupera tutti i viaggi o un singolo viaggio per ID, con possibilità di filtro per paesi e numero di posti disponibili.
    - **POST**: Aggiunge un nuovo viaggio.
    - **PUT**: Aggiorna i dettagli di un viaggio esistente.
    - **DELETE**: Elimina un viaggio per ID.

## Frontend

Il frontend è stato creato utilizzando HTML, CSS e JavaScript per fornire una semplice interfaccia utente che permette di interagire con le API.

### index.html
Il file `index.html` fornisce il layout e i campi di input necessari per le operazioni CRUD su paesi e viaggi.

### script.js
Il file `script.js` gestisce le richieste API e aggiorna l'interfaccia utente.

## Testing e Debugging

- **Configurazione dell'Ambiente**: Utilizza XAMPP per configurare Apache e MySQL.
- **phpMyAdmin**: Gestisci il database tramite phpMyAdmin.
- **Frontend**: Interagisci con le API attraverso il frontend sviluppato.
- **Debugging**: Utilizza `console.log` per debug nel frontend e verifica le risposte JSON.

## Conclusione

L'uso combinato di queste tecnologie e strumenti consente di sviluppare un sistema robusto e scalabile per la gestione dei paesi e dei viaggi. La scelta di PHP e MySQL garantisce un'integrazione fluida e una gestione efficiente dei dati, mentre JavaScript, HTML e CSS offrono un'interfaccia utente interattiva e intuitiva. Apache, gestito tramite XAMPP, fornisce l'infrastruttura server necessaria per eseguire il progetto localmente, mentre phpMyAdmin facilita la gestione del database.