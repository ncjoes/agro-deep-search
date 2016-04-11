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
    }

    public function send(RequestContext $requestContext)
    {
        $requestContext->setView('page-contact.php');
        $response_status = false;

        $fields = $requestContext->getAllFields(INPUT_POST);
        $names = $fields['names'];
        $email = $fields['email'];
        $phone = $fields['phone'];
        $company = $fields['company'];
        $address = $fields['address'];
        $text = "Company: ".$company."\nAddress: ".$address."\nPhone: ".$phone."\n\nMessage\n".$fields['message'];
        $message = wordwrap(str_replace('\n.', '\n..',$text), 70);
        $send_to = site_info('contact_email', false);

        if(mail($send_to, "Website Message From: {$names}", $message, "From: {$names}<{$email}>\r\n"))
        {
            $response_status = true;
        }
        $requestContext->setResponseData(array('content'=>"", 'status'=>$response_status));
    }
}