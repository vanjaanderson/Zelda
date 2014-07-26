<?php
/**
 * A utility class to easy creating and handling of forms
 * 
 * @package ZeldaCore
 */
class CFormElement implements ArrayAccess {

  /**
   * Properties
   */
  public $attributes;
  public $characterEncoding;
  
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    $this->attributes = $attributes;    
    $this['name'] = $name;
    
    if(is_callable('CZelda::Instance()')) {
      $this->characterEncoding = CZelda::Instance()->config['character_encoding'];
    } else {
      $this->characterEncoding = 'UTF-8';
    }
  }

  /**
   * Implementing ArrayAccess for this->attributes
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->attributes[] = $value; } else { $this->attributes[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->attributes[$offset]); }
  public function offsetUnset($offset) { unset($this->attributes[$offset]); }
  public function offsetGet($offset) { return isset($this->attributes[$offset]) ? $this->attributes[$offset] : null; }
  
  /**
  * Create a formelement from an array, factory returns the correct type.
  *
  * @param string name of the element.
  * @param array attributes to use when creating the element.
  * @return the instance of the form element.
  */
  public static function Create($name, $attributes) {
    $types = array(
      'text'              => 'CFormElementText',
      'textarea'          => 'CFormElementTextArea',
      'password'          => 'CFormElementPassword',
      'hidden'            => 'CFormElementHidden',
      'checkbox'          => 'CFormElementCheckbox',
      'checkbox-multiple' => 'CFormElementCheckboxMultiple',
      'select'            => 'CFormElementSelect',
      'file'              => 'CFormElementFile',
      'search'            => 'CFormElementSearch',
      'submit'            => 'CFormElementSubmit',
    );

    $type = isset($attributes['type']) ? $attributes['type'] : null;

    if($type && isset($types[$type])) {
      return new $types[$type]($name, $attributes);
    } else {
      throw new Exception("Form element does not exists and can not be created: $name - $type");
    }
  }

  /**
  * Get HTML code for a element.
  *
  * @return HTML code for the element.
  */
  public function GetElementId() {
    return ($this['id'] = isset($this['id']) ? $this['id'] : 'form-element-' . $this['name']);
  }

  public function GetHTML() {
    $id = $this->GetElementId();
    $class = isset($this['class']) ? "{$this['class']}" : null;
    $validates = (isset($this['validation-pass']) && $this['validation-pass'] === false) ? ' validation-failed' : null;
    $class = (isset($class) || isset($validates)) ? " class='{$class}{$validates}'" : null;
    $name = " name='{$this['name']}'";
    $label = isset($this['label']) ? ($this['label'] . (isset($this['required']) && $this['required'] ? "<sup class='form-element-required'>*</sup>" : null)) : null;
    $autofocus = isset($this['autofocus']) && $this['autofocus'] ? " autofocus='autofocus'" : null;
    $required = isset($this['required']) && $this['required'] ? " required='required'" : null;
    $readonly = isset($this['readonly']) && $this['readonly'] ? " readonly='readonly'" : null;
    $placeholder = isset($this['placeholder']) && $this['placeholder'] ? " placeholder='{$this['placeholder']}'" : null;
    $checked = isset($this['checked']) && $this['checked'] ? " checked='checked'" : null;
    $type = isset($this['type']) ? " type='{$this['type']}'" : null;
    $description = isset($this['description']) ? $this['description'] : null;
    $onlyValue = isset($this['value']) ? htmlentities($this['value'], ENT_QUOTES, $this->characterEncoding) : null;
    $selectedValue = isset($this['value']) ? htmlentities($this['value'], ENT_QUOTES, $this->characterEncoding) : 'Plain';
    $value = isset($this['value']) ? " value='{$onlyValue}'" : null;

    $messages = null;
    if(isset($this['validation-messages'])) {
      $message = null;
      foreach($this['validation-messages'] as $val) {
        $message .= "<li>{$val}</li>\n";
      }
      $messages = "<ul class='validation-message'>\n{$message}</ul>\n";
    }
    
    if($type && $this['type'] == 'submit') {
        return "<input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$readonly} />\n";
    } else if($type && $this['type'] == 'textarea') {
        return "<p><label for='$id'>$label</label><textarea id='$id'{$type}{$class}{$name}{$autofocus}{$readonly}>{$onlyValue}</textarea></p>\n"; 
    } else if($type && $this['type'] == 'hidden') {
        return "<input id='$id'{$type}{$class}{$name}{$value} />\n";
    } else if($type && $this['type'] == 'select') {
        return "<p><label for='$id'>$label</label><select id='$id'{$type}{$class}{$name}{$value}>
          <option value=\"{$type}{$class}{$name}{$value} selected\">{$selectedValue}</option>
          <option value='plain'>Plain</option>
          <option value='htmlpurify'>HTML Purify</option>
          <option value='bbcode'>BB Code</option>
          <option value='make_clickable'>Make Clickable</option>
          <option value='markdownextra'>Markdown</option>
          <option value='smartypants'>Smarty Pants</option>
        </select></p>\n"; 
    } else {
      return "<p><label for='$id'>$label</label><input id='$id'{$type}{$class}{$name}{$value}{$autofocus}{$readonly} />{$messages}</p>\n";        
    }
  }


  /**
  * Validate the form element value according a ruleset.
  *
  * @param array $rules validation rules.
  * @param CForm $form the parent form.
  * returns boolean true if all rules pass, else false.
  */
  public function Validate($rules, $form) {
    $regExpEmailAddress = '/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';
    $tests = array(
      'fail'          => array('message' => 'Kommer alltid att misslyckas.', 'test'     => 'return false;'),
      'pass'          => array('message' => 'Kommer alltid att godkännas.', 'test'      => 'return true;'),
      'not_empty'     => array('message' => 'Får inte vara tomt.', 'test'               => 'return $value != "";'),
      'not_equal'     => array('message' => 'Inmatningen är felaktig.', 'test'          => 'return $value != $arg;'),
      'numeric'       => array('message' => 'Måste vara numeriskk.', 'test'             => 'return is_numeric($value);'),
      'email_adress'  => array('message' => 'Måste vara en e-postadress.', 'test'       => function($value) { return preg_match('/\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i', $value) === 1; } ),
      'match'         => array('message' => 'Inmatniongen matchar inte.', 'test'        => 'return $value == $form[$arg]["value"] ;'),
      'must_accept'   => array('message' => 'Du måste godkänna detta.', 'test'          => 'return $checked;'),
      'post_or_page'  => array('message' => 'Måste innehålla post eller page.', 'test'  => 'return $value != "";'),
      'custom_test'   => true,
    );

    $pass = true;
    $messages = array();
    $value = $this['value'];
    $checked = $this['checked'];

    foreach($rules as $key => $val) {
      $rule = is_numeric($key) ? $val : $key;
      if(!isset($tests[$rule])) throw new Exception("Validation of form element failed, no such validation rule exists: $rule");
      $arg = is_numeric($key) ? null : $val;

      $test = ($rule == 'custom_test') ? $arg : $tests[$rule];
      $status = null;
      if(is_callable($test['test'])) {
        $status = $test['test']($value);
      } else {
        $status = eval($test['test']);
      }

      if($status === false) {
        $messages[] = $test['message'];
        $pass = false;
      }
    }

    if(!empty($messages)) {
      $this['validation-messages'] = $messages;
    }
    return $pass;
  }
 
  /**
   * Use the element name as label if label is not set.
   */
  public function UseNameAsDefaultLabel() {
    if(!isset($this['label'])) {
      $this['label'] = ucfirst(strtolower(str_replace(array('-','_'), ' ', $this['name']))).':';
    }
  }

  /**
   * Use the element name as value if value is not set.
   */
  public function UseNameAsDefaultValue() {
    if(!isset($this['value'])) {
      $this['value'] = ucfirst(strtolower(str_replace(array('-','_'), ' ', $this['name'])));
    }
  }

  /**
  * Get the value of the form element.
  *
  * @return mixed the value of the form element.
  */
  public function GetValue() {
    return $this['value'];
  }

  /**
  * Get the value of the form element, if value is empty return null.
  *
  * @return mixed the value of the form element. Null if the value is empty.
  */
  public function GetValueNullIfEmpty() {
    return empty($this['value']) ? null : $this['value'];
  }
}
  
