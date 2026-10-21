$(function () {
    $('#addUser').validate({
        rules: {
            fname: {
                required: true
            },
            mname: {
                required: true
            },
            lname: {
                required: true
            },
            username: {
                required: true,
                minlength: 5
            },
            password: {
                required: true,
                minlength: 5
            },
            gender: {
                required: true
            },
            role: {
                required: true
            },
        },
        messages: {
            fname: {
                required: "Please enter a First Name"
            },
            mname: {
                required: "Please enter a Middle Name"
            },
            lname: {
                required: "Please enter a Last Name"
            },
            username: {
                required: "Please enter a username",
                minlength: "Your username must be at least 5 characters long"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            gender: {
                required: "Please select a Gender"
            },
            role: {
                required: "Please select a Role"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-md-12, .col-md-6').append(error);        
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });
});