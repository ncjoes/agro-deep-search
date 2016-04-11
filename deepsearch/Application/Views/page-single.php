<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: thehouseoflaws.org
 * Date:    2/19/2016
 * Time:    12:42 AM
 **/

include_once('header.php');

$page = $data['item'];
$rel_pages = $data['pages'];
?>
    <div class="row">
        <div class="col-md-6 col-md-offset-1 col-sm-10 col-sm-offset-1">
            <h3 class="page-header full-margin-top full-margin-bottom"><?= $page->getTitle(); ?></h3>
            <div>
                <?= $page->getContent(); ?>
            </div>
        </div>

        <div class="col-md-3 col-md-offset-1 col-sm-10 col-sm-offset-1">
            <div>
                <h4 class="page-header full-margin-top full-margin-bottom">
                    <span class="glyphicon glyphicon-link"></span> <?= isset($data['sidebar-title']) ? $data['sidebar-title'] : 'Related Pages'; ?>
                </h4>
                <?php
                if(is_object($rel_pages) and $rel_pages->size())
                {
                    ?>
                    <ul style="list-style: square">
                        <?php
                        foreach($rel_pages as $rel_page)
                        {
                            ?>
                            <li><a href="<?php home_url("/page/".$rel_page->getGuid())?>" class="navbar-link"><?= $rel_page->getTitle(); ?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<?php include_once("footer.php"); ?>