import {handleAjaxError} from './utils/ErrorHandler.js?v=2';

export class ApplicationSwitcher {
    constructor() {
        this.switcher = document.getElementById('application-switcher');
        this.createBtn = document.getElementById('create-app-btn');
        this.nameInput = document.getElementById('new-app-name');
        this.renameBtn = document.getElementById('rename-app-btn');
        this.currentNameInput = document.getElementById('current-app-name');

        if (this.switcher) {
            this.switcher.addEventListener('change', this.onSwitch.bind(this));
        }

        if (this.createBtn) {
            this.createBtn.addEventListener('click', this.onCreate.bind(this));
        }

        if (this.nameInput) {
            this.nameInput.addEventListener('keypress', this.onCreateKeyPress.bind(this));
        }

        if (this.renameBtn) {
            this.renameBtn.addEventListener('click', this.onRename.bind(this));
        }

        if (this.currentNameInput) {
            this.currentNameInput.addEventListener('keypress', this.onRenameKeyPress.bind(this));
        }
    }

    getToken() {
        return document.head.querySelector('[name="csrf-token"][content]').content;
    }

    onSwitch() {
        const apiKeyId = this.switcher.value;
        $.ajax({
            type: 'POST',
            url: `${window.app_base}/admin/switchApplication`,
            data: {token: this.getToken(), apiKeyId: apiKeyId},
            success: () => window.location.reload(),
            error: handleAjaxError,
        });
    }

    onCreate() {
        const name = this.nameInput.value.trim();
        if (!name) return;

        this.createBtn.disabled = true;
        $.ajax({
            type: 'POST',
            url: `${window.app_base}/admin/createApplication`,
            data: {token: this.getToken(), name: name},
            success: () => window.location.reload(),
            error: (xhr, status, error) => {
                this.createBtn.disabled = false;
                handleAjaxError(xhr, status, error);
            },
        });
    }

    onCreateKeyPress(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            this.onCreate();
        }
    }

    onRename() {
        const name = this.currentNameInput.value.trim();
        if (!name) return;

        this.renameBtn.disabled = true;
        $.ajax({
            type: 'POST',
            url: `${window.app_base}/admin/renameApplication`,
            data: {token: this.getToken(), name: name},
            success: () => window.location.reload(),
            error: (xhr, status, error) => {
                this.renameBtn.disabled = false;
                handleAjaxError(xhr, status, error);
            },
        });
    }

    onRenameKeyPress(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            this.onRename();
        }
    }
}
