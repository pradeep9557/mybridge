<!--fonts-->
<!--<link href='https://fonts.googleapis.com/css?family=Work+Sans' rel='stylesheet' type='text/css'>-->
<!--end of fonts-->
<script src="<?= CDN1 ?>js/jquery-1.11.0.js" type="text/javascript"></script> 
<script>
    console.log();
    var myVar = setInterval(function () {
        myTimer()
    }, 500);
    var progress = 10;
    function myTimer() {
        $(".progress-bar").css("width", progress + "%");
        $(".progress-bar span").text(progress + "%");
        if (!progress > 90) {
            progress += 10;
        }
    }
    function myStopFunction() {
        clearInterval(myVar);
    }

</script>
<link href="<?= CDN1 ?>css/sb-admin-2.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="<?= CDN1 ?>css/bootstrap.css">

<!-- for sweet alert -->
<link href="<?= CDN1 ?>js/sweetalert/lib/sweet-alert.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/sweetalert/lib/sweet-alert.js" type="text/javascript"></script>
<!-- multi select -->
<!--<link href="<?= CDN1 ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css"/>-->

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->


<link href="<?= CDN1 ?>css/custome.css" rel="stylesheet" type="text/css"/>

<!-- preloader -->
<link href="<?= CDN1 ?>js/material_preloader/materialPreloader.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>js/custom_js/helper.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/material_preloader/materialPreloader.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/material_preloader/preloader_runner.js" type="text/javascript"></script>

<!-- Material preloader -->

<!-- Custom Fonts -->
<link href="<?= CDN1 ?>font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">


<!--Angluar js for menu-->
<!--<script src="<?= base_url() ?>js/angular.min.js" type="text/javascript"></script>-->
<!--End Angluar js-->



<!--<link href="<?= base_url() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css"/>-->
<!--<link href="<?= base_url() ?>css/plugins/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>-->
<!--datatables-->
<!--
<link href="<?= base_url() ?>css/plugins/dataTables.responsive.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js"></script>-->

<!-- MetisMenu CSS -->
<!--<link href="<?= base_url() ?>css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet" type="text/css"/>-->
<!-- Timeline CSS -->
<!--<link href="<?= base_url() ?>css/plugins/timeline.css" rel="stylesheet" type="text/css"/>-->
<!-- Custom CSS -->

<!--<link href="<?= base_url() ?>css/form.css" rel="stylesheet">-->


<!-- Custom CSS -->
<!--<link href="<?= base_url() ?>css/sb-admin-2.css" rel="stylesheet">-->


<!-- Date Picker css -->


<!--for form validation-->
<!--<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>-->

<!-- switch remove from every where -->
<!--<link href="<?= base_url() ?>css/switch/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/switch/bootstrap-switch.js" type="text/javascript"></script>-->

<!--<link href="<?= base_url() ?>css/model/bootstrap-modal.css" rel="stylesheet" type="text/css"/>-->

<!--<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>-->




<!-- Morris Charts CSS -->

<!-- Material preloader -->

