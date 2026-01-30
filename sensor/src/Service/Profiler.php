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

namespace Sensor\Service;

class Profiler {
    /** @var array<string, array{start: float, time?: float}> */
    private array $actions = [];

    public function start(string $action): void {
        $this->actions[$action] = ['start' => microtime(true)];
    }

    public function finish(string $action): void {
        if (!isset($this->actions[$action]['start'])) {
            return;
        }

        $time = microtime(true) - $this->actions[$action]['start'];
        $this->actions[$action]['time'] = round($time, 3);
    }

    /**
     * @return array<string, float|null>
     */
    public function getData(): array {
        $result = [];
        foreach ($this->actions as $action => $value) {
            $result[$action] = $value['time'] ?? null;
        }

        return $result;
    }
}
