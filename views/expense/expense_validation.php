<script>
    //      Form Validation           
    $(document).ready(function () {
        $('#expense_mst').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                ex_amt: {
                    feedbackIcons: true,
                    validators: {
                        numeric: {
                            message: 'Please enter a valid amount',
                            decimalSeparator: '.'
                        }, notEmpty: {
                            message: 'Amount is required and cannot be left empty'
                        },between: {
                            min: 1,
                            max: 1000000,
                            message: 'Enter a valid amount'
                        }
                    }
                }, ex_des: {
                    feedbackIcons: true,
                    validators: {
                        regexp: {
                        regexp: /^[a-z0-9!@&?_-\s]+$/i,
                        message: 'Description can only consist of valid alphabetical characters'
                    }
                    }
                }
            }
        });
    });

</script>