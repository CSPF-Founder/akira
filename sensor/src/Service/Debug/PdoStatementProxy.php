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

namespace Sensor\Service\Debug;

use Sensor\Service\Logger;

class PdoStatementProxy {
    /** @var array<string,mixed> */
    private array $values;

    public function __construct(
        private \PDOStatement $statement,
        private Logger $logger,
    ) {
    }

    public function bindValue(
        string $param,
        mixed $value,
        int $type = \PDO::PARAM_STR,
    ): void {
        $this->statement->bindValue($param, $value, $type);
        $this->values[$param] = $value;
    }

    public function execute(): void {
        $this->logger->logQuery($this->statement->queryString, $this->values);
        $this->statement->execute();
    }

    public function __call(string $name, array $args): mixed {
        return $this->statement->$name(...$args);
    }
}
