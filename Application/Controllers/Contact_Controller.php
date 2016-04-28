<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    11:29 AM
 */

namespace Application\Controllers;

use System\Request\RequestContext;

class Contact_Controller extends A_Controller
{
    protected function doExecute(RequestContext $requestContext)
    {
        $requestContext->setView('page-contact.php');
        $requestContext->setResponseData(array('page-title'=>"Contact Us",'content'=>"", 'status'=>null));

        if($requestContext->fieldIsSet('send', INPUT_POST)) $this->sendMail($requestContext);
    }

    private function sendMail(RequestContext $requestContext)
    {
        $requestContext->setView('page-contact.php');
        $response_status = false;

        $fields = $requestContext->getAllFields(INPUT_POST);
        $subject = $fields['subject'];
        $names = $fields['name'];
        $email = $fields['email'];
        $phone = $fields['phone'];
        $text = "Subject: ".$subject."\r\nName: ".$names."\r\nPhone: ".$phone."\r\n\r\nMessage\r\n".$fields['message'];
        $message = wordwrap(str_replace('\n.', '\n..',$text), 70);
        $send_to = site_info('contact-email', false);

        if(mail($send_to, "Website Message From: {$names}", $message, "From: {$names}<{$email}>\r\n"))
        {
            $response_status = true;
            $requestContext->setFlashData("Your message has been delivered successfully. We shall be in touch with you soon.");
        }
        $requestContext->setResponseData(array('status'=>$response_status));
    }
}