<?=$this->extend("admin/layout/master")?>

<?=$this->section("content")?>
<div class="content-wrapper">
 <div class="row">
		<!-- Start of tiles -->
		<div class="col-md-4 grid-margin transparent">
            <div class="row">
                 <div class="col-md-12 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Categories</p>
                            <p class="fs-30 mb-2"><?=$total_categories?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="col-md-4 grid-margin transparent">
            <div class="row">
                 <div class="col-md-12 mb-4 stretch-card transparent">
                    <div class="card card-light-danger">
                        <div class="card-body">
                            <p class="mb-4">Total Submissions</p>
                            <p class="fs-30 mb-2"><?=$total_submissions?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="col-md-4 grid-margin transparent">
            <div class="row">
                 <div class="col-md-12 mb-4 stretch-card transparent">
                    <div class="card card-dark-blue">
                        <div class="card-body">
                            <p class="mb-4">Total Forms</p>
                            <p class="fs-30 mb-2"><?=$total_forms?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>         
        </div>
	  <!-- End of tiles -->
    </div>
	<!-- End of pie chart memebership -->

<!-- content-wrapper ends -->
<?=$this->endSection()?>
<?=$this->section("script")?>
<script>
//Get params

</script>
<?=$this->endSection()?>