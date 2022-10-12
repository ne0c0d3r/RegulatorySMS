<label>Route To </label>
						<select class="form-control input-sm col-md-12" name="routeTo" id="routeTo" required>
							<?php
							// echo json_encode($assignEmpData);
							echo print_r($data['assignEmpData']);
							if (count($assignEmpData) > 0) {
								foreach ($assignEmpData as $assignEmpList) { ?>
									<option value="<?php echo $assignEmpList->employeeId; ?>">
									<?php echo $assignEmpList->lastName . ', ' . $assignEmpList->firstName . ' ' . $assignEmpList->middleName; ?>
									</option>
								<?php 
								} ?>
							<?php } else { 
								if ($statusDesc == 'End') { ?>
									<option value="End">End of flow</option>
								<?php } else { ?>
									<option value="">No assigned Personnel</option>
							<?php } 
						} ?>
						</select>