class CFormElementText extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'text';
    $this->UseNameAsDefaultLabel();
  }
}

class CFormElementTextarea extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'textarea';
    $this->UseNameAsDefaultLabel();
  }
}

class CFormElementFile extends CFormElement {
  /**
  * Constructor
  *
  * @param string name of the element.
  * @param array attributes to set to the element. Default is an empty array.
  */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'file';
    $this->UseNameAsDefaultLabel();
  }
}

class CFormElementHidden extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'hidden';
  }
}

class CFormElementPassword extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'password';
    $this->UseNameAsDefaultLabel();
  }
}

class CFormElementCheckbox extends CFormElement {
  /**
  * Constructor
  *
  * @param string name of the element.
  * @param array attributes to set to the element. Default is an empty array.
  */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'checkbox';
    $this['checked'] = isset($attributes['checked']) ? $attributes['checked'] : false;
    $this['value'] = isset($attributes['value']) ? $attributes['value'] : $name;
  }
}

class CFormElementCheckboxMultiple extends CFormElement {
  /**
  * Constructor
  *
  * @param string name of the element.
  * @param array attributes to set to the element. Default is an empty array.
  */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'checkbox-multiple';
  }
}

/* Select/option list*/
class CFormElementSelect extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'select';
    $this->UseNameAsDefaultLabel();
    //$this->UseNameAsDefaultValue();
  }
}

