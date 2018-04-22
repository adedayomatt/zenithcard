											<form action="<?php $_PHP_SELF ?>" method="POST">

											<style>
											.kyc-section{
												background-color: #fff;
												color: #003300;
												padding: 10px;
												border-radius: 5px;
												margin-bottom: 10px;
											}
											label{
												font-weight: bold;
											}
											.doc-criteria-list{
												list-style-type: none;
												color: #003300;
											}
											.help-block{
												color:grey;
											}
											#personal-info{

											}
											#id-info{
												
											}
											</style>
												<h2 class="primary-color text-center"><i class="fas fa-users"></i>  Complete KYC</h2>
												<input type="hidden" name="user_id" value="<?php echo $user->id ?>">
												<div class="kyc-section" id="personal-info">
												<h3 class="primary-color">Personal Information</h3>
												
												<div class="row">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
														<div class="form-group">
															<label for="">Your Name</label>
															<div class="row">
																<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
																	<div style="padding: 10px">
																		<input type="text" name="first_name" class="form-control" placeholder="Firt Name" value="<?php echo $user->firstName ?>" readonly>
																	</div>
																</div>
																<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
																	<div style="padding: 10px">
																		<input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo $user->lastName ?>" readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
												
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="email_address">Email Address</label>
															<input type="email" name="email" class="form-control" placeholder="you@example.com" value="<?php echo $user->email ?>" readonly>
														</div>
													</div>
													
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="phone">Mobile Phone</label>
															<input type="text" name="phone" class="form-control" placeholder="Your mobile phone number" value="<?php echo ($myKYC->phone == '' ? '': $myKYC->phone) ?>" <?php echo ($myKYC->phone == '' ? '': 'readonly') ?>>
														</div>
													</div>
													
															<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="email_address">Address</label>
															<input type="text" name="address" class="form-control" placeholder="Your home address" value="<?php echo ($myKYC->address == '' ? '': $myKYC->address) ?>" <?php echo ($myKYC->address == '' ? '': 'readonly') ?> >
														</div>
													</div>
													
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="postal_code">Postal Code</label>
															<input type="text" name="postal_code" class="form-control" placeholder="Your postal code" value="<?php echo ($myKYC->postalCode == '' ? '': $myKYC->postalCode) ?>" <?php echo ($myKYC->postalCode == '' ? '': 'readonly') ?> >
														</div>
													</div>

													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="city">City</label>
															<input type="text" name="city" class="form-control" placeholder="Your city" value="<?php echo ($myKYC->city == '' ? '': $myKYC->city) ?>" <?php echo ($myKYC->city == '' ? '': 'readonly') ?>>
														</div>
													</div>
												
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="country">Country</label>
															<input type="text" name="country" class="form-control" placeholder="Your country" value="<?php echo ($myKYC->country == '' ? '': $myKYC->country) ?>" <?php echo ($myKYC->country == '' ? '': 'readonly') ?>>
														</div>
													</div>	
												
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="nationality">Nationality</label>
															<input type="text" name="nationality" class="form-control" placeholder="Your nationality" value="<?php echo ($myKYC->nationality == '' ? '': $myKYC->nationality) ?>" <?php echo ($myKYC->nationality == '' ? '': 'readonly') ?> >
														</div>
													</div>
													
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="dob">Date of Birth</label>
															<input type="date" name="dob" class="form-control" placeholder="Your date of birth in dd-mm-yy" value="<?php echo (($myKYC->dob == '' || $myKYC->dob == '0000-00-00') ? '': $myKYC->dob) ?>" <?php echo (($myKYC->dob == '' || $myKYC->dob == '0000-00-00') ? '': 'readonly') ?>  >
														</div>
													</div>
													
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="form-group" style="padding: 5px 20px">
														<p class="help-block">I will pay from the following ETH wallet address and receive tokens to this address also </p>
														<input type="text" name="eth_wallet" class="form-control" placeholder="ETH address you would be paying from" value="<?php echo ($myKYC->wallet == '' ? '': $myKYC->wallet) ?>" <?php echo ($myKYC->wallet == '' ? '': 'readonly') ?>  >
														</div>
													</div>
													
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="form-group" style="padding: 5px 20px">
															<p class="help-block">I wish to contribute more than 15 ETH </p>
															<div class="radiobutton">
																<label><input type="radio" name="contribute_more_than_15ETH" value="Yes" <?php echo ($myKYC->_15ETHplus == '' ? '': ($myKYC->_15ETHplus == 'Yes' ? 'checked' : '' )) ?> <?php echo ($myKYC->_15ETHplus == '' ? '': 'readonly') ?> > Yes</label>
															</div>
															<div class="radiobutton">
																<label><input type="radio" name="contribute_more_than_15ETH" value="No" <?php echo ($myKYC->_15ETHplus == '' ? '': ($myKYC->_15ETHplus == 'No' ? 'checked' : '' )) ?> <?php echo ($myKYC->_15ETHplus == '' ? '': 'readonly') ?>> No</label>
															</div>
														</div>
													</div>
												</div>
												
												</div>
												
												<div class="kyc-section" id="id-info">
													<h3 class="primary-color">ID Information</h3>
													<p>You can upload one of the following government issued ID documents:</p>
													<ul>
														<li>Passport</li>
														<li> National ID Card</li>
														<li>Driver’s License</li>
													</ul>
													<p>Please ensure the picture of your government issued ID document is clear. If your ID is not readable or otherwise unable to be verified as a legitimately issued government ID, we will not allow you to proceed with our improved identity verification process.</p>
												
												<div class="row">
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="dob">ID Document Type : <?php echo ($myKYC->idType == '' ? '': $myKYC->idType) ?> </label>
															<select class="form-control" name="id_type"  <?php echo ($myKYC->idType == '' ? '': 'readonly') ?> >
																<option value="none">--Select ID type--</option>
																<option value="Passport">Passport</option>
																<option value="National ID Card">National ID Card</option>
																<option value="Driver’s License">Driver’s License</option>
															</select>
														</div>
													</div>
													
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="dob">ID Document Number</label>
															<input type="text" name="id_doc_no" class="form-control" placeholder="Enter ID document number here" value="<?php echo ($myKYC->idNumber == '' ? '': $myKYC->idNumber) ?>" <?php echo ($myKYC->idNumber == '' ? '': 'readonly') ?>  >
														</div>
													</div>
													
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="dob">ID Document Issue Date (DD. MM. YYYY)</label>
															<input type="date" name="id_issue_date" class="form-control" placeholder="Enter issue date for your ID document" value="<?php echo (($myKYC->idIssueDate == '' || $myKYC->idIssueDate == '0000-00-00') ? '': $myKYC->idIssueDate) ?>" <?php echo (($myKYC->idIssueDate == '' || $myKYC->idIssueDate == '0000-00-00') ? '': 'readonly') ?>  >
														</div>
													</div>
													
													<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
														<div class="form-group">
															<label for="dob">ID Document Expiration Date (DD. MM. YYYY)</label>
															<input type="date" name="id_expire_date" class="form-control" placeholder="Enter expiration date for your ID document" value="<?php echo (($myKYC->idExpireDate == '' || $myKYC->idExpireDate == '0000-00-00') ? '': $myKYC->idExpireDate) ?>" <?php echo (($myKYC->idExpireDate == '' || $myKYC->idExpireDate == '0000-00-00') ? '': 'readonly') ?>  >
														</div>
													</div>
													
												</div>
												
												</div>
												
												<div class="kyc-section" id="id_document_photo">
													<h3 class="primary-color">Identity</h3>
													
													<div class="row" id="front-id">
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
															<img src="../images/KYC/id-doc-front-template.png" width="300px" height="auto" class="doc-template">
															<input type="hidden" name="id_front_photo_name" value="<?php echo ($myKYC->idPhotoFront == '' ? '': $myKYC->idPhotoFront) ?>" >
														</div>
														
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															<div class="form-group">
															<label for="id_front_photo">Front side photo ID document </label>
																<input type="file" name="id_front_photo" class="form-control" <?php echo ($myKYC->idPhotoFront == '' ? '': 'readonly') ?>>
																<button></button>
																<ul>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Entire ID is visible</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  ID is clear and easy to read </li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Front side (National ID Card / Driver’s License) </li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Passport personal page (Passport) </li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Format: PDF, JPG, JPEG OR PNG </li>
																</ul>
															</div>
														</div>
													</div>
													
													<div class="row" id="back-id">
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
															<img src="../images/KYC/id-doc-back-template.png" width="300px" height="auto" class="doc-template">
															<input type="hidden" name="id_back_photo_name" value="<?php echo ($myKYC->idPhotoBack == '' ? '': $myKYC->idPhotoBack) ?>">
														</div>
														
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															<div class="form-group">
															<label for="id_back_photo">Back side photo ID document </label>
																<input type="file" name="id_back_photo" class="form-control" <?php echo ($myKYC->idPhotoBack == '' ? '': 'readonly')?> >
																<ul>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Entire ID is visible</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  ID is clear and easy to read </li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Back side (National ID Card / Driver’s License) </li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Cover (Passport) </li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Format: PDF, JPG, JPEG OR PNG </li>
																</ul>
																
																<ul>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Recent utility bill with your name and address on it (such as a telephone bill)</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Recent bank account statement with your name and address on it or similar</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Less than 3 months old</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Format: PDF, JPG, JPEG OR PNG</li>
																</ul>
															</div>
														</div>
													</div>
												</div>
												
												<div class="kyc-section" id="ultilty-bill-photo">
													<h3 class="primary-color">Ultility Bill</h3>
													<div class="row">
													
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
															<img src="../images/KYC/ultility-bill-template.png" width="300px" height="auto" class="doc-template">
															<input type="hidden" name="ultility_bill_photo_name" value="<?php echo ($myKYC->ultilityBillPhoto == '' ? '': $myKYC->ultilityBillPhoto) ?>" >
														</div>
														
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															<div class="form-group">
															<label for="ultility_bill_photo">Ultility Bill Photo</label>
																<input type="file" name="ultility_bill_photo" class="form-control" <?php echo ($myKYC->ultilityBillPhoto == '' ? '': 'readonly')?> >
																<ul>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Recent utility bill with your name and address on it (such as a telephone bill)</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Recent bank account statement with your name and address on it or similar</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Less than 3 months old</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Format: PDF, JPG, JPEG OR PNG</li>
																</ul>
															</div>
														</div>
													</div>
													
													</div>
													
												<div class="kyc-section" id="selfie-photo">
													<h3 class="primary-color">Selfie</h3>
													<div class="row">
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
															<img src="../images/KYC/selfie-template.png" width="300px" height="auto" class="doc-template">
															<input type="hidden" name="selfie_name" value="<?php echo ($myKYC->selfie == '' ? '': $myKYC->selfie) ?>">
														</div>
														<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
															<div class="form-group">
															<label for="selfie">Selfie with ID and handwritten note</label>
																<input type="file" name="selfie" class="form-control" <?php echo ($myKYC->selfie == '' ? '': 'readonly')?> >
																<ul>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Face clearly visible (no glasses)</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  ID clearly visible</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Note with words “For ZenithCard” + today’s date + signature</li>
																	<li class="doc-criteria-list"><i class="fas fa-check-circle"></i>  Format: PDF, JPG, JPEG OR PNG</li>
																</ul>
															</div>
														</div>
													</div>
													
												</div>
												
												<div class="kyc-section" id="consent">
													<h3 class="primary-color text-center">Consent for processing your personal data</h3>
													<p>On the basis of the legitimate interests, ZenithCard Ltd will process and maintain records of personal data
														which you inserted in the KYC (“Know Your Customer”) form, together with other details of this transaction
														(the amount, date and purpose of your contribution), to verify the identity of any contributor through KYC. 
														KYC is a reasonable and proportionate procedure and the collected personal data involves only limited and
														necessary information.<br/><br/>
														After you submit the KYC form, ZenithCard would like to stay in touch with you. By ticking the boxes below, 
														you permit Eligma to process your personal data also:</p>
														
														<div class="checkbox">
															<label>
																<input type="checkbox" name="transaction_com_permission" value="Yes" <?php echo ($myKYC->tcp == 'Yes' ? 'checked': '') ?> >  For contacting you via email or mobile phone about this transaction or for security notifications, after the transaction is completed.
															</label>
														</div>
														<br/>
														<div class="checkbox">
															<label>
																<input type="checkbox" name="occasional_com_permission" value="Yes" <?php echo ($myKYC->ocp == 'Yes' ? 'checked': '') ?>>  For occasional email news and updates about Eligma, its products & services, promotions, special offers and events.
															</label>
														</div>
												</div>
												
												<div class="kyc-section">
													<div class="checkbox">
														<label>
															<input type="checkbox" name="data_confirmation" value="Yes">  I have confirmed that the information provided above are mine and are all correct to the best of my knowledge
														</label>
													</div>
														
													<input type="submit" name="submit_KYC_individual" value="Submit" class="btn">
												</div>
											</form>
