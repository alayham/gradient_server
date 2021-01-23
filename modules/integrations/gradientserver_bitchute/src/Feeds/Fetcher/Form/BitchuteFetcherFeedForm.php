<?php

namespace Drupal\gradientserver_bitchute\Feeds\Fetcher\Form;

use Drupal\feeds\Feeds\Fetcher\Form\HttpFetcherFeedForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\feeds\FeedInterface;

/**
 * Provides a form on the feed edit page for the HttpFetcher.
 */
class BitchuteFetcherFeedForm extends HttpFetcherFeedForm {

  /**
   * The base url for the feed.
   * 
   * @var string
   * 
   * @see https://support.bitchute.com/content/converting-a-bitchute-channel-into-an-rss-feed
   */
  protected $baseUrl = 'https://www.bitchute.com/feeds/rss/channel/';


  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state, FeedInterface $feed = NULL) {
    $form['source'] = [
      '#title' => $this->t('Feed URL'),
      '#type' => 'hidden',
      '#default_value' => $feed->getSource(),
    ];

    $form['channel'] = [
      '#title' => $this->t('Bitchute Channel'),
      '#type' => 'textfield',
      '#default_value' => $this->getChannelFromFeed($feed),
      '#maxlength' => 2048,
      '#required' => TRUE,
    ];
  
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state, FeedInterface $feed = NULL) {
    $form_state->setValue('source', $this->buildBitchuteRssUrl($form_state->getValue('channel')));
    parent::validateConfigurationForm($form, $form_state, $feed);
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state, FeedInterface $feed = NULL) {
    $form_state->setValue('source', $this->buildBitchuteRssUrl($form_state->getValue('channel')));
    parent::submitConfigurationForm($form, $form_state, $feed);
  }

  /**
   * Get a Bitchute channel name from the feed's url.
   * 
   * @param Drupal\Core\Form\FormStateInterface $feed
   *   A feed.
   * 
   * @return $string
   *   A Bitchute channel name.
   */
  protected function getChannelFromFeed(FeedInterface $feed) {
    if ($feed instanceof FeedInterface) {
      $source =  $feed->getSource();
      if(!empty($source)) {
        $parts = explode('/', $source);
        return end($parts);
      }
    }
    return NULL;
  }

  /**
   * Build a url from a channel name.
   * 
   * @param string $channel
   *   The channel name.
   * 
   * @return string
   *   A url for the bitchute RSS feed.
   */
  protected function buildBitchuteRssUrl($channel) {
    return $this->baseUrl . trim($channel, " \n\r\t\v\0/");
  }

}
