<?php
//Class to instantiate  stock entered by user
class StockCheck 
{
private $stockItem;
private $stockCode;
private $stockPrice;
//	public $stockItems = array(); //array to check against for return of item values
	public function __construct($stock)
	{
/*
		echo "<br><strong><i>Class stockCheck output for construct method</i></strong><br>";//debug assist
		echo '<pre>2', print_r($stock,'true'), '</pre>';  //debug assist
		echo '<pre>3', print_r(array_keys($stock),'true') , '</pre>';  //debug assist
*/
		echo "<br>The stock item to check for is : $stock[stockItem] <br>"; 
		echo "<br>The stock code to check for is : $stock[stockCode] <br>"; 
		echo "<br>The stock item to check for is : $stock[stockPrice] <br>"; 
	}
	public function setStock($item,$code,$price)
	{
		$this -> stockItem = $item;
		$this -> stockCode = $code;
		$this -> stockPrice = $price;
	}
	public function getStock(){
		return $this -> stockItem;
		return $this -> stockCode;
		return $this -> stockPrice;
	}
}
?>