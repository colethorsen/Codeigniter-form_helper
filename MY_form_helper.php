<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();

// ------------------------------------------------------------------------

/**
 * Form Helpers Extension
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Cole Thorsen
 * @copyright	2014 Impulse Studios
 */

// ------------------------------------------------------------------------

/**
 * Form Declaration
 *
 * Creates the opening portion of the form.
 *
 * @param	string	the URI segments of the form destination
 * @param	mixed	an array or object to populate the form fields.
 * @param	array	a key/value pair of attributes
 * @param	array	a key/value pair hidden data
 * @return	string
 */
function f_open($action = '', $populate = '', $attributes = '', $hidden = array())
{
	//save populate values into the CI super object for use with the input helpers.
	$CI =& get_instance();
	$CI->_populate = (array) $populate;
	
	$CI->_tabindex = 1;
	
	return form_open($action, $attributes, $hidden);
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating an text field
 *
 * Uses the name provided to generate the text input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
function f_text($name, $req = '', $data = NULL) 
{
	return f_input('text', $name, $req, $data); 
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating an hidden field
 *
 * Uses the name provided to generate the hidden input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
function f_hidden($name, $req = '', $data = NULL) 
{
	f_disable_labels();
	
	$return = f_input('hidden', $name, $req, $data); 
	
	f_enable_labels();
	
	return $return;
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating an tel field
 *
 * Uses the name provided to generate the tel input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
function f_tel($name, $req = '', $data = NULL) 
{
	return f_input('tel', $name, $req, $data); 
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating an email field
 *
 * Uses the name provided to generate the tel email field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
function f_email($name, $req = '', $data = NULL) 
{
	return f_input('email', $name, $req, $data); 
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating an url field
 *
 * Uses the name provided to generate the url input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
function f_url($name, $req = '', $data = NULL) 
{
	return f_input('url', $name, $req, $data); 
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating an number field
 *
 * Uses the name provided to generate the url input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
function f_number($name, $req = '', $data = NULL) 
{
	return f_input('number', $name, $req, $data);
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating an upload field
 *
 * Uses the name provided to generate the url input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */

function f_file($name, $req = '', $data = NULL)
{
	return f_input('file', $name, $req, $data);
}


// ------------------------------------------------------------------------

/**
 * Simplify the process of creating an input field
 *
 * Uses the name provided to generate the input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @param	string
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
function f_input($type = 'text', $name, $req = '', $data = NULL) 
{	
	$return = f_build_label($name, $req);
	
	$values = array(
			'type'	=> $type,
			'name'	=> $name,
			'id'	=> 'input_' . $name
		);

	//we can only ever call _populate once if we want array iteration to work.
	if(!isset($data['value'])) :

		$values['value'] = _populate($name);

	endif;
	
	//if there was an error with this field, add class of .error
	if(form_error($name)) :
		
		$values['class'] = 'error';
	
	endif;	
		
	//set required.
	if(!empty($req)) :
		$values['required'] = '';
	endif;
	
	$return .= "<input " . _parse_form_attributes($data, $values) . ">";
	
	return $return;
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating an password field
 *
 * Uses the name provided to generate the input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name. The password field is different from the above as it will 
 * never re-populate.
 *
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
function f_password($name, $req = '', $data = NULL) 
{
	$return = f_build_label($name, $req);

	$values = array(
			'type'	=> 'password',
			'name'	=> $name,
			'id'	=> 'input_' . $name
		);
	
	//if there was an error with this field, add class of .error
	if(form_error($name)) :
		
		$values['class'] = 'error';
	
	endif;
	
	//set required.
	if(!empty($req)) :
		$values['required'] = '';
	endif;
	
	$return .= "<input " . _parse_form_attributes($data, $values) . ">";
	
	return $return;
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating a textarea
 *
 * Uses the name provided to generate the textarea, id, and label.
 * If there is a corresponding lang file entry to the textarea name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
function f_textarea($name, $req = '', $data = array()) 
{
	$return = f_build_label($name, $req);
	
	$values = array(
			'name'	=> $name,
			'id'	=> 'input_' . $name,
			'value'	=> _populate($name)
		);
	
	//if there was an error with this field, add class of .error
	if(form_error($name)) :
		
		$values['class'] = 'error';
	
	endif;
	
	$values = array_merge($values, $data);
	
	$return .= form_textarea($values);
	
	return $return;
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating a dropdown
 *
 * Uses the name provided to generate the dropdown, id, and label.
 * If there is a corresponding lang file entry to the dropdown name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @param	string
 * @param   array
 * @param	string
 * @param	array
 * @return	string
 */
function f_dropdown($name, $items = array(), $req = '', $data = array(), $extra = '') 
{
	if(isset($data['value'])) :
		$selected = $data['value'];

		//required for parse_form_attributes to work correctly.
		unset($data['value']);
	else :

		$selected = _populate($name);

	endif;

	$return = f_build_label($name, $req);
	
	$values = array(
			'id'	=> 'input_' . $name
		);
		
	$extra .= _parse_form_attributes($data, $values);
	
	$return .= form_dropdown($name, $items, $selected, $extra);
	
	return $return;
}

function f_multiselect($name, $items = array(), $req = '', $data = array(), $extra = '')
{
	if ( ! strpos($extra, 'multiple')) :
	
		$extra .= 'multiple="multiple" ';
	
	endif;
	
	//required for parse_form_attributes to work correctly.
	unset($data['value']);
	
	$return = f_build_label($name, $req);
	
	$values = array(
			'id'	=> 'input_' . $name
		);
		
	$extra .= _parse_form_attributes($data, $values);
	
	$return .= form_dropdown($name . '[]', $items, $selected, $extra);
	
	return $return;
}

// ------------------------------------------------------------------------

/**
 * Form Checkbox
 *
 * @param	string
 * @param	string
 * @param	string
 * @param	bool
 * @param	array
 * @return	string
 */
function f_checkbox($name, $value = '1', $checked = FALSE, $data = NULL)
{
	$values = array(
			'type'	=> 'checkbox',
			'name'	=> $name,
			'id'	=> 'input_' . $name,
			'value'	=> $value
		);

  /*  if (_populate($name) || (empty($_POST) && $checked !== FALSE)) :
		
		yell('in here');
		
		$values['checked'] = '';
		
	endif;	
	*/
	
	$return = "<input " . _parse_form_attributes($data, $values) . _populate_checkbox($name, $value, $checked) . ">";
	
	$return .= f_build_label($name, '');
	
	return $return;
}

// ------------------------------------------------------------------------

/**
 * Form Radio Button
 *
 * @param	string
 * @param	string
 * @param	string
 * @param	bool
 * @param	array
 * @return	string
 */
function f_radio($name, $value, $req = '', $checked = FALSE, $data = NULL)
{
	$values = array(
			'type'	=> 'radio',
			'name'	=> $name,
			'id'	=> 'input_' . $name . '_' . $value,
			'value'	=> $value
		);

	if (_populate($name) === $value || (empty($_POST) && $checked !== FALSE)) :
		
		$values['checked'] = '';
		
	endif;	
	
	$return = "<input " . _parse_form_attributes($data, $values) . ">";
	
	$return .= f_build_label($name . '_' . $value, $req);
	
	return $return;

}

// ------------------------------------------------------------------------

/**
 * Submit Button
 *
 * @param	string
 * @param	array
 * @return	string
 */
function f_submit($name, $data = NULL) 
{
	//set the default class to btn if no class is provided.
	if(!isset($data['class'])) :
		
		$data['class'] = 'btn';
	
	endif;
	
	$values = array(
			'type'	=> 'submit',
			'name'	=> $name,
			'id'	=> 'input_' . $name,
			'value'	=> lang('input_' . $name) ? lang('input_' . $name) : humanize($name)
		);
	
	return "<input " . _parse_form_attributes($data, $values) . ">";
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating a date and time input
 *
 * Uses the name provided to generate the input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
 
function f_datetime($name, $req = '', $data = NULL) 
{
	//grab value to repopulate out of the array.
	$CI =& get_instance();
	
	//we can only ever call _populate once if we want array iteration to work.
	$data['value'] = _populate($name);

	//date
	$date = f_date($name, $req, $data);

	//get time before date messes up the population value.
	f_disable_labels();

	$time = f_time($name, $req, $data);
	
	f_enable_labels();
	
	return $date . $time;
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating a date input
 *
 * Uses the name provided to generate the input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
 
function f_date($name, $req = '', $data = NULL) 
{	
	//grab value to repopulate out of the array.
	$CI =& get_instance();


	//if there was a value sent from f_datetime
	//we can only ever call _populate once if we want array iteration to work.
	if(!isset($data['value'])) :

		$data['value'] = _populate($name);

	endif;

	if(!empty($data['value'])) :

		$data['value'] = strtotime($data['value']);
		$data['value'] = date('M j, Y', $data['value']);
	
	else :

		//set to current date.
		$data['value'] = date('M j, Y');

	endif;

	$data['class'] = 'date';
	
	//date
	$return = f_text($name, $req, $data);
	
	return $return;
}

// ------------------------------------------------------------------------

/**
 * Simplify the process of creating a time input
 *
 * Uses the name provided to generate the input field, id, and label.
 * If there is a corresponding lang file entry to the input name you
 * created it will use that instead of humanizing the provided field
 * name.
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	array
 * @return	string
 */
 
function f_time($name, $req = '', $data = NULL) 
{
	//show on a 5 min interval.
	$interval = 5;
	
	//grab value to repopulate out of the array.
	$CI =& get_instance();
	
	//see if this is array, if it is we have some work to do.
	if(substr($name, -2, 2) == '[]') :
	
		$remove = (substr($name, -3, 3) == '][]') ? -3 : -2;
		
		$start = substr($name, 0, $remove);
	
		$end = ($remove == -3) ? '][]' : '[]';
	
	else :
	
		$start = $name;
		$end = '';
	
	endif;

	$name_hour = $start . '_hour' . $end;
	$name_minute = $start . '_minute' . $end;
	
	//if there was a value sent from f_datetime
	//we can only ever call _populate once if we want array iteration to work.
	if(!isset($data['value'])) :

		$data['value'] = _populate($name);

	endif;

	if(!empty($data['value'])) :

		$data['value'] = strtotime($data['value']);

		$hour	= date('H', $data['value']);
		$minute	= date('i', $data['value']);

	else :

		$hour	= date('H');
		$minute	= date('i') - fmod(date('i'), $interval);
		$minute	= sprintf('%02d', $minute);

	endif;
	
	
	$return = f_build_label($name, $req);
	
	f_disable_labels();

	//hours    
	$i = 0;
	$options = array();
	while($i <= 23) :
		$i = sprintf('%02d', $i);
	
		$options[$i] = $i;
		$i++;
	endwhile;
	
	$return .= f_dropdown($name_hour, $options, $req, array('value' => $hour)) . ' : '; 

	//minutes		
	$i = 0;
	$options = array();
	while($i <= 59) :
		$i = sprintf('%02d', $i);

		$options[$i] = $i;
		$i = $i + $interval;
	endwhile;			
	
	$return .= f_dropdown($name_minute, $options, $req, array('value' => $minute));
	
	f_enable_labels();
	
	return $return;
}

// ------------------------------------------------------------------------

/**
 * Disable Labels
 *
 * If you need to disable labels for some reason while using
 * the form helper this will do so. To be used in conjunction
 * with f_enable_labels()
 *
 */
function f_disable_labels() 
{
	$CI =& get_instance();
	
	$CI->_disable_labels = true;
}

// ------------------------------------------------------------------------

/**
 * Enable Labels
 *
 * If you need to enable labels after they have been disabled
 * this will enable them. To be used in conjunction
 * with f_enable_labels()
 *
 */
function f_enable_labels() 
{
	$CI =& get_instance();
	
	$CI->_disable_labels = false;
}

// ------------------------------------------------------------------------

/**
 * Humanize
 *
 * Takes multiple words separated by underscores, or square
 * brackets and changes them to spaces
 *
 */

function humanize($str)
{
	return ucwords(preg_replace('/[[,\],_]+/', ' ', strtolower(trim($str))));
}

// ------------------------------------------------------------------------

/**
 * f_repeat
 *
 * Allows for instances where a group of inputs is required
 * to be repeated an unknown number of times based on the
 * number of entries into the system.
 *
 */

function f_repeat($name, $min = 0)
{	
	$CI =& get_instance();
	
	if(!isset($CI->_f_repeat[$name])) :
	
		$CI->_f_repeat[$name]['count'] = 0;
	
		//determines how many times to repeat based on the post data or the refill data as necessary.
		if(!empty($_POST)) :
		
			$fields = $CI->form_validation->field_data();
	
			$CI->_f_repeat[$name]['total'] = count($fields[$name]['postdata']);
		
		elseif(_return_value($name) != false) :
			
			$CI->_f_repeat[$name]['total'] = count(_return_value($name));
			
		else :
			
			$CI->_f_repeat[$name]['total'] = 0;
				
		endif;
	
	endif;
	
	$CI->_f_repeat[$name]['count']++;

	//checks to see if we have reached the number of times to repeat based on the fields provided and the minimum entered.
	if(($CI->_f_repeat[$name]['count'] > $CI->_f_repeat[$name]['total']) && ($CI->_f_repeat[$name]['count'] > $min)) :
	
		return false;
	
	else :
	
		return true;
	
	endif;
	
}

// ------------------------------------------------------------------------

/**
 * f_last_value
 *
 * Returns the value from the last item sent.
 *
 */

function f_last_value()
{
	$CI =& get_instance();

	return $CI->_f_last_value;
}

// ------------------------------------------------------------------------

function f_build_label($name, $req = '')
{	
	$CI =& get_instance();

	//add the ability to turn off labels
	if (!isset($CI->_disable_labels) || $CI->_disable_labels === false) :
	
		//build label
		$label = lang('input_' . $name) ? lang('input_' . $name) : humanize($name);
		$label .= !empty($req) ? ' <span class="req">' . $req . '</span>' : '';
	
		$values = array();
	
		//if there was an error with this field, add class of .error
		if($error = form_error($name)) :
			
			$values['class'] = 'error';
			
			$label .= '<span class="error-msg">' . $error . '</span>';
			
		endif;
	
		$name = 'input_' . $name;
	
		return form_label($label, $name, $values);
		
	endif;
}

/**
 * Private Functions
 *
 * These are private functions that are used by the above
 *
 */


function _parse_form_attributes($attributes, $default)
{
	if (is_array($attributes))
	{
		foreach ($default as $key => $val)
		{
			if (isset($attributes[$key]))
			{
				$default[$key] = $attributes[$key];
				unset($attributes[$key]);
			}
		}

		if (count($attributes) > 0)
		{
			$default = array_merge($default, $attributes);
		}
	}

	$att = '';

	foreach ($default as $key => $val)
	{
		if ($key == 'value')
		{
			$val = form_prep($val, $default['name']);
		}

		$att .= $key; 
		
		$att .= (!empty($val)) ? ('="' . $val . '" ') : ' ';
	}

	return $att;
}

function _populate($name)
{
	$CI =& get_instance();
	
	//check for existing value parsing.
	if(!isset($CI->_populate[$name])) :
	
		_return_value($name);
	
	endif;
	
	$value = $CI->_populate[$name];

	// If the data is an array output them one at a time.
	//     E.g: form_input('name[]', set_value('name[]');
	if (is_array($CI->_populate[$name])) :
	
		$value = array_shift($CI->_populate[$name]);
	
	endif;
	
	$CI->_f_last_value = set_value($name, $value);
	
	return $CI->_f_last_value;
}

function _populate_checkbox($name, $value, $default)
{	
	$populate = true;
	
	$field = _return_value($name);

	//allow the default if there is no data.
	if($default === true && ! $field) {
	
		$populate = true;
	}
	else if (is_array($field))
	{
		if ( ! in_array($value, $field))
		{
			$populate = false;
		}
	}
	else
	{
		if (($field == '' OR $value == '') OR ($field != $value))
		{
			$populate = false;
		}
	}
	
	return set_checkbox($name, $value, $populate);
}


function _return_value($name)
{
	$CI =& get_instance();

	// this part is actually based on something out of the CI form validation lib
	// Is the field name an array?  We test for the existence of a bracket "[" in
	// the field name to determine this.  If it is an array, we break it apart
	// into its components so that we can fetch the corresponding data later
	if (strpos($name, '[') !== FALSE AND preg_match_all('/\[(.*?)\]/', $name, $matches)) :
	
		// Note: Due to a bug in current() that affects some versions
		// of PHP we can not pass function call directly into it
		$x = explode('[', $name);
		$indexes[] = current($x);

		for ($i = 0; $i < count($matches['0']); $i++)
		{
			if ($matches['1'][$i] != '')
			{
				$indexes[] = $matches['1'][$i];
			}
		}

		$value = $CI->_populate;

		foreach($indexes as $index) :
			
			if(isset($value[$index])) :
			
				$value = $value[$index];
		
			else :
				$value = '';
				break;
			endif;
		
		endforeach;
		
	else :
	
		$value = isset($CI->_populate[$name]) ? $CI->_populate[$name] : false;
	
	endif;
	
	$CI->_populate[$name] = $value;
	
	return $value;
}

/* End of file MY_form_helper.php */
/* Location: ./application/helpers/MY_form_helper.php */
