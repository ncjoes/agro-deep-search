<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: ANPC.NET
 * Date:    1/7/2016
 * Time:    8:11 PM
 **/

namespace System\Models;


interface I_StatefulObject
{
    const STATUS_PENDING = 2;
    const STATUS_APPROVED = 1;
    const STATUS_DELETED = 0;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    const STATUS_STAMPED = 1;
    const STATUS_UNSTAMPED = 2;

    const STATUS_PUBLISHED = 1;
    const STATUS_DRAFT = 2;

    const STATUS_ON = 1;
    const STATUS_OFF = 0;

    const STATUS_VALID = 1;
    const STATUS_CANCELED = 0;

    function getStatus();
    function setStatus($status);
}