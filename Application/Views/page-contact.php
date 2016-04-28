<?php
/**
 * Phoenix Laboratories NG.
 * Author: J. C. Nwobodo (phoenixlabs.ng@gmail.com)
 * Project: RBHCISTD
 * Date:    1/19/2016
 * Time:    11:25 PM
 **/

include_once('header-2.php');

$fields = $requestContext->getAllFields(INPUT_POST);
?>
    <form method="post" enctype="multipart/form-data" action="<?php home_url('/contact/send/'); ?>">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <h2 class="page-header"><span class="glyphicon glyphicon-envelope"></span> Get in touch with us</h2>
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="page-header tiny-margin-top">Contact Details</h3>
                        <p class="lead">Our doors are always open</p>
                        <p>
                            <b><span class="glyphicon glyphicon-home"></span> Head-quarters</b><br/>
                            <?php site_info('office-address'); ?>
                        </p>
                        <div class="row">
                            <div class="col-sm-6">
                                <b><span class="glyphicon glyphicon-phone"></span> Phone:</b><br/>
                                <a href="tel:<?php site_info('contact-phone'); ?>"><?php site_info('contact-phone'); ?></a>
                            </div>
                            <div class="col-sm-6">
                                <b><span class="glyphicon glyphicon-envelope"></span> Email:</b><br/>
                                <a href="mailto:<?php site_info('contact-email'); ?>"><?php site_info('contact-email'); ?></a>
                            </div>
                        </div>
                        <hr/>
                        <div class="text-center">
                            <p><b><span class="glyphicon glyphicon-link"></span> Connect with us</b></p>
                            <p class="btn-group btn-group-sm">
                                <a href="<?php site_info('facebook-page'); ?>" class="btn btn-default" target="_blank" title="<?php site_info('name'); ?> on Facebook">
                                    <img src="<?php home_url('/Assets/icons/fb.png'); ?>" style="height: 2em; width: auto">
                                </a>
                                <a href="<?php site_info('youtube-channel'); ?>" class="btn btn-default" target="_blank" title="<?php site_info('name'); ?> on Youtube">
                                    <img src="<?php home_url('/Assets/icons/youtube.png'); ?>" style="height: 2em; width: auto">
                                </a>
                                <a href="<?php site_info('google-plus'); ?>" class="btn btn-default" target="_blank" title="<?php site_info('name'); ?> on Google+">
                                    <img src="<?php home_url('/Assets/icons/gp.png'); ?>" style="height: 2em; width: auto">
                                </a>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h4 class="page-header">We value your comments and feedback</h4>
                        <?php if(isset($data['status'])){ ?><div class="text-center mid-margin-bottom lead <?= $data['status'] ? 'text-success bg-success' : 'text-danger bg-danger';?>"><?= $requestContext->getFlashData(); ?></div><?php } ?>
                        <div class="form-group form-group-sm">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="subject"><span class="glyphicon glyphicon-flag"></span> Subject</label>
                                </div>
                                <div class="col-md-9">
                                    <input name="subject" id="subject" required type="text" class="form-control" placeholder="Subject of discussion" value="<?= isset($fields['subject'])?$fields['subject']:'';?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="name"><span class="glyphicon glyphicon-user"></span> Name</label>
                                </div>
                                <div class="col-md-9">
                                    <input name="name" id="name" required type="text" class="form-control" placeholder="Your Name" value="<?= isset($fields['name'])?$fields['name']:'';?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="email"><span class="glyphicon glyphicon-envelope"></span> Email</label>
                                </div>
                                <div class="col-md-9">
                                    <input name="email" id="email" required type="email" class="form-control" placeholder="your-email@website.com" value="<?= isset($fields['email'])?$fields['email']:'';?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="phone" class="text-nowrap"><span class="glyphicon glyphicon-phone"></span> Phone</label>
                                </div>
                                <div class="col-md-9">
                                    <input name="phone" id="phone" required type="tel" class="form-control" placeholder="08012345678" value="<?= isset($fields['phone'])?$fields['phone']:'';?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="message"><span class="glyphicon glyphicon-pencil"></span> Message</label>
                                </div>
                                <div class="col-md-9">
                                    <textarea name="message" id="message" required class="form-control" placeholder="Your message ..." style="height: 13em;"><?= isset($fields['message'])?$fields['message']:'';?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="text-right">
                                <button name="send" id="send" type="submit" class="btn btn-lg btn-primary">
                                    <span class="glyphicon glyphicon-send"></span> Submit
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php include_once("footer.php"); ?>