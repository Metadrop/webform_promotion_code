<?php

namespace Drupal\webform_promotion_code\Element;

use Drupal\Core\Render\Element;
use Drupal\Core\Render\Element\FormElement;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'webform_promotion_code'.
 *
 * Below is the definition for 'webform_promotion_code' which
 * renders a text field.
 *
 * @FormElement("webform_promotion_code")
 *
 * @see \Drupal\Core\Render\Element\FormElement
 * @see https://api.drupal.org/api/drupal/core%21lib%21Drupal%21Core%21Render%21Element%21FormElement.php/class/FormElement
 * @see \Drupal\Core\Render\Element\RenderElement
 * @see https://api.drupal.org/api/drupal/namespace/Drupal%21Core%21Render%21Element
 * @see \Drupal\webform_example_element\Element\WebformExampleElement
 */
class WebformPromotionCode extends FormElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#input' => TRUE,
      '#size' => 60,
      '#process' => [
        [$class, 'processWebformPromotionCode'],
        [$class, 'processAjaxForm'],
      ],
      '#element_validate' => [
        [$class, 'validateWebformPromotionCode'],
      ],
      '#pre_render' => [
        [$class, 'preRenderWebformPromotionCode'],
      ],
      '#theme' => 'input__webform_promotion_code',
      '#theme_wrappers' => ['form_element'],
    ];
  }

  /**
   * Processes a 'webform_promotion_code' element.
   */
  public static function processWebformPromotionCode(&$element, FormStateInterface $form_state, &$complete_form) {
    // Here you can add and manipulate your element's properties and callbacks.
    return $element;
  }

  /**
   * Webform element validation handler for #type 'webform_example_element'.
   */
  public static function validateWebformPromotionCode(&$element, FormStateInterface $form_state, &$complete_form) {
    $has_access = (!isset($element['#access']) || $element['#access'] === TRUE);

    $value = $element['#value'];
    if ($value === '') {
      return;
    }

    $promotion_code = trim($value);
    if ($promotion_code === FALSE) {
      if ($has_access) {
        if (isset($element['#title'])) {
          $form_state->setError($element, t('%name must be a valid code.', ['%name' => $element['#title']]));
        }
        else {
          $form_state->setError($element);
        }
      }
      return;
    }

    $valid_codes = trim($element['#codes']);
    $valid_codes_array = array_map('trim', explode(PHP_EOL, $valid_codes));

    if ($has_access && in_array($promotion_code, $valid_codes_array) === FALSE) {
      $form_state->setError($element, t('%name must be a valid code.', ['%name' => $element['#title']]));
    }
  }

  /**
   * Prepares a #type 'email_multiple' render element for theme_element().
   *
   * @param array $element
   *   An associative array containing the properties of the element.
   *   Properties used: #title, #value, #description, #size, #maxlength,
   *   #placeholder, #required, #attributes.
   *
   * @return array
   *   The $element with prepared variables ready for theme_element().
   */
  public static function preRenderWebformPromotionCode(array $element) {
    $element['#attributes']['type'] = 'text';
    Element::setAttributes(
        $element,
        ['id', 'name', 'value', 'size', 'maxlength', 'placeholder']
    );
    static::setAttributes($element, ['form-text', 'webform-promotion-code']);
    return $element;
  }

}
