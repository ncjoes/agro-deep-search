<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: PPSMB-Enugu Website
 * Date:    4/7/2016
 * Time:    8:06 PM
 **/

namespace Application\Controllers;


use Application\Models\UserPrivilege;
use Application\Models\User;
use Application\Models\Upload;
use Application\Utilities\AccessManager;
use System\Request\RequestContext;
use System\Utilities\DateTime;
use System\Utilities\UploadHandler;

class MyAccount_Controller extends A_UserCommands_Controller
{
    public function execute(RequestContext $requestContext)
    {
        $allowed_users = array(UserPrivilege::UT_ADMIN, UserPrivilege::UT_EDITOR);
        if($this->securityPass($requestContext, $allowed_users, 'admin-panel'))
        {
            parent::execute($requestContext);
        }
    }

    protected function doExecute(RequestContext $requestContext)
    {
        $data['page-title'] = "My Account";
        $data['user'] = $requestContext->getSession()->getUser();

        $requestContext->setResponseData($data);
        $requestContext->setView('my-account/default.php');
    }

    protected function EditProfile(RequestContext $requestContext)
    {
        $data = array();
        $data['user'] = $user = $requestContext->getSession()->getUser();
        $data['page-title'] = "Update Profile - My Account";

        $fields = array();
        $fields['photo'] = is_object( $user->getPhoto() ) ? $user->getPhoto()->getFullPath() : "/Assets/images/faceless.png";
        $fields['title'] = $user->getTitle();
        $fields['first-name'] = $user->getFirstName();
        $fields['middle-name'] = $user->getMiddleName();
        $fields['last-name'] = $user->getLastName();
        $fields['email'] = $user->getEmail();
        $fields['phone'] = $user->getPhone();
        $fields['address1'] = $user->getAddress1();
        $fields['address2'] = $user->getAddress2();
        $fields['city'] = $user->getCity();
        $fields['zip_code'] = $user->getZipCode();
        $fields['state'] = $user->getState();
        $fields['country'] = $user->getCountry();
        $fields['biography'] = $user->getBiography();
        $data['fields'] = $fields;

        if($requestContext->fieldIsSet('save-changes', INPUT_POST))
        {
            $fields = array_merge($data['fields'], $requestContext->getAllFields(INPUT_POST));

            $photo = !empty($_FILES['photo']['name']) ? $requestContext->getFile('photo') : null;
            $title = $fields['title'];
            $first_name = $fields['first-name'];
            $middle_name = $fields['middle-name'];
            $last_name = $fields['last-name'];
            $email = $fields['email'];
            $phone = $fields['phone'];
            $address1 = $fields['address1'];
            $address2 = $fields['address2'];
            $city = $fields['city'];
            $zip_code = $fields['zip_code'];
            $state = $fields['state'];
            $country = $fields['country'];
            $biography = $fields['biography'];

            if(
                strlen($first_name)
                and strlen($last_name)
                and validate_email($email)
                and validate_phone($phone)
            )
            {
                $unique_mail = true; //assume email is unique
                $unique_phone = true; //assume phone is unique
                $photo_handled = true; //assume there is no need for image upload processing

                //do some checks for unique email and phone
                $u1 = User::getMapper('User')->findByEmail($email);
                if(is_object($u1) and $u1->getId() != $user->getId()) $unique_mail = false;
                $u2 = User::getMapper('User')->findByPhone($phone);
                if(is_object($u2) and $u2->getId() != $user->getId()) $unique_phone = false;

                if($unique_mail and $unique_phone)
                {
                    if(!is_null($photo))
                    {
                        //Handle photo upload
                        $photo_handled = false;
                        $uploader = new UploadHandler('photo', uniqid('p'));
                        $uploader->setAllowedExtensions(array('jpg'));
                        $uploader->setUploadDirectory("Uploads/staff-photos");
                        $uploader->setMaxUploadSize(0.15); //~150KB
                        $uploader->doUpload();

                        if($uploader->getUploadStatus())
                        {
                            if(is_object($user->getPhoto()))
                            {
                                $user->getPhoto()->mapper()->delete($user->getPhoto());
                            }
                            $photo = new Upload();
                            $photo->setAuthor($requestContext->getSession()->getUser());
                            $photo->setUploadTime(new DateTime());
                            $photo->setLocation($uploader->getUploadDirectory());
                            $photo->setFileName($uploader->getOutputFileName().".".$uploader->getFileExtension());
                            $photo->setFileSize($uploader->getFileSize());
                            $photo->setStatus(Upload::STATUS_VALID);
                            $photo->mapper()->insert($photo);

                            $photo_handled = true;
                        }
                        else
                        {
                            $data['status'] = false;
                            $requestContext->setFlashData("Error Uploading Photo - ".$uploader->getStatusMessage());
                        }
                    }

                    if($photo_handled)
                    {
                        if(is_object($photo)) $user->setPhoto($photo);
                        $user->setTitle($title);
                        $user->setFirstName($first_name)->setMiddleName($middle_name)->setLastName($last_name);
                        $user->setEmail($email)->setPhone($phone);
                        $user->setAddress1($address1)->setAddress2($address2)->setCity($city)->setZipCode($zip_code);
                        $user->setState($state)->setCountry($country);
                        $user->setBiography($biography);

                        $fields['photo'] = $user->getPhoto()->getFullPath();

                        //set status text
                        $data['status'] = 1;
                        $requestContext->setFlashData("Profile updated successfully");
                    }
                }
                else{
                    $user->markClean();
                    $m = array();
                    if(!$unique_mail){
                        $m[] = "Email {$email} is already in use by another staff";
                    }
                    if(!$unique_phone){
                        $m[] = "Phone number {$phone} is already in use by another staff";
                    }
                    $requestContext->setFlashData(implode("<br/>", $m));
                    $data['status'] = 0;
                }
            }
            else
            {
                $requestContext->setFlashData('Please fill out all mandatory fields with valid data');
                $data['status'] = 0;
            }
            $data['fields'] = $fields;
        }

        $requestContext->setResponseData($data);
        $requestContext->setView('my-account/profile-editor.php');
    }

    protected function ChangePassword(RequestContext $requestContext)
    {
        $data = array();
        $data['user'] = $user = $requestContext->getSession()->getUser();
        $data['page-title'] = "Change Password - My Account";

        if($requestContext->fieldIsSet('change-password', INPUT_POST))
        {
            $fields = $requestContext->getAllFields(INPUT_POST);

            $old_password = $fields['old-password'];
            $password1 = $fields['password1'];
            $password2 = $fields['password2'];

            if(
                strcmp(AccessManager::hashString($old_password), $user->getPassword()) == 0
                and strlen($password1) >= 8 and strcmp($password1, $password2) == 0
            )
            {
                $user->setPassword(AccessManager::hashString($password1));

                //set status text
                $data['status'] = 1;
                $requestContext->setFlashData("Password changed successfully");
            }
            else
            {
                $m = array();
                if(strcmp(AccessManager::hashString($old_password), $user->getPassword()) != 0){
                    $m[] = "Incorrect Old Password";
                }
                if(strlen($password1) < 8){
                    $m[] = "New Password is too short.";
                }
                if(strcmp($password1, $password2) != 0){
                    $m[] = "Please confirm the new password.";
                }
                $requestContext->setFlashData(implode("<br/>", $m));
                $data['status'] = 0;
            }
        }

        $requestContext->setResponseData($data);
        $requestContext->setView('my-account/password-editor.php');
    }
}