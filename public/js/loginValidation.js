$(function () {
    $('#login').validate({
        rules: {
            username: {
                required: true,
                minlength: 5
            },
            password: {
                required: true,
                minlength: 5
            },
        },
        messages: {
            username: {
                required: "Please enter a username",
                username: "Please enter a valid username address",
                minlength: "Your username must be at least 5 characters long"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-md-12').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });
});