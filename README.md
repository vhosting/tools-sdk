# Tools API SDK

L'SDK PHP per interagire con l'API di Tools VHosting, sviluppato utilizzando la libreria [Saloon](https://saloon.dev/).

## Installazione

Puoi installare il pacchetto tramite composer:

```bash
composer require vhosting/tools-sdk
```

Il pacchetto si registra automaticamente in Laravel tramite il Service Provider.

## Configurazione

Puoi pubblicare il file di configurazione con il seguente comando:

```bash
php artisan vendor:publish --provider="VHosting\ToolsSdk\ToolsSdkServiceProvider"
```

Queste sono le variabili d'ambiente supportate:

```env
TOOLS_TOKEN=il-tuo-token-api
TOOLS_URL=https://tools.vhosting-it.com
TOOLS_MOCK=false
```

Il token può essere generato visitando [https://tools.vhosting-it.com/token](https://tools.vhosting-it.com/token).

## Utilizzo

L'SDK fornisce una Facade per Laravel che rende semplice l'accesso alle risorse.

### Gestione Workflow

Tutte le operazioni sui workflow sono accessibili tramite `ToolsSdk::workflow()`.

#### Recuperare tutti i workflow (Paginati)

```php
use VHosting\ToolsSdk\Facades\ToolsSdk;

$paginator = ToolsSdk::workflow()->all();

foreach ($paginator as $workflow) {
    echo $workflow->id;
    echo $workflow->status;
}
```

#### Recuperare un singolo workflow

```php
$workflow = ToolsSdk::workflow()->get(123);

echo $workflow->description;
echo $workflow->tasks_count;
```

#### Avviare (Dispatch) un nuovo workflow

```php
$workflow = ToolsSdk::workflow()->dispatch('nome-tipo-workflow', [
    'parametro1' => 'valore1',
    'parametro2' => 'valore2',
]);

echo $workflow->id;
```

#### Riprovare un workflow fallito

```php
ToolsSdk::workflow()->retry(123);
```

## Mocking per i Test

L'SDK integra il sistema di faking di Saloon per facilitare i test:

```php
use VHosting\ToolsSdk\Facades\ToolsSdk;
\Saloon\Http\Faking\MockResponse;

ToolsSdk::fake([
    '*' => MockResponse::make(['id' => 1, 'status' => 'completed'], 200),
]);
```

È anche possibile abilitare i mock globalmente tramite la variabile d'ambiente `TOOLS_MOCK=true`, che utilizzerà i dati predefiniti definiti nella classe `Mocks`.

## Licenza

MIT License (MIT). Per maggiori informazioni consultare il file [LICENSE](LICENSE).
