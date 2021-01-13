<script>
    //      Form Validation           
    $(document).ready(function () {
        $('#job_mst').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                FacultyID: {
                    feedbackIcons: true,
                    validators: {
                        integer: {
                            message: 'Faculty ID must be of numeric type, No special character allowed'
                        }, notEmpty: {
                            message: 'ID is required and cannot be left empty'
                        }
                    }
                },CourseID: {
                    feedbackIcons: true,
                    validators: {
                        integer: {
                            message: 'Course ID must be of numeric type, No special character allowed'
                        }, notEmpty: {
                            message: 'ID is required and cannot be left empty'
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
                },Share: {
                    feedbackIcons: true,
                    validators: {
                        numeric: {
                            message: 'Please enter a valid amount',
                            decimalSeparator: '.'
                        }, notEmpty: {
                            message: 'Share is required and cannot be left empty'
                        }, between: {
                            min: 1,
                            max: 100,
                            message: 'Enter a valid number'
                        }
                    }
                }
            }
        });
    });

</script>