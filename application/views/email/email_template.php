			<html>
			<head>
				<title></title>
				<style type="text/css">
				body, div{
					font-family: sans-serif;
					font-size: 9pt;
				}
				label {
					font-size: 10pt;
					font-weight: bold;

				}
				table {
					table-layout: fixed;
					font-size: 9pt;
				}
				.body {
					width: 600px;
					padding: 0px 50px 0px 50px;
				}
				label, .label {
					font-weight: bold;
				}
		
				.header-col {
					padding: 0px 20px 10px 0px;
				}
				.detail-body {
					float: both;
					width: 100%;
					clear:left;
				}

				.put-border {
					border: 1px solid black;
				}
				.body-label {
					width: 150px;
					font-weight: bold;
					vertical-align: top;
					color: #00541C;
				}
				.body-row {
					padding: 10px;
					border-top-left-radius: 4px;
					border-top-right-radius: 4px;
					border-bottom-right-radius: 4px;
					border-bottom-left-radius: 4px;

				}
				.bg-std {
					background: #00541C;
				}
			
				</style>
			</head>
			<body>
				<div class="body">
					<table width="600">
						<tr>
							<td class="body-row" style="background: #00541C">
								<table border="0" style="color: white" >
									<tr>
										<td class="header-col">
											<b><label>Ticket</label></b><br/>
											<span>#1032</span>
										</td>
										<td class="header-col">
											<b><label>Date Requested</label></b><br/>
											<span>June 15, 2016 07:54PM</span>
										</td>
										<td class="header-col">
											<b><label>Status</label></b><br/>
											<span>Acknowledge</span>
										</td>
										<td class="header-col">
											<b><label>Priority</label></b><br/>
											<span>High</span>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="600">
						<tr>
							<td class="body-row" style="background: #F6FDE5">
								<H4 style="color: #00541C">Ticket details</H4>
							</td>
						</tr>
					</table>

					<table width="600">
						<tr>
							<td class="body-row">
								<table>
									<tr>
										<td class="body-label">
											<label>Request Type</label> 
										</td>
										<td>MMD CONTRACT</td>
									</tr>
									<tr>
										<td class="body-label">
											<label>Requested By </label> 
										</td>
										<td>Mediavilla, Jason</td>
									</tr>
									<tr>
										<td class="body-label">
											<label>Site & Department  </label> 
										</td>
										<td>PPC - MIS</td>
									</tr>
									<tr>
										<td class="body-label">
											<label>Support</label> 
										</td>
										<td>Lapso, Kenneyjay</td>
									</tr>
								</table>
								<br>
								<table>
									<tr>
										<td>
											<b style="color: #00541C"><label>Subject: </label></b> This is a subject
										</td>
									</tr>
									<tr>
										<td class="body-label">
									
											<label>Message </label>
										</td>
									</tr>
									<tr>
										<td colspan="2" style="text-transform: ;">
											<p>i am trying to acquire a lock on a table A in exclusive mode, and this statement gives an error indicating a deadlock or timeout has been detected. The lock timeout value is set to 0 which I understand is to wait for however long it takes to acquire a lock.</p>
										</td>							
									</tr>
									<tr>
										<td colspan="2" style="text-transform: ;">
										    Attachments
										    <hr width="100%" class="margin3">
										    <?php foreach ($attachData as $attachData) { ?>
										      <span class='label label-info font8 margin1 inline-flex' id="attachfile-<?php echo $attachData->ticketAttacheId ?>"> 
										      	<a href="<?php echo base_url() ?>resources/uploads/<?php echo $attachData->fileHash ?>" target="_black" class="colo-white" >
										      		<?php echo $attachData->fileName ?>
										      	</a>
										      	<a href="#" data-ticketid="<?php echo $attachData->ticketId ?>" data-aId="<?php echo $attachData->ticketAttacheId ?>" data-fileHash="<?php echo $attachData->fileHash ?>" class="text-danger ticket-remove-attach"><span class="glyphicon glyphicon-remove"></span></a>
										      </span>
										    <?php
										    }
										</td>							
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width="600">
						<tr>
							<td class="body-row" style="background: #CFF37A">
								<H4 style="color: #00541C">Status Detail</H4>
							</td>
						</tr>
					</table>
					<table width="600">
						<tr>
							<td class="body-row">
								<table>
									<tr>
										<td class="header-col">
											<b style="color: #00541C"><label style="color: #00541C">Status</label></b> <br/>
											<span>Acknowledge</span>
										</td>
										<td class="header-col">
											<b style="color: #00541C"><label style="color: #00541C">Status Date</label></b><br/>
											<span>June 13, 2016 01:35PM</span>
										</td>
									</tr>
									<tr>
										<td class="body-label">Remarks</td>
										<td>The lock timeout value is set to 0 which I understand is to wait for however long it takes to acquire a lock.</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</div>
			
			</body>
			</html>