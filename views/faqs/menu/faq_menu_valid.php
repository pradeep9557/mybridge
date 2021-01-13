<script>
         // Form Validation           
    $(document).ready(function () {
        $('#faq_menu_form_valid').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
        fields: {
                htmlid: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Html ID is required and can\'t be left empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9@\s]+$/,
                            message: 'Menu ID can only consist of Alpha numeric Characters'
                        }
                    }
                },m_heading_text: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Meta Heading Text is required and can\'t be left empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 50,
                            message: 'Length of Question must be more than 3 Characters'
                        }
                    }
                },div_heading_text: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Div Heading  is required and can\'t be left empty'
                        },
                        stringLength: {
                            min: 3,
                            max: 150,
                            message: 'Lenght of Answer must be more than 3 Characters'
                        }
                    }
                },Remarks: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Remark is required and can\'t be left empty'
                        },
                        stringLength: {
                            min: 5,
                            max: 100,
                            message: 'Lenght of Remark must be more than 5 Characters'
                        }
                    }
                }
               
            }

        });
    });
    

    
</script>