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

    <div class="col-md-4">
        <div class="form-group form-group-sm">
            <label for="addContentTypeReceiveRule">Content-types to receive</label>
            <input name="val[addContentTypeReceiveRule]" id="addContentTypeReceiveRule" type="text" class="form-control" value="<?= isset($fields['val']['addContentTypeReceiveRule']) ? $fields['val']['addContentTypeReceiveRule'] : ''; ?>"/>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group form-group-sm">
            <label for="addURLFollowRule">Link Follow Rules</label>
            <input name="val[addURLFollowRule]" id="addURLFollowRule" type="text" class="form-control" value="<?= isset($fields['val']['addURLFollowRule']) ? $fields['val']['addURLFollowRule'] : ''; ?>"/>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group form-group-sm">
            <label for="addURLFilterRule">Link Filter Rules</label>
            <input name="val[addURLFilterRule]" id="addURLFilterRule" type="text" class="form-control" value="<?= isset($fields['val']['addURLFilterRule']) ? $fields['val']['addURLFilterRule'] : ''; ?>" />
        </div>
    </div>
    
</div>
