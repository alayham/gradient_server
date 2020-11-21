<?php

namespace Drupal\source\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * The Source type form.
 */
class SourceTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $source_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $source_type->label(),
      '#description' => $this->t("Label for the Source type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $source_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\source\Entity\SourceType::load',
      ],
      '#disabled' => !$source_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $source_type = $this->entity;
    $status = $source_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Source type.', [
          '%label' => $source_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Source type.', [
          '%label' => $source_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($source_type->toUrl('collection'));
  }

}
