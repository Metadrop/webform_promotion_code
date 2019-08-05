<?php

namespace Drupal\webform_promotion_code\Plugin\WebformElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformElementBase;

/**
 * Provides a 'webform_promotion_code' element.
 *
 * @WebformElement(
 *   id = "webform_promotion_code",
 *   label = @Translation("Promotion code element"),
 *   description = @Translation("Provides a promotion code element."),
 *   category = @Translation("Advanced elements"),
 * )
 *
 * @see \Drupal\webform_promotion_code\Element\WebformExampleElement
 * @see \Drupal\webform\Plugin\WebformElementBase
 * @see \Drupal\webform\Plugin\WebformElementInterface
 * @see \Drupal\webform\Annotation\WebformElement
 */
class WebformPromotionCode extends WebformElementBase {

  /**
   * {@inheritdoc}
   */
  public function getDefaultProperties() {
    return parent::getDefaultProperties() + [
      'codes' => '',
      'amount' => 100,
      'code_length' => 6,
      'code_pattern' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $form['promotion_code'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Promotion code settings'),
    ];
    $form['promotion_code']['codes'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Valid promotion code list'),
      '#description' => $this->t('Specify the list of valid promotion codes. Enter one code per line.'),
    ];

    $form['promotion_code']['amount'] = [
      '#type' => 'number',
      '#title' => $this->t('Amount of code to be generated'),
      '#description' => $this->t('You can auto generate any number of random codes by specifing the amount and clicking on "Auto generate" button.'),
    ];
    $form['promotion_code']['code_length'] = [
      '#type' => 'number',
      '#title' => $this->t('Code length for the codes to be generated'),
      '#description' => $this->t('You can specify the length of the codes to be automatically generated.'),
    ];
    $form['promotion_code']['code_pattern'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Valid characters for the codes to be generated'),
      '#suffix' => '<span class="button wpc-auto-generate">Auto generate</span>',
      '#description' => $this->t('You can specify the valid characters for the code that will be generated. Example: If "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789" is inserted only capital letters and numbers will be used to generate the code.'),
    ];

    $form['#attached']['library'][] = 'webform_promotion_code/webform.admin.promotion_code_style';
    $form['#attached']['library'][] = 'webform_promotion_code/webform.admin.promotion_code_js';

    return $form;
  }

}
