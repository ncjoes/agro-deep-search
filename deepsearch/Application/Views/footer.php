<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: E-Stamp
 * Date: 10/4/2015
 * Time: 6:43 PM
 */

$data = $rc->getResponseData();
$about_pages = $data['footer']['about-pages'];
$recent_posts = $data['footer']['recent-posts'];
?>
        </div><!--/container-fluid-->
    </div><!--//inner-body-wrapper-->
</div><!--//outer-body-wrapper-->

<!-- Bootstrap core JavaScript -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php home_url('/Assets/js/jquery.min.js'); ?>"></script>
<script src="<?php home_url('/Assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php home_url('/Assets/js/barebones.js'); ?>"></script>

</body>
</html>