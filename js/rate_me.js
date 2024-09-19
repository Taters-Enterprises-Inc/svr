document.getElementById("btnContinue").onclick = function() {

	//Employee Information
	var firstName = document.getElementById("rater_firstname");
	var lastName = document.getElementById("rater_lastname");

	//Question No. 1
	var r1q1 = document.getElementById("r1q1").checked;
	var r2q1 = document.getElementById("r2q1").checked;

	//Question No. 2
	var r1q2 = document.getElementById("r1q2").checked;
	var r2q2 = document.getElementById("r2q2").checked;

	//Question No. 3
	var r1q3 = document.getElementById("r1q3").checked;
	var r2q3 = document.getElementById("r2q3").checked;

	//Question No. 4
	var r1q4 = document.getElementById("r1q4").checked;
	var r2q4 = document.getElementById("r2q4").checked;

	//Question No. 5
	var r1q5 = document.getElementById("r1q5").checked;
	var r2q5 = document.getElementById("r2q5").checked;
	var r3q5 = document.getElementById("r3q5").checked;
	var r4q5 = document.getElementById("r4q5").checked;
	var r5q5 = document.getElementById("r5q5").checked;

	//Question No. 6
	var r1q6 = document.getElementById("r1q6").checked;
	var r2q6 = document.getElementById("r2q6").checked;
	var r3q6 = document.getElementById("r3q6").checked;
	var r4q6 = document.getElementById("r4q6").checked;
	var r5q6 = document.getElementById("r5q6").checked;

	if (firstName && firstName.value || lastName && lastName.value) {
		var divEmp = document.getElementById("divEmp");
		divEmp.classList.add("hide-element");

		var divQ1 = document.getElementById("divQ1");
		divQ1.classList.remove("hide-element");
	}
	
	if(r1q1 || r2q1) {
		document.getElementById("q1ans").value = document.querySelector("input[type='radio'][name=radioQ1]:checked").value;
		
		var divQ1 = document.getElementById("divQ1");
		divQ1.classList.add("hide-element");

		var divQ2 = document.getElementById("divQ2");
		divQ2.classList.remove("hide-element");
	}

	if(r1q2 || r2q2) {
		document.getElementById("q2ans").value = document.querySelector("input[type='radio'][name=radioQ2]:checked").value;
		
		var divQ2 = document.getElementById("divQ2");
		divQ2.classList.add("hide-element");

		var divQ3 = document.getElementById("divQ3");
		divQ3.classList.remove("hide-element");
	}

	if(r1q3 || r2q3) {
		document.getElementById("q3ans").value = document.querySelector("input[type='radio'][name=radioQ3]:checked").value;
		
		var divQ3 = document.getElementById("divQ3");
		divQ3.classList.add("hide-element");

		var divQ4 = document.getElementById("divQ4");
		divQ4.classList.remove("hide-element");
	}

	if(r1q4 || r2q4) {
		document.getElementById("q4ans").value = document.querySelector("input[type='radio'][name=radioQ4]:checked").value;
		
		var divQ4 = document.getElementById("divQ4");
		divQ4.classList.add("hide-element");

		var divQ5 = document.getElementById("divQ5");
		divQ5.classList.remove("hide-element");
	}

	if(r1q5 || r2q5 || r3q5 || r4q5 || r5q5) {
		document.getElementById("q5ans").value = document.querySelector("input[type='radio'][name=radioQ5]:checked").value;

		var divQ5 = document.getElementById("divQ5");
		divQ5.classList.add("hide-element");

		var divQ6 = document.getElementById("divQ6");
		divQ6.classList.remove("hide-element");
	}

	if(r1q6 || r2q6 || r3q6 || r4q6 || r5q6) {
		document.getElementById("q6ans").value = document.querySelector("input[type='radio'][name=radioQ6]:checked").value;

		var divQ6 = document.getElementById("divQ6");
		divQ6.classList.add("hide-element");

		var divComment = document.getElementById("divComment");
		divComment.classList.remove("hide-element");

		var btnContinue = document.getElementById("btnContinue");
		btnContinue.classList.add("hide-element");

		var btnSubmit = document.getElementById("btnSubmit");
		btnSubmit.classList.remove("hide-element");
	}
}