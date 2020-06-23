/**********************************************************************
Author:			Juan Garcia
Date Created:		2020-06-22
Last Modified:		2020-06-22
Description:		Form Validation JS functions
**********************************************************************/

//General form validator and serializer.
function formValidator(rcvFormObj)
{
	var frmObj;
	var jsonData = '';

	if(rcvFormObj)
	{
		frmObj = document.forms[rcvFormObj.name];
		
		try
		{
			//Validating the fields
			console.log(frmObj.length);
			
			for(fi=0;fi<frmObj.length;fi++)
			{
				console.log(frmObj.elements[fi].id);
			}
			
			jsonData = $(frmObj).serializeArray();
			jsonData = JSON.stringify(jsonData);
			
			console.log("Form data to be sent: vvv");
			console.log(jsonData);
			
			sendData(jsonData);			
		}
		catch(e)
		{
			console.log(e);
			return false;
		}
	}
	
	return false;
}


//Field validator function
function fieldValidator(rcvFldData, rcvType)
{
	
}


//Sends the data to the proxy controller
function sendData(rcvDataStr)
{
	var translateData = rcvDataStr.replace(new RegExp(/\|+\|+DBLQT+\|+\|/, 'g'), '"');
	console.log(translateData);
	
	$('#request_data').val(translateData);
	$('#btn_send_data').click();
}