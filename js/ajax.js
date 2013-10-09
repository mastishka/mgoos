var AJAX = function()
{
	var curEntryIndex ;
	var http_request = false ;
	
	return {
		MakePostRequest : function(url, parameters, callback)
		{
			if (window.XMLHttpRequest)
			{
				// Mozilla, Safari,...
				this.http_request = new XMLHttpRequest();
				if (this.http_request.overrideMimeType)
				{
					//alert(this.http_request.overrideMimeType) ;
					// set type accordingly to anticipated content type
					//http_request.overrideMimeType('text/xml');
					this.http_request.overrideMimeType('text/html');
				}
			}
			else if (window.ActiveXObject)
			{
				// IE
				try 
				{
					this.http_request = new ActiveXObject("Msxml2.XMLHTTP");
				}
				catch (e)
				{
					try
					{
						this.http_request = new ActiveXObject("Microsoft.XMLHTTP");
					}
					catch (e)
					{}
				}
			}
			if (!this.http_request)
			{
				alert('Cannot create XMLHTTP instance');
				return false;
			}
			
			this.http_request.onreadystatechange = callback;
			
			this.http_request.open('POST', url, true);
			this.http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			this.http_request.setRequestHeader("Content-length", parameters.length);
			this.http_request.setRequestHeader("Connection", "close");
			this.http_request.send(parameters);
		},
		GetContents : function()
		{
			if (this.http_request.readyState == 4)
			{
				if (this.http_request.status == 200)
				{
					return this.http_request.responseText ;
				}
			}
			return false;
		}
	};
}();

/*
,
		AlertContents : function()
		{
			if (http_request.readyState == 4)
			{
				if (http_request.status == 200)
				{
					//alert(http_request.responseText);
					result = http_request.responseText;
					if(result.search(/updated/i) != -1)
					{
						alert("Record has been updated!");//document.getElementById(''+curEntryIndex).innerHTML = result;
					}
					else
					{
						alert("Incorrect Conf Code !");
					}
				}
				else
				{
					alert('There was a problem with the request.'+http_request.status);
				}
			}
		},
		AlertContentsLogin : function()
		{
			if (http_request.readyState == 4)
			{
				if (http_request.status == 200)
				{
					// - - - - - - - - - - - - - - - - - - -
					// Debug Code.
					// - - - - - - - - - - - - - - - - - - -
					// alert(http_request.responseText) ;
					// - - - - - - - - - - - - - - - - - - -
					
					var result = eval('(' + http_request.responseText + ')') ;
					alert(http_request.responseText);
					if(result.LoginResult.bUserVerified == 'true')
					{
						//alert("Success");
						location = "search_results.php?justlogin=true" ;
					}
					else
					{
						if(result.LoginResult.status == 0)
						{
							alert("Verification Pending...")
						}
						else if (result.LoginResult.status == 9)
						{
							alert("email or password is wrong...");
						}
						
						var objDivLogin = eval('document.all.LOGIN_FORM.style');
						var objDivTop = eval('document.all.USER_MSG_TOP.style');
						var objDivBot = eval('document.all.USER_MSG_BOT.style');
						
						objDivLogin.display = 'block' ;
						objDivTop.display = 'none' ;
						objDivBot.display = 'none' ;
					}
				}
				else
				{
					alert('There was a problem with the request.'+http_request.status);
				}
			}
		},
		Post : function(entryIndex)
		{
			this.curEntryIndex = entryIndex ;
			var poststr = "title=" + encodeURI( document.getElementById("TITLE_"+entryIndex).value ) +
						"&album=" + encodeURI( document.getElementById("ALBUM_"+entryIndex).value ) +
						"&artist=" + encodeURI( document.getElementById("ARTIST_"+entryIndex).value ) +
						"&year=" + encodeURI( document.getElementById("YEAR_"+entryIndex).value ) +
						"&time=" + encodeURI( document.getElementById("TIME_"+entryIndex).value ) +
						"&genre=" + encodeURI( document.getElementById("GENRE_"+entryIndex).value ) +
						"&composer=" + encodeURI( document.getElementById("COMPOSER_"+entryIndex).value ) +
						"&lyrics=" + encodeURI( document.getElementById("LYRICS_"+entryIndex).value ) +
						"&password=" + encodeURI( document.getElementById("PASSWORD_"+entryIndex).value ) +
						"&filepath=" + encodeURI( document.getElementById("FILEPATH_"+entryIndex).value );
			MakePOSTRequest('update_entry.php', poststr, 1);
		},
		PostUserPass : function(user, pass)
		{
			var poststr = "username=" + encodeURI( user ) +
						"&password=" + encodeURI( pass ) ;
			MakePOSTRequest('login.php', poststr, 2);
		}
*/