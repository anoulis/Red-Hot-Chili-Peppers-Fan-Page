var pos = 0, find = 0, flag=0, movement=false, test, test_status, question,
 choice, choices, chA, chB, chC,chCor, correct = 0, first_time = true;

var positions = [];

function randomize(){
	var k = 0;
	 while (k < 5) {
         var randomnumber = Math.floor((Math.random() * 6) + 0);
          if (positions.indexOf(randomnumber) == -1) {
              positions[k] = randomnumber;
              k++;
          }
     }
}

var size = 5;

function start(){
	document.getElementById("warning").setAttribute("style", "visibility:hidden;")
  	randomize();
    quiz_status.innerHTML = "Test Your Knowledge in RHCP";
	  buttons_container.innerHTML = "<button  class='button button1 centerize' onclick='play()'>Play</button>";
}

function printResults(){
	quiz_question.innerHTML = "";
   	images_container.innerHTML = "";
	quiz_status.innerHTML = "Test Completed";
  	 quiz_status.innerHTML += "<h2>You got "+correct+" of "+size+" questions correct</h2>";
    buttons_container.innerHTML= "<button class='button button1 ' onclick='play()'>Play Again</button>";
		pos = 0;
		correct = 0;
}

function play(){
	if(pos<size){
		index = positions[pos];
    loadDoc();
	}else{
		printResults();
		randomize();
		return false;
	}
}


function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      showQuestion(this);
    }
  };
  xhttp.open("GET", "quizData.xml", true);
  xhttp.send();
}

function showQuestion(xml){

  var xmlDoc = xml.responseXML;
  var i;
  var x = xmlDoc.getElementsByTagName("QUESTION");
  question = x[index].getElementsByTagName("TITLE")[0].childNodes[0].nodeValue;
	chA = x[index].getElementsByTagName("CHOICE_ONE")[0].childNodes[0].nodeValue;
	chB = x[index].getElementsByTagName("CHOICE_TWO")[0].childNodes[0].nodeValue;
	chC = x[index].getElementsByTagName("CHOICE_THREE")[0].childNodes[0].nodeValue;
	chCor = x[index].getElementsByTagName("ANSWER")[0].childNodes[0].nodeValue;

  quiz_status.innerHTML = "Question "+(pos+1)+" of "+size;
  quiz_question.innerHTML = ""+question;
  warning.innerHTML = "nothing";
	images_container.innerHTML = "<input type='image' class='fake_img' class='img_quiz' id='A' onclick='markQuestion(id)' >";
  $("#A").attr("src",chA);
  images_container.innerHTML += "<input type='image' class='fake_img' class='img_quiz' id='B' onclick='markQuestion(id)'>";
  $("#B").attr("src",chB);
  images_container.innerHTML += "<input type='image' class='fake_img' class='img_quiz' id='C' onclick='markQuestion(id)'>";
  $("#C").attr("src",chC);
  buttons_container.innerHTML = "<button class='button button1' onclick='submitAnswer()'>Submit Answer</button>";
	buttons_container.innerHTML += "<button class='button button1' onclick='move()'>Next Answer</button>";

}

function refreshImageBorder(){
  document.getElementById('A').style.borderColor = "grey";
  document.getElementById('B').style.borderColor = "grey";
  document.getElementById('C').style.borderColor = "grey";

}

function markQuestion(element){
  choice = element;
  refreshImageBorder();
  document.getElementById(choice).style.borderColor = "blue";
	find=1;
   if(first_time){
      	if(choice == chCor){
      		 flag=1;
      		correct++;
      	}
      	else{
      		flag=0;
      	}
   }
}

function submitAnswer(){

    if(find==1)
	   {
       if(first_time){
         movement=true;
         if(flag == 1){
          document.getElementById(choice).style.borderColor = "green";
          warning.innerHTML = "Correct!";
          document.getElementById("warning").setAttribute("style", "visibility:visible;");
	       }
	       else{
          document.getElementById(choice).style.borderColor = "red";
          warning.innerHTML = "Wrong!";
          document.getElementById("warning").setAttribute("style", "visibility:visible;");
         }
         first_time=false;
       }else{
         warning.innerHTML = "You have already submit an Answear!";
         document.getElementById("warning").setAttribute("style", "visibility:visible;")
         document.getElementById("question_result").setAttribute("style", "visibility:hidden;")
       }
	  }
	  else{
        warning.innerHTML = "Please make a selection first!";
        document.getElementById("warning").setAttribute("style", "visibility:visible;");
    }

}


function move(){
	if(movement)
	{ pos++;
	  find=0;
	  flag=0;
	  movement=false;
    first_time = true;
    document.getElementById("warning").setAttribute("style", "visibility:hidden;")
	  play();
	}else{
    warning.innerHTML = "Please submit an answer!";
    document.getElementById("warning").setAttribute("style", "visibility:visible;");
	}
}

window.addEventListener("load", start, false);
