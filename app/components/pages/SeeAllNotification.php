<?php
session_start();

if(!isset($_SESSION["PK_USER"])){

	echo "<script>window.location.href='https://desk.hosteur.pro/app/components/pages/auth_login.php'</script>";
  
  }
  
if(isset($_REQUEST['pagenotification_number'])){

	$pagenoti_number=intval($_REQUEST['pagenotification_number']);
}
else{
	$pagenoti_number=1;
}

?>



<div class="container-full">
		<!-- Content Header (Page header) -->
		<div class="content-header">
			<div class="d-flex align-items-center">
				<div class="me-auto">
					<h4 class="page-title">Listes Notifications</h4>
					<div class="d-inline-block align-items-center">
						
					</div>
				</div>
				
			</div>
		</div>	  

		<!-- Main content -->
		<section class="content">

		  <div class="row">
			  <div class="col-12 col-xl-12">
				<div class="box">
					<div class="box-header with-border">
					<input type="hidden" value="<?php echo $pagenoti_number;?>" id="idpagenumbernotification">

						<h4 class="box-title">Notifications</h4><br>
                        <span class="text-info" style="font-size:12px">Vous avez <span id="countallnotifications"></span> notifications</span>
					</div>
					<div class="box-body p-0">
					  <div class="media-list media-list-hover bg-lightest" id="barnotifications">
						<!--a class="media media-single" href="#">
						  <h4 class="w-50 text-gray fw-500">10:10</h4>
						  <div class="media-body ps-15 bs-5 rounded border-primary">
							<p>Morbi quis ex eu arcu auctor sagittis.</p>
							<span class="text-fade">by Johne</span>
						  </div>
						</a-->

					  </div>
					</div>
				</div>
			  </div>

			</div>
		  <!-- /.row -->
           <form>
            <input type="hidden" id="pk_userNOT" value="<?php echo $_SESSION['PK_USER']; ?>">
			<input type="hidden" id="k_keyNOT" value="<?php echo $_SESSION['K_KEY'];?>">
		   </form>
		</section>
		<!-- /.content -->
	  </div>

	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


      <script>

	$(document).ready(function()
		{

			// get all notifications..............................	
			let pagenumber=$('#idpagenumbernotification').val();
			let PK_USER=$('#pk_userNOT').val();

			$.ajax({
			url:"https://www.yestravaux.com/webservice/crm/lead.php",
			method:"POST",
			data:{fct:'FetchAllNotifications',pagenotification_number:pagenumber,PK_USER:PK_USER},
			dataType:"json",
			success:function(data)
			{
			$('#barnotifications').html(data.notification);
			if(data.count_all_notification > 0)
			{
			$('#countallnotifications').html(data.count_all_notification)
			}
			}
	 });

});

// function for making paginations for notifications....
	function nextNotificationPage(numpage)
	{
	        let PK_USER=$('#pk_userNOT').val();

			$('#idpagenumbernotification').val(numpage);
			$.ajax({
			url:"https://www.yestravaux.com/webservice/crm/lead.php",
			method:"POST",
			data:{fct:'FetchAllNotifications',pagenotification_number:numpage,PK_USER:PK_USER},
			dataType:"json",
			success:function(data)
			{
				$('#barnotifications').html(data.notification);
			if(data.count_all_notification > 0)
			{
				$('#countallnotifications').html(data.count_all_notification)
			}
			}
		});
	}


      </script>