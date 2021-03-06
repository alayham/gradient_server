<?php

namespace Drupal\gradient\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * The Gradient type form.
 */
class GradientTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $gradient_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $gradient_type->label(),
      '#description' => $this->t("Label for the Gradient type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $gradient_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\gradient\Entity\GradientType::load',
      ],
      '#disabled' => !$gradient_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $gradient_type = $this->entity;
    $status = $gradient_type->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Gradient type.', [
          '%label' => $gradient_type->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Gradient type.', [
          '%label' => $gradient_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($gradient_type->toUrl('collection'));
  }

}
