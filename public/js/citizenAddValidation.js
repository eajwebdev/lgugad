$(function () {
    $('#addCitizen').validate({
        rules: {
            lname: {
                required: true,
            },
            fname: {
                required: true,
            },
            mname: {
                required: true,
            },
        },
        messages: {
            lname: {
                required: "Please provide a Lastname",
            },
            fname: {
                required: "Please provide a Firstname",
            },
            mname: {
                required: "Please provide a Middlename",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.col-md-12').append(error);        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
    });
});