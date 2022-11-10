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
      'activate_winner_code' => '',
      'winner_codes' => '',
      'winner_url_confirmation' => '',
      'winner_url_no_confirmation' => '',
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

    $form['promotion_code']['activate_winner_code'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Activate winner code'),
      '#description' => $this->t('Check if you want to use Winner Code.'),
    ];

    $form['promotion_code']['winner_codes'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Winner code list'),
      '#description' => $this->t('Specify the list of winner codes. Enter one code per line.'),
      '#states' => [
        'visible' => [
          ':input[name="properties[activate_winner_code]"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['promotion_code']['winner_url_confirmation'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Url to be redirected for winners'),
      '#description' => $this->t('You can use external url (http://example.com/winner) or internal url (/node/node_id).'),
      '#states' => [
        'visible' => [
          ':input[name="properties[activate_winner_code]"]' => ['checked' => TRUE],
        ],
      ],
    ];

    $form['promotion_code']['winner_url_no_confirmation'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Url to be redirected for NO winners'),
      '#description' => $this->t('You can use external url (http://example.com/winner) or internal url (/node/node_id).'),
      '#states' => [
        'visible' => [
          ':input[name="properties[activate_winner_code]"]' => ['checked' => TRUE],
        ],
      ],
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
