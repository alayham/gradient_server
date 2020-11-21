<?php

namespace Drupal\source\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\source\Entity\SourceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SourceController.
 *
 *  Returns responses for Source routes.
 */
class SourceController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->dateFormatter = $container->get('date.formatter');
    $instance->renderer = $container->get('renderer');
    return $instance;
  }

  /**
   * Displays a Source revision.
   *
   * @param int $source_revision
   *   The Source revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($source_revision) {
    $source = $this->entityTypeManager()->getStorage('source')
      ->loadRevision($source_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('source');

    return $view_builder->view($source);
  }

  /**
   * Page title callback for a Source revision.
   *
   * @param int $source_revision
   *   The Source revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($source_revision) {
    $source = $this->entityTypeManager()->getStorage('source')
      ->loadRevision($source_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $source->label(),
      '%date' => $this->dateFormatter->format($source->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Source.
   *
   * @param \Drupal\source\Entity\SourceInterface $source
   *   A Source object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(SourceInterface $source) {
    $account = $this->currentUser();
    $source_storage = $this->entityTypeManager()->getStorage('source');

    $langcode = $source->language()->getId();
    $langname = $source->language()->getName();
    $languages = $source->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ?
      $this->t('@langname revisions for %title', [
        '@langname' => $langname,
        '%title' => $source->label(),
      ]) :
      $this->t('Revisions for %title', ['%title' => $source->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all source revisions") || $account->hasPermission('administer source entities')));
    $delete_permission = (($account->hasPermission("delete all source revisions") || $account->hasPermission('administer source entities')));

    $rows = [];

    $vids = $source_storage->revisionIds($source);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\source\SourceInterface $revision */
      $revision = $source_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $source->getRevisionId()) {
          $link = $this->l($date, new Url('entity.source.revision', [
            'source' => $source->id(),
            'source_revision' => $vid,
          ]));
        }
        else {
          $link = $source->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.source.translation_revert', [
                'source' => $source->id(),
                'source_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.source.revision_revert', [
                'source' => $source->id(),
                'source_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.source.revision_delete', [
                'source' => $source->id(),
                'source_revision' => $vid,
              ]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['source_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
