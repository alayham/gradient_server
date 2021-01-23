<?php

namespace Drupal\gradientserver_bitchute\Feeds\Fetcher\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\feeds\Feeds\Fetcher\Form\HttpFetcherForm;

/**
 * The configuration form for http fetchers.
 */
class BitchuteFetcherFrom extends HttpFetcherForm {

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['auto_detect_feeds'] = [
      '#type' => 'hidden',
      '#default_value' => false,
    ];
    $form['use_pubsubhubbub'] = [
      '#type' => 'hidden',
      '#default_value' => false,
    ];
    $form['always_download'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Always download'),
      '#description' => $this->t('Always download the feed, even if the feed has not been updated.'),
      '#default_value' => $this->plugin->getConfiguration('always_download'),
    ];
    // Per feed type override of global http request timeout setting.
    $form['request_timeout'] = [
      '#type' => 'number',
      '#title' => $this->t('Request timeout'),
      '#description' => $this->t('Timeout in seconds to wait for an HTTP request to finish.'),
      '#default_value' => $this->plugin->getConfiguration('request_timeout'),
      '#min' => 0,
    ];

    return $form;
  }

}
