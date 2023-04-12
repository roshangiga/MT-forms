# MT Forms

MT Forms is a developer-focused WordPress plugin that provides an easy-to-use form builder to speed-up development. 
You can quickly create forms programmatically in templates or shortcodes. You can specify default values, validation rules, and other attributes for each form element.
It is easy to extend & to create custom elements.

Taking inpiration from Gravity forms, MT Forms provides a lot of useful hooks such as before form render, after form render, before form process, after form validation, etc.

## Installation

1. Download the plugin ZIP file from the [MT Forms website](https://example.com/mt-forms).
2. Log in to your WordPress admin panel.
3. Navigate to Plugins → Add New.
4. Click the "Upload Plugin" button at the top of the screen.
5. Choose the ZIP file you downloaded in step 1.
6. Click the "Install Now" button.
7. After the plugin has been installed, click the "Activate Plugin" button.


## Features

MT Forms includes the following features:

- Support for a wide range of form elements, including text inputs, checkboxes, radio buttons, select boxes, and more.
- Customizable form settings, including form action, method, and enctype.
- Built-in form validation and error handling.
- Support for custom validation rules.
- Automatic nonce handling to prevent CSRF attacks.
- Support for adding custom CSS classes to form elements.
- Extensible architecture with support for custom form elements.

## Example Usage
```php
// Create a new form builder instance.
$form = new roshangiga\MT_Form_Builder();

$form_id = $form->get_form_id();

// Add the inputs field to the form.
try {

    $form->add_element('Input', array(
        'label'            => 'Email Address',
        'value'            => isset($_POST['email']) ? $_POST['email'] : '',
        'attributes'       => array(
            'name'        => 'email',
            'type'        => 'text',
            'class'       => 'input-field',
            'placeholder' => 'Enter your email address',
        ),
        'validation_rules' => 'Required|Email|MaxLength:60',
    ));

    $form->add_element('Checkbox', array(
        'label'            => 'Are you a human?',
        'value'            => '',
        'attributes'       => array(
            'name'  => 'check',
            'class' => 'input-field',
        ),
        'validation_rules' => 'Required',
    ));

} catch (\roshangiga\Element_Exception $e) {
    echo $e->getMessage();
}

try {
    $form->process_form();
    
} catch (\roshangiga\Validation_Exception $e) {
    echo $e->getMessage();
    print_r($e->get_errors());
}


// Render the form with a submit button.
$form->render_form(array('submit_button' => true));
```
## Built-in Validators
The validator used is based on my other [library](https://github.com/roshangiga/ValidatorPHP).

You can pipe multiple validators by separating them with a pipe (|) character. 

For example, to validate a field as _required_, _email address_ and _max length of 60_, you would use the following validation rule:
```Required|Email|MaxLength:60```. See demo code above for usage.


The following validators are included out of the box:

- Alphanumeric
- Required
- MinLength
- NIC
- Phone
- Email
- MinValue
- MaxLength
- URL
- Mobile
- Numeric
- Text
- MaxValue
- NumberBetween

Create your own validator classes by implementing the ValidationRule Interface. See the source code for examples of custom validators.

## Custom hooks
Developers can easily modify or extend the form rendering process by using any of the following action hooks:

### 1. In the render_form() method, you can use the action hooks with the form ID

* `mt_form_before_render`: This _action_ hook is called before rendering the form. You can use this hook to add custom content or perform actions before the form is displayed.
* `mt_form_before_elements`: This _action_ hook is called before rendering the form elements. You can use this hook to add custom content or perform actions before the form elements are displayed.
* `mt_form_after_elements`: This _action_ hook is called after rendering the form elements. You can use this hook to add custom content or perform actions after the form elements are displayed.
* `mt_form_after_render`: This _action_ hook is called after rendering the form. You can use this hook to add custom content or perform actions after the form is displayed.

### 2. In the process_form() method, you can use the action/filter hooks with the form ID
* `mt_form_before_process`: This _action_ hook is called after validation & before processing the form. You can use this hook to add custom content or perform actions before the form is processed.
* `mt_form_data`: This _filter_ hook is called after validation & before processing the form. You can use this hook to manipulate (add/edit/remove) validated form data.
* `mt_form_after_process`: This _action_ hook is called after validation & after processing the form. You can use this hook to add custom content or perform actions after the form is processed.

All action hooks and filters use the form ID in their names, allowing for more granular customization of the form rendering and processing for each form.
For example, if you have a form with an ID of 1, the hooks and filters will be:

* mt_form_before_render_1
* mt_form_before_elements_1
* mt_form_after_elements_1
* mt_form_after_render_1
* mt_form_before_process_1
* mt_form_data_1
* mt_form_after_process_1

## Contributing[README.md](..%2F..%2F..%2F..%2FMT-forms%2FREADME.md)

Contributions are welcome! If you find a bug or have a feature request, please create an issue or submit a pull request.

## License 

This project is licensed under the [MIT License](https://opensource.org/licenses/MIT). See the [LICENSE](LICENSE) file for details.
