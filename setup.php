<?php
namespace Threecolts\Phptest;

require 'src/Hello.php';
require 'src/UrlCounter.php';

// echo (new Hello())?->run();

// echo (new UrlCounter())?->countUniqueUrls(['https://example.com', 'http://example.com/']);
// echo (new UrlCounter())?->countUniqueUrls(["https://example.com", "https://example.com/"]);
// echo (new UrlCounter())?->countUniqueUrls(["https://example.com?", "https://example.com"]);
// echo (new UrlCounter())?->countUniqueUrls(["https://example.com?a=1&b=2", "https://example.com?b=2&a=1"]);


$result = (new UrlCounter())->countUniqueUrlsPerTopLevelDomain(["https://example.com", "https://subdomain.example.com"]);
print_r($result);

// $result = (new UrlCounter())->countUniqueUrlsPerTopLevelDomain(["https://example.com"]);
// print_r($result);
