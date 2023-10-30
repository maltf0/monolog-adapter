<?php
/**
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Bex\Monolog;

use Bitrix\Main\Config\Configuration;
use Cascade\Cascade;

/**
 * Adapter Monolog to Bitrix CMS.
 *
 * @author Nik Samokhvalov <nik@samokhvalov.info>
 */
class MonologAdapter
{
    protected static bool $isConfigurationLoaded = false;

    /**
     * Load a configuration for the loggers from `.settings.php` or `.settings_extra.php`.
     *
     * @param bool $force Load even if the configuration has already been loaded.
     *
     * @return bool
     */
    public static function loadConfiguration(bool $force = false): bool
    {
        if ($force === false && static::$isConfigurationLoaded)
        {
            return true;
        }

        if (class_exists(Configuration::class))
        {
            $config = Configuration::getInstance()->get('monolog');

            if (is_array($config) && !empty($config))
            {
                Cascade::fileConfig($config);

                return true;
            }
        }

        return false;
    }
}
