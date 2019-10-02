<!-- Forgot Password up start -->
<div id="forgotPassword" class="popup">
    <a href="#" class="close">
        <img src="<?php echo base_url(); ?>images/popup-close-btn.png" class="btn_close_rdPop" title="Close Window" alt="Close" />
    </a>
    <div class="popup_area">
        <div class="deals_popup pop_mrg_lft">
            <div class="login">
                <div class="login_contain">
                    <h1>Forgot Password</h1>
                    <form name="login" id="forgotPaasowrdForm" method="post" action=""  >
                        <div class="login_box">
                            <div class="login_field">
                                <label class="usr">Email :</label>
                                <input type="text" class="validate[required,custom[email]]  txt_field" name="user_name" id="user_name"  />
                            </div>
                             
                            <a href="javascript:void(0)" class="forgot_password login_btn">
                                submit
                            </a>
                        </div>
                        <br style="clear:both;">
                        <div style="float:left;margin:0 0 0 80px; display:none;" class="error_div_forgot_password" ></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Pop up End -->

<!-- Login Pop up start -->
<div id="LoginPopUpRestaurantOwner" class="popup">
    <a href="#" class="close">
        <img src="<?php echo base_url(); ?>images/popup-close-btn.png" class="btn_close_rdPop" title="Close Window" alt="Close" />
    </a>
    <div class="popup_area">
        <div class="deals_popup pop_mrg_lft">
            <div class="login">
                <div class="login_contain">
                    <h1>Login</h1>
                    <form name="login" id="formID" method="post" action=""  >
                        <div class="login_box">
                            <div class="login_field">
                                <label class="usr">Email :</label>
                                <input type="text" class="validate[required,custom[email]]  txt_field" name="user_name" id="user_name"  />
                            </div>
                            <div class="login_field">
                                <label class="usr">Password :</label>
                                <input type="password" class="validate[required] txt_field" name="password" id="password" />
                            </div>
                            <a href="javascript:void(0)" class="login_restaurant_owner login_btn add_login_restaurant_owner">
                                submit
                            </a>
                            <a href="javascript:void(0)" onclick="popUpForgotPasswid();" class="login_btn" style="margin-left:35px;">
                                Forgot Password
                            </a>
                        </div>
                        <br style="clear:both;">
                        <div style="float:left;margin:20px 0 0 80px; display:none;" class="error_div" ></div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Login Pop up End -->
 



</div>
</body>
</html>

