<?php
/**
 * @copyright Copyright (c) PutYourLightsOn
 */

namespace putyourlightson\blitzkeycdn;

use Craft;
use craft\behaviors\EnvAttributeParserBehavior;
use craft\events\RegisterTemplateRootsEvent;
use craft\helpers\App;
use craft\web\View;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use putyourlightson\blitz\drivers\purgers\BaseCachePurger;
use putyourlightson\blitz\events\RefreshCacheEvent;
use putyourlightson\blitz\helpers\SiteUriHelper;
use yii\base\Event;

/**
 * @property-read null|string $settingsHtml
 */
class KeyCdnPurger extends BaseCachePurger
{
    public const API_ENDPOINT = 'https://api.keycdn.com/';

    /**
     * @var string
     */
    public string $apiKey = '';

    /**
     * @var string
     */
    public string $zoneId = '';

    /**
     * @inheritdoc
     */
    public static function displayName(): string
    {
        return Craft::t('blitz', 'Key CDN Purger');
    }

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        Event::on(View::class, View::EVENT_REGISTER_CP_TEMPLATE_ROOTS,
            function(RegisterTemplateRootsEvent $event) {
                $event->roots['blitz-keycdn'] = __DIR__ . '/templates/';
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['parser'] = [
            'class' => EnvAttributeParserBehavior::class,
            'attributes' => [
                'apiKey',
                'zoneId',
            ],
        ];

        return $behaviors;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'apiKey' => Craft::t('blitz', 'API Key'),
            'zoneId' => Craft::t('blitz', 'Zone ID'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['apiKey', 'zoneId'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function purgeUrisWithProgress(array $siteUris, callable $setProgressHandler = null): void
    {
        $count = 0;
        $total = count($siteUris);
        $label = 'Purging {total} pages.';

        if (is_callable($setProgressHandler)) {
            $progressLabel = Craft::t('blitz', $label, ['total' => $total]);
            call_user_func($setProgressHandler, $count, $total, $progressLabel);
        }

        $this->_sendRequest('delete', 'purgeurl', [
            'urls' => SiteUriHelper::getUrlsFromSiteUris($siteUris),
        ]);

        $count = $total;

        if (is_callable($setProgressHandler)) {
            $progressLabel = Craft::t('blitz', $label, ['total' => $total]);
            call_user_func($setProgressHandler, $count, $total, $progressLabel);
        }
    }

    /**
     * @inheritdoc
     */
    public function purgeAll(callable $setProgressHandler = null, bool $queue = true): void
    {
        $event = new RefreshCacheEvent();
        $this->trigger(self::EVENT_BEFORE_PURGE_ALL_CACHE, $event);

        if (!$event->isValid) {
            return;
        }

        $this->_sendRequest('get', 'purge');

        if ($this->hasEventHandlers(self::EVENT_AFTER_PURGE_ALL_CACHE)) {
            $this->trigger(self::EVENT_AFTER_PURGE_ALL_CACHE, $event);
        }
    }

    /**
     * @inheritdoc
     */
    public function test(): bool
    {
        $response = $this->_sendRequest('get');

        if (!$response) {
            return false;
        }

        return $response->getStatusCode() == 200;
    }

    /**
     * @inheritdoc
     */
    public function getSettingsHtml(): ?string
    {
        return Craft::$app->getView()->renderTemplate('blitz-keycdn/settings', [
            'purger' => $this,
        ]);
    }

    /**
     * Sends a request to the API.
     */
    private function _sendRequest(string $method, string $action = '', array $params = []): ?ResponseInterface
    {
        $response = null;

        $client = Craft::createGuzzleClient([
            'base_uri' => self::API_ENDPOINT,
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode(App::parseEnv($this->apiKey) . ':'),
            ],
        ]);

        $uri = 'zones/' . ($action ? $action . '/' : '') . App::parseEnv($this->zoneId) . '.json';
        $options = !empty($params) ? ['json' => $params] : [];

        try {
            $response = $client->request($method, $uri, $options);
        }
        catch (BadResponseException|GuzzleException) {
        }

        return $response;
    }
}
