=== Plugin Name ===
Contributors: ESPR!T
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=MXBVDRBUUZU76&lc=NZ&item_name=ESPR%21T%20Picasa&item_number=wp%2desprit%2dpicasa&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted
Tags: image, picasa, gallery, lightbox, photo
Requires at least: 2.5
Tested up to: 3.3.1
Stable tag: 0.0.6

ESPR!T Picasa is a Wordpress plugin that lets you add photos from picasa albums to your post and pages.

== Description ==

You can use ESPR!T Picasa to add photos from google Picasa albums to your post and pages. Just click on ESPR!T Picasa photo tab icon when editing post or page, select the album and then with one click just insert the photo into your post. The photos are still being hold on Google Picasa album, the plugin just insert pure html link into the post. You can also take advantage of Lightbox effects, but you do need to install separate plugin for lightbox.

== Installation ==

To do a new installation of the plugin, please follow these steps:

1. Unzip the content of the zip file into you wordpress plugin folder.
1. Activate the plugin in Wordpress administration.
1. Optionally install some Lightbox plugin for Wordpress to get nice effects when viewing images (ie. Slimbox plugin)

== How To Use It ==

1. After the installation, go to Wordpress Settings -> ESPR!T Picasa and set:
* the username of your Google Picasa album.
* size of the thumbnails which will be included in your posts or pages
* size of the large version of images which will be displayed after clicking on thumbnail 
1. While editing the post or page, click on Picasa icon on top of the editor window (in the same place ase are the other default media icons located). New window with list of albums will be opened, click on the album for list of its images and after clicking on image it will be inserted in your post or page.
(It is recommended to save the page/post you are editing first, as it will get an post id assigned - the ESPR!T Picasa uses such id as a reference for generating Lightbox code)

== Screenshots ==

1. Option page in Wordpress Administration
2. Please see new Picasa icon in Upload/Insert bar above the editor window
3. List of users albums
4. List of images in one of albums
5. Inserted image in post
6. Lightboxed version of image after click on it 

== Changelog ==

= 0.0.5 =
* Added support for perex image

= 0.0.6 =
* fixed support for Wordpress 3.3.1 

== Frequently Asked Questions ==

For support please visit http://trac.espr.it/wiki/Wordpress/Picasa
 
== Credits ==

Thanks go out to:

* [Bogdan Necula](http://bogde.ro/) for his *Picasa LightBox 2 plugin* which I have used as an inspiration and completely rewrote it for newer versions of Wordpress
* [Cameron Hinkle](http://www.cameronhinkle.com/) for his *Lightweight PHP Picasa API*, which I have used after realizing that the *Zend GData libraries* are piece of crap
* [Wordpress team](http://www.wordpress.org) for the good job
* All who release their work to public use!
