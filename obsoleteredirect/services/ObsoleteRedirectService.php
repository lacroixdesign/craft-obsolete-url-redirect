<?php
namespace Craft;

class ObsoleteRedirectService extends BaseApplicationComponent
{

    /**
     * Given a path, look for an obsolete URL from the revisions
     *
     * @return EntryModel or null
     */
    public function locateEntry($path)
    {
        $slug   = array_pop($path);
        $prefix = join("/", $path);

        // Check that there's even a slug to work with

        if ($slug === '') {
            return false;
        }

        // Element conditions

        $element_conditions = array('and',
            'elements_i18n.enabled = 1',
            'elements.enabled = 1',
            'elements.archived = 0'
        );

        // Slug conditions

        $slug_conditions = array('like',
            'entryversions.data',
            '%"slug":"' . $slug . '"%'
        );

        // Query for (or against) a path prefix

        if (empty($prefix)) {
            // Ensure the prefixed segments do NOT exist in the URI
            $path_conditions = array('not like', 'elements_i18n.uri', '%/%');
        } else {
            // Ensure the prefixed segments DO exist in the URI
            $path_conditions = array('like', 'elements_i18n.uri', $prefix . '/%');
        }

        // Query for matching revisions

        $query = craft()->db->createCommand()
            ->select('elements.id')
            ->from('elements elements')
            ->join('elements_i18n elements_i18n',
                    'elements_i18n.elementId = elements.id')
            ->join('entryversions entryversions',
                    'entryversions.entryId = elements.id')
            ->where($element_conditions)
            ->andWhere($slug_conditions)
            ->andWhere($path_conditions)
            ->order('entryversions.dateUpdated DESC')
            ->limit(1);

        // ObsoleteRedirectPlugin::log($query->text);
        $result = $query->queryRow();

        if ($result) {
            // Get the element's EntryModel
            $criteria = craft()->elements->getCriteria(ElementType::Entry);
            $criteria->id = $result['id'];

            // Return the actual element
            return $criteria->first();
        }
    }

}
