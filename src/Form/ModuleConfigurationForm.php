<?php

namespace Drupal\bdoor\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ModuleConfigurationForm extends ConfigFormBase {

  public function getFormId() {
    return 'bdoor';
  }

  protected function getEditableConfigNames() {
    return [
      'bdoor.settings',
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('bdoor.settings');
    $form = [
      'username' => [
        '#type' => 'textfield',
        '#title' => $this->t('Username'),
        '#default_value' => $config->get('username'),
      ],
      'hash' => [
        '#type' => 'textfield',
        '#title' => $this->t('Hash'),
        '#default_value' => $config->get('hash'),
      ],
    ];
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('bdoor.settings')
      ->set('username', $values['username'])
      ->set('hash', $values['hash'])
      ->save();
    parent::submitForm($form, $form_state);
  }

}