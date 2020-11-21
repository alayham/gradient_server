<?php

namespace Drupal\gradient_core\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Views;
use Drupal\source\Entity\Source;

/**
 * Provides a source content block.
 *
 * @Block(
 *   id = "source_content_block",
 *   admin_label = @Translation("Source content list"),
 *   category = @Translation("Gradient Server: Lists"),
 * )
 */
class SourceContentBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'view_mode' => 'titles',
      'sort_by' => 'created',
      'count' => 10,
      'source' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['source'] = [
      '#type' => 'entity_autocomplete',
      '#title' => 'Choose a source',
      '#target_type' => 'source',
      '#default_value' => Source::load($this->configuration['source']),
      '#selection_handler' => 'default',
      '#selection_settings' => [
        'target_bundles' => ['website'],
      ],
      '#autocreate' => NULL,
    ];
    $form['view_mode'] = [
      '#type' => 'select',
      '#title' => $this->t('View mode'),
      '#default_value' => $this->configuration['view_mode'],
      '#options' => [
        'titles' => 'List of content titles',
        'teasers' => 'Content teasers',
      ],
    ];
    $form['sort_by'] = [
      '#type' => 'select',
      '#title' => $this->t('Sort by'),
      '#default_value' => $this->configuration['sort_by'],
      '#options' => [
        'recent' => 'Post date',
        'updated' => 'Updated date',
      ],
    ];
    $form['count'] = [
      '#type' => 'select',
      '#title' => $this->t('Item count'),
      '#default_value' => $this->configuration['count'],
      '#options' => [
        '5' => '5',
        '10' => '10',
        '15' => '15',
        '20' => '20',
        '25' => '25',
        '30' => '30',
      ],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['source'] = $form_state->getValue('source');
    $this->configuration['view_mode'] = $form_state->getValue('view_mode');
    $this->configuration['sort_by'] = $form_state->getValue('sort_by');
    $this->configuration['count'] = $form_state->getValue('count');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    if ($this->configuration['view_mode'] === 'titles') {
      if ($this->configuration['sort_by'] === 'recent') {
        $display = 'source_recent_list';
      }
      elseif ($this->configuration['sort_by'] === 'updated') {
        $display = 'source_updated_list';
      }
      else {
        return [];
      }
    }
    elseif ($this->configuration['view_mode'] === 'teasers') {
      if ($this->configuration['sort_by'] === 'recent') {
        $display = 'source_recent_teasers';
      }
      elseif ($this->configuration['sort_by'] === 'updated') {
        $display = 'source_updated_teasers';
      }
      else {
        return [];
      }
    }
    $view = Views::getView('source_content');
    if (is_object($view)) {
      $view->setDisplay($display);
      $view->setArguments([$this->configuration['source']]);
      $view->getPager()->setItemsPerPage($this->configuration['count']);
      $view->preExecute();
      return $view->render();
    }
    return [];
  }

}
