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
	var frmArr 		= {};
	var jsonData 		= '';
	var errMsg 		= [];
	var errCt 		= 0;
	var modalHtml 	= "";


	if(rcvFormObj)
	{
		frmObj = document.forms[rcvFormObj.name];

		try
		{
			//Validating the fields
			for(fi=0;fi<frmObj.length;fi++)
			{
				//console.log(frmObj.elements[fi].id);
				//console.log($('#'+frmObj.elements[fi].id).attr('class'));


				//console.log(frmObj.elements[fi].id);
				frmArr[frmObj.elements[fi].id] = frmObj.elements[fi].value; // this converts the KV pairs to a dict of keys and values

				//Processing fields for validation
				if($('#'+frmObj.elements[fi].id).attr('class')!=undefined)
				{
					var classList = $('#'+frmObj.elements[fi].id).attr('class').split(/\s+/);
					var tmpErrMsg = "";

					//Processing the classes
					for(vic=0;vic<classList.length;vic++)
					{
						//console.log('Processing Class: '+ classList[vic]);
						tmpErrMsg = fieldValidator(frmObj.elements[fi].value, classList[vic]);


						if(tmpErrMsg[0]=="1")
						{
							errMsg[frmObj.elements[fi].id] = tmpErrMsg[1];
							errCt++;
						}
					}
				}
			}

			//Processing the results of the validations
			if(errCt==0)
			{
				//Serialize the ansower in json format to be sent
				//jsonData = $(frmObj).serializeArray();
				jsonData = JSON.stringify(frmArr);  // thgis converts the dict object into JSON string

				console.log("Form data to be sent: vvv");
				console.log(frmArr);
				console.log(jsonData);

				sendData(jsonData);
			}
			else
			{
				//Shows the errors on the form
				console.log(errMsg);

				//Modal HTML data
				modalHtml = modalHtml + '<div id="dialog-message" title="Form Error Messages">';

				for(var tmpErrMsg in errMsg)
				{
					modalHtml = modalHtml + '<p>';
					modalHtml = modalHtml + '<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>';
					modalHtml = modalHtml + tmpErrMsg + ': ' + errMsg[tmpErrMsg];
					modalHtml = modalHtml + '</p>';
				}

				modalHtml = modalHtml + '</div>';

				$('#modal-container').html(modalHtml);

				$( "#dialog-message" ).dialog(
				{
				      modal: true,
				      height: 400,
				      width: 500,
				      show:
				      		{
				      			effect: "blind",
				      			duration: 500
				      		},
				      buttons: {
				        		Ok: function() {
				          						$( this ).dialog( "close" );
				        					}
				      			}
				});
			}

			return false;
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
	console.log('Field Validator Check');
	console.log(rcvFldData);

	var resultArr 		= ["", ""];
	var typeOpts 		= rcvType.split("_");


	var regexTime = /^(\d{2})+:+(\d{2})+:+(\d{2})$/;
	var regexDate = /^(\d{4})+-+(\d{2})+-+(\d{2})$/;
	var regexDt = /^(\d{4})+-+(\d{2})+-+(\d{2})+\s+(\d{2})+:+(\d{2})+:+(\d{2})$/;
	var regexInt = /^(\d)+$/;
	var regexDecimal = /^(\d)+(\.)?(\d)*$/;
	var regexUpperCase = /^(.*[A-Z].*){2,}$/;
	var regexDigits = /^(.*[\d].*){2,}$/;
	var regexWordsDigits = /^[\d\w]+$/;



	if(rcvFldData=="" || rcvFldData==undefined)
	{
		resultArr[0] = "1";
		resultArr[1] = "The field is empty.";
	}
	else
	{
		switch(typeOpts[0].toLowerCase())
		{
			case "integer":
				if(!regexInt.test(rcvFldData))
				{
					resultArr[0] = "1";
					resultArr[1] = "The value is not an integer.";
				}
			break;

			case "decimal":
				if(!regexDecimal.test(rcvFldData))
				{
					resultArr[0] = "1";
					resultArr[1] = "The value is not a decimal.";
				}
			break;

			case "percent":
			    // remove pecentage sign if any
                rcvFldData = rcvFldData.replace("%", "");
				if(!regexDecimal.test(rcvFldData))
				{
					resultArr[0] = "1";
					resultArr[1] = "The value is not an decimal.";
				}
				else
				{
					rcvFldData = parseInt(rcvFldData, 10);

					if(rcvFldData<0 || rcvFldData > 100)
					{
						resultArr[0] = "1";
						resultArr[1] = "Value is not between 0 and 100.";
					}
				}
			break;

			case "date":
				if(!regexDate.test(rcvFldData))
				{
					resultArr[0] = "1";
					resultArr[1] = "The value is not an date.";
				}
			break;


			case "datetime":
				if(!regexDt.test(rcvFldData))
				{
					resultArr[0] = "1";
					resultArr[1] = "The value is not datetime.";
				}
			break;
		}
	}


	return resultArr;
}


//Sends the data to the proxy controller
function sendData(rcvDataStr)
{
	var translateData = rcvDataStr.replace(new RegExp(/\|+\|+DBLQT+\|+\|/, 'g'), '"');
	console.log(translateData);

	$('#request_data').val(translateData);
	$('#btn_send_data').click();
}
