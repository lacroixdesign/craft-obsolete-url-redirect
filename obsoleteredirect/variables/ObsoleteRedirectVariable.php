<?php
namespace Craft;

class ObsoleteRedirectVariable
{

    /**
     * Redirect to an obsolete URL, if one exists
     */
    public function check()
    {
        if (craft()->request->isSiteRequest()) {
            $path = craft()->request->getSegments();
            $entry = craft()->obsoleteRedirect->locateEntry($path);

            if ($entry) {
                craft()->request->redirect($entry->url);
            }
        }
    }

}
