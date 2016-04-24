<?php
/**
 * Phoenix Laboratories NG.
 * Website: phoenixlabsng.com
 * Email:   info@phoenixlabsng.com
 * * * * * * * * * * * * * * * * * * *
 * Project: NwubanFarms.com
 * Author:  J. C. Nwobodo (Fibonacci)
 * Date:    4/18/2016
 * Time:    4:30 PM
 **/
?>
<div class="row">

    <div class="col-md-4">
        <div class="form-group form-group-sm">
            <div class="row">
                <div class="col-xs-6">
                    <label for="setFollowMode">Follow mode</label>
                </div>
                <div class="col-xs-6">
                    <select name="val[setFollowMode]" id="setFollowMode" class="form-control">
                        <option value="0" <?= selected($fields['val']['setFollowMode'], 0) ?>>0 - Follow every link</option>
                        <option value="1" <?= selected($fields['val']['setFollowMode'], 1) ?>>1 - Stay in domain</option>
                        <option value="2" <?= selected($fields['val']['setFollowMode'], 2) ?>>2 - Stay in host</option>
                        <option value="3" <?= selected($fields['val']['setFollowMode'], 3) ?>>3 - Stay in path</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="row">
                <div class="col-xs-6">
                    <label for="setCrawlingDepthLimit">Max. Crawling Depth</label>
                </div>
                <div class="col-xs-6">
                    <input name="val[setCrawlingDepthLimit]" id="setCrawlingDepthLimit" type="number" class="form-control" value="<?= isset($fields['val']['setCrawlingDepthLimit']) ? $fields['val']['setCrawlingDepthLimit'] : '5'; ?>" placeholder="10" max="10" min="1"/>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-4">

        <div class="form-group form-group-sm">
            <div class="row">
                <div class="col-xs-6">
                    <label for="setFollowRedirects">Follow redirects</label>
                </div>
                <div class="col-xs-6">
                    <select name="val[setFollowRedirects]" id="setFollowRedirects" class="form-control">
                        <option value="0" <?= selected($fields['val']['setFollowRedirects'], 0) ?>>No</option>
                        <option value="1" <?= selected($fields['val']['setFollowRedirects'], 1) ?>>Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="row">
                <div class="col-xs-6">
                    <label for="enableCookieHandling">Enable Cookie Handling</label>
                </div>
                <div class="col-xs-6">
                    <select name="val[enableCookieHandling]" id="enableCookieHandling" class="form-control">
                        <option value="0" <?= selected($fields['val']['enableCookieHandling'], 0) ?>>No</option>
                        <option value="1" <?= selected($fields['val']['enableCookieHandling'], 1) ?>>Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="row">
                <div class="col-xs-6">
                    <label for="enableAggressiveLinkSearch">Aggressive Link Extraction</label>
                </div>
                <div class="col-xs-6">
                    <select name="val[enableAggressiveLinkSearch]" id="enableAggressiveLinkSearch" class="form-control">
                        <option value="0" <?= selected($fields['val']['enableAggressiveLinkSearch'], 0) ?>>No</option>
                        <option value="1" <?= selected($fields['val']['enableAggressiveLinkSearch'], 1) ?>>Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="row">
                <div class="col-xs-6">
                    <label for="obeyRobotsTxt">Obey robots.txt</label>
                </div>
                <div class="col-xs-6">
                    <select name="val[obeyRobotsTxt]" id="obeyRobotsTxt" class="form-control">
                        <option value="0" <?= selected($fields['val']['obeyRobotsTxt'], 0) ?>>No</option>
                        <option value="1" <?= selected($fields['val']['obeyRobotsTxt'], 1) ?>>Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="row">
                <div class="col-xs-6">
                    <label for="obeyNoFollowTags">Obey NoFollow Tags</label>
                </div>
                <div class="col-xs-6">
                    <select name="val[obeyNoFollowTags]" id="obeyNoFollowTags" class="form-control">
                        <option value="0" <?= selected($fields['val']['obeyNoFollowTags'], 0) ?>>No</option>
                        <option value="1" <?= selected($fields['val']['obeyNoFollowTags'], 1) ?>>Yes</option>
                    </select>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-4">

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="setRequestLimit">Page/File limit</label>
                    </div>
                    <div class="col-xs-6">
                        <input name="val[setRequestLimit]" id="setRequestLimit" type="number" class="form-control" value="<?= isset($fields['val']['setRequestLimit']) ? $fields['val']['setRequestLimit'] : ''; ?>" placeholder="1000"/>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="setTrafficLimit">Traffic limit (in bytes)</label>
                    </div>
                    <div class="col-xs-6">
                        <input name="val[setTrafficLimit]" id="setTrafficLimit" type="number" class="form-control" value="<?= isset($fields['val']['setTrafficLimit']) ? $fields['val']['setTrafficLimit'] : ''; ?>" placeholder="102400"/>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="setContentSizeLimit">Content Size Limit (in bytes)</label>
                    </div>
                    <div class="col-xs-6">
                        <input name="val[setContentSizeLimit]" id="setContentSizeLimit" type="number" class="form-control" value="<?= isset($fields['val']['setContentSizeLimit']) ? $fields['val']['setContentSizeLimit'] : ''; ?>" placeholder="1024"/>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="setConnectionTimeout">Connection Timeout (in Sec.)</label>
                    </div>
                    <div class="col-xs-6">
                        <input name="val[setConnectionTimeout]" id="setConnectionTimeout" type="number" class="form-control" value="<?= isset($fields['val']['setConnectionTimeout']) ? $fields['val']['setConnectionTimeout'] : ''; ?>" placeholder="30"/>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="setStreamTimeout">Stream Timeout (in Sec.)</label>
                    </div>
                    <div class="col-xs-6">
                        <input name="val[setStreamTimeout]" id="setStreamTimeout" type="number" class="form-control" value="<?= isset($fields['val']['setStreamTimeout']) ? $fields['val']['setStreamTimeout'] : ''; ?>" placeholder="60"/>
                    </div>
                </div>
            </div>
        </div>

