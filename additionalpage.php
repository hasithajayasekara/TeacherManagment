
    <!-- END PAGE LEVEL  STYLES -->
     <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <SCRIPT language=Javascript>
// in my system, all pages call from index page so I put these function in index page only
// function for only allow input a number in textbox
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }
    </SCRIPT>
	<script>
// function for phone number
function phonenumber()
{
var phoneno = /^\d{10}$/;
	if(document.getElementById("tpnum").value=="")
	{
	}
	else
	{
		if( document.getElementById("tpnum").value.match(phoneno))
		{
			//return true;
			hand();
		}
		else
		{
			alert("Enter 10 digit hand phone number");
			document.getElementById("tpnum").value="";		
			return false;
		}
	}	 
}
function hand()
{
	var str = document.getElementById("tpnum").value;
	var res = str.substring(0, 2); 
	if(res=="07")
	{
		return true;
	}
	else
	{
			alert("Enter Valid Mobile Number");
			document.getElementById("tpnum").value="";		
			return false;
	}
	
}
// function for password
function password()
{
	var str = document.getElementById("txtnewpassword").value;
	var res = str.length; 
	if(res>6)
	{
		return true;
	}
	else
	{
			alert("enter more than 6 character password");
			document.getElementById("txtnewpassword").value="";		
			return false;
	}
	
}
// function for new password
function newpassword()
{
	var str = document.getElementById("nwpwdd").value;
	var res = str.length; 
	if(res>6)
	{
		return true;
	}
	else
	{
			alert("enter more than 6 character password");
			document.getElementById("nwpwdd").value="";		
			return false;
	}
	
}
</script>
<script language="javascript">
// function for only allow input a text in textbox
       function isTextKey(evt)
       {
          var charCode = (evt.which) ? evt.which : event.keyCode;
          if (((charCode >64 && charCode < 91)||(charCode >96 && charCode < 123)||charCode ==08 || charCode ==127||charCode ==32||charCode ==46)&&(!(evt.ctrlKey&&(charCode==118||charCode==86))))
             return true;
			
          return false;
       }
</script>
<script>
function nicnumber()
{
var nicno = /^[0-9]{9}[vVxX]$/;
	if(document.getElementById("txt_nicno").value=="")
	{
	}
	else
	{
		if( document.getElementById("txt_nicno").value.match(nicno))
		{
			return true;
		}
		else
		{
			alert("Enter 10 digit nic number");
			document.getElementById("txt_nicno").value="";		
			return false;
		}
	}	 
}
</script> 