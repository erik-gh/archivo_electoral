    <script type="text/javascript">

    	const base_url = "<?= base_url(); ?>";
      const media = "<?= media(); ?>";
    </script>

    <script src="<?= media(); ?>/js/vendor.min.js"></script>
  	<script src="<?= media(); ?>/js/cosmos.min.js"></script>
  	<script src="<?= media(); ?>/js/application.min.js"></script>
  	<script src="<?= media(); ?>/js/ui-notifications.min.js"></script>
  	<script src="<?= media(); ?>/js/forms-form-wizard.min.js"></script>
  	<script src="<?= media(); ?>/js/responsivevoice.js"></script>
  	<script src="<?= media(); ?>/js/ui-buttons.min.js"></script>
  	<script src="<?= media(); ?>/js/forms-material-form.min.js"></script>
  	<!-- <script src="<?= media(); ?>/js/index.min.js"></script> -->
  	<!-- <script src="<?= media(); ?>/js/dashboard-2.min.js"></script> -->
  	<script src="<?= media();?>/js/quagga.min.js"></script>
  	<!-- Custom js for this page-->
  	<script src="<?= media(); ?>/js/jquery-validation/jquery.validate.js"></script>
  	<script src="<?= media(); ?>/js/jquery-validation/localization/messages_es_PE.js"></script>
  	<script src="<?= media(); ?>/js/alert/js/sweetalert.min.js"></script>
    <script src="<?= media(); ?>/js/plugins/bootstrap-select.min.js"></script>
    <script src="<?= media(); ?>/js/plugins/bootstrap-select-es_ES.min.js"></script>
  	<script src="<?= media(); ?>/js/sign-in.js"></script>
    <script src="<?= media(); ?>/js/jquery.signature.js"></script>
    <script src="<?= media(); ?>/js/jquery.ui.touch-punch.min.js"></script>

    <script src="<?= media();?>/functions/<?= $data['page_function_js'] ?>"></script>
    <script src="<?= media();?>/js/upload.js"></script>

    <script src="<?= media();?>/js/datatables_export/dataTables.buttons.min.js"></script>
    <script src="<?= media();?>/js/datatables_export/jszip.min.js"></script>
    <script src="<?= media();?>/js/datatables_export/pdfmake.min.js"></script>
    <script src="<?= media();?>/js/datatables_export/vfs_fonts.js"></script>
    <script src="<?= media();?>/js/datatables_export/buttons.html5.min.js"></script>
    

    <script type="text/javascript">

    	$(document).ready(function() {
          // $('[data-toggle="tooltip"]').tooltip(); 			
          var url = window.location; 
          var element = $('ul.sidebar-menu a').filter(function() {
          return this.href == url || url.href.indexOf(this.href) == 0; }).parent().addClass('active');
          if (element.is('li')) { 
            element.addClass('active').parent().parent('li').addClass('active')
          }
  		});
		
    </script>