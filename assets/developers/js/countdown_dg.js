// DG_JavaScript Document

function cdtime(container, targetdate){
if (!document.getElementById || !document.getElementById(container)) return
this.container=document.getElementById(container)
this.currentTime=new Date()
this.targetdate=new Date(targetdate);
this.timesup=false
this.updateTime()
}

cdtime.prototype.updateTime=function(){
var thisobj=this
this.currentTime.setSeconds(this.currentTime.getSeconds()+1)
setTimeout(function(){thisobj.updateTime()}, 1000) //update time every second
}

cdtime.prototype.displaycountdown=function(baseunit, functionref){
this.baseunit=baseunit
this.formatresults=functionref
this.showresults()
}

cdtime.prototype.showresults=function(){
var thisobj=this


var timediff=(this.targetdate-this.currentTime)/1000 //difference btw target date and current date, in seconds
if (timediff<0){ //if time is up
this.timesup=true
this.container.innerHTML=this.formatresults()
return
}
var oneMinute=60 //minute unit in seconds
var oneHour=60*60 //hour unit in seconds
var oneDay=60*60*24 //day unit in seconds
var dayfield=Math.floor(timediff/oneDay)
var hourfield=Math.floor((timediff-dayfield*oneDay)/oneHour)
var minutefield=Math.floor((timediff-dayfield*oneDay-hourfield*oneHour)/oneMinute)
var secondfield=Math.floor((timediff-dayfield*oneDay-hourfield*oneHour-minutefield*oneMinute));

if (this.baseunit=="hours"){ //if base unit is hours, set "hourfield" to be topmost level
hourfield=dayfield*24+hourfield
dayfield="n/a"
}
else if (this.baseunit=="minutes"){ //if base unit is minutes, set "minutefield" to be topmost level
minutefield=dayfield*24*60+hourfield*60+minutefield;

dayfield=hourfield="n/a"
}
else if (this.baseunit=="seconds"){ //if base unit is seconds, set "secondfield" to be topmost level
var secondfield=timediff
dayfield=hourfield=minutefield="n/a"
}
this.container.innerHTML=this.formatresults(dayfield, hourfield, minutefield, secondfield)
setTimeout(function(){thisobj.showresults()}, 1000) //update results every second
}

function formatresults(){
if (this.timesup==false){//if target date/time not yet met
var displaystring=arguments[0]+" d "+arguments[1]+" h "+arguments[2]+" m "+arguments[3]+" seconds left until March 23, 2009 18:25:00"
}
else{ //else if target date/time met
var displaystring="Future date is here!";
}
return displaystring
}

function formatresults2(){
	if (this.timesup==false){ //if target date/time not yet met
		//var displaystring="<span class='lcdstyle'>"+arguments[0]+" days, "+arguments[1]+":"+arguments[2]+":"+arguments[3]+"</span>"
		var min=arguments[2];
		min=(min<10)?"0"+min:min;
		var hr=arguments[1];
		hr=(hr<10)?"0"+hr:hr;
		
		var displaystring='<p><strong class="fs18">'+arguments[0]+'</strong><br>days</p><p><strong class="fs18">'+hr+'</strong><br>hours</p><p><strong class="fs18">'+min+'</strong><br>minutes</p><p><strong class="fs18">'+arguments[3]+'</strong><br>seconds</p><div class="cb"></div>';
	}else{ //else if target date/time met
		var displaystring="" //Don't display any text
	}
	return displaystring
}

function formatresults3(){
	if (this.timesup==false){ //if target date/time not yet met
		//var displaystring="<span class='lcdstyle'>"+arguments[0]+" days, "+arguments[1]+":"+arguments[2]+":"+arguments[3]+"</span>"
		var min=arguments[2];
		min=(min<10)?"0"+min:min;
		var hr=arguments[1];
		hr=(hr<10)?"0"+hr:hr;		
		var displaystring='<p><strong class="fs18">'+arguments[0]+'</strong><br>days</p><p><strong class="fs18">'+hr+'</strong><br>hours</p><p><strong class="fs18">'+min+'</strong><br>minutes</p><p><strong class="fs18">'+arguments[3]+'</strong><br>seconds</p><div class="cb"></div>';
	}else{ //else if target date/time met
		var displaystring="" //Don't display any text
	}
	return displaystring
}

function formatresults4(){
	if (this.timesup==false){ //if target date/time not yet met
		//var displaystring="<span class='lcdstyle'>"+arguments[0]+" days, "+arguments[1]+":"+arguments[2]+":"+arguments[3]+"</span>"
		var min=arguments[2];
		min=(min<10)?"0"+min:min;
		var hr=arguments[1];
		hr=(hr<10)?"0"+hr:hr;
		
		var displaystring='<p><strong class="fs18">'+arguments[0]+'</strong><br>days</p><p><strong class="fs18">'+hr+'</strong><br>hours</p><p><strong class="fs18">'+min+'</strong><br>minutes</p><p><strong class="fs18">'+arguments[3]+'</strong><br>seconds</p><div class="cb"></div>';
	}else{ //else if target date/time met
		window.location.reload();
	}
	return displaystring
}


