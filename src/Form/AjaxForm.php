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

    if ($form_state->hasValue('date')) {
      $userInput = $form_state->getUserInput();
      $userInput['result'] = 'Date Set';
      $form_state->setUserInput($userInput);
    } else {
      $form_state->setValue('date', date('Y-m-d', REQUEST_TIME));
      $form_state->setValue('result', 'date not set');
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
    ];

    $form['ajax_wrapper']['submit_button'] = [
      '#type' => 'submit',
      '#value' => 'Load',
      '#ajax' => [
        'callback' => [$this, 'ajaxFormCallback'],
      ],
    ];

    $form['ajax_wrapper']['result'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Result'),
      '#default_value' => $result,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    dd('validate');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    dd('submit');
    dd('Submitted Result: ' . $form_state->getValue('result'));
    $form_state->setRebuild();
  }

  public function ajaxFormCallback(array &$form, FormStateInterface $form_state) {
    dd('callback');
    //dd(array_keys($form['ajax_wrapper']));
    $response = new AjaxResponse();
    $response->addCommand(new HtmlCommand('#ajax_wrapper', $form['ajax_wrapper']));
    $status_messages = ['#type' => 'status_messages'];
    $response->addCommand(new HtmlCommand('.highlighted aside .region', $status_messages));

    return $response;
  }

}
