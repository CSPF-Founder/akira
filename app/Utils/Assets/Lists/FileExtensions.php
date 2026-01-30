<?php

/**
 * Akira ~ open-source security framework
 * Based on Tirreno (https://github.com/TirrenoTechnologies/tirreno)
 * Copyright (c) Tirreno Technologies Sàrl (https://www.tirreno.com)
 * Modified by Cyber Security and Privacy Foundation (https://cysecurity.org)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Tirreno Technologies Sàrl, Cyber Security and Privacy Foundation
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://cysecurity.org Akira
 */

declare(strict_types=1);

namespace Tirreno\Utils\Assets\Lists;

class FileExtensions extends Base {
    protected static string $extensionFile = 'file-extensions.php';
    protected static array $list = [];

    public static function getList(): array {
        return static::getExtension() ?? [];
    }

    public static function getKeys(): array {
        return array_keys(static::getList());
    }

    public static function getValues(string $key): array {
        return static::getList()[$key] ?? [];
    }
}
