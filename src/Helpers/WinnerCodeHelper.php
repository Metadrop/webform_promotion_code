<?php

namespace Drupal\webform_promotion_code\Helpers;

use Drupal\webform\WebformSubmissionInterface;
use Drupal\webform\Entity\Webform;
use Drupal\Core\Serialization\Yaml;

/**
 * Helper to winner Codes.
 */
class WinnerCodeHelper {

  /**
   * Winner submission name.
   *
   * @var string
   */
  const WINNER_SUBMISSION_ELEMENT_NAME = 'webform_promotion_code_is_winner_submission';

  /**
   * Return TRUE if it has element type Winner Code.
   */
  public static function isWinnerCodeField(array $element) {
    if ($element['#type'] === 'webform_promotion_code' && array_key_exists("#activate_winner_code", $element)) {
      return (boolean) $element["#activate_winner_code"];
    }
    return FALSE;
  }

  /**
   * Return TRUE if submission has a winner code.
   */
  public static function hasWinnerCodeInserted(string $name, WebformSubmissionInterface $webform_submission) {
    if (isset($webform_submission->getData()[$name])) {
      $array_winner_codes = array_map('trim', explode(PHP_EOL, $webform_submission->getWebform()->getElementsDecoded()[$name]["#winner_codes"]));
      return in_array($webform_submission->getData()[$name], $array_winner_codes);
    }
    return FALSE;
  }

  /**
   * Get URL when is a winner code.
   */
  public static function getUrlConfirmWinnerCode(array $element) {
    return (string) $element["#winner_url_confirmation"];
  }

  /**
   * Get URL when not is a winner code.
   */
  public static function getUrlFailWinnerCode(array $element) {
    return (string) $element["#winner_url_no_confirmation"];
  }

  /**
   * Return TRUE if webform has Winner Code.
   */
  public static function hasWinnerCodeField(Webform $webform) {
    $result = FALSE;
    foreach ($webform->getElementsDecoded() as $element) {
      $result = WinnerCodeHelper::isWinnerCodeField($element);
      if ($result) {
        break;
      }
    }
    return $result;
  }

  /**
   * Return TRUE if webform has field $fieldName.
   */
  public static function hasField(Webform $webform, $fieldName) {
    return isset($webform->getElementsDecoded()[$fieldName]);
  }

  /**
   * Return TRUE if webform has field $fieldName.
   */
  public static function hasFieldWinnerSubmission(Webform $webform) {
    return isset($webform->getElementsDecoded()[self::WINNER_SUBMISSION_ELEMENT_NAME]);
  }

  /**
   * Add field winner submission.
   */
  public static function addWinnerSubmissionField(Webform &$webform) {
    $elements = Yaml::decode($webform->get('elements'));

    foreach ($elements as $key => $unused) {
      $last_key = $key;
    }
    $last_element = array_pop($elements);

    $elements[self::WINNER_SUBMISSION_ELEMENT_NAME] = [
      '#type' => 'hidden',
      '#title' => 'Winner Code - Is Winner (automatic field)',
      '#private' => TRUE,
    ];

    $elements[$last_key] = $last_element;
    $webform->setElements($elements)->save();

  }

}
