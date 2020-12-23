<?php

namespace Drupal\Gradientserver_sitepins;

use Drupal\feeds\Entity\Feed;

/**
 * Helper functions for SitePins.net integration.
 */
class SitePinsHelper {

  const FIELDS = [
    'sitepins_thumbnail_url' => 'Sitepins thumbnail',
    'sitepins_video_url' => 'Sitepins video ',
    'sitepins_author' => 'Sitepins author',
  ];

  const COLLECTIONS = [
    'lukewearechange' => 'Luke We Are Change',
    'press4truth' => 'Press For Truth',
    'truthstream' => 'Truth Stream Media',
    'wearechange' => 'We Are Change',
    'worldaltmedia' => 'World Alternative Media',
    // 'freedomsphoenix' => 'Freedoms Phoenix',
    'historycommons' => 'History Commons',
  ];


  /**
   * Download a sitepins.net collection page.
   * 
   * @param \Drupal\feeds\Entity\Feed $feed
   *   A Feed entity.
   * @param int $page
   *   The current page in the collection.
   * 
   * @return string
   *   the html of a page.
   */
  public static function getHtml(Feed $feed, $page = 0) {
    if($page === 0) {
      $url = $feed->source->value;
    }
    else {
      $per_page = 24;
      $id = end(explode('/', $feed->source->value));
      $skip = $per_page * $page;
      $url = "http://sitepins.net/videos/more?skip=$skip&take=$per_page&search.collection_name=$id";
    }
    return file_get_contents($url);
  }

  /**
   * Parses a sitepins.net html page.
   * 
   * @param string $html
   *   An html page.
   * 
   * @return array
   *   An array of parsed items.
   */
  public static function parseHtml($html) {
    $doc = new \DomDocument('1.0');
    $doc->loadHTML(str_replace(['<time', '</time'],['<div', '</div'], $html));
    $xpath = new \DOMXpath($doc);
    $divs = $xpath->query('//div[contains(@class, "video-summary")]');
    $result = [];
    foreach($divs as $div) {
      $arr = self::dom2array($div);
      if (!empty(trim($arr['h4']['a']['#text'])) && !empty (trim($arr['h4']['a']['#attributes']['href']))) {
        $result[] = [
          'guid' => trim($arr['h4']['a']['#attributes']['href']),
          'sitepins_thumbnail_url' => self::sitepins_url(trim($arr['img']['#attributes']['src'])),
          'sitepins_video_url' => self::sitepins_url(trim($arr['h4']['a']['#attributes']['href'])),
          'title' => trim($arr['h4']['a']['#text']),
          'sitepins_author' => trim($arr['div']['span']['#text']),
          'created' => self::sitepins_date(trim($arr['div']['div']['#attributes']['datetime'])),
        ];
      }
    }
    return $result;
  }

  /**
   * Recursive function to turn a DOMElement into an array.
   * @param DOMElement $node 
   *   An element in an XML document.
   * 
   * @return array
   *   The Dom element as an array.
   * 
   * @see https://www.php.net/manual/en/book.dom.php#73875
   */
  private function dom2array($node) {
    $res = array();
    if($node->nodeType == XML_TEXT_NODE){
        $res = $node->nodeValue;
    }
    else{
      if($node->hasAttributes()){
        $attributes = $node->attributes;
        if(!is_null($attributes)){
          $res['@attributes'] = array();
          foreach ($attributes as $index=>$attr) {
            $res['#attributes'][$attr->name] = $attr->value;
          }
        }
      }
      if($node->hasChildNodes()){
        $children = $node->childNodes;
        for($i=0;$i<$children->length;$i++){
          $child = $children->item($i);
          $res[$child->nodeName] = self::dom2array($child);
        }
      }
    }
    return $res;
  }

  private function sitepins_url($url) {
    return 'https://sitepins.net' . $url;
  }
  private function sitepins_date($date) {
    return (new \DateTime($date))->getTimestamp();
  }

}
