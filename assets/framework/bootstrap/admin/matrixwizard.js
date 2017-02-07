$(document).ready(function(){
	
	$("#form-wizard").formwizard({ 
		formPluginEnabled: true,
		validationEnabled: true,
		focusFirstInput : true,
		disableUIStyles : true,
	
		formOptions :{
			success: function(data){$("#status").fadeTo(500,1,function(){ $(this).html("<span>Form was submitted!</span>").fadeTo(5000, 0); })},
			beforeSubmit: function(data){$("#submitted").html("<span>Form was submitted with ajax. Data sent to the server: " + $.param(data) + "</span>");},
			dataType: 'json',
			resetForm: true
		},
		validationOptions : {
			rules: {
				student_firstname: "required",
                                student_middlename: "required",
                                student_lastname: "required",
                                student_school_id: "required",
                                student_gender: "required",
                                student_permanent_address: "required",
                                course_id: "required",
                                student_year_level: "required",
                                student_year_level_value: "required"
			},
			messages: {
				student_firstname: "required",
                                student_middlename: "required",
                                student_lastname: "required",
                                student_school_id: "required",
                                student_gender: "required",
                                student_permanent_address: "required",
                                course_id: "required",
                                student_year_level: "required",
                                student_year_level_value: "required"
			},
			errorClass: "help-inline",
			errorElement: "span",
			highlight:function(element, errorClass, validClass) {
			$(element).parents('.control-group').addClass('error');
			},
			unhighlight: function(element, errorClass, validClass) {
				$(element).parents('.control-group').removeClass('error');
			}
		}
	});	
});

