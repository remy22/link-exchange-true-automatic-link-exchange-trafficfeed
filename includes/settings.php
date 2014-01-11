<link href="<?php echo $this->plugin_url?>/css/style.css" rel="stylesheet" />
<?php 
//delete_option('tf_token');
$token = get_option('tf_token'); 

?>
<div class="wrap nosubsub">
  	<h2 class="tf_heading">Trafficfeed Settings</h2>
  	<div id="col-container">
  	<?php 
 
 
	if($token) {?>
	<div>
  		<div class="tf_float_left"><a href="javascript://" id="tf_logout" class="tf_logout">LOGOUT FROM TRAFFICFEED</a></div>
  		<div class="tf_float_left" style="margin-left:10px;"><a href="javascript://"  class="tf_reset">RESET SETTINGS</a></div>
  		<div class="tf_clear"></div>
  	</div>
  <?php } 
	if(!$token ) {?>
		<div id="col-right" >
  			<div class="col-wrap">
    			<div class="form-wrap">
    				<h3>Sign Up to trafficfeed.com</h3>
    				<form method="post" name="frm_tf_reg" id="frm_tf_reg">
    				<div class="frmRegister">
     
				        <div class="form-field form-required">
				          	<label for="tf_first_name">First Name <span>*</span></label>
				        	<input type="text" name="tf_first_name" id="tf_first_name" />
				        	
				        </div>
				       
				        <div class="form-field form-required">
				          	<label for="tf_last_name">Last Name <span>*</span></label>
				          	<input type="text" name="tf_last_name" id="tf_last_name" />
				          	
				        </div>
				      
				        <div class="form-field form-required">
				          	<label for="tf_username">username <span>*</span></label>
				           	<input type="text" name="tf_username" id="tf_username_reg" />
				           	
				        </div>
				       
				        <div class="form-field form-required">
				          	<label for="tf_email">Email <span>*</span></label>
				          	<input type="text" name="tf_email" id="tf_email" />
				        </div>
				      
				        <div class="form-field form-required">
				          <label for="tf_password">Password <span>*</span></label>
				          <input type="password" name="tf_password" id="tf_password_reg" />
				          
				        </div>
				       
				        <div class="form-field form-required">
				          <label for="tf_c_password">Confirm Password <span>*</span></label>
				           <input type="password" name="tf_c_password" id="tf_c_password_reg" />
				          
				        </div>
				       
				        <p class="submit" >
				          <input type="submit" class="button button-primary"  name="tf_btn_register" id="tf_btn_register" value="Sign Up" />
				        </p>
				       
				        <div class="tf_success" style="display:none"></div>
				        <div class="tf_error" style="display:none"></div>
				        
				      
    				</div>
    				</form>
    			</div>
    		</div>
  		</div>
  		<div id="col-left" >
			<div class="col-wrap">
    			<div class="form-wrap">
    				<h3>Login to trafficfeed.com</h3>
    			 	<form method="post" name="frm_tf_login" id="frm_tf_login">
    					<div class="frmLogin ">

				     
					        <div class="form-field form-required">
					        	 <label for="tf_username">Username <span>*</span></label>
					        	 <input type="text" name="tf_username" id="tf_username" />
					        </div>
					        <div  class="form-field form-required">
					        	<label for="tf_password">Password <span>*</span></label> 
					        	<input type="password" name="tf_password" id="tf_password" style="width:98%" />		
					        </div>
					        
					        <p class="submit">
					          <input type="submit" class="button button-primary"  name="tf_btn_login" id="tf_btn_login" value="Login" />
					        </p>
					        <div class="tf_error_msg" style="display:none"></div>
      
    					</div>
    				</form>	
    			</div>
  			</div>
  		</div>
  		<div style="clear:both"></div>
  <?php  } 
