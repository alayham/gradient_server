<?php

namespace Drupal\gradientserver_sitepins\Feeds\Item;

use Drupal\feeds\Feeds\Item\BaseItem;

/**
 * A sitepins.net item.
 */
class SitePinsItem extends BaseItem {

    protected $guid;

    protected $sitepins_thumbnail_url;

    protected $sitepins_video_url;

    protected $title;

    protected $created;

    protected $sitepins_author;

}
