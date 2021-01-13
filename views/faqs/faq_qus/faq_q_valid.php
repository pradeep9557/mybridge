  <script>
         // Form Validation           
    $(document).ready(function () {
        $('#faq_ques_form').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
        fields: {
                menuid: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Menu ID is required and can\'t be left empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9@\s]+$/,
                            message: 'Menu ID can only consist of Alpha numeric'
                        }
                    }
                },questions: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Question is required and can\'t be left empty'
                        },
                        stringLength: {
                            min: 10,
                            max: 50,
                            message: 'Length of Question must be more than 10 Characters'
                        }
                    }
                },answers: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Answer is required and can\'t be left empty'
                        },
                        stringLength: {
                            min: 10,
                            max: 50,
                            message: 'Lenght of Answer must be more than 10 Characters'
                        }
                    }
                }
               
            }

        });
    });
    

    
</script>