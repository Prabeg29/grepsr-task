<?php

declare(strict_types=1);

/**
 * Write a crawler in PHP to extract data from URL: https://github.com/search?q=php
 * a. Collect all the listings available from first 10 pages sorted by ‘Most stars’
 * b. Collect the following data from each listing (column names as listed in bold with example):
 *  i. repo: ‘ohmyzsh/ohmyzsh’
 *  ii. description: ‘🙃 A delightful community-driven (with 2,100+ contributors) 
 *      framework for managing your zsh configuration. Includes 300+ optional
 *      plugins (rails, git, macOS, hub, docker, homebrew, node, php, python,
 *      etc), 140+ themes to spice up your morning, and an auto-update tool so
 *      that makes it easy to keep up with the latest updates from the community.’
 *  iii. is_sponsored : ‘yes’
 *  iv. topics :
 *  ‘zsh|terminal|shell|theme|cli|productivity|oh-my-zsh|plugins|themes|cli-app
 *  |hacktoberfest|oh-my-zsh-theme|oh-my-zsh-plugin|zsh-configuration|ohm
 *  yzsh|plugin-framework’
 *  v. stargazers : ‘157k’
 *  vi. language: ‘Shell’
 *  vii. license: ‘MIT license’
 *  viii. date: ‘05/04/2023’ (format should be d/m/Y)
 *  ix. commits : 6862
 * c. Create a ‘CSV’ file named ‘repositories.csv’, with data collected.
 */

require_once 'vendor/autoload.php';

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$data = [];

$client = new Client([
  'base_uri' => 'https://github.com',
  'headers'  => [
    'User-Agent'      => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/112.0.0.0 Safari/537.36',
    'Accept-Language' => 'en-US,en;q=0.8',
    'Accept-Encoding' => 'gzip, deflate, br',
    'Connection'      => 'keep-alive',
  ],
]);

for ($i = 1; $i <= 1; $i++) {
  usleep(10);
  $response = $client->request('GET', '/search', [
    'query' => [
      'q' => 'php',
      's' => 'stars',
      'o' => 'desc',
      'p' => $i,
    ],
  ]);

  $listHtml = (string) $response->getBody();

  $listCrawler = new Crawler($listHtml);

  try {
    $listCrawler->filter('ul.repo-list > li')
      ->each(function (Crawler $node) use (&$data, $client) {
        $topics = '';

        if ($node->filter('a.topic-tag')->count()) {
          $node->filter('a.topic-tag')->each(function (Crawler $topicNode) use (&$topics) {
            $topics .= $topicNode->text() . '|';
          });
        }

        $row = [
          'repo'          => $node->filter('div.d-flex > .f4 > a')->first()->text(),
          'description'   => $node->filter('p.mb-1')->count() ? $node->filter('p.mb-1')->first()->text() :  'N/A',
          'is_sponsored'  => $node->filter('summary')->count() ? 'yes' : 'no',
          'topics'        => rtrim($topics,  '|'),
          'stargazers'    => $node->filter('a.Link--muted')->first()->text(),
          'language'      => $node->filter('span[itemprop="programmingLanguage"]')->count()  ?
            $node->filter('span[itemprop="programmingLanguage"]')->innerText() :
            'N/A',
          'license'       => $node->filter('div.d-flex')->children(),
          'date'          => DateTime::createFromFormat(
            'Y-m-d\TH:i:s\Z',
            $node->filter('relative-time')->attr('datetime')
          )->format('d/m/Y')
        ];

        $response = $client->request('GET', "/{$row['repo']}");

        $detailHtml = (string) $response->getBody();
        $detailCrawler = new Crawler($detailHtml);
        $row['commits'] = $detailCrawler->filter('span.d-none > strong')->innerText();

        $data[] = $row;
      });
  } catch (Exception $ex) {
    echo "Caught exception: " . $ex->getMessage();
  }
}

$fp = fopen('repositories.csv', 'w');
fputcsv($fp, array_keys(reset($data)));
foreach ($data as $row) {
  fputcsv($fp, $row);
}
fclose($fp);