if($token) {?>
  
		<div id="col-right" >
			<div class="col-wrap">
    			<div class="form-wrap">
  					<div class="tf_site">
    					<?php $categories = $this->get_tf_categories();
							$categories = json_decode($categories);
						?>
	
    					<h3>Add Site in trafficfeed.com</h3>
    					<?php if($user->is_allow==0) {?>
    					<form method="post" action="" name="tf_add_site" id="tf_add_site">
    						
        
						        <div class="form-field form-required">
						          <label for="title">Site Title <span>*</span></label>
						          <input type="text" name="title" id="title"  class="tf_text">
						          <p>The title for your site.</p>
						        </div>
						      
						        <div class="form-field form-required">
						          <label for="tf_category">Select Category <span>*</span></label>
						           <?php if(count($categories)>0){?>
						          <select name="tf_category" id="tf_category">
						            <option value="">Select Category</option>
						            <?php foreach($categories as $category) {?>
						            <option value="<?php echo $category->id?>"><?php echo $category->name?></option>
						            <?php }?>
						          </select>
						          <p>The category for your site.</p>
						          <?php } ?>
						        </div>
						        
						        <div class="form-field form-required">
						          <label for="domain">Domain Name <span>*</span></label>
						          <input type="text" name="domain" id="domain" class="tf_text">
						           <p>[Ex:www.domain.com]</p>
						        </div>
						      
						        <div  class="form-field form-required">
						          <label for="description">Description <span>*</span></label>
						           <textarea name="description" id="description" rows="5" class="tf_text"></textarea>
						            <p>Write something about your site</p>
						        </div>
						       
						        <p class="submit">
						          <input type="submit" name="btn_domain" id="btn_domain" value="ADD" class="button button-primary">
						        </p>
						        
						          <div id="tf_error" class="tf_error" style="display:none; width:250px"></div>
						          <div id="tf_success" class="tf_success" style="display:none;width:250px"></div>
						        
    						
						</form>
  					</div>
  				</div>
  			</div>
		</div>
		<div id="col-left" >
			<div class="col-wrap">
    			<div class=" ">
  					<div class="tf_user">
   						<h3>Your details</h3>
         
						<?php 
						$user = $this->get_user_info();
						if(count($user)>0){
						?>
		            	<div >
		                	<label class="tf_user_label">Name</label> <div style="tf_float_left"><?php echo $user->name ;?></div>
		                	<div class="tf_clear"></div>
		                </div>
		                
		                
		                <div>
		                	<label class="tf_user_label">Username</label> <div class="tf_float_left"><?php echo $user->username; ?></div>
		                	<div class="tf_clear"></div>
		                </div>
		                <div>
		                	<label class="tf_user_label">Email</label> <div class="tf_float_left"><?php echo $user->email; ?></div>
		                	<div class="tf_clear"></div>
		                </div>
		                <div>
		                	<label class="tf_user_label">Role</label> <div class="tf_float_left"><?php echo $user->role; ?></div>
		                	<div class="tf_clear"></div>
		                </div>
		                 <div>
		                	<label class="tf_user_label">Status</label> <div class="tf_float_left"><?php echo $user->status; ?></div>
		                	<div class="tf_clear"></div>
		                </div>
		                 <div>
		                	<label class="tf_user_label">Blalace</label> <div class="tf_float_left"><?php echo $user->balance; ?></div>
		                	<div class="tf_clear"></div>
		                </div>
		                <div>
		                	<label class="tf_user_label">Earning</label> <div class="tf_float_left"><?php echo $user->earning; ?></div>
		                	<div class="tf_clear"></div>
		                </div>
		                 <div>
		                	<label class="tf_user_label">Added Sites</label> <div class="tf_float_left"><?php echo $user->sites; ?></div>
		                	<div class="tf_clear"></div>
		                </div>
		                <div>
		                	<label class="tf_user_label">Account Status</label> <div class="tf_float_left"><?php echo $user->status; ?></div>
		                	<div class="tf_clear"></div>
		                </div>
 					</div> 
 				</div>
  			</div>	
 	 	</div>
 	 	<div style="clear:both"></div>	              
            <?php 
			}
		?>
  			
  	<?php  } else {?>
    		<div><?php echo $user->message;?></div>
	<?php } ?>
  
  <?php } ?>
	<div <?php if(!$token) {?>class="domain_info "<?php } else {?> class="domain_info "  <?php } ?>>
    <h3>Domain Information</h3>
    <div class="info_padding">
      <div id="domain_status">
        <?php 
			
                if(isset($token) && $token!=""){
                    $response =  json_decode($this->tf_check_domain($token));
				
					switch($response->domain->status){
						case 0:
							echo "<div>Domain is active and verified.</div>";
						break;
						case 1:
							echo "<div>";
							echo "<div>Domain is in-active.<div>";
							echo "<div>To verify please click <a href='javascript:/' class='active_domain'>here</a><div>";
							echo "<div id='domain_act_response'><div>";
							echo "</div>";
						break;
						case 2:
							$msg  ="<div>Your domain is either blocked or suspened.</div>";
							$msg  .="<div>To contact us please click <a href='http://www.trafficfeed.com'>here</a>. </div>";
							echo $msg;
						break;
						case -2:
							echo "<div class='tf_note'>This domain is not linked with your account</div>";
							
						break;
						case 4:
							echo "<div>This domain is not linked with your account</div>";
							
						break;
						case 3:
							echo $response->domain->message;
						break ;
					}
                }else{
                    
                    $response =  json_decode($this->tf_check_domain());
                  
					echo $response->domain->message;
                }
			
            ?>
      </div>
    </div>
	</div>
  
 	</div>
</div>
<div class="result" style="display:none"></div>
