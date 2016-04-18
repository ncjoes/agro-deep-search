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
                <div class="col-xs-5">
                    <label for="setFollowMode">Follow mode</label>
                </div>
                <div class="col-xs-7">
                    <select name="val[setFollowMode]" id="setFollowMode" class="form-control">
                        <option value="0">0 - Follow every link</option>
                        <option value="1">1 - Stay in domain</option>
                        <option value="2">2 - Stay in host</option>
                        <option value="3">3 - Stay in path</option>
                    </select>
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
                        <option value="0" >No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="row">
                <div class="col-xs-6">
                    <label for="setCookieHandling">Enable Cookie Handling</label>
                </div>
                <div class="col-xs-6">
                    <select name="val[setCookieHandling]" id="setCookieHandling" class="form-control">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group form-group-sm">
            <div class="row">
                <div class="col-xs-6">
                    <label for="setAggressiveLinkExtraction">Aggressive Link Extraction</label>
                </div>
                <div class="col-xs-6">
                    <select name="val[setAggressiveLinkExtraction]" id="setAggressiveLinkExtraction" class="form-control">
                        <option value="0" >No</option>
                        <option value="1">Yes</option>
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
                        <option value="0" >No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-4">

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="setPageLimit">Page/File limit</label>
                    </div>
                    <div class="col-xs-6">
                        <input name="val[setPageLimit]" id="setPageLimit" type="number" class="form-control" value="<?= isset($fields['val']['setPageLimit']) ? $fields['val']['setPageLimit'] : ''; ?>" placeholder="1000"/>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="setTrafficLimit">Traffic limit (in KB)</label>
                    </div>
                    <div class="col-xs-6">
                        <input name="val[setTrafficLimit]" id="setTrafficLimit" type="number" class="form-control" value="<?= isset($fields['val']['setTrafficLimit']) ? $fields['val']['setTrafficLimit'] : ''; ?>" placeholder="102400"/>
                    </div>
                </div>
            </div>

            <div class="form-group form-group-sm">
                <div class="row">
                    <div class="col-xs-6">
                        <label for="setContentSizeLimit">Content Size Limit (in KB)</label>
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
            <label for="addReceiveContentType">Content-types to receive</label>
            <span class="help-block">Separate multiple regex entries with new-line</span>
            <textarea name="val[addReceiveContentType]" id="addReceiveContentType" class="form-control height-10vh"><?= isset($fields['val']['addReceiveContentType']) ? $fields['val']['addReceiveContentType'] : ''; ?></textarea>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group form-group-sm">
            <label for="addFollowMatch">Follow matches</label>
            <span class="help-block">Separate multiple regex entries with new-line</span>
            <textarea name="val[addFollowMatch]" id="addFollowMatch" class="form-control height-10vh"><?= isset($fields['val']['addFollowMatch']) ? $fields['val']['addFollowMatch'] : ''; ?></textarea>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group form-group-sm">
            <label for="addNonFollowMatch">Non follow matches</label>
            <span class="help-block">Separate multiple regex entries with new-line</span>
            <textarea name="val[addNonFollowMatch]" id="addNonFollowMatch" class="form-control height-10vh"><?= isset($fields['val']['addNonFollowMatch']) ? $fields['val']['addNonFollowMatch'] : ''; ?></textarea>
        </div>
    </div>
    
</div>
