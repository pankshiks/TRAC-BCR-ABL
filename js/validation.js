function checkPattern(value,vid,fname,pattern,mx)
{
	
	switch (pattern)
	{
		case "Empty":
		if(value=="")
            return false;
        else          	   
    		return true;        
								
		case "Number":
			return (/^[\.0-9]+$/.test(value)); 
        
        case "ExRate":
			return (/^[\.1-9]+$/.test(value));   
			
		case "PhoneNum":
		return (/^[\.0-9- ]+$/.test(value));     
		
		case "StrictNumber":
			return (/^[0-9]+$/.test(value));     
		
		case "Date":            
            va=value.split('/');
            
			if((/^\d{1,2}\/\d{1,2}\/\d{4}$/.test(value))==false) 
            {
                return false; 
            }                     		 
            else
            {      
                if((parseInt(va[0])>31)||(parseInt(va[1])>12))
                    return false;
                else
                {
                    if((parseInt(va[2])%4)==0&&((parseInt(va[2])%400)!=0))
                    {
                        if(parseInt(va[1])==2)
                        {
                            if(parseInt(va[0])>29)
                                return false;
                            else
                                return true;
                        }
                        else
                            return true;                         
                    }
                    else
                    {
                        if(parseInt(va[1])==2)
                        {
                            if(parseInt(va[0])>28)
                                return false; 
                            else
                                return true;                                
                        } 
                        else
                            return true;             
                    }                    
                }

            }		
		case "StringNum":
			return (/^[a-zA-Z0-9 ]+$/.test(value));    
		
		case "StrictString":
			return (/^[a-zA-Z ]+$/.test(value));    
		
		case "Email":
			return (/^[^0-9][A-z0-9_]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/.test(value));    
	
		case "Website":
		var v = new RegExp();
		v.compile("|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i");
		if (!v.test(str)) 
		return false;

		case "Zero":
			return (/^[-|+]{0,1}0{0,}[.]{0,1}[0]{0,}$/.test(value));
	
		 case "SignInt":
				return (/^[-|+]{0,1}[0-9]{1,}$/.test(value));
		case "Negative":
				return (/^-[0-9]{0,}[.]{0,1}[0-9]{0,}$/.test(value));
		case "SqlCheck":
			return (/^(delete from )|(update .+ set .+=.+)|(drop table )$/.test(value));
		case "StringLen":
        	if (value.length>mx)                	   
        		return false;   
            else          	   
        		return true;                            
        case "CharLen":
        	if (value.length!=mx)                	   
        		return false;    
            else          	   
        		return true;  
        case "Digit":
        	if (value>=10000000000)                	   
        		return false;    
            else          	   
        		return true;  
		case "Time":
            va=value.split(':');
        
			if((/^\d{1,2}:\d{1,2}(:\d{2})?$/.test(value))==false)	
        		return false;    
            else          
            {
                if((parseInt(va[0])>23) || (parseInt(va[1])>59 )|| (parseInt(va[2])>59) )
                    return false;
                else
                    return true;
            }	   
        		
        case 'Radio':
            radgrp=document.forms[fname].elements[vid];
            for (var i=0; i <radgrp.length; i++) 
            {
                if (radgrp[i].checked) 
                {
                    return true;                                         
                }
            } 
            return false;		                               
		default:
            alert(pattern+" not found");
            return false;
	}
}
function disable_form(fn,vid,con)
{
    objElems = document.forms[fn].elements;
    for(i=0;i<objElems.length;i++)
    {
        if(objElems[i].id!=vid && objElems[i].type!="submit")
        {
            $(objElems[i]).attr('disabled',con);
           // objElems[i].disabled=con;
        }
    }
}

function read_only_form(fn,vid,con)
{
    objElems = document.forms[fn].elements;
	var vid=vid.split(',');
    for(i=0;i<objElems.length;i++)
    {
		for(j=0;j<vid.length;j++)
		{
			if(objElems[i].id==vid[j])
			{
				objElems[i].readOnly=con;
			}
		}
    }
}

function disable_form_elements(fn,vid,con)
{
    
    objElems = document.forms[fn].elements;
	var vid=vid.split(',');
    for(i=0;i<objElems.length;i++)
    {
		for(j=0;j<vid.length;j++)
		{
			if(objElems[i].id==vid[j])
			{
		  	   objElems[i].disabled=con;
			}
		}
    }
}

			
function validate_custom(value,eid,patt,e,vid,fn,mx,opt)
{     
    
  
  	var value=$.trim(value);  
       
    var pat=patt.split(',');
    var err=e.split('~');
    var i;
    

   
    if(err.length==pat.length)
    {
        for(i=0;i<err.length;i++)
        {
            if((value=="")&&(opt=='true'))
            {
                var ereq = document.getElementById(eid);
                ereq.style.display = "none";                
                errset=0;                
            }            
            else if(!checkPattern(value,vid,fn,pat[i],mx))
            {      
                
                /*
            	var ereq = document.getElementById(eid);
            	ereq.innerHTML=err[i];
            	ereq.style.display = "";
                */
                
                /*New  */   
                  
                $('#'+eid).html(err[i]);  
            	
                $('[id='+eid+']').css('display', '');
                                                          
                
                
                
                
                
				disable_form(fn,vid,true);
                alertTimerId =window.setTimeout(function ()
                {
                    document.forms[fn].elements[vid].focus();
                }, 0);     
                                          
                errset=1;
                break;
            }
            else
            {
                var ereq = document.getElementById(eid);
                ereq.style.display = "none";                
                errset=0;
            }
        }
        if(errset==1)
        return false;
        else
        {
            disable_form(fn,vid,false); 
            return true;         
        }                
    }   
}

function validate_condition(value,eid,pat,e,vid,fn,mx,opt)
{    
  	var value=value.trim();    
    var pat=pat.split(',');
    var err=e.split('~');
    
    if(err.length==pat.length)
    {
        for(i=0;i<pat.length;i++)
        {
            if((value=="")&&(opt=='true'))                
                return true;                           
            else if(!checkPattern(value,vid,fn,pat[i],mx))
            {                                                               
                return false;
                break;
            }
            else               
                return true;
        }                
    }   
}