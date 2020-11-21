<?php

namespace Drupal\gradient\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\gradient\Entity\GradientInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GradientController.
 *
 *  Returns responses for Gradient routes.
 */
class GradientController extends ControllerBase implements ContainerInjectionInterface {

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
   * Displays a Gradient revision.
   *
   * @param int $gradient_revision
   *   The Gradient revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($gradient_revision) {
    $gradient = $this->entityTypeManager()->getStorage('gradient')
      ->loadRevision($gradient_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('gradient');

    return $view_builder->view($gradient);
  }

  /**
   * Page title callback for a Gradient revision.
   *
   * @param int $gradient_revision
   *   The Gradient revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($gradient_revision) {
    $gradient = $this->entityTypeManager()->getStorage('gradient')
      ->loadRevision($gradient_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $gradient->label(),
      '%date' => $this->dateFormatter->format($gradient->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Gradient.
   *
   * @param \Drupal\gradient\Entity\GradientInterface $gradient
   *   A Gradient object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(GradientInterface $gradient) {
    $account = $this->currentUser();
    $gradient_storage = $this->entityTypeManager()->getStorage('gradient');

    $build['#title'] = $this->t('Revisions for %title', ['%title' => $gradient->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all gradient revisions") || $account->hasPermission('administer gradient entities')));
    $delete_permission = (($account->hasPermission("delete all gradient revisions") || $account->hasPermission('administer gradient entities')));

    $rows = [];

    $vids = $gradient_storage->revisionIds($gradient);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\gradient\GradientInterface $revision */
      $revision = $gradient_storage->loadRevision($vid);
      $username = [
        '#theme' => 'username',
        '#account' => $revision->getRevisionUser(),
      ];

      // Use revision link to link to revisions that are not active.
      $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
      if ($vid != $gradient->getRevisionId()) {
        $link = $this->l($date, new Url('entity.gradient.revision', [
          'gradient' => $gradient->id(),
          'gradient_revision' => $vid,
        ]));
      }
      else {
        $link = $gradient->link($date);
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
            'url' => Url::fromRoute('entity.gradient.revision_revert', [
              'gradient' => $gradient->id(),
              'gradient_revision' => $vid,
            ]),
          ];
        }

        if ($delete_permission) {
          $links['delete'] = [
            'title' => $this->t('Delete'),
            'url' => Url::fromRoute('entity.gradient.revision_delete', [
              'gradient' => $gradient->id(),
              'gradient_revision' => $vid,
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

    $build['gradient_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
