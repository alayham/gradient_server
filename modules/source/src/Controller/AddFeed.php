<?php

namespace Drupal\source\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityFormBuilder;
use Drupal\feeds\Entity\FeedType;
use Drupal\feeds\Entity\Feed;
use Drupal\source\Entity\Source;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * The AddFeed route controller.
 */
class AddFeed extends ControllerBase {

  /**
   * The entity form builder service.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilder
   */
  protected $builder;

  /**
   * Constructs a controller object.
   *
   * @param \Drupal\Core\Entity\EntityFormBuilder $entity_form_builder
   *   The entity form builder service.
   */
  public function __construct(EntityFormBuilder $entity_form_builder) {
    $this->builder = $entity_form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.form_builder')
    );
  }

  /**
   * Creates the bySource form for the feed.
   */
  public function bySource(FeedType $feed_type, Source $source) {
    $feed = Feed::create([
      'type' => $feed_type->id(),
      'source_entity' => $source,
    ]);
    $form = $this->builder->getForm($feed, 'default');

    $form['source_entity']['#attributes']['class'][] = 'visually-hidden';
    return $form;
  }

  /**
   * Title callback for the bySource route.
   */
  public function bySourceTitle(FeedType $feed_type, Source $source) {
    return new TranslatableMarkup('Add a new <strong>@type</strong> to source <strong>@source</strong>', [
      '@type' => $feed_type->label(),
      '@source' => $source->label(),
    ]);
  }

}
