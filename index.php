<!DOCTYPE html>
<html lang="en">
<head>
	<style>
	h1   {color: blue;}
	p    {border: 3px solid black;}
</style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assesment One</title>
</head>
<h1>Assesment One Brief</h1>
	<p>
	Develop a fully object-oriented web application.<br>
	The application should have:<br>
	A number of classes spanning several PHP files<br>
	A basic web form to collect some user input.<br>
	A method of passing data into your instantiated classes. This code does not need to be fully OO.<br>
	A selection of functions which accept user supplied data and use this to create a custom response.
	One or more functions to report the results of the query back to the user.
	</p>

<body>
	<form action='index.php' method='GET'>
		<fieldset>
			<legend>User Input Area</legend>
			<br>
			<br>
			<label>Stock Item: <input type='text' name='stockItem' />
			<label>Stock Code: <input type='text' name='stockCode' />
			<label>Stock Price: <input type='text' name='stockPrice' />
			<br>
			<br>
			<input type='submit' value='Submit Information' />
			<br>
			<br>
		</fieldset>
	</form>
</body>

</html>
<meta name="viewport" content="width=device-width, initial-scale=1.0"><style></style>
<?php
/*code adapted for errorhandler and validator classes on youtube - 
//https://www.youtube.com/watch?v=netHLn9TScY&t=6s
*/
require_once 'ErrorHandler.class.php';
require_once 'Validator.class.php';
require_once 'StockCheck.class.php';

$errorHandler = new ErrorHandler; //instantiate object for error checking of the input
/*
echo "<br><strong>Main printing errorHandler</strong>"; //debug assist
echo '<pre>', print_r(($errorHandler),'true'), '</pre>'; //debug assist 
*/

if(!empty($_GET)) //if superglobal is not empty, then execute
{ //start input validation
    $validator = new Validator($errorHandler);
/*
    echo " <br><strong>Main function _GET <u>not</u> empty printing validate object</strong>"; //debug assist 
    echo '<pre>', print_r(($validator),'true'), '</pre>'; //debug assist
*/
	$validation = $validator->check($_GET, [ 
    /*call the check method for the instantiated object, using superglobal array.
    instantiated items from the item check method will then use the item and associated rule*/
		'stockItem' => [  //pass main item array key
			'required' => true, //make it required for this array input object
			'maxlength' => 20, //maximum characters for this array object
			'minlength' => 1 //minimum characters for this array object
		],
		'stockCode' => [ //pass supplementary item
			'required' => false, //not required for this array object
			'maxlength' => 80, //criteria maximum characters for this array object
			'minlength' => 0 //minimum characters for this array object
		],
		'stockPrice' => [ //pass supplementary item
			'required' => false, //not required for this array object
			'maxlength' => 80, //maximum characters for this array object
			'minlength' => 0, //minimum characters for this array object
		]
	]);
/*
    echo "<br><strong>Main-printing validation</strong>"; //debug assist 
    echo '<pre>', print_r(($validation),'true'), '</pre>';//debug assist
*/
	//input validation pass/fail
	if ($validation->fails()) //runs if validation has failed
	{
		echo "<strong>Input Validation Fails</strong><br>"; //output the object errors array so user can see which rules failed
        echo '<pre><strong>', print_r(($validation->errors()->all()),'true'), '</strong></pre>';
	}
    else //not empty and input validation succeeded. Script objectives pass values back to user
    {
/*
        echo "<br>Main Printing _GET prior to object stockCheck<br>"; //debug assist 
        echo '<pre>', print_r(($_GET),'true'), '</pre>'; //debug assist 
*/

        $stockQuery = new StockCheck($_GET); 
        $stockQuery -> setStock("$_GET[stockItem]" , "$_GET[stockCode]" , "$_GET[stockPrice]"); 
/*		
		 echo '<pre>4', print_r(($stockQuery),'true') , '</pre>';  //debug assist. using numbers in output to help track where they come from.
*/
    }
}
?>