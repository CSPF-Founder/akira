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

namespace Tirreno\Utils;

class ApiKeys {
    public static function getCurrentOperatorApiKeyId(): ?int {
        $key = self::getCurrentOperatorApiKeyObject();

        return $key ? $key->id : null;
    }

    public static function getCurrentOperatorApiKeyString(): ?string {
        $key = self::getCurrentOperatorApiKeyObject();

        return $key ? $key->key : null;
    }

    public static function getCurrentOperatorEnrichmentKeyString(): ?string {
        $key = self::getCurrentOperatorApiKeyObject();

        return $key ? $key->token : null;
    }

    public static function getOperatorApiKeys(int $operatorId): array {
        $model = new \Tirreno\Models\ApiKeys();
        $apiKeys = $model->getKeys($operatorId);

        $isOwner = true;
        if (!$apiKeys) {
            $coOwnerModel = new \Tirreno\Models\ApiKeyCoOwner();
            $coOwnerModel->getCoOwnership($operatorId);

            if ($coOwnerModel->loaded()) {
                $isOwner = false;
                $apiKeys[] = $model->getKeyById($coOwnerModel->api);
            }
        }

        return [$isOwner, $apiKeys];
    }

    public static function setActiveApiKey(int $apiKeyId): bool {
        $currentOperator = \Tirreno\Utils\Routes::getCurrentRequestOperator();
        if (!$currentOperator) {
            return false;
        }

        [$isOwner, $apiKeys] = self::getOperatorApiKeys($currentOperator->id);

        foreach ($apiKeys as $key) {
            if ((int) $key->id === $apiKeyId) {
                \Base::instance()->set('SESSION.active_api_key_id', $apiKeyId);
                return true;
            }
        }

        return false;
    }

    public static function getActiveApiKeyId(): ?int {
        $f3 = \Base::instance();
        $activeKeyId = $f3->get('SESSION.active_api_key_id');

        return $activeKeyId ? (int) $activeKeyId : null;
    }

    // returns \Tirreno\Models\ApiKeys; in test mode returns object
    public static function getCurrentOperatorApiKeyObject(): object|null {
        $currentOperator = \Tirreno\Utils\Routes::getCurrentRequestOperator();

        if (!$currentOperator) {
            return null;
        }

        $model = new \Tirreno\Models\ApiKeys();
        $f3 = \Base::instance();

        // Check for test API key configuration
        $testId = $f3->get('TEST_API_KEY_ID');
        if (isset($testId) && $testId !== '') {
            return (object) [
                'id' => $testId,
                'key' => $model->getKeyById($testId)->key,
                'skip_blacklist_sync' => true,
                'token' => $model->getKeyById($testId)->token,
            ];
        }

        $operatorId = $currentOperator->id;
        [$isOwner, $apiKeys] = self::getOperatorApiKeys($operatorId);

        if (!$apiKeys) {
            return null;
        }

        // Check for session-stored active key
        $activeKeyId = $f3->get('SESSION.active_api_key_id');
        if ($activeKeyId) {
            foreach ($apiKeys as $key) {
                if ((int) $key->id === (int) $activeKeyId) {
                    return $key;
                }
            }
        }

        // Fall back to first available key
        return $apiKeys[0] ?? null;
    }
}
