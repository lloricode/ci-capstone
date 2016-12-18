<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - Filipino
*
* Author: Ben Edmunds
*         ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  Filipino language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful']            = 'Ang account ay nagawa na';
$lang['account_creation_unsuccessful']          = 'Hindi magawa ang account';
$lang['account_creation_duplicate_email']       = 'Ang Email ang nagamit na o kaya ay invalid';
$lang['account_creation_duplicate_identity']    = 'Identity Already Used or Invalid';
$lang['account_creation_missing_default_group'] = 'Ang default group ay hndi na-set';
$lang['account_creation_invalid_default_group'] = 'Invalid ang default na ngalan sa grupo';


// Password
$lang['password_change_successful']          = 'Ang Password ay napalitan na';
$lang['password_change_unsuccessful']        = 'Hindi mapalitan ang password';
$lang['forgot_password_successful']          = 'Password Reset Email ay na Send na';
$lang['forgot_password_unsuccessful']        = 'Hindi ma-reset ang password';

// Activation
$lang['activate_successful']                 = 'Account Activated';
$lang['activate_unsuccessful']               = 'Hndi Activated ang account';
$lang['deactivate_successful']               = 'Account De-Activated';
$lang['deactivate_unsuccessful']             = 'Hindi ma De-Activate ang Account';
$lang['activation_email_successful']         = 'Activation Email Sent. Paki check sa spam folder';
$lang['activation_email_unsuccessful']       = 'Hindi masend ang activation email';

// Login / Logout
$lang['login_successful']                    = 'Logged In Successfully';
$lang['login_unsuccessful']                  = 'Incorrect Login';
$lang['login_unsuccessful_not_active']       = 'Account is inactive';
$lang['login_timeout']                       = 'Temporarily Locked Out.  Try again later.';
$lang['logout_successful']                   = 'Logged Out Successfully';

// Account Changes
$lang['update_successful']                   = 'Account Information ay nabago na!';
$lang['update_unsuccessful']                 = 'Hindi ma-update Account Information';
$lang['delete_successful']                   = 'User Deleted';
$lang['delete_unsuccessful']                 = 'Hindi ma-delete ang user';

// Groups
$lang['group_creation_successful']           = 'Ang grupo ay nagawa na';
$lang['group_already_exists']                = 'Ang ngalan sa grupo ay nagamit na';
$lang['group_update_successful']             = 'Ang detalye sa grupo ay nabago na';
$lang['group_delete_successful']             = 'Ang grupo ay natanggal na';
$lang['group_delete_unsuccessful']           = 'Hindi maalis ang grupo';
$lang['group_delete_notallowed']             = 'Hindi pwdi ma-delete ang administraot group';
$lang['group_name_required']                 = 'Ang ngalan sa grupo ay kinakailangan';
$lang['group_name_admin_not_alter']          = 'Ang ngalan sa grupo ng Admin ang hndi dapat na mapalitan.';

// Activation Email
$lang['email_activation_subject']            = 'Account Activation';
$lang['email_activate_heading']              = 'Activate account for %s';
$lang['email_activate_subheading']           = 'aki click ang link na ito %s.';
$lang['email_activate_link']                 = 'Activate Your Account';

// Forgot Password Email
$lang['email_forgotten_password_subject']    = 'Nalimutan ang verification sa password';
$lang['email_forgot_password_heading']       = 'RBagong Password para sa %s';
$lang['email_forgot_password_subheading']    = 'Paki click ang link na ito %s.';
$lang['email_forgot_password_link']          = 'I-reset ang iyong Password';

// New Password Email
$lang['email_new_password_subject']          = 'Bagong Password';
$lang['email_new_password_heading']          = 'Bagong Password para sa %s';
$lang['email_new_password_subheading']       = 'Ang iyong password ay na reset sa: %s';
