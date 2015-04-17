<?php
namespace Testeleven\WholisticServices\Positioned;

$plugin = \Testeleven_Positioned_Plugin::get_instance();

$creator = 'Positioned_Post_Creator';

// Welcome posts
$welcome_to_nbs = new \Position('welcome-to-nbs', 'front-page.php');
$fifteen_second_intro = new \Position('fifteen-second-intro', 'front-page.php');
$fifteen_second_intro_image = new \Position('fifteen-second-intro-image', 'front-page.php');
$still_reading = new \Position('still-reading', 'front-page.php');
$what_we_offer = new \Position('what-we-offer', 'front-page.php');
$our_approach_to_yoga = new \Position('our-approach-to-yoga', 'front-page.php');
$our_approach_to_yoga_image = new \Position('our-approach-to-yoga-image', 'front-page.php');
$our_approach_to_energywork = new \Position('our-approach-to-energywork', 'front-page.php');
$our_approach_to_energywork_image = new \Position('our-approach-to-energywork-image', 'front-page.php');
$our_approach_to_esthetics = new \Position('our-approach-to-esthetics', 'front-page.php');
$our_approach_to_esthetics_image = new \Position('our-approach-to-esthetics-image', 'front-page.php');

//$why_we_are_so_good = new \Position('why-we-are-so-good', 'front-page.php');
//$because_of_who_we_are = new \Position('because-of-who-we-are', 'front-page.php');
//$because_of_our_qualifications = new \Position('because-of-our-qualifications', 'front-page.php');

$andrea = new \Position('andrea', 'front-page.php');
$who_we_are = new \Position('who-we-are', 'front-page.php');
$andrea_image = new \Position('andrea-image', 'front-page.php');


// Create the 'welcome' section of the site.
// Say hi!
$plugin->create_positioned_post($creator, 'positioned_title', $welcome_to_nbs);
// 'Cast the net' - a quick initial introduction
$plugin->create_positioned_post($creator, 'positioned_full', $fifteen_second_intro);
$plugin->create_positioned_post($creator, 'positioned_image', $fifteen_second_intro_image);

// The previous section has filtered the sites users - for those who are left...
$plugin->create_positioned_post($creator, 'positioned_title', $still_reading);

// Our work means different things to different people - let's give the reader
// a brief overview of our approach to the work. (This is further filtering of the
// users to make sure we are 'on the same page.')
$plugin->create_positioned_post($creator, 'positioned_title', $what_we_offer);
$plugin->create_positioned_post($creator, 'positioned_full', $our_approach_to_yoga);
$plugin->create_positioned_post($creator, 'positioned_image', $our_approach_to_yoga_image);
$plugin->create_positioned_post($creator, 'positioned_full', $our_approach_to_energywork);
$plugin->create_positioned_post($creator, 'positioned_image', $our_approach_to_energywork_image);
$plugin->create_positioned_post($creator, 'positioned_full', $our_approach_to_esthetics);
$plugin->create_positioned_post($creator, 'positioned_image', $our_approach_to_esthetics_image);

// Reassurance - what does the reader need to know?
$plugin->create_positioned_post($creator, 'positioned_title', $andrea);
$plugin->create_positioned_post($creator, 'positioned_full', $who_we_are);
$plugin->create_positioned_post($creator, 'positioned_image', $andrea_image);

// Footer posts
$footer_where = new \Position('footer-where', 'front-page.php');
$footer_who = new \Position('footer-who', 'front-page.php');
$footer_site_info = new \Position('footer-site-info', 'front-page.php');

$plugin->create_positioned_post($creator, 'positioned_full', $footer_who);
$plugin->create_positioned_post($creator, 'positioned_full', $footer_where);
$plugin->create_positioned_post($creator, 'positioned_full', $footer_site_info);

