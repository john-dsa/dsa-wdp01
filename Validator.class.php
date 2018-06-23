<?php
//Class to confirm the input conforms to certain rules.
//Reference - https://www.youtube.com/watch?v=DRWwDB6bU9o&t=14s
class Validator
{
	private $errorHandler; //declare variable for errors
	private $rules = ['required','minlength','maxlength']; //array for rules against which to check.
	public $messages = [
		'required' => 'The :field field is required', //replacing the : field value with string replacement in the function validate
		'minlength' => 'The :field field minimum requirement of :satisfier',
		'maxlength' => 'The :field field maximum requirement of :satisfier'
	]; //associative array for passing messages. may decide to override them with custom messsages hence public.

	public function __construct(ErrorHandler $errorHandler){ //dependancy injection for Errorhandler class
		$this->errorHandler = $errorHandler; //assign class variable by parameter passed
		//echo "<br><strong><i>printing from validator contruct</i></strong><br>"; //debug assist
	}
	public function check($items, $rules){ //items from get superglobal passed 
		foreach ($items as $item => $value)  //loop through all the superglobal items. grab key, and the value in it.
		{
/*
			echo "<br><i><b>Printing from validating class foreach loop</b><br>"; //debug assist
			echo '<pre>', print_r(($items),'true'), '</pre>'; //debug assist
			echo "item value $item=>$value <br></i>"  ; //debug assist
*/
			if (in_array($item, array_keys($rules))) //loop through the superglobal items rules.
			{
				$this->validate  //call function to verify for each of
				([
					'field' => $item, //used by : field to be replaced below in the function validate
					'value' => $value, //used by : value replaced below in the function validate
					'rules' => $rules[$item] // this array will trigger the user_func_array for our arrays $rules and $messages
				]);
			}
		}
		unset($value); //reset value
		return $this;
	}

	public function fails() {
		return $this->errorHandler->hasErrors(); //error parser method returns a boolean, hence this also returns a boolean.
	}
	public function errors() {
		return $this->errorHandler;
	}
	private function validate($item) {
		$field = $item['field'];
		foreach ($item['rules'] as $rule => $satisfier) //the rule parameters ie. minimum,maximum
		{
			if (in_array($rule, $this->rules)) //check if rule is in set of rules allowed.
			{
				if (!call_user_func_array([$this, $rule],[$field, $item['value'],$satisfier])) //check for the return value --- used in place of switch pairs for each one of the items.
				{
						$this->errorHandler->addError(
						str_replace([':field', ':satisfier'], [$field,$satisfier], $this->messages[$rule]), // replace the :field and :satisfier with their values inside the looped array.
						$field);
				}
			}
		}
	}
	private function required($field, $value, $satisfier)
	{
		return !empty($value); //return value if non-empty, remove whitespace from value.
	}
	private function minlength($field, $value, $satisfier)
	{
		return strlen($value) >= $satisfier;
	}
	private function maxlength($field, $value, $satisfier)
	{
		return strlen($value) <= $satisfier;
	}
}
?>