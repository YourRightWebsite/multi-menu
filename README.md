# Multi Menu Plugin for WordPress
This plugin allows you to easily enable three new types of menu for your WordPress website: Mega Menu, Fullscreen Menu and Slideout Menu.

*Plugin Version v1.0.3*

## Plugin Installation

Download the .zip file for this plugin.  Inside of WordPress, click on *Plugins > Add Plugin* and then click on the *Upload Plugin* option.  Upload the zip file for this plugin, then activate it.

## Creating a Menu

Menus are managed under the *Appearance > Menus* section of your theme.  You must be using a theme that uses a traditional navigation element and not a full site editing theme.

Once you have created a menu and added some pages you can enable the multi menu functionality.  On the left hand side of the menu interface, above where you add pages you should see an option named *Multi Menu Settings*.  If you don't see this option, click on *Screen Options* on the upper right of your screen.  You will need to enable the *Multi Menu Settings* option from the *Screen Elements* section.  For best results, you should also enable the *Description* option from the *Show advanced menu properties* section as well.

### Selecting A Menu Style

On the left hand side under the *Multi Menu Settings* section, you can select which type of menu to use:

#### Disabled

The multi menu will be disabled for this menu.

#### Fullscreen Menu

A menu toggle will appear that when clicked opens a fullscreen menu containing multiple columns.  Each menu item can contain a description and child menu elements.

#### Slideout Menu

A menu toggle will appear that when clicked opens a slideout menu.  Top level menu items will appear by default but can be clicked to open a sub-menu showing child elements.

#### Mega Menu

A traditional navigation bar will appear but when elements in the menu are clicked or hovered a mega menu element will appear.  Each menu item can have a featured image and description.  Featured images are pulled from the featured image set on each page or post you add to the menu.

### Loading Menu Styles

The *Menu CSS Styles to Load* toggle determines which CSS styles will be loaded for your menu.  You can choose not to load any menu styles, core styles only or core styles plus a color scheme (light or dark).  Core styles are used for structure of the menu but do not set a color scheme.

If you are a developer you can choose the *none* or *core styles only* options to easily override the menu styling with your own custom CSS.  If you are not a developer, it is recommended you choose either the *Core + Light* or *Core + Dark* option depending on whether your theme is using a light or dark color scheme.

### Additional Options

#### Invert Menu Toggle Color

This enables you to change the color of the *Menu* toggle that appears to be the opposite of the menu's color scheme.  This is useful for instance if you have a dark navigation bar but want the inner menu items to appear on a light / white background.

#### Show Menu and Close Labels

If you enable this option labels for *Menu* and *Close* will be shown next to the *hamburger* and *x* icons of the menu.  This can be useful if your site caters to a less tech savvy audience that may not know what the menu symbols mean.

#### Preserve Menu ID and Class

By default Multi Menu strips out the class and ID of the menu item it replaces.  Checking this option stops this behavior.  This usually should be unchecked but might be needed if your menu's styles look broken based on your theme.

#### Load Theme Specific CSS

This option loads specific CSS fixes for popular WordPress themes.  It is recommended you always enable this option as it will make your menu look much better if you're using a common WordPress theme that we have created style overrides for.

#### Additional CSS classes for menu

If you want to add additional CSS classes to the menu wrapper you can add them here.  Add classes separated by a space between each class name.  Class names *should not* contain a period / dot before the class name.

### Saving Your Settings

Once you have made your selections, click the blue *Save Settings* button at the bottom of the form.  If you do not see your changes reflected on your website be sure to clear any cache you may have on your website, such as *LiteSpeed Cache*, etc.

## Getting Additional Help With This Plugin

For additional help with this plugin visit [the plugin documentation](https://yourrightwebsite.com/multi-menu-documentation/?source=multi-menu-github).  You can also [contact us](https://yourrightwebsite.com/contact/?source=multi-menu-github) to report a bug or to arrange paid plugin support.

## About This Plugin

This plugin was created by [Your Right Website](https://yourrightwebsite.com/?source=multi-menu-github) and is released for free under the MIT Licence.  More information about this plugin can be found [here](https://yourrightwebsite.com/multi-menu/?source=multi-menu-github).

## About Your Right Website

Your Right Website offers [custom WordPress web design](https://yourrightwebsite.com/website-design-and-development/?source=multi-menu-github), [custom WordPress plugin development](https://yourrightwebsite.com/custom-wordpress-plugin-development/?source=multi-menu-github) and [managed web hosting for WordPress](https://yourrightwebsite.com/managed-web-hosting-for-wordpress/?source=multi-menu-github).  We would love to work with you on your next web design project.  [Contact us](https://yourrightwebsite.com/contact/?source=multi-menu-github) for a free, no obligation consultation.