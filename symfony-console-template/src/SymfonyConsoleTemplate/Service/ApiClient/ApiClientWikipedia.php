<?php

namespace SymfonyConsoleTemplate\Service\ApiClient;

use SymfonyConsoleTemplate\Service\ServiceAbstract;
use SymfonyConsoleTemplate\Utility\Accessor;
use Httpful\Request;
use Httpful\Mime;

/**
 * ApiClientwikipedia
 *
 * @see API:Main page - MediaWiki https://www.mediawiki.org/wiki/API:Main_page
 * @author 
 * @license MIT (see LICENSE.md)
 */
class ApiClientWikipedia extends ServiceAbstract
{

    /**
     * base_url
     *
     * @var string
     */
    private $base_url;

    /**
     * Set base_url
     *
     * @param string $base_url
     * @return self
     */
    public function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;
        return $this;
    }

    /**
     * Get base_url
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * @param string $title
     * @return array
     */
    public function findOnePageinfo($title)
    {
        $params = [
            "format" => "json",
            "action" => "query",
            "prop" => "info",
            "titles" => $title,
        ];
        
        $response = Request::get($this->getBaseUrl() . "/w/api.php?" . $this->createQueryString($params))
                ->expects(Mime::JSON)
                ->followRedirects(true)
                ->send();

        $result = json_decode($response->raw_body, true);

        // jsonが不正じゃないかチェックする
        if (!is_array($result) || json_last_error() !== \JSON_ERROR_NONE) {
            return null;
        }
        
        $pages = array_values(Accessor::getValueHierarchy($result, ['query', 'pages'], array()));
        
        return [
            "pageid"    => Accessor::getValueHierarchy($pages, ['0', 'pageid']),
            "title"  => Accessor::getValueHierarchy($pages, ['0', 'title']),
            "pagelanguage" => Accessor::getValueHierarchy($pages, ['0', 'pagelanguage']),
        ];
    }

    /**
     *
     * @param array $params
     * @return string
     */
    public function createQueryString(array $params)
    {
        return implode('&', array_map(function ($key, $value) {
            return $key . "=" . $value;
        }, array_keys($params), array_values($params)));
    }
}
