<?php
declare(strict_types=1);
namespace Helhum\ConfigLoader\Reader;

/*
 * This file is part of the helhum configuration loader package.
 *
 * (c) Helmut Hummel <info@helhum.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Helhum\ConfigLoader\Config;

class ExcludedConfigReader implements ConfigReaderInterface
{
    /**
     * @var ConfigReaderInterface
     */
    private $reader;

    /**
     * @var array
     */
    private $configPaths;

    public function __construct(ConfigReaderInterface $reader, string ...$configPaths)
    {
        $this->reader = $reader;
        $this->configPaths = $configPaths;
    }

    public function hasConfig(): bool
    {
        return $this->reader->hasConfig();
    }

    public function readConfig(): array
    {
        $config = $this->reader->readConfig();
        foreach ($this->configPaths as $overridePath) {
            $config = Config::removeValue($config, $overridePath);
        }

        return $config;
    }
}
