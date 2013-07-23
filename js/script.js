// JavaScript Document
function RemoveTag(i){
	
		jQuery('#imgurl_'+i).remove();
		jQuery('#post_image_'+i).remove();
		jQuery('#remove_'+i).remove();
		k = 1;
}
  function getArticle(id,title, url){
	jQuery("#dialog-view").text(title);
	jQuery("#htmlurl").val(url);
	jQuery(".inline").hide();	
	jQuery(".remove").show();
	jQuery(".inline").colorbox.close();  
	 } 
function Remove(){
	jQuery("#dialog-view").text('');
	jQuery("#htmlurl").val('');
	jQuery(".inline").show();
	jQuery(".remove").hide();
	}	 
	
	
function checkhour(tagid)
{	
	if(typeof(event)!='undefined')
	{
		var e = event; // for trans-browser compatibility
		var charCode = e.which || e.keyCode;

			if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

			hour=""+document.getElementById(tagid).value+String.fromCharCode(e.charCode);
			hour=parseFloat(hour);
			if((hour<0) || (hour>23))
			return false;
	}
	return true;

} 
function checkminute(tagid)
{	
	if(typeof(event)!='undefined')
	{
		var e = event; // for trans-browser compatibility
		var charCode = e.which || e.keyCode;

		if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

		minute=""+document.getElementById(tagid).value+String.fromCharCode(e.charCode);
		minute=parseFloat(minute);
		if((minute<0) || (minute>59))
		return false;
	}
	return true;
}	
	
function add_0(id)
{
		input=document.getElementById(id);
		if(input.value.length==1)
		{
				input.value='0'+input.value;
				input.setAttribute("value", input.value);
		}
}

function change_event_type(type)
{
	switch(type)
	{
		case 'text':
	
			jQuery('.postarea').css("display","none");
			jQuery('.mce_editable').css("display","inline");
			jQuery('.hidetext').hide('slow');
		break;

		case 'html':

			jQuery('.postarea').css("display","inline");
			jQuery('.mce_editable').css("display","none");
			jQuery('.hidetext').show('slow');
		break;

	}

}

function change_theme_slider(idtaginp, idtagdiv ){
	
		var inpvalue = jQuery( "#"+idtaginp ).val();

		if(inpvalue == "")
		 inpvalue = 28;
				jQuery( "#"+idtagdiv ).slider({

					range: "min",

					value: inpvalue,

					min: 0,

					max: 100,

					slide: function( event, ui ) {

						
						jQuery( "#"+idtaginp ).val( "" + ui.value ); 

					}

				});

				jQuery( "#videoDefaultVolume" ).val(jQuery( "#"+idtagdiv ).slider( "value" ) );
				jQuery( "#"+idtaginp ).val(jQuery( "#"+idtagdiv ).slider( "value" ) ); 
	
}	