class CFormElementSearch extends CFormElement {
  /**
  * Constructor
  *
  * @param string name of the element.
  * @param array attributes to set to the element. Default is an empty array.
  */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'search';
  }
}

class CFormElementSubmit extends CFormElement {
  /**
   * Constructor
   *
   * @param string name of the element.
   * @param array attributes to set to the element. Default is an empty array.
   */
  public function __construct($name, $attributes=array()) {
    parent::__construct($name, $attributes);
    $this['type'] = 'submit';
    $this->UseNameAsDefaultValue();
  }
}

class CForm implements ArrayAccess {

  /**
   * Properties
   */
  public $form;     // array with settings for the form
  public $elements; // array with all form elements
  public $output;   // array with messages to display together with the form
  
  /**
   * Constructor
   */
  public function __construct($form=array(), $elements=array()) {
    $this->form = $form;
    if(!empty($elements)) {
      foreach($elements as $key => $element) {
        $this->elements[$key] = CFormElement::Create($key, $element);
      }
    }
    $this->output = array();
  }

  /**
   * Implementing ArrayAccess for this->elements
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->elements[] = $value; } else { $this->elements[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->elements[$offset]); }
  public function offsetUnset($offset) { unset($this->elements[$offset]); }
  public function offsetGet($offset) { return isset($this->elements[$offset]) ? $this->elements[$offset] : null; }

  /**
   * Add a form element
   *
   * @param $element CFormElement the formelement to add.
   * Returns $this CForm
   */
  public function AddElement($element) {
    $this[$element['name']] = $element;
    return $this;
  }

  /**
  * Remove an form element
  *
  * @param $name string the name of the element to remove from the form.
  * @return $this CForm
  */
  public function RemoveElement($name) {
    unset($this->elements[$name]);
    return $this;
  }

  /**
   * Set validation to a form element
   *
   * @param $element string the name of the formelement to add validation rules to.
   * @param $rules array of validation rules.
   * Returns $this CForm
   */
  public function SetValidation($element, $rules) {
    $this[$element]['validation'] = $rules;
    return $this;
  }

  /**
  * Add output to display to the user what happened whith the form.
  *
  * @param string $str the string to add as output.
  * @return $this CForm.
  */
  public function AddOutput($str) {
    if(isset($_SESSION['form-output'])) {
      $_SESSION['form-output'] .= " $str";
    }
    else {
      $_SESSION['form-output'] = $str;
   }
    return $this;
  }

  /**
  * Get value of a form element
  *
  * @param $element string the name of the formelement.
  * @return mixed the value of the element.
  */
  public function Value($element) {
    return $this[$element]['value'];
  }

  /**
  * Return HTML for the form or the formdefinition.
  *
  * @param $options array with options affecting the form output.
  * @return string with HTML for the form.
  */
  public function GetHTML($options=array()) {
    $defaults = array(
      'start' => false, // Only return the start of the form element
      'columns' => 1, // Layout all elements in one column
      'use_buttonbar' => true, // Layout consequtive buttons as one element wrapped in <p>
      'use_fieldset' => true, // Wrap form fields within <fieldset>
    );
    $options = array_merge($defaults, $options);

    $form = array_merge($this->form, $options);
    $id = isset($form['id']) ? " id='{$form['id']}'" : null;
    $class = isset($form['class']) ? " class='{$form['class']}'" : null;
    $name = isset($form['name']) ? " name='{$form['name']}'" : null;
    $action = isset($form['action']) ? " action='{$form['action']}'" : null;
    $method = isset($form['method']) ? " method='{$form['method']}'" : " method='post'";
    $enctype = isset($form['enctype']) ? " enctype='{$form['enctype']}'" : null;

    if($options['start']) {
      return "<form{$id}{$class}{$name}{$action}{$method}{$enctype}>\n";
    }
    
    $fieldsetStart = '<fieldset>';
    $fieldsetEnd = '</fieldset>';
    if(!$options['use_fieldset']) {
      $fieldsetStart = $fieldsetEnd = null;
    }
    
    $elementsArray = $this->GetHTMLForElements($options);
    $elements = $this->GetHTMLLayoutForElements($elementsArray, $options);
    $output = $this->GetOutput();
    $html = <<< EOD
\n<form{$id}{$class}{$name}{$action}{$method}{$enctype}>
{$fieldsetStart}
{$elements}
{$output}
{$fieldsetEnd}
</form>\n
EOD;
    return $html;
  }

