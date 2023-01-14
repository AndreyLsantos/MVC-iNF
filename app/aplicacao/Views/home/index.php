
<?php 
    $GLOBALS['css'] = [];
    $GLOBALS['js'] = [];
?>

<?php $load->loadView('_layout/header');?>


    <div class="row">
        <div class="col">
            <div class="card-body">
                <button class="btn btn-danger"><?php echo $titulo?></button>
            </div>
        </div>
    </div>


<?php $load->loadView('_layout/footer'); ?>
