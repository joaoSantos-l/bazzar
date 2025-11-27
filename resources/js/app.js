import './bootstrap';
import Alpine from 'alpinejs';

import './components/slider';
import notif from './components/notif';
import editModal from './components/edit-modal';
import deleteConfirm from './components/delete-confirm';
import passwordToggle from './components/password-toggle';
import cartComponent from "./components/cart";
import searchComponent from './components/search';

window.Alpine = Alpine;

Alpine.data('notif', notif);
Alpine.data('editModal', editModal);
Alpine.data('deleteConfirm', deleteConfirm);
Alpine.data('passwordToggle', passwordToggle);
Alpine.data("cartComponent", cartComponent);
Alpine.data('searchComponent', searchComponent);


Alpine.start();
