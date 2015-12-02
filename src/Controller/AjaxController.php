<?php

/**
 * @file
 * Contains \Drupal\drupal8_testing\Controller\AjaxController.
 */

namespace Drupal\drupal8_testing\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class AjaxController.
 *
 * @package Drupal\drupal8_testing\Controller
 */
class AjaxController extends ControllerBase {
  /**
   * Index.
   *
   * @return string
   *   Return Hello string.
   */
  public function index() {
    return \Drupal::formBuilder()->getForm('Drupal\drupal8_testing\Form\AjaxForm');
  }

}