  /**
  * Return HTML for the elements
  *
  * @param $options array with options affecting the form output.
  * @return array with HTML for the formelements.
  */
  public function GetHTMLForElements($options=array()) {
    $defaults = array(
      'use_buttonbar' => true,
    );
    $options = array_merge($defaults, $options);

    $elements = array();
    reset($this->elements);
    while(list($key, $element) = each($this->elements)) {
      
      // Create a buttonbar?
      if($element['type'] == 'submit' && $options['use_buttonbar']) {
        $name = 'buttonbar';
        $html = "<p class='buttonbar'>\n" . $element->GetHTML() . '&nbsp;';
        // Get all following submits (and buttons)
        while(list($key, $element) = each($this->elements)) {
          if($element['type'] == 'submit') {
            $html .= $element->GetHTML();
          } else {
            prev($this->elements);
            break;
          }
        }
        $html .= "\n</p>";
      }

      // Just add the element
      else {
        $name = $element['name'];
        $html = $element->GetHTML();
      }

      $elements[] = array('name'=>$name, 'html'=> $html);
    }

    return $elements;
  }
  
  /**
  * Place the elements according to a layout and return the HTML
  *
  * @param array $elements as returned from GetHTMLForElements().
  * @param array $options with options affecting the layout.
  * @return array with HTML for the formelements.
  */
  public function GetHTMLLayoutForElements($elements, $options=array()) {
    $defaults = array(
      'columns' => 1,
      'wrap_at_element' => false, // Wraps column in equal size or at the set number of elements
    );
    $options = array_merge($defaults, $options);

    $html = null;
    if($options['columns'] === 1) {
      foreach($elements as $element) {
        $html .= $element['html'];
      }
    }
    else if($options['columns'] === 2) {
      $buttonbar = null;
      $col1 = null;
      $col2 = null;
      
      $e = end($elements);
      if($e['name'] == 'buttonbar') {
        $e = array_pop($elements);
        $buttonbar = "<div class='cform-buttonbar'>\n{$e['html']}</div>\n";
      }

      $size = count($elements);
      $wrapAt = $options['wrap_at_element'] ? $options['wrap_at_element'] : round($size/2);
      for($i=0; $i<$size; $i++) {
        if($i < $wrapAt) {
          $col1 .= $elements[$i]['html'];
        } else {
          $col2 .= $elements[$i]['html'];
        }
      }

      $html = "<div class='cform-columns-2'>\n<div class='cform-column-1'>\n{$col1}\n</div>\n<div class='cform-column-2'>\n{$col2}\n</div>\n{$buttonbar}</div>\n";
    }

    return $html;
  }
  
  /**
  * Get an array with all elements that failed validation together with their id and validation message.
  *
  * @return array with elements that failed validation.
  */
  public function GetValidationErrors() {
    $errors = array();
    foreach($this->elements as $name => $element) {
      if($element['validation-pass'] === false) {
        $errors[$name] = array('id' => $element->GetElementId(), 'label' => $element['label'], 'message' => implode(' ', $element['validation-messages']));
      }
    }
    return $errors;
  }

  /**
  * Get output messages as <output>.
  *
  * @return string/null with the complete <output> element or null if no output.
  */
  public function GetOutput() {
    if(!empty($this->output)) {
      return "<output>{$this->output}</output>";
    }
    return null;
  }

  /**
  * Init all element with values from session, clear all and fill in with values from the session.
  *
  */
  protected function InitElements($values) {
    // First clear all
    foreach($this->elements as $key => $val) {
      // Do not reset value for buttons
      if($this[$key]['type'] == 'submit') {
        continue;
      }

      // Reset the value
      $this[$key]['value'] = null;

      // Checkboxes must be cleared
      if(isset($this[$key]['checked'])) {
        $this[$key]['checked'] = false;
      }
    }

    // Now build up all values from $values (session)
    foreach($values as $key => $val) {

      // Take care of arrays as values (multiple-checkbox)
      if(isset($val['values'])) {
        $this[$key]['checked'] = $val['values'];
      } else {
        $this[$key]['value'] = $val['value'];
      }

      // Is this a checkbox?
      if($this[$key]['type'] === 'checkbox') {
        $this[$key]['checked'] = true;
      }

      // Keep track on validation messages if set
      if(isset($val['validation-messages'])) {
        $this[$key]['validation-messages'] = $val['validation-messages'];
        $this[$key]['validation-pass'] = false;
      }
    }
  }

