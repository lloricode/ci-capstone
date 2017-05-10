<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Auth Lang - Cebuano
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
* Description:  English language file for Ion Auth example views
*
*/

// Errors
$lang['error_csrf'] = 'This form post did not pass our security checks.';

// Login
$lang['login_heading']         = 'Sulod';
$lang['login_subheading']      = 'Palihug sulod uban sa imong email/asoy ug password sa ubos.';
$lang['login_identity_label']  = 'Email/Asoy:';
$lang['login_password_label']  = 'Password:';
$lang['login_remember_label']  = 'Hinumdumi Ko:';
$lang['login_submit_btn']      = 'Isumiter';
$lang['login_forgot_password'] = 'Nakalimot ba ka sa imong password??';

// Index
$lang['index_heading']           = 'Mga Tig-gamit';
$lang['index_subheading']        = 'Sa ubos mao ang lista sa mga tig-gamit.';
$lang['index_fname_th']          = 'Pangalan';
$lang['index_lname_th']          = 'Apilido';
$lang['index_email_th']          = 'Email';
$lang['index_groups_th']         = 'Grupo';
$lang['index_status_th']         = 'Istado';
$lang['index_action_th']         = 'Aksyon';
$lang['index_active_link']       = 'Aktibo';
$lang['index_inactive_link']     = 'Dili Aktibo';
$lang['index_create_user_link']  = 'Mag gama ug bag-ong tig-gamit';
$lang['index_create_group_link'] = 'Mag gama ug bag-ong grupo';

// Deactivate User
$lang['deactivate_heading']                  = 'Pagpalong sa tig-gamit';
$lang['deactivate_subheading']               = 'Sigurado nga imong gusto kuhaan ug katungod mugamit ni siya?';
$lang['deactivate_confirm_y_label']          = 'Oo:';
$lang['deactivate_confirm_n_label']          = 'Dili:';
$lang['deactivate_submit_btn']               = 'Isumiter';
$lang['deactivate_validation_confirm_label'] = 'Kumpirmasyon';
$lang['deactivate_validation_user_id_label'] = 'ID sa Tig-gamit';

// Create User
$lang['create_user_heading']                           = 'Mag gama ug Tig-gamit';
$lang['create_user_subheading']                        = 'Palihug ihulad ang impormasyon sa tig-gamit sa ubos.';
$lang['create_user_fname_label']                       = 'Pangalan:';
$lang['create_user_lname_label']                       = 'Apilido:';
$lang['create_user_company_label']                     = 'Kompanya:';
$lang['create_user_identity_label']                    = 'Timailhan:';
$lang['create_user_email_label']                       = 'Email:';
$lang['create_user_phone_label']                       = 'Selpon:';
$lang['create_user_password_label']                    = 'Password:';
$lang['create_user_password_confirm_label']            = 'Pagmatuod sa Password:';
$lang['create_user_submit_btn']                        = 'Isumiter';
$lang['create_user_validation_fname_label']            = 'Pangalan';
$lang['create_user_validation_lname_label']            = 'Apilido';
$lang['create_user_validation_identity_label']         = 'Timailhan';
$lang['create_user_validation_email_label']            = 'Email Address';
$lang['create_user_validation_phone_label']            = 'Selpon';
$lang['create_user_validation_company_label']          = 'Pangalan sa Kompanya';
$lang['create_user_validation_password_label']         = 'Password';
$lang['create_user_validation_password_confirm_label'] = 'Pagmatuod sa Password';

