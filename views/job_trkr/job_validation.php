<script>
    // Form Validation           
    $(document).ready(function () {
        $('#job_mst').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                jobCode: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Job Code is required and can\'t be left empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9@\s]+$/,
                            message: 'Job Code can only consist of Alpha numeric Characters'
                        }, stringLength: {
                            min: 5,
                            max: 50,
                            message: 'Job Code must be more than 5 Characters and less than 50 Characters'
                        }
                    }
                }, Job_Description: {// field name
                    validators: {
                        regexp: {
                            regexp: /^[a-zA-Z0-9@\s]+$/,
                            message: 'Description can only consist of Alpha numeric Characters'
                        },
                        stringLength: {
                            min: 5,
                            max: 80,
                            message: 'Description must be more than 5 Characters and less than 80 Characters'
                        }
                    }
                }, JobAddress: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Address Should not be left Empty'
                        }
                    }
                }, JobCharge: {// field name
                    validators: {
                        numeric: {
                            message: 'Please enter a valid amount',
                            decimalSeparator: '.'
                        }, notEmpty: {
                            message: 'Amount is required and cannot be left empty'
                        }, between: {
                            min: 1,
                            max: 1000000,
                            message: 'Enter a valid amount'
                        }
                    }
                }, Remarks: {// field name
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