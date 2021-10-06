<?php

namespace ContentManager\Controller;

use DateTime;
use Mustache_Engine;
use Mustache_Loader_CascadingLoader;
use Mustache_Loader_FilesystemLoader;

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * For selecting some information from `map_files_to_templates` table with some "complex" SQL query
 * $mapsFilesToTemplate = new MapFilesToTemplates();
 * $query = sprintf('SELECT m.id_file as fileId, f.identifier as identifier, m.id_template as templateId, t.identifier as template_name, f.is_base_css as is_base_css, f.mime as mime
 * FROM map_files_to_templates m
 * WHERE t.site_structure_id=%d ', $this->getProjectId(), "0", "0", "0", $this->getProjectId());
 * try {
 * $data = $mapsFilesToTemplate->repository()->findAllByQuery($query);
 * } catch (Exception $e) {
 * error handling here
 * }
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * For selecting one row from `map_files_to_templates` by few parameters
 * $mapFilesEntity = new MapFilesToTemplates();
 * try {
 * $mapFilesToTemplate = $mapFilesEntity->repository()->findOneBy(['id_file' => $id, 'id_template' => $id_template', 'livesite' => "0"]);
 * //$mapFilesToTemplate - is an associative array
 * } catch (Exception $e) {
 * error handling here
 * }
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * For selecting all rows from `templates` by few parameters
 * $templateEntity = new Templates();
 * try {
 * $templatesData = $templateEntity->repository()->findAllBy(['site_structure_id' => $this->getProjectId(), 'livesite' => "0"]);
 * } catch (Exception $e) {
 * error handling here
 * }*
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * Insert one record into table `map_files_to_templates` with returning id of newly created record
 * $mapFilesEntity = new MapFilesToTemplates();
 * try {
 * $mapFileToTemplateId = $mapFilesEntity->repository()->insertOne(['id_file' => $this->newFileId, 'id_template' => '',
 * 'type' => '', 'livesite' => "0", 'sorter' => ']);
 * } catch (Exception $e) {
 * error handling here
 * }*
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * Update one record in table `map_files_to_templates`
 * $mapFilesEntity = new MapFilesToTemplates();
 *  try {
 * $mapFilesEntity->repository()->updateOneBy(['id_file' => $this->fileId, 'id_template' => '', 'livesite' => "0"],
 * ['type' => '']);
 * } catch (Exception $e) {
 * error handling here
 * }
 *
 * ---------------------------------------------------------------------------------------------------------------------
 * Remove all records from `map_files_to_templates` table by $id
 * try {
 * $mapFilesToTemplates = new MapFilesToTemplates();
 * $mapFilesToTemplates->repository()->deleteAllBy(['id_file' => $id]);
 * } catch (AExceptions $exception) {
 * error handling
 * }
 */
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

    /**
     * Returns stub html for CSS_S multiselect
     * @return string
     */
    public static function get_CSS_S_HTML(): string
    {
        $html = '
        <option value="563533"> /[global]/PUBLICATIONS/EGU/ACP/ACP Bootstrap CSS File</option>
<option value="782"> /[global]/PUBLICATIONS/EGU/ACP/ACP CSS File</option>
<option value="2754"> /[global]/PUBLICATIONS/EGU/EGU CSS</option>
<option value="18550"> /[global]/PUBLICATIONS/EGU/ACP/Font Awesome v3.2 Min Css</option>
<option value="18551"> /[global]/PUBLICATIONS/EGU/ACP/Font Awesome v3.2 Min ie7 Css</option>
<option value="163924"> /[global]/PUBLICATIONS/Template base css 2018</option>
<option value="240357"> /[global]/PUBLICATIONS/Template base css 2018 mobile opt</option>
<option value="262955"> /[global]/PUBLICATIONS/Template base css 2018 mobile opt media</option>
<option value="553405"> /[global]/PUBLICATIONS/Template base css 2019 mobile opt</option>
<option value="553406"> /[global]/PUBLICATIONS/Template base css 2019 mobile opt media</option>
<option value="553407"> /[global]/PUBLICATIONS/Template Bootstrap bridge css</option>
<option value="1283"> /[global]/PUBLICATIONS/Template css addon extendend content</option>
<option value="120"> /[global]/PUBLICATIONS/Template css base</option>
<option value="19074"> /[global]/PUBLICATIONS/Template css base 2015</option>
<option value="24190"> /[global]/Template css base candidate</option>
<option value="24294"> /[global]/PUBLICATIONS/Template css display-mathml</option>
<option value="24295"> /[global]/PUBLICATIONS/Template css editor</option>
<option value="19796"> /[global]/PUBLICATIONS/Template css editor bridge</option>
<option value="17695"> /[global]/Template css Font Awesome</option>
<option value="75462"> /[global]/Template CSS Font Awesome 4.7.0.min</option>
<option value="23035"> /[global]/Template css Font Open Sans</option>
<option value="19803"> /[global]/PUBLICATIONS/Template css font style</option>
<option value="24302"> /[global]/PUBLICATIONS/Template css grid-system unsemantic</option>
<option value="20666"> /[global]/PUBLICATIONS/Template css journals addon extended content</option>
<option value="16236"> /[global]/PUBLICATIONS/Template css JQuery Toggle - deprecated</option>
<option value="24297"> /[global]/PUBLICATIONS/Template css jquery-ui slider pips</option>
<option value="392"> /[global]/PUBLICATIONS/Template css print base</option>
<option value="19818"> /[global]/PUBLICATIONS/Template css print base 2015</option>
<option value="1026718"> /[global]/PUBLICATIONS/Template Editor bridge hide blocks css 2021</option>
<option value="774031"> /[global]/PUBLICATIONS/Template EGUSphere Base special CSS</option>
<option value="774025"> /[global]/Template One-column base print css 2020</option>
<option value="778693"> /[global]/Template One-column base special css 2020</option>
<option value="19817"> /[global]/Template style social icon CSS</option>
        ';

        return $html;
    }

    /**
     * Returns stub html for CSS_P multiselect
     * @return string
     */
    public static function get_CSS_P_HTML(): string
    {
        $html = '
        <option value="563533"> /[global]/PUBLICATIONS/EGU/ACP/ACP Bootstrap CSS File</option>
<option value="782"> /[global]/PUBLICATIONS/EGU/ACP/ACP CSS File</option>
<option value="2754"> /[global]/PUBLICATIONS/EGU/EGU CSS</option>
<option value="18550"> /[global]/PUBLICATIONS/EGU/ACP/Font Awesome v3.2 Min Css</option>
<option value="18551"> /[global]/PUBLICATIONS/EGU/ACP/Font Awesome v3.2 Min ie7 Css</option>
<option value="163924"> /[global]/PUBLICATIONS/Template base css 2018</option>
<option value="240357"> /[global]/PUBLICATIONS/Template base css 2018 mobile opt</option>
<option value="262955"> /[global]/PUBLICATIONS/Template base css 2018 mobile opt media</option>
<option value="553405"> /[global]/PUBLICATIONS/Template base css 2019 mobile opt</option>
<option value="553406"> /[global]/PUBLICATIONS/Template base css 2019 mobile opt media</option>
<option value="553407"> /[global]/PUBLICATIONS/Template Bootstrap bridge css</option>
<option value="1283"> /[global]/PUBLICATIONS/Template css addon extendend content</option>
<option value="120"> /[global]/PUBLICATIONS/Template css base</option>
<option value="19074"> /[global]/PUBLICATIONS/Template css base 2015</option>
<option value="24190"> /[global]/Template css base candidate</option>
<option value="24294"> /[global]/PUBLICATIONS/Template css display-mathml</option>
<option value="24295"> /[global]/PUBLICATIONS/Template css editor</option>
<option value="19796"> /[global]/PUBLICATIONS/Template css editor bridge</option>
<option value="17695"> /[global]/Template css Font Awesome</option>
<option value="75462"> /[global]/Template CSS Font Awesome 4.7.0.min</option>
<option value="23035"> /[global]/Template css Font Open Sans</option>
<option value="19803"> /[global]/PUBLICATIONS/Template css font style</option>
<option value="24302"> /[global]/PUBLICATIONS/Template css grid-system unsemantic</option>
<option value="20666"> /[global]/PUBLICATIONS/Template css journals addon extended content</option>
<option value="16236"> /[global]/PUBLICATIONS/Template css JQuery Toggle - deprecated</option>
<option value="24297"> /[global]/PUBLICATIONS/Template css jquery-ui slider pips</option>
<option value="392"> /[global]/PUBLICATIONS/Template css print base</option>
<option value="19818"> /[global]/PUBLICATIONS/Template css print base 2015</option>
<option value="1026718"> /[global]/PUBLICATIONS/Template Editor bridge hide blocks css 2021</option>
<option value="774031"> /[global]/PUBLICATIONS/Template EGUSphere Base special CSS</option>
<option value="774025"> /[global]/Template One-column base print css 2020</option>
<option value="778693"> /[global]/Template One-column base special css 2020</option>
<option value="19817"> /[global]/Template style social icon CSS</option>
        ';

        return $html;
    }

    /**
     * Returns stub html for JS multiselect
     * @return string
     */
    public static function get_JS_HTML(): string
    {
        $html = '
        <option value="977858"> /[global]/ads-js</option>
<option value="364729"> /[global]/PUBLICATIONS/Almetric js</option>
<option value="119"> /[global]/PUBLICATIONS/do not use this anymore</option>
<option value="683409"> /[global]/service worer</option>
<option value="683408"> /[global]/Service Worker Activation JS</option>
<option value="16235"> /[global]/PUBLICATIONS/Template js jQuery toggle 191 min - deprecated</option>
<option value="20025"> /[global]/PUBLICATIONS/Template js Google Search v.2.0.1.</option>
<option value="20046"> /[global]/PUBLICATIONS/Template js carousel</option>
<option value="24303"> /[global]/PUBLICATIONS/Template js CoPublisher.js</option>
<option value="24304"> /[global]/PUBLICATIONS/Template js display-mathml</option>
<option value="24305"> /[global]/PUBLICATIONS/Template js editor</option>
<option value="3906"> /[global]/Template js formchange watchdog</option>
<option value="24306"> /[global]/PUBLICATIONS/Template js highstock</option>
<option value="1671"> /[global]/Template js inputhighlighter</option>
<option value="352"> /[global]/PUBLICATIONS/Template js journal box</option>
<option value="20002"> /[global]/PUBLICATIONS/Template js journal list pup up</option>
<option value="19151"> /[global]/PUBLICATIONS/Template js journals</option>
<option value="25532"> /[global]/PUBLICATIONS/Template js jquer-ui touch JS</option>
<option value="19152"> /[global]/PUBLICATIONS/Template js JQuery 1.11.1 min</option>
<option value="16237"> /[global]/PUBLICATIONS/Template js JQuery Toggle Functions JS - deprecated</option>
<option value="24308"> /[global]/PUBLICATIONS/Template js jquery-ui slider pips</option>
<option value="24309"> /[global]/PUBLICATIONS/Template js respond</option>
<option value="109727"> /[global]/PUBLICATIONS/Template js seeker search</option>
<option value="2251"> /[global]/Template js swfobject</option>
<option value="1137288"> /[global]/Template One-column push-notification JS</option>
<option value="210442"> /[global]/PUBLICATIONS/Template responsive js</option>
<option value="210443"> /[global]/PUBLICATIONS/Template service worker js</option>
        ';

        return $html;
    }

    /**
     * Returns stub html for CDN multiselect
     * @return string
     */
    public static function get_CDN_HTML(): string
    {
        $html = '
        <option value="jquery.1.11.1.js" selected="selected"> jquery.1.11.1.js</option>
<option value="jquery.1.11.1 UI"> jquery.1.11.1 UI</option>
<option value="jquery.1.11.1 tablesorter"> jquery.1.11.1 tablesorter</option>
<option value="mustache.min.js" selected="selected"> mustache.min.js</option>
<option value="copernicus.min.css" selected="selected"> copernicus.min.css</option>
<option value="unsemantic.min.css" selected="selected"> unsemantic.min.css</option>
<option value="copernicus.min.js" selected="selected"> copernicus.min.js</option>
<option value="htmlgenerator-v2.js" selected="selected"> htmlgenerator-v2.js</option>
<option value="photoswipe.css" selected="selected"> photoswipe.css</option>
<option value="photoswipe.min.js" selected="selected"> photoswipe.min.js</option>
<option value="bootstrap-2.3.2 (css &amp; js)"> bootstrap-2.3.2 (css &amp; js)</option>
<option value="bootstrap-3.3.7 (css &amp; js)"> bootstrap-3.3.7 (css &amp; js)</option>
<option value="bootstrap-4.0.0 (css &amp; js)" selected="selected"> bootstrap-4.0.0 (css &amp; js)</option>
<option value="dszparallexer" selected="selected"> dszparallexer</option>
<option value="fontawesome v4.7.0" selected="selected"> fontawesome v4.7.0</option>
<option value="fontawesome v5.10.1"> fontawesome v5.10.1</option>
<option value="fontawesome v5.11.2 Pro (don\'t use with version 4)"> fontawesome v5.11.2 Pro (don\'t use with version 4)</option>
<option value="fontawesome v5.11.2 Pro (use only with version 4)" selected="selected"> fontawesome v5.11.2 Pro (use only with version 4)</option>
        ';

        return $html;
    }

    /**
     * Returns stub html for extended cntent CSS list multiselect
     * @return string
     */
    public static function get_CSS_extended_content_HTML(): string
    {
        $html = '<option value="-1"></option>
<option value="563533"> /[global]/PUBLICATIONS/EGU/ACP/ACP Bootstrap CSS File</option>
<option value="782"> /[global]/PUBLICATIONS/EGU/ACP/ACP CSS File</option>
<option value="2754"> /[global]/PUBLICATIONS/EGU/EGU CSS</option>
<option value="18550"> /[global]/PUBLICATIONS/EGU/ACP/Font Awesome v3.2 Min Css</option>
<option value="18551"> /[global]/PUBLICATIONS/EGU/ACP/Font Awesome v3.2 Min ie7 Css</option>
<option value="163924"> /[global]/PUBLICATIONS/Template base css 2018</option>
<option value="240357"> /[global]/PUBLICATIONS/Template base css 2018 mobile opt</option>
<option value="262955"> /[global]/PUBLICATIONS/Template base css 2018 mobile opt media</option>
<option value="553405"> /[global]/PUBLICATIONS/Template base css 2019 mobile opt</option>
<option value="553406"> /[global]/PUBLICATIONS/Template base css 2019 mobile opt media</option>
<option value="553407"> /[global]/PUBLICATIONS/Template Bootstrap bridge css</option>
<option value="1283"> /[global]/PUBLICATIONS/Template css addon extendend content</option>
<option value="120"> /[global]/PUBLICATIONS/Template css base</option>
<option value="19074"> /[global]/PUBLICATIONS/Template css base 2015</option>
<option value="24190"> /[global]/Template css base candidate</option>
<option value="24294"> /[global]/PUBLICATIONS/Template css display-mathml</option>
<option value="24295"> /[global]/PUBLICATIONS/Template css editor</option>
<option value="19796"> /[global]/PUBLICATIONS/Template css editor bridge</option>
<option value="17695"> /[global]/Template css Font Awesome</option>
<option value="75462"> /[global]/Template CSS Font Awesome 4.7.0.min</option>
<option value="23035"> /[global]/Template css Font Open Sans</option>
<option value="237997"> /[global]/Template css Font Open Sans v.15</option>
<option value="19803"> /[global]/PUBLICATIONS/Template css font style</option>
<option value="24302"> /[global]/PUBLICATIONS/Template css grid-system unsemantic</option>
<option value="20666" selected="selected"> /[global]/PUBLICATIONS/Template css journals addon extended content</option>
<option value="16236"> /[global]/PUBLICATIONS/Template css JQuery Toggle - deprecated</option>
<option value="24297"> /[global]/PUBLICATIONS/Template css jquery-ui slider pips</option>
<option value="392"> /[global]/PUBLICATIONS/Template css print base</option>
<option value="19818"> /[global]/PUBLICATIONS/Template css print base 2015</option>
<option value="1026718"> /[global]/PUBLICATIONS/Template Editor bridge hide blocks css 2021</option>
<option value="774031"> /[global]/PUBLICATIONS/Template EGUSphere Base special CSS</option>
<option value="774024"> /[global]/Template One-column base css 2020</option>
<option value="774025"> /[global]/Template One-column base print css 2020</option>
<option value="778693"> /[global]/Template One-column base special css 2020</option>
<option value="19817"> /[global]/Template style social icon CSS</option> ';

        return $html;
    }

    /**
     * Returns stub html for extended cntent CSS list multiselect
     * @return string
     */
    public static function get_Pages_For_Globalizing_HTML(): string
    {
        $html = '    <option value="883" selected="selected"> 404</option>
    <option value="6086"> about</option>
    <option value="6088"> about/aims_and_scope</option>
    <option value="4967"> about/article_level_metrics</option>
    <option value="323"> about/article_processing_charges</option>
    <option value="307"> about/contact</option>
    <option value="317"> about/faq</option>
    <option value="1786"> about/financial_support</option>
    <option value="7107"> about/journal_statistics</option>
    <option value="308"> about/journal_subject_areas</option>
    <option value="324"> about/manuscript_types</option>
    <option value="10252"> about/manuscript_types/acp letters</option>
    <option value="8798"> about/mobile_abstracted_indexed</option>
    <option value="8797"> about/mobile_journal_metrics</option>';

        return $html;
    }
}
