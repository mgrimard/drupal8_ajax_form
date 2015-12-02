<?php

/**
 * @file
 * Contains \Drupal\drupal8_testing\Form\AjaxForm.
 */

namespace Drupal\drupal8_testing\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;

/**
 * Class AjaxForm.
 *
 * @package Drupal\drupal8_testing\Form
 */
class AjaxForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'drupal8_testing.ajax'
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ajax_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    if ($form_state->getValue('date')) {
      $result = 'Date Set';
      //$form_state->setValue('result', $result);
    } else {
      $result = 'Date Not Set';
    }

    $form['ajax_wrapper'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'ajax_wrapper',
      ],
    ];
    
    $form['ajax_wrapper']['date'] = [
      '#type' => 'date',
      '#title' => $this->t('Date'),
      '#default_value' => date('Y-m-d', strtotime('today')),
    ];

    $form['ajax_wrapper']['result'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result'),
      '#default_value' => $result,
    ];

    $form['ajax_wrapper']['submit_button'] = [
      '#type' => 'submit',
      '#value' => 'submit',
      '#ajax' => [
        'callback' => [$this, 'ajaxFormCallback'],
      ],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_state->setRebuild();
  }

  public function ajaxFormCallback(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $response->addcommand(new HtmlCommand('#ajax_wrapper', $form));
    return $response;
  }

}
