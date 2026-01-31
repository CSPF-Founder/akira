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

namespace Tests\Support;

/**
 * FakeFilesystem provides a controlled temporary filesystem
 * for unit tests that need file-based input.
 *
 * Responsibilities:
 * - create isolated temp directory
 * - create files with content
 * - cleanup after test
 *
 * This helper intentionally avoids mocks and replaces
 * filesystem access with a deterministic sandbox.
 */
final class FakeFilesystem {
    private string $root;

    public function __construct(string $prefix = 'fs_test') {
        $this->root = sys_get_temp_dir() . '/' . $prefix . '_' . uniqid();
        $this->mkdir($this->root);
    }

    public function getRoot(): string {
        return $this->root;
    }

    public function mkdir(string $path): void {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }

    public function put(string $relativePath, string $contents): string {
        $fullPath = $this->root . '/' . ltrim($relativePath, '/');

        $dir = dirname($fullPath);
        $this->mkdir($dir);

        file_put_contents($fullPath, $contents);

        return $fullPath;
    }

    public function exists(string $relativePath): bool {
        return file_exists($this->root . '/' . ltrim($relativePath, '/'));
    }

    public function cleanup(): void {
        $this->removeDir($this->root);
    }

    private function removeDir(string $dir): void {
        if (!is_dir($dir)) {
            return;
        }

        $items = scandir($dir);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $dir . '/' . $item;

            if (is_dir($path)) {
                $this->removeDir($path);
            } else {
                unlink($path);
            }
        }

        rmdir($dir);
    }
}
