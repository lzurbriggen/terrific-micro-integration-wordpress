Wordpress Terrific-Micro integration
====================================

Description
------
Roger Dudler integrated the terrific-concept into wordpress a while ago: https://github.com/rogerdudler/terrific-integration-wordpress
Because his integration is based on a quite old version and I prefer the slim terrific-micro (from Roger as well) over the original one, I decided to integrate it myself.

The result is a very basic wordpress theme built by using terrific components.
The integration is very loose, it doesn't force you to use any terrific-functionality.

Terrific-Micro:
https://github.com/rogerdudler/terrific-micro

Differences to Terrific-Micro
------
- Removed Views as well as partials because wordpress replaces this functionality
- Added caching to app.css & app.js, because it will be used productive and not just for frontend development

Apache Requirements
------
- .htaccess files have to be allowed (using "AllowOverride All" in your httpd.conf or vhosts configuration)
- mod_rewrite, mod_filter, mod_deflate needs to be enabled in your apache configuration
- "Options FollowSymLinks" has to be enabled

Cache
------
The theme caches the terrific-generated css- and javascript-files in the cache folder directly in the theme.
Make sure this folder is accessible to read/write.

##### Enable/disable cache
You can disable caching by setting the DEV-variable in the index.php in the terrific folder to true.
The $nocache variable you may stumble across is used by terrific-micro to cache less/scss results.

##### Flush cache
As an administrator, you can flush the cache by clicking the button in the administration bar when you're logged in.
