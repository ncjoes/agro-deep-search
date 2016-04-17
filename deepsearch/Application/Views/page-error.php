<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: BareBones PHP Framework
 * Date:    10/27/2015
 * Time:    10:46 AM
 */

include_once('header-2.php');
?>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <h1 class="page-header"><?= $page_title; ?></h1>
        <p><?= $data['message']; ?></p>
    </div>
</div>
<?php
include_once("footer.php");
?>