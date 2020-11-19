<?php

namespace Drupal\gradient_server\Commands;

use Drush\Commands\DrushCommands;
use Drupal\layout_builder\Plugin\SectionStorage\OverridesSectionStorage;
use Drupal\node\Entity\NodeType;
use Drupal\node\Entity\Node;
use Drupal\layout_builder\Section;
use Drupal\layout_builder\SectionComponent;
use Drupal\menu_link_content\Entity\MenuLinkContent;
class Home extends DrushCommands {

  /**
   * Create a homepage.
   *
   * @command gradient:homepage:create
   * @aliases ghc
   * @usage gradient:homepage:create
   */
  public function create() {
    $section1 = new Section('layout_twocol_section', ['column_widths' => '75-25']);
    $section1->appendComponent(new SectionComponent(\Drupal::service('uuid')->generate(), 'first', [
      'id' => 'views_block:new_items-teasers',
      'label' => 'Test block title',
      'label_display' => 'hidden',
    ]));
    $section1->appendComponent(new SectionComponent(\Drupal::service('uuid')->generate(), 'second', [
      'id' => 'views_block:new_feeds-block_1',
      'label' => 'Test block title',
      'label_display' => 'hidden',
    ]));
    $section1->appendComponent(new SectionComponent(\Drupal::service('uuid')->generate(), 'second', [
      'id' => 'views_block:new_sources-block_1',
      'label' => 'Test block title',
      'label_display' => 'hidden',
    ]));
    $section1->appendComponent(new SectionComponent(\Drupal::service('uuid')->generate(), 'second', [
      'id' => 'views_block:new_gradients-block_1',
      'label' => 'Test block title',
      'label_display' => 'hidden',
    ]));
    $page = Node::create([
      'type' => 'landing_page',
      'title' => 'Welcome to Gradient Server',
      'status' => 1,
      'uid' => 1,
      'path' => '/home',
      OverridesSectionStorage::FIELD_NAME => [$section1],
    ]);
    $page->save();
    MenuLinkContent::create([
      'title' => 'Home',
      'menu_name' => 'main',
      'bundle' => 'menu_link_content',
      'weight' => -50,
      'link' => [['uri' => 'entity:node/' . $page->id()]],
    ])->save();
    \Drupal::configFactory()
      ->getEditable('system.site')
      ->set('page.front', $page->toUrl()->toString())
      ->save();
  }

}
