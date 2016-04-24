<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/24/2016
 * Time:    8:42 PM
 **/

require_once('header-2.php');
$result_set = $data['result-set'];
?>
<div class="row">
    <div class="col-sm-10 col-sm-offset-1">
        <h3 class="page-header">Search Results> <span class="text-success"><?= $data['search-string']; ?></span></h3>
        <?php
        if(sizeof($result_set))
        {
            ?>
            <div class="reader-text">
                <?php
                foreach ($result_set as $result)
                {
                    $main_link = $result['main-link'];
                    $rel_links = $result['rel-links'];
                    ?>
                    <p class="result-group">
                    <a href="<?= $main_link->getUrl(); ?>" target="_blank"><?= $main_link->getAnchor() ?> - <?= $main_link->getPageTitle(); ?></a><br/>
                    <span><?= $main_link->getAroundTextStr('...'); ?></span>
                    <?php
                    if(is_array($rel_links) and sizeof($rel_links)>0)
                    {
                        ?>
                        <br/>Related Sources
                        <ul style="list-style-type: none;">
                            <?php
                            foreach ($rel_links as $link)
                            {
                                ?>
                                <a href="<?= $link->getUrl(); ?>" target="_blank"><?= $link->getAnchor() ?> - <?= $link->getPageTitle(); ?></a>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                    </p>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        else
        {
            ?>
            <p class="lead text-info">No Results found for your search</p>
            <p class="reader-text">Query: <span class="text-danger "><?= $data['search-string']; ?></span></p>
            <?php
        }
        ?>
    </div>
</div>
<?php
require_once("footer.php");
?>