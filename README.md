## Delete Unused Images ##

Contributors: Faheem Seedat

Tags: images, media, cleanup, WordPress, WooCommerce

Requires at least: 5.0

Tested up to: 6.3

Stable tag: 1.0


A plugin to delete unused  WooCommerce product images from the WordPress database and `wp-content/uploads` directory. You can trigger the cleanup process via a URL and limit how many images to delete per request.

### Description ###

The **Delete Unused Images** plugin helps you clean up unused  WooCommerce product media files from your WordPress installation. It identifies images in the media library that are not associated with any WooCommerce products and deletes them both from the database and the server's `wp-content/uploads` directory.

You can trigger the image deletion process by visiting a specific URL. Additionally, you can limit how many images are deleted in a single request by passing a `limit` parameter in the URL.

### Installation ###

1. Upload the `delete-unused-images` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Flush your rewrite rules by going to **Settings** > **Permalinks** and clicking **Save Changes**.

### Usage ###

To delete unused images, visit the following URL in your browser:

YOUR_WEBSITE/delete-unused-images/


### Optional Parameters

- **limit**: You can limit the number of images deleted in a single request by adding the `limit` parameter to the URL. For example, to delete 10 images at a time:

/delete-unused-images/?limit=10


If the `limit` parameter is not specified, the plugin will attempt to delete all unused images in one request.

### Security Notice ###

This plugin triggers the deletion of media files via a publicly accessible URL. It is recommended to secure the URL by requiring an admin login or adding a secret key parameter to the URL if the site is publicly accessible.


