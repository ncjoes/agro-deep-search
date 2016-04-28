<?php
/**
 * Phoenix Laboratories NG.
 * Author:  J. C. Nwobodo (Fibonacci)
 * Email:   phoenixlabs.ng@gmail.com
 * Project: PPSMB-Web
 * Date:    3/28/2016
 * Time:    5:32 AM
 **/

require_once('header-2.php');

$category = $data['item'];
$posts = $data['posts'];
$categories = $data['categories'];
?>
    <div class="row">
        <div class="full-padding-all">
            <h2 class="page-header">
                <span class="glyphicon glyphicon-bullhorn"></span> <?= $data['page-title']; ?>
            </h2>

            <div class="row">
                <div class="col-md-8">
                    <div class="full-margin-top">
                        <h4 class="page-header full-margin-bottom">
                            <span class="glyphicon glyphicon-paste"></span> Recent Posts in <?= $category->getName(); ?>
                        </h4>
                        <?php
                        if(is_object($posts) and $posts->size())
                        {
                            $sn = 1;
                            foreach ($posts as $post)
                            {
                                ?>
                                <div class="row">
                                    <?php
                                    $photo_url = is_object( $post->getFeaturedImage() ) ? $post->getFeaturedImage()->getFullPath() : '#';
                                    ?>
                                    <div class="col-xs-2">
                                        <div class="mid-padding-all text-center">
                                            <p><img src="<?= $photo_url; ?>" class="img-thumbnail img-responsive bg-news"/></p>
                                        </div>
                                    </div>
                                    <div class="col-xs-10">
                                        <h4 class="no-margin mid-margin-bottom"><?= $post->getTitle(); ?></h4>
                                        <div><?= $post->getExcerpt(); ?></div>
                                        <p>
                                            <span class="glyphicon glyphicon-time"></span> <?= getTimeDifference($post->getDateCreated()->getDateTimeInt()); ?> ago.
                                            <a href="<?php home_url("/announcements/".$post->getGuid())?>" class="pull-right btn btn-lg">More &hellip;</a>
                                        </p>
                                    </div>
                                    <?php
                                    ?>
                                </div>
                                <?php
                                if($sn++ < $posts->size()) print "<hr/>";
                            }//end for loop
                        }//IF
                        ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <h4 class="page-header">
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
    </div>
<?php require_once('footer.php');?>