  /**
  * Check if a form was submitted and perform validation and call callbacks.
  * The form is stored in the session if validation or callback fails. The page should then be redirected
  * to the original form page, the form will populate from the session and should be rendered again.
  * Form elements may remember their value if 'remember' is set and true.
  *
  * @return mixed, $callbackStatus if submitted&validates, false if not validate, null if not submitted.
  * If submitted the callback function will return the actual value which should be true or false.
  */
  public function Check() {
    $remember = null;
    $validates = null;
    $callbackStatus = null;
    $values = array();
    
    // Remember output messages in session
    if(isset($_SESSION['form-output'])) {
      $this->output = $_SESSION['form-output'];
      unset($_SESSION['form-output']);
    }

    $request = null;
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $request = $_POST;
      unset($_SESSION['form-failed']);
      $validates = true;

      foreach($this->elements as $element) {

        // The form element has a value set
        if(isset($request[$element['name']])) {

          // Multiple choices comes in the form of an array
          if(is_array($request[$element['name']])) {
            $values[$element['name']]['values'] = $element['checked'] = $request[$element['name']];
          } else {
            $values[$element['name']]['value'] = $element['value'] = $request[$element['name']];
          }

          // If the element is a checkbox, set its value of checked.
          if($element['type'] === 'checkbox') {
            $element['checked'] = true;
          }

          if(isset($element['validation'])) {
            $element['validation-pass'] = $element->Validate($element['validation'], $this);
            if($element['validation-pass'] === false) {
              $values[$element['name']] = array('value'=>$element['value'], 'validation-messages'=>$element['validation-messages']);
              $validates = false;
            }
          }

          // Hmmm.... Why did I need this remember thing?
          if(isset($element['remember']) && $element['remember']) {
            $values[$element['name']] = array('value'=>$element['value']);
            $remember = true;
          }

          // Carry out the callback if the form validates
          if(isset($element['callback']) && $validates) {
            if(isset($element['callback-args'])) {
              $callbackStatus = call_user_func_array($element['callback'], array_merge(array($this), $element['callback-args']));
            } else {
              $callbackStatus = call_user_func($element['callback'], $this);
            }
          }
        }

        // The form element has no value set
        else {

          // Set element to null, then we know it was not set.
          $element['value'] = null;

          // If the element is a checkbox, clear its value of checked.
          if($element['type'] === 'checkbox' || $element['type'] === 'checkbox-multiple') {
            $element['checked'] = false;
          }

          // Do validation even when the form element is not set? Duplicate code, revise this section and move outside this if-statement?
          if(isset($element['validation'])) {
            $element['validation-pass'] = $element->Validate($element['validation'], $this);
            if($element['validation-pass'] === false) {
              $values[$element['name']] = array('value'=>$element['value'], 'validation-messages'=>$element['validation-messages']);
              $validates = false;
            }
          }
        }
      }
    }

    // Read form data from session if the previous post failed during validation.
    elseif(isset($_SESSION['form-failed'])) {
      $this->InitElements($_SESSION['form-failed']);
      unset($_SESSION['form-failed']);
    }

    // Read form data from session if some form elements should be remembered
    elseif(isset($_SESSION['form-remember'])) {
      foreach($_SESSION['form-remember'] as $key => $val) {
        $this[$key]['value'] = $val['value'];
      }
      unset($_SESSION['form-remember']);
    }

    // Read form data from session,
    // useful during test where the original form is displayed with its posted values
    elseif(isset($_SESSION['form-save'])) {
      $this->InitElements($_SESSION['form-save']);
      unset($_SESSION['form-save']);
    }
    
    
    // Prepare if data should be stored in the session during redirects
    // Did form validation or the callback fail?
    if($validates === false || $callbackStatus === false) {
      $_SESSION['form-failed'] = $values;
    }

    // Hmmm, why do I want to use this
    elseif($remember) {
      $_SESSION['form-remember'] = $values;
    }
    
    // Remember all posted values
    if(isset($this->saveInSession) && $this->saveInSession) {
      $_SESSION['form-save'] = $values;
    }

    return ($validates) ? $callbackStatus : $validates;
  }  
}

?>