// Edit User
$lang['edit_user_heading']                           = 'Pag-usab sa Tig-gamit';
$lang['edit_user_subheading']                        = 'Palihug ihulad ang impormasyon sa tig-gamit sa ubos.';
$lang['edit_user_fname_label']                       = 'Pangalan:';
$lang['edit_user_lname_label']                       = 'Apilido:';
$lang['edit_user_company_label']                     = 'Pangalan sa Kompanya:';
$lang['edit_user_email_label']                       = 'Email:';
$lang['edit_user_phone_label']                       = 'Selpon:';
$lang['edit_user_password_label']                    = 'Password: (kung mag-usab)';
$lang['edit_user_password_confirm_label']            = 'Pagmatuod sa Password: (kung mag-usab)';
$lang['edit_user_groups_heading']                    = 'Miyembro sa grupo';
$lang['edit_user_submit_btn']                        = 'Tigomon ang Tig-gamit';
$lang['edit_user_validation_fname_label']            = 'Pangalan';
$lang['edit_user_validation_lname_label']            = 'Apilido';
$lang['edit_user_validation_email_label']            = 'Email Address';
$lang['edit_user_validation_phone_label']            = 'Selpon';
$lang['edit_user_validation_company_label']          = 'Pangalan sa Kompanya';
$lang['edit_user_validation_groups_label']           = 'Mga Grupo';
$lang['edit_user_validation_password_label']         = 'Password';
$lang['edit_user_validation_password_confirm_label'] = 'Pagmatuod sa Password';

// Create Group
$lang['create_group_title']                  = 'Pag-gama ug Grupo';
$lang['create_group_heading']                = 'Pag-gama ug Grupo';
$lang['create_group_subheading']             = 'Palihug ihulad ang impormasyon sa grupo sa ubos.';
$lang['create_group_name_label']             = 'Pangalan sa Grupo:';
$lang['create_group_desc_label']             = 'Paghulagway:';
$lang['create_group_submit_btn']             = 'Gamaon ang Grupo';
$lang['create_group_validation_name_label']  = 'Pangalan sa Grupo';
$lang['create_group_validation_desc_label']  = 'Paghulagway';

// Edit Group
$lang['edit_group_title']                  = 'Pag-usab sa Grupo';
$lang['edit_group_saved']                  = 'Ang grupo naapil na sa tigom.';
$lang['edit_group_heading']                = 'Pag-usab sa Grupo';
$lang['edit_group_subheading']             = 'Palihug ihulad ang impormasyon sa grupo sa ubos.';
$lang['edit_group_name_label']             = 'Pangalan sa Grupo:';
$lang['edit_group_desc_label']             = 'Paghulagway:';
$lang['edit_group_submit_btn']             = 'Tigomon ang Grupo';
$lang['edit_group_validation_name_label']  = 'Group Name';
$lang['edit_group_validation_desc_label']  = 'Description';

// Change Password
$lang['change_password_heading']                               = 'Change Password';
$lang['change_password_old_password_label']                    = 'Old Password:';
$lang['change_password_new_password_label']                    = 'New Password (at least %s characters long):';
$lang['change_password_new_password_confirm_label']            = 'Confirm New Password:';
$lang['change_password_submit_btn']                            = 'Change';
$lang['change_password_validation_old_password_label']         = 'Old Password';
$lang['change_password_validation_new_password_label']         = 'New Password';
$lang['change_password_validation_new_password_confirm_label'] = 'Confirm New Password';

// Forgot Password
$lang['forgot_password_heading']                 = 'Forgot Password';
$lang['forgot_password_subheading']              = 'Please enter your %s so we can send you an email to reset your password.';
$lang['forgot_password_email_label']             = '%s:';
$lang['forgot_password_submit_btn']              = 'Submit';
$lang['forgot_password_validation_email_label']  = 'Email Address';
$lang['forgot_password_identity_label'] = 'Identity';
$lang['forgot_password_email_identity_label']    = 'Email';
$lang['forgot_password_email_not_found']         = 'No record of that email address.';
$lang['forgot_password_identity_not_found']         = 'No record of that username.';

// Reset Password
$lang['reset_password_heading']                               = 'Change Password';
$lang['reset_password_new_password_label']                    = 'New Password (at least %s characters long):';
$lang['reset_password_new_password_confirm_label']            = 'Confirm New Password:';
$lang['reset_password_submit_btn']                            = 'Change';
$lang['reset_password_validation_new_password_label']         = 'New Password';
$lang['reset_password_validation_new_password_confirm_label'] = 'Confirm New Password';
