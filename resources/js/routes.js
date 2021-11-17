import Owners from './components/Owners.vue';
import Addresses from './components/Addresses.vue';
import Cars from './components/Cars.vue';

import AppViewEdit from './components/AppViewEdit.vue';

// Ref: https://router.vuejs.org/guide/essentials/dynamic-matching.html

export const routes = [
    {
        name: 'owners',
        path: '/owners',
        component: Owners
    },
    {
        name: 'addresses',
        path: '/addresses',
        component: Addresses
    },
    {
        name: 'cars',
        path: '/cars',
        component: Cars
    },
    {
        name: 'appviewedit',
        path: '/:model/:action/:id',
        component: AppViewEdit
    }
];
