<?php

namespace ContentManager\Controller;

use DateTime;
use Mustache_Engine;
use Mustache_Loader_CascadingLoader;
use Mustache_Loader_FilesystemLoader;

class TemplatesController
{

    /**
     * Response statuses for AJAX requests
     */
    const STATUS_200 = 200;
    const STATUS_500 = 500;
    const STATUS_404 = 404;

    /**
     * List of action links to be used in form action attribute
     */
    const ADD_ACTION_URL = '/template/create';
    const EDIT_ACTION_URL = '/template';
    const INFO_ACTION_URL = '/template/info/id/';
    const DELETE_ACTION_URL = '/template/delete/id/';

    /**
     * List of templates entities
     * @return mixed
     */
    public function indexAction(): string
    {
        return $this->getTemplateEngine()->render('/templates/cms/templates/index');
    }

    /**
     * Remove template entity
     * @return mixed
     */
    public function deleteAction(): string
    {
        $status = self::STATUS_200;
        $message = '';
        return $this->prepareJSONResponse($status, $message);
    }

    /**
     * Create a new template entity
     * @return mixed
     */
    public function createAction(): string
    {
        $status = self::STATUS_200;
        $message = '';
        return $this->prepareJSONResponse($status, $message);
    }

    /**
     * Change/edit template entity
     * @return mixed
     */
    public function editAction(): string
    {
        $status = self::STATUS_200;
        $message = '';
        return $this->prepareJSONResponse($status, $message);
    }

    /**
     * Preparing JSON response for AJAX requests
     * @param int $status
     * @param $data
     * @return string
     */
    public function prepareJSONResponse(int $status, $data): string
    {
        return json_encode(['status' => $status, 'message' => $data]);
    }

    /**
     * Creates an Instance of Mustache_Engine
     * @return Mustache_Engine
     */
    public function getTemplateEngine(): Mustache_Engine
    {
        $globalPath = __DIR__ . '/templates';
        $localPath = $_SERVER['DOCUMENT_ROOT'] . '/templates';
        $loaders[] = new Mustache_Loader_FilesystemLoader($_SERVER['DOCUMENT_ROOT'] . '/templates/');
        $loaders [] = new Mustache_Loader_FilesystemLoader($globalPath);
        if (is_dir($localPath)) {
            $loaders [] = new Mustache_Loader_FilesystemLoader($localPath);
        }
        $loader = new Mustache_Loader_CascadingLoader();
        $defaultConfig = array(
            'cache' => '/tmp/mustache',
            'loader' => $loader,
            'partials_loader' => $loader
        );

        $realConfig = $defaultConfig;
        $mustache = new Mustache_Engine($realConfig);
        $mustache->addHelper('number_format', function ($value) {

            return number_format($value);
        });
        $mustache->addHelper('pureContent', function ($value) {
            return $value;
        });
        $helpers = [
            'Y-m-d' => function ($date) {
                if ($date instanceof DateTime) {
                    return $date->format('Y-m-d');
                }
                return $date;
            },

            'd M Y' => function ($date) {
                if ($date instanceof DateTime) {
                    return $date->format('d M Y');
                }
                return $date;

            },
            'Y/m/d' => function ($date) {
                if ($date instanceof DateTime) {
                    return $date->format('Y/m/d');
                }
                return $date;

            },
            'F Y' => function ($date) {
                if ($date instanceof DateTime) {
                    return $date->format('F Y');
                }
                return $date;

            },
            //we still need these helpers for HTMLGENERATOR
            'rss' => function ($date) {
                if ($date instanceof DateTime) {
                    return $date->format('D, d M Y H:i:s O');
                }
                return $date;
            },
            'atom' => function ($date) {
                if ($date instanceof DateTime) {
                    return $date->format('Y-m-d\TH:i:sP');
                }
                return $date;
            },
            'w3c' => function ($date) {
                if ($date instanceof DateTime) {
                    return $date->format('Y-m-d\TH:i:sP');
                }
                return $date;
            },
        ];
        $mustache->addHelper('date', $helpers);
        $mustache->addHelper('dateFormat', $helpers);
        $mustache->addHelper('url', [
                'encode' => function ($url) {
                    return urlencode($url);
                },

                'rawencode' => function ($url) {
                    return rawurlencode($url);
                }
            ]
        );
        return $mustache;

    }
}