</div>
<hr/>
<div class="row">

    <div class="col-md-3">
        <div class="form-group form-group-sm">
            <label for="addContentTypeReceiveRule">Content-types to receive</label>
            <?php
            $options = array("#text/html#", "#text/css#", "#text/javascript#", "#image/gif#", "#image/png#", "#image/jpeg#")
            ?>
            <select name="val[addContentTypeReceiveRule][]" id="addContentTypeReceiveRule" multiple class="form-control height-10vh">
                <?php
                $fields['val']['addContentTypeReceiveRule'] = (isset($fields['val']['addContentTypeReceiveRule']) and is_array($fields['val']['addContentTypeReceiveRule'])) ?
                    $fields['val']['addContentTypeReceiveRule'] : array('#text/html#');
                foreach ($options as $option){
                    ?>
                    <option value="<?= $option; ?>" <?=selected_multi($option, $fields['val']['addContentTypeReceiveRule'])?>><?= strtoupper($option); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group form-group-sm">
            <label for="addURLFollowRule">Link Follow Rules</label>
            <?php
            $options = array('html', 'htm', 'php', 'php3', 'php4', 'php5', 'asp', 'aspx', 'jsp')
            ?>
            <select name="val[addURLFollowRule][]" id="addURLFollowRule" multiple class="form-control height-10vh">
                <?php
                $fields['val']['addURLFollowRule'] = (isset($fields['val']['addURLFollowRule']) and is_array($fields['val']['addURLFollowRule'])) ?
                    $fields['val']['addURLFollowRule'] : array();
                foreach ($options as $option){
                    ?>
                    <option value="<?= $option; ?>" <?=selected_multi($option, $fields['val']['addURLFollowRule'])?>><?= strtoupper($option); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group form-group-sm">
            <label for="addURLFilterRule">Link Filter Rules</label>
            <?php
            $options = array('jpg', 'png', 'gif', 'css', 'js', 'pdf', 'exe', 'apk', 'm4a', 'mp4')
            ?>
            <select name="val[addURLFilterRule][]" id="addURLFilterRule" multiple class="form-control height-10vh">
                <?php
                $fields['val']['addURLFilterRule'] = (isset($fields['val']['addURLFilterRule']) and is_array($fields['val']['addURLFilterRule'])) ?
                    $fields['val']['addURLFilterRule'] : $options;
                foreach ($options as $option){
                    ?>
                    <option value="<?= $option; ?>" <?=selected_multi($option, $fields['val']['addURLFilterRule'])?>><?= strtoupper($option); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group form-group-sm">
            <label for="setLinkExtractionTags">Link Extraction Tags</label>
            <select name="val[setLinkExtractionTags][]" id="setLinkExtractionTags" multiple class="form-control height-10vh">
                <?php
                $fields['val']['setLinkExtractionTags'] = (isset($fields['val']['setLinkExtractionTags']) and is_array($fields['val']['setLinkExtractionTags'])) ?
                    $fields['val']['setLinkExtractionTags'] : array('href');
                ?>
                <option value="href" <?=selected_multi('href', $fields['val']['setLinkExtractionTags'])?>>Anchor HREF Attribute</option>
                <option value="src" <?=selected_multi('src', $fields['val']['setLinkExtractionTags'])?>>Image SRC Attribute</option>
            </select>
        </div>
    </div>
</div>
