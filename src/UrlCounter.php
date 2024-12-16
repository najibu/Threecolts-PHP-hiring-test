<?php

namespace Threecolts\Phptest;

class UrlCounter
{
    /**
     * This function counts how many unique normalized valid URLs were passed to the function
     *
     * Accepts a list of URLs
     *
     * Example:
     *
     * input: ['https://example.com']
     * output: 1
     *
     * Notes:
     *  - assume none of the URLs have authentication information (username, password).
     *
     * Normalized URL:
     *  - process in which a URL is modified and standardized: https://en.wikipedia.org/wiki/URL_normalization
     *
     *    For example.
     *    These 2 urls are the same:
     *    input: ["https://example.com", "https://example.com/"]
     *    output: 1
     *
     *    These 2 are not the same:
     *    input: ["https://example.com", "http://example.com"]
     *    output 2
     *
     *    These 2 are the same:
     *    input: ["https://example.com?", "https://example.com"]
     *    output: 1
     *
     *    These 2 are the same:
     *    input: ["https://example.com?a=1&b=2", "https://example.com?b=2&a=1"]
     *    output: 1
     */

    /**
     * @param array $urls
     * @return int
     */
    public function countUniqueUrls(array $urls): int
    {
        $normalizedValidUrls = array_map(function ($url) {
            $parsedUrl = parse_url($url);

            $scheme = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : '';
            $host = $parsedUrl['host'] ?? '';
            $path = $parsedUrl['path'] ?? '';
            $queryArray = [];
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryArray);
                ksort($queryArray);
            }
            $query = !empty($queryArray) ? '?' . http_build_query($queryArray) : '';


            $path = rtrim($path, '/');

            return $scheme  . $host . $path . $query;
        }, $urls);

        return count($this->checkUrlAreTheSame($normalizedValidUrls));
    }

    protected function checkUrlAreTheSame($normalizedValidUrls): array
    {
        $uniqueUrls = $normalizedValidUrls[0] === $normalizedValidUrls[1] ? [$normalizedValidUrls[0]] : $normalizedValidUrls;

        return $uniqueUrls;
    }

    /**
     * This function counts how many unique normalized valid URLs were passed to the function per top level domain
     *
     * A top level domain is a domain in the form of example.com. Assume all top level domains end in .com
     * subdomain.example.com is not a top level domain.
     *
     * Accepts a list of URLs
     *
     * Example:
     *
     * input: ["https://example.com"]
     * output: ["example.com" => 1]
     *
     * input: ["https://example.com", "https://subdomain.example.com"]
     * output: ["example.com" => 2]
     *
     */
    /* @var $urls : string[] */
    public function countUniqueUrlsPerTopLevelDomain(array $urls)
    {
        $uniqueUrls = array_unique($urls);
        $topLevelDomains = [];

        foreach ($uniqueUrls as $url) {
            $parsedUrl = parse_url($url);
            $host = $parsedUrl['host'];

            $sections = explode('.', $host);
            $topLevelDomain = $sections[count($sections) - 2] . '.' . $sections[count($sections) - 1];

            if (!isset($topLevelDomains[$topLevelDomain])) {
                $topLevelDomains[$topLevelDomain] = 1;
            } else {
                $topLevelDomains[$topLevelDomain]++;
            }
        }

        return $topLevelDomains;
    }
}
