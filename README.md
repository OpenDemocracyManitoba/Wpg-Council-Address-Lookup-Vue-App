# Winnipeg Ward and School Division Wordpress Plugin

This tool is a simple auto-complete based address lookup tool that can be used as wordpress plugin. It allows a user to enter their Winnipeg based address, and it will return the Ward and School Division Ward using the Addresses dataset on the Open Data portal <https://data.winnipeg.ca/City-Planning/Addresses/cam2-ii3u>.

To include the plugin in Wordpress, simply download the code, activate it Wordpress through the plugin menu, and then add this shortcode to your wordpress post:

`[address-lookup-widget]`

You can also invoke it directly in a template using the following:

`<?php echo do_shortcode("[address-lookup-widget]"); ?>`

If you plan on building a new version of the plugin be sure to have npm installed and use it to install the package dependencies:

`npm install`

The tool is built using Vue, and needs to be 'built'. During the development you can run:

`npm run serve`

To have a freestanding version of the application.  To build the code for production:

`npm run build`

This code is changed slightly from regular Vue projects as the code is compiled as a library and put into the js folder. This also includes some css for the auto-complete - but I'm not changing the name. It is bundled with the Vue library so it's not necessary to include on the page. If using more than one Vue library, I would suggest removing the --inline-vue option in the 'build' command in package.json.
