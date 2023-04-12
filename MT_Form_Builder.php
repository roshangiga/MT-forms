<?php
/**
 * Created by PhpStorm.
 * User: roshan.summun
 * Date: 4/12/2023
 * Time: 11:01 AM
 */

namespace roshangiga;

class MT_Form_Builder
{
    private static $form_count = 0;
    private static $form_ids;
    private $form_id;
    private array $elements;

    /**
     *  Use an internal static count to automatically assign it if nothing is supplied in the constructor
     *
     * @param $form_id
     * @throws Duplicate_Form_ID_Exception If the form_id is already used
     */
    public function __construct($form_id = null)
    {
        // Check if the submitted form_id is unique
        if ($form_id !== null) {
            $form_id = (int)$form_id;
            if (in_array($form_id, self::$form_ids, true)) {
                throw new Duplicate_Form_ID_Exception('The form ID ' . $form_id . ' already exists.');
            }
        } else {
            self::$form_count++;
            $form_id = self::$form_count;
        }

        $this->form_id = $form_id;
        self::$form_ids[] = $form_id;

        $this->elements = array();
    }

    /**
     * @return int
     */
    public function get_form_id()
    {
        return $this->form_id;
    }

    /**
     * This method adds a form element to the form.
     *
     *
     *      //Example usage
     *
     *      $form->add_element('Input', array(
     *          'name' => 'email',
     *          'label' => 'Email Address',
     *          'value' => '',
     *          'attributes' => array(
     *             'class' => 'form-control',
     *             'placeholder' => 'Enter your email address',
     *           ),
     *        'validation_rules' =>'Required|Email',
     *        ),
     *      ));
     *
     * @param $element_type
     * @param array $args dictionary that must contain label, value, attributes[], validation_rules
     * @return void
     * @throws Element_Exception if Element class not found
     */

    public function add_element($element_type, $args)
    {
        // Initialize variables
        $value = $label = $attributes = $validation_rules = null;

        // Instantiate element if it exists
        // always capitalize $element_type
        $element_type = ucfirst($element_type);

        // Proceed to instantiate the element class
        $namespacedElementClassName = __NAMESPACE__ . '\\' . $element_type;

        if (!class_exists($namespacedElementClassName)) {
            throw new Element_Exception("Form Element of type '{$element_type}' not found at $namespacedElementClassName. Maybe check spelling or Element class missing?");
        }

        // Extract the element arguments as variables.
        // args should contain label, value, attributes[], validation_rules
        extract($args, EXTR_OVERWRITE);

        $element = new $namespacedElementClassName($attributes, $this->form_id);

        $element->label($label);                       // args can contain label
        $element->value($value);                       // args can contain value
        $element->validation_rules($validation_rules); // args can contain validation_rules

        // Add the element in the elements list of the form.
        $this->elements[] = $element;
    }

