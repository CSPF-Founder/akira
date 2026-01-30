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

namespace Tirreno\Assets;

abstract class Rule {
    protected $rb;
    protected $context;
    protected $params;
    protected $condition;

    public $uid;

    public function __construct(?\Ruler\RuleBuilder $rb = null, array $params = []) {
        $this->uid = end(explode('\\', get_class($this)));
        $this->rb = $rb ? $rb : (new \Ruler\RuleBuilder());
        $this->params = $params;
    }

    abstract protected function defineCondition();

    protected function prepareParams(array $params): array {
        return $params;
    }

    public function execute(): bool {
        $this->context = $this->buildContext();
        $this->condition = $this->defineCondition();
        return $this->rb->create($this->condition)->evaluate($this->context);
    }

    private function buildContext(): \Ruler\Context {
        return new \Ruler\Context($this->prepareParams($this->params));
    }

    public function updateParams(array $params): void {
        $this->params = $params;
    }
}
