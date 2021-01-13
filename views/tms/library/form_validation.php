<?php
$config = array(
        'user_data' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'trim|required'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email'
                ),
                array(
                        'field' => 'my_image',
                        'label' => 'Image',
                        'rules' => 'callback_validate_image'
                )
        )
);
?>