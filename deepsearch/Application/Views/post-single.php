<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: TheHouseOfLaws.ORG
 * Date:    2/23/2016
 * Time:    9:48 AM
 **/

include_once('header.php');

$section = $data['item'];
$rel_posts = $data['posts'];
$categories = $data['categories'];
?>
    <div class="row">
        <div class="col-md-6 col-md-offset-1 col-sm-10 col-sm-offset-1">
            <h3 class="page-header full-margin-top full-margin-bottom"><?= $section->getTitle(); ?></h3>
            <?php
            if(is_object( $section->getFeaturedImage() ))
            {
                ?>
                <p>
                    <img src="<?php home_url("/".$section->getFeaturedImage()->getFullPath()); ?>" class="img-thumbnail img-responsive" style="width: 100%; height: auto; max-height: 260px;"/>
                </p>
                <?php
            }
            ?>
            <div>
                <?= $section->getContent(); ?>
            </div>
            <p class="text-right">
                <span class="glyphicon glyphicon-time"></span> <?= getTimeDifference($section->getDateCreated()->getDateTimeInt()); ?> ago.

                <a href="<?php home_url("/".$rc->getRequestUrlParam(0)."/category/".$section->getCategory()->getGuid())?>">
                    <span class="glyphicon glyphicon-tag"></span> &nbsp;<?= $section->getCategory()->getName(); ?>
                </a>
            </p>
        </div>

        <div class="col-md-3 col-md-offset-1 col-sm-10 col-sm-offset-1">
            <div>
                <h4 class="page-header full-margin-top full-margin-bottom">
                    <span class="glyphicon glyphicon-tag"></span> <?= is_object($section->getCategory()) ? $section->getCategory()->getName() : 'In the same category'; ?>
                </h4>
                <?php
                if(is_object($rel_posts) and $rel_posts->size())
                {
                    ?>
                    <ul style="list-style: square">
                        <?php
                        foreach($rel_posts as $category)
                        {
                            ?>
                            <li>
                                <a href="<?php home_url("/".$rc->getRequestUrlParam(0)."/".$category->getGuid())?>">
                                    <?= $category->getTitle(); ?>
                                </a>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                    <?php
                }
                ?>
            </div>
            <div>
                <h4 class="page-header full-margin-bottom">
                    <span class="glyphicon glyphicon-tags"></span> &nbsp;&nbsp;Other Categories
                </h4>
                <?php
                if(is_object($categories) and $categories->size())
                {
                    ?>
                    <ul style="list-style: square">
                        <?php
                        foreach($categories as $category)
                        {
                            ?>
                            <li>
                                <a href="<?php home_url("/".$rc->getRequestUrlParam(0)."/category/".$category->getGuid())?>">
                                    <?= $category->getName(); ?>
                                </a>
                            </li>
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