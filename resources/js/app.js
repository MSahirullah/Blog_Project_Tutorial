import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Choices from 'choices.js';

Window.choices = (element) => {
    return new Choices(element, {
        maxItemCount: 4, removeItemButton: true,
    });
}

