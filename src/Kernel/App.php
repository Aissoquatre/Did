<?php

namespace Did\Kernel;

use Did\Database\Translation\Translation;

/**
 * Class App
 *
 * @package Did\Kernel
 * @author (c) Julien Bernard <hello@julien-bernard.com>
 */
class App
{
    /**
     * Method that load in session everything needed for the application base.
     *
     * @param Environment $environmentVars
     */
    public static function preLoadApp(Environment $environmentVars)
    {
        $currentPreventCache = Environment::get()->findVar('PREVENT_CACHE');

        if (empty($_SESSION['prevent_cache'])) {
            $_SESSION['prevent_cache'] = $currentPreventCache;
        }

        $baseUrl = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http') .
            '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . '/';

        if (
            !isset($_SESSION['baseUrl']) ||
            empty($_SESSION['baseUrl']) ||
            (!empty($_SESSION['baseUrl']) && $_SESSION['baseUrl'] !== $baseUrl)
        ) {
            $_SESSION['baseUrl'] = $baseUrl;
        }

        $lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])
            ? (strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'fr') !== false
                ? 'fr'
                : (strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'en') !== false
                    ? 'en'
                    : (strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], 'es') !== false
                        ? 'es'
                        : 'en'
                    )
                )
            )
            : 'fr';

        if (empty($_SESSION['pref_lang'])) {
            $_SESSION['pref_lang'] = $lang;
        }

        $forceLangRefresh = false;

        if (
            empty($_SESSION['lang']['full']) ||
            $_SESSION['prevent_cache'] !== $currentPreventCache
        ) {
            $_SESSION['lang']['full']  = Translation::getAll();
            $_SESSION['prevent_cache'] = $currentPreventCache;

            $forceLangRefresh = true;
        }

        if (
            $forceLangRefresh ||
            empty($_SESSION['lang']['table']) ||
            $_SESSION['lang']['name'] !== $_SESSION['pref_lang']
        ) {
            $_SESSION['lang']['name']  = $_SESSION['pref_lang'];
            $_SESSION['lang']['table'] = array_column($_SESSION['lang']['full'], $_SESSION['pref_lang'], 'tKey');

            Environment::get()->setVars(
                array_merge($environmentVars->vars(), [
                    'LANG' => $_SESSION['lang']['table']
                ])
            );
        }
    }
}