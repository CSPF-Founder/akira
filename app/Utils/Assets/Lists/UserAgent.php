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

class UserAgent extends Base {
    protected static string $extensionFile = 'user-agent.php';

    protected static array $list = [
        '--',
        '/*',
        '*/',
        'pg_',
        '\');',     // should be %'%)%;% ?
        'alter ',
        'select',
        'waitfor',
        'delay',
        'delete',
        'drop',
        'dbcc',
        'schema',
        'exists',
        'cmdshell',
        '%2A',      // *
        '%27',      // '
        '%22',      // "
        '%2D',      // -
        '%2F',      // /
        '%5C',      // \
        '%3B',      // ;
        '%23',      // #
        '%2B',      // +
        '%3D',      // =
        '%28',      // (
        '%29',      // )
        '/bin',
        '%2Fbin',
        '.sh',
        '|sh',
        '.exe',
    ];
}
