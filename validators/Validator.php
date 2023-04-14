<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/5/2023
 * Time: 11:40 AM
 */

namespace roshangiga;

use Exception;

/**
 *      // Example usage:
 *      $fields = array(
 *          'name' => 'Required|Alphanumeric|MaxLength:50',
 *          'phone' => 'Numeric'
 *      );
 *
 *      $validator = new Validator($fields);
 *
 *      $input = array(
 *          'name' => 'John Doe',
 *          'phone' => '1234567890'
 *      );
 *
 *      $errors = $validator->validate($input);
 *
 *      if (count($errors) > 0) {
 *          // Handle validation errors
 *         echo $validator->display_errors();
 *      } else {
 *          // Input is valid
 *      }
 */
class Validator
{

    private $fields;
    private $inputs;
    private $errors;

    public function __construct($fields, $inputs)
    {
        $this->fields = $fields;
        $this->inputs = $inputs;
    }

    /**
     * Validates an array of input data.
     *
     * @return array An associative array of field names and validation error messages.
     */
    public function validate()
    {
        $errors = [];

        foreach ($this->fields as $field => $fieldRules) {

            $ruleList = explode('|', $fieldRules);

            foreach ($ruleList as $ruleWithParams) {
                [$rule, $params] = static::parseRule($ruleWithParams);

                $namespacedRuleName = __NAMESPACE__ . '\\' . $rule;

                if (!class_exists($namespacedRuleName)) {
                    throw new \RuntimeException("Validator class '{$rule}' not found.");
                }

                $validator = new $namespacedRuleName($params);

                if (!$validator->validate($this->inputs[$field])) {
                    $errors[$field][] = $validator->getErrorMessage($field);
                }
            }
        }
        $this->errors = $errors;
        return $errors;
    }

    protected static function parseRule($ruleWithParams)
    {
        $params = [];

        if (strpos($ruleWithParams, ':') !== false) {
            list($rule, $paramString) = explode(':', $ruleWithParams);
            $params = explode(',', $paramString);
        } else {
            $rule = $ruleWithParams;
        }
        return [$rule, $params];
    }

    public function isValid()
    {
        return empty($this->errors);
    }

    public function getErrors() {
        return $this->errors;
    }


    /**
     * Generates an HTML error message from an array of validation errors.
     *
     * @param array $errors An associative array of field names and validation error messages.
     * @return string The HTML error message.
     */
    public static function display_errors($errors)
    {

        if (empty($errors)) {
            return '';
        }

        if (count($errors) > 1) {
            $str_error = 'errors were';
        } else {
            $str_error = 'error was';
        }

        $errorMessage = '<div class="error-message" style="background-color: #F8D7DA; color: #721C24; border: 1px solid #F5C6CB; padding: 10px; margin-bottom: 10px;">';
        $errorMessage .= '<h4 style="margin-top: 0;">Form could not be submitted. The following ' . $str_error . ' found:</h4>';
        $errorMessage .= '<ul style="margin: 0; padding: 0 0 0 20px; ">';

        foreach ($errors as $field => $errorMessages) {

            echo "Errors for {$field}:<br>";

            foreach ($errorMessages as $errorMessage) {
                $errorMessage .= '<li>' . htmlspecialchars($errorMessage) . '</li>';
            }
        }

        $errorMessage .= '</ul></div><br/>';

        return $errorMessage;
    }
}
