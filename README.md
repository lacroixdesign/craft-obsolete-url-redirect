# Obsolete URL Redirect

A plugin for [Craft](http://buildwithcraft.com/) to automatically redirect to an entry’s new URL if (1) its slug has been revised and (2) a visitor landed on the old URL. For example, if an entry started with the URL:

```
http://example.com/first
```

...but its slug was later changed to make it:

```
http://example.com/second
```

...then visiting `/first` will redirect the visitor to `/second`. On a request that is about to return a 404, the plugin will:

- Query for the most recent revision with the same path prefix and that now defunct slug.
- Fetch the current, live revision of that entry.
- Redirect (302) to that entry’s new URL.

One thing to note is that the query is intentionally isolated to the same prefix. In the above example, it would not redirect to an entry in a section that has a different URL prefix, such as `/blog/`.

### Installation

Download the plugin from [https://github.com/lacroixdesign/craft-obsolete-url-redirect](https://github.com/lacroixdesign/craft-obsolete-url-redirect), unzip, then move the `obsoleteredirect` folder to your Craft plugins folder. Install it via the Craft Control Panel as you would for any plugin. Finally, add the following snippet to your 404 template file:

```twig
{% do craft.obsoleteRedirect.check() %}
```

That's it!

### Caveats

Obviously you will need either Craft Client or Pro, as the Personal edition does not have revision functionality. Additionally, this plugin does not track URL changes at a structural level; e.g. changing your blog section’s prefix from `/blog/` to `/news/`.

This plugin has not been tested on localized websites, so any testing and feedback in that realm would be greatly appreciated.