    /**
     * This method renders(outputs) the form elements by calling the render() method of each element
     *
     *      Hooks:
     *      custom_form_before_render: This hook is called before rendering the form.
     *          You can use this hook to add custom content or perform actions before the form is displayed.
     *
     *      custom_form_before_elements: This hook is called before rendering the form elements.
     *          You can use this hook to add custom content or perform actions before the form elements are displayed.
     *
     *      custom_form_after_elements: This hook is called after rendering the form elements.
     *          You can use this hook to add custom content or perform actions after the form elements are displayed.
     *
     *      custom_form_after_render: This hook is called after rendering the form.
     *          You can use this hook to add custom content or perform actions after the form is displayed.
     *
     * @param array $atts The attributes of the form. See the shortcode_atts() function inside for the options.
     * @return void
     */
    public function render_form(array $atts)
    {
        // Action hook before rendering the form
        do_action("mt_form_before_render_{$this->form_id}", $this);

        // Merge default attributes with the provided attributes
        // Ref: https://developer.wordpress.org/reference/functions/shortcode_atts/
        $atts = shortcode_atts(array('id'            => 'mt-form-' . $this->form_id,
                                     'class'         => 'mt-form',
                                     'method'        => 'post',
                                     'action'        => '',
                                     'enctype'       => '',
                                     'submit_button' => true, // Show submit_button e.g. to not display use $form->render_form(array('submit_button' => false))
                                     ), $atts);

         // Start the output buffer
         ob_start();

        // Render the form opening tag
        //echo '<form id="' . esc_attr($atts['id']) . '" class="' . esc_attr($atts['class']) . '" method="' . esc_attr($atts['method']) . '" action="' . esc_attr($atts['action']) . '" enctype="' . esc_attr($atts['enctype']) . '">';
        echo sprintf('<form id="%s" class="%s" method="%s" action="%s" enctype="%s">',
                     esc_attr($atts['id']),
                     esc_attr($atts['class']),
                     esc_attr($atts['method']),
                     esc_attr($atts['action']) ?: esc_url($_SERVER['REQUEST_URI']),
                     esc_attr($atts['enctype']) ?: 'multipart/form-data'
        );

        // Render the nonce field
        wp_nonce_field('mt_form_nonce', 'mt_form_nonce');

        //  Add a hidden input field for the form_id. This is used to identify the form when the form is submitted.
        echo sprintf('<input type="hidden" name="form_id" value="%d">', $this->form_id);

        // Action hook before rendering form elements
        do_action("mt_form_before_elements_{$this->form_id}", $this);


        // Render the form elements
        foreach ($this->elements as $element) {
            echo $element->render($this->form_id);
        }

        // Action hook after rendering form elements
        do_action("mt_form_after_elements_{$this->form_id}", $this);


        // Render the submit button if the submit_button attribute is set to true
        if ($atts['submit_button']) {
            echo '<input type="submit" class="mt-form-submit" value="Submit">';
        }

        // Render the form closing tag
        echo '</form>';

        // Get the output buffer contents and end the buffer
        $output = ob_get_clean();

        // Action hook after rendering the form
        do_action("mt_form_after_render_{$this->form_id}", $this);

        // Echo then Return the form HTML
        echo $output;
        return $output;
    }


    /**
     * This method processes the form data and applies the custom_form_data filter with the form_id
     *
     * @return void
     * @throws Security_Check_Exception Invalid nonce
     * @throws Validation_Exception
     */
    public function process_form()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mt_form_nonce'])) {
            if (!wp_verify_nonce($_POST['mt_form_nonce'], 'mt_form_nonce')) {
                throw new Security_Check_Exception('Security check failed');
            }

            // Call the validate method before processing the form data
            $this->validate();


            // Prepare the form data for filters
            $form_data = array();
            foreach ($this->elements as $element) {
                if ($element instanceof Form_Element_Interface) {
                    $field_name = $element->args['name'];
                    $form_data[$field_name] = isset($_POST[$field_name]) ? $_POST[$field_name] : null;
                }
            }


            // Action hook before processing form data
            do_action("mt_form_before_process_{$this->form_id}", $this, $form_data);


            // Filter the form data using mt_form_data filter
            $processed_data = apply_filters("mt_form_data_{$this->form_id}", $form_data, $this->form_id);


            // Action hook after processing form data
            do_action("mt_form_after_process_{$this->form_id}", $this, $processed_data);

        }
    }

    /**
     * @throws Validation_Exception
     */
    public function validate()
    {

        // Create an array to store rules
        $rules = array();

        // Iterate through form elements
        foreach ($this->elements as $element) {

            // Check if the element has a validation rule
            if (isset($element->attributes['validation']) && !empty($element->attributes['validation'])) {
                $field_name = $element->attributes['name'];
                $rules[$field_name] = $element->attributes['validation'];
            }
        }

        // Get the input values from the POST data
        $inputs = array();
        foreach ($rules as $field_name => $validation_rule) {
            $inputs[$field_name] = isset($_POST[$field_name]) ? $_POST[$field_name] : null;
        }

        // Create a new Validator instance and validate the inputs
        $validator = new Validator($rules, $inputs);
        $errors = $validator->validate();

        // If validation fails, throw the ValidationError with the errors
        if (!empty($errors)) {
            throw new Validation_Exception('Validation failed', $errors);
        }
    }

}
