<?php

namespace Drupal\gradientserver_bitchute\Feeds\Fetcher;

use Drupal\feeds\Feeds\Fetcher\HttpFetcher;

/**
 * Defines an HTTP fetcher.
 *
 * @FeedsFetcher(
 *   id = "gradientserver_bitchute",
 *   title = @Translation("Bitchute channel (as RSS feed)"),
 *   description = @Translation("Downloads a bitchute channel as a bitchute rss feed."),
 *   form = {
 *     "configuration" = "Drupal\gradientserver_bitchute\Feeds\Fetcher\Form\BitchuteFetcherFrom",
 *     "feed" = "Drupal\gradientserver_bitchute\Feeds\Fetcher\Form\BitchuteFetcherFeedForm",
 *   }
 * )
 */
class BitchuteFetcher extends HttpFetcher  {

}
