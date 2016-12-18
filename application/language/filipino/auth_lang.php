<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - filipino
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Author: Daniel Davis
*         @ourmaninjapan
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.09.2013
*
* Description:  Filipino language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'Ang iyong request ay hindi pumasa  sa aming seguridad.';

// Login
$lang['login_heading']         = 'Mag-login';
$lang['login_subheading']      = 'Paki login ang iyong email/username at password sa ibaba.';
$lang['login_identity_label']  = 'Email/Username:';
$lang['login_password_label']  = 'Password:';
$lang['login_remember_label']  = 'Tandaan Ako:';
$lang['login_submit_btn']      = 'Mag-Login';
$lang['login_forgot_password'] = 'Nalimutan ang password?';

// Index
$lang['index_heading']           = 'Mga User';
$lang['index_subheading']        = 'Below is a list of the users.';
$lang['index_fname_th']          = 'Pangalan';
$lang['index_lname_th']          = 'Apilyido';
$lang['index_email_th']          = 'Email';
$lang['index_groups_th']         = 'Grupo';
$lang['index_status_th']         = 'Istatus';
$lang['index_action_th']         = 'Paraan';
$lang['index_active_link']       = 'Aktibo';
$lang['index_inactive_link']     = 'Hindi Aktibo';
$lang['index_create_user_link']  = 'Gumawa ng bagong user';
$lang['index_create_group_link'] = 'Gumawa ng bagong groupo';

// Deactivate User
$lang['deactivate_heading']                  = 'I-dedaktib User';
$lang['deactivate_subheading']               = 'Sigurado ka bang idedaktib itong user \'%s\'';
$lang['deactivate_confirm_y_label']          = 'Oo:';
$lang['deactivate_confirm_n_label']          = 'Hindi:';
$lang['deactivate_submit_btn']               = 'Isabmit';
$lang['deactivate_validation_confirm_label'] = 'kompirmado';
$lang['deactivate_validation_user_id_label'] = 'user ID';

// Create User
$lang['create_user_heading']                           = 'Gumawa ng User';
$lang['create_user_subheading']                        = 'Paki Lagyan ng mga impormasyon ng user';
$lang['create_user_fname_label']                       = 'Pangalan:';
$lang['create_user_lname_label']                       = 'Apilyido:';
$lang['create_user_company_label']                     = 'Ngalan sa kompanya:';
$lang['create_user_identity_label']                    = 'Identity:';
$lang['create_user_email_label']                       = 'Email:';
$lang['create_user_phone_label']                       = 'Telepono:';
$lang['create_user_password_label']                    = 'Password:';
$lang['create_user_password_confirm_label']            = 'Ikompirm Password:';
$lang['create_user_submit_btn']                        = 'Gawan ng User';
$lang['create_user_validation_fname_label']            = 'Pangalan';
$lang['create_user_validation_lname_label']            = 'Apilyido';
$lang['create_user_validation_identity_label']         = 'Identity';
$lang['create_user_validation_email_label']            = 'Email Address';
$lang['create_user_validation_phone_label']            = 'Telepono';
$lang['create_user_validation_company_label']          = 'Ngalan ng kompanya';
$lang['create_user_validation_password_label']         = 'Password';
$lang['create_user_validation_password_confirm_label'] = 'Password ikompirm';

