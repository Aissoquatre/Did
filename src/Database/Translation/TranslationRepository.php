<?php

namespace Did\Database\Translation;

use Did\Database\SmartConnector;

/**
 * Class TranslationRepository
 *
 * @package Did\Database\Translation
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class TranslationRepository extends SmartConnector
{
    const ENTITY = Translation::class;
    const TABLE  = 'translations';

    /**
     * @static
     * @return array
     */
    public static function getAll(): array
    {
        $translations = [];

        foreach (self::model()->findAll([], ['index' => 'tKey']) as $tKey => $translation) {
            /** @var Translation $translation */
            $translations[$tKey] = [
                'tKey' => $tKey,
                'fr'   => $translation->getFr(),
                'en'   => $translation->getEn(),
                'es'   => $translation->getEs(),
            ];
        }

        return $translations;
    }

    /**
     * @param string $key
     * @param null|string $lang
     * @return mixed
     */
    public static function findByKey(string $key, ?string $lang = null)
    {
        $model = self::model()->find([
            'tKey' => $key
        ]);

        if ($model && $lang) {
            $model = $model->{'get' . ucfirst($lang)}();
        }

        return $model;
    }
}