<script>
    // Form Validation           
    $(document).ready(function () {
        $('#room_mst').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                rcode: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Room Code is required and can\'t be left empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9@\s]+$/,
                            message: 'Room Code can only consist of Alpha numeric Characters'
                        }, stringLength: {
                            min: 2,
                            max: 15,
                            message: 'Room Code must be more than 2 Characters and less than 50 Characters'
                        }
                    }
                }, max_students: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Number Of students is required and can\'t be left empty'
                        },
                        integer: {
                            message: 'Number Of students Must be an integer'
                        },between: {
                            min: 1,
                            max: 1000,
                            message: 'Enter valid number '
                        }
                    }
                }

            }

        });
    });



</script>