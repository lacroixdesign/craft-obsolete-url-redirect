<?php
namespace Craft;

class ObsoleteRedirectPlugin extends BasePlugin
{

    function getName()
    {
        return Craft::t('Obsolete URL Redirect');
    }

    function getVersion()
    {
        return '0.1.0';
    }

    function getDeveloper()
    {
        return 'Michael LaCroix';
    }

    function getDeveloperUrl()
    {
        return 'http://www.lacroixdesign.net';
    }

    function hasCpSection()
    {
        return false;
    }

}
