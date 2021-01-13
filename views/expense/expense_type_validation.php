<script>
    //      Form Validation           
    $(document).ready(function () {
        $('#expense_type_mst').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                ex_type_code: {
                    feedbackIcons: true,
                    validators: {
                        regexp: {
                            regexp: /^[a-zA-Z]+$/,
                            message: 'The Expense Type can only consist Alphabates, No special character allowed'
                        }, notEmpty: {
                            message: 'Type of expense is required and cannot be left empty'
                        }
                    }
                }, Remarks: {
                    feedbackIcons: true,
                    validators: {
                        regexp: {
                        regexp: /^[a-z0-9!@&?_-\s]+$/i,
                        message: 'Remarks can only consist of valid alphabetical characters'
                    }
                    }
                }
            }
        });
    });

</script>