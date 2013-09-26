<link href="<?php echo $this->plugin_url?>/css/style.css" rel="stylesheet" />
<?php 
//delete_option('tf_token');
$token = get_option('tf_token'); 

?>
<div class="wrap">
  <h2 class="tf_heading">Trafficfeed Settings</h2>
  <?php 
 
 
  if($token) {?>
  <div>
  	<div class="tf_float_left"><a href="javascript://" id="tf_logout" class="tf_logout">LOGOUT FROM TRAFFICFEED</a></div>
  	<div class="tf_float_left" style="margin-left:10px;"><a href="javascript://"  class="tf_reset">RESET SETTINGS</a></div>
  	<div class="tf_clear"></div>
  </div>
  <?php } ?>
  <?php 
  if(!$token ) {?>
  <div style="float:left">
    <h3>Login to trafficfeed.com</h3>
    <ul class="frmLogin">
      <form method="post" name="frm_tf_login" id="frm_tf_login">
        <li>Username</li>
        <li>
          <input type="text" name="tf_username" id="tf_username" />
        </li>
        <li>Password</li>
        <li>
          <input type="password" name="tf_password" id="tf_password" />
        </li>
        <li>
          <input type="submit" class="button-primary"  name="tf_btn_login" id="tf_btn_login" value="Login" />
        </li>
        <li class="tf_error_msg" style="display:none"></li>
      </form>
    </ul>
  </div>
  <div style="float:left;margin:0px 10px;" >
    <h3>Sign Up to trafficfeed.com</h3>
    <ul class="frmRegister">
      <form method="post" name="frm_tf_reg" id="frm_tf_reg">
        <li>
          <label class="tf_label_small">First Name <span>*</span></label>
        </li>
        <li>
          <input type="text" name="tf_first_name" id="tf_first_name" />
        </li>
        <li>
          <label class="tf_label_medium">Last Name <span>*</span></label>
        </li>
        <li>
          <input type="text" name="tf_last_name" id="tf_last_name" />
        </li>
        <div class="tf_clear"></div>
        <li>
          <label class="tf_label_small">username <span>*</span></label>
        </li>
        <li>
          <input type="text" name="tf_username" id="tf_username_reg" />
        </li>
        <li>
          <label class="tf_label_medium">Email <span>*</span></label>
        </li>
        <li>
          <input type="text" name="tf_email" id="tf_email" />
        </li>
        <div class="tf_clear"></div>
        <li>
          <label class="tf_label_small">Password <span>*</span></label>
        </li>
        <li>
          <input type="password" name="tf_password" id="tf_password_reg" />
        </li>
        <li>
          <label class="tf_label_medium">Confirm Password <span>*</span></label>
        </li>
        <li>
          <input type="password" name="tf_c_password" id="tf_c_password_reg" />
        </li>
        <div class="tf_clear"></div>
        <li>
          <input type="submit" class="button-primary"  name="tf_btn_register" id="tf_btn_register" value="Sign Up" />
        </li>
        <div class="tf_clear"></div>
        <li class="tf_success" style="display:none"></li>
        <li class="tf_error" style="display:none"></li>
        <div class="tf_clear"></div>
      </form>
    </ul>
  </div>
  <div style="clear:both"></div>
  <?php  } ?>
  <?php if($token) {?>
   <div class="tf_user">
   		 <h3>Your details</h3>
         
		<?php 
			$user = $this->get_user_info();
			if(count($user)>0){
			?>
            	<div>
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
                
            <?php 
			}
		?>
   </div>
  <div class="tf_site">
    <?php $categories = $this->get_tf_categories();
		$categories = json_decode($categories);
		
	?>
    <h3>Add Site in trafficfeed.com</h3>
    <?php if($user->is_allow==0) {?>
    		<form method="post" action="" name="tf_add_site" id="tf_add_site">
      <ul>
        
        <li>
          <label>Site Title <span>*</span></label>
        </li>
        <li>
          <input type="text" name="title" id="title"  class="tf_text">
        </li>
        <li>
          <label>Select Category <span>*</span></label>
        </li>
        <li>
          <?php if(count($categories)>0){?>
          <select name="tf_category" id="tf_category">
            <option value="">Select Category</option>
            <?php foreach($categories as $category) {?>
            <option value="<?php echo $category->id?>"><?php echo $category->name?></option>
            <?php }?>
          </select>
          <?php } ?>
        </li>
        <li>
          <label>Domain Name <span>*</span>[Ex:www.domain.com]</label>
        </li>
        <li>
          <input type="text" name="domain" id="domain" class="tf_text">
        </li>
        <li>
          <label class="tf_">Description <span>*</span></label>
        </li>
        <li>
          <textarea name="description" id="description" rows="5" class="tf_text"></textarea>
        </li>
        <li style="margin:10px 0px;">
          <input type="submit" name="btn_domain" id="btn_domain" value="ADD" class="button-primary">
        </li>
        <li>
          <div id="tf_error" class="tf_error" style="display:none; width:250px"></div>
          <div id="tf_success" class="tf_success" style="display:none;width:250px"></div>
        </li>
      </ul>
    </form>
  	<?php  } else {?>
    		<div><?php echo $user->message;?></div>
	<?php } ?>
  </div>
  <?php } ?>
  <div <?php if(!$token) {?>class="domain_info "<?php } else {?> class="domain_info " style="float:left" <?php } ?>>
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
  
  <div style="clear:both"></div>
</div>
<div class="result" style="display:none"></div>
