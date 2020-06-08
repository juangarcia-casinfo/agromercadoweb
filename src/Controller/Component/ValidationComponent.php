<?php
/*Cake PHP Custom Component for Casinfo
Author:		Juan Garcia
Date:		2019-03-25
Description:	This Component is used to create custom validation formats
File:			src/View/Helper/ValidationHelper.php
*/

namespace App\Controller\Component;

use Cake\Controller\Component;

class ValidationComponent extends Component
{
	/*
	Check if value comes from query string or post, returns blank if none have a value.
	*/
	public function validMethods($key = null, $usrdef = null)
	{
		$val = '';

		if($key!==null && $key!=="")
		{
			$tmpGetValue = $this->request->query($key);
			$tmpPostValue = $this->request->data($key);
			

			$usrdef = (isset($usrdef)==false)? $this->defaultEmpty: $usrdef;
			$tmpGetValue = (isset($tmpGetValue)==false)? $this->defaultEmpty: $tmpGetValue;
			$tmpPostValue = (isset($tmpPostValue)==false)? $this->defaultEmpty: $tmpPostValue;
			
			
			$val = (isset($tmpPostValue)==false || $tmpPostValue=="") ? $tmpGetValue: $tmpPostValue;
		}

		
		return $val;
	}	    
}
?>