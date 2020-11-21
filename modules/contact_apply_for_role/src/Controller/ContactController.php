<?php

namespace Drupal\contact_apply_for_role\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\contact\MessageInterface;
use Drupal\system\Entity\Action;
use Drupal\user\Entity\User;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Cache\Cache;

/**
 * The contact controller class.
 */
class ContactController extends ControllerBase {

  /**
   * Approce a role.
   *
   * @param \Drupal\contact\MessageInterface $contact_message
   *   The contact message.
   */
  public function approveRole(MessageInterface $contact_message) {
    $redirect = $contact_message->toUrl('canonical')->toString();

    $uid = $contact_message->get('uid')->target_id;
    $user = User::load($uid);
    if (!$user) {
      $this->messenger()->addError('The application is incomplete and can not be approved. The user is missing');
      return new RedirectResponse($redirect);
    }

    $role = $contact_message->get('role')->entity;
    if (!$role) {
      $this->messenger()->addError('The application is incomplete and can not be approved. The role is missing');
      return new RedirectResponse($redirect);
    }
    $action = Action::load('user_add_role_action.' . $role->id());
    if (!$action) {
      $this->messenger()->addError('The application is complete but it can not be approved because the action to assign the role to the user is missing');
      return new RedirectResponse($redirect);
    }
    $action->execute([$user]);
    Cache::invalidateTags(['contact_message:' . $contact_message->id()]);
    $this->messenger()->addStatus('The application was successfully approved.');
    return new RedirectResponse($redirect);

  }

  /**
   * Access callback for the ApproveRole route.
   *
   * @param \Drupal\contact\MessageInterface $contact_message
   *   The contact message.
   */
  public function approveRoleAccess(MessageInterface $contact_message) {
    $uid = $contact_message->get('uid')->target_id;
    $user = User::load($uid);
    $role = $contact_message->get('role')->target_id;
    return AccessResult::allowedIf(!$user->hasRole($role));
  }

}
