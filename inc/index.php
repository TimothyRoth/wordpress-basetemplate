<?php

/**** Custom Post Types ****/
require_once 'post-types/Example.php';
$example_post_type = new post_types\Example();
/**** End Custom Post Types ****/

/**** MetaBoxes ****/
require_once 'meta-boxes/Metabox.php';
require_once 'meta-boxes/Example.php';
require_once 'meta-boxes/Frontpage.php';
$example_meta = new meta_boxes\Example();
$frontpage_meta = new meta_boxes\Frontpage();
/**** End MetaBoxes ****/

/**** Customizer ****/
require_once 'customizer/CompanyDetails.php';
require_once 'customizer/SocialMedia.php';
require_once 'customizer/SiteIdentity.php';
$social_media = new customizer\SocialMedia();
$company_details = new customizer\CompanyDetails();
$site_identity = new customizer\SiteIdentity();
/**** End Customizer ****/

/**** Cronjobs ****/
require_once 'cronjobs/TestObserver.php';
$prospect_observer = new cronjobs\TestObserver();
/**** End Cronjobs****/

/**** AJAX****/
require_once 'ajax/AJAX.php';
require_once 'ajax/ExampleRequest.php';
$example_request = new ajax\ExampleRequest();
/**** End AJAX****/

/**** Theme Functions ****/
require_once 'functions/ThemeFunctions.php';
$theme_functions = new functions\ThemeFunctions();
/**** End Theme Functions ****/