// Edit User
$lang['edit_user_heading']                           = 'I-edit ang User';
$lang['edit_user_subheading']                        = 'Paki lagyan ng informasyon para sa user.';
$lang['edit_user_fname_label']                       = 'Pangalan:';
$lang['edit_user_lname_label']                       = 'Apilyido:';
$lang['edit_user_company_label']                     = 'Ngalan sa kompanya:';
$lang['edit_user_email_label']                       = 'Email:';
$lang['edit_user_phone_label']                       = 'Telepono:';
$lang['edit_user_password_label']                    = 'Password: (kung papalitan ang password)';
$lang['edit_user_password_confirm_label']            = 'Ikompirm ang Password: (if changing password)';
$lang['edit_user_groups_heading']                    = 'Myembro sa grupo';
$lang['edit_user_submit_btn']                        = 'I-save ang User';
$lang['edit_user_validation_fname_label']            = 'Pangalan';
$lang['edit_user_validation_lname_label']            = 'Apilyido';
$lang['edit_user_validation_email_label']            = 'Email Address';
$lang['edit_user_validation_phone_label']            = 'Telepono';
$lang['edit_user_validation_company_label']          = 'Ngalan sa kompanya';
$lang['edit_user_validation_groups_label']           = 'Groupo';
$lang['edit_user_validation_password_label']         = 'Password';
$lang['edit_user_validation_password_confirm_label'] = 'Password kompirmasyon';

// Create Group
$lang['create_group_title']                  = 'Gumawa ng Grupo';
$lang['create_group_heading']                = 'Gumawa ng Grupo';
$lang['create_group_subheading']             = 'Paki lagyna ng mga impormasyong ng grupo.';
$lang['create_group_name_label']             = 'Ngalan sa grupo:';
$lang['create_group_desc_label']             = 'deskripsyon sa grupo:';
$lang['create_group_submit_btn']             = 'Gumawa ng Grupo';
$lang['create_group_validation_name_label']  = 'Ngalan sa grupo';
$lang['create_group_validation_desc_label']  = 'deskripsyon sa grupo';

// Edit Group
$lang['edit_group_title']                  = 'I-edit ang Grupo';
$lang['edit_group_saved']                  = 'I-seyb ang grupo';
$lang['edit_group_heading']                = 'I-edit ang grupo';
$lang['edit_group_subheading']             = 'Paki lagyna ng mga impormasyong ng grupo.';
$lang['edit_group_name_label']             = 'Ngalan sa grupo:';
$lang['edit_group_desc_label']             = 'deskripsyon sa grupo:';
$lang['edit_group_submit_btn']             = 'I-seyb ang grupo';
$lang['edit_group_validation_name_label']  = 'Ngalan sa grupo';
$lang['edit_group_validation_desc_label']  = 'deskripsyon sa grupo';

// Change Password
$lang['change_password_heading']                               = 'Palitan ang Password';
$lang['change_password_old_password_label']                    = 'Lumang Password:';
$lang['change_password_new_password_label']                    = 'Bagong Password (dapat nasa %s pataas ang karakter):';
$lang['change_password_new_password_confirm_label']            = 'Ikompirm ang bagong Password:';
$lang['change_password_submit_btn']                            = 'Palitan';
$lang['change_password_validation_old_password_label']         = 'Lumang Password';
$lang['change_password_validation_new_password_label']         = 'Bagong Password';
$lang['change_password_validation_new_password_confirm_label'] = 'Ikompirm ang bagong Password';

// Forgot Password
$lang['forgot_password_heading']                 = 'NAlimitan ang Password';
$lang['forgot_password_subheading']              = 'paki lagaya ang iyong %s, para ma-send ang reset password';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Submit';
$lang['forgot_password_validation_email_label']  = 'Email Address';
$lang['forgot_password_identity_label'] = 'Identity';
$lang['forgot_password_email_identity_label']    = 'Email';
$lang['forgot_password_email_not_found']         = 'Wla kaming nahagilap sa email na tinutukoy mo.';

// Reset Password
$lang['reset_password_heading']                               = 'Palitan Password';
$lang['reset_password_new_password_label']                    = 'Bagong Password (dapat nasa %s pataas ang karakter):';
$lang['reset_password_new_password_confirm_label']            = 'CIkompirm ang bagong Passwor';
$lang['reset_password_submit_btn']                            = 'Palitan';
$lang['reset_password_validation_new_password_label']         = 'Bagong Password';
$lang['reset_password_validation_new_password_confirm_label'] = 'Ikompirm ang bagong Password';
