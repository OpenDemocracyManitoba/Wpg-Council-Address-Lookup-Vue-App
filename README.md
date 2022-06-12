# Winnipeg Ward and School Division Wordpress Plugin

This tool is a simple auto-complete based address lookup tool that can be used as wordpress plugin. It allows a user to enter their Winnipeg based address, and it will return the Ward and School Division Ward using the Addresses dataset on the Open Data portal <https://data.winnipeg.ca/City-Planning/Addresses/cam2-ii3u>.

To include the plugin in Wordpress, simply download the code, activate it Wordpress through the plugin menu, and then add this shortcode to your wordpress post:

`[address-lookup-widget]`

You can also invoke it directly in a template using the following:

`<?php echo do_shortcode("[address-lookup-widget]"); ?>`

The tool is built using Vue, and needs to be 'built'. During the development you can run:

`npm run serve`

To have a freestanding version of the application.  To build the code for production:

`npm run prod`

